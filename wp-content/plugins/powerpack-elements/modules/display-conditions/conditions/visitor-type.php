<?php
namespace PowerpackElements\Modules\DisplayConditions\Conditions;

// Powerpack Elements Classes
use PowerpackElements\Base\Condition;

// Elementor Classes
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Visitor_Type extends Condition {

	/**
	 * Get Group
	 *
	 * Get the group of the condition
	 *
	 * @since  2.9.5
	 * @return string
	 */
	public function get_group() {
		return 'user';
	}

	/**
	 * Get Name
	 *
	 * Get the name of the module
	 *
	 * @since  2.9.5
	 * @return string
	 */
	public function get_name() {
		return 'visitor_type';
	}

	/**
	 * Get Title
	 *
	 * Get the title of the module
	 *
	 * @since  2.9.5
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Visitor Type', 'powerpack' );
	}

	/**
	 * Get Value Control
	 *
	 * Get the settings for the value control
	 *
	 * @since  2.9.5
	 * @return string
	 */
	public function get_value_control() {
		return [
			'type'          => Controls_Manager::SELECT,
			'description'   => esc_html__( 'Warning: This condition applies only to logged in visitors.', 'powerpack' ),
			'default'       => 'new',
			'label_block'   => true,
			'options'       => array(
				'new'       => esc_html__( 'First Time Visitor', 'powerpack' ),
				'returning' => esc_html__( 'Returning Visitor', 'powerpack' ),
			),
		];
	}

	/**
	 * Check condition
	 *
	 * @since 2.9.5
	 *
	 * @access public
	 *
	 * @param string    $name       The control name to check
	 * @param string    $operator   Comparison operator
	 * @param mixed     $value      The control value to check
	 */
	public function check( $name, $operator, $value ) {
		$show = 'new';

		if ( ! isset( $_COOKIE['PPEVisitorData'] ) && ! isset( $_COOKIE['PPENewVisitor'] ) ) {
			wp_add_inline_script(
				'elementor-frontend',
				'jQuery( window ).on( "elementor/frontend/init", function() {
					var current_time = new Date().getTime();
	
					var ppe_secure = ( document.location.protocol === "https:" ) ? "secure" : "";
					var visit_date = new Date( current_time + 1000 * 86400 * 365 ).toGMTString();
					var visit_date_expire = new Date( current_time + 86400 * 1000 ).toGMTString();
	
					document.cookie = "PPEVisitorData=enabled;expires=" + visit_date + "SameSite=Strict;" + ppe_secure;
					document.cookie = "PPENewVisitor=enabled;expires=" + visit_date_expire + "SameSite=Strict;" + ppe_secure;
				}); '
			);
		}

		if ( isset( $_COOKIE['PPEVisitorData'] ) && ! isset( $_COOKIE['PPENewVisitor'] ) ) {
			$show = 'returning';
		}

		return $this->compare( $show, $value, $operator );
	}
}
