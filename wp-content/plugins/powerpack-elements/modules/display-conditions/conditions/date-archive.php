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
 * \ExtensionsConditions\Date_Archive
 *
 * @since  1.4.13.1
 */
class Date_Archive extends Condition {

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
		return 'date_archive';
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
		return esc_html__( 'Date', 'powerpack' );
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
			'type'          => Controls_Manager::SELECT2,
			'default'       => '',
			'placeholder'   => esc_html__( 'Any', 'powerpack' ),
			'description'   => esc_html__( 'Leave blank or select all for any date based archive.', 'powerpack' ),
			'multiple'      => true,
			'label_block'   => true,
			'options'       => [
				'day'       => esc_html__( 'Day', 'powerpack' ),
				'month'     => esc_html__( 'Month', 'powerpack' ),
				'year'      => esc_html__( 'Year', 'powerpack' ),
			],
		];
	}

	/**
	 * Checks a given date type against the current page template
	 *
	 * @since 1.4.13.1
	 *
	 * @access protected
	 *
	 * @param string  $type  The type of date archive to check against
	 */
	protected function check_date_archive_type( $type ) {
		if ( 'day' === $type ) { // Day
			return is_day();
		} elseif ( 'month' === $type ) { // Month
			return is_month();
		} elseif ( 'year' === $type ) { // Year
			return is_year();
		}

		return false;
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
				if ( $this->check_date_archive_type( $_value ) ) {
					$show = true;
					break;
				}
			}
		} else {
			$show = is_date( $value ); }

		return $this->compare( $show, true, $operator );
	}
}
