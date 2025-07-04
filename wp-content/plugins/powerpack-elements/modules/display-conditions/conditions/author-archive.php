<?php
namespace PowerpackElements\Modules\DisplayConditions\Conditions;

// Powerpack Elements Classes
use PowerpackElements\Base\Condition;
use PowerpackElements\Classes\PP_Posts_Helper;

// Elementor Classes
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * \ExtensionsConditions\Author_Archive
 *
 * @since  1.4.13.1
 */
class Author_Archive extends Condition {

	/**
	 * Get Group
	 *
	 * Get the group of the condition
	 *
	 * @since  1.4.13.1
	 * @return string
	 */
	public function get_group() {
		return 'archive';
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
		return 'author_archive';
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
		return esc_html__( 'Author', 'powerpack' );
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
		/*return [
			'type'				=> Controls_Manager::SELECT2,
			'default' 		=> '',
			'placeholder'	=> esc_html__( 'Any', 'powerpack' ),
			'description'	=> esc_html__( 'Leave blank for all authors.', 'powerpack' ),
			'multiple'		=> true,
			'label_block' 	=> true,
			'options'			=> PP_Posts_Helper::get_users(),
		];*/

		return [
			'type'                  => 'pp-query',
			'placeholder'           => esc_html__( 'Any', 'powerpack' ),
			'description'           => esc_html__( 'Leave blank for all authors.', 'powerpack' ),
			'label_block'           => true,
			'multiple'              => true,
			'query_type'            => 'authors',
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
		$show = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {
				if ( is_author( $_value ) ) {
					$show = true;
					break;
				}
			}
		} else {
			$show = is_author( $value ); }

		return $this->compare( $show, true, $operator );
	}
}
