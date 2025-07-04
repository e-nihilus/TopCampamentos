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
 * \Extensions\Conditions\Os
 *
 * @since  1.4.13.1
 */
class Os extends Condition {

	/**
	 * Get Group
	 *
	 * Get the group of the condition
	 *
	 * @since  1.4.13.1
	 * @return string
	 */
	public function get_group() {
		return 'misc';
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
		return 'os';
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
		return esc_html__( 'Operating System', 'powerpack' );
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
			'default'       => array_keys( $this->get_os_options() )[0],
			'label_block'   => true,
			'options'       => $this->get_os_options(),
		];
	}

	/**
	 * Get OS options for control
	 *
	 * @since 1.4.13.1
	 *
	 * @access protected
	 */
	protected function get_os_options() {
		$oses = [
			'iphone'        => 'iPhone',
			'android'       => 'Android',
			'windows'       => 'Windows',
			'open_bsd'      => 'OpenBSD',
			'sun_os'        => 'SunOS',
			'linux'         => 'Linux',
			'mac_os'        => 'Mac OS',
		];

		return apply_filters( 'ppe_os_display_condition_options', $oses );
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
		$oses = [
			'iphone'            => '(iPhone)',
			'android'           => '(Android)',
			'windows'           => 'Win16|(Windows 95)|(Win95)|(Windows_95)|(Windows 98)|(Win98)|(Windows NT 5.0)|(Windows 2000)|(Windows NT 5.1)|(Windows XP)|(Windows NT 5.2)|(Windows NT 6.0)|(Windows Vista)|(Windows NT 6.1)|(Windows 7)|(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)|Windows ME',
			'open_bsd'          => 'OpenBSD',
			'sun_os'            => 'SunOS',
			'linux'             => '(Linux)|(X11)',
			'mac_os'            => '(Mac_PowerPC)|(Macintosh)',
		];

		$oses = apply_filters( 'ppe_os_display_condition_check', $oses );

		return $this->compare( preg_match( '@' . $oses[ $value ] . '@', $_SERVER['HTTP_USER_AGENT'] ), true, $operator );
	}
}
