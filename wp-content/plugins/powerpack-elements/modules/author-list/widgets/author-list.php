<?php
namespace PowerpackElements\Modules\AuthorList\Widgets;

use PowerpackElements\Base\Powerpack_Widget;
use PowerpackElements\Classes\PP_Helper;
use PowerpackElements\Classes\PP_Posts_Helper;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Business Hours Widget
 */
class Author_List extends Powerpack_Widget {

	/**
	 * Retrieve Business Hours widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_name( 'Author_List' );
	}

	/**
	 * Retrieve Business Hours widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Author_List' );
	}

	/**
	 * Retrieve Business Hours widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Author_List' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Business Hours widget belongs to.
	 *
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Author_List' );
	}

	protected function is_dynamic_content(): bool {
		return true;
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
		return [ 'widget-pp-author-list' ];
	}

	public function has_widget_inner_wrapper(): bool {
		return ! PP_Helper::is_feature_active( 'e_optimized_markup' );
	}

	/**
	 * Register Business Hours widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function register_controls() {

		/* Content Tab */
		$this->register_general_controls();
		$this->register_layout_controls();

		/* Style Tab */
		$this->register_style_layout_controls();
		$this->register_style_items_controls();
		$this->register_style_avatar_controls();
		$this->register_style_naame_controls();
		$this->register_style_posts_count_controls();
		$this->register_style_role_controls();
		$this->register_style_email_controls();
		$this->register_style_author_description_controls();

	}

	/*-----------------------------------------------------------------------------------*/
	/*	CONTENT TAB
	/*-----------------------------------------------------------------------------------*/
	protected function register_general_controls() {
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'powerpack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'select_authors_by',
			[
				'label'   => esc_html__( 'Source', 'powerpack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'custom' => esc_html__( 'Custom Query', 'powerpack' ),
					'manual' => esc_html__( 'Manual Selection', 'powerpack' ),
				],
				'default' => 'custom',
			]
		);

		$wp_roles = wp_roles();
		$all_roles = $wp_roles->role_names;

		$this->start_controls_tabs( 'users_query_tabs',
			[
				'condition'   => [
					'select_authors_by' => 'custom',
				],
			]
		);

			$this->start_controls_tab(
				'users_query_include',
				[
					'label'     => esc_html__( 'Include', 'powerpack' ),
					'condition' => [
						'select_authors_by' => 'custom',
					],
				]
			);

				$this->add_control(
					'include_roles',
					[
						'label'       => esc_html__( 'Include Roles', 'powerpack' ),
						'type'        => Controls_Manager::SELECT2,
						'options'     => $all_roles,
						'default'     => [],
						'label_block' => true,
						'multiple'    => true,
						'condition'   => [
							'select_authors_by' => 'custom',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'users_query_exclude',
				[
					'label'     => esc_html__( 'Exclude', 'powerpack' ),
					'condition' => [
						'select_authors_by' => 'custom',
					],
				]
			);

				$this->add_control(
					'exclude_roles',
					[
						'label'       => esc_html__( 'Exclude Roles', 'powerpack' ),
						'type'        => Controls_Manager::SELECT2,
						'options'     => $all_roles,
						'default'     => [],
						'label_block' => true,
						'multiple'    => true,
						'condition'   => [
							'select_authors_by' => 'custom',
						],
					]
				);

				$this->add_control(
					'exclude_users',
					[
						'label'       => esc_html__( 'Exclude Users', 'powerpack' ),
						'type'         => 'pp-query',
						'options'      => array(),
						'default'      => [],
						'label_block'  => true,
						'multiple'     => true,
						'query_type'   => 'users',
						'object_type'  => '',
						'condition'    => [
							'select_authors_by' => 'custom',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'select_users',
			[
				'label'        => esc_html__( 'Select Users', 'powerpack' ),
				'type'         => 'pp-query',
				'options'      => array(),
				'default'      => [],
				'label_block'  => true,
				'multiple'     => true,
				'query_type'   => 'users',
				'object_type'  => '',
				'condition'    => [
					'select_authors_by' => 'manual',
				],
			]
		);

		$this->add_control(
			'users_per_page',
			array(
				'label'     => esc_html__( 'Number of Users', 'powerpack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 10,
				'separator' => 'before',
				'condition' => [
					'select_authors_by' => 'custom',
				],
			)
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'powerpack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'default'      => esc_html__( 'Default', 'powerpack' ),
					'ID'           => esc_html__( 'User ID', 'powerpack' ),
					'display_name' => esc_html__( 'Display Name', 'powerpack' ),
					'name'         => esc_html__( 'Username', 'powerpack' ),
					'login'        => esc_html__( 'User Login', 'powerpack' ),
					'nicename'     => esc_html__( 'Nice Name', 'powerpack' ),
					'email'        => esc_html__( 'Email', 'powerpack' ),
					'url'          => esc_html__( 'User Url', 'powerpack' ),
					'registered'   => esc_html__( 'Registered Date', 'powerpack' ),
					'post_count'   => esc_html__( 'Number of Posts', 'powerpack' ),
				],
				'default'   => 'name',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'powerpack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'DESC' => esc_html__( 'Descending', 'powerpack' ),
					'ASC'  => esc_html__( 'Ascending', 'powerpack' ),
				],
				'default' => 'ASC',
			]
		);

		$this->end_controls_section();
	}

	protected function register_layout_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'powerpack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'        => esc_html__( 'Layout', 'powerpack' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'list' => esc_html__( 'List', 'powerpack' ),
					'grid' => esc_html__( 'Grid', 'powerpack' ),
				],
				'default'      => 'list',
				'prefix_class' => 'pp-author-list-layout-',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'          => esc_html__( 'Columns', 'powerpack' ),
				'type'           => Controls_Manager::SELECT,
				'label_block'    => false,
				'default'        => '2',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'1' => esc_html__( '1', 'powerpack' ),
					'2' => esc_html__( '2', 'powerpack' ),
					'3' => esc_html__( '3', 'powerpack' ),
					'4' => esc_html__( '4', 'powerpack' ),
					'5' => esc_html__( '5', 'powerpack' ),
					'6' => esc_html__( '6', 'powerpack' ),
					'7' => esc_html__( '7', 'powerpack' ),
					'8' => esc_html__( '8', 'powerpack' ),
				),
				'prefix_class'   => 'elementor-grid%s-',
				'selectors'      => array(
					'{{WRAPPER}}.pp-author-list-layout-grid .pp-autor-list-wrapper' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
				),
				'condition'      => array(
					'layout' => 'grid',
				),
			)
		);

		$this->add_control(
			'elements_layout',
			array(
				'label'                => esc_html__( 'Elements Position', 'powerpack' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'inline',
				'options'              => array(
					'inline'  => esc_html__( 'Inline', 'powerpack' ),
					'stacked' => esc_html__( 'Stacked', 'powerpack' ),
				),
				'prefix_class'         => 'pp-author-list-elements-align-',
				'selectors_dictionary' => [
					'inline'  => 'flex-direction: row',
					'stacked' => 'flex-direction: column',
				],
				'selectors'            => [
					'{{WRAPPER}} .pp-author-list-item' => '{{VALUE}};',
				],
			)
		);

		$this->add_control(
			'link_type',
			array(
				'label'                => esc_html__( 'Link Type', 'powerpack' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'box',
				'options'              => array(
					'none'   => esc_html__( 'None', 'powerpack' ),
					'box'    => esc_html__( 'Box', 'powerpack' ),
					'name'   => esc_html__( 'Name', 'powerpack' ),
					'avatar' => esc_html__( 'Avatar', 'powerpack' ),
				),
			)
		);

		$this->add_control(
			'link_to',
			array(
				'label'                => esc_html__( 'Link To', 'powerpack' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'author_archive',
				'options'              => array(
					'author_archive' => esc_html__( 'Author Posts Page', 'powerpack' ),
					'author_website' => esc_html__( 'Author Website', 'powerpack' ),
				),
				'condition' => [
					'link_type!' => 'none',
				],
			)
		);

		$this->add_control(
			'list_alignment',
			[
				'label'       => esc_html__( 'Alignment', 'powerpack' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default'     => 'center',
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'powerpack' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'powerpack' ),
						'icon' => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'powerpack' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'pp-author-alignment-',
				'condition'    => array(
					'elements_layout' => 'stacked',
				),
			]
		);

		$this->add_control(
			'author_name_heading_content',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Author Name', 'powerpack' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'author_name',
			[
				'label'   => esc_html__( 'Name', 'powerpack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'display_name'  => esc_html__( 'Display Name', 'powerpack' ),
					'first_name'    => esc_html__( 'First Name', 'powerpack' ),
					'last_name'     => esc_html__( 'Last Name', 'powerpack' ),
					'nickname'      => esc_html__( 'Nick Name', 'powerpack' ),
					'user_nicename' => esc_html__( 'User Nice Name', 'powerpack' ),
				],
				'default' => 'display_name',
			]
		);

		$this->add_control(
			'avatar_content_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Avatar', 'powerpack' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'avatar_type',
			array(
				'label'                => esc_html__( 'Avatar Type', 'powerpack' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'gravatar',
				'options'              => array(
					'gravatar' => esc_html__( 'Gravatar', 'powerpack' ),
					'icon'     => esc_html__( 'Icon', 'powerpack' ),
				),
			)
		);

		$this->add_control(
			'author_avatar_size',
			[
				'label'     => esc_html__( 'Avatar Size', 'powerpack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'xs' => esc_html__( 'Extra Small', 'powerpack' ),
					'sm' => esc_html__( 'Small', 'powerpack' ),
					'md' => esc_html__( 'Medium', 'powerpack' ),
					'lg' => esc_html__( 'Large', 'powerpack' ),
					'xl' => esc_html__( 'Extra Large', 'powerpack' ),
				],
				'default'   => 'sm',
				'condition' => [
					'avatar_type' => 'gravatar',
				],
			]
		);

		$this->add_control(
			'author_icon',
			array(
				'label'            => esc_html__( 'Author Icon', 'powerpack' ),
				'type'             => Controls_Manager::ICONS,
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
				'condition' => [
					'avatar_type' => 'icon',
				],
			)
		);

		$this->add_control(
			'post_count_heading_content',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Post Count', 'powerpack' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'author_post_count',
			[
				'label'        => esc_html__( 'Show Post Count', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'powerpack' ),
				'label_off'    => esc_html__( 'No', 'powerpack' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'author_post_count_text',
			[
				'label'       => esc_html__( 'Post Count Text', 'powerpack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => esc_html__( 'Post Count ', 'powerpack' ),
				'placeholder' => esc_html__( 'Post Count Text', 'powerpack' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'author_post_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'       => esc_html__( 'Post Type', 'powerpack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => PP_Posts_Helper::get_post_types(),
				'default'     => 'post',
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'author_post_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'author_role_heading_content',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Role', 'powerpack' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'author_role',
			[
				'label'        => esc_html__( 'Show Role', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'powerpack' ),
				'label_off'    => esc_html__( 'No', 'powerpack' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'author_email_heading_content',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Email', 'powerpack' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'author_email',
			[
				'label'        => esc_html__( 'Show Email', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'powerpack' ),
				'label_off'    => esc_html__( 'No', 'powerpack' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'author_description_heading_content',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Author Bio', 'powerpack' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'author_description',
			[
				'label'        => esc_html__( 'Show Author Bio', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'powerpack' ),
				'label_off'    => esc_html__( 'No', 'powerpack' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	STYLE TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_style_layout_controls() {
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'Layout', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			array(
				'label'       => esc_html__( 'Columns Gap', 'powerpack' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', 'em', 'rem', 'custom' ],
				'default'     => array(
					'size' => 20,
				),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'layout' => 'grid',
				),
			)
		);

		$this->add_responsive_control(
			'row_gap',
			array(
				'label'      => esc_html__( 'Rows Gap', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default'    => array(
					'size' => 20,
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.pp-author-list-layout-list .pp-author-list-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Items
	 */
	protected function register_style_items_controls() {
		$this->start_controls_section(
			'section_items_style',
			array(
				'label'     => esc_html__( 'Items', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'items_tabs_style' );

		$this->start_controls_tab(
			'items_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'powerpack' ),
			)
		);

		$this->add_control(
			'items_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-author-list-item' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'items_border',
				'label'       => esc_html__( 'Border', 'powerpack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .pp-author-list-item',
			)
		);

		$this->add_control(
			'items_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-author-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'items_box_shadow',
				'selector' => '{{WRAPPER}} .pp-author-list-item',
			)
		);

		$this->add_control(
			'items_padding',
			array(
				'label'      => esc_html__( 'Padding', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-author-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'items_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'powerpack' ),
			)
		);

		$this->add_control(
			'items_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-author-list-item:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'items_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-author-list-item:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'items_box_shadow_hover',
				'selector' => '{{WRAPPER}} .pp-author-list-item:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_avatar_controls() {
		$this->start_controls_section(
			'section_avatar_style',
			[
				'label' => esc_html__( 'Avatar', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'avatar_vertical_align',
			[
				'label'                => esc_html__( 'Vertical Align', 'powerpack' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'middle',
				'options'              => [
					'top'    => esc_html__( 'Top', 'powerpack' ),
					'middle' => esc_html__( 'Middle', 'powerpack' ),
					'bottom' => esc_html__( 'Bottom', 'powerpack' ),
				],
				'selectors_dictionary' => [
					'top'    => 'align-self: flex-start',
					'middle' => 'align-self: center',
					'bottom' => 'align-self: flex-end',
				],
				'selectors'            => [
					'{{WRAPPER}} .pp-author-list-avatar' => '{{VALUE}};',
				],
				'condition'            => [
					'elements_layout' => 'inline',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_size',
			[
				'label'      => esc_html__( 'Size', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range'      => [
					'px'    => [
						'min' => 20,
						'max' => 200,
					],
				],
				'default'    => [
					'size'  => 50,
				],
				'selectors'  => [
					'{{WRAPPER}} .pp-author-list-avatar img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'avatar_type' => 'gravatar',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'powerpack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => [
					'{{WRAPPER}} .pp-author-list-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'avatar_type' => 'gravatar',
				],
			]
		);

		$this->add_control(
			'avatar_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .pp-author-list-avatar i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pp-author-list-avatar svg' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'avatar_type' => 'icon',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'avatar_box_shadow',
				'exclude'   => [
					'box_shadow_position',
				],
				'selector'  => '{{WRAPPER}} .pp-author-list-avatar img, {{WRAPPER}} .pp-author-list-avatar i',
				'condition' => [
					'avatar_type' => 'gravatar',
				],
			]
		);

		$this->add_control(
			'avatar_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pp-author-list-avatar i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pp-author-list-avatar svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'avatar_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'avatar_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Hover Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pp-author-list-avatar i:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pp-author-list-avatar:hover svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'avatar_type' => 'icon',
					'link_type' => 'name',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vw', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pp-author-list-avatar' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_naame_controls() {
		$this->start_controls_section(
			'section_name_style',
			[
				'label' => esc_html__( 'Name', 'powerpack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => esc_html__( 'Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pp-author-list-name-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pp-author-list-name-text a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'name_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pp-author-list-name-text a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'link_type' => 'name',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'label'    => esc_html__( 'Typography', 'powerpack' ),
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .pp-author-list-name-text, {{WRAPPER}} .pp-author-list-name-text a',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'name_text_shadow',
				'selector' => '{{WRAPPER}} .pp-author-list-name',
			]
		);

		$this->add_responsive_control(
			'name_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pp-author-list-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_posts_count_controls() {
		$this->start_controls_section(
			'section_posts_count_style',
			[
				'label'     => esc_html__( 'Posts Count', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'author_post_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'post_count_color',
			[
				'label'     => esc_html__( 'Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pp-author-list-post-count' => 'color: {{VALUE}};',
				],
				'condition' => [
					'author_post_count' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'post_count_typography',
				'label'     => esc_html__( 'Typography', 'powerpack' ),
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} .pp-author-list-post-count',
				'condition' => [
					'author_post_count' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'post_count_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pp-author-list-post-count' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'author_post_count' => 'yes',
					'elements_layout'   => 'stacked',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_role_controls() {
		$this->start_controls_section(
			'section_role_style',
			[
				'label'     => esc_html__( 'Role', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'author_role' => 'yes',
				],
			]
		);

		$this->add_control(
			'role_color',
			[
				'label'     => esc_html__( 'Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pp-author-list-role' => 'color: {{VALUE}};',
				],
				'condition' => [
					'author_role' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'role_typography',
				'label'     => esc_html__( 'Typography', 'powerpack' ),
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'exclude'   => [
					'line_height',
				],
				'selector'  => '{{WRAPPER}} .pp-author-list-role',
				'condition' => [
					'author_role' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'role_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pp-author-list-role' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'author_role' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_email_controls() {
		$this->start_controls_section(
			'section_email_style',
			[
				'label'     => esc_html__( 'Email', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'author_email' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_color',
			[
				'label'     => esc_html__( 'Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pp-author-list-email' => 'color: {{VALUE}};',
				],
				'condition' => [
					'author_email' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'email_typography',
				'label'    => esc_html__( 'Typography', 'powerpack' ),
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .pp-author-list-email',
			]
		);

		$this->add_responsive_control(
			'email_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'powerpack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pp-author-list-email' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'author_email' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_author_description_controls() {
		$this->start_controls_section(
			'section_author_description_style',
			[
				'label'     => esc_html__( 'Author Description', 'powerpack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'author_description' => 'yes',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'powerpack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pp-author-list-description' => 'color: {{VALUE}};',
				],
				'condition' => [
					'author_description' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'description_typography',
				'label'     => esc_html__( 'Typography', 'powerpack' ),
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} .pp-author-list-description',
				'condition' => [
					'author_description' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function get_avatar_size( $size = 'sm' ) {

		if ( 'xs' === $size ) {
			$value = 30;
		} elseif ( 'sm' === $size ) {
			$value = 60;
		} elseif ( 'md' === $size ) {
			$value = 120;
		} elseif ( 'lg' === $size ) {
			$value = 180;
		} elseif ( 'xl' === $size ) {
			$value = 240;
		} else {
			$value = 96;
		}

		return $value;
	}

	/**
	 * Render Business Hours widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();

		// Author Icon
		if ( ! empty( $settings['author_icon']['value'] ) ) {
			$has_author_icon = true;
		}

		$author_ids = [];
		$users      = $this->get_user_data();
		$post_types = empty( $settings['post_type'] ) ? 'post' : $settings['post_type'];

		foreach ( $users as $user ) {
			$user_post_count = count_user_posts( $user->ID, $post_types, true );

			$author_ids[] = [
				'autor_id'   => $user->ID,
				'post_count' => $user_post_count,
			];
		}
		$this->add_render_attribute( 'list-wrap', 'class', 'pp-author-list-wrapper' );

		if ( 'grid' === $settings['layout'] ) {
			$this->add_render_attribute( 'list-wrap', 'class', 'elementor-grid' );
		}

		/* if ( empty( $author_ids ) ) {
			$post_type_data = get_post_type_object( $settings['post_type'] );
			printf( '<div class="pp-author-list-error"><strong>%s</strong> %s</div>', esc_html( $post_type_data->labels->singular_name ), esc_html__( ' post type don\'t have any post.', 'powerpack' ) );
			return;
		} */
		?>
		<div <?php $this->print_render_attribute_string( 'list-wrap' ); ?>>
			<?php foreach ( $author_ids as $index => $author_id ) : ?>
				<?php
					$item_key = $this->get_repeater_setting_key( 'item', 'author_list', $index );
					$link_key = $this->get_repeater_setting_key( 'link', 'author_list', $index );

					$this->add_render_attribute( $item_key, 'class', 'pp-author-list-item' );

					if ( 'grid' === $settings['layout'] ) {
						$this->add_render_attribute( $item_key, 'class', 'elementor-grid-item' );
					}

					if ( 'none' !== $settings['link_type'] ) {
						if ( 'author_website' === $settings['link_to'] ) {
							$link = get_the_author_meta( 'user_url', $author_id['autor_id'] );
						} else {
							$link = get_author_posts_url( $author_id['autor_id'] );
						}

						$this->add_render_attribute( $link_key, [
							'href'  => esc_url( $link ),
							'class' => 'pp-author-list-link'
						] );
					}
				?>
				<div <?php $this->print_render_attribute_string( $item_key ); ?>>
					<?php if ( 'box' === $settings['link_type'] ) { ?>
					<a <?php $this->print_render_attribute_string( $link_key ); ?>></a>
					<?php } ?>
					<?php if ( 'gravatar' === $settings['avatar_type'] ) : ?>
						<div class="pp-author-list-avatar">
							<?php
							$avatar_size = $this->get_avatar_size( $settings['author_avatar_size'] );

							if ( 'avatar' === $settings['link_type'] ) {
								printf( '<a %1$s>%2$s</a>',
									wp_kses_post( $this->get_render_attribute_string( $link_key ) ),
									get_avatar( $author_id['autor_id'], $avatar_size )
								);
							} else {
								echo get_avatar( $author_id['autor_id'], $avatar_size );
							}
							?>
						</div>
					<?php elseif ( 'icon' === $settings['avatar_type'] && ! empty( $settings['author_icon']['value'] ) ) : ?>
						<div class="pp-author-list-avatar">
							<?php
							if ( 'avatar' === $settings['link_type'] ) {
								?>
								<a <?php $this->print_render_attribute_string( $link_key ); ?>>
									<?php
										Icons_Manager::render_icon( $settings['author_icon'], array( 'aria-hidden' => 'true' ) );
									?>
								</a>
								<?php
							} else {
								Icons_Manager::render_icon( $settings['author_icon'], array( 'aria-hidden' => 'true' ) );
							}
							?>
						</div>
					<?php endif; ?>

					<div class="pp-author-list-meta">
						<div class="pp-author-list-name">
							<div class="pp-author-list-name-text">
								<?php
								if ( 'name' === $settings['link_type'] ) {
									printf( '<a %1$s>%2$s</a>',
										wp_kses_post( $this->get_render_attribute_string( $link_key ) ),
										esc_html( get_the_author_meta( $settings['author_name'], $author_id['autor_id'] ) )
									);
								} else {
									echo esc_html( get_the_author_meta( $settings['author_name'], $author_id['autor_id'] ) );
								}
								?>
							</div>
						</div>

						<?php if ( 'yes' === $settings['author_role'] ) :
							$get_user = get_user_by( 'id', $author_id['autor_id'] );
							$ob_user = get_object_vars( $get_user );
							?>
							<div class="pp-author-list-role"><?php echo esc_html( $ob_user['roles'][0] ); ?></div>
						<?php endif; ?>

						<?php if ( 'yes' === $settings['author_email'] ) : ?>
							<div class="pp-author-list-email"><?php echo esc_html( get_the_author_meta( 'user_email', $author_id['autor_id'] ) ); ?></div>
						<?php endif; ?>
					</div>

					<?php if ( 'yes' === $settings['author_post_count'] ) : ?>
						<div class="pp-author-list-post-count">
							<?php
							echo ! empty( $settings['author_post_count_text'] ) ? esc_html( $settings['author_post_count_text'] ) : '';
							echo esc_html( $author_id['post_count'] );
							?>
						</div>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['author_description'] ) : ?>
						<div class="pp-author-list-description"><?php echo esc_html( get_the_author_meta( 'description', $author_id['autor_id'] ) ); ?></div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}

	protected function get_user_data() {
		$settings = $this->get_settings();

		$args = [
			'orderby' => $settings['orderby'],
			'order'   => $settings['order'],
		];

		if ( 'custom' === $settings['select_authors_by'] ) {
			$args['number'] = ! empty( $settings['users_per_page'] ) ? $settings['users_per_page'] : '-1';

			if ( ! empty( $settings['include_roles'] ) ) {
				$args['capability__in'] = $settings['include_roles'];
			}

			if ( ! empty( $settings['exclude_roles'] ) ) {
				$args['capability__not_in'] = $settings['exclude_roles'];
			}

			if ( ! empty( $settings['exclude_users'] ) ) {
				$args['exclude'] = $settings['exclude_users'];
			}
		} else {
			if ( ! empty( $settings['select_users'] ) ) {
				$args['include'] = $settings['select_users'];
			}
		}

		return get_users( $args );
	}
}
