<?php
namespace PowerpackElements\Modules\DisplayConditions\Conditions;

// Powerpack Elements Classes
use PowerpackElements\Base\Condition;

// Elementor Classes
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * \Extensions\Conditions\Static_Page
 *
 * @since  1.4.13.1
 */
class Static_Page extends Condition {

	/**
	 * Get Group
	 *
	 * Get the group of the condition
	 *
	 * @since  1.4.13.1
	 * @return string
	 */
	public function get_group() {
		return 'single';
	}

	/**
	 * Get Name
	 *
	 * Get the name of the module
	 *
	 * @since  1.4.13.1
	 * @return string
	 */
	public function get_name() {
		return 'static_page';
	}

	/**
	 * Get Title
	 *
	 * Get the title of the module
	 *
	 * @since  1.4.13.1
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Static Page', 'powerpack' );
	}

	/**
	 * Get Value Control
	 *
	 * Get the settings for the value control
	 *
	 * @since  1.4.13.1
	 * @return string
	 */
	public function get_value_control() {
		return [
			'type'          => Controls_Manager::SELECT,
			'default'       => 'home',
			'label_block'   => true,
			'options'       => [
				'home'      => esc_html__( 'Homepage', 'powerpack' ),
				'static'    => esc_html__( 'Front Page', 'powerpack' ),
				'blog'      => esc_html__( 'Blog', 'powerpack' ),
				'404'       => esc_html__( '404 Page', 'powerpack' ),
			],
		];
	}

	/**
	 * Check condition
	 *
	 * @since 1.4.13.1
	 *
	 * @access public
	 *
	 * @param string    $name       The control name to check
	 * @param string    $operator   Comparison operator
	 * @param mixed     $value      The control value to check
	 */
	public function check( $name, $operator, $value ) {
		if ( 'home' === $value ) {
			return $this->compare( ( is_front_page() && is_home() ), true, $operator );
		} elseif ( 'static' === $value ) {
			return $this->compare( ( is_front_page() && ! is_home() ), true, $operator );
		} elseif ( 'blog' === $value ) {
			return $this->compare( ( ! is_front_page() && is_home() ), true, $operator );
		} elseif ( '404' === $value ) {
			return $this->compare( is_404(), true, $operator );
		}
	}
}
