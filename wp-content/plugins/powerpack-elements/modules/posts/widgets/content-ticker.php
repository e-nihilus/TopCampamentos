<?php
namespace PowerpackElements\Modules\Posts\Widgets;

use PowerpackElements\Base\Powerpack_Widget;
use PowerpackElements\Modules\Posts\Widgets\Posts_Base;
use PowerpackElements\Classes\PP_Helper;
use PowerpackElements\Classes\PP_Posts_Helper;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Content Ticker Widget
 */
class Content_Ticker extends Posts_Base {

	/**
	 * Retrieve content ticker widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_name( 'Content_Ticker' );
	}

	/**
	 * Retrieve content ticker widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Content_Ticker' );
	}

	/**
	 * Retrieve content ticker widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Content_Ticker' );
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
		return parent::get_widget_keywords( 'Content_Ticker' );
	}

	protected function is_dynamic_content(): bool {
		return true;
	}

	/**
	 * Retrieve the list of scripts the content ticker widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array(
			'swiper',
			'pp-carousel',
		);
	}

	/**
	 * Get style dependencies.
	 *
	 * Retrieve the list of style dependencies the widget requires.
	 *
	 * @since 2.11.0
	 * @access public
	 *
	 * @return array Widget style dependencies.
	 */
	public function get_style_depends(): array {
		return [ 'e-swiper', 'pp-swiper', 'widget-pp-content-ticker' ];
	}

	public function has_widget_inner_wrapper(): bool {
		return ! PP_Helper::is_feature_active( 'e_optimized_markup' );
	}

	/**
	 * Register content ticker widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.0.3
	 * @access protected
	 */
	protected function register_controls() {
		/* Content Tab */
		$this->register_content_general_controls();
		$this->register_content_meta_controls();
		$this->register_content_ticker_items_controls();
		$this->register_query_section_controls( array( 'source' => 'posts' ), 'content_ticker', 'yes' );
		$this->register_content_heading_controls();
		$this->register_content_ticker_settings_controls();

		/* Style Tab */
		$this->register_style_heading_controls();
		$this->register_style_content_controls();
		$this->register_style_image_controls();
		$this->register_style_arrows_controls();
	}

	/**
	 * Register Content Ticker General Controls.
	 *
	 * @access protected
	 */
	protected function register_content_general_controls() {
		/**
		 * Content Tab: General
		 */
		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'powerpack' ),
			)
		);

		$this->add_control(
			'source',
			array(
				'label'   => esc_html__( 'Source', 'powerpack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'custom' => esc_html__( 'Custom', 'powerpack' ),
					'posts'  => esc_html__( 'Posts', 'powerpack' ),
				),
				'default' => 'posts',
			)
		);

		$this->add_control(
			'link_type',
			array(
				'label'   => esc_html__( 'Link Type', 'powerpack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'None', 'powerpack' ),
					'title' => esc_html__( 'Title', 'powerpack' ),
					'image' => esc_html__( 'Image', 'powerpack' ),
					'both'  => esc_html__( 'Title + Image', 'powerpack' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'posts_count',
			array(
				'label'     => esc_html__( 'Posts Count', 'powerpack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'condition' => array(
					'source' => 'posts',
				),
			)
		);

		$this->add_control(
			'post_image',
			array(
				'label'        => esc_html__( 'Post Image', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'show',
				'label_on'     => esc_html__( 'Show', 'powerpack' ),
				'label_off'    => esc_html__( 'Hide', 'powerpack' ),
				'return_value' => 'show',
				'condition'    => array(
					'source' => 'posts',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image_size',
				'label'     => esc_html__( 'Image Size', 'powerpack' ),
				'default'   => 'medium_large',
				'condition' => array(
					'source'     => 'posts',
					'post_image' => 'show',
				),
			)
		);

		$this->add_control(
			'title_html_tag',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'powerpack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => array(
					'h1'   => esc_html__( 'H1', 'powerpack' ),
					'h2'   => esc_html__( 'H2', 'powerpack' ),
					'h3'   => esc_html__( 'H3', 'powerpack' ),
					'h4'   => esc_html__( 'H4', 'powerpack' ),
					'h5'   => esc_html__( 'H5', 'powerpack' ),
					'h6'   => esc_html__( 'H6', 'powerpack' ),
					'div'  => esc_html__( 'div', 'powerpack' ),
					'span' => esc_html__( 'span', 'powerpack' ),
					'p'    => esc_html__( 'p', 'powerpack' ),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Ticker Post Meta Controls.
	 *
	 * @access protected
	 */
	protected function register_content_meta_controls() {
		/**
		 * Content Tab: Post Meta
		 */
		$this->start_controls_section(
			'section_post_meta',
			array(
				'label'     => esc_html__( 'Post Meta', 'powerpack' ),
				'condition' => array(
					'source' => 'posts',
				),
			)
		);

		$this->add_control(
			'post_meta',
			array(
				'label'              => esc_html__( 'Post Meta', 'powerpack' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => '',
				'label_on'           => esc_html__( 'Show', 'powerpack' ),
				'label_off'          => esc_html__( 'Hide', 'powerpack' ),
				'return_value'       => 'yes',
				'condition'          => array(
					'source' => 'posts',
				),
			)
		);

		$this->add_control(
			'post_date',
			array(
				'label'              => esc_html__( 'Date', 'powerpack' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => '',
				'label_on'           => esc_html__( 'Show', 'powerpack' ),
				'label_off'          => esc_html__( 'Hide', 'powerpack' ),
				'return_value'       => 'yes',
				'condition'          => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->add_control(
			'post_time',
			array(
				'label'              => esc_html__( 'Time', 'powerpack' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => '',
				'label_on'           => esc_html__( 'Show', 'powerpack' ),
				'label_off'          => esc_html__( 'Hide', 'powerpack' ),
				'return_value'       => 'yes',
				'condition'          => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->add_control(
			'datetime_separator',
			array(
				'label'       => esc_html__( 'Date Time Separator', 'powerpack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => 'at',
				'condition'   => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->add_control(
			'datetime_icon',
			array(
				'label'            => esc_html__( 'Date Time Icon', 'powerpack' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => false,
				'skin'             => 'inline',
				'default'          => array(
					'value'   => 'fas fa-calendar-alt',
					'library' => 'fa-solid',
				),
				'recommended'     => array(
					'fa-regular' => array(
						'calendar',
						'calendar-alt',
						'calendar-check',
						'calendar-day',
						'clock',
					),
					'fa-solid'   => array(
						'calendar',
						'calendar-alt',
						'calendar-check',
						'clock',
					),
				),
				'conditions'       => array(
					'relation' => 'and',
					'terms'    => array(
						array(
							'name'     => 'source',
							'operator' => '==',
							'value'    => 'posts',
						),
						array(
							'name'     => 'post_meta',
							'operator' => '==',
							'value'    => 'yes',
						),
						array(
							'relation' => 'or',
							'terms'    => array(
								array(
									'name'     => 'post_date',
									'operator' => '==',
									'value'    => 'yes',
								),
								array(
									'name'     => 'post_time',
									'operator' => '==',
									'value'    => 'yes',
								),
							),
						),
					),
				),
			)
		);

		$this->add_control(
			'post_author',
			array(
				'label'              => esc_html__( 'Author', 'powerpack' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'return_value'       => 'yes',
				'condition'          => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->add_control(
			'select_author_icon',
			array(
				'label'            => esc_html__( 'Author Icon', 'powerpack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'author_icon',
				'label_block'      => false,
				'skin'             => 'inline',
				'default'          => array(
					'value'   => 'fas fa-user',
					'library' => 'fa-solid',
				),
				'recommended'     => array(
					'fa-regular' => array(
						'user',
						'user-circle',
					),
					'fa-solid'   => array(
						'user',
						'user-alt',
						'user-check',
						'user-circle',
						'user-graduate',
						'user-md',
						'user-nurse',
						'user-secret',
						'user-tie',
					),
				),
				'condition'        => array(
					'source'      => 'posts',
					'post_author' => 'yes',
					'post_meta'   => 'yes',
				),
			)
		);

		$this->add_control(
			'post_category',
			array(
				'label'              => esc_html__( 'Category', 'powerpack' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'return_value'       => 'yes',
				'condition'          => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->add_control(
			'select_category_icon',
			array(
				'label'            => esc_html__( 'Category Icon', 'powerpack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'category_icon',
				'label_block'      => false,
				'skin'             => 'inline',
				'default'          => array(
					'value'   => 'fas fa-folder-open',
					'library' => 'fa-solid',
				),
				'recommended'     => array(
					'fa-regular' => array(
						'folder',
						'folder-open',
					),
					'fa-solid'   => array(
						'folder',
						'folder-open',
						'tag',
					),
				),
				'condition'        => array(
					'source'        => 'posts',
					'post_category' => 'yes',
					'post_meta'     => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Ticker Items Controls.
	 *
	 * @access protected
	 */
	protected function register_content_ticker_items_controls() {
		/**
		 * Content Tab: Ticker Items
		 */
		$this->start_controls_section(
			'section_ticker_items',
			array(
				'label'     => esc_html__( 'Ticker Items', 'powerpack' ),
				'condition' => array(
					'source' => 'custom',
				),
			)
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'ticker_items_tabs' );

		$repeater->start_controls_tab( 'tab_ticker_items_content', array( 'label' => esc_html__( 'Content', 'powerpack' ) ) );

			$repeater->add_control(
				'ticker_title',
				array(
					'label'       => esc_html__( 'Title', 'powerpack' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => false,
					'default'     => '',
				)
			);

			$repeater->add_control(
				'link',
				array(
					'label'       => esc_html__( 'Link', 'powerpack' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => array(
						'active'     => true,
						'categories' => array(
							TagsModule::POST_META_CATEGORY,
							TagsModule::URL_CATEGORY,
						),
					),
					'placeholder' => 'https://www.your-link.com',
					'default'     => array(
						'url' => '',
					),
				)
			);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'tab_ticker_items_image', array( 'label' => esc_html__( 'Image', 'powerpack' ) ) );

		$repeater->add_control(
			'ticker_image',
			array(
				'label'        => esc_html__( 'Show Image', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'powerpack' ),
				'label_off'    => esc_html__( 'No', 'powerpack' ),
				'return_value' => 'yes',
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'      => esc_html__( 'Choose Image', 'powerpack' ),
				'type'       => \Elementor\Controls_Manager::MEDIA,
				'default'    => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'ticker_image',
							'operator' => '==',
							'value'    => 'yes',
						),
					),
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'       => 'image',
				'exclude'    => array( 'custom' ),
				'include'    => array(),
				'default'    => 'large',
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'ticker_image',
							'operator' => '==',
							'value'    => 'yes',
						),
					),
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'items',
			array(
				'label'       => '',
				'type'        => Controls_Manager::REPEATER,
				'default'     => array(
					array(
						'ticker_title' => esc_html__( 'Content Ticker Item 1', 'powerpack' ),
					),
					array(
						'ticker_title' => esc_html__( 'Content Ticker Item 2', 'powerpack' ),
					),
					array(
						'ticker_title' => esc_html__( 'Content Ticker Item 3', 'powerpack' ),
					),
					array(
						'ticker_title' => esc_html__( 'Content Ticker Item 4', 'powerpack' ),
					),
				),
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ ticker_title }}}',
				'condition'   => array(
					'source' => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Ticker Heading Controls.
	 *
	 * @access protected
	 */
	protected function register_content_heading_controls() {
		/**
		 * Content Tab: Heading
		 */
		$this->start_controls_section(
			'section_heading',
			array(
				'label' => esc_html__( 'Header', 'powerpack' ),
			)
		);

		$this->add_control(
			'show_heading',
			array(
				'label'        => esc_html__( 'Show Heading', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'powerpack' ),
				'label_off'    => esc_html__( 'No', 'powerpack' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'     => esc_html__( 'Heading Text', 'powerpack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Trending Now', 'powerpack' ),
				'condition' => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->add_control(
			'selected_icon',
			array(
				'label'            => esc_html__( 'Icon', 'powerpack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'heading_icon',
				'default'          => array(
					'value'   => 'fas fa-bolt',
					'library' => 'fa-solid',
				),
				'condition'        => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->add_control(
			'heading_icon_position',
			array(
				'label'       => esc_html__( 'Icon Position', 'powerpack' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'toggle'      => false,
				'default'     => 'left',
				'options'     => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
			)
		);

		$this->add_control(
			'heading_arrow',
			array(
				'label'        => esc_html__( 'Arrow', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'powerpack' ),
				'label_off'    => esc_html__( 'No', 'powerpack' ),
				'return_value' => 'yes',
				'condition'    => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Ticker Settings Controls.
	 *
	 * @access protected
	 */
	protected function register_content_ticker_settings_controls() {
		/**
		 * Content Tab: Ticker Settings
		 */
		$this->start_controls_section(
			'section_additional_options',
			array(
				'label' => esc_html__( 'Ticker Settings', 'powerpack' ),
			)
		);

		$this->add_control(
			'ticker_effect',
			array(
				'label'       => esc_html__( 'Effect', 'powerpack' ),
				'description' => esc_html__( 'Sets transition effect', 'powerpack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'fade',
				'options'     => array(
					'slide' => esc_html__( 'Slide', 'powerpack' ),
					'fade'  => esc_html__( 'Fade', 'powerpack' ),
				),
			)
		);

		$this->add_control(
			'slider_speed',
			array(
				'label'       => esc_html__( 'Slider Speed', 'powerpack' ),
				'description' => esc_html__( 'Duration of transition between slides (in ms)', 'powerpack' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array( 'size' => 400 ),
				'range'       => array(
					'px' => array(
						'min'  => 100,
						'max'  => 3000,
						'step' => 1,
					),
				),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'              => esc_html__( 'Autoplay', 'powerpack' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'label_on'           => esc_html__( 'Yes', 'powerpack' ),
				'label_off'          => esc_html__( 'No', 'powerpack' ),
				'return_value'       => 'yes',
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'                 => esc_html__( 'Pause on Hover', 'powerpack' ),
				'description'           => '',
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => esc_html__( 'Yes', 'powerpack' ),
				'label_off'             => esc_html__( 'No', 'powerpack' ),
				'return_value'          => 'yes',
				'frontend_available'    => true,
				'condition'             => array(
					'autoplay'      => 'yes',
				),
			)
		);

		$this->add_control(
			'pause_on_interaction',
			array(
				'label'              => esc_html__( 'Pause on Interaction', 'powerpack' ),
				'description'        => esc_html__( 'Disables autoplay completely on first interaction with the carousel.', 'powerpack' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => '',
				'label_on'           => esc_html__( 'Yes', 'powerpack' ),
				'label_off'          => esc_html__( 'No', 'powerpack' ),
				'return_value'       => 'yes',
				'condition'          => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'              => esc_html__( 'Autoplay Speed', 'powerpack' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 3000,
				'min'                => 500,
				'max'                => 5000,
				'step'               => 1,
				'condition'          => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'              => esc_html__( 'Infinite Loop', 'powerpack' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'label_on'           => esc_html__( 'Yes', 'powerpack' ),
				'label_off'          => esc_html__( 'No', 'powerpack' ),
				'return_value'       => 'yes',
			)
		);

		$this->add_control(
			'grab_cursor',
			array(
				'label'              => esc_html__( 'Grab Cursor', 'powerpack' ),
				'description'        => esc_html__( 'Shows grab cursor when you hover over the slider', 'powerpack' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => '',
				'label_on'           => esc_html__( 'Yes', 'powerpack' ),
				'label_off'          => esc_html__( 'No', 'powerpack' ),
				'return_value'       => 'yes',
			)
		);

		$this->add_control(
			'navigation_heading',
			array(
				'label'     => esc_html__( 'Navigation', 'powerpack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'arrows',
			array(
				'label'        => esc_html__( 'Arrows', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'powerpack' ),
				'label_off'    => esc_html__( 'No', 'powerpack' ),
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Ticker Heading Controls in Style Tabs.
	 *
	 * @access protected
	 */
	protected function register_style_heading_controls() {
		/**
		 * Style Tab: Heading
		 */
		$this->start_controls_section(
			'section_heading_style',
			array(
				'label'     => esc_html__( 'Header', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->add_control(
			'heading_alignment',
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
				'default'   => 'left',
				'prefix_class' => 'pp-content-ticker-heading-',
			)
		);

		$this->add_responsive_control(
			'heading_padding',
			array(
				'label'      => esc_html__( 'Padding', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-content-ticker-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-content-ticker-heading' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .pp-content-ticker-heading:after' => 'border-left-color: {{VALUE}}',
				),
				'condition' => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Text Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .pp-content-ticker-heading' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pp-content-ticker-heading .pp-icon svg' => 'fill: {{VALUE}}',
				),
				'condition' => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'heading_border',
				'label'       => esc_html__( 'Border', 'powerpack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .pp-content-ticker-heading',
				'condition'   => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Typography', 'powerpack' ),
				'selector' => '{{WRAPPER}} .pp-content-ticker-heading',
			)
		);

		$this->add_responsive_control(
			'heading_width',
			array(
				'label'      => esc_html__( 'Width', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 20,
						'max'  => 500,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-content-ticker-heading' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Ticker Content Controls in Style Tabs.
	 *
	 * @access protected
	 */
	protected function register_style_content_controls() {
		/**
		 * Style Tab: Content
		 */
		$this->start_controls_section(
			'section_content_ticker_style',
			array(
				'label' => esc_html__( 'Content', 'powerpack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-content-ticker-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'content_tabs' );

		$this->start_controls_tab( 'tab_content_normal', array( 'label' => esc_html__( 'Normal', 'powerpack' ) ) );

		$this->add_control(
			'content_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-content-ticker-container' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'content_border',
				'label'       => esc_html__( 'Border', 'powerpack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .pp-content-ticker-container',
			)
		);

		$this->add_control(
			'content_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-content-ticker-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_title',
			array(
				'label'     => esc_html__( 'Title', 'powerpack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-content-ticker-item-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'powerpack' ),
				'selector' => '{{WRAPPER}} .pp-content-ticker-item-title',
			)
		);

		$this->add_responsive_control(
			'title_margin_bottom',
			array(
				'label'      => esc_html__( 'Bottom Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-content-ticker-item-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_meta',
			array(
				'label'     => esc_html__( 'Post Meta', 'powerpack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Text Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-content-ticker-meta' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pp-content-ticker-meta .pp-icon svg' => 'fill: {{VALUE}}',
				),
				'condition' => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'meta_typography',
				'label'     => esc_html__( 'Typography', 'powerpack' ),
				'selector'  => '{{WRAPPER}} .pp-content-ticker-meta',
				'condition' => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->add_control(
			'meta_items_spacing',
			array(
				'label'      => esc_html__( 'Items Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'default'    => array(
					'size' => '',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-content-ticker-meta > span:not(:last-child)' => 'margin-right: {{SIZE}}px;',
				),
				'condition'  => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_content_hover', array( 'label' => esc_html__( 'Hover', 'powerpack' ) ) );

		$this->add_control(
			'content_bg_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-content-ticker-container:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'content_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-content-ticker-container:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'content_title_color_hover',
			array(
				'label'     => esc_html__( 'Title Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-content-ticker-item-title:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_color_hover',
			array(
				'label'     => esc_html__( 'Post Meta Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-content-ticker-meta > span:hover' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'source'    => 'posts',
					'post_meta' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Content Ticker Image Controls in Style Tabs.
	 *
	 * @access protected
	 */
	protected function register_style_image_controls() {
		/**
		 * Style Tab: Image
		 */
		$this->start_controls_section(
			'section_image_style',
			array(
				'label' => esc_html__( 'Image', 'powerpack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border', 'powerpack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .pp-content-ticker-image',
			)
		);

		$this->add_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-content-ticker-image, {{WRAPPER}} .pp-content-ticker-image:after, {{WRAPPER}} .pp-content-ticker-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => esc_html__( 'Width', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-content-ticker-image' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_margin',
			array(
				'label'       => esc_html__( 'Margin', 'powerpack' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', 'em', 'rem', 'custom' ),
				'placeholder' => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				),
				'selectors'   => array(
					'{{WRAPPER}} .pp-content-ticker-image' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Ticker Arrows Controls in Style Tabs.
	 *
	 * @access protected
	 */
	protected function register_style_arrows_controls() {
		/**
		 * Style Tab: Arrows
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_arrows_style',
			array(
				'label'     => esc_html__( 'Arrows', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'arrows' => 'yes',
				),
			)
		);

		$this->add_control(
			'select_arrow',
			array(
				'label'                  => esc_html__( 'Choose Arrow', 'powerpack' ),
				'type'                   => Controls_Manager::ICONS,
				'fa4compatibility'       => 'arrow',
				'label_block'            => false,
				'default'                => array(
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				),
				'skin'                   => 'inline',
				'exclude_inline_options' => 'svg',
				'recommended'            => array(
					'fa-regular' => array(
						'arrow-alt-circle-right',
						'caret-square-right',
						'hand-point-right',
					),
					'fa-solid'   => array(
						'angle-right',
						'angle-double-right',
						'chevron-right',
						'chevron-circle-right',
						'arrow-right',
						'long-arrow-alt-right',
						'caret-right',
						'caret-square-right',
						'arrow-circle-right',
						'arrow-alt-circle-right',
						'toggle-right',
						'hand-point-right',
					),
				),
			)
		);

		$this->add_responsive_control(
			'arrows_size',
			array(
				'label'      => esc_html__( 'Arrows Size', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'default'    => array( 'size' => '22' ),
				'range'      => array(
					'px' => array(
						'min'  => 15,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_arrows_normal',
			array(
				'label' => esc_html__( 'Normal', 'powerpack' ),
			)
		);

		$this->add_control(
			'arrows_bg_color_normal',
			array(
				'label'     => esc_html__( 'Background Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-swiper-button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrows_color_normal',
			array(
				'label'     => esc_html__( 'Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .elementor-swiper-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-swiper-button svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'arrows_border_normal',
				'label'       => esc_html__( 'Border', 'powerpack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .elementor-swiper-button',
			)
		);

		$this->add_control(
			'arrows_border_radius_normal',
			array(
				'label'      => esc_html__( 'Border Radius', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-swiper-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrows_hover',
			array(
				'label' => esc_html__( 'Hover', 'powerpack' ),
			)
		);

		$this->add_control(
			'arrows_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-swiper-button:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrows_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-swiper-button:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrows_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-swiper-button:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'arrows_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'default'    => array( 'size' => '' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-swiper-button-prev' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'arrows_padding',
			array(
				'label'      => esc_html__( 'Padding', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-swiper-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Slider Settings.
	 *
	 * @access public
	 */
	public function slider_settings() {
		$settings = $this->get_settings();

		$slider_options = array(
			'direction'       => 'horizontal',
			'speed'           => ( $settings['slider_speed']['size'] ) ? $settings['slider_speed']['size'] : 400,
			'effect'          => ( $settings['ticker_effect'] ) ? $settings['ticker_effect'] : 'fade',
			'slides_per_view' => 1,
			'auto_height'     => false,
			'loop'            => ( 'yes' === $settings['loop'] ) ? 'yes' : '',
		);

		if ( 'yes' === $settings['grab_cursor'] ) {
			$slider_options['grab_cursor'] = true;
		}

		if ( 'yes' === $settings['autoplay'] ) {
			$autoplay_speed = 999999;
			$slider_options['autoplay'] = 'yes';

			if ( ! empty( $settings['autoplay_speed'] ) ) {
				$autoplay_speed = $settings['autoplay_speed'];
			}

			$slider_options['autoplay_speed'] = $autoplay_speed;
			$slider_options['pause_on_interaction'] = ( 'yes' === $settings['pause_on_interaction'] ) ? 'yes' : '';
		}

		if ( 'yes' === $settings['arrows'] ) {
			$slider_options['show_arrows'] = true;
		}

		$this->add_render_attribute(
			'content-ticker',
			array(
				'data-slider-settings' => wp_json_encode( $slider_options ),
			)
		);
	}

	/**
	 * Render content ticker widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute( 'content-ticker-container', 'class', 'pp-content-ticker-container' );

		if ( 'yes' === $settings['show_heading'] && 'yes' === $settings['heading_arrow'] ) {
			$this->add_render_attribute( 'content-ticker-container', 'class', 'pp-content-ticker-heading-arrow' );
		}

		$this->add_render_attribute( 'content-ticker', 'class', array( 'pp-content-ticker', 'pp-swiper-slider' ) );

		$this->slider_settings();

		$this->add_render_attribute( 'content-ticker-wrap', 'class', [
			'pp-content-ticker-wrap',
			'swiper-container-wrap',
			//'swiper'
		] );

		if ( ! isset( $settings['heading_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default.
			$settings['heading_icon'] = 'fa fa-bolt';
		}

		$has_icon = ! empty( $settings['heading_icon'] );

		if ( $has_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['heading_icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		if ( ! $has_icon && ! empty( $settings['selected_icon']['value'] ) ) {
			$has_icon = true;
		}
		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new   = ! isset( $settings['heading_icon'] ) && Icons_Manager::is_migration_allowed();
		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-ticker-container' ) ); ?>>
			<?php if ( 'yes' === $settings['show_heading'] && $settings['heading'] ) { ?>
				<div class="pp-content-ticker-heading">
					<?php if ( $has_icon ) { ?>
						<?php
							$this->add_render_attribute(
								'heading-icon',
								'class',
								array(
									'pp-content-ticker-heading-icon',
									'pp-icon',
								)
							);

						if ( 'right' === $settings['heading_icon_position'] ) {
							$this->add_render_attribute( 'heading-icon', 'class', 'pp-content-ticker-heading-icon-' . $settings['heading_icon_position'] );
						}
						?>
						<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'heading-icon' ) ); ?>>
							<?php
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $settings['selected_icon'], array( 'aria-hidden' => 'true' ) );
							} elseif ( ! empty( $settings['heading_icon'] ) ) {
								?>
								<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i>
								<?php
							}
							?>
						</span>
					<?php } ?>
					<span class="pp-content-ticker-heading-text">
						<?php echo wp_kses_post( $settings['heading'] ); ?>
					</span>
				</div>
			<?php } ?>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-ticker-wrap' ) ); ?>>
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-ticker' ) ); ?>>
					<div class="swiper-wrapper">
						<?php
						if ( 'posts' === $settings['source'] ) {
							$this->render_source_posts();
						} elseif ( 'custom' === $settings['source'] ) {
							$this->render_source_custom();
						}
						?>
					</div>
				</div>
			</div>
			<div class="pp-content-ticker-navigation">
				<?php
					$this->render_arrows();
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render content ticker arrows output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_arrows() {
		$settings = $this->get_settings_for_display();

		$migration_allowed = Icons_Manager::is_migration_allowed();

		if ( ! isset( $settings['arrow'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default.
			$settings['arrow'] = 'fa fa-angle-right';
		}

		$has_icon = ! empty( $settings['arrow'] );

		if ( ! $has_icon && ! empty( $settings['select_arrow']['value'] ) ) {
			$has_icon = true;
		}

		if ( ! empty( $settings['arrow'] ) ) {
			$this->add_render_attribute( 'arrow-icon', 'class', $settings['arrow'] );
			$this->add_render_attribute( 'arrow-icon', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['select_arrow'] );
		$is_new = ! isset( $settings['arrow'] ) && $migration_allowed;

		if ( 'yes' === $settings['arrows'] ) {
			?>
			<?php
			if ( $has_icon ) {
				if ( $is_new || $migrated ) {
					$next_arrow = $settings['select_arrow'];
					$prev_arrow = str_replace( 'right', 'left', $settings['select_arrow'] );
				} else {
					$pa_next_arrow = $settings['arrow'];
					$pa_prev_arrow = str_replace( 'right', 'left', $settings['arrow'] );
				}
			} else {
				$pa_next_arrow = 'fa fa-angle-right';
				$pa_prev_arrow = 'fa fa-angle-left';
			}

			if ( ! empty( $settings['arrow'] ) || ( ! empty( $settings['select_arrow']['value'] ) && $is_new ) ) { ?>
				<div class="pp-slider-arrow elementor-icon elementor-swiper-button elementor-swiper-button-prev swiper-button-prev-<?php echo esc_attr( $this->get_id() ); ?>">
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $prev_arrow, [ 'aria-hidden' => 'true' ] );
					else : ?>
						<i <?php $this->print_render_attribute_string( 'arrow-icon' ); ?>></i>
					<?php endif; ?>
				</div>
				<div class="pp-slider-arrow elementor-icon elementor-swiper-button elementor-swiper-button-next swiper-button-next-<?php echo esc_attr( $this->get_id() ); ?>">
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $next_arrow, [ 'aria-hidden' => 'true' ] );
					else : ?>
						<i <?php $this->print_render_attribute_string( 'arrow-icon' ); ?>></i>
					<?php endif; ?>
				</div>
			<?php }
		}
	}

	/**
	 * Render custom content output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_source_custom() {
		$settings = $this->get_settings();

		$i = 1;

		foreach ( $settings['items'] as $index => $item ) {

			$item_key  = $this->get_repeater_setting_key( 'item', 'items', $index );
			$title_key = $this->get_repeater_setting_key( 'ticker_title', 'items', $index );
			$link_key  = $this->get_repeater_setting_key( 'link', 'items', $index );

			$this->add_render_attribute(
				$item_key,
				'class',
				array(
					'pp-content-ticker-item',
					'swiper-slide',
					'elementor-repeater-item-' . esc_attr( $item['_id'] ),
				)
			);

			$this->add_render_attribute( $title_key, 'class', 'pp-content-ticker-item-title' );

			if ( '' !== $settings['link_type'] && $item['link']['url'] ) {
				$this->add_link_attributes( $link_key, $item['link'] );
			}
			?>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( $item_key ) ); ?>>
				<div class="pp-content-ticker-content">
					<?php if ( 'yes' === $item['ticker_image'] && ! empty( $item['image']['url'] ) ) { ?>
						<div class="pp-content-ticker-image">
							<?php
							if ( ( 'image' === $settings['link_type'] || 'both' === $settings['link_type'] ) && $item['link']['url'] ) {
								printf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( $link_key ), wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $item ) ) );
							} else {
								echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $item ) );
							}
							?>
						</div>
					<?php } ?>
					<?php
					if ( $item['ticker_title'] ) {
						printf( '<%1$s %2$s>', wp_kses_post( $settings['title_html_tag'] ), wp_kses_post( $this->get_render_attribute_string( $title_key ) ) );
						if ( ( 'title' === $settings['link_type'] || 'both' === $settings['link_type'] ) && $item['link']['url'] ) {
							printf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( $link_key ), wp_kses_post( $item['ticker_title'] ) );
						} else {
							echo wp_kses_post( $item['ticker_title'] );
						}
						printf( '</%s>', wp_kses_post( $settings['title_html_tag'] ) );
					}
					?>
				</div>
			</div>
			<?php
			$i++;
		}
	}

	/**
	 * Render posts output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_source_posts() {
		$settings = $this->get_settings();

		$i = 1;

		// Author Icon.
		if ( ! isset( $settings['author_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default.
			$settings['author_icon'] = 'fa fa-user';
		}

		$has_author_icon = ! empty( $settings['author_icon'] );

		if ( $has_author_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['author_icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		if ( ! $has_author_icon && ! empty( $settings['select_author_icon']['value'] ) ) {
			$has_author_icon = true;
		}
		$migrated_author_icon = isset( $settings['__fa4_migrated']['select_author_icon'] );
		$is_new_author_icon   = ! isset( $settings['author_icon'] ) && Icons_Manager::is_migration_allowed();

		// Category Icon.
		if ( ! isset( $settings['category_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default.
			$settings['category_icon'] = 'fa fa-folder-open';
		}

		$has_category_icon = ! empty( $settings['category_icon'] );

		if ( $has_category_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['category_icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		if ( ! $has_category_icon && ! empty( $settings['select_category_icon']['value'] ) ) {
			$has_category_icon = true;
		}
		$migrated_category_icon = isset( $settings['__fa4_migrated']['select_category_icon'] );
		$is_new_category_icon   = ! isset( $settings['category_icon'] ) && Icons_Manager::is_migration_allowed();

		// Query Arguments.
		/* $args        = $this->query_posts_args( '', '', '', '', '', 'content_ticker', 'yes', 'posts_count' );
		$posts_query = new \WP_Query( $args ); */
		$posts_count = $settings['posts_count'];
		$this->query_posts( '', '', '', '', '', 'content_ticker', 'yes', '', $posts_count );
		$posts_query = $this->get_query();

		if ( $posts_query->have_posts() ) :
			while ( $posts_query->have_posts() ) :
				$posts_query->the_post();

				$item_key = 'content-ticker-item' . $i;
				$post_type_name = $settings['post_type'];

				if ( has_post_thumbnail() || 'attachment' === $post_type_name ) {

					if ( 'attachment' === $post_type_name ) {
						$image_id = get_the_ID();
					} else {
						$image_id = get_post_thumbnail_id( get_the_ID() );
					}

					$pp_thumb_url = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image_size', $settings );
					$image_alt    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				} else {
					$pp_thumb_url = '';
					$image_alt    = '';
				}

				$this->add_render_attribute(
					$item_key,
					'class',
					array(
						'pp-content-ticker-item',
						'swiper-slide',
						'pp-content-ticker-item-' . intval( $i ),
					)
				);
				?>
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( $item_key ) ); ?>>
					<div class="pp-content-ticker-content">
						<?php if ( 'show' === $settings['post_image'] && $pp_thumb_url ) { ?>
							<div class="pp-content-ticker-image">
								<?php
								if ( 'image' === $settings['link_type'] || 'both' === $settings['link_type'] ) {
									printf( '<a href="%1$s">%2$s</a>', esc_url( get_permalink() ), '<img src="' . esc_url( $pp_thumb_url ) . '" alt="' . esc_attr( $image_alt ) . '">' );
								} else {
									echo '<img src="' . esc_url( $pp_thumb_url ) . '" alt="' . esc_attr( $image_alt ) . '">';
								}
								?>
							</div>
						<?php } ?>
						<div class="pp-content-ticker-item-title-wrap">
							<?php
							printf( '<%s class="pp-content-ticker-item-title">', wp_kses_post( $settings['title_html_tag'] ) );
							if ( 'title' === $settings['link_type'] || 'both' === $settings['link_type'] ) {
								printf( '<a href="%1$s">%2$s</a>', esc_url( get_permalink() ), wp_kses_post( get_the_title() ) );
							} else {
								the_title();
							}
							printf( '</%s>', wp_kses_post( $settings['title_html_tag'] ) );
							if ( 'yes' === $settings['post_meta'] ) { ?>
								<div class="pp-content-ticker-meta">
									<?php if ( 'yes' === $settings['post_date'] || 'yes' === $settings['post_time'] ) { ?>
										<span class="pp-content-ticker-item-datetime">
											<?php if ( ! empty( $settings['datetime_icon']['value'] ) ) { ?>
												<span class="pp-content-ticker-meta-icon pp-icon">
													<?php Icons_Manager::render_icon( $settings['datetime_icon'], array( 'aria-hidden' => 'true' ) ); ?>
												</span>
											<?php } ?>
											<?php
											if ( 'yes' === $settings['post_date'] ) {
												the_date();
											}
											if ( 'yes' === $settings['post_time'] ) {
												echo ' ' . wp_kses_post( $settings['datetime_separator'] ) . ' ';
												the_time();
											}
											?>
										</span>
									<?php } ?>
									<?php if ( 'yes' === $settings['post_author'] ) { ?>
										<span class="pp-content-author">
											<?php if ( $has_author_icon ) { ?>
												<span class="pp-content-ticker-meta-icon pp-icon">
													<?php
													if ( $is_new_author_icon || $migrated_author_icon ) {
														Icons_Manager::render_icon( $settings['select_author_icon'], array( 'aria-hidden' => 'true' ) );
													} elseif ( ! empty( $settings['author_icon'] ) ) {
														?>
														<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i>
														<?php
													}
													?>
												</span>
											<?php } ?>
											<span class="pp-content-ticker-meta-text">
												<?php echo get_the_author(); ?>
											</span>
										</span>
									<?php } ?>  
									<?php if ( 'yes' === $settings['post_category'] ) { ?>
										<span class="pp-post-category">
												<?php if ( $has_category_icon ) { ?>
												<span class="pp-content-ticker-meta-icon pp-icon">
													<?php
													if ( $is_new_author_icon || $migrated_author_icon ) {
														Icons_Manager::render_icon( $settings['select_category_icon'], array( 'aria-hidden' => 'true' ) );
													} elseif ( ! empty( $settings['category_icon'] ) ) {
														?>
														<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i>
														<?php
													}
													?>
												</span>
											<?php } ?>
											<span class="pp-content-ticker-meta-text">
												<?php
												$category = get_the_category();
												if ( $category ) {
													echo esc_attr( $category[0]->name );
												}
												?>
											</span>
										</span>
									<?php } ?>  
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php
				$i++;
			endwhile;
		endif;
		wp_reset_postdata();
	}
}
