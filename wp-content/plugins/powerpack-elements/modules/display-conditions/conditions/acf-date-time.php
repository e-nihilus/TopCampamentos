<?php
namespace PowerpackElements\Modules\DisplayConditions\Conditions;

// Powerpack Elements Classes
use PowerpackElements\Base\Condition;
use PowerpackElements\Modules\DisplayConditions\Module;

// Elementor Classes
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Acf_Date_Time extends Acf_Base {

	/**
	 * Get Name
	 *
	 * Get the name of the module
	 *
	 * @since  1.4.15
	 * @return string
	 */
	public function get_name() {
		return 'acf_date_time';
	}

	/**
	 * Get Title
	 *
	 * Get the title of the module
	 *
	 * @since  1.4.15
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'ACF Date / Time', 'powerpack' );
	}

	/**
	 * Get Name Control
	 *
	 * Get the settings for the name control
	 *
	 * @since  1.4.15
	 * @return array
	 */
	public function get_name_control() {
		return wp_parse_args( [
			'description'   => esc_html__( 'Search ACF "Date" and "Date Time" fields by label.', 'powerpack' ),
			'placeholder'   => esc_html__( 'Search Fields', 'powerpack' ),
			'query_options' => [
				'field_type'    => [
					'date',
				],
				'show_field_type' => true,
			],
		], $this->name_control_defaults );
	}

	/**
	 * Get Value Control
	 *
	 * Get the settings for the value control
	 *
	 * @since  1.4.15
	 * @return array
	 */
	public function get_value_control() {
		$default_date_start = date( 'Y-m-d', strtotime( '-3 day' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );

		return [
			'label'     => esc_html__( 'Before', 'powerpack' ),
			'type'      => \Elementor\Controls_Manager::DATE_TIME,
			'picker_options' => [
				'enableTime' => true,
			],
			'label_block'   => true,
			'default'       => $default_date_start,
		];
	}

	/**
	 * Check condition
	 *
	 * @since 1.4.15
	 *
	 * @access public
	 *
	 * @param string    $name       The control name to check
	 * @param string    $operator   Comparison operator
	 * @param mixed     $value      The control value to check
	 */
	public function check( $key, $operator, $value ) {
		$show = false;

		global $post;

		$field_settings = get_field_object( $key );

		if ( $field_settings ) {

			$field_format   = $field_settings['return_format'];
			$field_db_value = acf_get_metadata( $post->ID, $field_settings['name'] );

			// ACF saves values in these formats in the database
			// We use the db values to bypass days and months translations
			// not supported by PHP's DateTime
			$field_db_format = 'date_time_picker' === $field_settings['type'] ? 'Y-m-d H:i:s' : 'Ymd';

			// Create date based on saved format
			$date = \DateTime::createFromFormat( $field_db_format, $field_db_value );

			// Make sure it's a valid date
			if ( ! $date ) {
				return; }

			// Convert to timestamps
			$field_value_ts = strtotime( $date->format( $field_format ) ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
			$value_ts       = strtotime( $value ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );

			// Set display condition
			$show = $field_value_ts < $value_ts;
		}

		return $this->compare( $show, true, $operator );
	}
}
