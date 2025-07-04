<?php
namespace PowerpackElements\Modules\OnepageNav\Widgets;

use PowerpackElements\Base\Powerpack_Widget;
use PowerpackElements\Classes\PP_Config;
use PowerpackElements\Classes\PP_Helper;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * One Page Navigation Widget
 */
class Onepage_Nav extends Powerpack_Widget {

	/**
	 * Retrieve one page navigation widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_name( 'Onepage_Nav' );
	}

	/**
	 * Retrieve one page navigation widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Onepage_Nav' );
	}

	/**
	 * Retrieve one page navigation widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Onepage_Nav' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.3.7
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Onepage_Nav' );
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	/**
	 * Retrieve the list of scripts the one page navigation widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [
			'pp-one-page-nav',
		];
	}

	/**
	 * Retrieve the list of styles the offcanvas content widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends() {
		return [
			'widget-pp-one-page-nav'
		];
	}

	public function has_widget_inner_wrapper(): bool {
		return ! PP_Helper::is_feature_active( 'e_optimized_markup' );
	}

	/**
	 * Register one page navigation widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.0.3
	 * @access protected
	 */
	protected function register_controls() {
		/* Content Tab */
		$this->register_content_nav_dots_controls();
		$this->register_content_tooltip_controls();
		$this->register_content_settings_controls();
		$this->register_content_help_docs_controls();

		/* Style Tab */
		$this->register_style_nav_box_controls();
		$this->register_style_dots_controls();
		$this->register_style_tooltip_controls();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CONTENT TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_content_nav_dots_controls() {
		/**
		 * Content Tab: Navigation Dots
		 */
		$this->start_controls_section(
			'section_nav_dots',
			[
				'label'                 => esc_html__( 'Navigation Dots', 'powerpack' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'section_title',
			[
				'label'                 => esc_html__( 'Section Title', 'powerpack' ),
				'type'                  => Controls_Manager::TEXT,
				'default'               => esc_html__( 'Section Title', 'powerpack' ),
			]
		);

		$repeater->add_control(
			'section_id',
			[
				'label'                 => esc_html__( 'Section ID', 'powerpack' ),
				'type'                  => Controls_Manager::TEXT,
				'default'               => '',
				'ai'                    => [
					'active' => false,
				],
			]
		);

		$repeater->add_control(
			'select_dot_icon',
			[
				'label'                 => esc_html__( 'Navigation Dot', 'powerpack' ),
				'type'                  => Controls_Manager::ICONS,
				'fa4compatibility'      => 'dot_icon',
				'default'               => [
					'value'     => 'fas fa-circle',
					'library'   => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'nav_dots',
			[
				'label'                 => '',
				'type'                  => Controls_Manager::REPEATER,
				'default'               => [
					[
						'section_title'   => esc_html__( 'Section #1', 'powerpack' ),
						'section_id'      => 'section-1',
						'select_dot_icon' => 'fa fa-circle',
					],
					[
						'section_title'   => esc_html__( 'Section #2', 'powerpack' ),
						'section_id'      => 'section-2',
						'select_dot_icon' => 'fa fa-circle',
					],
					[
						'section_title'   => esc_html__( 'Section #3', 'powerpack' ),
						'section_id'      => 'section-3',
						'select_dot_icon' => 'fa fa-circle',
					],
				],
				'fields'                => $repeater->get_controls(),
				'title_field'           => '{{{ section_title }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_tooltip_controls() {
		/**
		 * Content Tab: Tooltip
		 */
		$this->start_controls_section(
			'section_onepage_nav_tooltip_settings',
			[
				'label'                 => esc_html__( 'Tooltip', 'powerpack' ),
			]
		);

		$this->add_control(
			'nav_tooltip',
			[
				'label'                 => esc_html__( 'Tooltip', 'powerpack' ),
				'description'           => esc_html__( 'Show tooltip on hover', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
				'label_on'              => esc_html__( 'Yes', 'powerpack' ),
				'label_off'             => esc_html__( 'No', 'powerpack' ),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'tooltip_arrow',
			[
				'label'                 => esc_html__( 'Tooltip Arrow', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
				'label_on'              => esc_html__( 'Show', 'powerpack' ),
				'label_off'             => esc_html__( 'Hide', 'powerpack' ),
				'return_value'          => 'yes',
				'condition'             => [
					'nav_tooltip'   => 'yes',
				],
			]
		);

		$this->add_control(
			'distance',
			[
				'label'                 => esc_html__( 'Distance', 'powerpack' ),
				'description'           => esc_html__( 'The distance between navigation dot and the tooltip.', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'default'               => [
					'size'  => '',
				],
				'range'                 => [
					'px'    => [
						'min'   => 0,
						'max'   => 150,
					],
				],
				'selectors'             => [
					'{{WRAPPER}}.pp-nav-align-top .pp-nav-dot-tooltip' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.pp-nav-align-bottom .pp-nav-dot-tooltip' => 'bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.pp-nav-align-left .pp-nav-dot-tooltip' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.pp-nav-align-right .pp-nav-dot-tooltip' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'nav_tooltip'   => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_settings_controls() {
		/**
		 * Content Tab: Settings
		 */
		$this->start_controls_section(
			'section_onepage_nav_settings',
			[
				'label'                 => esc_html__( 'Settings', 'powerpack' ),
			]
		);

		$this->add_control(
			'scroll_wheel',
			[
				'label'                 => esc_html__( 'Scroll Wheel', 'powerpack' ),
				'description'           => esc_html__( 'Use mouse wheel to navigate from one row to another', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'off',
				'label_on'              => esc_html__( 'On', 'powerpack' ),
				'label_off'             => esc_html__( 'Off', 'powerpack' ),
				'return_value'          => 'on',
			]
		);

		$this->add_control(
			'scroll_touch',
			[
				'label'                 => esc_html__( 'Touch Swipe', 'powerpack' ),
				'description'           => esc_html__( 'Use touch swipe to navigate from one row to another in mobile devices', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'off',
				'label_on'              => esc_html__( 'On', 'powerpack' ),
				'label_off'             => esc_html__( 'Off', 'powerpack' ),
				'return_value'          => 'on',
				'condition'             => [
					'scroll_wheel'   => 'on',
				],
			]
		);

		$this->add_control(
			'scroll_keys',
			[
				'label'                 => esc_html__( 'Scroll Keys', 'powerpack' ),
				'description'           => esc_html__( 'Use UP and DOWN arrow keys to navigate from one row to another', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'off',
				'label_on'              => esc_html__( 'On', 'powerpack' ),
				'label_off'             => esc_html__( 'Off', 'powerpack' ),
				'return_value'          => 'on',
			]
		);

		$this->add_control(
			'top_offset',
			[
				'label'                 => esc_html__( 'Row Top Offset', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [ 'size' => '0' ],
				'range'                 => [
					'px' => [
						'min'   => 0,
						'max'   => 300,
						'step'  => 1,
					],
				],
			]
		);

		$this->add_control(
			'scrolling_speed',
			[
				'label'                 => esc_html__( 'Scrolling Speed', 'powerpack' ),
				'type'                  => Controls_Manager::NUMBER,
				'default'               => '700',
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_help_docs_controls() {

		$help_docs = PP_Config::get_widget_help_links( 'Onepage_Nav' );
		if ( ! empty( $help_docs ) ) {
			/**
			 * Content Tab: Docs Links
			 *
			 * @since 1.4.8
			 * @access protected
			 */
			$this->start_controls_section(
				'section_help_docs',
				[
					'label' => esc_html__( 'Help Docs', 'powerpack' ),
				]
			);

			$hd_counter = 1;
			foreach ( $help_docs as $hd_title => $hd_link ) {
				$this->add_control(
					'help_doc_' . $hd_counter,
					[
						'type'            => Controls_Manager::RAW_HTML,
						'raw'             => sprintf( '%1$s ' . $hd_title . ' %2$s', '<a href="' . $hd_link . '" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'pp-editor-doc-links',
					]
				);

				$hd_counter++;
			}

			$this->end_controls_section();
		}
	}

	/*-----------------------------------------------------------------------------------*/
	/*	STYLE TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_style_nav_box_controls() {
		/**
		 * Style Tab: Navigation Box
		 */
		$this->start_controls_section(
			'section_nav_box_style',
			[
				'label'                 => esc_html__( 'Navigation Box', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_alignment',
			[
				'label'                 => esc_html__( 'Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'top'          => [
						'title'    => esc_html__( 'Top', 'powerpack' ),
						'icon'     => 'eicon-v-align-top',
					],
					'bottom'       => [
						'title'    => esc_html__( 'Bottom', 'powerpack' ),
						'icon'     => 'eicon-v-align-bottom',
					],
					'left'         => [
						'title'    => esc_html__( 'Left', 'powerpack' ),
						'icon'     => 'eicon-h-align-left',
					],
					'right'        => [
						'title'    => esc_html__( 'Right', 'powerpack' ),
						'icon'     => 'eicon-h-align-right',
					],
				],
				'default'               => 'right',
				'prefix_class'          => 'pp-nav-align-',
				'selectors'             => [
					'{{WRAPPER}} .pp-caldera-form-heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'nav_container_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .pp-one-page-nav',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'nav_container_border',
				'label'                 => esc_html__( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .pp-one-page-nav',
			]
		);

		$this->add_control(
			'nav_container_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-one-page-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_container_margin',
			[
				'label'                 => esc_html__( 'Margin', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-one-page-nav-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_container_padding',
			[
				'label'                 => esc_html__( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-one-page-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'nav_container_box_shadow',
				'selector'              => '{{WRAPPER}} .pp-one-page-nav',
				'separator'             => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_dots_controls() {
		/**
		 * Style Tab: Navigation Dots
		 */
		$this->start_controls_section(
			'section_dots_style',
			[
				'label'                 => esc_html__( 'Navigation Dots', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'dots_size',
			[
				'label'                 => esc_html__( 'Size', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'default'               => [ 'size' => '10' ],
				'range'                 => [
					'px' => [
						'min'   => 5,
						'max'   => 60,
						'step'  => 1,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-nav-dot' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dots_spacing',
			[
				'label'                 => esc_html__( 'Spacing', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'default'               => [ 'size' => '10' ],
				'range'                 => [
					'px' => [
						'min'   => 2,
						'max'   => 30,
						'step'  => 1,
					],
				],
				'selectors'             => [
					'{{WRAPPER}}.pp-nav-align-right .pp-one-page-nav-item, {{WRAPPER}}.pp-nav-align-left .pp-one-page-nav-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.pp-nav-align-top .pp-one-page-nav-item, {{WRAPPER}}.pp-nav-align-bottom .pp-one-page-nav-item' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dots_padding',
			[
				'label'                 => esc_html__( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-nav-dot-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'dots_box_shadow',
				'selector'              => '{{WRAPPER}} .pp-nav-dot-wrap',
				'separator'             => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_dots_style' );

		$this->start_controls_tab(
			'tab_dots_normal',
			[
				'label'                 => esc_html__( 'Normal', 'powerpack' ),
			]
		);

		$this->add_control(
			'dots_color_normal',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-nav-dot' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pp-nav-dot svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dots_bg_color_normal',
			[
				'label'                 => esc_html__( 'Background Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-nav-dot-wrap' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'dots_border',
				'label'                 => esc_html__( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .pp-nav-dot-wrap',
			]
		);

		$this->add_control(
			'dots_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-nav-dot-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			[
				'label'                 => esc_html__( 'Hover', 'powerpack' ),
			]
		);

		$this->add_control(
			'dots_color_hover',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-one-page-nav-item .pp-nav-dot-wrap:hover .pp-nav-dot' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pp-one-page-nav-item .pp-nav-dot-wrap:hover .pp-nav-dot svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dots_bg_color_hover',
			[
				'label'                 => esc_html__( 'Background Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-one-page-nav-item .pp-nav-dot-wrap:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dots_border_color_hover',
			[
				'label'                 => esc_html__( 'Border Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-one-page-nav-item .pp-nav-dot-wrap:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_active',
			[
				'label'                 => esc_html__( 'Active', 'powerpack' ),
			]
		);

		$this->add_control(
			'dots_color_active',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-one-page-nav-item.active .pp-nav-dot' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pp-one-page-nav-item.active .pp-nav-dot svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dots_bg_color_active',
			[
				'label'                 => esc_html__( 'Background Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-one-page-nav-item.active .pp-nav-dot-wrap' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dots_border_color_active',
			[
				'label'                 => esc_html__( 'Border Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-one-page-nav-item.active .pp-nav-dot-wrap' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_tooltip_controls() {
		/**
		 * Style Tab: Tooltip
		 */
		$this->start_controls_section(
			'section_tooltips_style',
			[
				'label'                 => esc_html__( 'Tooltip', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'nav_tooltip'  => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_bg_color',
			[
				'label'                 => esc_html__( 'Background Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-nav-dot-tooltip-content' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .pp-nav-dot-tooltip' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'nav_tooltip'  => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_color',
			[
				'label'                 => esc_html__( 'Text Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-nav-dot-tooltip-content' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'nav_tooltip'  => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'tooltip_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'              => '{{WRAPPER}} .pp-nav-dot-tooltip',
				'condition'             => [
					'nav_tooltip'  => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'tooltip_padding',
			[
				'label'                 => esc_html__( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-nav-dot-tooltip-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$fallback_defaults = [
			'fa fa-check',
			'fa fa-times',
			'fa fa-dot-circle-o',
		];

		$is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

		$this->add_render_attribute( 'onepage-nav-container', 'class', 'pp-one-page-nav-container' );

		$this->add_render_attribute(
			'onepage-nav',
			[
				'class'             => 'pp-one-page-nav',
				'id'                => 'pp-one-page-nav-' . $this->get_id(),
				'data-section-id'   => 'pp-one-page-nav-' . $this->get_id(),
				'data-top-offset'   => $settings['top_offset']['size'],
				'data-scroll-speed' => $settings['scrolling_speed'],
				'data-scroll-wheel' => $settings['scroll_wheel'],
				'data-scroll-touch' => $settings['scroll_touch'],
				'data-scroll-keys'  => $settings['scroll_keys'],
			]
		);

		$migration_allowed = Icons_Manager::is_migration_allowed();
		?>
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'onepage-nav-container' ) ); ?>>
			<ul <?php echo wp_kses_post( $this->get_render_attribute_string( 'onepage-nav' ) ); ?>>
				<?php
				$i = 1;
				foreach ( $settings['nav_dots'] as $index => $dot ) {

					// add old default
					if ( ! isset( $dot['dot_icon'] ) && ! $migration_allowed ) {
						$dot['dot_icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
					}

					$migrated = isset( $dot['__fa4_migrated']['select_dot_icon'] );
					$is_new = ! isset( $dot['dot_icon'] ) && $migration_allowed;

					$this->add_render_attribute( 'tooltip', 'class', 'pp-nav-dot-tooltip' );

					if ( $settings['tooltip_arrow'] == 'yes' ) {
						$this->add_render_attribute( 'tooltip', 'class', 'pp-tooltip-arrow' );
					}

					$pp_section_title = $dot['section_title'];
					$pp_section_id = $dot['section_id'];

					if ( $settings['nav_tooltip'] == 'yes' ) {
						$pp_dot_tooltip = sprintf( '<span %1$s><span class="pp-nav-dot-tooltip-content">%2$s</span></span>', $this->get_render_attribute_string( 'tooltip' ), $pp_section_title );
					} else {
						$pp_dot_tooltip = '';
					}
					?>
					<li class="pp-one-page-nav-item">
						<?php echo wp_kses_post( $pp_dot_tooltip ); ?>
						<a href="#" data-row-id="<?php echo esc_attr( $pp_section_id ); ?>">
							<span class="pp-nav-dot-wrap">
								<span class="pp-nav-dot pp-icon">
									<?php
									if ( $is_new || $migrated ) {
										Icons_Manager::render_icon( $dot['select_dot_icon'], [ 'aria-hidden' => 'true' ] );
									} else { ?>
											<i class="<?php echo esc_attr( $dot['dot_icon'] ); ?>" aria-hidden="true"></i>
										<?php } ?>
								</span>
							</span>
						</a>
					</li>
					<?php
					$i++;
				}
				?>
			</ul>
		</div>
		<?php
		if ( $is_editor ) {
			$placeholder = sprintf(
				// translators: %1$s is for widget title.
				esc_html__( 'Click here to edit the "%1$s" settings. This text will not be visible on frontend.', 'powerpack' ), esc_attr( $this->get_title() )
			);

			echo esc_html( $this->render_editor_placeholder( [
				'title' => sprintf(
					/* translators: 1: Widget title, 2: Widget ID */
					'%1$s - %2$s', esc_attr( $this->get_title() ), esc_attr( $this->get_id() )
				),
				'body' => $placeholder,
			] ) );
		}
	}
}
