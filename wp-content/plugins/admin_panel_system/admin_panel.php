<?php

/*
* Plugin Name: SP Admin
* Plugin URI: https://agenciasp.com
* Description: Panel administartivo
* Version: 1.1.0
* Author: Agencia Digital SP
* Author URI: https://agenciasp.com
* License:
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define('ADPNSY_VER', '1.1.0');
define('ADPNSY_PATH', realpath( dirname(__FILE__) ) );
define('ADPNSY_URL', plugins_url('/', __FILE__) );

require_once 'admin_license.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';

if ( class_exists('admin_panel_system')){
	class adpnsy extends admin_panel_system {
		public function __construct(){
			add_action('admin_menu', array($this, 'menu_register'));
			add_action('wp_ajax_admin_panel', array($this, 'ajax'));
			add_action('wp_ajax_nopriv_admin_panel', array($this, 'ajax'));
			register_nav_menu( 'admin_system' , __( 'SP menú administrador' , 'adpnsy' ) );
			register_nav_menu( 'perfil_admin_system' , __( 'SP menú perfil usuario' , 'adpnsy' ) );
			register_nav_menu( 'perfil_admin_system__admin' , __( 'SP menú perfil admin' , 'adpnsy' ) );
			add_action('woocommerce_before_calculate_totals', array($this, 'price_booking'), 99 );
			add_action('init', array($this,'startSession'));
			add_action('init', array($this,'custom_role'));
			add_action('show_user_profile', array($this,'custom_user_profile_fields'));
			add_action('edit_user_profile', array($this,'custom_user_profile_fields'));
			add_action('personal_options_update', array($this,'update_extra_profile_fields'));
			add_action('edit_user_profile_update', array($this,'update_extra_profile_fields'));
			add_shortcode('tags_camp_cpt', array($this, 'tags_camp_cpt_TOP'));
			add_shortcode('camp_booking_top', array($this, 'camp_buy_process_TOP'));
			add_shortcode('listing_camp_single', array($this, 'sh_listing_camp_single_TOP'));
			add_shortcode('camp_certify_TOP', array($this, 'camp_certify_TOP_cllbck'));
			add_shortcode('destc_listings_short', array($this, 'destc_listings_short_cllbck'));
			add_shortcode('list_wishlist_user', array($this, 'list_wishlist_user_cllbck'));
			add_shortcode('button_wishlist_TOP', array($this, 'button_wishlist_TOP_callback'));
			add_shortcode('footer_copyright_camp', array($this, 'footer_copyright_campcllbck'));
			add_shortcode('name_company_camp_pg', array($this, 'name_company_camp_pg_cllbck'));
			add_shortcode('activities_camps_2', array($this, 'activities_camps_2_cllbck'));
			add_shortcode('details_dates_top_fich_camp', array($this, 'details_dates_top_fich_camp_cllbck'));
			add_filter('woocommerce_account_menu_items', array($this, 'mis_mensajes'));
			add_filter('query_vars', array($this, 'mis_mensajes_query_vars'), 0);
			add_action('woocommerce_account_mensajes_endpoint', array($this, 'mis_mensajes_content' ));
			add_filter('woocommerce_my_account_my_orders_actions', array($this, 'agregar_boton_accion_pedido' ), 10, 2 );
			add_action('woocommerce_order_status_completed', array( $this, 'plazas_sale_booking'));
			add_action('woocommerce_cart_item_product', array($this, 'cart_item_product'), 99, 3 );
			add_action('woocommerce_checkout_process', array($this, 'before_checkout_TOP'), 10, 2);
			add_action('woocommerce_order_status_refunded', array($this, 'refound_booking_TOP'));
			add_shortcode('retting_coment', array($this, 'retting_coment_function'));
			add_shortcode('camps_pages_seo', array($this, 'camps_pages_seo_function'));
			add_shortcode('title_topbsnss', array($this, 'title_topbsnss_function'));
			add_shortcode('camps_topbsnss', array($this, 'camps_topbsnss_function'));
			add_filter('woocommerce_order_item_get_formatted_meta_data', array($this, 'hide_data_no_client'), 10, 2);
			add_filter( 'woocommerce_cart_item_remove_link', array($this, 'cart_item_remove_link'), 99, 2 );
			add_action('user_register', array($this, 'send_verify_activation'), 10, 2);
			add_action('init', array($this, 'verify_activation_user_cllbck'));
			add_filter('woocommerce_process_login_errors', array($this, 'validate_to_login_TOP'), 99, 3);
			add_filter('woocommerce_registration_redirect', array($this, 'desconect_register_TOP'), 10, 1 );
			add_action('woocommerce_checkout_order_processed', array($this, 'stripe_procesing_TOP'), 10, 3);
			add_action('init', array($this, 'remove_capabilities_camps'));
			add_action('admin_init', array($this, 'restrict_wp_admin'));
			add_filter('woocommerce_before_order_notes', array($this, 'form_tutor_kids_TOP'));
			add_filter('woocommerce_billing_fields', array($this, 'dni_responsible_TOP'));
			add_action('woocommerce_review_order_before_submit', array($this, 'add_checks_responsible_TOP'));
			add_action('woocommerce_checkout_process', array($this, 'check_the_checks_TOP'));
			add_action('woocommerce_new_order', array($this, 'save_form_tutor_kids_TOP'));
			self::init();
		}

		public function retting_coment_function(){

			global $wpdb;
			$jet_reviews = $wpdb->prefix . "jet_reviews";
			$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
			$user = get_current_user_id();
			$source_id = get_the_ID();
			$opiniones = (int)$wpdb->get_var("SELECT COUNT(id) FROM $jet_reviews WHERE author = {$user} AND post_id = {$source_id}");
			$compras = $wpdb->get_results("SELECT fechas_reserva FROM $camp_bookings_top WHERE id_user = {$user} AND id_camp = {$source_id}");
			$compras_consumida = 0;
			$fecha_a = time();
			if(is_array($compras) && !empty($compras)) foreach($compras as $c){
				$fechas = explode(" | ", $c->fechas_reserva);
				$fecha_f = explode('/', $fechas[1]);
				$fecha_f = strtotime("{$fecha_f[2]}-{$fecha_f[1]}-{$fecha_f[0]}");
				if ($fecha_a > $fecha_f) {
					$compras_consumida++;
				}
			} 
			if($opiniones < $compras_consumida){
				return do_shortcode('[elementor-template id="2572"]');
			}

			return "";
			
		}

		public function agregar_boton_accion_pedido( $actions, $order ) {
		    $actions['new_mensaje'] = array(
		        'url'  => '#_' .  $order->get_id(),
		        'name' => __( 'Enviar mensaje', 'adpnsy' ),
		    );

		    return $actions;
		}

		public function mis_mensajes( $tabs ) {
		    $tabs['mensajes'] = __( 'Mensajes', 'adpnsy' );
		    return $tabs;
		}

		public function mis_mensajes_query_vars( $vars ) {
		    $vars[] = 'mensajes';
		    return $vars;
		}
		  
		public function mis_mensajes_content() { 
			global $wpdb;
			$top_mensajes = $wpdb->prefix . "top_mensajes";
			$user = get_current_user_id();

			if(isset($_GET['id_m']) && is_numeric($_GET['id_m'])){
				$id = (int)$_GET['id_m'];
				$mensaje = $wpdb->get_row("SELECT * FROM $top_mensajes WHERE user= '$user' AND padre = 0 AND id='$id'");
				if($mensaje){ 

					///nuevo mensaje
					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						if(isset($_POST['msg_text']) && trim($_POST['msg_text'])){
							$nm = [
								"message"		=> sanitize_text_field(trim($_POST['msg_text'])),
								"user"			=> $user,
								"campamento"	=> $mensaje->campamento,
								"padre"			=> $mensaje->id
							];
							if($wpdb->insert($top_mensajes, $nm) !== false){
								global $info;
								$post_id = $mensaje->campamento;
								$author_id = get_post_field( 'post_author', $post_id );
								$mail = $author_id ? get_the_author_meta( 'user_email', $author_id ) : get_option("admin_email");
								$nombre = $author_id ? get_the_author_meta( 'display_name', $author_id ) : 'Administrador';
								$url = get_option( "siteurl" ) . "/registro-campamentos/?ingresar";
								$_data = [
									"nombre" => $nombre,
									"mensaje" => "Hola $nombre,<br><br>Tienes un nuevo mensaje, para leerlo y responder por favor ingrese a <a target='_blank' href='$url'>este enlaces</a><br><br><br>Si no puedes acceder al enlace prueba copiar y pegar esta URL en tu navegador $url"
								];
								$this->mail($mail, __("Nuevo mensaje en TOP Campamentos", 'adpnsy'), "notificacion", $_data, $info);
								$wpdb->update($top_mensajes, ["estado" => 0], ["id" => $mensaje->id]);
								$mensaje->estado = 0;
							}
						}
					}

					$mensajes = $wpdb->get_results("SELECT message, fecha, user FROM $top_mensajes WHERE padre = {$mensaje->id} ORDER BY fecha ASC");
					?>
					<link rel="stylesheet" id="dashicons-css" href="<?=ADPNSY_URL;?>/css/mensaje_items.css" media="all">
					<div class="msg-box">
						<div class="msg-head">
							<label class="msd-item">Fecha:<span><?=date("d/m/Y", strtotime($mensaje->fecha));?></span></label>
							<label class="msd-item">Campamento:<span><?=get_the_title($mensaje->campamento) ?? "---";?></span></label>
							<label class="msd-item">Asunto:<span><?=$mensaje->orden ? __("Información de la orden #",'adpnsy') . $mensaje->orden : __("Información del campamento",'adpnsy'); ?></span></label>
							<label class="msd-item">Estado:<span><?=$mensaje->estado == 0 ? __('Enviado','adpnsy') : '';?><?=$mensaje->estado == 1 ? __('Leído','adpnsy') : '';?><?=$mensaje->estado == 2 ? __('Respondido','adpnsy') :'';?></span></label>
						</div>
						<div class="msg-hist">
							<p class="msg-text msg-user"><?=$mensaje->message;?><span><?=date("H:i d/m/Y", strtotime($mensaje->fecha));?></span></p>
							<?php if(count($mensajes)) foreach($mensajes as $m){ ?>
								<p class="msg-text <?=$m->user == $user ? 'msg-user' : 'msg-campamento' ?>"><?=$m->message?><span><?=date("H:i d/m/Y", strtotime($m->fecha));?></span></p>
							<?php } ?>
						</div>
						<form action="#" method="post" class="msg-n-mensaje">
							<input type="text" class="msg-n-text" name="msg_text" placeholder="Escriba su mensaje" required />
							<input type="submit" class="msg-n-send" value="Enviar" />
						</form>
					</div>
					<script type="text/javascript">
						const element = jQuery(".msg-hist")[0]; 
						element.scrollTop = element.scrollHeight;
						if (window.history.replaceState) {
						    window.history.replaceState(null, null, window.location.href);
						}
					</script>
				<?php }else{
					echo "<p>".__('Mensaje no encontrado.','adpnsy')."</p>";
				}
			}else{
				$mensajes = $wpdb->get_results("SELECT id, campamento, estado, fecha, orden FROM $top_mensajes WHERE user= '$user' AND padre = 0 ORDER BY fecha DESC"); ?>
				<link rel="stylesheet" id="dashicons-css" href="<?=ADPNSY_URL;?>/css/mensaje_tabla.css" media="all">
			    <table class="shop_table shop_table_responsive woocommerce-orders-table">
					<thead>
						<tr>
							<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Fecha</span></th>
							<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Campamento</span></th>
							<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Asunto</span></th>
							<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Estado</span></th>
							<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"></th>
						</tr>
					</thead>

					<tbody>
						<?php if(count($mensajes)){ foreach($mensajes as $m){ ?>
							<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-cancelled order">
								<td class="woocommerce-orders-table__cell"><?=date("d/m/Y", strtotime($m->fecha));?></td>
								<td class="woocommerce-orders-table__cell"><?=get_the_title($m->campamento);?></td>
								<td class="woocommerce-orders-table__cell"><?=$m->orden ? __("Información de la orden #",'adpnsy') . $m->orden : __("Información del campamento",'adpnsy'); ?></td>
								<td class="woocommerce-orders-table__cell">
									<?=$m->estado == 0 ? __('Enviado','adpnsy') : '';?>
									<?=$m->estado == 1 ? __('Leído','adpnsy') : '';?>
									<?=$m->estado == 2 ? __('Respondido','adpnsy') :'';?>
								</td>
								<td class="woocommerce-orders-table__cell"><a href="<?=get_option( "siteurl" )?>/mi-cuenta/mensajes/?id_m=<?=$m->id;?>" class="woocommerce-button wp-element-button button view">Ver</a></td>
							</tr>
						<?php } }else{ ?>
							<tr><td colspan="5" class="center"><?=__('Sin mensajes','adpnsy')?></td></tr>
						<?php } ?>
					</tbody>
				</table>
			<?php }
		}

		public function menu_register() {
			add_submenu_page('options-general.php', 'SP Admin', 'SP Admin', 'manage_options', 'panel_admin_system', array($this, 'admin'), 20); 
		}

		public function notificacion(){
			$n = '';
			$c = 0;
			$t = 0;

			////Mensajes
			global $wpdb;
			$top_mensajes = $wpdb->prefix . "top_mensajes";
			$user = get_current_user_id();
			$args = array(
			    'post_type' => 'topcampamentos',
			    'posts_per_page' => -1,
			    'author' => $user,
			    'fields' => 'ids'
			);

			$post_ids = get_posts( $args );

			if($post_ids){
				$nuevos = 0;
				$pendientes = $wpdb->get_results("SELECT campamento, estado, COUNT(id) AS cant 
					FROM $top_mensajes 
					WHERE estado < 2 AND padre = 0 AND campamento IN (".implode(",", $post_ids).") 
					GROUP BY campamento, estado 
					ORDER BY estado ASC"
				);
				if(count($pendientes)) foreach($pendientes as $i => $p){
					$t += $p->cant;
					if($p->estado == 0){
						$c += $p->cant;
						$n .= "<li tabindex='{$i}'>
							<a class='black-text' href='".get_site_url()."/mis-mensajes'>
								<span class='material-icons icon-bg-circle orange'>forum</span> 
								<p>Tienes {$p->cant} mensaje(s) por leer<br>Campamento: \"" . get_the_title($p->campamento) . "\"</p>
							</a>
						</li>";
					}else{
						$n .= "<li tabindex='{$i}'>
							<a class='black-text' href='".get_site_url()."/mis-mensajes'>
								<span class='material-icons icon-bg-circle gray'>chat_bubble</span> 
								<p>Tienes {$p->cant} mensaje(s) por responder<br>Campamento: \"" . get_the_title($p->campamento) . "\"</p>
							</a>
						</li>";
					}
				}
			}

			return [
				"n" => ($n == '') ? '<li tabindex="0">Sin notificaciones nuevas</li>' : $n,
				"c" => ($c > 0) ? '<small class="notification-badge orange accent-3">'.$c.'</small>' : '',
				"t" => ($t > 0) ? '<span class="new badge">'.$t.'</span>' : '',
			];
		}

		public function ajax(){
			include 'admin_ajax.php';
		}

		public function install(){

			//Pages
			$login_ar = array("post_title" => "Login", "post_status" => "publish", "post_type" => "page");
			$login = wp_insert_post($login_ar);
			update_post_meta( $login, '_wp_page_template', 'admin_login.php' );

			$dashboard_ar = array("post_title" => "Dashboard", "post_status" => "publish", "post_type" => "page");
			$dashboard = wp_insert_post($dashboard_ar);
			update_post_meta( $dashboard, '_wp_page_template', 'admin_dashboard.php' );

			$recovery_ar = array("post_title" => "Recuperar Contraseña", "post_status" => "publish", "post_type" => "page");
			$recovery = wp_insert_post($recovery_ar);
			update_post_meta( $recovery, '_wp_page_template', 'admin_recovery.php' );

			$register_ar = array("post_title" => "Registro", "post_status" => "publish", "post_type" => "page");
			$register = wp_insert_post($register_ar);
			update_post_meta( $register, '_wp_page_template', 'admin_register.php' );

			$logout_ar = array("post_title" => "Salir", "post_status" => "publish", "post_type" => "page");
			$logout = wp_insert_post($logout_ar);
			update_post_meta( $logout, '_wp_page_template', 'admin_logout.php' );

			$perfil_ar = array("post_title" => "Perfil", "post_status" => "publish", "post_type" => "page");
			$perfil = wp_insert_post($perfil_ar);
			update_post_meta( $perfil, '_wp_page_template', 'admin_perfil.php' );

			$opciones = json_decode('{
				"titulo":"SP Admin",
				"description":"Instación basica de SP Admin",
				"autor":"Santiago Ponce",
				"logo":"'.ADPNSY_URL.'\/app-assets\/img\/logo_c.png",
				"logo_vn":"0",
				"logo_blanco":"'.ADPNSY_URL.'\/app-assets\/img\/logo_b.png",
				"logo_blanco_vn":"0",
				"logo_texto":"Santiago Ponce",
				"icon_apple":"'.ADPNSY_URL.'\/app-assets\/img\/logo.png",
				"icon_apple_vn":"0",
				"favicon":"'.ADPNSY_URL.'\/app-assets\/img\/logo_c.png",
				"favicon_vn":"0",
				"bglogin_vn":"'.ADPNSY_URL.'\/app-assets\/img\/login.jpg",
				"bglogin":"0",
				"lglogin_vn":"'.ADPNSY_URL.'\/app-assets\/img\/logo.png",
				"lglogin":"0",
				"login":"'.$dashboard.'",
				"Register":"'.$register.'",
				"Recovery":"'.$recovery.'",
				"Politicas":"",
				"botton_fondo":"red",
				"botton_tono":"darken-1",
				"botton_color":"white-text",
				"botton_color_t":"",
				"demo":"1"
			}');

			$menu_Admin_id = wp_create_nav_menu("SP Admin menu");
			$menu_User_id = wp_create_nav_menu("SP Admin menu user");
			wp_update_nav_menu_item($menu_Admin_id, 0, array(
		        'menu-item-title' => 'Dashboard',
			    'menu-item-object-id' => $dashboard,
			    'menu-item-object' => 'page',
			    'menu-item-status' => 'publish',
			    'menu-item-type' => 'post_type',
			));
			wp_update_nav_menu_item($menu_User_id, 0, array(
		        'menu-item-title' => 'Perfil',
			    'menu-item-object-id' => $perfil,
			    'menu-item-object' => 'page',
			    'menu-item-status' => 'publish',
			    'menu-item-type' => 'post_type',
			));
			wp_update_nav_menu_item($menu_User_id, 0, array(
		        'menu-item-title' => 'Salir',
			    'menu-item-object-id' => $logout,
			    'menu-item-object' => 'page',
			    'menu-item-status' => 'publish',
			    'menu-item-type' => 'post_type',
			));

			$locations['admin_system'] = $menu_Admin_id;
			$locations['perfil_admin_system'] = $menu_User_id;        	
        	set_theme_mod( 'nav_menu_locations', $locations );

			return $opciones;
		}

		public function list_event($despues, $antes, $log = false){
			require_once 'mws/index.php';
			return __list_event(date(DATE_FORMAT, $despues), date(DATE_FORMAT, $antes), $log);
		}

		public function startSession() {
			add_rewrite_endpoint( 'mensajes', EP_ROOT | EP_PAGES );
		    if(!session_id()) {
		        session_start();
		    }
		}

		public function productos(){
			if(isset($_GET['delete'])){
				global $wpdb;
				$inv_productos = $wpdb->prefix . "inv_productos";
				$inv_transacciones = $wpdb->prefix . "inv_transacciones";
				$_id = sanitize_key($_GET['delete']);
				$_sku = $wpdb->get_var("SELECT sku FROM $inv_productos WHERE id = '$_id';");
				$_p = $wpdb->get_var("SELECT count(*) FROM $inv_transacciones WHERE sku = '$_sku';");
				if($_p == 0){
					if($wpdb->delete($inv_productos, ["id" => $_id]) !== false){
						$_SESSION['eliminar_producto'] = true;
					}else{
						$_SESSION['eliminar_producto'] = false;
					}
				}else{
					$_SESSION['eliminar_producto2'] = true;
				}
				echo "<script>location.href='".remove_query_arg('delete')."'</script>";
				exit;
				
			}

			if(isset($_GET['asignar'])){
				global $wpdb;
				$inv_productos = $wpdb->prefix . "inv_productos";
				$inv_operaciones = $wpdb->prefix . "inv_operaciones";

				$_idp = sanitize_key($_GET['asignar']);

				$_pr = $wpdb->get_row("SELECT * FROM $inv_productos WHERE id='$_idp'", ARRAY_A);
				if($_pr){
					$_operaciones = $wpdb->get_results("SELECT * FROM $inv_operaciones WHERE user='0' AND sku='$_pr[sku]'", ARRAY_A);
					$_p = 0;
					$_e = 0;
					foreach($_operaciones as $_operacion){
						if(!$_operacion["devolucion"]){
							$_operacion["beneficio"] = $_pr["beneficio"];
							$_operacion["user"] = $_pr["user"];
							$_operacion["compra"] = $_operacion["cantidad"] * $_pr['pdc_siva'];
							$_operacion["inversion"] = $_operacion["cantidad"] * $_pr['coste'];
							$_operacion["beneficio_total"] = $_operacion["base"] + $_operacion["fba"] + $_operacion["amz"] - ( $_operacion["cantidad"] * ($_pr['pdc_siva'] + $_pr['preparacion'] + $_pr['otros'] + $_pr['transporte']));
							$_operacion["beneficio_user"] = number_format((($_operacion["beneficio_total"]/100)*$_pr['beneficio']),2,".","");
							$_operacion["margen"] = number_format(($_operacion["beneficio_total"]/($_operacion["base"]+$_operacion["iva"]))* 100,0,".","");
							$_operacion["margen_user"] = number_format((($_operacion["margen"]/100)*$_pr['beneficio']), 0,".","");
							$_operacion["roi"] = number_format(($_operacion["beneficio_total"]/$_operacion["inversion"])* 100,0,".","");
							$_operacion["roi_user"] = number_format((($_operacion["roi"]/100)*$_pr['beneficio']), 0,".","");
						}else{
							$_operacion["beneficio"] = $_pr["beneficio"];
							$_operacion["user"] = $_pr["user"];
							$_operacion["beneficio_user"] = number_format((($_operacion["beneficio_total"]/100)*$_pr['beneficio']),2,".","");
						}
						if($wpdb->replace($inv_operaciones, $_operacion) !== false){
							$_p++;
						}else{
							$_e++;
						}
					}
					if($_p > 0 || $_e > 0){
						$_SESSION['asignar_producto'] = 1;
						$_SESSION['asignar_producto_exito'] = $_p;
						$_SESSION['asignar_producto_error'] = $_e;
					}else{
						$_SESSION['asignar_producto'] = 0;
					}
				}else{
					$_SESSION['asignar_producto'] = -1;
				}
				echo "<script>location.href='".remove_query_arg('asignar')."'</script>";
				exit;
			}

			if(isset($_GET['asignar_todos'])){
				global $wpdb;
				$inv_productos = $wpdb->prefix . "inv_productos";
				$inv_operaciones = $wpdb->prefix . "inv_operaciones";

				$_idp = sanitize_key($_GET['asignar_todos']);

				$_pr = $wpdb->get_row("SELECT * FROM $inv_productos WHERE id='$_idp'", ARRAY_A);
				if($_pr){
					$_operaciones = $wpdb->get_results("SELECT * FROM $inv_operaciones WHERE sku='$_pr[sku]'", ARRAY_A);
					$_p = 0;
					$_e = 0;
					foreach($_operaciones as $_operacion){
						if(!$_operacion["devolucion"]){
							$_operacion["beneficio"] = $_pr["beneficio"];
							$_operacion["user"] = $_pr["user"];
							$_operacion["compra"] = $_operacion["cantidad"] * $_pr['pdc_siva'];
							$_operacion["inversion"] = $_operacion["cantidad"] * $_pr['coste'];
							$_operacion["beneficio_total"] = $_operacion["base"] + $_operacion["fba"] + $_operacion["amz"] - ( $_operacion["cantidad"] * ($_pr['pdc_siva'] + $_pr['preparacion'] + $_pr['otros'] + $_pr['transporte']));
							$_operacion["beneficio_user"] = number_format((($_operacion["beneficio_total"]/100)*$_pr['beneficio']),2,".","");
							$_operacion["margen"] = number_format(($_operacion["beneficio_total"]/($_operacion["base"]+$_operacion["iva"]))* 100,0,".","");
							$_operacion["margen_user"] = number_format((($_operacion["margen"]/100)*$_pr['beneficio']), 0,".","");
							$_operacion["roi"] = number_format(($_operacion["beneficio_total"]/$_operacion["inversion"])* 100,0,".","");
							$_operacion["roi_user"] = number_format((($_operacion["roi"]/100)*$_pr['beneficio']), 0,".","");
						}else{
							$_operacion["beneficio"] = $_pr["beneficio"];
							$_operacion["user"] = $_pr["user"];
							$_operacion["beneficio_user"] = number_format((($_operacion["beneficio_total"]/100)*$_pr['beneficio']),2,".","");
						}
						if($wpdb->replace($inv_operaciones, $_operacion) !== false){
							$_p++;
						}else{
							$_e++;
						}
					}
					if($_p > 0 || $_e > 0){
						$_SESSION['asignar_producto'] = 1;
						$_SESSION['asignar_producto_exito'] = $_p;
						$_SESSION['asignar_producto_error'] = $_e;
					}else{
						$_SESSION['asignar_producto'] = 0;
					}
				}else{
					$_SESSION['asignar_producto'] = -1;
				}
				echo "<script>location.href='".remove_query_arg('asignar_todos')."'</script>";
				exit;
			}

			if(isset($_SESSION['eliminar_producto'])){
				if($_SESSION['eliminar_producto'] == true){
					echo "<div class='notice notice-success is-dismissible'><p>Se elimino el producto</p></div>";
				}else{
					echo "<div class='notice notice-error is-dismissible'><p>No se pudo eliminar el producto</p></div>";
				}
				unset($_SESSION['eliminar_producto']);
			}

			if(isset($_SESSION['eliminar_producto2'])){
				echo "<div class='notice notice-error is-dismissible'><p>Este producto ya posee transacciones no se puede eliminar</p></div>";
				unset($_SESSION['eliminar_producto2']);
			}

			if(isset($_SESSION['asignar_producto'])){
				if($_SESSION['asignar_producto'] == 1){
					echo "<div class='notice notice-success is-dismissible'><p>Se Asignaron $_SESSION[asignar_producto_exito] operación(es) al usuario con $_SESSION[asignar_producto_error] error(es)</p></div>";
				}elseif($_SESSION['asignar_producto'] == -1){
					echo "<div class='notice notice-error is-dismissible'><p>No se encontraron el producto</p></div>";
				}else{
					echo "<div class='notice notice-error is-dismissible'><p>No se encontraron operaciones</p></div>";
				}
				unset($_SESSION['asignar_producto']);
				unset($_SESSION['asignar_producto_exito']);
				unset($_SESSION['asignar_producto_error']);
			}

			require_once 'inc/tabla.php';
            $lista = new listar_productos();
            $lista->prepare_items();
            ?>
            	<style type="text/css">.column-ventas, .column-devoluciones, .column-beneficio { width: 100px; }</style>
            	<div class="wrap">
	                <div id="icon-users" class="icon32"></div>
	                <h1 class="wp-heading-inline">Productos</h1>
	                <form action="" method="GET">
	                    <p class="search-box">
	                      <label class="screen-reader-text" for="search-box-id-search-input">Buscar:</label>
	                      <input type="text" id="search-box-id-search-input" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : ''; ?>">
	                      <input type="submit" id="search-submit" class="button" value="Buscar">
	                    </p>
	                    <input type="hidden" name="page" value="<?=esc_attr($_REQUEST['page']);?>"/>
	                </form>
	                <form id="productos_bulk" method="post">
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

		public function producto(){
			include "inc/producto.php";
		}

		public function importar(){
			include "inc/importador.php";
		}

		public function retiros(){

			if(isset($_GET['pagar'])){
				global $wpdb;
				$inv_transacciones = $wpdb->prefix . "inv_transacciones";
				$id = sanitize_key($_GET['pagar']);
				$estado = 1;

				if($wpdb->update($inv_transacciones, ["estado" => $estado], ["id" => $id]) !== false ){
					$_SESSION['exito'] = true;
				}else{
					$_SESSION['error'] = true;
				}
				
				echo "<script>location.href='".remove_query_arg('pagar')."'</script>";
				exit;
			}

			if(isset($_GET['espera'])){
				global $wpdb;
				$inv_transacciones = $wpdb->prefix . "inv_transacciones";
				$id = sanitize_key($_GET['espera']);
				$estado = 0;

				if($wpdb->update($inv_transacciones, ["estado" => $estado], ["id" => $id]) !== false ){
					$_SESSION['exito'] = true;
				}else{
					$_SESSION['error'] = true;
				}
				
				echo "<script>location.href='".remove_query_arg('espera')."'</script>";
				exit;
			}

			if(isset($_GET['cancelar'])){
				global $wpdb;
				$inv_transacciones = $wpdb->prefix . "inv_transacciones";
				$id = sanitize_key($_GET['cancelar']);
				$estado = 2;

				if($wpdb->update($inv_transacciones, ["estado" => $estado], ["id" => $id]) !== false ){
					$_SESSION['exito'] = true;
				}else{
					$_SESSION['error'] = true;
				}
				
				echo "<script>location.href='".remove_query_arg('cancelar')."'</script>";
				exit;
			}


			if(isset($_SESSION['exito'])){
				echo "<div class='notice notice-success is-dismissible'><p>Se cambio el estado</p></div>";
				unset($_SESSION['exito']);
			}

			if(isset($_SESSION['error'])){
				echo "<div class='notice notice-error is-dismissible'><p>Error al cambiar estado</p></div>";
				unset($_SESSION['error']);
			}			

			require_once 'inc/tabla_retiros.php';
            $lista = new listar_productos();
            $lista->prepare_items();
            ?>
            	<div class="wrap">
	                <div id="icon-users" class="icon32"></div>
	                <h1 class="wp-heading-inline">Solicitud de retiro</h1>
	                <form action="" method="GET">
	                    <p class="search-box">
	                      <label class="screen-reader-text" for="search-box-id-search-input">Buscar:</label>
	                      <input type="text" id="search-box-id-search-input" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : ''; ?>">
	                      <input type="submit" id="search-submit" class="button" value="Buscar">
	                    </p>
	                    <?php if(isset($_GET['st']) && $_GET['st']) echo "<input type='hidden' name='st' value='$_GET[st]' />"; ?>
	                    <?php if(isset($_GET['us']) && $_GET['us']) echo "<input type='hidden' name='us' value='$_GET[us]' />"; ?>
	                    <input type="hidden" name="page" value="<?=esc_attr($_REQUEST['page']);?>"/>
	                </form>
	                <?php 
	                    $page  = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );
	                    $paged = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );
	                    printf( '<input type="hidden" name="page" value="%s" />', $page );
	                    printf( '<input type="hidden" name="paged" value="%d" />', $paged );
	                    $lista->display();
	                  ?>
              </div>
            <?php
		}

		public function depositos(){

			if(isset($_GET['delete'])){
				global $wpdb;
				$inv_transacciones = $wpdb->prefix . "inv_transacciones";
				$id = sanitize_key($_GET['delete']);
				$estado = 1;

				if($wpdb->update($inv_transacciones, ["estado" => $estado], ["id" => $id]) !== false ){
					$_SESSION['exito'] = true;
				}else{
					$_SESSION['error'] = true;
				}
				
				echo "<script>location.href='".remove_query_arg('delete')."'</script>";
				exit;
			}


			if(isset($_SESSION['exito'])){
				echo "<div class='notice notice-success is-dismissible'><p>Se elimino el deposito</p></div>";
				unset($_SESSION['exito']);
			}

			if(isset($_SESSION['error'])){
				echo "<div class='notice notice-error is-dismissible'><p>Error al eliminar deposito</p></div>";
				unset($_SESSION['error']);
			}			

			require_once 'inc/tabla_depositos.php';
            $lista = new listar_productos();
            $lista->prepare_items();
            ?>
            	<div class="wrap">
	                <div id="icon-users" class="icon32"></div>
	                <h1 class="wp-heading-inline">Solicitud de depositos</h1>
	                <a href="<?=add_query_arg("new", "true")?>" class="page-title-action">Añadir nuevo</a>
	                <form action="" method="GET">
	                    <p class="search-box">
	                      <label class="screen-reader-text" for="search-box-id-search-input">Buscar:</label>
	                      <input type="text" id="search-box-id-search-input" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : ''; ?>">
	                      <input type="submit" id="search-submit" class="button" value="Buscar">
	                    </p>
	                    <?php if(isset($_GET['us']) && $_GET['us']) echo "<input type='hidden' name='us' value='$_GET[us]' />"; ?>
	                    <input type="hidden" name="page" value="<?=esc_attr($_REQUEST['page']);?>"/>
	                </form>
	                <?php 
	                    $page  = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );
	                    $paged = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );
	                    printf( '<input type="hidden" name="page" value="%s" />', $page );
	                    printf( '<input type="hidden" name="paged" value="%d" />', $paged );
	                    $lista->display();
	                  ?>
              </div>
            <?php
		}

		public function custom_role() {
		    if ( get_option( 'custom_roles_version' ) < 2 ) {
		        remove_role( 'inversor_confianza' );
		        remove_role( 'inversor' );
		        update_option( 'custom_roles_version', 2 );
		    }
		}

		public function custom_user_profile_fields( $user ) {
		?>
		    <table class="form-table">
		        <tr>
		            <th>
		                <label for="benefico_mm">Beneficio General</label>
		            </th>
		            <td>
		                <input type="number" min="1" step="1" required name="benefico_mm" id="benefico_mm" value="<?php echo esc_attr( get_the_author_meta( 'benefico_mm', $user->ID ) ); ?>" class="regular-text" />
		            </td>
		        </tr>
		    </table>
		<?php
		}
		public function update_extra_profile_fields( $user_id ) {
		    if ( current_user_can( 'edit_user', $user_id ) ) update_user_meta( $user_id, 'benefico_mm', $_POST['benefico_mm'] );
		}

		public function tags_camp_cpt_TOP(){
			global $post;
			$post_id = $post->ID;
			$r_data = array();
			$activity = get_post_meta($post_id, 'actividades', true);
			$region = get_post_meta($post_id, 'region', true);
			$clue_camp = json_decode(get_post_meta($post_id, 'cluecamp', true));
			$ages_tags_ = [];
			foreach($clue_camp as $k => $v) if(!in_array($v->edades, $ages_tags_)) $ages_tags_[] = $v->edades;
			$ages_tags_ = (count($ages_tags_) > 1) ? ('Edades: '.(implode(', ', $ages_tags_))) : ('Edades: '.(strval($ages_tags_[0])));
			$r_data['edades'] = $ages_tags_;
			$r_data['actividades'] = '<a title="Link a los campamentos con la actividad '.$activity.'" href="'.home_url('topcampamentos/actividades:'.$activity).'">'.$activity.'</a>';
			$r_data['region'] = '<a title="Link a los campamentos de la region '.$region.'" href="'.home_url('topcampamentos/region:'.$region).'">'.$region.'</a>';
			$r_data['servicios_plazas'] = get_post_meta($post_id, 'servicios_plazas', true);
			$r_data['servicios_experiencia'] = get_post_meta($post_id, 'servicios_experiencia', true) . " de experiencia";
			$r_data['servicios_monitores'] = get_post_meta($post_id, 'servicios_monitores', true);
			$idioma = get_post_meta($post_id, 'idioma', true);
			$write_idioma = [];
			$lang_write = '';
			foreach($idioma as $k => $v){
				if($v && $v != false && $v != 'false'){
					$write_idioma[] = $k;
				} 
			}
			$lang_write = $this->print_the_flags_in_fich($write_idioma);
			$r_data['idioma'] = $lang_write;
			$container = "<div class='container_tags_fich_camp_pg_TOP_unick'> <div class='content_tags_fich_camp_pg_TOP_unick'>";
			foreach($r_data as $k => $v) if($v) $container .= "<div class='tag_fich_camp_pg_TOP_unick'>".$v."</div>";
			$container .= "</div></div>";
			return $container;
		}

		// --------- upload imgs top campamentos ----------------
		public function media_custom_TOPCamps($file_path, $file_name){
			$file_data = file_get_contents($file_path);
			$upload = wp_upload_bits($file_name, null, $file_data);
			if ($upload['error']) {
				return false;
			}else {
				$attachment = array(
				'guid'           => $upload['url'],
				'post_mime_type' => $upload['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', $file_name ),
				'post_content'   => '',
				'post_status'    => 'inherit'
				);
				$attachment_id = wp_insert_attachment($attachment, $upload['file']);
				$attachment_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
				wp_update_attachment_metadata($attachment_id, $attachment_data);
				return $attachment_id;
			}

		}
		// --------- upload imgs top campamentos ----------------

		// --------- api latitud y longitud callback ----------------
		public function lt_lg_iframe_TOP($dir){
			if(!$dir) return false;
			$key = 'AIzaSyBo-lGYg-ONjQV0WqOAX8kaN6VBcyN4FEs';
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($dir).'&key='.$key,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
			));
			$response = curl_exec($curl);
			curl_close($curl);
			$resultados = json_decode($response);
			$resultados = $resultados->results[0]->geometry->location;
			return $resultados;
		}
		// --------- api latitud y longitud callback ----------------

		// ---------- camp shop ----------------

		public function camp_buy_process_TOP(){
			global $wpdb;
			global $post;
			$post_id = $post->ID;
			$cmsn = get_option('comi_booking');
			if($cmsn === false || $cmsn === null || $cmsn === '') $cmsn = 15;
			$conatiner_form = '<div class="container_form_booking_fich_TOP" ide="'.$post_id.'">
									<div class="head_content_form_book">
										<span>Solicitud Reserva</span>
									</div>
									<div class="body_content_form_book">
										<select class="age_clue_fich" name="edad" id="">
											<option value="" selected disabled>Edades*</option>
										</select>
										<select class="dates_clue_fich" name="fechas" id="" disabled>
											<option class="base" value="" selected disabled>Fechas*</option>
										</select>
										<div class="agroup_cluecamp_fich">
											<span class="tmp">Temporada: </span>
											<span class="drc">Duración: </span>
											<span class="fch">Fechas: </span>
											<div class="plz"><span>Plazas<p></p></span><span>Plazas disponibles<p></p></span></div>
										</div>
										<label for="" class="num_cupes">
											<span>Cupos a reservar</span>
											<input class="plaz_num_descont" min="1" type="number" value="1" name="plazas" disabled>
										</label>
										<div class="agroup_cluecamp_fich_impo">
											<span class="notice_book">* Por favor tenga en cuenta que va realizar solo una reserva, es necesario completar el pago posteriormente. Este pago asegura su lugar y garantiza que su reserva esté confirmada. Si tiene alguna pregunta sobre el proceso de pago, no dude en contactarnos.</span>
											<span class="price_unitary">Precio unitario: <div><p>0</p> &#8364</div></span>
											<span class="price__total">Total: <div><p>0</p> &#8364 (iva incl.)</div></span>
											<span class="price__total_percent">Total a pagar: <div><p>0</p> &#8364</div></span>
										</div>
										<input type="hidden" class="booking_id_post_top" value="'.$post_id.'">
										<button class="reserve_booking_in_fich">Reservar</button>
									</div>
								</div>';
			return $conatiner_form;
		}

		// ---------- camp shop ----------------

		// ---------- Listing single camp ----------------

		public function sh_listing_camp_single_TOP(){
			global $post;
			$post_id = $post->ID;
			$port_media = get_post_meta($post_id, 'portada_camp', true);
			$port_media = ($port_media) ? $port_media : 0;
			$activity = get_post_meta($post_id, 'actividades', true);
			$region = get_post_meta($post_id, 'region', true);
			$price = json_decode(get_post_meta($post_id, 'cluecamp', true));
			$ages_write = $this->print_the_ages_in_cards($price);
			$lang = get_post_meta($post_id, 'idioma', true);
			$destc_plan = get_post_meta($post_id, 'certify_by_TOP', true);
			$destc_plan_30 = get_post_meta($post_id, 'venc_camp_dest_30', true);
			if($destc_plan){
				$destc_plan = '<div class="destc_pack_camp">
									<div class="content_dest_pack_camp">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
										<span>Campamento verificado</span>
									</div>
								</div>';
			}else if (time() < $destc_plan_30){
				$destc_plan = '<div class="destc_pack_camp">
									<div class="content_dest_pack_camp">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
										<span>Destacado</span>
									</div>
								</div>';
			}else{
				$destc_plan = '';
			}
			$langs = array();
			$lang_write = '';
			$write_price = array();
			$write_price_write = '';
			$current_user = (get_current_user_id()) ? get_current_user_id() : 0;
			$wish_disable = (!get_current_user_id()) ? 'disable' : 'aviable';
			foreach($price as $k => $v) if($v->precio) $write_price[] = $v->precio;
			if(count($write_price) > 1){
				sort($write_price);
				$price1 = $write_price[0];
				$price2 = end($write_price);
				if($price1 != $price2){
					$write_price_write = wc_price($price1) . ' - ' . wc_price($price2);
				}else{
					$write_price_write = wc_price($write_price[0]);
				}
			}else{
				$write_price_write = wc_price($write_price[0]);
			}
			foreach($lang as $k => $v) if(filter_var($v, FILTER_VALIDATE_BOOLEAN)) $langs[] = $k;
			$lang_write = $this->print_the_flags_in_cards($langs);
			$wish_log = false;
			if(is_user_logged_in()){
				$user_id = get_current_user_id();
				$wishlist = get_user_meta($user_id, 'wishlist_user_TOP', true);
				if($wishlist){
					if(is_serialized($wishlist)) unserialize($wishlist);
					if(in_array($post_id, $wishlist)) $wish_log = true;
				}
			}
			$isw = ($wish_log) ? 'add': 'nadd';

			$wish_added = ($wish_log) ? '': 'disabled';
			$wish_empty = (!$wish_log) ? '': 'disabled';

			$port_media = ($port_media) ? ((wp_get_attachment_url($port_media)) ? wp_get_attachment_url($port_media) : home_url('/wp-content/uploads/2023/05/Imagen-banner-top-2.jpg')) : home_url('/wp-content/uploads/2023/05/Imagen-banner-top-2.jpg');
			$container = '<div class="container_listing_camp">
								<div class="head_img_listing">	
									<a href="'.get_permalink($post_id).'" title="Link al campamento '.get_the_title($post_id).'">
										<img src="'.$port_media.'" alt="Imagen de portada del campamento">
									</a>
									'.$destc_plan.'
									<span usr="'.$current_user.'" class="wishlist_icon_top_camp destc_sll '.$wish_disable.'" wis="'.$post_id.'" isw="'.$isw.'">
										<div class="heart_added '.$wish_added.'">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/></svg>
										</div>
										<div class="heart_empty '.$wish_empty.'" >
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"/></svg>
										</div>	
									</span>
									<span class="activity toggle_FILL"><a title="Link a los campamentos con la actividad '.$activity.'" href="'.home_url('resultados/?jsf=jet-engine&meta=actividades:'.$activity).'">'.$activity.'</a></span>
								</div>
								<div class="body_data_listing_camp">
									<div class="f1-row">
										<span class="title"><a href="'.get_permalink($post_id).'" title="Enlace al campamento '.get_the_title($post_id).'">'.get_the_title($post_id).'</a></span>
									</div>
									<div class="f2-row">
										<span class="ubication toggle_FILL"><a title="Link a los campamentos de la region '.$region.'" href="'.home_url('resultados/?jsf=jet-engine&meta=region:'.$region).'">'.$region.'</a></span>
									</div>
									<div class="f2-2-row">
										'.$ages_write.'
									</div>
									<div class="f3-row">
										'.$lang_write.'
									</div>
									<div class="f4-row">
										<span class="price_prefix">Precio:</span>
										<span class="price">'.$write_price_write.'</span>
									</div>
									<a class="view_camp" href="'.get_permalink($post_id).'" title="Link al campamento '.get_the_title($post_id).'">Ver ficha</a>
								</div>
							</div>';
			return $container;
		}

		// ---------- Listing single camp ----------------

		public function date_format_cluecamp($date, $type = 1){
			$fc = explode('-', $date);
			if($type == 1) return $fc[1].'-'.$fc[0].'-'.$fc[2];
			return $fc[2].'-'.$fc[0].'-'.$fc[1];
		}

		public function price_booking($cart_object) {  
			$cmsn = get_option('comi_booking');
			if($cmsn === false || $cmsn === null || $cmsn === '') $cmsn = 15;
	        foreach ($cart_object->cart_contents as $item ) {
				if($item['product_id'] == 236){
					$to_price = $item['variation']['precio'];
					$the_price = ($to_price / 100) * $cmsn;
					$item['data']->set_price($the_price);
				}
	        } 
		}

		public function plazas_sale_booking($order_id){
			$order = wc_get_order($order_id);
			$order_items = $order->get_items();
			$order_total = $order->get_total();
			$user_id = $order->get_user_id();
			$process = get_post_meta($order_id, 'topcamp_process', true);
			if(!empty($order_items) && !$process){
				foreach($order_items as $key => $it){
					$the_pid = $it->get_product_id();
					if($the_pid == 236){
						$camp_id = $it->get_meta('campamento');
						$clue_id = $it->get_meta('reserva');
						$quantity = $it->get_quantity();
						$fechas_r = ($it->get_meta('fechas_r')) ? $it->get_meta('fechas_r') : '';
						$edades_r = ($it->get_meta('edades_r')) ? $it->get_meta('fechas_r') : '';
						$ttl = ($it->get_meta('title_camp')) ? ' '.$it->get_meta('title_camp').'.' : '.';
						if($camp_id && $clue_id && $quantity){
							$clue_data_dis = get_post_meta($camp_id, 'plazas_disp', true);
							if(is_array($clue_data_dis) && isset($clue_data_dis[$clue_id])){
								global $wpdb;
								$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
								$author_id = (get_post_field('post_author', $camp_id)) ? get_post_field('post_author', $camp_id): 0;
								$current_date = date('Y-m-d');
								$cmsn = get_option('comi_booking');
								if(!$cmsn) $cmsn = 15;
								$data_booking_table = array(
									'plazas'			=>  $quantity,
									'id_orden'			=>  $order_id,
									'id_user'			=>  $user_id,
									'id_gest_camp'		=>  $author_id,
									'id_camp'			=>  $camp_id,
									'id_cluecamp'		=>  $clue_id,
									'precio'			=>  $order_total,
									'fecha'				=>  $current_date,
									'fullname'			=>  get_post_meta($order_id, '_billing_first_name', true) . ' ' . get_post_meta($order_id, '_billing_last_name', true),
									'correo'			=>  get_post_meta($order_id, '_billing_email', true),
									'telefono'			=>  get_post_meta($order_id, '_billing_phone', true),
									'fechas_reserva'	=>  $fechas_r,
									'comision'			=>  $cmsn,
								);
								if($wpdb->insert($camp_bookings_top, $data_booking_table)){
									$clue_data_dis[$clue_id] += $quantity;
									if(!update_post_meta($camp_id, 'plazas_disp', $clue_data_dis)){
										$mensaje_admin = '<h1>¡Hola Agata!</h1>
											<p>
												Quería hacerte saber que ha ocurrido un error en el proceso de la reserva #'.$order_id.' con el campamento '.get_the_title($camp_id).' . Lamentablemente, no podemos descontar las plazas correctamente.
												<br>
												Debes comunicarte con el equipo de la aplicación para que puedan ayudarte a resolver este problema lo antes posible.
											</p>
										';
										$data_admin = [
											"nombre"	=> 'Agata',
											"mensaje"	=> $mensaje_admin,
										];
										$this->mail('info@topcampamentos.com', "Error en la reservación", "reservacion-admin", $data_admin);
										$order->add_order_note('Ha ocurrido un error al intentar descontar las plazas del campamento'.$ttl);
										$order->update_status('on-hold', 'Error al descontar las plazas.');
									}else{
										$data_campists_for = $order->get_customer_note();
										$data_notes = ($data_campists_for) ? 'Aquí tienes la información de los campistas que asistirán a tu campamento: '.$data_campists_for.'<br><br>' : '';
										$mensaje_user = get_post_meta($camp_id, 'mail_message', true);
										$correo = get_post_meta($order_id, '_billing_email', true);
										$name_user = get_post_meta($order_id, '_billing_first_name', true) . ' ' . get_post_meta($order_id, '_billing_last_name', true);
										$mensaje_admin = '<h1>¡Hola Agata!</h1>
											<p>
												Te escribimos para informarte de que se ha hecho una nueva reserva en TOP Campamentos. ¡El campamento que se ha reservado es '.get_the_title($camp_id).'!<br><br>
												Nos complace informarte que el correo electrónico de confirmación ha sido enviado correctamente al cliente y a la empresa del campamento.<br><br>
												Por favor, revisa la reserva lo antes posible y asegúrate de que todo está correcto. Si tienes alguna pregunta o necesitas más información, no dudes en ponerte en contacto con el soporte.
											</p>
											<br>
											<a href="'.home_url().'">Ir a TOP Campamentos</a>
										';
										$mensaje_camp = '<h1>¡Enhorabuena!</h1>
											<p>
												¡Tenemos noticias emocionantes que compartir contigo! Acabas de recibir una nueva reserva en tu campamento en TOP Campamentos. El campamento reservado es '.get_the_title($camp_id).'.<br><br>
												Nos complace informarte que el correo electrónico de contacto para el cliente se envió correctamente. ¡Así que todo está listo para que tus huéspedes disfruten de su estancia en tu campamento!<br><br>
												'.$data_notes.'
												Para revisar los detalles de la reserva, puedes acceder a tu panel de administración en TOP Campamentos. Ahí encontrarás toda la información necesaria.<br><br>
												Si tienes alguna pregunta o necesitas más información, no dudes en ponerte en contacto con nosotros. ¡Estamos aquí para ayudarte en lo que necesites!<br><br><br>
												¡Gracias por ser parte de TOP Campamentos!<br>
											</p>
											<br>
											<a href="'.home_url().'">Ir a TOP Campamentos</a>
										';
										$mensaje_base = '<h2>¡Hola {{nombre_cliente}}!</h2>
											<p>
											¡Bienvenido(a) a nuestro campamento! Gracias por su reserva y estamos emocionados de tenerles como nuestros huéspedes.
											<br>
											<br>
											Solo queremos recordarle que aún queda por pagar el resto del campamento y le estaremos contactando pronto para organizar los detalles de su reserva y asegurarnos de que todo esté listo. Si tiene alguna pregunta o inquietud, puede hacérnoslo saber siguiendo este enlace: <a href="{{campamento_enlace}}">Tengo una duda</a>.
											<br>
											<br>
											Por lo pronto necesitamos ciertos datos del o los campistas tales como: 
											<br>
											</p>
											<ol>
												<li style="color: #333;">Alergias o especifiaciones alimentarias</li>
												<li style="color: #333;">¿Toma alguna medicación? (En caso afirmativo detallar en ficha médica)</li>
												<li style="color: #333;">¿Padece algún tipo de discapacidad?</li>
											</ol>
											<br>
											<p>
											Ficha médica Ej: Enfermedades importantes, padece algún tipo de discapacidad, 
											ataques epilépticos, ...). 
											<br>
											De igual manera debe brindarnos ciertos comentarios o detalles a tener en cuenta Ej: Sabe nadar, ha estado antes en campamentos, tiene algún miedo específico, ... 
											<br>
											Esta información debe hacérnosla al correo electrónico con el que nos estaremos comunicando próximamente.
											<br>
											<br>
											Esperamos que disfruten de todas las actividades y experiencias que ofrecemos en nuestro campamento. ¡Gracias por elegirnos como su destino de campamento!
											</p>';
										$variables = [
											"{{nombre_campamento}}" 		=> get_the_title($camp_id),
											"{{nombre_completo_cliente}}"	=> get_post_meta($order_id, '_billing_first_name', true) . ' ' . get_post_meta($order_id, '_billing_last_name', true),
											"{{nombre_cliente}}" 			=> get_post_meta($order_id, '_billing_first_name', true),
											"{{apellido_cliente}}" 			=> get_post_meta($order_id, '_billing_last_name', true),
											"{{fechas_contratadas}}" 		=> $fechas_r,
											"{{plazas_contratadas}}" 		=> $quantity,
											"{{cantidad_deuda}}" 			=> ($order_total/15)*85,
											"{{telefono_cliente}}" 			=> get_post_meta($order_id, '_billing_phone', true),
											"{{campamento_edades}}" 		=> $edades_r,
											"{{campamento_enlace}}" 		=> get_permalink($camp_id),
											"{{cuenta_usuario}}" 			=> home_url('/mi-cuenta/'),
										];
										$mensaje_def = ($mensaje_user) ? $mensaje_user: $mensaje_base;
										foreach($variables as $vr => $vl) $mensaje_def = str_replace($vr, $vl, $mensaje_def);
										$data = [
											"nombre" 	=> $name_user,
											"mensaje"	=> $mensaje_def,
										];
										$data_admin = [
											"nombre"	=> 'Agata',
											"mensaje"	=> $mensaje_admin,
										];
										if($author_id){
											$gest_mail = get_the_author_meta('user_email', $author_id);
											if($gest_mail){
												$data_camp = [
													"nombre"	=> get_userdata($author_id)->display_name,
													"mensaje"	=> $mensaje_camp,
												];
												$send_mail_camp = $this->mail($gest_mail, "¡Nueva reserva en TOP Campamentos!", "reservacion-camp", $data_camp);
												if(!$send_mail_camp) $order->add_order_note('Ha ocurrido un error con el envío del correo de aviso al gestor de campamento.');
											}else{
												$order->add_order_note('Ha ocurrido un error al intentar enviar el mensaje de aviso al gestor de este campamento.');
											}
										}else{
											$order->add_order_note('Ha ocurrido un error al intentar enviar el mensaje de aviso al gestor de este campamento.');
										}
										$send_mail_user = $this->mail($correo, "Nuevo mensaje de TOP Campamentos", "reservacion", $data);
										$this->mail('info@topcampamentos.com', "¡Nueva reserva en TOP Campamentos!", "reservacion-admin", $data_admin);
										if(!$send_mail_user) $order->add_order_note('Ha ocurrido un error con el envío del correo de contacto entre el campamento '.get_the_title($camp_id).' y el usuario '.$name_user.'.');
										update_post_meta($order_id, 'topcamp_process', true);
									}
								}else{
									$order->add_order_note('Ha ocurrido un error al intentar guardar la orden al campamento'.$ttl);
									$order->update_status('on-hold', 'Error al guardar la orden al campamento.');
								}
							}else{
								$mensaje_admin = '<h1>¡Hola Agata!</h1>
											<p>
												Quería hacerte saber que ha ocurrido un error al obtener la información necesaria para seguir con el proceso de reservación con el campamento '.get_the_title($camp_id).' en la reserva #'.$order_id.'. Lamentablemente, no podemos descontar las plazas debido a que la información no se obtuvo correctamente.
												<br>
												Debes comunicarte con el equipo de la aplicación para que puedan ayudarte a resolver este problema lo antes posible.
											</p>
								';
								$data_admin = [
									"nombre"	=> 'Agata',
									"mensaje"	=> $mensaje_admin,
								];
								$this->mail('info@topcampamentos.com', "Error en la reservación", "reservacion-admin", $data_admin);
								$order->add_order_note('Ha ocurrido un error al obtener la información para descontar las plazas del campamento'.$ttl);
							}
						}else{
							$mensaje_admin = '<h1>¡Hola Agata!</h1>
											<p>
												Quería hacerte saber que ha ocurrido un error al obtener la información necesaria para seguir con el proceso de reservación con el campamento '.get_the_title($camp_id).' en la reserva #'.$order_id.'. Lamentablemente, no podemos descontar las plazas debido a que la información no se obtuvo correctamente.
												<br>
												Debes comunicarte con el equipo de la aplicación para que puedan ayudarte a resolver este problema lo antes posible.
											</p>
							';
							$data_admin = [
								"nombre"	=> 'Agata',
								"mensaje"	=> $mensaje_admin,
							];
							$this->mail('info@topcampamentos.com', "Error en la reservación", "reservacion-admin", $data_admin);
							$order->add_order_note('Ha ocurrido un error al obtener la información para descontar las plazas del campamento'.$ttl);
						}
						$it->set_name(get_the_title($camp_id));
					}else if($the_pid == 2693){
						$camp_id = $it->get_meta('camp');
						$add_certify = update_post_meta($camp_id, 'certify_by_TOP', true);
						if(!$add_certify){
							$order->add_order_note('Ha ocurrido un error al asignarle la certificación al campamento '.get_the_title($camp_id).', por favor comuniquese con el soporte de la aplicación para solucionar este problema.');
							$mensaje_c = '
								<h1>Ha ocurrido un error</h1>
								<p>
								Lamentablemente ha ocurrido un error al asignarle <b>la certificación</b> al campamento <b>'.get_the_title($camp_id).'</b>, por favor comuniquese con el soporte de la aplicación para solucionar este problema cuanto antes
								</p>
								<br>
								<a href="'.home_url('/adminsp').'">Ir a TOP Campamentos</a>
							';
							$data = [
								"nombre" 	=> 'Admin',
								"mensaje"	=> $mensaje_c,
							];
							$this->mail('info@topcampamentos.com', "[TopCampamentos] - Error en compra de certificación", "reservacion", $data);
						}else{
							$correo = get_post_meta($order_id, '_billing_email', true);
							$name_user = get_post_meta($order_id, '_billing_first_name', true) . ' ' . get_post_meta($order_id, '_billing_last_name', true);
							$mensaje_c = '
								<h1>¡Enhorabuena!</h1>
								<p>
								Nos complace informarte que <b>la certificación</b> ha sido asignada al campamento <b>'.get_the_title($camp_id).'</b>.
								<br>
								Si deseas ver las certificaciones de este campamento, puedes hacer click en el siguiente enlace:
								</p>
								<br>
								<a href="'.home_url().'">Ir a TOP Campamentos</a>
							';
							$data = [
								"nombre" 	=> $name_user,
								"mensaje"	=> $mensaje_c,
							];
							$send_mail_camp_l = $this->mail($correo, "Compra de certificación en TOP Campamentos", "reservacion", $data);
							if(!$send_mail_camp_l){
								$order->add_order_note('Ha ocurrido un error al enviar el correo de la compra al campamento '.get_the_title($camp_id).', por favor comuniquese con el soporte de la aplicación para solucionar este problema.');
							}
						}
					}else if($the_pid == 2695){
						$camp_id = $it->get_meta('camp');
						$the_meta_destc_visiblt = get_post_meta($the_pid, 'activity_desc_plan', true);
						$mensaje_c_admin = '
							<h1>Ha ocurrido un error</h1>
							<p>
							Lamentablemente ha ocurrido un error al asignarle el <b>plan de visibilidad destacada</b> al campamento <b>'.get_the_title($camp_id).'</b>, por favor comuniquese con el soporte de la aplicación para solucionar este problema cuanto antes
							</p>
							<br>
							<a href="'.home_url('/adminsp').'">Ir a TOP Campamentos</a>
						';
						$data_c_admin = [
							"nombre" 	=> 'Admin',
							"mensaje"	=> $mensaje_c_admin,
						];
						if($the_meta_destc_visiblt){
							if(is_serialized($the_meta_destc_visiblt)) unserialize($the_meta_destc_visiblt);
							$the_meta_destc_visiblt[] = $camp_id;
						}else{
							$the_meta_destc_visiblt = array($camp_id);
						}
						if(!update_post_meta($the_pid, 'activity_desc_plan', $the_meta_destc_visiblt)){
							$this->mail('info@topcampamentos.com', "[TopCampamentos] - Error en compra de plan de visibilidad", "reservacion", $data);
							$order->add_order_note('Ha ocurrido un error al asignarle el plan de visibilidad destacada al campamento '.get_the_title($camp_id).', por favor comuniquese con el soporte de la aplicación para solucionar este problema.');
						}else{
							$to_date = strtotime('+30 days');	
							if(!update_post_meta($camp_id, 'venc_camp_dest_30', $to_date)){
								$this->mail('info@topcampamentos.com', "[TopCampamentos] - Error en compra de plan de visibilidad", "reservacion", $data);
								$order->add_order_note('Ha ocurrido un error al asignarle el plan de visibilidad destacada al campamento '.get_the_title($camp_id).', por favor comuniquese con el soporte de la aplicación para solucionar este problema.');
							}else{
								$correo = get_post_meta($order_id, '_billing_email', true);
								$name_user = get_post_meta($order_id, '_billing_first_name', true) . ' ' . get_post_meta($order_id, '_billing_last_name', true);
								$mensaje_c = '
									<h1>¡Enhorabuena!</h1>
									<p>
									Nos complace informarte que el <b>plan de visibilidad destacada</b> ha sido asignado al campamento <b>'.get_the_title($camp_id).'</b>.
									<br>
									Si deseas ver las certificaciones o planes de este campamento, puedes hacer click en el siguiente enlace:
									</p>
									<br>
									<a href="'.home_url().'">Ir a TOP Campamentos</a>
								';
								$data = [
									"nombre" 	=> $name_user,
									"mensaje"	=> $mensaje_c,
								];
								$send_mail_camp_l = $this->mail($correo, "Compra de plan de visibilidad en TOP Campamentos", "reservacion", $data);
								if(!$send_mail_camp_l){
									$order->add_order_note('Ha ocurrido un error al enviar el correo de la compra al campamento '.get_the_title($camp_id).', por favor comuniquese con el soporte de la aplicación para solucionar este problema.');
								}
							}
						}
					}
					
				}
			}
			$order->save();
		}

		public function cart_item_product($cart_item_product, $cart_item, $cart_item_key){
        	if(isset($cart_item["variation"]["title_camp"])) $cart_item_product->set_name($cart_item["variation"]["title_camp"]);
        	return $cart_item_product; 
        }

		public function before_checkout_TOP(){
			$order_items = WC()->cart->get_cart();
			if(!empty($order_items)){
				foreach($order_items as $key => $it){
					$camp_id = $it['variation']['campamento'];
					if($camp_id == 236){
						$clue_id = $it['variation']['reserva'];
						$quantity = $it['quantity'];
						$disp = get_post_meta($camp_id, 'plazas_disp', true);
						$clue_data = json_decode(get_post_meta($camp_id, 'cluecamp', true));
						if(($clue_data->{$clue_id}->plazas_num - $disp[$clue_id]) < $quantity){
							wc_add_notice( 'Lo sentimos, no hay suficientes plazas disponibles para este campamento"', 'error' );
							return;
						}
					}
				}
			}
		}

		public function refound_booking_TOP($order_id){
			$order = wc_get_order($order_id);
			$order_items = $order->get_items();
			if(!empty($order_items)){
				foreach($order_items as $key => $it){
					$camp_id = $it->get_meta('campamento');
					$clue_id = $it->get_meta('reserva');
					$quantity = $it->get_quantity();
					$clue_data_dis = get_post_meta($camp_id, 'plazas_disp', true);
					if($camp_id && $clue_id && $quantity){
						global $wpdb;
						$camp_bookings_top = $wpdb->prefix . 'camp_bookings_top';
						if(is_array($clue_data_dis) && isset($clue_data_dis[$clue_id])) $clue_data_dis[$clue_id] -= $quantity;
						if(!update_post_meta($camp_id, 'plazas_disp', $clue_data_dis)){
							$order->update_status('completed');
							$order->add_order_note("Lamentablemente, no se pudieron restaurar las plazas después del reembolso. Por favor, ponte en contacto con soporte técnico para obtener ayuda adicional con este problema.");
							$order->save();
							return;
						}else{
							if(!$wpdb->delete($camp_bookings_top, array( 'id_orden' => $order_id))){
								$order->update_status('completed');
								$order->add_order_note("No se pudo eliminar el registro de la base de datos. Por favor, ponte en contacto con soporte técnico");
							}else{
								if(!delete_post_meta($order_id, 'topcamp_process')){
									$order->update_status('completed');
									$order->add_order_note('Lo siento, no se pudo eliminar el control de la orden para permitir su procesamiento en el futuro. Por favor, intenta nuevamente más tarde o ponte en contacto con el soporte técnico para obtener ayuda adicional.');
								}		
							}
						}
					}else{
						$order->update_status('completed');
						$order->add_order_note("Lo siento, no se pudo obtener la información necesaria para procesar el reembolso en este momento. Por favor, intenta nuevamente más tarde o ponte en contacto con el soporte técnico para obtener ayuda adicional.");
					}
				}
			}
			$order->save();
		}

		public function camp_certify_TOP_cllbck(){
			global $post;
			$camp_id = $post->ID;
			if(get_post_meta($camp_id, 'certify_by_TOP', true)){
				$return = '<div class="camp_certify_container">
								<div class="camp_certify_content">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
									<span>Campamento verificado</span>
								</div>
							</div>';
				return $return;
			}
		}

		public function destc_listings_short_cllbck(){
			$args = array(
				'post_type' => 'topcampamentos',
				'post_status' => 'publish',
				'orderby' => 'rand',
				'posts_per_page' => 4,
				'fields' => 'ids',
				'meta_query' => array(
					array(
						'key' => 'venc_camp_dest_30',
						'compare' => 'EXISTS',
					),
				),
			);
			$return = '';
			$the_camps = get_posts($args);
			if(!empty($the_camps)){
				$return = '<div class="container_father_destc_30_act">
				<div class="content_father_destc_30_act">';
				foreach($the_camps as $camp){
					$logged = '';
					$wish_log = false;
					if(!is_user_logged_in()){
						$logged = 'disabled';
					}else{
						$user_id = get_current_user_id();
						$wish_user = get_user_meta($user_id, 'wishlist_user_TOP', true);
						if($wish_user){
							if(is_serialized($wish_user)) unserialize($wish_user);
							if(in_array($camp, $wish_user)){
								$wish_log = true;
							}
						}
					}
					$isw = ($wish_log) ? 'add': 'nadd';
					$wish_added = ($wish_log) ? '': 'disabled';
					$wish_empty = (!$wish_log) ? '': 'disabled';
					$activity = get_post_meta($camp, 'actividades', true);
					$region = get_post_meta($camp, 'region', true);
					$lang = get_post_meta($camp, 'idioma', true);
					$price = get_post_meta($camp, 'precio', true);
					$to_pass_ages = json_decode(get_post_meta($camp, 'cluecamp', true));
					$ages_write = $this->print_the_ages_in_cards($to_pass_ages, 'dest_fich');
					$title = get_the_title($camp);
					$photo = get_post_meta($camp, 'portada_camp', true);
					$is_photo = 'true';
					if($photo){
						$is_photo = 'false';
						$photo = (wp_get_attachment_url($photo)) ? wp_get_attachment_url($photo) : home_url('/wp-content/uploads/2023/05/TOPcampamentos-logotipo-combinado.png');
					}else{	
						$photo = home_url('/wp-content/uploads/2023/05/TOPcampamentos-logotipo-combinado.png'); 
					}
					$langs = [];
					$lang_write = '';
					foreach($lang as $k => $v){
						if($v && $v != false && $v != 'false'){
							$langs[] = $k; 
						}
					}
					$lang_write = $this->print_the_flags_in_cards($langs, 'dest_card');
					$return .= '<div class="back_camp_img '.$is_photo.'" style="background-image: url('.$photo.')">
									<div class="card_destc_activy">
										<span class="destc_sll">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
											Destacado
										</span>
										<div class="wishlist_destc '.$logged.'" wis="'.$camp.'" isw="'.$isw.'">
											<div class="heart_added '.$wish_added.'">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/></svg>
											</div>
											<div class="heart_empty '.$wish_empty.'">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"/></svg>
											</div>
										</div>
										<div class="content_cartd_destc_activy">
											<div class="head_card">
												<span class="activity"><a title="Link a los campamentos con la actividad '.$activity.'" href="'.home_url('resultados/?jsf=jet-engine&meta=actividades:'.$activity).'">'.$activity.'</a></span> 
											</div>	
											<div class="ctitle">
												<h2 class="title_camp"><a href="'.get_permalink($camp).'" title="Enlace al campamento '.$title.'">'.$title.'</a></h2>
											</div>
											<div class="cubi">
												<span class="ubication"><a title="Link a los campamentos de la region '.$region.'" href="'.home_url('resultados/?jsf=jet-engine&meta=region:'.$region).'">'.$region.'</a></span>
											</div>
											<div class="clang">
												'.$lang_write.'
											</div>
											<div class="f2-2-row">
												'.$ages_write.'
											</div>
											<div class="cprice">
												<h4>'.wc_price($price).'</h4>
											</div>
											<div class="cbtn">
												<a href="'.get_permalink($camp).'" title="Link al campamento '.$title.'">Ver ficha</a>
											</div>
										</div>
									</div>
								</div>';
				}
				$return .= '	</div>
							</div>';
			}else{
				$return = '<div class="empty_camps_destc_30"><h4>Sin campamentos destacados</h4></div>';
			}
			return $return;
		}

		public function list_wishlist_user_cllbck(){
			$user_id = get_current_user_id();
			$meta = get_user_meta($user_id, 'wishlist_user_TOP', true);
			$new_meta__ = [];
			$return = '';
			if($meta){
				$return = '<div class="container_camps_wishlist">
							<div class="content_wishlist">';
				if(is_serialized($meta)) unserialize($meta);
				foreach($meta as $post_id){
					$post__status = get_post_status($post_id);
					if(!$post__status || $post__status !== 'publish'){
						continue;
					}else{
						$new_meta__[] = $post_id;
						$port_media = get_post_meta($post_id, 'portada_camp', true);
						$activity = get_post_meta($post_id, 'actividades', true);
						$region = get_post_meta($post_id, 'region', true);
						$price = json_decode(get_post_meta($post_id, 'cluecamp', true));
						$ages_write = $this->print_the_ages_in_cards($price);
						$destc_plan = get_post_meta($post_id, 'certify_by_TOP', true);
						$destc_plan_30 = get_post_meta($post_id, 'venc_camp_dest_30', true);
						if($destc_plan){
							$destc_plan = '<div class="destc_pack_camp">
												<div class="content_dest_pack_camp">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
													<span>Campamento verificado</span>
												</div>
											</div>';
						}else if (time() < $destc_plan_30){
							$destc_plan = '<div class="destc_pack_camp">
												<div class="content_dest_pack_camp">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
													<span>Destacado</span>
												</div>
											</div>';
						}else{
							$destc_plan = '';
						}
						$lang = get_post_meta($post_id, 'idioma', true);
						$langs = array();
						$lang_write = '';
						$write_price = array();
						$write_price_write = '';
						foreach($price as $k => $v) if($v->precio) $write_price[] = $v->precio;
						if(count($write_price) > 1){
							sort($write_price);
							$write_price_write = wc_price($write_price[0]) . ' - ' . wc_price(end($write_price));
						}else{
							$write_price_write = wc_price($write_price[0]);
						}
						foreach($lang as $k => $v) if(filter_var($v, FILTER_VALIDATE_BOOLEAN)) $langs[] = $k;
						$lang_write = $this->print_the_flags_in_cards($langs);
						$port_media = ($port_media) ? ((wp_get_attachment_url($port_media)) ? wp_get_attachment_url($port_media) : home_url('/wp-content/uploads/2023/05/Imagen-banner-top-2.jpg')) : home_url('/wp-content/uploads/2023/05/Imagen-banner-top-2.jpg');
						$return .= '<div class="container_listing_camp" cmpdlt="'.$post_id.'">
											<div class="head_img_listing">	
												<a href="'.get_permalink($post_id).'" title="Link al campamento '.get_the_title($post_id).'">
													<img src="'.$port_media.'" alt="Imagen de portada del campamento">
												</a>
												'.$destc_plan.'
												<span class="campdlt_TOP" tdlt="'.$post_id.'">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"/></svg>
												</span>
												<span class="activity toggle_FILL"><a title="Link a los campamentos con la actividad '.$activity.'" href="'.home_url('resultados/?jsf=jet-engine&meta=actividades:'.$activity).'">'.$activity.'</a></span>
											</div>
											<div class="body_data_listing_camp">
												<div class="f1-row">
													<span class="title"><a href="'.get_permalink($post_id).'" title="Enlace al campamento '.get_the_title($post_id).'">'.get_the_title($post_id).'</a></span>
												</div>
												<div class="f2-row">
													<span class="prefix_ub">Región: </span>
													<span class="ubication toggle_FILL"><a title="Link a los campamentos de la region '.$region.'" href="'.home_url('resultados/?jsf=jet-engine&meta=region:'.$region).'">'.$region.'</a></span>
												</div>
												<div class="f2-2-row">
													'.$ages_write.'
												</div>
												<div class="f3-row">
													'.$lang_write.'
												</div>
												<div class="f4-row">
													<span class="price_prefix">Precio:</span>
													<span class="price">'.$write_price_write.'</span>
												</div>
												<a class="view_camp" href="'.get_permalink($post_id).'" title="Link al campamento '.get_the_title($post_id).'">Ver ficha</a>
											</div>
										</div>';
					}
				}
				$return .= '	</div>
						</div>';
				update_user_meta($user_id, 'wishlist_user_TOP', $new_meta__); 
			}else{
				$return = '<div class="empty_wishlist">
								<h2>No hay campamentos en tu lista de deseos</h2>
							</div>';
			}
			return $return;
			
		}

		public function button_wishlist_TOP_callback(){
			$return = '';
			$diferent = (!is_front_page()) ? 'notf': '';
			if(is_user_logged_in()){
				$index = 0;
				$user_id = get_current_user_id();
				$meta = get_user_meta($user_id, 'wishlist_user_TOP', true);
				if($meta){
					if(is_serialized($meta)) unserialize($meta);
					$index = count($meta);
					$index = ($index) ? $index : 0;
				}
				$return = '<a href="'.home_url('/lista-de-deseos/').'" title="Enlace a la página de tu lista de deseos">
								<div class="container_wishlist_btn '.$diferent.'">
									<div class="content_wihslits_btn">
										<div class="content_counter">
											<span class="counter_wishlist_shrtcd_TOP">'.$index.'</span>
										</div>
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/></svg>
									</div>
								</div>
							</a>';
			}
			return $return;
		}

		public function footer_copyright_campcllbck(){
			$return = '<div class="container_copyright_footer_TOP">
							<h6>&#169 TopCampamentos '.date('Y').' || Buscador de campamentos de Verano en España y Extranjero</h6>
						</div>';
			return $return;
		}

		public function name_company_camp_pg_cllbck(){
			global $post;
			$post_id = $post->ID;
			$return = '';
			$author = get_post_field('post_author', $post_id);
			if($author){
				$company_name  = get_the_author_meta('display_name', $author);
				if($company_name){
					$return = '<h4 class="diplay_name_company_camp toPageAuthors" athr="'.$author.'" title="Ver más campamentos de esta empresa">'.$company_name.'<svg version="1.0" xmlns="http://www.w3.org/2000/svg"
					width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000"
					preserveAspectRatio="xMidYMid meet">

					<g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
					stroke="none">
					<path d="M1976 5110 c-307 -39 -578 -167 -795 -375 -200 -192 -323 -403 -393
					-673 -64 -249 -42 -668 39 -732 50 -39 139 -18 163 40 11 27 10 46 -5 123 -97
					507 123 997 564 1257 198 116 461 173 688 151 494 -50 902 -391 1028 -861 47
					-177 53 -395 15 -555 -5 -22 -10 -57 -10 -78 0 -87 104 -129 171 -69 26 23 34
					42 50 117 11 50 22 149 25 220 19 386 -127 759 -405 1035 -260 259 -573 394
					-935 405 -72 2 -162 0 -200 -5z"/>
					<path d="M1955 4565 c-409 -90 -699 -468 -672 -879 6 -94 20 -132 58 -152 47
					-24 87 -18 125 20 l33 33 -1 119 c-1 142 15 214 75 329 57 111 154 206 268
					263 107 53 181 72 290 72 299 0 549 -194 624 -485 9 -36 15 -103 15 -173 l0
					-114 34 -34 c47 -47 95 -47 140 -1 29 28 34 41 40 103 4 39 2 110 -4 158 -45
					360 -293 644 -638 732 -109 28 -284 32 -387 9z"/>
					<path d="M2015 4037 c-103 -35 -203 -111 -251 -193 -56 -96 -59 -134 -57 -787
					1 -329 -1 -597 -5 -595 -4 2 -35 18 -70 36 -182 95 -374 75 -487 -50 -78 -87
					-77 -72 -72 -710 4 -615 3 -599 68 -794 92 -281 286 -535 534 -704 147 -99
					312 -170 503 -213 93 -21 118 -22 592 -22 482 0 498 1 599 23 234 53 392 126
					576 268 288 222 479 558 525 926 6 47 10 296 10 573 0 534 -2 561 -57 655 -41
					70 -116 138 -191 173 -56 26 -82 32 -157 35 -86 4 -132 -5 -216 -42 -13 -6
					-19 2 -28 40 -37 145 -147 263 -290 309 -80 26 -217 18 -295 -18 -32 -15 -60
					-27 -62 -27 -2 0 -15 21 -28 48 -98 194 -332 281 -535 199 l-61 -25 0 267 c0
					298 -7 346 -63 440 -41 68 -103 123 -185 163 -58 29 -77 33 -161 35 -60 2
					-111 -2 -136 -10z m176 -208 c50 -16 105 -61 132 -112 l22 -42 5 -845 c3 -465
					9 -852 13 -861 5 -9 23 -24 41 -34 42 -23 94 -14 127 21 l24 26 5 426 5 427
					28 47 c47 81 141 120 234 97 65 -17 135 -87 151 -151 8 -32 12 -171 12 -437 0
					-266 4 -398 11 -415 28 -60 122 -71 170 -20 l24 26 5 321 c5 351 6 352 67 408
					43 41 87 59 143 59 88 0 152 -38 193 -115 21 -38 22 -57 27 -355 3 -173 9
					-322 13 -331 5 -9 23 -24 41 -34 42 -23 94 -14 127 21 23 24 24 34 29 187 6
					175 12 198 67 248 45 42 87 59 148 59 98 0 181 -63 204 -156 14 -55 15 -892 1
					-1024 -27 -257 -137 -498 -313 -686 -186 -199 -454 -332 -732 -364 -117 -13
					-764 -13 -880 0 -268 31 -489 133 -680 313 -181 170 -288 354 -348 597 -19 79
					-21 120 -24 610 -3 413 -1 530 9 550 45 86 202 71 311 -29 91 -84 107 -172
					107 -613 0 -190 4 -295 11 -312 28 -60 122 -71 170 -20 l24 26 5 1176 5 1177
					23 38 c55 88 147 124 243 96z"/>
					</g>
					</svg></h4>';
				}else{
					$return = '<h4 class="diplay_name_company_camp toPageAuthors">TOP Campamentos</h4>';
				}
			}else{
				$return = '<h4 class="diplay_name_company_camp toPageAuthors">TOP Campamentos</h4>';
			}
			return $return;
		}

		public function hide_data_no_client($data, $order){
			return '';
		}

		public function cart_item_remove_link( $cart_item_remove_link, $cart_item_key ) {
		    return '';
		}

		public function send_verify_activation($user_id){
			$user_info = get_userdata($user_id);
			if(!in_array('subscriber', (array) $user_info->roles) && !in_array('customer', (array) $user_info->roles)) return;
			$code = md5(time());
			$code_url = array('id'=>$user_id, 'code'=>$code);
			update_user_meta($user_id, 'account_activated', 0);
			update_user_meta($user_id, 'activation_code', $code);
			$url = get_site_url(). '/mi-cuenta/?code=' .base64_encode( serialize($code_url));
			$mensaje = '<h1>¡Hola '.$user_info->user_login.'!</h1>
				<p>Gracias por registrarte en nuestro sitio. Para activar tu cuenta, por favor haz clic en el siguiente enlace: <br> <a href="'.esc_url($url).'">activar cuenta</a>.</p>';
			$data = [
				"nombre"	=> $user_info->user_login,
				"mensaje"	=> $mensaje,
			];
			$this->mail($user_info->user_email, "Activación de cuenta", "activacion-user", $data);
		}

		public function verify_activation_user_cllbck(){
			if(isset($_GET['code']) && !empty($_GET['code'])){
				$data = unserialize(base64_decode($_GET['code']));
				if (is_array($data)) {
				$user_id = $data['id'];
				$url_code = $data['code'];
				$user_code = get_user_meta($user_id, 'activation_code', true);
					if($user_code == $url_code) {
						delete_user_meta($user_id, 'activation_code');
						update_user_meta($data['id'], 'top_account_validated', 1);
						add_action('wp_footer', function(){?>
							<script>
								var urlActual = window.location.href.split('?')[0];
								history.pushState(null, null, urlActual);
								alert('¡Cuenta activada con éxito! ¡Bienvenido/a!', true);
							</script>
						<?php });
					}else{
						add_action('wp_footer', function(){?>
							<script>
								var urlActual = window.location.href.split('?')[0];
								history.pushState(null, null, urlActual);
								alert('Tu cuenta ya ha sido activada previamente. ¡Gracias por tu confirmación!');
							</script>
						<?php });
					}
				}
			}
		}

		public function validate_to_login_TOP($errors, $username, $password){
			if($errors->has_errors()) return $errors;
			$user = get_user_by('login', $username);
			if( !$user ){
				$user = get_user_by('email', $username);
				if( !$user ){
					$errors->add('account_not_fount', "Cuenta no encontrada");
					return $errors;
				}
			} 
			if(in_array('gestor_campamento', (array) $user->roles)){
				$creds = array(
					'user_login'    => $user->user_login,
					'user_password' => sanitize_text_field($password),
					'remember'      => 1
				);
				$user_login = wp_signon( $creds, is_ssl() );
				if ( is_wp_error( $user_login ) ) {
					$errors->add('account_error', "Datos incorrectos");
					return $errors;
				}else{
					wp_redirect(  get_site_url() . '/dashboard/');
					exit;
				}
			}else{
				$meta_value = get_user_meta($user->ID, 'top_account_validated', true);
				if(empty($meta_value)){
					$message = '¡Aún no puedes acceder! Por favor, verifica tu cuenta utilizando el correo que te enviamos.';
					$errors->add('account_not_verified', $message);
				}
			}
			return $errors;
		}

		public function desconect_register_TOP($redirect) {
			wp_logout();
			$redirect = site_url('gracias-por-registrarte');
			return $redirect;
		}

		public function activities_camps_2_cllbck(){
			global $post;
			$post_id = $post->ID;
			$return = '';
			$meta = get_post_meta($post_id, 'actividades2', true);
			if($meta){
				if(is_serialized($meta)) unserialize($meta);
				$new_meta = [];
				foreach($meta as $k => $v){
					if($v == 'true') $new_meta[] = $k;
				}

				if(!empty($new_meta)){
					$return = '<div class="container_act2_shrt_TOP">';
					foreach($new_meta as $act){
						$return .= '<li class="acts2_shrt_TOP">'.$act.'</li>';
					}
					$return .= '</div>';
				}else{
					$return = '<h2 class="act2_empty_message">Sin actividades cargadas por el momento</h2>';
				}
			}else{
				$return = '<h2 class="act2_empty_message">Sin actividades cargadas por el momento</h2>';
			}
			return $return;
		}

		public function stripe_procesing_TOP($order_id, $posted_data, $order){
			if ($order->get_payment_method() == 'stripe') {
				$order->update_status('completed');
				$order->save();
			}
		} 

		public function remove_capabilities_camps(){
			$roles_to_remove = get_role('gestor_campamento');
			if ($roles_to_remove) {
				$roles_to_remove->capabilities = array();
			}
		}

		public function restrict_wp_admin(){
			$roles = array('gestor_campamento', 'customer');
			$user = wp_get_current_user();
    		$user_role = reset($user->roles);
			if (in_array($user_role, $roles) && !wp_doing_ajax()) {
				wp_redirect(home_url()); 
				exit();
			}
		}

		public function form_tutor_kids_TOP($checkout){
			$user = get_current_user_id();
			if($user){
				$user = new WP_User($user);
				if(in_array('gestor_campamento', $user->roles)) return;
			}
			$order_items = WC()->cart->get_cart();
			if(!empty($order_items)){
				foreach($order_items as $key => $it){
					$num_kids = (int)$it['quantity'];
					echo '<div class="kids_data_TOP"><h3>'.__('Datos de los campistas').'</h3>';
					$itx = 1;
					woocommerce_form_field('num_campistas_form', [
						'type' => 'hidden',
					], $num_kids);
					for($i=0;$i<$num_kids;$i++){
						woocommerce_form_field('nombre_campista'.$itx, [
							'type' => 'text',
							'class' => array(
								'campista_field form-row-wide'
							),
							'label' => __('Nombre del campista N° '.$itx),
							'required' => true,

						], $checkout->get_value('nombre_campista'.$itx));
						woocommerce_form_field('fecha_nacimiento_campista'.$itx, [
							'type' => 'date',
							'class' => array(
								'campista_field form-row-wide'
							),
							'label' => __('Fecha de nacimiento del campista N° '.$itx),
							'required' => true,

						], $checkout->get_value('fecha_nacimiento_campista'.$itx));
						woocommerce_form_field('genero_campista'.$itx, [
							'type' => 'select',
							'class' => array(
								'campista_field form-row-wide'
							),
							'label' => __('Genero del campista N° '.$itx),
							'required' => true,
							'options' => array(
								'masculino' => __('Masculino'),
								'femenino' => __('Femenino'),
							),
						], $checkout->get_value('genero_campista'.$itx));
						woocommerce_form_field('comentarios_campista'.$itx, [
							'type' => 'textarea',
							'class' => array(
								'input-text '
							),
							'label' => __('Comentarios del campista N° '.$itx),
							'placeholder' => __('Ej: Alergias, o especificaciones alimentarias, sabe nadar, ha estado antes de campamento, tiene algún miedo específico, ...'),
						], $checkout->get_value('comentarios_campista'.$itx));
						$itx++;
					}
					echo '</div>';
				}
			}
		}

		public function dni_responsible_TOP($fields){
			$user = get_current_user_id();
			if($user){
				$user = new WP_User($user);
				if(in_array('gestor_campamento', $user->roles)) return $fields;
			}
			$fields['billing_document_responsible'] = array(
				'label'       => __('DNI/NIF o Pasaporte', 'woocommerce'),
				'required'    => true,
				'class'       => array('form-row-wide'),
				'clear'       => true,
			);
			return $fields;
		}

		public function add_checks_responsible_TOP(){
			$user = get_current_user_id();
			if($user){
				$user = new WP_User($user);
				if(in_array('gestor_campamento', $user->roles)) return;
			}
			woocommerce_form_field('consent_1', array(
				'type' => 'checkbox',
				'class' => array('form-row terms'),
				'label_class' => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
				'input_class' => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
				'required' => true,
				'label' => __('Como padre/madre o tutor/a legal y con el consentimiento del padre/madre o tutor/tutora que coinciden con los nombres y DNI aportados anteriormente, AUTORIZO a él/los participantes inscritos a participar en las actividades del campamento', 'woocommerce'),
			));
			woocommerce_form_field('consent_2', array(
				'type' => 'checkbox',
				'class' => array('form-row terms'),
				'label_class' => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
				'input_class' => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
				'required' => true,
				'label' => __('Certifico tener la autorización de los dos padres o tutores del o de los niños /as', 'woocommerce'),
			));
		}

		public function check_the_checks_TOP(){
			$user = get_current_user_id();
			if($user){
				$user = new WP_User($user);
				if(in_array('gestor_campamento', $user->roles)) return;
			}
			if(!isset($_POST['consent_1']) || !isset($_POST['consent_2'])) {
				wc_add_notice(__('Para inscribir a su/sus hijo/s en el campamento, es obligatorio marcar ambas casillas de autorización', 'woocommerce'), 'error');
			}
			if(isset($_POST['num_campistas_form'])){
				$num_campists = ($_POST['num_campistas_form']) ? (int)$_POST['num_campistas_form'] : 0;
				$itx = 1;
				for($i=0;$i<$num_campists;$i++){
					if(isset($_POST['nombre_campista'.$itx]) && empty($_POST['nombre_campista'.$itx])){
						wc_add_notice(__('El nombre del campista N° '.$itx.' es requerido', 'woocommerce'), 'error');
					}
					if(isset($_POST['fecha_nacimiento_campista'.$itx]) && empty($_POST['fecha_nacimiento_campista'.$itx])){
						wc_add_notice(__('La fecha de nacimiento del campista N° '.$itx.' es requerida', 'woocommerce'), 'error');
					}
					if(isset($_POST['genero_campista'.$itx]) && empty($_POST['genero_campista'.$itx])){
						wc_add_notice(__('El genero del campista N° '.$itx.' es requerido', 'woocommerce'), 'error');
					}
					$itx++;
				}
			}
		}

		public function save_form_tutor_kids_TOP($order_id){
			$dni = sanitize_text_field($_POST['billing_document_responsible']);
			$dni = ($dni) ? $dni : '';
			update_post_meta($order_id, 'billing_document_responsible', $dni);
			$num_kids = (int)sanitize_text_field($_POST['num_campistas_form']);
			$num_kids = ($num_kids) ? $num_kids : 0;
			update_post_meta($order_id, 'num_campistas_form', $num_kids);
			$itx = 1;
			for($i=0;$i<$num_kids;$i++){
				$name = sanitize_text_field($_POST['nombre_campista'.$itx]);
				$name = ($name) ? $name : '';
				update_post_meta($order_id, 'nombre_campista'.$itx, $name);
				$date = sanitize_text_field($_POST['fecha_nacimiento_campista'.$itx]);
				$date = ($date) ? $date : '';
				update_post_meta($order_id, 'fecha_nacimiento_campista'.$itx, $date);
				$genero = sanitize_text_field($_POST['genero_campista'.$itx]);
				$genero = ($genero) ? $genero : '';
				update_post_meta($order_id, 'genero_campista'.$itx, $genero);
				$comentarios = sanitize_text_field($_POST['comentarios_campista'.$itx]);
				$comentarios = ($comentarios) ? $comentarios : '';
				update_post_meta($order_id, 'comentarios_campista'.$itx, $comentarios);
				$itx++;
			}
		}

		public function details_dates_top_fich_camp_cllbck(){
			global $post;
			$post_id = $post->ID;
			$clue_camp = json_decode(get_post_meta($post_id, 'cluecamp', true));
			$return = '';
			if(!empty($clue_camp)){
				$return = '<div class="details_dates_fich"><div class="head_details_dates"><h2>Fechas</h2></div><div class="body_details_dates">';
					foreach($clue_camp as $k => $v){
						$d1 = $v->fecha_inicio;
						$d2 = $v->fechas_final;
						$cdd_b = date('d/m/Y');
						$msgsToBooking = "";
						if(!$v->plazas_num){
							$msgsToBooking = "<span class='msgs_to_insit'>Agotado</span>";
						}else{
							$msgsToBooking = "<span class='msgs_to_insit lasts'>¡Últimas plazas!</span>";
						}
						$price = $v->precio . ' &#8364;';
						$return .= '<div class="rows_details_dates_fich"><p>'.$d1.' - '.$d2.'</p>'.$msgsToBooking.'<span>'.$price.'</span></div>';
					}
				$return .= "</div></div>";
			}
			return $return;
		}

		public function camps_pages_seo_function($params){
			$return = '<div class="empty_camps_page_seo">
							<p>Sin campamentos</p>
						</div>';
			if($params){
				$attr = shortcode_atts(array(
					'ids' => ''
				), $params);
				$ids = explode(',', $attr['ids']);
				if(!empty($ids)){
					$camps = array(
						'post_type' => 'topcampamentos', 
						'posts_per_page' => 16,
						'post_status' => 'publish',
						'post__in' => $ids,
    					'orderby' => 'post__in',
					);
					$camps = get_posts($camps);
					if(!empty($camps)){
						$return = '<div class="container_camps_page_seo"><div class="content_camps">';
						foreach($camps as $camp){
							$post_id = $camp->ID;
							$port_media = get_post_meta($post_id, 'portada_camp', true);
							$activity = get_post_meta($post_id, 'actividades', true);
							$region = get_post_meta($post_id, 'region', true);
							$price = json_decode(get_post_meta($post_id, 'cluecamp', true));
							$ages_write = $this->print_the_ages_in_cards($price);
							$destc_plan = get_post_meta($post_id, 'certify_by_TOP', true);
							$destc_plan_30 = get_post_meta($post_id, 'venc_camp_dest_30', true);
							if($destc_plan){
								$destc_plan = '<div class="destc_pack_camp">
													<div class="content_dest_pack_camp">
														<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
														<span>Campamento verificado</span>
													</div>
												</div>';
							}else if (time() < $destc_plan_30){
								$destc_plan = '<div class="destc_pack_camp">
													<div class="content_dest_pack_camp">
														<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
														<span>Destacado</span>
													</div>
												</div>';
							}else{
								$destc_plan = '';
							}
							$lang = get_post_meta($post_id, 'idioma', true);
							$langs = array();
							$lang_write = '';
							$write_price = array();
							$write_price_write = '';
							foreach($price as $k => $v) if($v->precio) $write_price[] = $v->precio;
							if(count($write_price) > 1){
								sort($write_price);
								$write_price_write = wc_price($write_price[0]) . ' - ' . wc_price(end($write_price));
							}else{
								$write_price_write = wc_price($write_price[0]);
							}
							foreach($lang as $k => $v) if(filter_var($v, FILTER_VALIDATE_BOOLEAN)) $langs[] = $k;
							$lang_write = $this->print_the_flags_in_cards($langs);
							$port_media = ($port_media) ? ((wp_get_attachment_url($port_media)) ? wp_get_attachment_url($port_media) : home_url('/wp-content/uploads/2023/05/Imagen-banner-top-2.jpg')) : home_url('/wp-content/uploads/2023/05/Imagen-banner-top-2.jpg');
							$return .= '<div class="container_listing_camp" cmpdlt="'.$post_id.'">
										<div class="head_img_listing">	
											<a href="'.get_permalink($post_id).'" title="Link al campamento '.get_the_title($post_id).'">
												<img src="'.$port_media.'" alt="Imagen de portada del campamento">
											</a>
											'.$destc_plan.'
											<span class="activity toggle_FILL"><a title="Link a los campamentos con la actividad '.$activity.'" href="'.home_url('resultados/?jsf=jet-engine&meta=actividades:'.$activity).'">'.$activity.'</a></span>
										</div>
										<div class="body_data_listing_camp">
											<div class="f1-row">
												<span class="title"><a href="'.get_permalink($post_id).'" title="Enlace al campamento '.get_the_title($post_id).'">'.get_the_title($post_id).'</a></span>
											</div>
											<div class="f2-row">
												<span class="ubication toggle_FILL"><a title="Link a los campamentos de la region '.$region.'" href="'.home_url('resultados/?jsf=jet-engine&meta=region:'.$region).'">'.$region.'</a></span>
											</div>
											<div class="f2-2-row">
												'.$ages_write.'
											</div>
											<div class="f3-row">
												'.$lang_write.'
											</div>
											<div class="f4-row">
												<span class="price_prefix">Precio:</span>
												<span class="price">'.$write_price_write.'</span>
											</div>
											<a class="view_camp" href="'.get_permalink($post_id).'" title="Link al campamento '.get_the_title($post_id).'">Ver ficha</a>
										</div>
									</div>';
						}
						$return .= '</div></div>';
					}
				}
			}
			return $return;
		}

		public function print_the_flags_in_cards($future_flags, $class_extra = ''){
			$return = '';
			$class_flex_many_flags = (count($future_flags) <= 2) ? '' : 'flex_lang';
			$data_from_language_to_cards = [
				1 => [
					'title' => 'Español',
					'flag' => ADPNSY_URL.'/img/esp_flag.png',
					'url' => home_url('topcampamentos/idioma!is_custom_checkbox:Español/'),
				],
				2 => [
					'title' => 'Inglés',
					'flag' => ADPNSY_URL.'/img/uk_flag.png',
					'url' => home_url('topcampamentos/idioma!is_custom_checkbox:Ingles/'),
				],
				3 => [
					'title' => 'Francés',
					'flag' => ADPNSY_URL.'/img/french_flag.png',
					'url' => home_url('topcampamentos/idioma!is_custom_checkbox:Francés/'),
				],
				4 => [ 
					'title' => 'Alemán',
					'flag' => ADPNSY_URL.'/img/flag_germany.png',
					'url' => home_url('topcampamentos/idioma!is_custom_checkbox:Alemán/'),
				],
				5 => [
					'title' => 'Euskera',
					'flag' => ADPNSY_URL.'/img/flag_euskera.png',
					'url' => home_url('topcampamentos/idioma!is_custom_checkbox:Euskera/'),
				],
			];
			foreach($future_flags as $f){
				$f = strtolower($f);
				$data_flag = '';
				switch($f){
					case 'español':
						$data_flag = $data_from_language_to_cards[1];
						break;
					case 'ingles':
						$data_flag = $data_from_language_to_cards[2];
						break;
					case 'francés':
						$data_flag = $data_from_language_to_cards[3];
						break;
					case 'alemán':
						$data_flag = $data_from_language_to_cards[4];
						break;
					case 'euskera':
						$data_flag = $data_from_language_to_cards[5];
						break;
				}
				if(!empty($data_flag)){
					$return .= '<a href="'.$data_flag['url'].'" class="lang_tag_card_camp '.$class_flex_many_flags.' '.$class_extra.'" title="'.$data_flag['title'].'">
						<img src="'.$data_flag['flag'].'" alt="'.$data_flag['title'].'"/>
						<span>'.$data_flag['title'].'</span>
					</a>';
				}
			}
			return $return;
		}

		public function print_the_flags_in_fich($future_flags){
			$return = '';
			$class_flex_many_flags = (count($future_flags) <= 2) ? '' : 'flex_lang';
			$data_from_language_to_cards = [
				1 => [
					'title' => 'Español',
				],
				2 => [
					'title' => 'Inglés',
				],
				3 => [
					'title' => 'Francés',
				],
				4 => [ 
					'title' => 'Alemán',
				],
				5 => [
					'title' => 'Euskera',
				],
			];
			foreach($future_flags as $f){
				$f = strtolower($f);
				$data_flag = '';
				switch($f){
					case 'español':
						$data_flag = $data_from_language_to_cards[1];
						break;
					case 'ingles':
						$data_flag = $data_from_language_to_cards[2];
						break;
					case 'francés':
						$data_flag = $data_from_language_to_cards[3];
						break;
					case 'alemán':
						$data_flag = $data_from_language_to_cards[4];
						break;
					case 'euskera':
						$data_flag = $data_from_language_to_cards[5];
						break;
				}
				if(!empty($data_flag)){
					if(!$return) $return .= $data_flag['title'];
					else $return .= ', '.$data_flag['title'];
				}
			}
			return $return;
		}

		public function print_the_ages_in_cards($meta_decode, $class_extra = ''){
			$return = '';
			if(!empty($meta_decode)){
				$array_ages = [];
				$first_inthsbclgs = true;
				$label_to_print_in_ages = '';
				foreach($meta_decode as $m => $mv){
					if($mv->fecha_inicio && $mv->fechas_final && $mv->precio && $mv->{'mes-temporada'} && $mv->duracion && $mv->edades && $mv->plazas_num && !in_array(($mv->edades .' | '. $mv->duracion), $array_ages)){
						if($first_inthsbclgs) $label_to_print_in_ages = $mv->edades .' | '. $mv->duracion;
						$array_ages[] = $mv->edades .' | '. $mv->duracion;
					}
					$first_inthsbclgs = false;
				}
				if(!empty($array_ages)){
					$label_to_print_in_ages = ($label_to_print_in_ages) ? $label_to_print_in_ages : '';
					$return .= '<div class="ages_toggle '.$class_extra.'"><span class="title_this_ages">'.$label_to_print_in_ages.' 
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M416 208H272V64c0-17.7-14.3-32-32-32h-32c-17.7 0-32 14.3-32 32v144H32c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32h144v144c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V304h144c17.7 0 32-14.3 32-32v-32c0-17.7-14.3-32-32-32z"/></svg>
					</span><div class="ages_toggle">';
					foreach($array_ages as $ages){
						$return .= '<p>'.$ages.'</p>';
					}
					$return .= '</div></div>';
				}
			}
			return $return;
		}

		public function camps_topbsnss_function(){
			$return = '';
			$get_author = sanitize_text_field($_GET['topBsnss']);
			if($get_author){
				$camps = array(
					'post_type' => 'topcampamentos', 
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'author'	=> $get_author,
				);
				$camps = get_posts($camps);
				if(!empty($camps)){
					$return = '<div class="container_camps_page_seo"><div class="content_camps">';
					foreach($camps as $camp){
						$post_id = $camp->ID;
						$port_media = get_post_meta($post_id, 'portada_camp', true);
						$activity = get_post_meta($post_id, 'actividades', true);
						$region = get_post_meta($post_id, 'region', true);
						$price = json_decode(get_post_meta($post_id, 'cluecamp', true));
						$ages_write = $this->print_the_ages_in_cards($price);
						$destc_plan = get_post_meta($post_id, 'certify_by_TOP', true);
						$destc_plan_30 = get_post_meta($post_id, 'venc_camp_dest_30', true);
						if($destc_plan){
							$destc_plan = '<div class="destc_pack_camp">
												<div class="content_dest_pack_camp">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
													<span>Campamento verificado</span>
												</div>
											</div>';
						}else if (time() < $destc_plan_30){
							$destc_plan = '<div class="destc_pack_camp">
												<div class="content_dest_pack_camp">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
													<span>Destacado</span>
												</div>
											</div>';
						}else{
							$destc_plan = '';
						}
						$lang = get_post_meta($post_id, 'idioma', true);
						$langs = array();
						$lang_write = '';
						$write_price = array();
						$write_price_write = '';
						foreach($price as $k => $v) if($v->precio) $write_price[] = $v->precio;
						if(count($write_price) > 1){
							sort($write_price);
							$write_price_write = wc_price($write_price[0]) . ' - ' . wc_price(end($write_price));
						}else{
							$write_price_write = wc_price($write_price[0]);
						}
						foreach($lang as $k => $v) if(filter_var($v, FILTER_VALIDATE_BOOLEAN)) $langs[] = $k;
						$lang_write = $this->print_the_flags_in_cards($langs);
						$port_media = ($port_media) ? ((wp_get_attachment_url($port_media)) ? wp_get_attachment_url($port_media) : home_url('/wp-content/uploads/2023/05/Imagen-banner-top-2.jpg')) : home_url('/wp-content/uploads/2023/05/Imagen-banner-top-2.jpg');
						$return .= '<div class="container_listing_camp" cmpdlt="'.$post_id.'">
									<div class="head_img_listing">	
										<a href="'.get_permalink($post_id).'" title="Link al campamento '.get_the_title($post_id).'">
											<img src="'.$port_media.'" alt="Imagen de portada del campamento">
										</a>
										'.$destc_plan.'
										<span class="activity toggle_FILL"><a title="Link a los campamentos con la actividad '.$activity.'" href="'.home_url('resultados/?jsf=jet-engine&meta=actividades:'.$activity).'">'.$activity.'</a></span>
									</div>
									<div class="body_data_listing_camp">
										<div class="f1-row">
											<span class="title"><a href="'.get_permalink($post_id).'" title="Enlace al campamento '.get_the_title($post_id).'">'.get_the_title($post_id).'</a></span>
										</div>
										<div class="f2-row">
											<span class="ubication toggle_FILL"><a title="Link a los campamentos de la region '.$region.'" href="'.home_url('resultados/?jsf=jet-engine&meta=region:'.$region).'">'.$region.'</a></span>
										</div>
										<div class="f2-2-row">
											'.$ages_write.'
										</div>
										<div class="f3-row">
											'.$lang_write.'
										</div>
										<div class="f4-row">
											<span class="price_prefix">Precio:</span>
											<span class="price">'.$write_price_write.'</span>
										</div>
										<a class="view_camp" href="'.get_permalink($post_id).'" title="Link al campamento '.get_the_title($post_id).'">Ver ficha</a>
									</div>
								</div>';
					}
					$return .= '</div></div>';
				}
			}
			
			return $return;
		}

		public function title_topbsnss_function(){
			$return = '';
			$get_author = sanitize_text_field($_GET['topBsnss']);
			if($get_author){
				$company_name  = get_the_author_meta('display_name', $get_author);
				$return .= '<h1 class="title_bsnss_camps_top">'.$company_name.' campamentos</h1>';
			}else{
				wp_redirect(home_url('404'));
			}
			return $return;
		}
	}
	$GLOBAL['adpnsy'] = new adpnsy();
}