<?php
namespace ElementorPro\Modules\NavMenu\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Nav_Menu extends Widget_Base {

	public function get_name() {
		return 'nav-menu';
	}

	public function get_title() {
		return __( 'Nav Menu', 'elementor-pro' );
	}

	public function get_icon() {
		return 'eicon-navigation-menu';
	}

	public function get_categories() {
		return [ 'pro-elements' ];
	}

	public function get_script_depends() {
		return [ 'smartmenus' ];
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'elementor-pro' ),
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label'   => __( 'Menu', 'elementor-pro' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'separator' => 'after',
					'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'elementor-pro' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'elementor-pro' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __( 'Horizontal', 'elementor-pro' ),
					'vertical' => __( 'Vertical', 'elementor-pro' ),
					'off_canvas' => __( 'Off-Canvas', 'elementor-pro' ),
					'dropdown' => __( 'Dropdown', 'elementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu--layout-',
				'render_type' => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'toggle',
			[
				'label' => __( 'Toggle', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'elementor-pro' ),
					'burger' => __( 'Burger', 'elementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu--toggle elementor-nav-menu--',
				'condition' => [
					'layout' => 'dropdown',
				],
				'render_type' => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'align_items',
			[
				'label' => __( 'Align', 'elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Stretch', 'elementor-pro' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'prefix_class' => 'elementor-nav-menu__align-',
				'condition' => [
					'layout' => 'horizontal',
				],
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'positive',
				'options' => [
					'positive' => __( 'Positive', 'elementor-pro' ),
					'negative' => __( 'Negative', 'elementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu--style-',
			]
		);

		$this->add_control(
			'pointer',
			[
				'label' => __( 'Pointer', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'underline',
				'options' => [
					'none' => __( 'None', 'elementor-pro' ),
					'underline' => __( 'Underline', 'elementor-pro' ),
					'overline' => __( 'Overline', 'elementor-pro' ),
					'double-line' => __( 'Double Line', 'elementor-pro' ),
					'framed' => __( 'Framed', 'elementor-pro' ),
					'background' => __( 'Background', 'elementor-pro' ),
					'text' => __( 'Text', 'elementor-pro' ),
				],
				'prefix_class' => 'e--pointer-',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
				],
			]
		);

		$this->add_control(
			'animation_line',
			[
				'label' => __( 'Animation', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'slide' => 'Slide',
					'grow' => 'Grow',
					'drop-in' => 'Drop In',
					'drop-out' => 'Drop Out',
				],
				'prefix_class' => 'e--animation-',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
					'pointer' => [ 'underline', 'overline', 'double-line' ],
				],
			]
		);

		$this->add_control(
			'animation_framed',
			[
				'label' => __( 'Animation', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'draw' => 'Draw',
					'corners' => 'Corners',
				],
				'prefix_class' => 'e--animation-',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
					'pointer' => 'framed',
				],
			]
		);

		$this->add_control(
			'animation_background',
			[
				'label' => __( 'Animation', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'sweep-left' => 'Sweep Left',
					'sweep-right' => 'Sweep Right',
					'sweep-up' => 'Sweep Up',
					'sweep-down' => 'Sweep Down',
					'shutter-in-vertical' => 'Shutter In Vertical',
					'shutter-out-vertical' => 'Shutter Out Vertical',
					'shutter-in-horizontal' => 'Shutter In Horizontal',
					'shutter-out-horizontal' => 'Shutter Out Horizontal',
				],
				'prefix_class' => 'e--animation-',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'animation_text',
			[
				'label' => __( 'Animation', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grow',
				'options' => [
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'sink' => 'Sink',
					'float' => 'Float',
					'skew' => 'Skew',
					'rotate' => 'Rotate',
				],
				'prefix_class' => 'e--animation-',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
					'pointer' => 'text',
				],
			]
		);

		$this->add_control(
			'indicator',
			[
				'label' => __( 'Submenu Indicator', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'classic',
				'options' => [
					'none' => __( 'None', 'elementor-pro' ),
					'classic' => __( 'Classic', 'elementor-pro' ),
					'chevron' => __( 'Chevron', 'elementor-pro' ),
					'angle' => __( 'Angle', 'elementor-pro' ),
					'plus' => __( 'Plus', 'elementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu--indicator-',
			]
		);

		$this->add_control(
			'heading_mobile_layout',
			[
				'label' => __( 'Mobile', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
				],
			]
		);

		$this->add_control(
			'mobile_layout',
			[
				'label' => __( 'Layout', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'off_canvas',
				'options' => [
					'off_canvas' => __( 'Off-Canvas', 'elementor-pro' ),
					'dropdown' => __( 'Dropdown', 'elementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu--layout-mobile-',
				'render_type' => 'template',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'text_align',
			[
				'label' => __( 'Align', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'aside',
				'options' => [
					'aside' => __( 'Aside', 'elementor-pro' ),
					'center' => __( 'Center', 'elementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu__text-align-',
			]
		);

		$this->add_control(
			'mobile_toggle',
			[
				'label' => __( 'Toggle', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'elementor-pro' ),
					'burger' => __( 'Burger', 'elementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu--mobile-toggle elementor-nav-menu--mobile-',
				'condition' => [
					'mobile_layout' => 'dropdown',
				],
				'render_type' => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'slide_from',
			[
				'label' => __( 'Slide From', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Left', 'elementor-pro' ),
					'right' => __( 'Right', 'elementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu--slide-from-',
			]
		);

		$this->add_responsive_control(
			'off_canvas_max_width',
			[
				'label' => __( 'Max Width', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%' => [
						'min' => 10,
					],
					'px' => [
						'min' => 100,
						'max' => 600,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-nav-menu--layout-off_canvas .elementor-nav-menu__container' => 'max-width: {{SIZE}}{{UNIT}}',
					'(mobile){{WRAPPER}}.elementor-nav-menu--layout-mobile-off_canvas .elementor-nav-menu__container' => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'toggle_align',
			[
				'label' => __( 'Toggle Align', 'elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right' => 'margin-left: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => '{{VALUE}}',
				],
				'label_block' => false,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label' => __( 'Main Menu', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_control(
			'background_color_menu_item',
			[
				'label' => __( 'Background Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.elementor-nav-menu--layout-off_canvas .elementor-nav-menu__container' => 'background-color: {{VALUE}}',
					'(mobile){{WRAPPER}}.elementor-nav-menu--layout-mobile-off_canvas .elementor-nav-menu__container' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_menu_item',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Menu Item', 'elementor-pro' ),
			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'color_menu_item',
			[
				'label' => __( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'color_menu_item_hover',
			[
				'label' => __( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-sub-item:hover,
					{{WRAPPER}} .elementor-sub-item.elementor-sub-item-active,
					{{WRAPPER}} .elementor-sub-item.highlighted,
					{{WRAPPER}} .elementor-sub-item:focus' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-item:hover,
					{{WRAPPER}} .elementor-item.elementor-item-active,
					{{WRAPPER}} .elementor-item.highlighted,
					{{WRAPPER}} .elementor-item:focus' => 'color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => 'background',
				],
			]
		);

		$this->add_control(
			'color_menu_item_hover_pointerbg',
			[
				'label' => __( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .elementor-item:hover,
					{{WRAPPER}} .elementor-item.elementor-item-active,
					{{WRAPPER}} .elementor-item.highlighted,
					{{WRAPPER}} .elementor-item:focus' => 'color: {{VALUE}}',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'pointer_color_menu_item_hover',
			[
				'label' => __( 'Pointer Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:not(.e--pointer-framed) .elementor-item:before,
					{{WRAPPER}}:not(.e--pointer-framed) .elementor-item:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.e--pointer-framed .elementor-item:before,
					{{WRAPPER}}.e--pointer-framed .elementor-item:after' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-sub-item:hover,
					{{WRAPPER}} .elementor-sub-item:focus,
					{{WRAPPER}} .elementor-sub-item.elementor-sub-item-active,
					{{WRAPPER}} .elementor-sub-item.highlighted' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
					'pointer!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_active',
			[
				'label' => __( 'Active', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'color_menu_item_active',
			[
				'label' => __( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-item.elementor-item-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pointer_color_menu_item_active',
			[
				'label' => __( 'Pointer Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:not(.e--pointer-framed) .elementor-item.elementor-item-active:before,
					{{WRAPPER}}:not(.e--pointer-framed) .elementor-item.elementor-item-active:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.e--pointer-framed .elementor-item.elementor-item-active:before,
					{{WRAPPER}}.e--pointer-framed .elementor-item.elementor-item-active:after' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
					'pointer!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'label' => __( 'Typography', 'elementor-pro' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-nav-menu a',
			]
		);

		$this->add_responsive_control(
			'pointer_width',
			[
				'label' => __( 'Pointer Width', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'devices' => [ self::RESPONSIVE_DESKTOP, self::RESPONSIVE_TABLET ],
				'range' => [
					'px' => [
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.e--pointer-framed .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.e--pointer-framed.e--animation-draw .elementor-item:before' => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.e--pointer-framed.e--animation-draw .elementor-item:after' => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
					'{{WRAPPER}}.e--pointer-framed.e--animation-corners .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.e--pointer-framed.e--animation-corners .elementor-item:after' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
					'{{WRAPPER}}.e--pointer-underline .elementor-item:after,
					 {{WRAPPER}}.e--pointer-overline .elementor-item:before,
					 {{WRAPPER}}.e--pointer-double-line .elementor-item:before,
					 {{WRAPPER}}.e--pointer-double-line .elementor-item:after' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
					'pointer' => [ 'underline', 'overline', 'double-line', 'framed' ],
				],
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_menu_item',
			[
				'label' => __( 'Horizontal Padding', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-nav-menu--close' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'padding_vertical_menu_item',
			[
				'label' => __( 'Vertical Padding', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_space_between',
			[
				'label' => __( 'Space Between', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}}.elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}}.elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}:not(.elementor-nav-menu--layout-horizontal) .elementor-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius_menu_item',
			[
				'label' => __( 'Border Radius', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.e--animation-shutter-in-horizontal .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
					'{{WRAPPER}}.e--animation-shutter-in-horizontal .elementor-item:after' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.e--animation-shutter-in-vertical .elementor-item:before' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
					'{{WRAPPER}}.e--animation-shutter-in-vertical .elementor-item:after' => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
					],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_submenu',
			[
				'label' => __( 'Submenu', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_submenu_item_style' );

		$this->start_controls_tab(
			'tab_submenu_item_normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'color_submenu_item',
			[
				'label' => __( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu > li li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_color_submenu_item',
			[
				'label' => __( 'Background Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu ul' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_submenu_item_hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'color_submenu_item_hover',
			[
				'label' => __( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu > li li:hover a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_color_submenu_item_hover',
			[
				'label' => __( 'Background Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu > li li a:hover,
					{{WRAPPER}} .elementor-nav-menu > li li a:focus,
					{{WRAPPER}} .elementor-nav-menu > li li a.highlighted' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'submenu_typography',
				'label' => __( 'Typography', 'elementor-pro' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .elementor-nav-menu ul li a',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'submenu_border',
				'label' => __( 'Border', 'elementor-pro' ),
				'selector' => '{{WRAPPER}} .elementor-nav-menu ul',
				'separator' => 'before',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
				],
			]
		);

		$this->add_responsive_control(
			'submenu_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .elementor-nav-menu ul li:first-child a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .elementor-nav-menu ul li:last-child a' => 'border-radius: {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'submenu_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elementor-nav-menu ul',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
				],
			]
		);

		$this->add_control(
			'padding_horizontal_submenu_item',
			[
				'label' => __( 'Horizontal Padding', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu > li li a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',

			]
		);

		$this->add_control(
			'padding_vertical_submenu_item',
			[
				'label' => __( 'Vertical Padding', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu > li li a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_submenu_divider',
			[
				'label' => __( 'Divider', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'submenu_divider',
				'label' => __( 'Divider', 'elementor-pro' ),
				'selector' => '{{WRAPPER}} .elementor-nav-menu ul li:not(:last-child)',
				'exclude' => [ 'width' ],
			]
		);

		$this->add_control(
			'submenu_divider_width',
			[
				'label' => __( 'Border Width', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu ul li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'submenu_divider_border!' => '',
				],
			]
		);

		$this->add_control(
			'submenu_top_distance',
			[
				'label' => __( 'Distance', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'(tablet+){{WRAPPER}} .elementor-nav-menu > li > ul' => 'margin-top: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'before',
				'condition' => [
					'layout' => [ 'horizontal', 'vertical' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'style_toggle',
			[
				'label' => __( 'Toggle', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs( 'tabs_toggle_color' );

		$this->start_controls_tab(
			'tab_toggle_color_normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'color_toggle_normal',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle__icon,
					{{WRAPPER}} .elementor-menu-toggle__icon:before,
					{{WRAPPER}} .elementor-menu-toggle__icon:after' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_toggle_color_hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'color_toggle_hover',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle:hover .elementor-menu-toggle__icon,
					{{WRAPPER}} .elementor-menu-toggle:hover .elementor-menu-toggle__icon:before,
					{{WRAPPER}} .elementor-menu-toggle:hover .elementor-menu-toggle__icon:after' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$available_menus = $this->get_available_menus();

		if ( ! $available_menus )
			return;

		$settings = $this->get_settings();

		$args = [
			'menu' => $settings['menu'],
			'menu_class' => 'elementor-nav-menu',
			'menu_id' => 'menu-' . $this->get_id(),
			'container' => '',
		];

		if ( 'vertical' === $settings['layout'] ) {
			$args['menu_class'] .= ' sm-vertical';
		}
		?>
		<div class="elementor-menu-toggle elementor-clickable">
			<span class="elementor-menu-toggle__icon"></span>
		</div>
		<nav class="elementor-nav-menu__container">
			<div class="elementor-nav-menu--close__container">
				<div class="elementor-nav-menu--close elementor-clickable">
					<i class="eicon-close"></i>
				</div>
			</div>
			<?php
			add_filter( 'nav_menu_link_attributes', [ $this, 'filter_handle_link_classes' ], 10, 4 );

			wp_nav_menu( $args );

			remove_filter( 'nav_menu_link_attributes', [ $this, 'filter_handle_link_classes' ], 10 );
			?>
		</nav>
		<?php
	}

	public function filter_handle_link_classes( $atts, $item, $args, $depth ) {
		$classes = ( 0 === $depth ) ? 'elementor-item' : 'elementor-sub-item';

		if ( in_array( 'current-menu-item', $item->classes ) ) {
			$classes .= ' ' . 'elementor-item-active';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = $classes;
		} else {
			$atts['class'] .= ' ' . $classes;
		}

		return $atts;
	}
}
