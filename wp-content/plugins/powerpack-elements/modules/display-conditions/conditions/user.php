<?php
namespace PowerpackElements\Modules\DisplayConditions\Conditions;

// Powerpack Elements Classes
use PowerpackElements\Base\Condition;

// Elementor Classes
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class User extends Condition {

	/**
	 * Get Group
	 *
	 * Get the group of the condition
	 *
	 * @since  2.2.0
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
	 * @since  2.2.0
	 * @return string
	 */
	public function get_name() {
		return 'user';
	}

	/**
	 * Get Title
	 *
	 * Get the title of the module
	 *
	 * @since  2.2.0
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Current User', 'powerpack' );
	}

	/**
	 * Get Value Control
	 *
	 * Get the settings for the value control
	 *
	 * @since  2.2.0
	 * @return string
	 */
	public function get_value_control() {
		return [
			'type'          => 'pp-query',
			'default'       => '',
			'placeholder'   => esc_html__( 'Any', 'powerpack' ),
			'description'   => esc_html__( 'Works only when visitor is a logged in user. Leave blank for all users.', 'powerpack' ),
			'multiple'      => true,
			'label_block'   => true,
			'query_type'    => 'users',
		];
	}

	/**
	 * Check condition
	 *
	 * @since 2.2.0
	 *
	 * @access public
	 *
	 * @param string    $name       The control name to check
	 * @param string    $operator   Comparison operator
	 * @param mixed     $value      The control value to check
	 */
	public function check( $name, $operator, $value ) {
		$show = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {
				if ( $_value == get_current_user_id() ) {
					$show = true;
					break;
				}
			}
		} else {
			$show = $value == get_current_user_id(); }

		return $this->compare( $show, true, $operator );
	}
}
