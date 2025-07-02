<?php 

	$r = array("r" => false, "m" => "Acceso denegado");
	global $wpdb;
	$spuser_data = $wpdb->prefix . "spuser_data";
    $spuser_recovery = $wpdb->prefix . "spuser_recovery";
	
	if ( isset($_REQUEST) && isset($_REQUEST['type']) && isset($_REQUEST['unik']) && wp_verify_nonce( $_REQUEST['unik'], '_spuser2021_' ) ){
		
		//login
		if($_REQUEST['type'] == 1){
			if(self::recaptcha($_REQUEST['token'])){
				if (filter_var(sanitize_text_field($_REQUEST['dts']["us"]), FILTER_VALIDATE_EMAIL)) {
					$user = get_user_by('email',sanitize_text_field($_REQUEST['dts']["us"]));
					if($user){
						$user_espera = $wpdb->get_var("SELECT cif FROM $spuser_data WHERE correo='".sanitize_text_field($_REQUEST['dts']["us"])."' AND pass='".sanitize_text_field($_REQUEST['dts']["ps"])."' ");
						$user_desactivado = $wpdb->get_var("SELECT code FROM $spuser_data WHERE correo='".sanitize_text_field($_REQUEST['dts']["us"])."' AND pass='".sanitize_text_field($_REQUEST['dts']["ps"])."' ");
					    $creds = array(
					        'user_login'    => $user->user_login,
					        'user_password' => sanitize_text_field($_REQUEST['dts']["ps"]),
					        'remember'      => 1
					    );
					}
				}else{
					$user_espera = $wpdb->get_var("SELECT cif FROM $spuser_data WHERE cif='".sanitize_text_field($_REQUEST['dts']["us"])."' AND pass='".sanitize_text_field($_REQUEST['dts']["ps"])."' ");
					$user_desactivado = $wpdb->get_var("SELECT code FROM $spuser_data WHERE cif='".sanitize_text_field($_REQUEST['dts']["us"])."' AND pass='".sanitize_text_field($_REQUEST['dts']["ps"])."' ");
					$creds = array(
				        'user_login'    => sanitize_text_field($_REQUEST['dts']["us"]),
				        'user_password' => sanitize_text_field($_REQUEST['dts']["ps"]),
				        'remember'      => 1
				    );
				}
				if($user_desactivado == "1"){
					$r["m"] = "Tu cuenta se encuentra temporalmente inaccesible contacte al administrador para solicitar ayuda";
				}else if($creds){
				    $user_login = wp_signon( $creds, is_ssl() );
				    if ( is_wp_error( $user_login ) ) {
				    	if($user_espera){
				    		$r["m"] = "Tu cuenta se encuentra en proceso de activación";
				    	}else{
				    		$r["m"] = "Compruebe usuario o contraseña";
				    	}
				    }else{
				    	$r["r"] = true;
				    	$r["url"] = home_url('/dashboard/');
				    }
				}else{
					if($user_espera){
			    		$r["m"] = "Tu cuenta se encuentra en proceso de activación";
			    	}else{
			    		$r["m"] = "Compruebe usuario o contraseña";
			    	}
				}
			}else{
				$r["m"] = "Captcha no valida intente volver a cargar la web";
			}
		}

		//recovery
		if($_REQUEST['type'] == 2){
			if(self::recaptcha($_REQUEST['token'])){
				if($user = get_user_by("email", sanitize_text_field($_REQUEST['mail_recovery']))){
					$key = get_password_reset_key($user);
					if(!is_wp_error($key)){
						$_data_bd = array(
							"key" 		=> $key,
							"user" 		=> $user->user_login
						);
						if($wpdb->replace($spuser_recovery, $_data_bd) !== false){
							$_data = array(
								"Link" 		=> get_option( "siteurl" ) . '/registro-campamentos' . "?spuser_recovery=" . $key,
								"Nombre"	=> $user->display_name,
								"Key"		=> $key,
								"User"		=> $user->user_login
							);

							if(self::mail(sanitize_text_field($_REQUEST['mail_recovery']), __("Recuperación de contraseña", 'spuser'), "recuperacion", $_data)){
								$r["r"] = true;
								$r["m"] = __("Hemos procedido a enviarle un correo electrónico con las instrucciones. Revise SPAM", "spuser");
							}else{
								$r["m"] = __("Correo no enviado", "spuser");
							}
						}else{
							$r["m"] = __("Key no generada", "spuser");
						}
					}else{
						$r["m"] = __("Error R1: por favor intente mas tarde", "spuser");
					}
				}else{
					$r["m"] = __("Usuario no encontrado", "spuser");
				}
			}else{
				$r["m"] = __("Captcha no valida intente volver a cargar la web", "spuser");
			}
		}

		//change passa recorevy
		if($_REQUEST['type'] == 3){
			if(self::recaptcha($_REQUEST['token'])){
				$key = sanitize_text_field($_REQUEST['key']);
				$pas = sanitize_text_field($_REQUEST['new_pass']);
				$sol = $wpdb->get_var("SELECT `user` FROM `$spuser_recovery` WHERE `key`='$key'");
				if($sol){
					$ck = check_password_reset_key($key, $sol);
					if(!is_wp_error( $ck )){
						if($wpdb->update($spuser_data, ["pass" => $pas], ["cif" => $sol]) !== false){
							$wpdb->delete($spuser_recovery, ["key" => $key]);
							reset_password($ck, $pas);
							$r["r"] = true;
							$r["m"] = __("Contraseña establecida", "spuser");
						}else{
							$r["m"] = __("Contraseña no establecida intente mas tarde", "spuser");
						}
					}else{
						$r["m"] = $ck->get_error_message();
					}
				}else{
					$r["m"] = __("Enlace invalido o caducado", "spuser");
				}
			}else{
				$r["m"] = __("Captcha no valida intente volver a cargar la web", "spuser");
			}
		}

		//Register
		if($_REQUEST['type'] == 4){
			if(self::recaptcha($_REQUEST['token'])){
				///validar correo
				$dts = $_REQUEST['dts'];
				$dts2 = $dts;
				foreach($dts2 as $_t => $_d) if(!in_array($_t, ["correo", "pass"]))$dts[$_t] = strtoupper($_d);
				$email = get_user_by('email',sanitize_text_field($dts["correo"]));
				$email2 = $wpdb->get_var("SELECT correo FROM $spuser_data WHERE correo = '".sanitize_text_field($dts["correo"])."'");
				if(!$email && !$email2){
					$login = get_user_by('login',sanitize_text_field($dts["cif"]));
					$login2 = $wpdb->get_var("SELECT cif FROM $spuser_data WHERE cif = '".sanitize_text_field($dts["cif"])."'");
					if(!$login && !$login2){
						if($wpdb->insert($spuser_data, $dts) !== false){
							$_data = array(
								"Nombre"	=> "Administardor",
								"url_damin" => get_admin_url(),
								"responsable" => $dts["responsable"],
								"movil" => $dts["movil"],
								"telefono" => $dts["telefono"],
								"empresa" => $dts["nombre_comercial"],
								"povincia" => $dts["provincia"],
								"correo" => $dts["correo"]
							); 
							self::mail(array('info@topcampamentos.com'), __("Nuevo usuario en espera", 'spuser'), "registro", $_data);
							$r["r"] = true;
							$r["m"] = __("Su preregistro se ha realizado con éxito, nos pondremos en contacto con usted para finalizar el proceso. Muchas Gracias.", "spuser");
							$r['rd'] = home_url();
						}else{
							$r["m"] = __("No pudimos almacenar tu información intente mas tarde", "spuser");
						}
					}else{
						$r["m"] = __("El CIF ya esta registrado", "spuser");
					}
				}else{
					$r["m"] = __("Correo electrónico ya esta registrado", "spuser");
				}
			}else{
				$r["m"] = "Captcha no valida intente volver a cargar la web";
			}
		}
	}

	if ( isset($_REQUEST) && isset($_REQUEST['logout']) && wp_verify_nonce( $_REQUEST['logout'], get_current_user_id() ) ){
		wp_logout();
		$r["r"] = true;
		$r["m"] = "echo";
	}

	echo json_encode($r);
	die();  