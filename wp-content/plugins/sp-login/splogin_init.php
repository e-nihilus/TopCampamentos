<?php

if ( ! class_exists('spuser_class')){
    class spuser_class{

        public function __construct(){
			add_action( 'wp_ajax_spuser', array($this, 'ajax'));
			add_action( 'wp_ajax_nopriv_spuser', array($this, 'ajax'));
			add_shortcode( 'spuser', array($this, 'shortcode'));
			add_action( 'admin_menu', array($this, 'menu_register'));
        }

        /* Menú */
        public function menu_register(){ 
            add_menu_page( __('Preregistro', 'spuser'), __('Preregistro', 'spuser'), 'manage_categories', 'spuser', '', 'dashicons-admin-users', 30 );
			add_submenu_page( 'spuser', __('Usuarios', 'spuser'), __('Usuarios', 'spuser'), 'manage_options', 'spuser', array($this, 'panel'), 0 );
        }

        /* Panel */
        public function panel(){
        	if(isset($_GET['desactivar'])){
        		global $wpdb;
				$spuser_data = $wpdb->prefix . "spuser_data";
				$id = sanitize_key($_GET['desactivar']);
				if($wpdb->update($spuser_data, array("code" => "1"), array("id" => $id)) !== false){
					$_SESSION['desactivar_user'] = 1;
					$user_id = $wpdb->get_var("SELECT data_user FROM $spuser_data WHERE id='$id'");
					$sessions = WP_Session_Tokens::get_instance($user_id);
					$sessions->destroy_all();
				}else{
					$_SESSION['desactivar_user'] = 0;
				}
        		echo "<script>location.href='".remove_query_arg('desactivar')."'</script>";
				exit;
        	}

        	if(isset($_GET['activar'])){
        		global $wpdb;
				$spuser_data = $wpdb->prefix . "spuser_data";
				$id = sanitize_key($_GET['activar']);
				if($wpdb->update($spuser_data, array("code" => ""), array("id" => $id)) !== false){
					$_SESSION['activar_user'] = 1;
				}else{
					$_SESSION['activar_user'] = 0;
				}
        		echo "<script>location.href='".remove_query_arg('activar')."'</script>";
				exit;
        	}

        	if(isset($_GET['aprobar'])){
        		global $wpdb;
				$spuser_data = $wpdb->prefix . "spuser_data";
				$id = sanitize_key($_GET['aprobar']);
        		$_data = $wpdb->get_row("SELECT * FROM $spuser_data WHERE id='$id'");
        		if($_data){
        			$user = get_user_by( "login", $_data->cif );
	    			$email = get_user_by( "email", $_data->correo );
					if($user){
						$_SESSION['aprobar_user'] = -1;
					}elseif($email){
						$_SESSION['aprobar_user'] = -2;
					}else {
						$nu_name = $_data->cif;
						$nu_pass = $_data->pass;
						$nu_mail = $_data->correo;
						$nu_role = 'gestor_campamento';
						$nu = wp_insert_user(array(
							'user_login' => $nu_name,
							'user_email' => $nu_mail,
							'user_pass' => $nu_pass,
							'role' => $nu_role,
						));
						if(is_wp_error( $nu )){
							$_SESSION['aprobar_user'] = -3;
							$_SESSION['aprobar_error'] = $r["m"] = $nu->get_error_message();
						}else{
							$to_display_name = array(
								'ID'			=>	$nu,
								'display_name'	=> $_data->nombre_comercial,
							);
							wp_update_user($to_display_name);
							$wpdb->update($spuser_data, ["data_user" => $nu], ["cif" => $_data->cif]);
							if(self::mail($_data->correo, __("Cuenta aprobada", 'spuser'), "activacion", array( "Nombre" => $_data->responsable, "url_recovery" => get_option( "siteurl" ). "/registro-campamentos/?recovery", "User" => $_data->cif))){
								$_SESSION['aprobar_user'] = 1;
							}else{
								$_SESSION['aprobar_user'] = 2;
							}
						}
					}
        		}else{
        			$_SESSION['aprobar_user'] = 0;
        		}

        		echo "<script>location.href='".remove_query_arg('aprobar')."'</script>";
				exit;
        	}

        	if(isset($_GET['delete'])){
				global $wpdb;
				$spuser_data = $wpdb->prefix . "spuser_data";
				if(!get_user_by('login', sanitize_text_field($_GET['delete']))){
					if($wpdb->delete($spuser_data, ["cif" => sanitize_text_field($_GET['delete'])]) !== false){
						$_SESSION['eliminar_user'] = 1;
					}else{
						$_SESSION['eliminar_user'] = 0;
					}
				}else{
					$_SESSION['eliminar_user'] = -1;
				}
				
				echo "<script>location.href='".remove_query_arg('delete')."'</script>";
				exit;
			}

			if(isset($_SESSION['desactivar_user'])){
				if($_SESSION['desactivar_user'] == 1){
					echo "<div class='notice notice-success is-dismissible'><p>Se desactivo el usuario</p></div>";
				}else{
					echo "<div class='notice notice-error is-dismissible'><p>No se pudo desactivar el usuario</p></div>";
				}
				unset($_SESSION['desactivar_user']);
			}

			if(isset($_SESSION['activar_user'])){
				if($_SESSION['activar_user'] == 1){
					echo "<div class='notice notice-success is-dismissible'><p>Se activo el usuario</p></div>";
				}else{
					echo "<div class='notice notice-error is-dismissible'><p>No se pudo activar el usuario</p></div>";
				}
				unset($_SESSION['activar_user']);
			}

			if(isset($_SESSION['eliminar_user'])){
				if($_SESSION['eliminar_user'] == 1){
					echo "<div class='notice notice-success is-dismissible'><p>Se elimino el usuario</p></div>";
				}elseif($_SESSION['eliminar_user'] == -1){
					echo "<div class='notice notice-error is-dismissible'><p>Debe eliminar el usuario de wordpress antes de continuar</p></div>";
				}else{
					echo "<div class='notice notice-error is-dismissible'><p>No se pudo eliminar el usuario</p></div>";
				}
				unset($_SESSION['eliminar_user']);
			}

			if(isset($_SESSION['aprobar_user'])){
				if($_SESSION['aprobar_user'] == 1){
					echo "<div class='notice notice-success is-dismissible'><p>Aprobación completada se envió correo al usuario para confirmación</p></div>";
				}elseif($_SESSION['aprobar_user'] == 2){
					echo "<div class='notice notice-warning is-dismissible'><p>Aprobación completada, no se pudo enviar correo al usuario para confirmación</p></div>";
				}elseif($_SESSION['aprobar_user'] == -1){
					echo "<div class='notice notice-error is-dismissible'><p>Este CIF ya se encuentra registrado</p></div>";
				}elseif($_SESSION['aprobar_user'] == -2){
					echo "<div class='notice notice-error is-dismissible'><p>Este correo ya se encuentra registrado</p></div>";
				}elseif($_SESSION['aprobar_user'] == -3){
					echo "<div class='notice notice-error is-dismissible'><p>$_SESSION[aprobar_error]</p></div>";
					unset($_SESSION['aprobar_error']);
				}elseif($_SESSION['aprobar_user'] == -4){
					echo "<div class='notice notice-error is-dismissible'><p>Error al intentar registrar en Netix intenet mas tarde</p></div>";
				}else{
					echo "<div class='notice notice-error is-dismissible'><p>Registro no encontrado intente de nuevo</p></div>";
				}
				unset($_SESSION['aprobar_user']);
			}

			require_once 'inc/vista_user.php';
			require_once 'inc/tabla_user.php';
            $lista = new lista_spuser();
            $lista->prepare_items();
            ?>
            	<style type="text/css">
                	.column-id {
                    	width: 50px;
                	}
                </style>
              	<div class="wrap">
                	<div id="icon-users" class="icon32"></div>
                  	<h1 class="wp-heading-inline">Usuarios</h1>
                  	<form action="" method="GET">
                    	<p class="search-box">
                      		<label class="screen-reader-text" for="search-box-id-search-input">Buscar:</label>
                      		<input type="text" id="search-box-id-search-input" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : ''; ?>">
                      		<input type="submit" id="search-submit" class="button" value="Buscar">
                    	</p>
                    	<input type="hidden" name="page" value="<?=esc_attr($_REQUEST['page']);?>"/>
                	</form>
                	<form id="expoty_bulk" method="post">
	                    <?php 
	                        $page  = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );
	                        $paged = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );
	                        printf( '<input type="hidden" name="page" value="%s" />', $page );
	                        printf( '<input type="hidden" name="paged" value="%d" />', $paged );
	                        $lista->display();
	                    ?>
                  	</form>
              	</div>
			<?php
        }

        /* Mail */
        public function mail($correo, $asunto, $template, $_data){
	    	$adjunto = array();
	    	if(isset($_data["__att"])){
	    		$adjunto = $_data["__att"];
	    		unset($_data["__att"]);
	    	}
	    	$_data = (object) $_data;
	    	$_base = file_get_contents(SPUSER_PATH . "/templates_email/base.html");
	    	include(SPUSER_PATH . "/templates_email/" . $template . ".php");
	    	$_head[] = 'Content-Type: text/html; charset=UTF-8';
	    	if(isset($_config) && is_array($_config) && isset($_config['Correo']) && isset($_config['Nombre'])){
	    		$_head[] = "From: ".$_config['Nombre']." <".$_config['Correo'].">";
	    	}
	    	if(isset($remplace) && is_array($remplace)){
	    		foreach ($remplace as $key => $value) {
		    		$_base = str_replace($key, $value, $_base);
		    	}
	    	}
	    	file_put_contents(SPUSER_PATH . "/test.html", $_base);
	    	return wp_mail( $correo, $asunto, $_base, $_head, $adjunto );
	    }

        /* ShortCode*/
        public function shortcode(){

        	if(!get_current_user_id()){
	        	wp_enqueue_script( 'google-rcap', "https://www.google.com/recaptcha/api.js?render=" . SPUSER_RC_KEY );
	        	wp_enqueue_style( 'spuser-style', SPUSER_URL . '/css/style.css', array(), filemtime(SPUSER_PATH . '/css/style.css'));
	        	wp_enqueue_script( 'spuser-script', SPUSER_URL . "/js/script.js", array( 'jquery'), filemtime(SPUSER_PATH . '/js/script.js'));
	        	$send = array(
			        'url'    => admin_url( 'admin-ajax.php' ),
			        'nonce'  => wp_create_nonce( '_spuser2021_' ),
			        'open'	 => 0,
			        'key'    => SPUSER_RC_KEY,
			        'login'  => isset($_GET['ingresar']) ? 1 : 0,
			    );
			    if(isset($_REQUEST['recovery'])) $send['open'] = 1;
			    if(isset($_REQUEST['login'])) $send['open'] = 2;
			    
	        	wp_localize_script( 'spuser-script', 'ajax', $send );

	        	ob_start(); ?>

					<div class="portal_campamento" id="portal_campamento">
						<div class="logotipo_TOP">
							<img src="<?= home_url() . '/wp-content/uploads/2023/05/TOPcampamentos-logotipo-combinado.png'; ?>" alt="">
						</div>
						<div class="login-register-tabs">
							<h4 tab="register">Registro</h4>
							<h4 tab="login">Ingresar</h4>
						</div>
						<div class="forms">
						<?php 
	        				include 'inc/login.php';
	        				include 'inc/registro.php';
	        				include 'inc/recordar.php';
	        				if(isset($_GET['spuser_recovery'])){
	        					include 'inc/recordar2.php';
	        				}
	        			?>
						</div>
					</div>


	        	<?php return ob_get_clean();
	        }else{
	        	wp_enqueue_style( 'spuser-style', SPUSER_URL . '/css/style.css', array(), filemtime(SPUSER_PATH . '/css/style.css'));
	        	wp_enqueue_script( 'spuser-script', SPUSER_URL . "/js/script2.js", array( 'jquery'), filemtime(SPUSER_PATH . '/js/script2.js'));
	        	wp_localize_script( 'spuser-script', 'ajax', array(
			        'url'    => admin_url( 'admin-ajax.php' ),
			        'nonce'  => wp_create_nonce( get_current_user_id() )
			    ) );
			    if ( user_can( get_current_user_id(), 'gestor_campamento' ) && get_the_ID() == 883 ) {
			    	$link = get_permalink(1061);
			    	return "<script> window.location.href = '$link' </script>";
			    }else{
			    	$link = home_url();
			    	return "<script> window.location.href = '$link' </script>";
			    }
	        	return "";
	        }
	    }

        /* Ajax */
        public function ajax(){
			require_once 'splogin_ajax.php';
		}

		/* Google verificar */
		private function recaptcha($token){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => SPUSER_RC_SCR, 'response' => $token)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$arrResponse = json_decode($response, true);
			if($arrResponse["success"] == '1' && $arrResponse["action"] == "spuser_valid" && $arrResponse["score"] >= 0.5) {
			    return true;
			} else {
			    return false;
			}
		}
  
    }
    $GLOBAL['spuser'] = new spuser_class();
}
