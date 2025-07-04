<?php
namespace PowerpackElements\Modules\ReviewBox\Widgets;

use PowerpackElements\Base\Powerpack_Widget;
use PowerpackElements\Classes\PP_Helper;
use PowerpackElements\Classes\PP_Config;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Control_Media;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Review Box Widget
 */
class Review_Box extends Powerpack_Widget {

	/**
	 * Retrieve review box widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_name( 'Review_Box' );
	}

	/**
	 * Retrieve review box widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Review_Box' );
	}

	/**
	 * Retrieve review box widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Review_Box' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.4.13.1
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Review_Box' );
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	/**
	 * Retrieve the list of styles the offcanvas content widget depended on.
	 *
	 * Used to set style dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends() {
		$styles = ['widget-pp-review-box'];

		if ( Icons_Manager::is_migration_allowed() ) {
			array_push( $styles, 'elementor-icons-fa-solid' );
		}

		return $styles;
	}

	public function has_widget_inner_wrapper(): bool {
		return ! PP_Helper::is_feature_active( 'e_optimized_markup' );
	}

	private static function get_network_icon_data( $network_name ) {
		$prefix = 'fa ';
		$library = '';

		if ( Icons_Manager::is_migration_allowed() ) {
			$prefix = 'fas ';
			$library = 'fa-solid';
		}

		return [
			'value' => $prefix . 'fa-' . $network_name,
			'library' => $library,
		];
	}

	/**
	 * Register review box widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.0.3
	 * @access protected
	 */
	protected function register_controls() {

		$this->register_presets_control( 'Review_Box', $this );

		/* Content Tab */
		$this->register_content_review_box_controls();
		$this->register_content_review_items_controls();
		$this->register_content_pros_controls();
		$this->register_content_cons_controls();
		$this->register_content_summary_controls();
		$this->register_content_help_docs_controls();

		/* Style Tab */
		$this->register_style_review_box_controls();
		$this->register_style_review_box_title_controls();
		$this->register_style_review_box_description_controls();
		$this->register_style_review_box_image_controls();
		$this->register_style_review_items_controls();
		$this->register_style_pros_controls();
		$this->register_style_cons_controls();
		$this->register_style_final_rating_controls();
		$this->register_style_summary_controls();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CONTENT TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_content_review_box_controls() {
		/**
		 * Content Tab: Review Box
		 */
		$this->start_controls_section(
			'section_review_box',
			[
				'label'                 => esc_html__( 'Review Box', 'powerpack' ),
			]
		);

		$this->add_control(
			'review_type',
			[
				'label'                 => esc_html__( 'Review Type', 'powerpack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'stars',
				'options'               => [
					'stars'     => esc_html__( 'Stars', 'powerpack' ),
					'percent'   => esc_html__( 'Percent', 'powerpack' ),
					'number'    => esc_html__( 'Number', 'powerpack' ),
				],
			]
		);

		$this->add_control(
			'box_title',
			[
				'label'                 => esc_html__( 'Title', 'powerpack' ),
				'type'                  => Controls_Manager::TEXT,
				'label_block'           => true,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => esc_html__( 'Review Title', 'powerpack' ),
				'title'                 => esc_html__( 'Enter review title', 'powerpack' ),
			]
		);

		$this->add_control(
			'box_title_html_tag',
			[
				'label'                 => esc_html__( 'Title HTML Tag', 'powerpack' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default'               => 'h2',
			]
		);

		$this->add_control(
			'review_description',
			[
				'label'                 => esc_html__( 'Description', 'powerpack' ),
				'type'                  => Controls_Manager::TEXTAREA,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => esc_html__( 'These heavenly brownies are pure chocolate overload, featuring a fudgy center, slightly crusty top and layers of decadence. It doesn\'t get better than this.', 'powerpack' ),
				'title'                 => esc_html__( 'Review description', 'powerpack' ),
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'                 => esc_html__( 'Show Image', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => esc_html__( 'Yes', 'powerpack' ),
				'label_off'             => esc_html__( 'No', 'powerpack' ),
				'return_value'          => 'yes',
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'image',
			[
				'label'                 => esc_html__( 'Image', 'powerpack' ),
				'type'                  => Controls_Manager::MEDIA,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => [
					'url'  => Utils::get_placeholder_image_src(),
				],
				'condition'             => [
					'show_image'    => 'yes',
				],
			]
		);

		$this->add_control(
			'pros',
			[
				'label'                 => esc_html__( 'Pros', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => esc_html__( 'Show', 'powerpack' ),
				'label_off'             => esc_html__( 'Hide', 'powerpack' ),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'cons',
			[
				'label'                 => esc_html__( 'Cons', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => esc_html__( 'Show', 'powerpack' ),
				'label_off'             => esc_html__( 'Hide', 'powerpack' ),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'final_rating',
			[
				'label'                 => esc_html__( 'Final Rating', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
				'label_on'              => esc_html__( 'Show', 'powerpack' ),
				'label_off'             => esc_html__( 'Hide', 'powerpack' ),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'final_rating_title',
			[
				'label'                 => esc_html__( 'Final Rating Title', 'powerpack' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => esc_html__( 'Final Rating', 'powerpack' ),
				'condition'             => [
					'final_rating'  => 'yes',
				],
			]
		);

		$this->add_control(
			'summary',
			[
				'label'                 => esc_html__( 'Show Summary', 'powerpack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => esc_html__( 'Yes', 'powerpack' ),
				'label_off'             => esc_html__( 'No', 'powerpack' ),
				'return_value'          => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_review_items_controls() {
		/**
		 * Content Tab: Review Items
		 */
		$this->start_controls_section(
			'section_review_items',
			[
				'label'                 => esc_html__( 'Review Items', 'powerpack' ),
			]
		);

		$this->add_control(
			'review_features',
			[
				'label'                 => '',
				'type'                  => Controls_Manager::REPEATER,
				'default'               => [
					[
						'feature' => esc_html__( 'Feature #1', 'powerpack' ),
						'rating'  => '8',
					],
					[
						'feature' => esc_html__( 'Feature #2', 'powerpack' ),
						'rating'  => '7',
					],
					[
						'feature' => esc_html__( 'Feature #3', 'powerpack' ),
						'rating'  => '9',
					],
				],
				'fields'                => [
					[
						'name'            => 'feature',
						'label'           => esc_html__( 'Title', 'powerpack' ),
						'type'            => Controls_Manager::TEXT,
						'dynamic'         => [
							'active'  => true,
						],
						'label_block'     => false,
						'placeholder'     => '',
						'default'         => '',
					],
					[
						'name'            => 'rating',
						'label'           => esc_html__( 'Rating (1-10)', 'powerpack' ),
						'type'            => Controls_Manager::TEXT,
						'dynamic'         => [
							'active'  => true,
						],
						'label_block'     => false,
						'placeholder'     => '',
						'default'         => '9',
					],
				],
				'title_field'           => '{{{ feature }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_pros_controls() {
		/**
		 * Content Tab: Pros
		 */
		$this->start_controls_section(
			'section_pros',
			[
				'label'                 => esc_html__( 'Pros', 'powerpack' ),
				'condition'             => [
					'pros'    => 'yes',
				],
			]
		);

		$this->add_control(
			'pros_title',
			[
				'label'                 => esc_html__( 'Title', 'powerpack' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => esc_html__( 'Pros', 'powerpack' ),
				'condition'             => [
					'pros'    => 'yes',
				],
			]
		);

		$this->add_control(
			'select_pros_list_icon',
			[
				'label'                 => esc_html__( 'List Icon', 'powerpack' ),
				'type'                  => Controls_Manager::ICONS,
				'fa4compatibility'      => 'pros_list_icon',
				'default'               => [
					'value'     => 'fas fa-check',
					'library'   => 'fa-solid',
				],
				'condition'             => [
					'pros'    => 'yes',
				],
			]
		);

		$repeater_pros = new Repeater();

		$repeater_pros->add_control(
			'review_pro',
			[
				'label'                 => esc_html__( 'Description', 'powerpack' ),
				'type'                  => Controls_Manager::TEXTAREA,
				'label_block'           => true,
				'rows'                  => 3,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => '',
			]
		);

		$this->add_control(
			'review_pros',
			[
				'label'                 => '',
				'type'                  => Controls_Manager::REPEATER,
				'default'               => [
					[
						'review_pro'    => esc_html__( 'Pro #1', 'powerpack' ),
					],
					[
						'review_pro'    => esc_html__( 'Pro #2', 'powerpack' ),
					],
					[
						'review_pro'    => esc_html__( 'Pro #3', 'powerpack' ),
					],
				],
				'fields'                => $repeater_pros->get_controls(),
				'title_field'           => '{{{ review_pro }}}',
				'condition'             => [
					'pros'    => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_cons_controls() {
		/**
		 * Content Tab: Cons
		 */
		$this->start_controls_section(
			'section_cons',
			[
				'label'                 => esc_html__( 'Cons', 'powerpack' ),
				'condition'             => [
					'cons'    => 'yes',
				],
			]
		);

		$this->add_control(
			'cons_title',
			[
				'label'                 => esc_html__( 'Title', 'powerpack' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => esc_html__( 'Cons', 'powerpack' ),
				'condition'             => [
					'cons'    => 'yes',
				],
			]
		);

		$this->add_control(
			'select_cons_list_icon',
			[
				'label'                 => esc_html__( 'List Icon', 'powerpack' ),
				'type'                  => Controls_Manager::ICONS,
				'fa4compatibility'      => 'cons_list_icon',
				'default'               => [
					'value'     => 'fas fa-times',
					'library'   => 'fa-solid',
				],
				'condition'             => [
					'cons'    => 'yes',
				],
			]
		);

		$this->add_control(
			'review_cons',
			[
				'label'                 => '',
				'type'                  => Controls_Manager::REPEATER,
				'default'               => [
					[
						'review_con' => esc_html__( 'Con #1', 'powerpack' ),
					],
					[
						'review_con' => esc_html__( 'Con #2', 'powerpack' ),
					],
					[
						'review_con' => esc_html__( 'Con #3', 'powerpack' ),
					],
				],
				'fields'                => [
					[
						'name'          => 'review_con',
						'label'         => esc_html__( 'Description', 'powerpack' ),
						'type'          => Controls_Manager::TEXTAREA,
						'rows'          => 3,
						'dynamic'       => [
							'active'    => true,
						],
						'label_block'   => true,
						'default'       => '',
					],
				],
				'title_field'           => '{{{ review_con }}}',
				'condition'             => [
					'cons'    => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_summary_controls() {
		/**
		 * Content Tab: Summary
		 */
		$this->start_controls_section(
			'section_summary',
			[
				'label'                 => esc_html__( 'Summary', 'powerpack' ),
				'condition'             => [
					'summary'    => 'yes',
				],
			]
		);

		$this->add_control(
			'summary_title',
			[
				'label'                 => esc_html__( 'Title', 'powerpack' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => esc_html__( 'Summary Title', 'powerpack' ),
				'condition'             => [
					'summary'    => 'yes',
				],
			]
		);

		$this->add_control(
			'summary_text',
			[
				'label'                 => esc_html__( 'Summary', 'powerpack' ),
				'type'                  => Controls_Manager::TEXTAREA,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => esc_html__( 'Here goes the description for summary!', 'powerpack' ),
				'condition'             => [
					'summary'    => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_help_docs_controls() {

		$help_docs = PP_Config::get_widget_help_links( 'Review_Box' );
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

	protected function register_style_review_box_controls() {
		/**
		 * Style Tab: Review Box
		 */
		$this->start_controls_section(
			'section_review_box_style',
			[
				'label'                 => esc_html__( 'Review Box', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'review_box_bg_color',
				'types'                 => [ 'classic', 'gradient' ],
				'selector'              => '{{WRAPPER}} .pp-review-box-container',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'review_box_border',
				'label'                 => esc_html__( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .pp-review-box-container',
			]
		);

		$this->add_responsive_control(
			'review_box_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'review_box_shadow',
				'selector'              => '{{WRAPPER}} .pp-review-box-container',
			]
		);

		$this->add_responsive_control(
			'review_box_padding',
			[
				'label'                 => esc_html__( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'review_box_bg_overlay_heading',
			[
				'label'                 => esc_html__( 'Background Overlay', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'review_box_bg_overlay',
				'types'                 => [ 'classic', 'gradient' ],
				'selector'              => '{{WRAPPER}} .pp-review-box-overlay',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_review_box_title_controls() {
		/**
		 * Style Tab: Box Title
		 */
		$this->start_controls_section(
			'section_review_box_title_style',
			[
				'label'                 => esc_html__( 'Title', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'box_title!'    => '',
				],
			]
		);

		$this->add_control(
			'title_text_color',
			[
				'label'                 => esc_html__( 'Text Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'global'                => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-title' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'box_title!'    => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'title_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector'              => '{{WRAPPER}} .pp-review-box-title',
				'condition'             => [
					'box_title!'    => '',
				],
			]
		);

		$this->add_control(
			'title_border_bottom',
			[
				'label'                 => esc_html__( 'Border Bottom', 'powerpack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'none',
				'options'               => [
					'none'      => esc_html__( 'None', 'powerpack' ),
					'solid'     => esc_html__( 'Solid', 'powerpack' ),
					'dashed'    => esc_html__( 'Dashed', 'powerpack' ),
					'dotted'    => esc_html__( 'Dotted', 'powerpack' ),
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-title' => 'border-bottom-style: {{VALUE}};',
				],
				'condition'             => [
					'box_title!'    => '',
				],
			]
		);

		$this->add_control(
			'title_border_bottom_color',
			[
				'label'                 => esc_html__( 'Border Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-title' => 'border-bottom-color: {{VALUE}};',
				],
				'condition'             => [
					'box_title!'    => '',
					'title_border_bottom!'  => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'title_border_bottom_width',
			[
				'label'                 => esc_html__( 'Border Width', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'default'               => [
					'size'      => 1,
					'unit'      => 'px',
				],
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 10,
						'step'  => 1,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-title' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
				'condition'             => [
					'box_title!'    => '',
					'title_border_bottom!'  => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'review_box_title_padding',
			[
				'label'                 => esc_html__( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'box_title!'    => '',
					'title_border_bottom!'  => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'review_box_title_spacing',
			[
				'label'                 => esc_html__( 'Spacing', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default'               => [
					'size'      => 5,
					'unit'      => 'px',
				],
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition'             => [
					'box_title!'    => '',
				],
			]
		);

		$this->add_responsive_control(
			'title_text_align',
			[
				'label'                 => esc_html__( 'Text Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify'   => [
						'title' => esc_html__( 'Justified', 'powerpack' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-title'   => 'text-align: {{VALUE}};',
				],
				'condition'             => [
					'box_title!'    => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_review_box_description_controls() {
		/**
		 * Style Tab: Box Description
		 */
		$this->start_controls_section(
			'section_review_box_description_style',
			[
				'label'                 => esc_html__( 'Description', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'review_description!'   => '',
				],
			]
		);

		$this->add_control(
			'description_text_color',
			[
				'label'                 => esc_html__( 'Text Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'global'                => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-description' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'review_description!'   => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'description_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'              => '{{WRAPPER}} .pp-review-box-description',
				'condition'             => [
					'review_description!'   => '',
				],
			]
		);

		$this->add_control(
			'description_border_bottom',
			[
				'label'                 => esc_html__( 'Border Bottom', 'powerpack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'none',
				'options'               => [
					'none'      => esc_html__( 'None', 'powerpack' ),
					'solid'     => esc_html__( 'Solid', 'powerpack' ),
					'dashed'    => esc_html__( 'Dashed', 'powerpack' ),
					'dotted'    => esc_html__( 'Dotted', 'powerpack' ),
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-description' => 'border-bottom-style: {{VALUE}};',
				],
				'condition'             => [
					'review_description!'   => '',
				],
			]
		);

		$this->add_control(
			'description_border_bottom_color',
			[
				'label'                 => esc_html__( 'Border Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-description' => 'border-bottom-color: {{VALUE}};',
				],
				'condition'             => [
					'review_description!'           => '',
					'description_border_bottom!'    => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'description_border_bottom_width',
			[
				'label'                 => esc_html__( 'Border Width', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'default'               => [
					'size'      => 1,
					'unit'      => 'px',
				],
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 10,
						'step'  => 1,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-description' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
				'condition'             => [
					'review_description!'           => '',
					'description_border_bottom!'    => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'description_padding',
			[
				'label'                 => esc_html__( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'review_description!'           => '',
					'description_border_bottom!'    => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'description_text_align',
			[
				'label'                 => esc_html__( 'Text Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify'   => [
						'title' => esc_html__( 'Justified', 'powerpack' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-description'   => 'text-align: {{VALUE}};',
				],
				'condition'             => [
					'review_description!'   => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_review_box_image_controls() {
		/**
		 * Style Tab: Image
		 */
		$this->start_controls_section(
			'section_review_box_image_style',
			[
				'label'                 => esc_html__( 'Image', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'show_image'    => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'                 => esc_html__( 'Width', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'                 => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-box-image' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_image'    => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_review_items_controls() {
		/**
		 * Style Tab: Review Items
		 */
		$this->start_controls_section(
			'section_review_items_style',
			[
				'label'                 => esc_html__( 'Review Items', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'review_item_color',
			[
				'label'                 => esc_html__( 'Text Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'global'                => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-feature .pp-review-feature-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'review_item_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'              => '{{WRAPPER}} .pp-review-feature .pp-review-feature-text',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'review_items_border',
				'label'                 => esc_html__( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .pp-review-features',
			]
		);

		$this->add_responsive_control(
			'review_items_padding',
			[
				'label'                 => esc_html__( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-features' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'review_items_spacing',
			[
				'label'                 => esc_html__( 'Items Spacing', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'                 => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-features-list .pp-review-feature:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'review_item_rating_heading',
			[
				'label'                 => esc_html__( 'Star Rating', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'review_type'   => 'stars',
				],
			]
		);

		$this->add_control(
			'review_item_rating_bar_heading',
			[
				'label'                 => esc_html__( 'Rating Bar', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'review_type'   => [ 'percent', 'number' ],
				],
			]
		);

		$this->add_control(
			'review_items_text_position',
			[
				'label'                 => esc_html__( 'Text Position', 'powerpack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'over',
				'options'               => [
					'above'     => esc_html__( 'Above', 'powerpack' ),
					'over'      => esc_html__( 'Over', 'powerpack' ),
				],
				'prefix_class'          => 'pp-rating-bar-text-',
				'condition'             => [
					'review_type'   => [ 'percent', 'number' ],
				],
			]
		);

		$this->add_responsive_control(
			'review_item_rating_bar_height',
			[
				'label'                 => esc_html__( 'Bar Thickness', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'range'                 => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-bar' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'review_type'   => [ 'percent', 'number' ],
				],
			]
		);

		$this->add_responsive_control(
			'review_item_rating_size',
			[
				'label'                 => esc_html__( 'Size', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'range'                 => [
					'px' => [
						'min' => 5,
						'max' => 40,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-stars' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'review_type'   => 'stars',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_rating_style' );

		$this->start_controls_tab(
			'tab_rating_normal',
			[
				'label'                 => esc_html__( 'Normal', 'powerpack' ),
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'                 => esc_html__( 'Star Rating Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#ccd6df',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-stars .pp-rating-star' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'review_type'   => 'stars',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'review_bar_color',
				'types'                 => [ 'classic', 'gradient' ],
				'exclude'               => [ 'image' ],
				'selector'              => '{{WRAPPER}} .pp-review-bar',
				'condition'             => [
					'review_type'   => [ 'percent', 'number' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_bar_overlay',
			[
				'label'                 => esc_html__( 'Overlay', 'powerpack' ),
			]
		);

		$this->add_control(
			'rating_overlay_color',
			[
				'label'                 => esc_html__( 'Star Rating Overlay Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#f0ad4e',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-stars-overlay .pp-rating-star' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'review_type'   => 'stars',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'review_bar_color_overlay',
				'types'                 => [ 'classic', 'gradient' ],
				'exclude'               => [ 'image' ],
				'selector'              => '{{WRAPPER}} .pp-review-bar-overlay',
				'condition'             => [
					'review_type'   => [ 'percent', 'number' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_pros_controls() {
		/**
		 * Style Tab: Pros
		 */
		$this->start_controls_section(
			'section_pros_style',
			[
				'label'                 => esc_html__( 'Pros', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'pros_list_spacing',
			[
				'label'                 => esc_html__( 'Items Gap', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'range'                 => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-pros li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_control(
			'pros_title_style',
			[
				'label'                 => esc_html__( 'Title', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_control(
			'pros_title_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-pros-title' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'pros_title_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'selector'              => '{{WRAPPER}} .pp-review-pros-title',
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'pros_title_text_align',
			[
				'label'                 => esc_html__( 'Text Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-pros-title'   => 'text-align: {{VALUE}};',
				],
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_control(
			'pros_content_style',
			[
				'label'                 => esc_html__( 'Content', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_control(
			'pros_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-pros-list' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'pros_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'selector'              => '{{WRAPPER}} .pp-review-pros-list',
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'pros_text_align',
			[
				'label'                 => esc_html__( 'Text Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify'   => [
						'title' => esc_html__( 'Justified', 'powerpack' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-pros-list'   => 'text-align: {{VALUE}};',
				],
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_control(
			'pros_list_style',
			[
				'label'                 => esc_html__( 'Divider', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_control(
			'pros_list_border_type',
			[
				'label'                 => esc_html__( 'Divider Type', 'powerpack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'none',
				'options'               => [
					'none'      => esc_html__( 'None', 'powerpack' ),
					'solid'     => esc_html__( 'Solid', 'powerpack' ),
					'dotted'    => esc_html__( 'Dotted', 'powerpack' ),
					'dashed'    => esc_html__( 'Dashed', 'powerpack' ),
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-pros li:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
				],
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_control(
			'pros_list_border_color',
			[
				'label'                 => esc_html__( 'Divider Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-pros li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
				],
				'condition'             => [
					'pros'                     => 'yes',
					'pros_list_border_type!'   => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'pros_list_border_width',
			[
				'label'                 => esc_html__( 'Divider Weight', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'default'               => [
					'size'      => 1,
					'unit'      => 'px',
				],
				'range'                 => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-pros li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'pros'                      => 'yes',
					'pros_list_border_type!'    => 'none',
				],
			]
		);

		$this->add_control(
			'pros_list_icon_style',
			[
				'label'                 => esc_html__( 'Icon', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->add_control(
			'pros_list_icon_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-pros .pp-review-list-icon' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'pros'      => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_cons_controls() {
		/**
		 * Style Tab: Cons
		 */
		$this->start_controls_section(
			'section_cons_style',
			[
				'label'                 => esc_html__( 'Cons', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'cons_list_spacing',
			[
				'label'                 => esc_html__( 'Items Gap', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'range'                 => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-cons-list li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_control(
			'cons_title_style',
			[
				'label'                 => esc_html__( 'Title', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_control(
			'cons_title_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-cons-title' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'cons_title_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'selector'              => '{{WRAPPER}} .pp-review-cons-title',
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'cons_title_text_align',
			[
				'label'                 => esc_html__( 'Text Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-cons-title'   => 'text-align: {{VALUE}};',
				],
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_control(
			'cons_content_style',
			[
				'label'                 => esc_html__( 'Content', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_control(
			'cons_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-cons-list' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'cons_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'selector'              => '{{WRAPPER}} .pp-review-cons-list',
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'cons_text_align',
			[
				'label'                 => esc_html__( 'Text Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify'   => [
						'title' => esc_html__( 'Justified', 'powerpack' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-cons-list'   => 'text-align: {{VALUE}};',
				],
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_control(
			'cons_list_style',
			[
				'label'                 => esc_html__( 'Divider', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_control(
			'cons_list_border_type',
			[
				'label'                 => esc_html__( 'Divider Type', 'powerpack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'none',
				'options'               => [
					'none'      => esc_html__( 'None', 'powerpack' ),
					'solid'     => esc_html__( 'Solid', 'powerpack' ),
					'dotted'    => esc_html__( 'Dotted', 'powerpack' ),
					'dashed'    => esc_html__( 'Dashed', 'powerpack' ),
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-cons-list li:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
				],
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_control(
			'cons_list_border_color',
			[
				'label'                 => esc_html__( 'Divider Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-cons-list li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
				],
				'condition'             => [
					'cons'                      => 'yes',
					'cons_list_border_type!'    => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'cons_list_border_width',
			[
				'label'                 => esc_html__( 'Divider Weight', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'default'               => [
					'size'      => '1',
					'unit'      => 'px',
				],
				'range'                 => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-cons-list li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'cons'                      => 'yes',
					'cons_list_border_type!'    => 'none',
				],
			]
		);

		$this->add_control(
			'cons_list_icon_style',
			[
				'label'                 => esc_html__( 'Icon', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->add_control(
			'cons_list_icon_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-cons .pp-review-list-icon' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'cons'      => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_final_rating_controls() {
		/**
		 * Style Tab: Final Rating
		 */
		$this->start_controls_section(
			'section_final_rating_style',
			[
				'label'                 => esc_html__( 'Final Rating', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'final_rating'  => 'yes',
				],
			]
		);

		$this->add_control(
			'final_rating_position',
			[
				'label'                 => esc_html__( 'Align', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'toggle'                => false,
				'options'               => [
					'left'  => [
						'title'     => esc_html__( 'Left', 'powerpack' ),
						'icon'      => 'eicon-h-align-left',
					],
					'center'        => [
						'title'     => esc_html__( 'Center', 'powerpack' ),
						'icon'      => 'eicon-h-align-center',
					],
					'right'         => [
						'title'     => esc_html__( 'Right', 'powerpack' ),
						'icon'      => 'eicon-h-align-right',
					],
				],
				'default'               => 'left',
				'prefix_class'          => 'pp-final-rating-',
			]
		);

		$this->add_control(
			'final_rating_bg_color',
			[
				'label'                 => esc_html__( 'Background Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-final-rating-wrap' => 'background-color: {{VALUE}}',
				],
				'condition'             => [
					'final_rating'  => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'final_rating_border',
				'label'                 => esc_html__( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .pp-review-final-rating-wrap',
			]
		);

		$this->add_responsive_control(
			'final_rating_padding',
			[
				'label'                 => esc_html__( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-final-rating-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'final_rating'  => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'final_rating_spacing_above',
			[
				'label'                 => esc_html__( 'Spacing Above', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'default'               => [
					'size'      => 20,
					'unit'      => 'px',
				],
				'range'                 => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-final-rating-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'final_rating'  => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'final_rating_spacing',
			[
				'label'                 => esc_html__( 'Spacing', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'range'                 => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'             => [
					'{{WRAPPER}}.pp-final-rating-right .pp-review-final-rating-wrap' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.pp-final-rating-left .pp-review-final-rating-wrap' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.pp-final-rating-center .pp-review-final-rating-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'final_rating'  => 'yes',
					'summary'       => 'yes',
				],
			]
		);

		$this->add_control(
			'final_rating_title_style',
			[
				'label'                 => esc_html__( 'Title', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'final_rating'          => 'yes',
					'final_rating_title!'   => '',
				],
			]
		);

		$this->add_control(
			'final_rating_title_position',
			[
				'label'                 => esc_html__( 'Title Position', 'powerpack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'top',
				'options'               => [
					'top'       => esc_html__( 'Top', 'powerpack' ),
					'bottom'    => esc_html__( 'Bottom', 'powerpack' ),
				],
				'condition'             => [
					'final_rating'          => 'yes',
					'final_rating_title!'   => '',
				],
			]
		);

		$this->add_control(
			'final_rating_title_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'global'                => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-final-rating-title' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'final_rating'          => 'yes',
					'final_rating_title!'   => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'final_rating_title_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector'              => '{{WRAPPER}} .pp-review-final-rating-title',
				'condition'             => [
					'final_rating'          => 'yes',
					'final_rating_title!'   => '',
				],
			]
		);

		$this->add_control(
			'final_rating_style',
			[
				'label'                 => esc_html__( 'Rating', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'final_rating'  => 'yes',
				],
			]
		);

		$this->add_control(
			'final_rating_text_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-final-rating' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'final_rating'  => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'final_rating_text_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'              => '{{WRAPPER}} .pp-review-final-rating',
				'condition'             => [
					'final_rating'  => 'yes',
				],
			]
		);

		$this->add_control(
			'final_rating_stars_style',
			[
				'label'                 => esc_html__( 'Stars', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'final_rating'  => 'yes',
					'review_type'   => 'stars',
				],
			]
		);

		$this->add_responsive_control(
			'final_rating_stars_size',
			[
				'label'                 => esc_html__( 'Size', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'range'                 => [
					'px' => [
						'min' => 5,
						'max' => 40,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-final-rating-wrap .pp-review-stars' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'final_rating'  => 'yes',
					'review_type'   => 'stars',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_summary_controls() {
		/**
		 * Style Tab: Summary
		 */
		$this->start_controls_section(
			'section_summary_style',
			[
				'label'                 => esc_html__( 'Summary', 'powerpack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,

				'condition'             => [
					'summary'    => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'summary_spacing',
			[
				'label'                 => esc_html__( 'Spacing Above', 'powerpack' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em', 'rem', 'custom' ],
				'default'               => [
					'size'      => 20,
					'unit'      => 'px',
				],
				'range'                 => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-review-summary-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'summary'    => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'summary_text_align',
			[
				'label'                 => esc_html__( 'Text Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify'   => [
						'title' => esc_html__( 'Justified', 'powerpack' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-summary'   => 'text-align: {{VALUE}};',
				],
				'condition'             => [
					'summary'    => 'yes',
				],
			]
		);

		$this->add_control(
			'summary_title_style',
			[
				'label'                 => esc_html__( 'Title', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'summary'           => 'yes',
					'summary_title!'    => '',
				],
			]
		);

		$this->add_control(
			'summary_title_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-summary-title' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'summary'           => 'yes',
					'summary_title!'    => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'summary_title_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'              => '{{WRAPPER}} .pp-review-summary-title',
				'condition'             => [
					'summary'           => 'yes',
					'summary_title!'    => '',
				],
			]
		);

		$this->add_control(
			'summary_content_style',
			[
				'label'                 => esc_html__( 'Content', 'powerpack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'summary'       => 'yes',
					'summary_text!' => '',
				],
			]
		);

		$this->add_control(
			'summary_color',
			[
				'label'                 => esc_html__( 'Color', 'powerpack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-review-summary-content' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'summary'       => 'yes',
					'summary_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'summary_typography',
				'label'                 => esc_html__( 'Typography', 'powerpack' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'              => '{{WRAPPER}} .pp-review-summary-content',
				'condition'             => [
					'summary'       => 'yes',
					'summary_text!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render review pros output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_review_pros() {
		$settings = $this->get_settings_for_display();

		if ( ! isset( $settings['pros_list_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['pros_list_icon'] = 'fa fa-check';
		}

		$has_icon = ! empty( $settings['pros_list_icon'] );

		if ( $has_icon ) {
			$this->add_render_attribute( 'pros-i', 'class', $settings['pros_list_icon'] );
			$this->add_render_attribute( 'pros-i', 'aria-hidden', 'true' );
		}

		if ( ! $has_icon && ! empty( $settings['select_pros_list_icon']['value'] ) ) {
			$has_icon = true;
		}
		$migrated = isset( $settings['__fa4_migrated']['select_pros_list_icon'] );
		$is_new = ! isset( $settings['pros_list_icon'] ) && Icons_Manager::is_migration_allowed();

		if ( 'yes' === $settings['pros'] ) { ?>
			<div class="pp-review-pros">
				<?php if ( $settings['pros_title'] ) { ?>
					<div class="pp-review-box-subheading pp-review-pros-title">
						<?php echo wp_kses_post( $settings['pros_title'] ); ?>
					</div>
				<?php } ?>
				<ul class="pp-review-pros-list pp-review-box-list">
					<?php
					foreach ( $settings['review_pros'] as $index => $item ) :

						$pros_key = $this->get_repeater_setting_key( 'review_pro', 'review_pros', $index );
						$this->add_render_attribute( $pros_key, 'class', 'pp-pros-list-text' );
						$this->add_inline_editing_attributes( $pros_key, 'none' );

						if ( $item['review_pro'] ) : ?>
							<li class="pp-review-pro">
								<?php
								if ( $has_icon ) {
									echo '<span class="pp-review-list-icon pp-icon">';
									if ( $is_new || $migrated ) {
										Icons_Manager::render_icon( $settings['select_pros_list_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( ! empty( $settings['pros_list_icon'] ) ) {
										?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'pros-i' ) ); ?>></i><?php
									}
									echo '</span>';
								}

								printf( '<span %1$s>%2$s</span>', wp_kses_post( $this->get_render_attribute_string( $pros_key ) ), wp_kses_post( $item['review_pro'] ) );
								?>
							</li>
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</div>
			<?php
		}
	}

	/**
	 * Render review cons output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_review_cons() {
		$settings = $this->get_settings_for_display();

		if ( ! isset( $settings['cons_list_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['cons_list_icon'] = 'fa fa-times';
		}

		$has_cons_icon = ! empty( $settings['cons_list_icon'] );

		if ( $has_cons_icon ) {
			$this->add_render_attribute( 'cons-i', 'class', $settings['cons_list_icon'] );
			$this->add_render_attribute( 'cons-i', 'aria-hidden', 'true' );
		}

		if ( ! $has_cons_icon && ! empty( $settings['select_cons_list_icon']['value'] ) ) {
			$has_cons_icon = true;
		}
		$migrated_cons_icon = isset( $settings['__fa4_migrated']['select_cons_list_icon'] );
		$is_new_cons_icon = ! isset( $settings['cons_list_icon'] ) && Icons_Manager::is_migration_allowed();

		if ( 'yes' === $settings['cons'] ) { ?>
			<div class="pp-review-cons">
				<?php if ( $settings['cons_title'] ) { ?>
					<div class="pp-review-box-subheading pp-review-cons-title">
						<?php echo wp_kses_post( $settings['cons_title'] ); ?>
					</div>
				<?php } ?>
				<ul class="pp-review-cons-list pp-review-box-list">
					<?php
					foreach ( $settings['review_cons'] as $index => $item ) :

						$cons_key = $this->get_repeater_setting_key( 'review_con', 'review_pros', $index );
						$this->add_render_attribute( $cons_key, 'class', 'pp-cons-list-text' );
						$this->add_inline_editing_attributes( $cons_key, 'none' );

						if ( $item['review_con'] ) : ?>
							<li class="pp-review-con">
								<?php
								if ( $has_cons_icon ) {
									echo '<span class="pp-review-list-icon pp-icon">';
									if ( $is_new_cons_icon || $migrated_cons_icon ) {
										Icons_Manager::render_icon( $settings['select_cons_list_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( ! empty( $settings['cons_list_icon'] ) ) {
										?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'cons-i' ) ); ?>></i><?php
									}
									echo '</span>';
								}

								printf( '<span %1$s>%2$s</span>', wp_kses_post( $this->get_render_attribute_string( $cons_key ) ), wp_kses_post( $item['review_con'] ) );
								?>
							</li>
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</div>
			<?php
		}
	}

	/**
	 * Render review summary output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_review_summary() {
		$settings = $this->get_settings_for_display();

		if ( 'yes' === $settings['summary'] || 'yes' === $settings['final_rating'] ) { ?>
			<div class="pp-review-summary">
				<?php $this->render_final_rating(); ?>

				<?php if ( 'yes' === $settings['summary'] && ( $settings['summary_title'] || $settings['summary_text'] ) ) { ?>
				<div class="pp-review-summary-wrap">
					<?php if ( $settings['summary_title'] ) { ?>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'summary_title' ) ); ?>>
							<?php echo wp_kses_post( $settings['summary_title'] ); ?>
						</div>
					<?php } ?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'summary_text' ) ); ?>>
						<?php
							$pp_allowed_html = wp_kses_allowed_html();
							echo wp_kses( $settings['summary_text'], $pp_allowed_html );
						?>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php
		}
	}

	private static function render_star_icon( $network_name ) {
		$network_icon_data = self::get_network_icon_data( $network_name );

		if ( PP_Helper::is_feature_active( 'e_font_icon_svg' ) ) {
			$icon = Icons_Manager::render_font_icon( $network_icon_data, [ 'class' => 'pp-rating-star' ] );
		} else {
			$icon = sprintf( '<i class="pp-rating-star %s" aria-hidden="true"></i>', $network_icon_data['value'] );
		}

		return $icon;
	}

	/**
	 * Render review box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_final_rating() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'final_rating_title', 'class', 'pp-review-final-rating-title' );
		$this->add_inline_editing_attributes( 'final_rating_title', 'none' );

		if ( 'yes' === $settings['final_rating'] ) {
			$this->add_render_attribute( 'final-rating', 'class', 'pp-review-final-rating' );

			$rating = null;

			foreach ( $settings['review_features'] as $index => $item ) {
				$rating += (float) $item['rating'];
			}

			$items_count = count( $settings['review_features'] );
			$avg_rating = $rating / $items_count;

			$rating_star_val = $avg_rating / 2;
			$rating_percent_val = $avg_rating * 10;
			$rating_star = sprintf(
				_nx(
					'%1$s Star',
					'%1$s Stars',
					$rating_star_val,
					'',
					'powerpack'
				),
				$rating_star_val
			);
			$final_rating_overlay_key = 'final_rating_overlay' . $index;
			$this->add_render_attribute( $final_rating_overlay_key, 'class', 'pp-review-overlay' );
			$stars = '';
			for ( $x = 1; $x <= 5; $x++ ) {
				$stars .= self::render_star_icon('star');
			}
			$this->add_render_attribute( $final_rating_overlay_key, 'class', 'pp-review-stars-overlay' );
			$this->add_render_attribute( $final_rating_overlay_key, 'style', 'width:' . $rating_star_val * 20 . '%' );
			?>
			<?php if ( 'yes' === $settings['final_rating'] ) { ?>
			<div class="pp-review-final-rating-wrap">
				<?php if ( $settings['final_rating_title'] && 'top' === $settings['final_rating_title_position'] ) { ?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'final_rating_title' ) ); ?>>
						<?php echo wp_kses_post( $settings['final_rating_title'] ); ?>
					</div>
				<?php } ?>
				<?php if ( 'stars' === $settings['review_type'] ) { ?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'final-rating' ) ); ?>>
						<?php
							echo esc_html( round( $rating_star_val, 2 ) );
						?>
					</div>
					<span class="pp-review-stars" title="<?php echo esc_attr( $rating_star ); ?>">
						<?php echo \Elementor\Utils::print_unescaped_internal_string( $stars ); ?>
						<span <?php echo wp_kses_post( $this->get_render_attribute_string( $final_rating_overlay_key ) ); ?>>
							<?php echo \Elementor\Utils::print_unescaped_internal_string( $stars ); ?>
						</span>
					</span>
				<?php } elseif ( 'percent' === $settings['review_type'] ) { ?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'final-rating' ) ); ?>>
						<?php
							echo esc_html( round( $rating_percent_val, 2 ) ) . '%';
						?>
					</div>
				<?php } elseif ( 'number' === $settings['review_type'] ) { ?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'final-rating' ) ); ?>>
						<?php
							echo esc_html( round( $avg_rating, 2 ) );
						?>
					</div>
				<?php } ?>
				<?php if ( $settings['final_rating_title'] && 'bottom' === $settings['final_rating_title_position'] ) { ?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'final_rating_title' ) ); ?>>
						<?php echo wp_kses_post( $settings['final_rating_title'] ); ?>
					</div>
				<?php } ?>
			</div>
				<?php
			}
		}
	}

	/**
	 * Render review box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'box_title', 'class', 'pp-review-box-title' );
		$this->add_render_attribute( 'box_title', 'itemprop', 'name' );
		$this->add_inline_editing_attributes( 'box_title', 'none' );

		$this->add_render_attribute( 'review_description', 'class', 'pp-review-box-description' );
		$this->add_render_attribute( 'review_description', 'itemprop', 'description' );
		$this->add_inline_editing_attributes( 'review_description', 'basic' );

		$this->add_render_attribute( 'summary_title', 'class', 'pp-review-summary-title' );
		$this->add_inline_editing_attributes( 'summary_title', 'none' );

		$this->add_render_attribute( 'summary_text', 'class', 'pp-review-summary-content' );
		$this->add_inline_editing_attributes( 'summary_text', 'basic' );
		?>
		<div class="pp-review-box-container">
			<div class="pp-review-box-overlay pp-image-overlay"></div>
			<div class="pp-review-box-inner">
				<div class="pp-review-box-header">
					<?php if ( 'yes' === $settings['show_image'] && ! empty( $settings['image']['url'] ) ) { ?>
						<div class="pp-review-box-image">
							<?php
								$this->add_render_attribute( 'image-url', 'content', $settings['image']['url'] );
								$this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
								$this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['image'] ) );
								$this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['image'] ) );

								echo '<img itemprop="image" ' . wp_kses_post( $this->get_render_attribute_string( 'image' ) ) . '>';
							?>
						</div>
					<?php } ?>

					<?php if ( $settings['box_title'] || $settings['review_description'] ) { ?>
						<div class="pp-review-box-content">
							<?php if ( ! empty( $settings['box_title'] ) ) { ?>
								<?php $title_tag = PP_Helper::validate_html_tag( $settings['box_title_html_tag'] ); ?>
								<<?php PP_Helper::print_validated_html_tag( $title_tag ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'box_title' ) ); ?>>
									<?php echo wp_kses_post( $settings['box_title'] ); ?>
								</<?php PP_Helper::print_validated_html_tag( $title_tag ); ?>>
							<?php } ?>
							<?php if ( ! empty( $settings['review_description'] ) ) { ?>
								<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'review_description' ) ); ?>>
									<?php echo $this->parse_text_editor( $settings['review_description'] ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
				<div class="pp-review-features">
					<ul class="pp-review-features-list pp-review-box-list">
						<?php
						foreach ( $settings['review_features'] as $index => $item ) :

							$feature_key = $this->get_repeater_setting_key( 'feature', 'review_features', $index );
							$this->add_render_attribute( $feature_key, 'class', 'pp-review-feature-text' );
							$this->add_inline_editing_attributes( $feature_key, 'none' );

							if ( $item['feature'] ) : ?>
								<li class="pp-review-feature">
									<?php
									$pp_review_type = $settings['review_type'];
									$pp_rating = (float) $item['rating'];
									$pp_rating_star_val = $pp_rating / 2;
									$pp_rating_percent_val = $pp_rating * 10;
									$pp_rating_star = sprintf(
										_nx(
											'%1$s Star',
											'%1$s Stars',
											$pp_rating_star_val,
											'',
											'powerpack'
										),
										$pp_rating_star_val
									);
									$rating_overlay_key = 'rating_overlay' . $index;
									$this->add_render_attribute( $rating_overlay_key, 'class', 'pp-review-overlay' );
									$pp_stars = '';
									for ( $x = 1; $x <= 5; $x++ ) {
										$pp_stars .= self::render_star_icon('star');
									}
									?>
									<?php if ( 'stars' === $pp_review_type ) {
										$this->add_render_attribute( $rating_overlay_key, 'class', 'pp-review-stars-overlay' );
										$this->add_render_attribute( $rating_overlay_key, 'style', 'width:' . $pp_rating_star_val * 20 . '%' ); ?>
										<span <?php echo wp_kses_post( $this->get_render_attribute_string( $feature_key ) ); ?>>
											<?php echo wp_kses_post( $item['feature'] ); ?>
										</span>
										<span class="pp-review-stars" title="<?php echo esc_attr( $pp_rating_star ); ?>">
											<?php echo \Elementor\Utils::print_unescaped_internal_string( $pp_stars ); ?>
											<span <?php echo wp_kses_post( $this->get_render_attribute_string( $rating_overlay_key ) ); ?>>
												<?php echo \Elementor\Utils::print_unescaped_internal_string( $pp_stars ); ?>
											</span>
										</span>
									<?php } if ( 'percent' === $pp_review_type ) {
										$this->add_render_attribute( $rating_overlay_key, 'class', 'pp-review-bar-overlay pp-review-percent-overlay' );
										$this->add_render_attribute( $rating_overlay_key, 'style', 'width:calc(' . $pp_rating_percent_val . '% + 1.1px)' ); ?>
										<div class="pp-review-percent-bar-wrap">
											<span class="pp-rating-bar-text pp-review-feature-text">
												<?php echo wp_kses_post( $item['feature'] ); ?> - <?php echo wp_kses_post( $pp_rating_percent_val ); ?>%
											</span>
											<div class="pp-review-bar pp-review-percent-bar">
												<div <?php echo wp_kses_post( $this->get_render_attribute_string( $rating_overlay_key ) ); ?>></div>
											</div>
										</div>
									<?php } if ( 'number' === $pp_review_type ) {
										$this->add_render_attribute( $rating_overlay_key, 'class', 'pp-review-bar-overlay pp-review-number-overlay' );
										$this->add_render_attribute( $rating_overlay_key, 'style', 'width:calc(' . $pp_rating * 10 . '% + 1.1px)' ); ?>
										<div class="pp-review-number-bar-wrap">
											<span class="pp-rating-bar-text pp-review-feature-text">
												<?php echo wp_kses_post( $item['feature'] ); ?> - <?php echo wp_kses_post( $pp_rating ); ?>/10
											</span>
											<div class="pp-review-bar pp-review-number-bar">
												<div <?php echo wp_kses_post( $this->get_render_attribute_string( $rating_overlay_key ) ); ?>> </div>
											</div>
										</div>
									<?php } ?>
								</li>
								<?php
							endif;
						endforeach;
						?>
					</ul>
				</div>
				<?php if ( 'yes' === $settings['pros'] || 'yes' === $settings['cons'] ) { ?>
					<div class="pp-review-pros-cons">
						<?php
							$this->render_review_pros();

							$this->render_review_cons();
						?>
					</div>
				<?php } ?>
				<?php $this->render_review_summary(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render review box widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
			var $i = 1;

			function review_pros_template() {
				var prosIconHTML = elementor.helpers.renderIcon( view, settings.select_pros_list_icon, { 'aria-hidden': true }, 'i' , 'object' ),
				prosMigrated = elementor.helpers.isIconMigrated( settings, 'select_pros_list_icon' );
		   
				if ( settings.pros == 'yes' ) { #>
					<div class="pp-review-pros">
						<# if ( settings.pros_title ) { #>
							<div class="pp-review-box-subheading pp-review-pros-title">
								{{{ settings.pros_title }}}
							</div>
						<# } #>
						<ul class="pp-review-pros-list pp-review-box-list">
							<# _.each( settings.review_pros, function( item, index ) {
							   
							var reviewProsTextKey = view.getRepeaterSettingKey( 'review_pro', 'review_pros', index );
							view.addRenderAttribute( reviewProsTextKey, 'class', 'pp-pros-list-text' );
							view.addInlineEditingAttributes( reviewProsTextKey, 'none' );
							#>
								<# if ( item.review_pro ) { #>
									<li class="pp-review-pro">
										<# if ( settings.pros_list_icon || settings.select_pros_list_icon ) { #>
											<span class="pp-review-list-icon pp-icon">
												<# if ( prosIconHTML && prosIconHTML.rendered && ( ! settings.pros_list_icon || prosMigrated ) ) { #>
												{{{ prosIconHTML.value }}}
												<# } else { #>
													<i class="{{ settings.pros_list_icon }}" aria-hidden="true"></i>
												<# } #>
											</span>
										<# } #>
										<span {{{ view.getRenderAttributeString( reviewProsTextKey ) }}}>
											{{{ item.review_pro }}}
										</span>
									</li>
								<# } #>
							<# } ); #>
						</ul>
					</div>
					<#
				}
			}

			function review_cons_template() {
				var consIconHTML = elementor.helpers.renderIcon( view, settings.select_cons_list_icon, { 'aria-hidden': true }, 'i' , 'object' ),
				consMigrated = elementor.helpers.isIconMigrated( settings, 'select_cons_list_icon' );
					   
				if ( settings.cons == 'yes' ) { #>
					<div class="pp-review-cons">
						<# if ( settings.cons_title ) { #>
							<div class="pp-review-box-subheading pp-review-cons-title">
								{{{ settings.cons_title }}}
							</div>
						<# } #>
						<ul class="pp-review-cons-list pp-review-box-list">
							<# _.each( settings.review_cons, function( item, index ) {
							   
								var reviewConsTextKey = view.getRepeaterSettingKey( 'review_con', 'review_cons', index );
								view.addRenderAttribute( reviewConsTextKey, 'class', 'pp-cons-list-text' );
								view.addInlineEditingAttributes( reviewConsTextKey, 'none' );
								#>
								<# if ( item.review_con ) { #>
									<li class="pp-review-con">
										<# if ( settings.cons_list_icon || settings.select_cons_list_icon ) { #>
											<span class="pp-review-list-icon pp-icon">
												<# if ( consIconHTML && consIconHTML.rendered && ( ! settings.cons_list_icon || consMigrated ) ) { #>
												{{{ consIconHTML.value }}}
												<# } else { #>
													<i class="{{ settings.cons_list_icon }}" aria-hidden="true"></i>
												<# } #>
											</span>
										<# } #>
										<span {{{ view.getRenderAttributeString( reviewConsTextKey ) }}}>
											{{{ item.review_con }}}
										</span>
									</li>
								<# } #>
							<# } ); #>
						</ul>
					</div>
					<#
				}
			}

			function final_rating_template() {
				if ( settings.final_rating == 'yes' ) {
					view.addRenderAttribute( 'final-rating', 'class', 'pp-review-final-rating' );
					view.addRenderAttribute( 'final_rating_title', 'class', 'pp-review-final-rating-title' );
					view.addInlineEditingAttributes( 'final_rating_title', 'none' );

					var rating = 0;
					   
					_.each( settings.review_features, function( item, index ) {
						rating += parseFloat( item.rating );
					} );

					var items_count = settings.review_features.length;
					var avg_rating = rating / items_count;
					var rating_star_val = avg_rating / 2;
					var rating_percent_val = avg_rating * 10;
					var rating_star = rating_star_val + ' Stars';

					var final_rating_overlay_key = 'final_rating_overlay' . index;
					view.addRenderAttribute( final_rating_overlay_key, 'class', 'pp-review-overlay' );

					var stars = '';
					for ( $x = 1; $x <= 5; $x++ ) {
						stars += '<i class="fa fa-star"></i>';
					}
					view.addRenderAttribute( final_rating_overlay_key, 'class', 'pp-review-stars-overlay' );
					view.addRenderAttribute( final_rating_overlay_key, 'style', 'width:' + rating_star_val * 20 + '%' );
					#>
					<div class="pp-review-final-rating-wrap">
						<# if ( settings.final_rating_title && settings.final_rating_title_position == 'top' ) { #>
							<div {{{ view.getRenderAttributeString( 'final_rating_title' ) }}}>
								{{{ settings.final_rating_title }}}
							</div>
						<# } #>
						<# if ( settings.review_type == 'stars' ) { #>
							<div {{{ view.getRenderAttributeString( 'final-rating' ) }}}>
								<# var pp_final_rating = Math.round(rating_star_val * 100) / 100 #>
								{{{ pp_final_rating }}}
							</div>
							<span class="pp-review-stars" title="{{{ rating_star }}}">
								{{{ stars }}}
								<span {{{ view.getRenderAttributeString( final_rating_overlay_key ) }}}>
									{{{ stars }}}
								</span>
							</span>
						<# } else if ( settings.review_type == 'percent' ) { #>
							<div {{{ view.getRenderAttributeString( 'final-rating' ) }}}>
								<# var pp_final_rating = Math.round(rating_percent_val * 100) / 100 + '%' #>
								{{{ pp_final_rating }}}
							</div>
						<# } else if ( settings.review_type == 'number' ) { #>
							<div {{{ view.getRenderAttributeString( 'final-rating' ) }}}>
								<# var pp_final_rating = Math.round(avg_rating * 100) / 100 #>
								{{{ pp_final_rating }}}
							</div>
						<# } #>
						<# if ( settings.final_rating_title && settings.final_rating_title_position == 'bottom' ) { #>
							<div {{{ view.getRenderAttributeString( 'final_rating_title' ) }}}>
								{{{ settings.final_rating_title }}}
							</div>
						<# } #>
					</div>
					<#
				}
			}

			function review_summary_template() {
				view.addRenderAttribute( 'summary_title', 'class', 'pp-review-summary-title' );
				view.addInlineEditingAttributes( 'summary_title', 'none' );
				view.addRenderAttribute( 'summary_text', 'class', 'pp-review-summary-content' );
				view.addInlineEditingAttributes( 'summary_text', 'none' );

				if ( settings.summary == 'yes' || settings.final_rating == 'yes' ) { #>
					<div class="pp-review-summary">
						<# final_rating_template() #>

						<# if ( settings.summary == 'yes' && ( settings.summary_title || settings.summary_text ) ) { #>
							<div class="pp-review-summary-wrap">
								<# if ( settings.summary_title ) { #>
									<div {{{ view.getRenderAttributeString( 'summary_title' ) }}}>
										{{{ settings.summary_title }}}
									</div>
								<# } #>
								<div {{{ view.getRenderAttributeString( 'summary_text' ) }}}>
									{{{ settings.summary_text }}}
								</div>
							</div>
						<# } #>
					</div>
					<#
				}
			}

			view.addRenderAttribute( 'box_title', 'class', 'pp-review-box-title' );
			view.addInlineEditingAttributes( 'box_title', 'none' );
			view.addRenderAttribute( 'review_description', 'class', 'pp-review-box-description' );
			view.addInlineEditingAttributes( 'review_description', 'none' );
		#>

		<div class="pp-review-box-container">
			<div class="pp-review-box-overlay pp-image-overlay"></div>
			<div class="pp-review-box-inner">
				<div class="pp-review-box-header">
					<# if ( settings.show_image == 'yes' && settings.image.url ) { #>
						<div class="pp-review-box-image">
							<#
							var image = {
								id: settings.image.id,
								url: settings.image.url,
								size: settings.image_size,
								dimension: settings.image_custom_dimension,
								model: view.getEditModel()
							};
							var image_url = elementor.imagesManager.getImageUrl( image );
							#>
							<img src="{{{ image_url }}}" />
						</div>
					<# } #>

					<# if ( settings.box_title || settings.review_description ) { #>
						<div class="pp-review-box-content">
							<# if ( settings.box_title ) { #>
								<# var boxTitleHTMLTag = elementor.helpers.validateHTMLTag( settings.box_title_html_tag ); #>
								<{{{ boxTitleHTMLTag }}} {{{ view.getRenderAttributeString( 'box_title' ) }}}>
									{{{ settings.box_title }}}
								</{{{ boxTitleHTMLTag }}}>
							<# } #>
							<# if ( settings.review_description ) { #>
								<div {{{ view.getRenderAttributeString( 'review_description' ) }}}>
									{{{ settings.review_description }}}
								</div>
							<# } #>
						</div>
					<# } #>
				</div>
				<div class="pp-review-features">
					<ul class="pp-review-features-list pp-review-box-list">
						<# _.each( settings.review_features, function( item, index ) { #>
							<# if ( item.feature ) { #>
								<li class="pp-review-feature">
									<#
										var pp_review_type = settings.review_type,
											pp_rating = parseFloat( item.rating ),
											pp_rating_star_val = pp_rating / 2,
											pp_rating_percent_val = pp_rating * 10;

										var pp_rating_star = pp_rating_star_val + ' Stars';

										var overlay_key = view.getRepeaterSettingKey( 'rating_overlay', 'review_features', index );
										view.addRenderAttribute( overlay_key, 'class', 'pp-review-overlay' );

										var pp_stars = '';
										for ( x = 1; x <= 5; x++ ) {
											pp_stars += '<i class="fa fa-star"></i>';
										}
									#>
									<# if ( pp_review_type == 'stars' ) {
										view.addRenderAttribute( overlay_key, 'class', 'pp-review-stars-overlay' );
										view.addRenderAttribute( overlay_key, 'style', 'width:' + pp_rating_star_val * 20 + '%' );
										#>
										<span class="pp-review-feature-text">
											{{{ item.feature }}}
										</span>
										<span class="pp-review-stars" title="{{{ pp_rating_star }}}">
											{{{ pp_stars }}}
											<span {{{ view.getRenderAttributeString( overlay_key ) }}}>
												{{{ pp_stars }}}
											</span>
										</span>
									<# } if ( pp_review_type == 'percent' ) {
										view.addRenderAttribute( overlay_key, 'class', 'pp-review-bar-overlay pp-review-percent-overlay' );
										view.addRenderAttribute( overlay_key, 'style', 'width:calc(' + pp_rating_star_val * 20 + '% + 1.1px)' );
										#>
										<div class="pp-review-percent-bar-wrap">
											<span class="pp-rating-bar-text pp-review-feature-text">
												{{{ item.feature }}} - {{{ pp_rating_percent_val }}}%
											</span>
											<div class="pp-review-bar pp-review-percent-bar">
												<div {{{ view.getRenderAttributeString( overlay_key ) }}}></div>
											</div>
										</div>
									<# } if ( pp_review_type == 'number' ) {
										view.addRenderAttribute( overlay_key, 'class', 'pp-review-bar-overlay pp-review-percent-overlay' );
										view.addRenderAttribute( overlay_key, 'style', 'width:calc(' + pp_rating_star_val * 20 + '% + 1.1px)' );
										#>
										<div class="pp-review-number-bar-wrap">
											<span class="pp-rating-bar-text pp-review-feature-text">
												{{{ item.feature }}} - {{{ pp_rating }}}/10
											</span>
											<div class="pp-review-bar pp-review-number-bar">
												<div {{{ view.getRenderAttributeString( overlay_key ) }}}></div>
											</div>
										</div>
									<# } #>
								</li>
							<# } #>
						<# $i++; } ); #>
					</ul>
				</div>
				<# if ( settings.pros == 'yes' || settings.cons == 'yes' ) { #>
					<div class="pp-review-pros-cons">
						<#
							review_pros_template();

							review_cons_template();
						#>
					</div>
				<# } #>
				<# review_summary_template(); #>
			</div>
		</div>
		<?php
	}
}
