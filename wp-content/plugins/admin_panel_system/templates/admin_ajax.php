<?php 

$r = array("r" => false, "m" => "Acceso denegado");

if ( isset($_REQUEST) ){

	if(isset($_REQUEST['GET_IMAGEN']) && $_REQUEST['GET_IMAGEN'] == 1){
		$img = $_FILES['imagen_top_camp'];
		if($img['error'] == 0) {
			$new_id = $this->media_custom_TOPCamps($img['tmp_name'], $img['name']);
			if($new_id !== false) {
				$r['r'] = true;
				$r['m'] = 'exito!';
				$r['d'] = $new_id;
				$r['url'] = wp_get_attachment_url($new_id);
			}else{
				$r['m'] = 'Error al almacenar la imagen';
			}
		}else{
			$r['m'] = 'Error al procesar la imagen';
		}
	}

	if(isset($_REQUEST['getAttach']) && $_REQUEST['getAttach'] == 2){
		$author = wp_get_current_user();
		$author = $author->ID;
		$attachments_current_user = get_posts(array(
			'post_type'      => 'attachment',
			'author'         => $author,
			'posts_per_page' => -1,
		));
		error_log('jkslfjk: '.print_r($attachments_current_user, true));
		if(empty($attachments_current_user)){
			$r['m'] = 'Subir medios';
		}else{
			$data_attachment = array();
			foreach ($attachments_current_user as $k => $v) {
				$data_attachment[$k]['id'] = $v->ID;
				$data_attachment[$k]['url'] = $v->guid;
				$data_attachment[$k]['title'] = $v->post_title;
			}
			$r['r'] = true;
			$r['attach_id'] = $data_attachment;
		}
	}

	if(isset($_REQUEST['dltAttach']) && $_REQUEST['dltAttach'] == 3){
		$id_dlt = (int)$_REQUEST['id_dlt'];
		$author = wp_get_current_user();
		$author = $author->ID;
		if(empty($id_dlt)) $r['m'] = 'Ocurrio un error al obtener el identificador de la imagen, por favor intentelo más tarde';
		if(wp_delete_attachment($id_dlt, true)) {
			$attachments_current_user = get_posts(array(
				'post_type'      => 'attachment',
				'author'         => $author,
				'posts_per_page' => -1,
			));
			if(empty($attachments_current_user)){
				$r['r'] = true;
				$r['empty'] = true;
				$r['m'] = 'Subir medios';
			}else{
				$data_attachment = array();
				foreach ($attachments_current_user as $k => $v) {
					$data_attachment[$k]['id'] = $v->ID;
					$data_attachment[$k]['url'] = $v->guid;
					$data_attachment[$k]['title'] = $v->post_title;
				}
				$r['r'] = true;
				$r['attach_id'] = $data_attachment;
			}
		}else{
			$r['m'] = 'Ocurrió un error al eliminar la imagen, por favor inténtelo más tarde';
		}
	}
	
	if(isset($_REQUEST['send_message'])){
		global $wpdb, $info;
		$top_mensajes = $wpdb->prefix . "top_mensajes";
		if(isset($_POST['fields']['orden_element'])){
			$order_id = $_POST['fields']['orden_element']['value'];
			$order = wc_get_order($order_id);
			$order_items = $order->get_items();
			if(!empty($order_items)) foreach($order_items as $key => $it) $camp_id = $it->get_meta('campamento');
			if(isset($camp_id) && $camp_id){
				$nelemento = [
					"message"		=> sanitize_text_field($_POST['fields']['message']['value']),
					"user"			=> $_POST['fields']['user']['value'],
					"campamento"	=> $camp_id,
					"orden"			=> $order_id,
				];
			}else{
				wp_send_json_error( 'Campamento no encontrado.', 400 );
			}

		}else{
			$nelemento = [
				"message"		=> sanitize_text_field($_POST['fields']['message']['value']),
				"user"			=> $_POST['fields']['user']['value'],
				"campamento"	=> $_POST['fields']['campamento']['value'],
				"orden"			=> 0,
			];
		}

		if($wpdb->insert($top_mensajes, $nelemento) !== false){
			$post_id = intval($nelemento['campamento']);
			$author_id = get_post_field( 'post_author', $post_id );
			$mail = $author_id ? get_the_author_meta( 'user_email', $author_id ) : get_option("admin_email");
			$nombre = $author_id ? get_the_author_meta( 'display_name', $author_id ) : 'Administrador';
			$url = get_option( "siteurl" ) . "/registro-campamentos/?ingresar";
			$_data = [
				"nombre" => $nombre,
				"mensaje" => "Hola $nombre,<br><br>Tienes un nuevo mensaje, para leerlo y responder por favor ingrese a <a target='_blank' href='$url'>este enlaces</a><br><br><br>Si no puedes acceder al enlace prueba copiar y pegar esta URL en tu navegador $url"
			];
			$this->mail($mail, __("Nuevo mensaje en TOP Campamentos", 'adpnsy'), "notificacion", $_data, $info);
		}else{
			wp_send_json_error( 'Ocurrió un error.', 400 );
		}
	}

	if(isset($_REQUEST['cbd']) && $_REQUEST['cbd'] == 'true'){
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb, $charset_collate;
		$top_mensajes = $wpdb->prefix . "top_mensajes";
		if($wpdb->get_var("SHOW TABLES LIKE '$top_mensajes'") != $top_mensajes) {
			dbDelta(  
			  "CREATE TABLE $top_mensajes (
			    `id` bigint(20) AUTO_INCREMENT NOT NULL,
			    `message` text(0) NOT NULL DEFAULT '',
		        `user` bigint(20) NOT NULL DEFAULT '0',
		        `campamento` bigint(20) NOT NULL DEFAULT '0',
		        `orden` bigint(20) NOT NULL DEFAULT '0',
		        `tipo` tinyint(1) NOT NULL DEFAULT '0',
		        `estado` tinyint(1) NOT NULL DEFAULT '0',
		        `padre` bigint(20) NOT NULL DEFAULT '0',
		        `fecha` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
			    PRIMARY KEY (`id`)
			  ) $charset_collate;"
			);
		}
	}

	if(isset($_REQUEST['GET_DATA_']) && $_REQUEST['GET_DATA_'] == 5){
		global $wpdb;
		$tabla = $wpdb->prefix . 'jet_post_types';
		$metadata_TOP_ajax = $wpdb->get_var("SELECT meta_fields FROM $tabla WHERE slug='topcampamentos'");
		$metadata_TOP_ajax = unserialize($metadata_TOP_ajax);
		$metadata_TOP_ajax_trat = array();
		foreach($metadata_TOP_ajax as $k => $v){
			$metadata_TOP_ajax_trat[$v['name']][] = $v['type'];
			$metadata_TOP_ajax_trat[$v['name']][] = $v['options'];
		}
		$form_data = $_POST;
		$crea_edit = false;
		$mensajes_ajax = array();
		$title_camp_cpt = $form_data['camp_title'];
		$p_or_d = (isset($form_data['is_complete']) && filter_var($form_data['is_complete'], FILTER_VALIDATE_BOOLEAN)) ? 'publish' : 'draft';
		$title_camp_cpt = trim($title_camp_cpt);
		$id_camp_current_ce = (isset($form_data['id_camp_current'])) ? (int)$form_data['id_camp_current'] : 0;
		$meta_data_trat_ = array();
		$query1 = array(
			'post_type' => 'topcampamentos',
			'title' => $title_camp_cpt,
		);
		$query_res_1 = new WP_Query($query1);
		if($query_res_1->have_posts() && $query_res_1->post->ID !== $id_camp_current_ce){
			$r['r'] = false;
			$mensajes_ajax[] = 'El título que elegiste para tu campamento, ya se encuentra en uso, por favor ingresa otro';
		}else{
			if(!$id_camp_current_ce){
				$author = get_current_user_id();
				$args = array(
					'post_type' 	=> 'topcampamentos',
					'post_title' 	=> $title_camp_cpt,
					'post_status' 	=> $p_or_d,
					'post_author'	=> $author,
				);
				$camp_id = wp_insert_post($args);
				$crea_edit = true;
			}else{
				$camp_id = $id_camp_current_ce;
				if($title_camp_cpt !== get_the_title($camp_id)){
					$camp_update_metatitle = array(
						'ID' => $camp_id,
						'post_title' => $title_camp_cpt
					);
					$res_updt_title = wp_update_post($camp_update_metatitle);
					if(!$res_updt_title){
						$mensajes_ajax[] = 'Ha ocurrido un error al actualizar el nombre de tu campamento, por favor intentelo más tarde.';
					}
				}
				
			}
			if($camp_id){
				foreach($form_data as $k => $v){
					if($k == 'camp_title' || $k == 'id_camp_current'){
						continue;
					}elseif($k == 'cluecamp') {
						$data = ['mes-temporada' => [], 'edades' => [], 'duracion' => []];
						foreach($metadata_TOP_ajax_trat['mes-temporada'][1] as $mt) $data['mes-temporada'][$mt['key']] = "false";
						foreach($metadata_TOP_ajax_trat['edades'][1] as $ed) $data['edades'][$ed['key']] = "false";
						foreach($metadata_TOP_ajax_trat['duracion'][1] as $dr) $data['duracion'][$dr['key']] = "false";
						$prices_clue = array();
						$plazas_sale = array();
						$plazas_sale_old = get_post_meta($camp_id, 'plazas_disp', true);
						if(!is_array($plazas_sale_old)) $plazas_sale_old  = array();
						foreach($v as $ide => $element){
							$ne = (array)$element;
							$mt = $ne['mes-temporada'];
							$ed = $ne['edades'];
							$dr = $ne['duracion'];
							$data['mes-temporada'][$mt] = "true";
							$data['edades'][$ed] = "true";
							$data['duracion'][$dr] = "true";
							$prices_clue[] = (int)$ne['precio'];
							$plazas_sale[$ide] = isset($plazas_sale_old[$ide]) ? $plazas_sale_old[$ide]: 0;
						}
						if(count(array_diff($plazas_sale, $plazas_sale_old))){
							if(!update_post_meta($camp_id, 'plazas_disp', $plazas_sale))  $mensajes_ajax[] = 'Ha ocurrido un error al intentar almacenar la información sensible, por favor contacte al administrador';
						}
						sort($prices_clue);
						$old_clue_price = get_post_meta($camp_id, 'precio', true);
						if($old_clue_price != $prices_clue[0]){
							if(!update_post_meta($camp_id, 'precio', $prices_clue[0])) $mensajes_ajax[] = 'Ha ocurrido un error al intentar almacenar la información sensible';
						}
						$mes_temporada = get_post_meta($camp_id, 'mes-temporada', true);
						$edades = get_post_meta($camp_id, 'edades', true);
						$duracion = get_post_meta($camp_id, 'duracion', true);
						if(!is_array($mes_temporada) || count(array_diff_assoc($mes_temporada, $data['mes-temporada']))){
							if(!update_post_meta($camp_id, 'mes-temporada', $data['mes-temporada'])) $mensajes_ajax[] = 'Ha ocurrido un error al intentar almacenar la información sensible';
						}
						if(!is_array($edades) || count(array_diff_assoc($edades, $data['edades']))){
							if(!update_post_meta($camp_id, 'edades', $data['edades'])) $mensajes_ajax[] = 'Ha ocurrido un error al intentar almacenar la información sensible';
						}
						if(!is_array($duracion) || count(array_diff_assoc($duracion, $data['duracion']))){
							if(!update_post_meta($camp_id, 'duracion', $data['duracion'])) $mensajes_ajax[] = 'Ha ocurrido un error al intentar almacenar la información sensible';
						}
						$cluecamp_old = get_post_meta($camp_id, $k, true);
						$cluecamp_new = json_encode($v, JSON_UNESCAPED_UNICODE);
						if($cluecamp_old != $cluecamp_new){
							$cluecamp_if = update_post_meta($camp_id, $k, $cluecamp_new);
							if(!$cluecamp_if) $mensajes_ajax[] = 'Ha ocurrido un error al intentar almacenar la información sensible';
						}
					}elseif($k == 'instalaciones') {
						$media_inst = implode(',', $v);
						$media_inst_old = get_post_meta($camp_id, $k, true);
						if($media_inst_old != $media_inst){
							$inst_media_meta = update_post_meta($camp_id, $k, $media_inst);
							if(!$inst_media_meta) {
								$mensajes_ajax[] = "Ha ocurrido un error al intentar almacenar los archivos en el metacampo ".$k;
							}
						}
					}elseif($k == 'ubication_iframe'){
						$ltlg = $this->lt_lg_iframe_TOP($v);
						if($ltlg !== false){
							$ltlg = (array)$ltlg;
							error_log('eso: '.print_r($ltlg, true));
							if(count($ltlg)){
								$meta_old_if_n_dir = get_post_meta($camp_id, $k, true);
								$meta_old_if_lt_dir = get_post_meta($camp_id, 'direction_lat_camp', true);
								$meta_old_if_lg_dir = get_post_meta($camp_id, 'direction_log_camp', true);
								if($meta_old_if_n_dir != $v){
									$meta_if = update_post_meta($camp_id, $k, $v);
									if(!$meta_if) {
										$mensajes_ajax[] = "Ha ocurrido un error al intentar almacenar la información en el metacampo ".$k;
									}
								}
	
								if($meta_old_if_lt_dir != $ltlg['lat']){
									$meta_if = update_post_meta($camp_id, 'direction_lat_camp', $ltlg['lat']);
									if(!$meta_if) {
										$mensajes_ajax[] = "Ha ocurrido un error al intentar almacenar la información en el metacampo ".$k;
									}
								}
	
								if($meta_old_if_lg_dir != $ltlg['lng']){
									$meta_if = update_post_meta($camp_id, 'direction_log_camp', $ltlg['lng']);
									if(!$meta_if) {
										$mensajes_ajax[] = "Ha ocurrido un error al intentar almacenar la información en el metacampo ".$k;
									}
								}
							}else{
								$mensajes_ajax[] = "La dirección ingresada es inválida, por favor ingrese una nueva dirección válida.";
							}
						}
					}else{
						if(is_array($v)){
							$meta_data_trat_ = array();
							if(array_key_exists($k, $metadata_TOP_ajax_trat)){
								$flevel_trat = $metadata_TOP_ajax_trat[$k][1];
								foreach($flevel_trat as $l){
									$meta_data_trat_[$l['key']] = in_array($l['key'], $v) ? "true" : "false";
								}
								$mt_camp_old = get_post_meta($camp_id, $k, true);
								if(!is_array($mt_camp_old) || count(array_diff_assoc($mt_camp_old, $meta_data_trat_))){
									$sub_meta_if = update_post_meta($camp_id, $k, $meta_data_trat_);
									if(!$sub_meta_if) $mensajes_ajax[] = "Ha ocurrido un error al intentar almacenar la información en el metacampo ".$k;
								}
							}
						}else{
							$meta_old_if_n = stripslashes(get_post_meta($camp_id, $k, true));
							if($meta_old_if_n != stripslashes($v)){
								$meta_if = update_post_meta($camp_id, $k, $v);
								if(!$meta_if) {
									$mensajes_ajax[] = "Ha ocurrido un error al intentar almacenar la información en el metacampo ".$k;
								}
							}
						}
					}
				}	
				if(!array_key_exists('foto', $form_data)){
					update_post_meta($camp_id, 'foto', '');
				}

				if(!array_key_exists('portada_camp', $form_data)){
					update_post_meta($camp_id, 'portada_camp', '');
				}
				
				if(!array_key_exists('instalaciones', $form_data)){
					update_post_meta($camp_id, 'instalaciones', '');
				}
			}else{
				$mensajes_ajax[] = 'Ha ocurrido un error al intentar trabajar con la información recogida del campamento, por favor intentelo más tarde.';
			}
		}

		$r['r'] = ($mensajes_ajax) ? false : true;
		$r['m'] =  $mensajes_ajax;
		$r['ce'] = $crea_edit;
	}

	if(isset($_REQUEST['getdata_book']) && $_REQUEST['getdata_book'] == 8 && wp_verify_nonce($_REQUEST['book'], 'booking')){
		$mens = array();
		$post_id = $_REQUEST['post_id'];
		$title_cmp = get_the_title($post_id);
		$clue_id = $_REQUEST['clueid'];
		$cantidad = $_REQUEST['cant'];
		$clue_data = json_decode(get_post_meta($post_id, 'cluecamp', true), true);
		$clue_data_dis = get_post_meta($post_id, 'plazas_disp', true);
		if(is_array($clue_data) && count($clue_data) && is_array($clue_data_dis) && count($clue_data_dis)){
			$disponible = $clue_data[$clue_id]["plazas_num"] - $clue_data_dis[$clue_id];
			if($disponible >= $cantidad){
				$to_price = $clue_data[$clue_id]['precio'];
				$fechas_meta = $clue_data[$clue_id]['fecha_inicio'].' | '.$clue_data[$clue_id]['fechas_final'];
				$edades_meta = $clue_data[$clue_id]['edades'];
				WC()->cart->empty_cart();
				WC()->cart->add_to_cart(236, $cantidad, 0, array("title_camp" => $title_cmp, "campamento" => $post_id, "fechas_r" => $fechas_meta, "edades_r" => $edades_meta, "reserva" => $clue_id, "precio" => $to_price));
				WC()->cart->calculate_totals();
				WC()->cart->set_session();
				WC()->cart->maybe_set_cart_cookies();
				do_action('woocommerce_before_calculate_totals', $cart_object);
				$r["r"] = true;
				$r["m"] = "agregado";
				$r["u"] = wc_get_checkout_url();
			}else{
				$r["m"] = "Las plazas ";
			}
		}else{	
			$r["m"] = "Datos incompleto";
		}
	}

	if(isset($_REQUEST['table_booking_top']) && $_REQUEST['table_booking_top'] == 'booking_top'){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		if($wpdb->get_var("SHOW TABLES LIKE '$camp_bookings_top'") != $camp_bookings_top){
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$table_booking_camp = dbDelta("CREATE TABLE $camp_bookings_top (
				id INT(11) NOT NULL AUTO_INCREMENT,
				plazas INT(100),
				id_orden INT(100),
				id_user INT(100),
				id_gest_camp INT(100),
				id_camp INT(100),
				id_cluecamp INT(100),
				precio FLOAT(11, 2),
				fecha DATE NOT NULL,
				PRIMARY KEY  (id)
			);");
		}
	}

	if(isset($_REQUEST['filterTab']) && $_REQUEST['filterTab'] == 2){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$data = $_REQUEST['dats'];
		$id_gest_camp = get_current_user_id();
		$sql = "SELECT * FROM $camp_bookings_top WHERE id_gest_camp = {$id_gest_camp}";
		if($data['id_camp']) $sql.= " AND id_camp = {$data['id_camp']}";
		if($data['date1'] && $data['date2']){
			$dt1 = explode('-', $data['date1']);
			$dt1 = $dt1[2].'-'.$dt1[1].'-'.$dt1[0];
			$dt2 = explode('-', $data['date2']);
			$dt2 = $dt2[2].'-'.$dt2[1].'-'.$dt2[0];
			$sql.= " AND fecha BETWEEN '{$dt1}' AND '{$dt2}'";
		}
		$result = $wpdb->get_results($sql);
		$result_print = [];
		if($result){
			foreach($result as $k => $dt){
				$result_print[$k][] = get_the_title($dt->id_camp);
				$date = explode('-', $dt->fecha);
				$result_print[$k][] = $date[2].'-'.$date[1].'-'.$date[0];
				$result_print[$k][] = $dt->plazas;
				$result_print[$k][] = $dt->fullname;
				$result_print[$k][] = wc_price(($dt->precio/15)*85);
				$result_print[$k][] = '<i class="material-icons icon-menu tbl_rs" dwn="'.$dt->id_orden.'">visibility</i>';
			}
		}
		$r['r'] = true;
		$r['m'] = 'Consulta obtenida';
		$r['sql'] = $result_print;
	}

	if(isset($_REQUEST['csv_reservas']) && wp_verify_nonce($_REQUEST['csv_reservas'], get_current_user_id())){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$id_gest_camp = get_current_user_id();
		$sql = "SELECT * FROM $camp_bookings_top WHERE id_gest_camp = {$id_gest_camp}";
		if($_REQUEST['id_camp']) $sql.= " AND id_camp = {$_REQUEST['id_camp']}";
		if($_REQUEST['date1'] && $_REQUEST['date2']){
			$dt1 = explode('-', $_REQUEST['date1']);
			$dt1 = $dt1[2].'-'.$dt1[1].'-'.$dt1[0];
			$dt2 = explode('-', $_REQUEST['date2']);
			$dt2 = $dt2[2].'-'.$dt2[1].'-'.$dt2[0];
			$sql.= " AND fecha BETWEEN '{$dt1}' AND '{$dt2}'";
		}

		$result = $wpdb->get_results($sql);
		$result_print = [];
		if($result){
			foreach($result as $k => $dt){
				$order_info_camps = wc_get_order($dt->id_orden);
				$order_info_camps = $order_info_camps->get_customer_note();
				$result_print[$k][] = $dt->id_orden;
				$result_print[$k][] = $dt->fullname;
				$result_print[$k][] = $dt->correo;
				$result_print[$k][] = $dt->telefono;
				$result_print[$k][] = get_the_title($dt->id_camp) ?? $dt->id_camp;
				$result_print[$k][] = $dt->fechas_reserva;
				$result_print[$k][] = $dt->plazas;
				$result_print[$k][] = (($dt->precio/15)*85);
				$result_print[$k][] = ($order_info_camps) ? $order_info_camps : '';
			}
		}
		header('Content-type: application/csv;charset=utf-8');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"reservas.csv\"");
		$outputBuffer = fopen("php://output", 'w');
		echo "\xEF\xBB\xBF";
		fputcsv($outputBuffer, array("Orden", "Nombre", "Correo", "Telefono", "Campamento", "Fechas", "Plasas solicitadas", "Pago pendiente", "Campistas"), ";");
		foreach($result_print as $v) {
			fputcsv($outputBuffer, $v, ";");
		}
		fclose($outputBuffer);
		exit;
	}

	if(isset($_REQUEST['table_booking_top']) && $_REQUEST['table_booking_top'] == 'alter_booking_top'){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$wpdb->query("ALTER TABLE $camp_bookings_top MODIFY id_cluecamp VARCHAR(255)");
	}

	if(isset($_REQUEST['table_booking_top']) && $_REQUEST['table_booking_top'] == 'alter_booking_top_add_column'){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$wpdb->query("ALTER TABLE $camp_bookings_top ADD fullname VARCHAR(255), ADD correo VARCHAR(255), ADD telefono VARCHAR(255), ADD fechas_reserva VARCHAR(255)");
	}

	if(isset($_REQUEST['table_booking_top']) && $_REQUEST['table_booking_top'] == 'comision'){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$wpdb->query("ALTER TABLE $camp_bookings_top ADD comision bigint(20) NOT NULL DEFAULT '15'");
	}

	if(isset($_REQUEST['visBook']) && $_REQUEST['visBook'] == 4){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$book_id = (int)$_REQUEST['booking'];
		$sql = $wpdb->get_row("SELECT * FROM {$camp_bookings_top} WHERE id_orden = '{$book_id}'");
		if($sql){
			$sql->title_camp = get_the_title($sql->id_camp);
			$order = wc_get_order($book_id);
			$sql->info_campists = $order->get_customer_note();
			$r['r'] = true;
			$r['m'] = 'Consulta realizada';
			$r['sql'] = $sql;
		}else{
			$r['m'] = 'Ha ocurrido un error al obtener la información de la orden #'.$book_id.'.';
		}
	}

	if(isset($_REQUEST['mailBook']) && $_REQUEST['mailBook'] == 1){
		$mail = $_REQUEST['text'];
		$post_id  = $_REQUEST['post_id'];
		if(!update_post_meta($post_id, 'mail_message', $mail)){
			$r['m'] = "Ha ocurrido un error al guardar la información. Por favor, inténtelo de nuevo más tarde.";
		}
		$r['r'] = true;
		$r['m'] = 'Los datos se guardaron exitosamente.';
	}

	if(isset($_REQUEST['mailBook']) && $_REQUEST['mailBook'] == 2){
		$post_id  = $_REQUEST['post_id'];
		$the_mail = get_post_meta($post_id, 'mail_message', true);
		$r['r'] = true;
		$r['m'] = 'Información obtenida.';
		$r['ml'] = $the_mail;
	}

	if(isset($_REQUEST['dashData']) && $_REQUEST['dashData'] == 1){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$reviews = $wpdb->prefix . 'jet_reviews';
		$reviews_consulta = "SELECT COUNT(*) FROM {$reviews}";
		$month = $_REQUEST['month'];
		$consulta = "SELECT SUM(plazas) as bk, SUM(precio) as pr FROM {$camp_bookings_top}";
		if($month && $month != 'false' && $month !== false){
			$month = explode('-', $month);
			$concat = " WHERE MONTH(fecha) = '{$month[1]}' AND YEAR(fecha) = '{$month[0]}'";
			$reviews_consulta .= " WHERE MONTH(date) = '{$month[1]}' AND YEAR(date) = '{$month[0]}'";
			$consulta .= $concat;
		}
		$sql_reviews = $wpdb->get_var($reviews_consulta);
		$sql = $wpdb->get_results($consulta);
		if($sql){
			$r['r'] = true;
			$r['sql'] = $sql;
			$r['op'] = (int)$sql_reviews;
		}else{
			$r['m'] = "Ha ocurrido un error al obtener la información. Por favor intentelo más tarde.";
		}
	}

	if(isset($_REQUEST['dashData']) && $_REQUEST['dashData'] == 2){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$reviews = $wpdb->prefix . 'jet_reviews';
		$views_table = $wpdb->prefix . 'postmeta'; 
		$user = $_REQUEST['user'];
		$camp = $_REQUEST['camp'];
		$current_year = date('Y');
		$reviews_consulta = '';
		$consult_views = "";
		$campamentos = get_posts(['author' => get_current_user_id(), 'posts_per_page' => -1, 'post_type' => 'topcampamentos', 'fields' => 'ids']);
		if(!empty($campamentos)){
			$_camps = implode(",", $campamentos);
			$consult_views = "SELECT SUM(meta_value) FROM {$views_table} WHERE meta_key = 'entry_views' AND post_id IN ({$_camps})";
			$reviews_consulta = "SELECT COUNT(*) FROM {$reviews} WHERE post_id IN ({$_camps})";
		}
		$consulta = "SELECT SUM(plazas) as bk FROM {$camp_bookings_top} WHERE id_gest_camp = {$user}";
		if($camp && $camp != 'false' && $camp !== false) {
			$concat = " AND id_camp = {$camp}";
			$consult_views = "SELECT SUM(meta_value) FROM {$views_table} WHERE meta_key = 'entry_views' AND post_id = {$camp}";
			$reviews_consulta = "SELECT COUNT(*) FROM {$reviews} WHERE post_id = {$camp}";
		}
		$sql_review = $wpdb->get_var($reviews_consulta);
		$consulta .= $concat;
		$sql = $wpdb->get_results($consulta);
		$sql_views = $wpdb->get_var($consult_views);
		if($sql){
			$r['r'] = true;
			$r['sql'] = $sql;
			$r['op'] = (int)$sql_review;
			$r['vw'] = (int)$sql_views;
		}else{
			$r['m'] = "Ha ocurrido un error al obtener la información. Por favor intentelo más tarde.";
		}
	}

	if(isset($_REQUEST['dashData']) && $_REQUEST['dashData'] == 3){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$month = $_REQUEST['month'];
		$consulta = "SELECT * FROM {$camp_bookings_top}";
		$concat = ($month && $month != 'false' && $month !== false) ? " WHERE MONTH(fecha) = '{$month}'": '';
		$consulta .= $concat;
		$sql = $wpdb->get_results($consulta);
		$r['r'] = true;
		$rsql = [];
		if($sql){
			foreach($sql as $k => $v){
				$rsql[$k][] = get_the_title($v->id_camp);
				$date = explode('-', $v->fecha);
				$rsql[$k][] = $date[2].'-'.$date[1].'-'.$date[0];
				$rsql[$k][] = $v->plazas;
				$rsql[$k][] = $v->id_gest_camp;
				$rsql[$k][] = wc_price($v->precio);
				$rsql[$k][] = '<i class="material-icons icon-menu" ord="'.$v->id_orden.'">visibility</i>';
			}
		}
		$r['rsql'] = $rsql;
		$r['m'] = 'Consulta obtenida!';
	}

	if(isset($_REQUEST['dashData']) && $_REQUEST['dashData'] == 4){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$id_order = $_REQUEST['order'];
		$sql = "SELECT * FROM {$camp_bookings_top} WHERE id_orden = '{$id_order}'";
		$result = $wpdb->get_row($sql);
		if($result){
			$order = wc_get_order($id_order);
			$result->info_campists = $order->get_customer_note();
			$result->title_camp = get_the_title($result->id_camp);
			$r['r'] = true;
			$r['m'] = 'Consulta obtenida!';
			$r['sql'] = $result;
		}else{
			$r['m'] = 'Ha ocurrido un error al obtener la información. Por favor intentelo de nuevo más tarde.';
		}
	}

	if(isset($_REQUEST['send_reviwer'])){
		if(!isset($_POST['fields']) || 
		   !isset($_POST['fields']['source_id']) || 
		   !isset($_POST['fields']['message']) || 
		   !isset($_POST['fields']['user']) || 
		   !isset($_POST['fields']['start_cant'])
		) wp_send_json_error( 'Datos incompletos', 400 );

		$source_id = $_POST['fields']['source_id']['value'];
		$message = $_POST['fields']['message']['value'];
		$user = $_POST['fields']['user']['value'];
		$start_cant = $_POST['fields']['start_cant']['value'];

		global $wpdb;
		$jet_reviews = $wpdb->prefix . "jet_reviews";
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$opiniones = (int)$wpdb->get_var("SELECT COUNT(id) FROM $jet_reviews WHERE author = {$user} AND post_id = {$source_id}");
		$compras = $wpdb->get_results("SELECT fechas_reserva FROM $camp_bookings_top WHERE id_user = {$user} AND id_camp = {$source_id}");
		$compras_consumida = 0;
		$fecha_a = time();
		if(is_array($compras) && !empty($compras)) foreach($compras as $c){
			$fechas = explode(" | ", $c->fechas_reserva);
			$fecha_f = explode("-",$fechas[1]);
			$fecha_f = strtotime("{$fecha_f[2]}-{$fecha_f[0]}-{$fecha_f[1]}");
			if ($fecha_a > $fecha_f) {
				$compras_consumida++;
			}
		} 
		if($opiniones >= $compras_consumida) wp_send_json_error( 'No pudes enviar mas opiniones', 400 );

		$request = new WP_REST_Request('POST', '/jet-reviews-api/v1/submit-review?_locale=user');

		$request->set_param('source', 'post');
		$request->set_param('source_id', $source_id);
		$request->set_param('content', $message);
		$request->set_param('author_id', $user);
		$request->set_param('rating_data', [
			[
				"field_label" => "Rating",
            	"field_value" => $start_cant,
            	"field_step" => 1,
            	"field_max" => 5
            ]
		]);
		
		$Submit_Review = new Jet_Reviews\Endpoints\Submit_Review();

		$r = $Submit_Review->callback($request);

		error_log(print_r($r, true));

		if(!$r->data["success"]) wp_send_json_error( $r, 400 );
	}

	if(isset($_REQUEST['dashData']) && $_REQUEST['dashData'] == 5){
		$comision = get_option('comi_booking');
		if(!$comision) $comision = 15;
		$r['r'] = true;
		$r['m'] = 'Comisión obtenida.';
		$r['cm'] = $comision;
	}

	if(isset($_REQUEST['dashData']) && $_REQUEST['dashData'] == 6){
		$comision = $_REQUEST['comision'];
		if(update_option('comi_booking', $comision)){
			$r['r'] = true;
			$r['m'] = 'Comisión configurada exitosamente';
		}else{
			$r['m'] = 'Lo sentimos, pero no pudimos subir la información al servidor en este momento. Por favor, inténtalo de nuevo más tarde.';
		}
	}

	if(isset($_REQUEST['factura']) && $_REQUEST['factura'] == '_look_'){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$post = $wpdb->prefix . 'posts';
		$users = $wpdb->prefix . 'users';

		$draw = $_POST['draw'];
		$row = $_POST['start'];
		$rowperpage = $_POST['length'];
		$columnIndex = $_POST['order'][0]['column'];
		$columnName = $_POST['columns'][$columnIndex]['data'];
		$columnSortOrder = $_POST['order'][0]['dir'];
		$searchValue = esc_sql($_POST['search']['value']);
		$filter = $_POST['filter'];

		//busqueda
		$_s = "";
		if($searchValue != ""){
			$_s = " AND (
				u.display_name LIKE '%$searchValue%' OR
				p.post_title LIKE '%$searchValue%'
			)";
		}

		//filtro
		if($filter){
			$filter_s = explode("-", $filter);
			$_s .= " AND ( MONTH(fecha) = '{$filter_s[1]}' AND YEAR(fecha) = '{$filter_s[0]}')";
		}

		///total
		$totalRecords = $wpdb->get_var(
			"SELECT
            	count(*)
            FROM
            	$camp_bookings_top
        	"
       	);

		//total filtrado
        $totalRecordwithFilter = $wpdb->get_var(
        	"SELECT
                COUNT(*)
            FROM
               $camp_bookings_top as f
            LEFT JOIN $post as p ON p.ID = f.id_camp
            LEFT JOIN $users as u ON u.ID = f.id_gest_camp
            WHERE
                1 = 1
                $_s
        	"
        );

        $extra = "";
    	switch ($columnName) {
    		case 'id': $extra .= " order by f.id_orden $columnSortOrder limit $row,$rowperpage"; break;
    		case 'campamento': $extra .= " order by p.post_title $columnSortOrder limit $row,$rowperpage"; break;
    		case 'fecha': $extra .= " order by f.fecha $columnSortOrder limit $row,$rowperpage"; break;
    		case 'cliente': $extra .= " order by f.fullname $columnSortOrder limit $row,$rowperpage"; break;
    		case 'plazas': $extra .= " order by f.plazas $columnSortOrder limit $row,$rowperpage"; break;
    		case 'empresa': $extra .= " order by u.display_name $columnSortOrder limit $row,$rowperpage"; break;
    		case 'comision': $extra .= " order by f.precio $columnSortOrder limit $row,$rowperpage"; break;
    		default: $extra .= " order by f.fecha DESC"; break;
    	}

    	$_q = "SELECT
    		f.id_orden as id,
            DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
            f.fullname as cliente,
            f.plazas,
        	f.precio,
        	u.display_name as empresa,
        	p.post_title as campamento
        FROM
           $camp_bookings_top as f
        LEFT JOIN $post as p ON p.ID = f.id_camp
        LEFT JOIN $users as u ON u.ID = f.id_gest_camp
        WHERE
            1 = 1
            $_s
        	$extra
        ";

        $r =  array(
			"draw" => intval($draw),
		  	"iTotalRecords" => (int)$totalRecords,
		  	"iTotalDisplayRecords" => (int)$totalRecordwithFilter,
		  	"aaData" => $wpdb->get_results($_q)
		);

	}

	if(isset($_REQUEST['reserva']) && $_REQUEST['reserva'] == '_look_'){
		global $wpdb;
		$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
		$post = $wpdb->prefix . 'posts';
		$users = $wpdb->prefix . 'users';
		$user_id = get_current_user_id();

		$draw = $_POST['draw'];
		$row = $_POST['start'];
		$rowperpage = $_POST['length'];
		$columnIndex = $_POST['order'][0]['column'];
		$columnName = $_POST['columns'][$columnIndex]['data'];
		$columnSortOrder = $_POST['order'][0]['dir'];
		$searchValue = esc_sql($_POST['search']['value']);
		$filter = $_POST['filter'];

		//busqueda
		$_s = "";
		if($searchValue != ""){
			$_s = " AND (
				f.fullname LIKE '%$searchValue%' OR
				p.post_title LIKE '%$searchValue%'
			)";
		}

		// filtro
		if(is_array($filter)){
			if(isset($filter['camp']) && $filter['camp']){
				$camp = (int)$filter['camp'];
				$_s .= " AND f.id_camp = '{$camp}'";
			}else if(isset($filter['fecha1']) && isset($filter['fecha2']) && $filter['fecha1'] && $filter['fecha2']){
				$dt1 = sanitize_text_field($filter['fecha1']);
				$dt2 = sanitize_text_field($filter['fecha2']);
				$dt1 = date("Y-m-d", strtotime($dt1));
				$dt2 = date("Y-m-d", strtotime($dt2));
				$_s .= " AND f.fecha BETWEEN '{$dt1}' AND '{$dt2}'";
			}
			
		}

		///total
		$totalRecords = $wpdb->get_var(
			"SELECT
            	count(*)
            FROM
            	$camp_bookings_top
			WHERE
				id_gest_camp = '{$user_id}'"
       	);

		//total filtrado
        $totalRecordwithFilter = $wpdb->get_var(
        	"SELECT
                COUNT(*)
            FROM
               $camp_bookings_top as f
            LEFT JOIN $post as p ON p.ID = f.id_camp
            WHERE
				id_gest_camp = '{$user_id}'
                $_s"
        );

        $extra = "";
    	switch ($columnName) {
    		case 'id': $extra .= " order by f.id_orden $columnSortOrder limit $row,$rowperpage"; break;
    		case 'campamento': $extra .= " order by p.post_title $columnSortOrder limit $row,$rowperpage"; break;
    		case 'fecha': $extra .= " order by f.fecha $columnSortOrder limit $row,$rowperpage"; break;
    		case 'plazas': $extra .= " order by f.plazas $columnSortOrder limit $row,$rowperpage"; break;
    		case 'usuario': $extra .= " order by f.fullname $columnSortOrder limit $row,$rowperpage"; break;
    		case 'total': $extra .= " order by f.precio $columnSortOrder limit $row,$rowperpage"; break;
    		default: $extra .= " order by f.fecha DESC"; break;
    	}

    	$_q = "SELECT
    		f.id_orden as id,
            DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
            f.plazas,
        	f.precio,
        	f.fullname as usuario,
        	p.post_title as campamento,
			f.comision
			FROM
			$camp_bookings_top as f
			LEFT JOIN $post as p ON p.ID = f.id_camp
			WHERE
            id_gest_camp = '{$user_id}'
            $_s
        	$extra
        ";

        $r =  array(
			"draw" => intval($draw),
		  	"iTotalRecords" => (int)$totalRecords,
		  	"iTotalDisplayRecords" => (int)$totalRecordwithFilter,
		  	"aaData" => $wpdb->get_results($_q),
			"query"	=> $_q,
		);

	}

	if(isset($_REQUEST['dltCamp']) && $_REQUEST['dltCamp'] == 1){
		$camp = $_REQUEST['camp'];
		$camp_data = array(
			'ID'          => $camp,
			'post_status' => 'draft',
		);
		$process = wp_update_post($camp_data);
		if($process && !is_wp_error($process)){
			$r['r'] = true;
			$r['m'] = '¡Campamento eliminado con exito!';
		}else{
			$r['m'] = 'Ha ocurrido un error al intentar eliminar el campamento '.get_the_title($camp).'. Por favor intentelo de nuevo más tarde.';
		}
	}

	if(isset($_REQUEST['buyPck']) && $_REQUEST['buyPck'] == 1){
		$camp_id = $_REQUEST['camp'];
		$difer = $_REQUEST['difer'];
		$product = [
			'certify' 		=> 2693,
			'visibility' 	=> 2695,
		];
		$plan = $product[$difer];
		$variation = ['camp' => $camp_id];
		if($difer == 'visibility'){
			$destc_plan = get_post_meta($camp_id, 'venc_camp_dest_30', true);
			if($destc_plan && time() < $destc_plan){
				$r['m'] = 'Tu campamento ya cuenta con este plan, desbes esperar el plazo de 30 días para adquirirlo de nuevo.';
				echo json_encode($r);
				die();
			}else{
				$camp_act = get_post_meta($camp_id, 'actividades', true);
				$meta_product = get_post_meta($plan, 'activity_desc_plan', true);
				$metadata_TOP_ajax_trat = array();
				if($meta_product){
					$metadata_TOP_ajax_trat = $meta_product;
					if($metadata_TOP_ajax_trat[$camp_act] <= 10){
						$metadata_TOP_ajax_trat[$camp_act] += 1;
					}else{
						$r['m'] = '¡Ups! Parece que este plan ha sido muy popular y ya no quedan más cupos disponibles. Pero no te preocupes, inténtalo de nuevo en unos días.';
						echo json_encode($r);
						die();
					}
				}else{
					global $wpdb;
					$tabla = $wpdb->prefix . 'jet_post_types';
					$metadata_TOP_ajax = $wpdb->get_var("SELECT meta_fields FROM $tabla WHERE slug='topcampamentos'");
					$metadata_TOP_ajax = unserialize($metadata_TOP_ajax);
					foreach($metadata_TOP_ajax as $k => $v){
						if($v['name'] == "actividades"){
							foreach($v['options'] as $ac){
								$metadata_TOP_ajax_trat[$ac['key']] = ($ac['key'] == $camp_act) ? 1: 0;
							}
						}
					}
				}
			}
			$metadata_TOP_ajax_trat = serialize($metadata_TOP_ajax_trat);
			$variation['actividades'] = $metadata_TOP_ajax_trat;
		}else{
			if(get_post_meta($camp_id, 'certify_by_TOP', true)){
				$r['m'] = 'Tu campamento ya cuenta con este plan.';
				echo json_encode($r);
				die();
			}
		}

		WC()->cart->empty_cart();
		WC()->cart->add_to_cart($plan, 1, 0, $variation);
		WC()->cart->calculate_totals();
		WC()->cart->set_session();
		WC()->cart->maybe_set_cart_cookies();
		$r["r"] = true;
		$r["m"] = "agregado";
		$r["u"] = wc_get_checkout_url();
		
	}

	if(isset($_REQUEST['wishlist']) && $_REQUEST['wishlist'] == 'wishTOP' && wp_verify_nonce($_REQUEST['wishn'], 'wishlist')){
		$camp_id = $_REQUEST['camp_id'];
		$act = $_REQUEST['act'];
		$user_id = get_current_user_id();
		$inx = 0;
		$meta = get_user_meta($user_id, 'wishlist_user_TOP', true);
		if($act == 'nadd'){
			if($meta){
				if(is_serialized($meta)) unserialize($meta);
				foreach($meta as $cid){
					if(get_post_status($camp_id) == 'publish'){
						$meta[] = $camp_id;
					}
				}
			}else{
				$meta = array($camp_id);
			}
			$meta = array_unique($meta);
			if(!update_user_meta($user_id, 'wishlist_user_TOP', $meta)){
				$r['m'] = 'Lamentablemente, no pudimos agregar el campamento '.get_the_title($camp_id).' a tu lista de deseos en este momento. Por favor, intenta nuevamente más tarde.';
			}else{
				$inx = (count($meta)) ? count($meta) : 0;
				$r['r'] = true;
				$r['m'] = 'Campamento agregado!';
				$r['inx'] = $inx;
			}
		}else{
			if($meta){
				if(is_serialized($meta)) unserialize($meta);
				unset($meta[array_search($camp_id, $meta)]);
				if(!update_user_meta($user_id, 'wishlist_user_TOP', $meta)){
					$r['m'] = 'Lamentablemente, no pudimos eliminar el campamento '.get_the_title($camp_id).' de tu lista de deseos en este momento. Por favor, intenta nuevamente más tarde.';
				}else{
					$inx = (count($meta)) ? count($meta): 0;
					$r['r'] = true;
					$r['m'] = 'Campamento eliminado!';
					$r['rl'] = (empty($meta)) ? true: false;
					$r['inx'] = $inx;
				}
			}
		}
	}

}

echo json_encode($r);
die();

