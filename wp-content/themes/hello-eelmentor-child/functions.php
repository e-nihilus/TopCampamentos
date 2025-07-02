<?php
/*
 * This is the child theme for Hello Elementor theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
add_action( 'wp_enqueue_scripts', 'hello_eelmentor_child_enqueue_styles' );
function hello_eelmentor_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

function no_update_camps_admin($post_id, $post) {
    if ($post['post_type'] === 'topcampamentos') {
        if (current_user_can('administrator')) {
            wp_die('No tienes permiso para guardar o actualizar este post.');
        }
    }
}
add_action('pre_post_update', 'no_update_camps_admin', 10, 2);

function no_fastupdate_camps_admin($post_id) {
    $post_type = get_post_type($post_id);
    if ($post_type === 'topcampamentos') {
        if (current_user_can('administrator')) {
            wp_die('No tienes permiso para guardar o actualizar este post.');
        }
    }
}
add_action('pre_post_update_quick_edit', 'no_fastupdate_camps_admin');

// ---- Shortcode banderas header ------
function banderas_header_TOP_Campamentos(){
	global $post;
	$post_id = $post->ID;
	$post_type = get_post_type($post_id);
	if($post_type !== 'topcampamentos'){
		$current_language = pll_current_language();
		$languages = pll_the_languages(array(
		'raw' => 1,
		'hide_if_empty' => 0,
		'hide_current' => 0,
		'echo' => 0 
		));
		$current_language_data = $languages[$current_language]; 
		return '<div class="info_banderas_select_header">
					<div class="current_lang">
						<span><img src="'.$current_language_data['flag'].'" alt="'.$current_language_data['name'].'"></span>
						<span>'.$current_language_data['name'].' <i class="fas fa-chevron-down"></i></span>
					</div>
					<div class="other_langs">
						<ul id="language-switcher">
							'. pll_the_languages( array(
							'show_flags' => 1,
							'show_names' => 1,
							'display_names_as' => 'name',
							'hide_if_empty' => 0,
							'hide_current' => 0,
							'echo' => 1,
							'menu' => 0
							) ) .'
						</ul>
					</div>
				 </div>';
	}else{
		return ''; 
	}
	
}

add_shortcode('banderas_select_header', 'banderas_header_TOP_Campamentos');
// ---- Shortcode banderas header ------

// ---- JS/CSS ------
function custom_cssJs_TOP_Campamentos(){
	wp_enqueue_style('custom-css', get_stylesheet_directory_uri() . '/customAssets/css/custom-style.css', [], time());
	wp_enqueue_style('custom-css', get_stylesheet_directory_uri() . '/customAssets/glider/glider.min.css');
	wp_enqueue_script('functions', get_stylesheet_directory_uri() . '/customAssets/js/custom-js-functions.js', array('jquery'), time(), true );
	wp_enqueue_script('glider', get_stylesheet_directory_uri() . '/customAssets/glider/glider.min.js', array(), '', true);
	if(get_post_type() == 'topcampamentos'){
		wp_enqueue_script( 'script-name', get_stylesheet_directory_uri() . '/customAssets/js/custom-js.js', array('jquery'), '1.0.0', true );
		global $post;
		$post_id = $post->ID;
		$clue_camp = json_decode(get_post_meta($post_id, 'cluecamp', true));
		$plazas_disp = get_post_meta($post_id, 'plazas_disp', true);
		$return = array();
		$msg_rr = true;
		if(!empty($clue_camp) && (is_array($clue_camp) || is_object($clue_camp))){
			foreach($clue_camp as $k => $v){
				if($v->fecha_inicio && $v->fechas_final && $v->precio && $v->{'mes-temporada'} && $v->duracion && $v->edades && $v->plazas_num){
					$fc = strtotime(date_format_cluecamp($v->fecha_inicio, false));
					$cd = strtotime(date('Y-m-d'));
					if($fc > $cd){
						$msg_rr = false;
						$v->fecha_inicio = date_format_cluecamp($v->fecha_inicio);
						$v->fechas_final = date_format_cluecamp($v->fechas_final);
						$return[$k] = $v;
					}
				}
			}
		}
		$cmsn = get_option('comi_booking');
		if($cmsn === false || $cmsn === null || $cmsn === '') $cmsn = 15;
		$vrf = array(
			'url'   	 	=> admin_url( 'admin-ajax.php' ),
			'nonce'  		=> wp_create_nonce( 'booking' ),
			'cluecamp_book' => $return,
			'plazas_disp'	=> $plazas_disp,
			'comi'			=> $cmsn,
			'sms'			=> (bool)$msg_rr,
			'home_url'		=> home_url(),
		);
		wp_localize_script('script-name', 'ajax', $vrf);
	}
	$vrf_f = array(
		'url'   	 	=> admin_url('admin-ajax.php'),
		'nonce'  		=> wp_create_nonce('wishlist'),
	);
	wp_localize_script('functions', 'ajax', $vrf_f);
}

function date_format_cluecamp($date, $type = 1){
	if($type != 1){
		$fc = explode('/', $date);
		return $fc[2].'-'.$fc[1].'-'.$fc[0];
	}
	return $date;
}

add_action( 'wp_enqueue_scripts', 'custom_cssJs_TOP_Campamentos' );
// ---- JS/CSS ------


// ---------- redirect user campers -------------------

function redirect_users_TOP( $redirect, $user ) {
	$roles = $user->roles;
	if(in_array('administrator', $roles) || in_array('gestor_campamento', $roles)){
		$redirect = home_url("/dashboard/");
		return $redirect;
	}else{
		$redirect = home_url();
		return $redirect;
	}
   
}
add_filter( 'woocommerce_login_redirect', 'redirect_users_TOP', 10, 2 );


// ---------- redirect user campers -------------------


// ---------- Loader ------------------

function loader_content_TOP_css(){ ?><style>.the_unick_very_loader_of_TOP {position: fixed;top: 0;left: 0;z-index: 1000000000000000000000000000000000;width: 100%;height: 100%;background: #fff;display: flex;justify-content: center;align-items: center;}.the_unick_very_loader_of_TOP .lds-dual-ring {display: inline-block;width: 80px;height: 80px;}.the_unick_very_loader_of_TOP .lds-dual-ring:after {content: " ";display: block;width: 80px;height: 80px;margin: 8px;border-radius: 50%;border: 6px solid #fff;border-color: #f30c0c transparent #f30c0c transparent;animation: lds-dual-ring 1.2s linear infinite;}@keyframes lds-dual-ring {0% {transform: rotate(0deg);}100% {transform: rotate(360deg);}}.the_unick_very_loader_of_TOP.disable {display: none !important;}</style><?php }
add_action('wp_head', 'loader_content_TOP_css');

function custom_filter_content($content) {
    $modified_content = '<script>let loaderGlobal=document.createElement("div"),load=document.createElement("div");loaderGlobal.className="the_unick_very_loader_of_TOP",load.className="lds-dual-ring",loaderGlobal.appendChild(load),document.body.appendChild(loaderGlobal),jQuery(document).ready((function(e){e(".the_unick_very_loader_of_TOP").addClass("disable")}));</script>' . $content;
    return $modified_content;
}
add_filter('the_content', 'custom_filter_content');

// ---------- Loader ------------------

// ---------- disable mails for customers ---------------

add_filter( 'woocommerce_email_enabled_customer_invoice', '__return_false' );
add_filter( 'woocommerce_email_enabled_customer_note', '__return_false' );
add_filter( 'woocommerce_email_enabled_low_stock', '__return_false' );
add_filter( 'woocommerce_email_enabled_no_stock', '__return_false' );
add_filter( 'woocommerce_email_enabled_order_refunded', '__return_false' );

// ---------- disable mails for customers ---------------

add_filter('woocommerce_order_item_name', 'cambiar_nombre_producto_en_gracias', 10, 3);
function cambiar_nombre_producto_en_gracias($product_name, $item, $order) {
    if (is_order_received_page() && $order) {
        $product_id = $item->get_product_id();
        if($product_id == 236){
        	return $camp_id = $item->get_meta('title_camp');
        }        
    }
    return $product_name;
}

add_filter('woocommerce_order_item_permalink', 'cambiar_enlace_producto_en_gracias', 10, 3);
function cambiar_enlace_producto_en_gracias($permalink, $item, $order) {   
    return "";
}

add_action('pre_get_posts', 'modificar_wp_query');

function modificar_wp_query($query) {
	if(isset($query->query['jet_smart_filters'])){
		global $wpdb;
		$posts_meta = $wpdb->prefix . "postmeta";
		$current_time = time();
		$wpdb->query("DELETE FROM {$posts_meta} WHERE meta_key = 'venc_camp_dest_30' AND meta_value < {$current_time}");
	    $meta_query = array(array(
	      'relation' => 'OR',
	      array(
	        'key' => 'venc_camp_dest_30',
	        'compare' => 'EXISTS',
	      ),
	      array(
	        'key' => 'venc_camp_dest_30',
	        'compare' => 'NOT EXISTS',
	      )
	    ));

	    $meta_query[] = $query->get('meta_query');

	    $query->set('meta_query', $meta_query);
	    $query->set('orderby', 'venc_camp_dest_30');
	    $query->set('order', 'ASC');
	}
}

add_action( 'template_redirect', 'redirect_top_results' );
function redirect_top_results() {
    if ( is_cart() || is_shop() ) {
        wp_redirect(home_url('/resultados/'));
        exit;
    }
}

function remove_cpt_business() {
    unregister_post_type('empresa');
}
add_action('init', 'remove_cpt_business');

add_filter( 'woocommerce_order_button_text', 'change_checkout_button_text', 10, 1 );
function change_checkout_button_text( $button_text ) {
    $button_text = 'Realizar solicitud';
    return $button_text;
}

/*
 * Your code goes below
 */