<?php

namespace JET_ABAF\Dashboard\Pages;

use JET_ABAF\Dashboard\Helpers\Page_Config;
use JET_ABAF\Price;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

class Bookings extends Base {

	/**
	 * Page slug.
	 *
	 * @return string
	 */
	public function slug() {
		return 'jet-abaf-bookings';
	}

	/**
	 * Page title.
	 *
	 * @return string
	 */
	public function title() {
		return __( 'Bookings', 'jet-booking' );
	}

	/**
	 * Page config.
	 *
	 * Return page config object.
	 *
	 * @since  2.8.0 Added Booking post type order & WC integration configuration parameters.
	 * @since  3.2.0 Added `apartment_id` filter.
	 *
	 * @return Page_Config
	 */
	public function page_config() {

		do_action( 'jet-abaf/dashboard/bookings-page/before-page-config' );

		$config = [
			'api'                => jet_abaf()->rest_api->get_urls( false ),
			'ajax_url'           => esc_url( admin_url( 'admin-ajax.php' ) ),
			'booking_mode'       => jet_abaf()->settings->get( 'booking_mode' ),
			'bookings'           => $this->get_bookings(),
			'bookings_units'     => $this->get_bookings_units(),
			'bookings_list'      => jet_abaf()->db->query(),
			'statuses_schema'    => jet_abaf()->statuses->get_schema(),
			'all_statuses'       => jet_abaf()->statuses->get_statuses(),
			'columns'            => jet_abaf()->db->get_default_fields(),
			'additional_columns' => jet_abaf()->db->get_additional_db_columns(),
			'monday_first'       => get_option( 'start_of_week' ) ? true : false,
			'filters'            => [
				'apartment_id'   => [
					'type'       => 'select',
					'label'      => __( 'Instance', 'jet-booking' ),
					'value'      => $this->get_bookings(),
					'visibility' => true,
				],
				'status'         => [
					'type'       => 'select',
					'label'      => __( 'Status', 'jet-booking' ),
					'value'      => jet_abaf()->statuses->get_statuses(),
					'visibility' => true,
				],
				'check_in_date'  => [
					'type'       => 'date-picker',
					'label'      => __( 'Check In', 'jet-booking' ),
					'value'      => '',
					'visibility' => true,
				],
				'check_out_date' => [
					'type'       => 'date-picker',
					'label'      => __( 'Check Out', 'jet-booking' ),
					'value'      => '',
					'visibility' => true,
				],
			],
			'edit_link'          => add_query_arg( [
				'post'   => '%id%',
				'action' => 'edit',
			], admin_url( 'post.php' ) ),
			'export_nonce'       => jet_abaf()->export->get_nonce(),
			'export_url'         => jet_abaf()->export->base_url(),
		];

		if ( jet_abaf()->settings->get( 'related_post_type' ) ) {
			$config['order_post_type']          = jet_abaf()->settings->get( 'related_post_type' );
			$config['order_post_type_statuses'] = get_post_statuses();
		}

		return new Page_Config( $this->slug(), $config );

	}

	/**
	 * Get bookings.
	 *
	 * Returns all registered bookings list.
	 *
	 * @since  2.0.0
	 * @since  2.6.0 Code refactor.
	 *
	 * @return array
	 */
	public function get_bookings() {

		$posts = jet_abaf()->tools->get_booking_posts();

		if ( empty( $posts ) ) {
			return [];
		}

		return wp_list_pluck( $posts, 'post_title', 'ID' );

	}

	/**
	 * Get bookings units.
	 *
	 * Returns all registered bookings units.
	 *
	 * @since  3.0.1
	 * @access public
	 *
	 * @return array
	 */
	public function get_bookings_units() {

		$posts = jet_abaf()->tools->get_booking_posts();
		$units = [];

		if ( empty( $posts ) ) {
			return $units;
		}

		foreach ( $posts as $post ) {
			$apartment_units = jet_abaf()->db->get_apartment_units( $post->ID );

			if ( ! empty( $apartment_units ) ) {
				foreach ( $apartment_units as $apartment_unit ) {
					$units[ $post->ID ][ $apartment_unit['unit_id'] ] = $apartment_unit['unit_title'];
				}
			}
		}

		return $units;

	}

	/**
	 * Render.
	 *
	 * Page render function.
	 *
	 * @since  2.0.0
	 * @since  2.5.4 Added `jquery-date-range-picker` styles.
	 * @since  3.0.0 Refactored.
	 * @access public
	 *
	 * @return void
	 */
	public function render() {
		echo '<div id="jet-abaf-bookings-page"></div>';
	}

	/**
	 * Assets.
	 *
	 * Dashboard booking page specific assets.
	 *
	 * @since  2.0.0
	 * @since  2.5.4 Added `moment-js`, `jquery-date-range-picker` scripts and style. Remove `vuejs-datepicker`.
	 * @since  2.8.0 Added `vuejs-datepicker` script for filtering.
	 * @since  3.0.0 Added `dashboard` styles from parent class.
	 * @access public
	 *
	 * @return void
	 */
	public function assets() {

		parent::assets();

		$this->enqueue_script( 'vuex', 'assets/js/admin/lib/vuex.min.js' );
		$this->enqueue_script( 'jet-plugins', 'assets/lib/jet-plugins/jet-plugins.js', [ 'jquery' ] );
		$this->enqueue_script( 'moment-js', 'assets/lib/moment/js/moment.js' );
		$this->enqueue_script( 'jquery-date-range-picker-js', 'assets/lib/jquery-date-range-picker/js/daterangepicker.min.js', [ 'jquery', 'moment-js', 'jet-plugins' ] );
		$this->enqueue_script( 'vuejs-datepicker', 'assets/js/lib/vuejs-datepicker.min.js' );
		$this->enqueue_script( 'jet-abaf-meta-extras', 'assets/js/admin/meta-extras.js' );
		$this->enqueue_script( 'v-calendar', 'assets/js/admin/lib/v-calendar.umd.min.js' );
		$this->enqueue_script( 'v-gantt-chart', 'assets/js/admin/lib/v-gantt-chart.umd.min.js' );

		$this->enqueue_script( $this->slug(), 'assets/js/admin/bookings.js' );

		$this->enqueue_style( 'jquery-date-range-picker-css', 'assets/lib/jquery-date-range-picker/css/daterangepicker.css' );

	}

	/**
	 * Vue templates.
	 *
	 * Page components templates.
	 *
	 * @since  2.8.0 Added `bookings-filter` template.
	 * @access public
	 *
	 * @return array
	 */
	public function vue_templates() {
		return [
			'add-new-booking',
			'bookings',
			'bookings-calendar',
			'bookings-filter',
			'bookings-list',
			'bookings-timeline',
			'bookings-view',
			'popup',
		];
	}

	public function __construct() {

		// Price calculation and display after date selection in admin area for add & edit popups.
		add_action( 'wp_ajax_jet_booking_product_get_total_price', [ $this, 'get_booking_total_price' ] );

		// Retrieves the apartment configuration status.
		add_action( 'wp_ajax_jet_booking_get_apartment_config', [ $this, 'get_booking_apartment_config' ] );

	}

	/**
	 * Get booking total price.
	 *
	 * Price calculation and display after date selection in admin area for add & edit popups.
	 *
	 * @since  3.0.0
	 * @since  3.2.0 Added `$booking` parameter to `jet-booking/booking-total-price` hook.
	 * @since  3.6.4 Fixed dates format issue.
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function get_booking_total_price() {

		if ( empty( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'jet-abaf-bookings' ) ) {
			wp_send_json_error();
		}

		$booking = $_REQUEST['booking'] ?? [];

		if ( empty( $booking ) ) {
			wp_send_json_error();
		}

		$check_in_date  = \DateTime::createFromFormat( get_option( 'date_format' ), $booking['check_in_date'] );
		$check_out_date = \DateTime::createFromFormat( get_option( 'date_format' ), $booking['check_out_date'] );

		if ( $check_in_date && $check_out_date ) {
			$booking['check_in_date']  = $check_in_date->getTimestamp();
			$booking['check_out_date'] = $check_out_date->getTimestamp();
		} else {
			$booking['check_in_date']  = strtotime( $booking['check_in_date'] );
			$booking['check_out_date'] = strtotime( $booking['check_out_date'] );
		}

		$price = new Price( $booking['apartment_id'] );

		$response['price'] = apply_filters( 'jet-booking/booking-total-price', $price->get_booking_price( $booking ), $booking );

		wp_send_json_success( $response );

	}

	/**
	 * Retrieves the apartment configuration for a given apartment ID.
	 *
	 * This function handles an AJAX request to fetch the apartment configuration for a specific post ID,
	 * and returns the apartment configuration status.
	 *
	 * @since 3.6.2
	 *
	 * @return void
	 */
	public function get_booking_apartment_config() {

		if ( empty( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'jet-abaf-bookings' ) ) {
			wp_send_json_error();
		}

		$post_id = $_REQUEST['postId'] ?? null;

		if ( ! $post_id ) {
			wp_send_json_error();
		}

		wp_send_json_success( [
			'apartment_config' => jet_abaf()->settings->get_config_setting( $post_id, 'enable_config' ),
		] );

	}

}