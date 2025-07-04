<?php
namespace PowerpackElements\Modules\Woocommerce\Widgets;

use PowerpackElements\Base\Powerpack_Widget;
use PowerpackElements\Classes\PP_Helper;
use PowerpackElements\Classes\PP_Woo_Helper;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Woo - Product Reviews widget
 */
class Woo_Product_Reviews extends Powerpack_Widget {

	public function get_categories() {
		return parent::get_woo_categories();
	}

	/**
	 * Retrieve Woo - Product Reviews widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_name( 'Woo_Product_Reviews' );
	}

	/**
	 * Retrieve Woo - Product Reviews widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Woo_Product_Reviews' );
	}

	/**
	 * Retrieve Woo - Product Reviews widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Woo_Product_Reviews' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Woo - Product Reviews widget belongs to.
	 *
	 * @since 1.4.13.4
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Woo_Product_Reviews' );
	}

	/**
	 * Retrieve the list of styles the Woo - Product Reviews depended on.
	 *
	 * Used to set style dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends() {
		return array(
			'pp-woocommerce',
		);
	}

	public function has_widget_inner_wrapper(): bool {
		return ! PP_Helper::is_feature_active( 'e_optimized_markup' );
	}

	/**
	 * Register Woo - Product Reviews widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Product Reviews', 'powerpack' ),
			)
		);

			$this->add_control(
				'html_notice',
				array(
					'label' => esc_html__( 'Element Information', 'powerpack' ),
					'show_label' => false,
					'type' => Controls_Manager::RAW_HTML,
					'raw' => esc_html__( 'Products reviews', 'powerpack' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Box', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'box_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .woocommerce-tabs-list',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'box_border',
				'label'       => esc_html__( 'Border', 'powerpack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .woocommerce-tabs-list',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_shadow',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .woocommerce-tabs-list',
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-tabs-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs-list .woocommerce-Reviews-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .woocommerce-tabs-list .woocommerce-Reviews-title',

			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs-list .woocommerce-Reviews-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		/* Rating Styling options */

		$this->start_controls_section(
			'section_review_style',
			array(
				'label'     => esc_html__( 'Review', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_image_style',
			[
				'label' => esc_html__( 'Image', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => esc_html__( 'Width', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs-list #reviews img.avatar' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_spacing',
			[
				'label' => esc_html__( 'Spacing', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs-list #reviews .comment-text' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs-list #reviews img.avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_comment_style',
			[
				'label' => esc_html__( 'Comment Box', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator'   => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'comment_border',
				'label'       => esc_html__( 'Border', 'powerpack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .woocommerce-tabs-list #reviews .comment-text',
			)
		);

		$this->add_responsive_control(
			'comment_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs-list #reviews .comment-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'comment_padding',
			array(
				'label'      => esc_html__( 'Padding', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-tabs-list #reviews .comment-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_comment_meta_style',
			[
				'label' => esc_html__( 'Comment Meta', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'comment_meta_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs-list #reviews .comment-text p.meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'comment_meta_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .woocommerce-tabs-list #reviews .comment-text p.meta',

			]
		);

		$this->add_responsive_control(
			'comment_meta_spacing',
			[
				'label' => esc_html__( 'Spacing', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs-list #reviews .comment-text p.meta' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_comment_text_style',
			[
				'label' => esc_html__( 'Comment Text', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'comment_text_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs-list #reviews .comment-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'comment_text_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .woocommerce-tabs-list #reviews .comment-text',

			]
		);

		$this->end_controls_section();

		/* Rating Styling options */

		$this->start_controls_section(
			'section_rating_style',
			array(
				'label'     => esc_html__( 'Rating', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'star_color',
			[
				'label' => esc_html__( 'Star Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .star-rating span:before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'empty_star_color',
			[
				'label' => esc_html__( 'Empty Star Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .star-rating::before, .woocommerce {{WRAPPER}} p.stars a::before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'star_size',
			[
				'label' => esc_html__( 'Star Size', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default' => [
					'unit' => 'em',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 4,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .star-rating, .woocommerce {{WRAPPER}} p.stars' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default' => [
					'unit' => 'em',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 4,
						'step' => 0.1,
					],
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'.woocommerce:not(.rtl) {{WRAPPER}} .star-rating' => 'margin-right: {{SIZE}}{{UNIT}}',
					'.woocommerce.rtl {{WRAPPER}} .star-rating' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		/* Labels Styling options */

		$this->start_controls_section(
			'section_label_style',
			array(
				'label'     => esc_html__( 'Labels', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'label_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} #reviews form label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'label_typography',
				'label'     => esc_html__( 'Typography', 'powerpack' ),
				'selector'  => '{{WRAPPER}} #reviews form label',
			)
		);

		$this->add_responsive_control(
			'label_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} #reviews form label' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/* Input & Textarea Styling options */

		$this->start_controls_section(
			'section_fields_style',
			array(
				'label' => esc_html__( 'Input & Textarea', 'powerpack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'input_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'powerpack' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"], {{WRAPPER}} #reviews textarea' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_fields_style' );

		$this->start_controls_tab(
			'tab_fields_normal',
			array(
				'label' => esc_html__( 'Normal', 'powerpack' ),
			)
		);

		$this->add_control(
			'field_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f9f9f9',
				'selectors' => array(
					'{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"], {{WRAPPER}} #reviews textarea' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'field_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"], {{WRAPPER}} #reviews textarea' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'field_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} #reviews form p:not(.comment-notes), {{WRAPPER}} #reviews form p:not(.comment-form-rating)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'field_padding',
			array(
				'label'      => esc_html__( 'Padding', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'default'    => array(
					'top'      => 10,
					'right'    => 10,
					'bottom'   => 10,
					'left'     => 10,
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"], {{WRAPPER}} #reviews textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_indent',
			array(
				'label'      => esc_html__( 'Text Indent', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 60,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"], {{WRAPPER}} #reviews textarea' => 'text-indent: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'input_width',
			array(
				'label'      => esc_html__( 'Input Width', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"]' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'input_height',
			array(
				'label'      => esc_html__( 'Input Height', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 80,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"]' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'textarea_width',
			array(
				'label'      => esc_html__( 'Textarea Width', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} #reviews textarea' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'textarea_height',
			array(
				'label'      => esc_html__( 'Textarea Height', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 400,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} #reviews textarea' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'field_border',
				'label'       => esc_html__( 'Border', 'powerpack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"], {{WRAPPER}} #reviews textarea',
				'separator'   => 'before',
			)
		);

		$this->add_control(
			'field_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"], {{WRAPPER}} #reviews textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'field_typography',
				'label'     => esc_html__( 'Typography', 'powerpack' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"], {{WRAPPER}} #reviews textarea',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'field_box_shadow',
				'selector'  => '{{WRAPPER}} #reviews input[type="text"], {{WRAPPER}} #reviews input[type="email"], {{WRAPPER}} #reviews textarea',
				'separator' => 'before',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_fields_focus',
			array(
				'label' => esc_html__( 'Focus', 'powerpack' ),
			)
		);

		$this->add_control(
			'field_bg_color_focus',
			array(
				'label'     => esc_html__( 'Background Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} #reviews input[type="text"]:focus, {{WRAPPER}} #reviews input[type="email"]:focus, {{WRAPPER}} #reviews textarea:focus' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'field_text_color_focus',
			array(
				'label'     => esc_html__( 'Text Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} #reviews input[type="text"]:focus, {{WRAPPER}} #reviews input[type="email"]:focus, {{WRAPPER}} #reviews textarea:focus' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'focus_input_border',
				'label'       => esc_html__( 'Border', 'powerpack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} #reviews input[type="text"]:focus, {{WRAPPER}} #reviews input[type="email"]:focus, {{WRAPPER}} #reviews textarea:focus',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'focus_box_shadow',
				'selector'  => '{{WRAPPER}} #reviews input[type="text"]:focus, {{WRAPPER}} #reviews input[type="email"]:focus, {{WRAPPER}} #reviews textarea:focus',
				'separator' => 'before',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/* Button Styling Controls */

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} #review_form .form-submit input[type="submit"]',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} #review_form .form-submit input[type="submit"]',
				'exclude' => [ 'color' ],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} #review_form .form-submit input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} #review_form .form-submit input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab( 'button_style_normal',
			[
				'label' => esc_html__( 'Normal', 'powerpack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form .form-submit input[type="submit"]' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form .form-submit input[type="submit"]' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => esc_html__( 'Border Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form .form-submit input[type="submit"]' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'button_style_hover',
			[
				'label' => esc_html__( 'Hover', 'powerpack' ),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form .form-submit input[type="submit"]:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form .form-submit input[type="submit"]:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label' => esc_html__( 'Border Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #review_form .form-submit input[type="submit"]:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.2,
				],
				'range' => [
					'px' => [
						'max' => 2,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} #review_form .form-submit input[type="submit"]' => 'transition: all {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {
		$settings   = $this->get_settings_for_display();

		do_action( 'pp_woo_builder_widget_before_render', $this );
		global $product;
		$product = wc_get_product();

		if ( PP_Helper::is_edit_mode() ) {
			echo wp_kses_post( PP_Woo_Helper::get_instance()->default( $this->get_name() ) );
		} else {
			if ( empty( $product ) ) {
				return;
			}
			add_filter( 'comments_template', array( 'WC_Template_Loader', 'comments_template_loader' ) );
			echo '<div class="woocommerce-tabs-list">';
				comments_template();
			echo '</div>';
		}
		do_action( 'pp_woo_builder_widget_after_render', $this );
	}

	public function render_plain_content() {}

}
