<?php
namespace PowerpackElements\Modules\Woocommerce\Widgets;

use PowerpackElements\Base\Powerpack_Widget;
use PowerpackElements\Classes\PP_Helper;
use PowerpackElements\Classes\PP_Woo_Helper;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Woo - Product Upsell widget
 */
class Woo_Product_Upsell extends Powerpack_Widget {

	/**
	 * Retrieve Woo - Product Upsell widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_name( 'Woo_Product_Upsell' );
	}

	/**
	 * Retrieve Woo - Product Upsell widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Woo_Product_Upsell' );
	}

	/**
	 * Retrieve Woo - Product Upsell widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Woo_Product_Upsell' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Woo - Product Upsell widget belongs to.
	 *
	 * @since 1.4.13.4
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Woo_Product_Upsell' );
	}

	public function get_categories() {
		return parent::get_woo_categories();
	}

	/**
	 * Retrieve the list of styles the Woo - Product Upsell depended on.
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
	 * Register Woo - Product Upsell widget controls.
	 *
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_upsell_content',
			[
				'label' => esc_html__( 'Upsells', 'powerpack' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'powerpack' ),
				'type' => Controls_Manager::NUMBER,
				'prefix_class' => 'pp-products-columns%s-',
				'default' => 4,
				'min' => 1,
				'max' => 12,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order By', 'powerpack' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => esc_html__( 'Date', 'powerpack' ),
					'title' => esc_html__( 'Title', 'powerpack' ),
					'price' => esc_html__( 'Price', 'powerpack' ),
					'popularity' => esc_html__( 'Popularity', 'powerpack' ),
					'rating' => esc_html__( 'Rating', 'powerpack' ),
					'rand' => esc_html__( 'Random', 'powerpack' ),
					'menu_order' => esc_html__( 'Menu Order', 'powerpack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'powerpack' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => esc_html__( 'ASC', 'powerpack' ),
					'desc' => esc_html__( 'DESC', 'powerpack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_products_style',
			[
				'label' => esc_html__( 'Products', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'wc_style_warning',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'powerpack' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'products_class',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => 'wc-products',
				'prefix_class' => 'elementor-products-grid pp-',
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Columns Gap', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default' => [
					'size' => 20,
				],
				'tablet_default' => [
					'size' => 20,
				],
				'mobile_default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products  ul.products' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__( 'Rows Gap', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default' => [
					'size' => 40,
				],
				'tablet_default' => [
					'size' => 40,
				],
				'mobile_default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products  ul.products' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'powerpack' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'pp-product-loop-item--align-',
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_image_style',
			[
				'label' => esc_html__( 'Image', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}}.pp-wc-products .attachment-woocommerce_thumbnail',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products .attachment-woocommerce_thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}}.pp-wc-products .attachment-woocommerce_thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_cateogry_style',
			[
				'label' => esc_html__( 'Category', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cateogry_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .wpbf-woo-product-category, {{WRAPPER}}.pp-wc-products ul.products li.product .ast-woo-product-category' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cateogry_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .wpbf-woo-product-category, {{WRAPPER}}.pp-wc-products ul.products li.product .ast-woo-product-category',
				],
			]
		);

		$this->add_responsive_control(
			'category_spacing',
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
					'{{WRAPPER}}.pp-wc-products ul.products li.product .wpbf-woo-product-category, {{WRAPPER}}.pp-wc-products ul.products li.product .ast-woo-product-category' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label' => esc_html__( 'Title', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .woocommerce-loop-product__title' => 'color: {{VALUE}}',
					'{{WRAPPER}}.pp-wc-products ul.products li.product .woocommerce-loop-category__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}}.pp-wc-products ul.products li.product .woocommerce-loop-product__title, ' .
								'{{WRAPPER}}.pp-wc-products ul.products li.product .woocommerce-loop-category__title',

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
					'{{WRAPPER}}.pp-wc-products ul.products li.product .woocommerce-loop-product__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.pp-wc-products ul.products li.product .woocommerce-loop-category__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_rating_style',
			[
				'label' => esc_html__( 'Rating', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'star_color',
			[
				'label' => esc_html__( 'Star Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .star-rating' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'empty_star_color',
			[
				'label' => esc_html__( 'Empty Star Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .star-rating::before' => 'color: {{VALUE}}',
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
					'{{WRAPPER}}.pp-wc-products ul.products li.product .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'rating_spacing',
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
					'{{WRAPPER}}.pp-wc-products ul.products li.product .star-rating' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_price_style',
			[
				'label' => esc_html__( 'Price', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .price' => 'color: {{VALUE}}',
					'{{WRAPPER}}.pp-wc-products ul.products li.product .price ins' => 'color: {{VALUE}}',
					'{{WRAPPER}}.pp-wc-products ul.products li.product .price ins .amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}}.pp-wc-products ul.products li.product .price',
			]
		);

		$this->add_control(
			'heading_old_price_style',
			[
				'label' => esc_html__( 'Regular Price', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .price del' => 'color: {{VALUE}}',
					'{{WRAPPER}}.pp-wc-products ul.products li.product .price del .amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'old_price_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}}.pp-wc-products ul.products li.product .price del .amount  ',
				'selector' => '{{WRAPPER}}.pp-wc-products ul.products li.product .price del ',
			]
		);

		$this->add_control(
			'heading_button_style',
			[
				'label' => esc_html__( 'Button', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'powerpack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => esc_html__( 'Border Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}}.pp-wc-products ul.products li.product .button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'powerpack' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'button_border',
				'exclude' => [ 'color' ],
				'selector' => '{{WRAPPER}}.pp-wc-products ul.products li.product .button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label' => esc_html__( 'Text Padding', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label' => esc_html__( 'Spacing', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product .button' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_view_cart_style',
			[
				'label' => esc_html__( 'View Cart', 'powerpack' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'view_cart_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products .added_to_cart' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'view_cart_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}}.pp-wc-products .added_to_cart',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_heading',
			[
				'label' => esc_html__( 'Heading', 'powerpack' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'powerpack' ),
				'label_on' => esc_html__( 'Show', 'powerpack' ),
				'default' => 'yes',
				'return_value' => 'yes',
				'prefix_class' => 'show-heading-',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products .products > h2' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}}.pp-wc-products .products > h2',
				'condition' => [
					'show_heading!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'heading_text_align',
			[
				'label' => esc_html__( 'Text Align', 'powerpack' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products .products > h2' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label' => esc_html__( 'Spacing', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products .products > h2' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_box',
			[
				'label' => esc_html__( 'Box', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'box_border_width',
			[
				'label' => esc_html__( 'Border Width', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label' => esc_html__( 'Padding', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'box_style_tabs' );

		$this->start_controls_tab( 'classic_style_normal',
			[
				'label' => esc_html__( 'Normal', 'powerpack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}}.pp-wc-products ul.products li.product',
			]
		);

		$this->add_control(
			'box_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'classic_style_hover',
			[
				'label' => esc_html__( 'Hover', 'powerpack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'selector' => '{{WRAPPER}}.pp-wc-products ul.products li.product:hover',
			]
		);

		$this->add_control(
			'box_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color_hover',
			[
				'label' => esc_html__( 'Border Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pagination_style',
			[
				'label' => esc_html__( 'Pagination', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);

		$this->add_control(
			'pagination_spacing',
			[
				'label' => esc_html__( 'Spacing', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} nav.woocommerce-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'show_pagination_border',
			[
				'label' => esc_html__( 'Border', 'powerpack' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'powerpack' ),
				'label_on' => esc_html__( 'Show', 'powerpack' ),
				'default' => 'yes',
				'return_value' => 'yes',
				'prefix_class' => 'pp-show-pagination-border-',
			]
		);

		$this->add_control(
			'pagination_border_color',
			[
				'label' => esc_html__( 'Border Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.woocommerce-pagination ul' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} nav.woocommerce-pagination ul li' => 'border-right-color: {{VALUE}}; border-left-color: {{VALUE}}',
				],
				'condition' => [
					'show_pagination_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'pagination_padding',
			[
				'label' => esc_html__( 'Padding', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 2,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} nav.woocommerce-pagination ul li a, {{WRAPPER}} nav.woocommerce-pagination ul li span' => 'padding: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pagination_typography',
				'selector' => '{{WRAPPER}} nav.woocommerce-pagination',
			]
		);

		$this->start_controls_tabs( 'pagination_style_tabs' );

		$this->start_controls_tab( 'pagination_style_normal',
			[
				'label' => esc_html__( 'Normal', 'powerpack' ),
			]
		);

		$this->add_control(
			'pagination_link_color',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.woocommerce-pagination ul li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_link_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.woocommerce-pagination ul li a' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'pagination_style_hover',
			[
				'label' => esc_html__( 'Hover', 'powerpack' ),
			]
		);

		$this->add_control(
			'pagination_link_color_hover',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.woocommerce-pagination ul li a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_link_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.woocommerce-pagination ul li a:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'pagination_style_active',
			[
				'label' => esc_html__( 'Active', 'powerpack' ),
			]
		);

		$this->add_control(
			'pagination_link_color_active',
			[
				'label' => esc_html__( 'Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.woocommerce-pagination ul li span.current' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_link_bg_color_active',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.woocommerce-pagination ul li span.current' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'sale_flash_style',
			[
				'label' => esc_html__( 'Sale Flash', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_onsale_flash',
			[
				'label' => esc_html__( 'Sale Flash', 'powerpack' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'powerpack' ),
				'label_on' => esc_html__( 'Show', 'powerpack' ),
				'separator' => 'before',
				'default' => 'yes',
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product span.onsale' => 'display: block',
				],
			]
		);

		$this->add_control(
			'onsale_text_color',
			[
				'label' => esc_html__( 'Text Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product span.onsale' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_onsale_flash' => 'yes',
				],
			]
		);

		$this->add_control(
			'onsale_text_background_color',
			[
				'label' => esc_html__( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product span.onsale' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'show_onsale_flash' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'onsale_typography',
				'selector' => '{{WRAPPER}}.pp-wc-products ul.products li.product span.onsale',
				'condition' => [
					'show_onsale_flash' => 'yes',
				],
			]
		);

		$this->add_control(
			'onsale_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product span.onsale' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_onsale_flash' => 'yes',
				],
			]
		);

		$this->add_control(
			'onsale_width',
			[
				'label' => esc_html__( 'Width', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product span.onsale' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_onsale_flash' => 'yes',
				],
			]
		);

		$this->add_control(
			'onsale_height',
			[
				'label' => esc_html__( 'Height', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product span.onsale' => 'min-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_onsale_flash' => 'yes',
				],
			]
		);

		$this->add_control(
			'onsale_horizontal_position',
			[
				'label' => esc_html__( 'Position', 'powerpack' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product span.onsale' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left' => 'right: auto; left: 0',
					'right' => 'left: auto; right: 0',
				],
				'condition' => [
					'show_onsale_flash' => 'yes',
				],
			]
		);

		$this->add_control(
			'onsale_distance',
			[
				'label' => esc_html__( 'Distance', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => -20,
						'max' => 20,
					],
					'em' => [
						'min' => -2,
						'max' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.pp-wc-products ul.products li.product span.onsale' => 'margin: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_onsale_flash' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$limit = '-1';
		$columns = 4;
		$orderby = 'rand';
		$order = 'desc';

		if ( ! empty( $settings['columns'] ) ) {
			$columns = $settings['columns'];
		}

		if ( ! empty( $settings['orderby'] ) ) {
			$orderby = $settings['orderby'];
		}

		if ( ! empty( $settings['order'] ) ) {
			$order = $settings['order'];
		}

		do_action( 'pp_woo_builder_widget_before_render', $this );

		if ( PP_Helper::is_edit_mode() ) {
			echo wp_kses_post( PP_Woo_Helper::get_instance()->default( $this->get_name() ) );
		} else {
			woocommerce_upsell_display( $limit, $columns, $orderby, $order );
		}

		do_action( 'pp_woo_builder_widget_after_render', $this );

	}

	public function render_plain_content() {}

}
