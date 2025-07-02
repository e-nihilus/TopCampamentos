<?php

class admin_panel_system {

	public function init(){
		add_filter( 'theme_page_templates', array($this, 'include_templates'));
		add_filter( 'page_template', array($this, 'templates' ));
		add_action( 'after_setup_theme', array($this,'barra_admin'));
		add_filter( 'nav_menu_item_title', array($this, 'icons_menu'), 10, 4 );
	}


	public function icons_menu( $title, $item, $args, $depth ) {
	    if ( !empty( $item->description ) ) {
	        $title = '<i class="material-icons icon-menu">'.$item->description.'</i> '.$title;
	    }
    	return $title;
	}

	public function info($key = false){
		$licence = get_option('adpnsy_lic');
		if($licence){
			$licence = substr($licence, 3);
			$licence = base64_decode($licence);
			$licence = json_decode($licence);
			$site = get_option('siteurl');
			if(crypt($site, 'AN') == $licence->key){
				///verificar ultima comprobación
				if(!isset($licence->key_last) || $licence->key_last < time() ){
					$nw = $ac = time() + 604800;
					$vl = self::comprobar($licence->key_id);
					if($vl)
						self::save($licence->key, $licence->key_id, $nw, $licence->opt, true);
					else
						self::save("", $licence->key_id, $nw, $licence->opt, true);
				}
				if($key){
					return $licence->key_id;
				}else{
					return $licence->opt;
				}
			}else{
				if(!$key) wp_die( __("No esta autorizado para ingresar a este enlace", "adpnsy") );
				return false;
			}
		}else{
			if($key) return false;
			exit;
		}
	}

/************************
*						*
*	Funciones Publicas	*
*						*
************************/

	public function Noticia($class, $mensaje){ ?>
		<div class="notice <?=$class;?> is-dismissible">
	        <p><?=$mensaje;?></p>
	    </div>
	<?php }

	public function admin(){
		
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			self::activar();
		}

		$key = self::info(true);
		if($key){
			self::admin_config_panel();
		}else{
			self::admin_activar_panel();
		}
	}

	public function templates( $template ) {
		if ( is_page_template( 'admin_dashboard.php' ) || is_page_template( 'admin_perfil.php' ) ) {
			if(is_user_logged_in()){
				global $adpnsy, $info;
				$adpnsy = $this;
				$info = self::info();
				$template = ADPNSY_PATH . '/admin_dashboard.php';
			}else{
				self::to_login();
			}
		}

		if ( is_page_template( 'admin_login.php' ) ) {
			if(is_user_logged_in()){
				self::to_dashboart();
			}else{
				global $adpnsy, $info, $mensaje;
				$adpnsy = $this;
				$info = self::info();
				$mensaje = self::conectar($info);
				$template = ADPNSY_PATH . '/admin_login.php';
			}
		}

		if ( is_page_template( 'admin_recovery.php' ) ) {
			if(is_user_logged_in()){
				self::to_dashboart();
			}else{
				global $adpnsy, $info, $mensaje;
				$adpnsy = $this;
				$info = self::info();
				$mensaje = self::recuperar($info);
				$template = ADPNSY_PATH . '/admin_recovery.php';
			}
		}

		if ( is_page_template( 'admin_register.php' ) ) {
			if(is_user_logged_in()){
				self::to_dashboart();
			}else{
				global $adpnsy, $info, $mensaje;
				$adpnsy = $this;
				$info = self::info();
				$mensaje = self::register($info);
				$template = ADPNSY_PATH . '/admin_register.php';
			}
		}

		if ( is_page_template( 'admin_logout.php' ) ) {
			self::logout();
		}

		return $template;
	}

	public function include_templates( $templates ) {
		$templates['admin_dashboard.php'] 	= 	__( 'SP Admin páginas', 'adpnsy' );
		$templates['admin_perfil.php'] 		= 	__( 'SP Admin perfil de usuario', 'adpnsy' );
	 	$templates['admin_login.php'] 		= 	__( 'SP Admin login', 'adpnsy' );
	 	$templates['admin_recovery.php'] 	= 	__( 'SP Admin recuperar contraseña', 'adpnsy' );
	 	$templates['admin_register.php'] 	= 	__( 'SP Admin registrar nuevo usuario', 'adpnsy' );
	 	$templates['admin_logout.php'] 		= 	__( 'SP Admin desconectar', 'adpnsy' );
		return $templates;
	}

    public function header($info, $login = true){
    	?>
    		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		    <meta name="description" content="<?=$info->description;?>">
		    <meta name="author" content="<?=$info->autor;?>">
		    <title><?=$info->titulo;?></title>
		    <link rel="apple-touch-icon" href="<?=$info->icon_apple;?>">
		    <link rel="shortcut icon" type="image/x-icon" href="<?=$info->favicon;?>">
		    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		    <link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/vendors/vendors.min.css">
		    <?php if($login){ ?>
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/css/themes/horizontal-menu-template/materialize.min.css">
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/css/themes/horizontal-menu-template/style.min.css">
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/css/layouts/style-horizontal.min.css">
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/css/login.min.css">
		    	
		    	<style type="text/css">
		    		.login-bg {
		    			background-image: url(<?=$info->bglogin_vn;?>);
		    		}
		    	</style>
		    <?php }else{ ?>
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/vendors/sweetalert/sweetalert.css">
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/vendors/dropify/css/dropify.min.css">
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/vendors/select2/select2.min.css">
		    	<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/vendors/select2/select2-materialize.css">
		    	<script src="<?=ADPNSY_URL;?>app-assets/vendors/sweetalert/sweetalert.min.js"></script>
		    <?php } ?>
		    <link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>css/style.css?<?=filemtime(ADPNSY_PATH . '/css/style.css');?>">
		<?php
    }

    public function footer($login = true){
    	?>
	    	<script src="<?=ADPNSY_URL;?>app-assets/js/vendors.min.js"></script>
	    	<?php if(!$login){ ?>
	    		<script src="<?=ADPNSY_URL;?>app-assets/vendors/chartjs/chart.min.js"></script>
	    		<script src="<?=ADPNSY_URL;?>app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
	    		<script src="<?=ADPNSY_URL;?>app-assets/vendors/data-tables/js/dataTables.material.min.js"></script>
	    		<script src="<?=ADPNSY_URL;?>app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
	    		<script src="<?=ADPNSY_URL;?>app-assets/vendors/data-tables/js/datatables.checkboxes.min.js"></script>		
	    		<script src="<?=ADPNSY_URL;?>app-assets/vendors/select2/select2.full.min.js"></script>		
	    	<?php } ?>
		    <script src="<?=ADPNSY_URL;?>app-assets/js/plugins.min.js"></script>
		    <script src="<?=ADPNSY_URL;?>app-assets/vendors/dropify/js/dropify.min.js"></script>
		    <script src="<?=ADPNSY_URL;?>js/script.js?<?=filemtime(ADPNSY_PATH . '/js/script.js');?>"></script>
		    <script type="text/javascript"> var AjaxUrl = "<?=admin_url( "admin-ajax.php" );?>";</script>
    	<?php
    }

    public function conectar($info){

    	if($_SERVER['REQUEST_METHOD'] === 'POST'){
	    	if($_REQUEST['login'] && $info){
				$creds = array(
			        'user_login'    => sanitize_text_field($_POST['user_login']),
			        'user_password' => sanitize_text_field($_POST['user_password']),
			        'remember'      => isset($_POST['remember'])
			    );
			    $user = wp_signon( $creds, is_ssl() );
			    if ( is_wp_error( $user ) ) {
			        return "Compruebe usuario o contraseña";
			    }else{
			    	$_act = get_usermeta( $user->ID, $meta_key = '__active' );
			    	if(!$_act){
			    		wp_logout();
			    		return __("Cuenta no activa, se envió un correo electrónico con un enlace de activación, si no lo recibió intente recuperar su contraseña. Revise SPAM", "adpnsy");
			    	}else{
			    		self::to_dashboart($info);
			    	}
			    }
			}
		}

		if($_SERVER['REQUEST_METHOD'] === 'GET'){
    		if(isset($_GET['key']) && $_GET['key'] != "" && isset($_GET['_s']) && $_GET['_s'] != "" && $info){
    			$us = urldecode(base64_decode(substr($_GET['_s'], 2)));
    			$ck = check_password_reset_key($_GET['key'], $us);
    			if(!is_wp_error( $ck )){
    				$user = get_user_by( "login", $us );
    				update_user_option( $user->ID, 'default_password_nag', false, true );
    				update_usermeta( $user->ID, '__active', true );
    				setcookie("_sp__m", base64_encode(__("Cuenta Activada", "adpnsy")), time()+1, "/");
    				self::to_login($info);
    			}else{
    				return __("Enlace invalido", "adpnsy");
    			}
    		}
    	}
    }

    public function to_login(){
    	$pgs = get_pages(array("meta_key" => "_wp_page_template", "meta_value" => "admin_login.php"));
    	if($pgs){
    		$pgs = array_shift($pgs);
    		wp_redirect(get_page_link($pgs->ID));
    	}else{
    		wp_redirect(get_option('siteurl'));
    	}
    }

    public function url_login(){
    	$pgs = get_pages(array("meta_key" => "_wp_page_template", "meta_value" => "admin_login.php"));
    	if($pgs){
    		$pgs = array_shift($pgs);
    		return get_page_link($pgs->ID);
    	}else{
    		return get_option('siteurl');
    	}
    }

    public function url_page($id){
    	if($id){
    		return get_page_link($id);
    	}else{
    		return get_option('siteurl');
    	}
    }
    
    public function to_dashboart($info = false){
    	if(!$info) $info = self::info(); 
    	if($info->login){
			wp_redirect(get_page_link($info->login));
		}else{
			$pgs = get_pages(array("meta_key" => "_wp_page_template", "meta_value" => "admin_dashboard.php"));
			if($pgs){
				$pgs = array_shift($pgs);
				wp_redirect(get_page_link($pgs->ID));
			}else{
				wp_redirect(get_option('siteurl'));
			}
		}
    }

    public function logout(){
    	wp_logout();
    	$pgs = get_pages(array("meta_key" => "_wp_page_template", "meta_value" => "admin_login.php"));
    	if($pgs){
    		$pgs = array_shift($pgs);
    		wp_redirect(get_page_link($pgs->ID));
    	}else{
    		wp_redirect(get_option('siteurl'));
    	}
    }

    public function avatar(){
    	$user = wp_get_current_user();
		if ( $user ) {
			return esc_url( get_avatar_url( $user->ID ) );
		}else{
			return "";
		}
    }

    public function contenido(){
    	$adpnsy = $this;
		$user = wp_get_current_user();
		$info = self::info();
    	if(is_page_template( 'admin_perfil.php' )){
    		if(file_exists(ADPNSY_PATH . "/templates/perfil_usuario.php")){
    			$mensaje = self::perfil_user($info, $user);
				include ADPNSY_PATH . "/templates/perfil_usuario.php";
			}else{
				return "<p>El template de perfil fue eliminado</p>";
			}
    	}else{
    		global $post;
			$slug = $post->post_name;
			if(file_exists(ADPNSY_PATH . "/templates/" . $slug . ".php")){
				include ADPNSY_PATH . "/templates/" . $slug . ".php";
			}else{
				return "<p>No se ha generador el template" . ADPNSY_PATH . "/templates/" . $slug . ".php</p>";
			}
    	}
    }

    public function menu($menu, $menu_class, $menu_id){
    	$theme_locations = get_nav_menu_locations();
    	$menu_obj = get_term( $theme_locations[$menu], 'nav_menu' );
    	$menu_name = $menu_obj->name;
    	wp_nav_menu(array("menu" => $menu_name, "menu_class" => $menu_class, "menu_id" => $menu_id, "container" => "ul"));
    }

    public function perfil_user($info, $user){
    	if($_SERVER['REQUEST_METHOD'] === 'POST'){
    		if(isset($_REQUEST['save']) && $info){
    			$act = $_REQUEST['act'];
    			$act['ID'] = $user->ID;
    			if($act['user_pass'] == ""){
    				unset($act['user_pass']);
    			}
    			$us = wp_update_user($act);
    			if(is_wp_error( $us )){
    				return array("e" => "error", "m" => $us->get_error_message());
    			}else{
    				return array("e" => "exito", "m" => __("Datos actualizados <span>NOTA: el correo tarda unos segundos en aparecer<span>", "adpnsy"));
    			}
    		}
    	}
    	return;
    }

    public function recuperar($info){
    	if($_SERVER['REQUEST_METHOD'] === 'POST'){
    		if(isset($_REQUEST['recovery']) && $info){
    			if($user = get_user_by("email", $_REQUEST['mail_recovery'])){
    				$key = get_password_reset_key($user);
    				if(!is_wp_error($key)){
    					$_data = array(
    						"Link" 		=> self::url_page($info->Recovery) . "?key=" . $key . "&us=an" . urlencode(base64_encode($user->user_login)),
    						"Nombre"	=> $user->display_name,
    						"Key"		=> $key,
    						"User"		=> $user->user_login
    					);
    					if(self::mail($_REQUEST['mail_recovery'], __("Recuperación de contraseña", 'adpnsy'), "recuperacion", $_data, $info)){
    						return array(
	    						"m" => __("Hemos procedido a enviarle un correo electrónico con las instrucciones. Revise SPAM", 'adpnsy' ),
	    						"c"	=> "exito"
	    					);
    					}else{
    						return array(
	    						"m" => __("Correo no enviado", 'adpnsy' ),
	    						"c"	=> "error"
	    					);
    					}
    				}else{
    					return array(
    						"m" => __("Key no generada", 'adpnsy' ),
    						"c"	=> "error"
    					);
    				}
    			}else{
    				return array(
						"m" => __("Usuario no encontrado", 'adpnsy' ),
						"c"	=> "error"
    				);
    			}
    		}else if(isset($_REQUEST['change']) && $info){
    			if(isset($_REQUEST['key']) && $_REQUEST['key'] != "" && 
    			   isset($_REQUEST['us']) && $_REQUEST['us'] != "" && 
    			   isset($_REQUEST['password']) && $_REQUEST['password'] != "" && $info){
    			   	$us = urldecode(base64_decode(substr($_REQUEST['us'], 2)));
	    			$ck = check_password_reset_key($_REQUEST['key'], $us);
	    			if(!is_wp_error( $ck )){
	    				reset_password($ck, $_REQUEST['password']);
	    				$user = get_user_by( "login", $us );
	    				setcookie("_sp__m", base64_encode(__("Nueva contraseña establecida", "adpnsy")), time()+1, "/");
	    				update_usermeta( $user->ID, '__active', true );
	    				self::to_login();
	    				exit;
	    			}else{
	    				return array(
		    				'm'	=> $ck->get_error_message()
		    			);
	    			}
	    		}else{
	    			return array(
	    				'm'	=> __("Datos insuficientes por favor rellene el formulario", "adpnsy")
	    			);
	    		}
    		}
    	}
    	if($_SERVER['REQUEST_METHOD'] === 'GET'){
    		if(isset($_GET['key']) && $_GET['key'] != "" && isset($_GET['us']) && $_GET['us'] != "" && $info){
    			$ck = check_password_reset_key($_GET['key'], urldecode(base64_decode(substr($_GET['us'], 2))));
    			if(!is_wp_error( $ck )){
    				return true;
    			}
    		}
    	}
    	return;
    }

    public function register($info){
    	if($_SERVER['REQUEST_METHOD'] === 'POST'){
    		if(isset($_REQUEST['register']) && $info){
    			if(!isset($_REQUEST['aceptar'])) return __("Debe leer y aceptar nuestra políticas para registrarse.", "adpnsy");
    			$us = $_REQUEST['username'];
    			$em = $_REQUEST['email'];
    			$ps = $_REQUEST['password'];
    			$nu = wp_create_user($us, $ps, $em);
    			if(is_wp_error( $nu )){
    				return $nu->get_error_message();
    			}else{
    				$user = get_user_by( "login", $us );
    				if($user){
    					$key = get_password_reset_key($user);
    					$_data = array(
    						"Link" 		=> self::url_login() . "?key=" . $key . "&_s=an" . urlencode(base64_encode($user->user_login)),
    						"Nombre"	=> $user->display_name,
    						"Key"		=> $key,
    						"User"		=> $user->user_login
    					);
    					if(self::mail($_REQUEST['email'], __("Activación de cuenta", 'adpnsy'), "activar", $_data, $info)){
    						setcookie("_sp__m", base64_encode(__("Registro realizado con éxito, hemos procedido a enviarte un correo electrónico con un enlace de activación. Revise SPAM", "adpnsy")), time()+1, "/");
    						self::to_login($info);
    					}else{
    						return __("Error al intentar enviar tu correo de activación, contacta a nuestro soporte con el código de error ", "adpnsy") . "ERCA-01";
    					}
    				}else{
    					return __("Error al registrar su usuario intente mas tarde.", "adpnsy");
    				}
    			}
    		}
    	}
    	return;
    }

    public function mail($correo, $asunto, $template, $_data, $info = null){
    	$_data = (object) $_data;
    	$_base = file_get_contents(ADPNSY_PATH . "/templates_email/base.html");
    	include(ADPNSY_PATH . "/templates_email/" . $template . ".php");
    	$_head[] = 'Content-Type: text/html; charset=UTF-8';
    	if(isset($_config) && is_array($_config) && isset($_config['Correo']) && isset($_config['Nombre'])){
    		$_head[] = "From: ".$_config['Nombre']." <".$_config['Correo'].">";
    	}
    	if(isset($remplace) && is_array($remplace)){
    		foreach ($remplace as $key => $value) {
	    		$_base = str_replace($key, $value, $_base);
	    	}
    	}
    	return wp_mail( $correo, $asunto, $_base, $_head );
    }

    public function mensaje(){
    	if(isset($_COOKIE['_sp__m'])){
    		$mensaje = base64_decode(urldecode($_COOKIE['_sp__m']));
	    	unset($_COOKIE['_sp__m']);
			setcookie( "_sp__m", '', time() - 86400, "/" );?>
			<div class='exito-login'><?=$mensaje;?></div>
		<?php }
    }

	public function barra_admin() {
		if (!current_user_can('administrator') && !is_admin()) {
			add_filter( 'show_admin_bar', '__return_false' );
		}
	}


/************************
*						*
*	Funciones Privadas	*
*						*
************************/

	private function save($key, $key_id, $key_last, $opt, $nm = false){
		$bse = new stdClass();
		$bse->key = $key;
		$bse->key_id = $key_id;
		$bse->key_last = $key_last;
		$bse->opt = $opt;
		$bse = json_encode($bse);
		$bse = base64_encode($bse);
		$bse = 'and' . $bse;
		if(update_option('adpnsy_lic', $bse)){
			if($key != "" && !$nm) self::Noticia("notice-success", __("Datos guardados satisfactoriamente.", "adpnsy"));
			return true;
		}else{
			if($key != "" && !$nm) self::Noticia("notice-error", __("Error al procesar los datos.", "adpnsy"));
			return false;
		}
	}

    private function activar(){
    	$site = get_option('siteurl');
    	$key = crypt($site, 'AN');
		if(isset($_POST['activar'])){
			///comprobar licencia
			if(!self::comprobar(sanitize_text_field($_POST['licencia']), false)){
				self::Noticia("notice-error", "Licencia Invalida");
			}else{
				/* En caso de reactivacion */
				$licence = get_option('adpnsy_lic');
				if($licence){
					$licence = substr($licence, 3);
					$licence = base64_decode($licence);
					$licence = json_decode($licence);
					$opt = $licence->opt;
				}else{
					$opt = array();
				}

				self::Noticia("notice-success", "Licencia Registrada");
				$bse = new stdClass();
				$bse->key = $key;
				$bse->key_id = sanitize_text_field($_POST['licencia']);
				$bse->key_last = time() + 604800;
				$bse->opt = $opt;
				$bse = json_encode($bse);
				$bse = base64_encode($bse);
				$bse = 'and' . $bse;
				update_option('adpnsy_lic', $bse);
			}
		}else{
			$key_id = self::info(true);
			self::save($key, $key_id, time() + 86400, $_POST );
		}
    }

    private function admin_activar_panel(){
    	?>
    		<style type="text/css">
    			.head-config div {
				    margin: auto;
				    width: 100%;
				    padding: 10px;
				}

				.head-config h1 {
				    font-size: 35px;
				    font-weight: 800;
				    vertical-align: middle;
				    margin: 0;
				}

				.head-config p {
				    margin: 5px 0;
				}

				.head-config span {
				    background-color: #222222;
				    display: inline-flex;
				    padding: 20px;
				    border-radius: 5px;
				}

				.head-config {
				    max-width: 730px;
				    padding: 20px;
				    margin-left: 0;
				    position: relative;
				    display: flex;
				}

				.head-config img {
				    display: inline;
				}
    		</style>
    		<div class="head-config">
    			<span>
    				<img src="<?=ADPNSY_URL;?>app-assets/img/logo.png">
    			</span>
    			<div>
    				<h1>SP Admin</h1>
    				<p>Diseñado y desarrollado por <a target="_blank" href="https://www.santipm.com/">Agencia Santiago Ponce</a></p>
    			</div>
    		</div>
			<div class="wrap">
				<h1>Activación de Panel</h1>
				<form method="post">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">
									<label for="licencia">Licencia</label>
								</th>
								<td>
									<input autocomplete="off" required name="licencia" type="password" id="licencia" value="" class="regular-text">
								</td>
							</tr>
						</tbody>
					</table>
					<input class="button button-primary" type="submit" name="activar" value="Activar">
				</form>
			</div>
		<?php
    }

    private function admin_config_panel(){

    	if(isset($_GET['demo'])){
    		$info = self::info();
    		if(!$info->demo){
    			$c = new adpnsy;
	    		$opt = $c->install();
	    		self::install_($opt);
    		}
    	}

    	if(isset($_COOKIE['__sp_a'])){
			$mensaje =  json_decode(base64_decode(urldecode($_COOKIE['__sp_a'])), true);
			self::Noticia($mensaje[0], $mensaje[1]);
			unset($_COOKIE['__sp_a']);
			setcookie( "__sp_a", '', 1 );
		}

    	///WP
		wp_enqueue_media();
		///JS
		wp_enqueue_script( 'admin_panel_js', ADPNSY_URL . "js/admin.js", array('jquery'), "1.5");
		///S2
		wp_enqueue_script( 'select2', ADPNSY_URL . "app-assets/vendors/select2/select2.full.min.js", array('jquery'));
		wp_enqueue_style( 'select2', ADPNSY_URL . "app-assets/vendors/select2/select2.min.css");
		///Materialize
		wp_enqueue_style( 'materialize', ADPNSY_URL . "app-assets/css/themes/horizontal-menu-template/style.min.css");
		wp_enqueue_style( 'admin_panel_css', ADPNSY_URL . "css/admin.css");
		///Panel

		$pages = get_pages(array("meta_key" => "_wp_page_template", "meta_value" => "admin_dashboard.php"));

		$pages_rg = get_pages(array("meta_key" => "_wp_page_template", "meta_value" => "admin_register.php"));

		$pages_rc = get_pages(array("meta_key" => "_wp_page_template", "meta_value" => "admin_recovery.php"));

		$pages_al = get_pages();

		$info = self::info();
		echo '<div class="head-config"><span><img src="' . ADPNSY_URL . 'app-assets/img/logo.png"></span><div><h1>SP Admin</h1><p>Diseñado y desarrollado por <a target="_blank" href="https://www.santipm.com/">Agencia Santiago Ponce</a></p><a class="button button-primary" type="submit" href="' . admin_url("options-general.php?page=panel_admin_system&demo") . '">Instalar Demo</a></div></div>';
		
		include 'admin_config.php';
    }

    private function comprobar($lic = "", $df = true){
    	$api_params = array(
			'slm_action' => 'slm_check',
			'secret_key' => '5e84c405466b11.57304054',
			'license_key' => $lic
		);
		$response = wp_remote_get(add_query_arg($api_params, 'http://santipm.com/blog/'), array('timeout' => 20, 'sslverify' => false));
		if(is_wp_error( $response )) return $df;
		try {
		    $data = json_decode( $response['body'] );
		} catch ( Exception $ex ) {
		    $data = null;
		}
		if(is_null($data)) return $df;
		if($data->result != "success") return false;
		if($data->status != "active") return false;
		return true;
    }

    private function install_($opt){
    	$licence = get_option('adpnsy_lic');
		if($licence){
			$licence = substr($licence, 3);
			$licence = base64_decode($licence);
			$licence = json_decode($licence);
			$key = $licence->key;
			$key_id = $licence->key_id;
			$key_last = $licence->key_last;
			if(self::save($key, $key_id, $key_last, $opt)){
				setcookie("__sp_a", base64_encode(json_encode(array('notice-success', __('Demo instalado.', 'adpnsy')))) );
			}else{
				setcookie("__sp_a", base64_encode(json_encode(array('notice-error', __('Error al instalar Demo.', 'adpnsy')))) );
			}
		}else{
			setcookie("__sp_a", base64_encode(json_encode(array('notice-error', __('Error al procesar los datos.', 'adpnsy')))) );
		}
		wp_redirect(remove_query_arg("demo"));
    }
}

?>