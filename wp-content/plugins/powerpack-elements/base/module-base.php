<?php
namespace PowerpackElements\Base;

use PowerpackElements\Classes\PP_Admin_Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Module_Base {

	/**
	 * @var \ReflectionClass
	 */
	private $reflection;

	private $components = array();

	/**
	 * @var Module_Base
	 */
	protected static $_instances = array();

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'powerpack' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'powerpack' ), '1.0.0' );
	}

	public static function is_active() {
		return true;
	}

	public static function class_name() {
		return get_called_class();
	}

	/**
	 * @return static
	 */
	public static function instance() {
		if ( empty( static::$_instances[ static::class_name() ] ) ) {
			static::$_instances[ static::class_name() ] = new static();
		}

		return static::$_instances[ static::class_name() ];
	}

	abstract public function get_name();

	public function get_widgets() {
		return array();
	}

	public function __construct() {
		$this->reflection = new \ReflectionClass( $this );

		add_action( 'elementor/widgets/register', array( $this, 'init_widgets' ) );
	}

	public function init_widgets() {
		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

		foreach ( $this->get_widgets() as $widget ) {
			$widget_name     = strtolower( $widget );
			$widget_filename = 'pp-' . str_replace( '_', '-', $widget_name );

			if ( $this->is_widget_active( $widget_filename ) ) {
				$class_name = $this->reflection->getNamespaceName() . '\Widgets\\' . $widget;

				$widgets_manager->register( new $class_name() );
			}
		}
	}

	public static function is_widget_active( $widget = '' ) {
		$enabled_modules = pp_get_enabled_modules();

		if ( ! is_array( $enabled_modules ) ) {
			$enabled_modules = array();
		}

		if ( in_array( $widget, $enabled_modules ) || isset( $enabled_modules[ $widget ] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Add module component.
	 *
	 * Add new component to the current module.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @param string $id       Component ID.
	 * @param mixed  $instance An instance of the component.
	 */
	public function add_component( $id, $instance ) {
		$this->components[ $id ] = $instance;
	}

	/**
	 * Get Components.
	 *
	 * Retrieve the module components.
	 *
	 * @since 2.3.0
	 * @access public
	 * @return Module[]
	 */
	public function get_components() {
		return $this->components;
	}

	/**
	 * Get Component.
	 *
	 * Retrieve the module component.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @param string $id Component ID.
	 *
	 * @return mixed An instance of the component, or `false` if the component
	 *               doesn't exist.
	 */
	public function get_component( $id ) {
		if ( isset( $this->components[ $id ] ) ) {
			return $this->components[ $id ];
		}

		return false;
	}

	/**
	 * Get assets url.
	 *
	 * @since 2.11.0
	 * @access protected
	 *
	 * @param string $file_name
	 * @param string $file_extension
	 * @param string $relative_url Optional. Default is null.
	 * @param string $add_min_suffix Optional. Default is 'default'.
	 *
	 * @return string
	 */
	final protected function get_assets_url( $file_name, $file_extension, $relative_url = null, $add_min_suffix = 'default' ) {
		static $is_test_mode = null;

		if ( null === $is_test_mode ) {
			$is_test_mode = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || defined( 'ELEMENTOR_TESTS' ) && ELEMENTOR_TESTS;
		}

		if ( 'default' === $add_min_suffix ) {
			$add_min_suffix = ! $is_test_mode;
		}

		if ( ! $relative_url ) {
			$path         = ( $add_min_suffix ) ? '/min/' : '/';
			$relative_url = $this->get_assets_relative_url() . $file_extension . $path;
		}

		$url = $this->get_assets_base_url() . $relative_url . $file_name;

		if ( $add_min_suffix ) {
			$url .= '.min';
		}

		return $url . '.' . $file_extension;
	}

	/**
	 * Get css assets url
	 *
	 * @since 2.11.0
	 * @access protected
	 *
	 * @param string $file_name
	 * @param string $relative_url         Optional. Default is null.
	 * @param string $add_min_suffix       Optional. Default is 'default'.
	 * @param bool   $add_direction_suffix Optional. Default is `false`
	 *
	 * @return string
	 */
	final protected function get_css_assets_url( $file_name, $relative_url = null, $add_min_suffix = 'default', $add_direction_suffix = false ) {
		static $direction_suffix = null;

		if ( ! $direction_suffix ) {
			$direction_suffix = is_rtl() ? '-rtl' : '';
		}

		if ( $add_direction_suffix ) {
			$file_name .= $direction_suffix;
		}

		return $this->get_assets_url( $file_name, 'css', $relative_url, $add_min_suffix );
	}

	/**
	 * Get assets base url
	 *
	 * @since 2.11.0
	 * @access protected
	 *
	 * @return string
	 */
	protected function get_assets_base_url() {
		return POWERPACK_ELEMENTS_URL;
	}

	/**
	 * Get assets relative url
	 *
	 * @since 2.11.0
	 * @access protected
	 *
	 * @return string
	 */
	protected function get_assets_relative_url() {
		return 'assets/';
	}
}
