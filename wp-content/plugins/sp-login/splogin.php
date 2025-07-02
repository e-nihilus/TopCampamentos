<?php

/**
* Plugin Name: SP User
* Plugin URI: https://agenciasp.com
* Description: Complemento para gestion de login/resgitro/recuperar contraseña
* Author: Agencia Digital SP
* Author URI: https://agenciasp.com
* Version: 1.0.0
* Text Domain: spuser
*
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define('SPUSER_VER', '1.0.0');
define('SPUSER_PATH', realpath( dirname(__FILE__) ) );
define('SPUSER_URL', plugins_url('/', __FILE__) );
define('SPUSER_ACT', plugin_basename( __FILE__ ) );
define('SPUSER_RC_KEY', '6LfWkx0lAAAAANi1W4Jt88nYH7_quFY1YpVv5WcQ' );
define('SPUSER_RC_SCR', '6LfWkx0lAAAAANVYJweUZ4qjNBl1I6MJO7Qa5A96' );

//BD

//Añade el custom role para los gestor de campamentos
if( !function_exists("gestor_campamento") ){
	function gestor_campamento(){
		add_role("gestor_campamento", "Gestor de Campamentos", array(
			'read'	=> true,
			'edit_posts' => true,
			'publish_posts' => true,
		));
	}
}
//Añade el custom role para los gestor de campamentos

if( !function_exists("spuser_activation") ){
	function spuser_activation(){
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	    global $wpdb, $charset_collate;
	    $spuser_data = $wpdb->prefix . "spuser_data";
	    $spuser_recovery = $wpdb->prefix . "spuser_recovery";

	    if($wpdb->get_var("SHOW TABLES LIKE '$spuser_data'") != $spuser_data) {
	        dbDelta(
	        	"CREATE TABLE $spuser_data (
				    `id` bigint(20) AUTO_INCREMENT NOT NULL,
				    `nombre_comercial` varchar(255) NOT NULL DEFAULT '',
				    `nombre_fiscal` varchar(255) NOT NULL DEFAULT '',
				    `direccion` varchar(50) NOT NULL DEFAULT '',
				    `cif` varchar(255) NOT NULL DEFAULT '',
				    `poblacion` varchar(255) NOT NULL DEFAULT '',
				    `provincia` varchar(255) NOT NULL DEFAULT '',
				    `zip` varchar(255) NOT NULL DEFAULT '',
				    `responsable` varchar(255) NOT NULL DEFAULT '',
				    `telefono` varchar(255) NOT NULL DEFAULT '',
				    `movil` varchar(255) NOT NULL DEFAULT '',
				    `correo` varchar(255) NOT NULL DEFAULT '',
				    `pass` varchar(255) NOT NULL DEFAULT '',
				    `code` varchar(255) NOT NULL DEFAULT '',
				    `data_user` text(0) NOT NULL DEFAULT '',
				    PRIMARY KEY (`id`)
				) $charset_collate;"
	        );
	    }else{
	    	$wpdb->query("ALTER TABLE $spuser_data ADD COLUMN `extra` varchar(255) NOT NULL DEFAULT ''");
	    	$wpdb->query("ALTER TABLE $spuser_data ADD COLUMN `login` varchar(255) NOT NULL DEFAULT ''");
	    }

	    if($wpdb->get_var("SHOW TABLES LIKE '$spuser_recovery'") != $spuser_recovery) {
	        dbDelta(
	        	"CREATE TABLE $spuser_recovery (
	        		`user` varchar(255) NOT NULL DEFAULT '',
				    `key` varchar(255) NOT NULL DEFAULT '',
				    PRIMARY KEY (`user`)
				) $charset_collate;"
	        );
	    }

		$wpdb->query("ALTER TABLE $spuser_data MODIFY direccion varchar(50) NOT NULL");
	}
}

register_activation_hook(__FILE__, "spuser_activation");
add_action('init', 'gestor_campamento');

include 'splogin_init.php';