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
 * \Modules\DisplayConditions\Conditions\Condition
 *
 * @since  2.2.2
 */
class Post_Term extends Condition {

	/**
	 * Get Group
	 *
	 * Get the group of the condition
	 *
	 * @since  2.2.2
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
	 * @since  2.2.2
	 * @return string
	 */
	public function get_name() {
		return 'post_term';
	}

	/**
	 * Get Title
	 *
	 * Get the title of the module
	 *
	 * @since  2.2.2
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Post Term', 'powerpack' );
	}

	/**
	 * Get Value Control
	 *
	 * Get the settings for the value control
	 *
	 * @since  2.2.2
	 * @return string
	 */
	public function get_value_control() {

		return [
			'description'   => esc_html__( 'Leave blank or select all for any term.', 'powerpack' ),
			'type'          => 'pp-query',
			'post_type'     => '',
			'options'       => [],
			'label_block'   => true,
			'multiple'      => true,
			'query_type'    => 'terms',
			'object_type'   => '',
			'include_type'  => true,
		];
	}

	/**
	 * Check condition
	 *
	 * @since 2.2.2
	 *
	 * @access public
	 *
	 * @param string    $name       The control name to check
	 * @param string    $operator   Comparison operator
	 * @param mixed     $value      The control value to check
	 */
	public function check( $name, $operator, $value ) {
		$value  = (array) $value;

		if ( ! $value || empty( $value ) ) {
			return $this->compare( true, true, $operator );
		}

		$show = false;

		foreach ( $value as $term_id ) {
			$term = get_term( $term_id );

			if ( ! empty( $term ) && ! is_wp_error( $term ) && has_term( $term->name, $term->taxonomy ) ) {
				$show = true;
				break;
			}
		}

		return $this->compare( $show, true, $operator );
	}
}
