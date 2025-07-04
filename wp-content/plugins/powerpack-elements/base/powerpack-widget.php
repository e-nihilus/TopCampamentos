<?php
/**
 * PowerPack Elements Common Widget.
 *
 * @package PowerPack Elements
 */

namespace PowerpackElements\Base;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use PowerpackElements\Classes\PP_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Common Widget
 *
 * @since 0.0.1
 */
abstract class Powerpack_Widget extends Widget_Base {

	/**
	 * Get categories
	 *
	 * @since 0.0.1
	 */
	public function get_categories() {
		return [ 'powerpack-elements' ];
	}

	public function get_woo_categories() {
		return [ 'powerpack-woocommerce' ];
	}

	/**
	 * Get widget name
	 *
	 * @param string $slug Module class.
	 * @since 1.4.13.1
	 */
	public function get_widget_name( $slug = '' ) {
		return PP_Helper::get_widget_name( $slug );
	}

	/**
	 * Get widget title
	 *
	 * @param string $slug Module class.
	 * @since 1.4.13.1
	 */
	public function get_widget_title( $slug = '' ) {
		return PP_Helper::get_widget_title( $slug );
	}

	/**
	 * Get widget title
	 *
	 * @param string $slug Module class.
	 * @since 1.4.13.1
	 */
	public function get_widget_categories( $slug = '' ) {
		return PP_Helper::get_widget_categories( $slug );
	}

	/**
	 * Get widget title
	 *
	 * @param string $slug Module class.
	 * @since 1.4.13.1
	 */
	public function get_widget_icon( $slug = '' ) {
		return PP_Helper::get_widget_icon( $slug );
	}

	/**
	 * Get widget title
	 *
	 * @param string $slug Module class.
	 * @since 1.4.13.1
	 */
	public function get_widget_keywords( $slug = '' ) {
		return PP_Helper::get_widget_keywords( $slug );
	}

	/**
	 * Add a placeholder for the widget in the elementor editor
	 *
	 * @access public
	 * @since 1.3.11
	 *
	 * @return void
	 */
	public function render_editor_placeholder( $args = array() ) {
		if ( ! \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
			return;
		}

		$defaults = [
			'title' => $this->get_title() . ' - ' . __( 'ID', 'powerpack' ) . ' ' . $this->get_id(),
			'body'  => __( 'This is a placeholder for this widget and is visible only in the editor.', 'powerpack' ),
		];

		$args = wp_parse_args( $args, $defaults );

		$this->add_render_attribute([
			'placeholder' => [
				'class' => 'pp-editor-placeholder',
			],
			'placeholder-title' => [
				'class' => 'pp-editor-placeholder-title',
			],
			'placeholder-content' => [
				'class' => 'pp-editor-placeholder-content',
			],
		]);

		?><div <?php echo wp_kses_post( $this->get_render_attribute_string( 'placeholder' ) ); ?>>
			<h4 <?php echo wp_kses_post( $this->get_render_attribute_string( 'placeholder-title' ) ); ?>>
				<?php echo wp_kses_post( $args['title'] ); ?>
			</h4>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'placeholder-content' ) ); ?>>
				<?php echo wp_kses_post( $args['body'] ); ?>
			</div>
		</div><?php
	}

	/**
	 * Get swiper slider settings
	 *
	 * @access public
	 * @since 1.4.13.1
	 */
	public function get_swiper_slider_settings( $settings, $new = true ) {
		$pagination = ( $new ) ? $settings['pagination'] : $settings['dots'];

		$effect      = ( isset( $settings['carousel_effect'] ) && ( $settings['carousel_effect'] ) ) ? $settings['carousel_effect'] : 'slide';
		$grab_cursor = ( isset( $settings['grab_cursor'] ) && ( 'yes' === $settings['grab_cursor'] ) ) ? true : false;

		$slider_options = [
			'direction'       => 'horizontal',
			'effect'          => $effect,
			'speed'           => ( '' !== $settings['slider_speed']['size'] ) ? $settings['slider_speed']['size'] : 400,
			'slides_per_view' => ( '' !== $settings['items']['size'] ) ? absint( $settings['items']['size'] ) : 3,
			'space_between'   => ( '' !== $settings['margin']['size'] ) ? absint( $settings['margin']['size'] ) : 10,
			'auto_height'     => true,
			'loop'            => ( 'yes' === $settings['infinite_loop'] ) ? 'yes' : '',
		];

		if ( true === $grab_cursor ) {
			$slider_options['grab_cursor'] = true;
		}

		$autoplay_speed = 999999;

		if ( 'yes' === $settings['autoplay'] ) {
			$slider_options['autoplay'] = 'yes';

			if ( isset( $settings['autoplay_speed']['size'] ) ) {
				$autoplay_speed = $settings['autoplay_speed']['size'];
			} elseif ( $settings['autoplay_speed'] ) {
				$autoplay_speed = $settings['autoplay_speed'];
			}

			$slider_options['autoplay_speed'] = $autoplay_speed;
			$slider_options['pause_on_interaction'] = ( 'yes' === $settings['pause_on_interaction'] ) ? 'yes' : '';
		}

		if ( 'yes' === $pagination && $settings['pagination_type'] ) {
			$slider_options['pagination'] = $settings['pagination_type'];
		}

		if ( 'yes' === $settings['arrows'] ) {
			$slider_options['show_arrows'] = true;
		}

		$breakpoints = PP_Helper::elementor()->breakpoints->get_active_breakpoints();

		foreach ( $breakpoints as $device => $breakpoint ) {
			if ( in_array( $device, [ 'mobile', 'tablet', 'desktop' ] ) ) {
				switch ( $device ) {
					case 'desktop':
						$slider_options['slides_per_view'] = ( isset( $settings['items']['size'] ) && $settings['items']['size'] ) ? absint( $settings['items']['size'] ) : 3;
						$slider_options['space_between'] = ( isset( $settings['margin']['size'] ) && $settings['margin']['size'] ) ? absint( $settings['margin']['size'] ) : 10;
						break;
					case 'tablet':
						$slider_options['slides_per_view_tablet'] = ( isset( $settings['items_tablet']['size'] ) && $settings['items_tablet']['size'] ) ? absint( $settings['items_tablet']['size'] ) : 2;
						$slider_options['space_between_tablet'] = ( isset( $settings['margin_tablet']['size'] ) && $settings['margin_tablet']['size'] ) ? absint( $settings['margin_tablet']['size'] ) : 10;
						break;
					case 'mobile':
						$slider_options['slides_per_view_mobile'] = ( isset( $settings['items_mobile']['size'] ) && $settings['items_mobile']['size'] ) ? absint( $settings['items_mobile']['size'] ) : 1;
						$slider_options['space_between_mobile'] = ( isset( $settings['margin_mobile']['size'] ) && $settings['margin_mobile']['size'] ) ? absint( $settings['margin_mobile']['size'] ) : 10;
						break;
				}
			} else {
				if ( isset( $settings['items_' . $device]['size'] ) && $settings['items_' . $device]['size'] ) {
					$slider_options['slides_per_view_' . $device] = absint( $settings['items_' . $device]['size'] );
				}

				if ( isset( $settings['margin_' . $device]['size'] ) && $settings['margin_' . $device]['size'] ) {
					$slider_options['space_between_' . $device] = absint( $settings['margin_' . $device]['size'] );
				}
			}
		}

		return $slider_options;
	}



	/**
	 * Get swiper slider settings for content_template function
	 *
	 * @access public
	 * @since 1.4.13.1
	 */
	public function get_swiper_slider_settings_js() {
		$elementor_bp_tablet    = get_option( 'elementor_viewport_lg' );
		$elementor_bp_mobile    = get_option( 'elementor_viewport_md' );
		$elementor_bp_lg        = get_option( 'elementor_viewport_lg' );
		$elementor_bp_md        = get_option( 'elementor_viewport_md' );
		$bp_desktop             = ! empty( $elementor_bp_lg ) ? $elementor_bp_lg : 1025;
		$bp_tablet              = ! empty( $elementor_bp_md ) ? $elementor_bp_md : 768;
		$bp_mobile              = 320;
		?>
		<#
			function get_slider_settings( settings ) {
		   
				if (typeof settings.effect !== 'undefined') {
					var $effect = settings.effect;
				} else {
					var $effect = 'slide';
				}

				var $items          = ( settings.items.size !== '' || settings.items.size !== undefined ) ? settings.items.size : 3,
					$items_tablet   = ( settings.items_tablet.size !== '' || settings.items_tablet.size !== undefined ) ? settings.items_tablet.size : 2,
					$items_mobile   = ( settings.items_mobile.size !== '' || settings.items_mobile.size !== undefined ) ? settings.items_mobile.size : 1,
					$margin         = ( settings.margin.size !== '' || settings.margin.size !== undefined ) ? settings.margin.size : 10,
					$margin_tablet  = ( settings.margin_tablet.size !== '' || settings.margin_tablet.size !== undefined ) ? settings.margin_tablet.size : 10,
					$margin_mobile  = ( settings.margin_mobile.size !== '' || settings.margin_mobile.size !== undefined ) ? settings.margin_mobile.size : 10,
					$autoplay       = ( settings.autoplay == 'yes' && settings.autoplay_speed.size != '' ) ? settings.autoplay_speed.size : 999999;

				var sliderOptions = {
					direction:       'horizontal',
					effect:          $effect,
					speed:           ( settings.slider_speed.size !== '' || settings.slider_speed.size !== undefined ) ? settings.slider_speed.size : 400,
					slides_per_view: $items,
					space_between:   $margin,
					auto_height:     true,
					loop:            ( 'yes' === settings.infinite_loop ) ? 'yes' : false,
					grab_cursor:     ( 'yes' === settings.grab_cursor ) ? 'yes' : false,
				};

				if ( 'yes' === settings.autoplay ) {
					var $autoplay = ( '' !== settings.autoplay_speed.size ) ? settings.autoplay_speed.size : 999999;

					sliderOptions.autoplay = $autoplay;
					sliderOptions.pause_on_interaction = ( 'yes' === settings.pause_on_interaction ) ? 'yes' : '';;
				}

				if ( 'yes' === settings.dots && settings.pagination_type ) {
					sliderOptions.pagination = settings.pagination_type;
				}

				if ( 'yes' === settings.arrows ) {
					sliderOptions.show_arrows = true;
				}

				breakpoints = elementorFrontend.config.responsive.activeBreakpoints;
				Object.keys(breakpoints).forEach(breakpointName => {
					if ( 'tablet' === breakpointName || 'mobile' === breakpointName ) {
						switch(breakpointName) {
							case 'tablet':
								sliderOptions['slides_per_view_tablet'] = $items_tablet;
								sliderOptions['space_between_tablet'] = $margin_tablet;
								break;
							case 'mobile':
								sliderOptions['slides_per_view_mobile'] = $items_mobile;
								sliderOptions['space_between_mobile'] = $margin_mobile;
								break;
						}
					} else {
						if ( settings['items_' + breakpointName].size !== '' || settings['items_' + breakpointName].size !== undefined ) {
							sliderOptions['slides_per_view_' + breakpointName] = settings['items_' + breakpointName].size;
						}

						if ( settings['margin_' + breakpointName].size !== '' || settings['margin_' + breakpointName].size !== undefined ) {
							sliderOptions['space_between_' + breakpointName] = settings['margin_' + breakpointName].size;
						}
					}
				});

				return sliderOptions;
			};
		#>
		<?php
	}

	/**
	 * Presets control
	 *
	 * @param string $slug Widget slug.
	 * @param string $widget Widget name.
	 * @since 2.9.0
	 */
	public function register_presets_control( $slug, $widget ) {

		if ( is_extension_enabled( 'presets-style' ) ) {

			$options       = array();
			$options['']   = __( 'Default', 'powerpack' );
			$presets_count = PP_Helper::get_widget_presets( $slug );

			for ( $i = 1; $i <= $presets_count; $i++ ) {
				// translators: %d Preset number.
				$options[ 'preset-' . $i ] = sprintf( __( 'Preset %d', 'powerpack' ), $i );
			}

			$widget->start_controls_section(
				'section_presets',
				array(
					'label' => __( 'Presets', 'powerpack' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);

			$widget->add_control(
				'presets_options',
				array(
					'label'   => __( 'Choose Preset', 'powerpack' ),
					'type'    => 'pp-presets-style',
					'options' => $options,
				)
			);

			$widget->add_control(
				'default_preset_note',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf(
						/* translators: 1: <b> 2: </b> 3: </br> */
						__( '%1$sNote:%2$s %3$s 1. Choosing a preset will reset all Style settings for this widget. %3$s 2. Choosing \'default\' option after switching between preset options will change the default view of the widget.', 'powerpack' ),
						'<b>',
						'</b>',
						'</br>'
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				)
			);

			$widget->end_controls_section();
		}
	}
}
