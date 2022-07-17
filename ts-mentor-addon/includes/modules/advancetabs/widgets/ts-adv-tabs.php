<?php
/*
Widget Name: Advanced Tabs
Type: widget
Enabled: true
Dir: advancetabs
*/
namespace TS\Modules\Advancetabs\Widgets;

use TS\Ts;
use TS\Base\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use \Elementor\Plugin;
use Elementor\Repeater;
use \Elementor\Utils;
use TS\Modules\Advancetabs\Module as AdvModule;

class TsAdvTabs extends Widget_Base {

	protected $_access_level = 2;
	
	public function get_name() {
		return 'ts-adv-tabs';
	}

	public function is_enabled() {

		return true;
	}

	public function get_title() {
		return __( 'TS - Advance Tabs', 'ts-pro' );
	}

	public function get_icon() {
		return 'ts-tab';
	}

	public function get_categories() {
		return [ 'ts-addons' ];
	}

	public function get_keywords()
	{
		return[
			'tab',
			'tabs',
		];
	}
    
    public function get_style_depends() {
        $styles=[];
        $enqueable=AdvModule::get_enqueuable();
        if(!empty($enqueable)){
            foreach($enqueable as $type=>$enqueue){
                        
                if($type=='css'){
                    // enqueue
                    foreach($enqueue as $style){
                        wp_register_style(
                            $style['name'],
                            (TS_PRO_ASSET_URL . '/css/' . $style['file']. '.css'),
                            false,
                        );
                        $styles[]=$style['name'];
                    }

                }
            }
        }
        return $styles;
    }
    public function get_script_depends() {

		$scripts=[];
        $enqueable=AdvModule::get_enqueuable();
        if(!empty($enqueable)){
            foreach($enqueable as $type=>$enqueue){
                        
                if($type=='js'){
                    foreach($enqueue as $script){
                        wp_enqueue_script(
                            $script['name'],
                            (TS_PRO_ASSET_URL . '/js/' . $script['file']. '.js'),
                            false,
                        );
                        $scripts[]=$script['name'];
                    }

                }
            }
        }
        return $scripts;

	}
	//phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
	public function register_controls() {
		/**
         * Advance Tabs Settings
         */
        $this->start_controls_section(
            'ts_section_adv_tabs_settings',
            [
                'label' => esc_html__('General Settings', 'tsmentor'),
            ]
        );
        
        $this->add_control(
            'ts_adv_tab_layout',
            [
                'label' => esc_html__('Layout', 'tsmentor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'ts-tabs-horizontal',
                'label_block' => false,
                'options' => [
                    'ts-tabs-horizontal' => esc_html__('Horizontal', 'tsmentor'),
                    'ts-tabs-vertical' => esc_html__('Vertical', 'tsmentor'),
                ],
            ]
        );
        $this->add_control(
            'ts_adv_tabs_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'tsmentor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'ts_adv_tab_icon_position',
            [
                'label' => esc_html__('Icon Position', 'tsmentor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'ts-tab-inline-icon',
                'label_block' => false,
                'options' => [
                    'ts-tab-top-icon' => esc_html__('Stacked', 'tsmentor'),
                    'ts-tab-inline-icon' => esc_html__('Inline', 'tsmentor'),
                ],
                'condition' => [
                    'ts_adv_tabs_icon_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_icon_alignment',
            [
                'label' => esc_html__( 'Icon Alignment', 'tsmentor' ),
                'description' => sprintf( __( 'Set icon position before/after the tab title.', 'tsmentor' ) ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'before',
                'options' => [
                    'before' => [
                        'title' => esc_html__( 'Before', 'tsmentor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'after' => [
                        'title' => esc_html__( 'After', 'tsmentor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    'ts_adv_tab_icon_position' => 'ts-tab-inline-icon',
                ],
            ]
        );
        $this->add_control(
            'ts_adv_tabs_default_active_tab',
            [
                'label' => esc_html__('Tab Auto Active?', 'tsmentor'), 
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('If no tab is selected as default active tab, then we display first tab as active. Turn on/off this default behaviour.', 'tsmentor'),
                'default' => 'yes',
                'return_value' => 'yes',
                'label_on'     => __('Yes', 'tsmentor'),
                'label_off'    => __('No', 'tsmentor'),
            ]
        );
        $this->end_controls_section();
        
        /**
         * Advance Tabs Content Settings
         */
        $this->start_controls_section(
            'ts_section_adv_tabs_content_settings',
            [
                'label' => esc_html__('Content', 'tsmentor'),
            ]
        );
        $repeater = new Repeater();

        $repeater->add_control(
            'ts_adv_tabs_tab_show_as_default',
            [
                'label' => __('Active as Default', 'tsmentor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'inactive',
                'return_value' => 'active-default',
            ]
        );
        $repeater->add_control(
            'ts_adv_tabs_icon_type',
            [
                'label' => esc_html__('Icon Type', 'tsmentor'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'none' => [
                        'title' => esc_html__('None', 'tsmentor'),
                        'icon' => 'fa fa-ban',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'tsmentor'),
                        'icon' => 'eicon-icon-box',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'tsmentor'),
                        'icon' => 'eicon-image-bold',
                    ],
                ],
                'default' => 'icon',
            ]
        );

        $repeater->add_control(
            'ts_adv_tabs_tab_title_icon_new',
            [
                'label' => esc_html__('Icon', 'tsmentor'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'ts_adv_tabs_tab_title_icon',
                'default' => [
                    'value' => 'fas fa-home',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'ts_adv_tabs_icon_type' => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'ts_adv_tabs_tab_title_image',
            [
                'label' => esc_html__('Image', 'tsmentor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'ts_adv_tabs_icon_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'ts_adv_tabs_tab_title',
            [
                'name' => 'ts_adv_tabs_tab_title',
                'label' => esc_html__('Tab Title', 'tsmentor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Tab Title', 'tsmentor'),
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'ts_adv_tabs_tab_title_html_tag',
            [
                'name' => 'ts_adv_tabs_tab_title',
                'label' => esc_html__('Title HTML Tag', 'tsmentor'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'span',
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'ts_adv_tabs_text_type',
            [
                'label' => __('Content Type', 'tsmentor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'content' => __('Content', 'tsmentor'),
                    'template' => __('Saved Templates', 'tsmentor'),
                ],
                'default' => 'content',
            ]
        );

        $repeater->add_control(
            'ts_primary_templates',
            [
                'label' => __('Choose Template', 'tsmentor'),
                'type' => 'ts-select2',
                'source_name' => 'post_type',
                'source_type' => 'elementor_library',
                'label_block' => true,
                'condition' => [
                    'ts_adv_tabs_text_type' => 'template',
                ],
            ]
        );

        $repeater->add_control(
            'ts_adv_tabs_tab_content',
            [
                'label' => esc_html__('Tab Content', 'tsmentor'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'tsmentor'),
                'dynamic' => ['active' => true],
                'condition' => [
                    'ts_adv_tabs_text_type' => 'content',
                ],
            ]
        );
        
        $repeater->add_control(
            'ts_adv_tabs_tab_id',
            [
                'label' => esc_html__('Custom ID', 'tsmentor'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__( 'Custom ID will be added as an anchor tag. For example, if you add ‘test’ as your custom ID, the link will become like the following: https://www.example.com/#test and it will open the respective tab directly.', 'tsmentor' ),
                'default' => '',
            ]
        );

        $this->add_control(
            'ts_adv_tabs_tab',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    ['ts_adv_tabs_tab_title' => esc_html__('Tab Title 1', 'tsmentor')],
                    ['ts_adv_tabs_tab_title' => esc_html__('Tab Title 2', 'tsmentor')],
                    ['ts_adv_tabs_tab_title' => esc_html__('Tab Title 3', 'tsmentor')],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{ts_adv_tabs_tab_title}}',
            ]
        );
        $this->end_controls_section();
        
        /**
         * -------------------------------------------
         * Tab Style Advance Tabs Generel Style
         * -------------------------------------------
         */
        $this->start_controls_section(
            'ts_section_adv_tabs_style_settings',
            [
                'label' => esc_html__('General', 'tsmentor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'ts_adv_tabs_padding',
            [
                'label' => esc_html__('Padding', 'tsmentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_margin',
            [
                'label' => esc_html__('Margin', 'tsmentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'ts_adv_tabs_border',
                'label' => esc_html__('Border', 'tsmentor'),
                'selector' => '{{WRAPPER}} .ts-advance-tabs',
            ]
        );

        $this->add_responsive_control(
            'ts_adv_tabs_border_radius',
            [
                'label' => esc_html__('Border Radius', 'tsmentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'ts_adv_tabs_box_shadow',
                'selector' => '{{WRAPPER}} .ts-advance-tabs',
            ]
        );
        $this->end_controls_section();
        /**
         * -------------------------------------------
         * Tab Style Advance Tabs Content Style
         * -------------------------------------------
         */
        $this->start_controls_section(
            'ts_section_adv_tabs_tab_style_settings',
            [
                'label' => esc_html__('Tab Title', 'tsmentor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ts_adv_tabs_tab_title_typography',
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li',
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_title_width',
            [
                'label' => __('Title Min Width', 'tsmentor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs.ts-tabs-vertical > .ts-tabs-nav > ul' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'ts_adv_tab_layout' => 'ts-tabs-vertical',
                ],
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_tab_icon_size',
            [
                'label' => __('Icon Size', 'tsmentor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_tab_icon_gap',
            [
                'label' => __('Icon Gap', 'tsmentor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ts-tab-inline-icon li .title-before-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ts-tab-inline-icon li .title-after-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ts-tab-top-icon li i, {{WRAPPER}} .ts-tab-top-icon li img, {{WRAPPER}} .ts-tab-top-icon li svg' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'ts_adv_tabs_tab_padding',
            [
                'label' => esc_html__('Padding', 'tsmentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_tab_margin',
            [
                'label' => esc_html__('Margin', 'tsmentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('ts_adv_tabs_header_tabs');
        // Normal State Tab
        $this->start_controls_tab('ts_adv_tabs_header_normal', ['label' => esc_html__('Normal', 'tsmentor')]);
        $this->add_control(
            'ts_adv_tabs_tab_color',
            [
                'label' => esc_html__('Background Color', 'tsmentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f1f1f1',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'ts_adv_tabs_tab_bgtype',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li',
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_text_color',
            [
                'label' => esc_html__('Text Color', 'tsmentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_icon_color',
            [
                'label' => esc_html__('Icon Color', 'tsmentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'ts_adv_tabs_icon_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'ts_adv_tabs_tab_border',
                'label' => esc_html__('Border', 'tsmentor'),
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li',
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_tab_border_radius',
            [
                'label' => esc_html__('Border Radius', 'tsmentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        // Hover State Tab
        $this->start_controls_tab('ts_adv_tabs_header_hover', ['label' => esc_html__('Hover', 'tsmentor')]);
        $this->add_control(
            'ts_adv_tabs_tab_color_hover',
            [
                'label' => esc_html__('Tab Background Color', 'tsmentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'ts_adv_tabs_tab_bgtype_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li:hover',
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'tsmentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'tsmentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li:hover > i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li:hover > svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'ts_adv_tabs_icon_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'ts_adv_tabs_tab_border_hover',
                'label' => esc_html__('Border', 'tsmentor'),
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li:hover',
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_tab_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'tsmentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        // Active State Tab
        $this->start_controls_tab('ts_adv_tabs_header_active', ['label' => esc_html__('Active', 'tsmentor')]);
        $this->add_control(
            'ts_adv_tabs_tab_color_active',
            [
                'label' => esc_html__('Tab Background Color', 'tsmentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'ts_adv_tabs_tab_bgtype_active',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li.active',
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_text_color_active',
            [
                'label' => esc_html__('Text Color', 'tsmentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li.active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'tsmentor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li.active > i' => 'color: {{VALUE}};',
                    //'{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li.active-default > i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li.active > svg' => 'fill: {{VALUE}};',
                    //'{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li.active-default > svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'ts_adv_tabs_icon_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'ts_adv_tabs_tab_border_active',
                'label' => esc_html__('Border', 'tsmentor'),
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li.active',
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_tab_border_radius_active',
            [
                'label' => esc_html__('Border Radius', 'tsmentor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /**
         * -------------------------------------------
         * Tab Style Advance Tabs Content Style
         * -------------------------------------------
         */
        $this->start_controls_section(
            'ts_section_adv_tabs_tab_content_style_settings',
            [
                'label' => esc_html__('Content', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'adv_tabs_content_bg_color',
            [
                'label' => esc_html__('Background Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-content > div' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'adv_tabs_content_bgtype',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-content > div',
            ]
        );
        $this->add_control(
            'adv_tabs_content_text_color',
            [
                'label' => esc_html__('Text Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-content > div' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ts_adv_tabs_content_typography',
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-content > div',
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_content_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_content_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-content > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'ts_adv_tabs_content_border',
                'label' => esc_html__('Border', 'essential-addons-for-elementor-lite'),
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-content > div',
            ]
        );
        $this->add_responsive_control(
            'ts_adv_tabs_content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ts-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'ts_adv_tabs_content_shadow',
                'selector' => '{{WRAPPER}} .ts-advance-tabs .ts-tabs-content > div',
                'separator' => 'before',
            ]
        );
        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style Advance Tabs Caret Style
         * -------------------------------------------
         */
        $this->start_controls_section(
            'ts_section_adv_tabs_tab_caret_style_settings',
            [
                'label' => esc_html__('Caret', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_caret_show',
            [
                'label' => esc_html__('Show Caret on Active Tab', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_caret_size',
            [
                'label' => esc_html__('Caret Size', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li:after' => 'border-width: {{SIZE}}px; bottom: -{{SIZE}}px',
                    '{{WRAPPER}} .ts-advance-tabs.ts-tabs-vertical > .ts-tabs-nav > ul li:after' => 'right: -{{SIZE}}px; top: calc(50% - {{SIZE}}px) !important;',
                    '.rtl {{WRAPPER}} .ts-advance-tabs.ts-tabs-vertical > .ts-tabs-nav > ul li:after' => 'right: auto; left: -{{SIZE}}px !important; top: calc(50% - {{SIZE}}px) !important;',
                ],
                'condition' => [
                    'ts_adv_tabs_tab_caret_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'ts_adv_tabs_tab_caret_color',
            [
                'label' => esc_html__('Caret Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .ts-advance-tabs .ts-tabs-nav > ul li:after' => 'border-top-color: {{VALUE}};',
                    '{{WRAPPER}} .ts-advance-tabs.ts-tabs-vertical > .ts-tabs-nav > ul li:after' => 'border-top-color: transparent; border-left-color: {{VALUE}};',
                ],
                'condition' => [
                    'ts_adv_tabs_tab_caret_show' => 'yes',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style: Advance Tabs Responsive Controls
         * -------------------------------------------
         */
        $this->start_controls_section(
            'ts_ad_responsive_controls',
            [
                'label' => esc_html__('Responsive Controls', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'responsive_vertical_layout',
            [
                'label' => __('Vertical Layout', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'essential-addons-for-elementor-lite'),
                'label_off' => __('No', 'essential-addons-for-elementor-lite'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
	}

	public function render() {

		$settings = $this->get_settings_for_display();

        $ts_find_default_tab = [];
        $ts_adv_tab_id = 1;
        $ts_adv_tab_content_id = 1;
        $tab_icon_migrated = isset($settings['__fa4_migrated']['ts_adv_tabs_tab_title_icon_new']);
        $tab_icon_is_new = empty($settings['ts_adv_tabs_tab_title_icon']);
        $tab_auto_active =  'yes' === $settings['ts_adv_tabs_default_active_tab'] ? esc_attr('ts-tab-auto-active') : '';
        
        $this->add_render_attribute(
            'ts_tab_wrapper',
            [
                'id' => "ts-advance-tabs-{$this->get_id()}",
                'class' => ['ts-advance-tabs', $settings['ts_adv_tab_layout'], $tab_auto_active],
                'data-tabid' => $this->get_id(),
            ]
        );
        if ($settings['ts_adv_tabs_tab_caret_show'] != 'yes') {
            $this->add_render_attribute('ts_tab_wrapper', 'class', 'active-caret-on');
        }

        if ($settings['responsive_vertical_layout'] != 'yes') {
            $this->add_render_attribute('ts_tab_wrapper', 'class', 'responsive-vertical-layout');
        }
        $this->add_render_attribute('ts_tab_icon_position', 'class', esc_attr($settings['ts_adv_tab_icon_position'])); ?>
        
        <div <?php echo $this->get_render_attribute_string('ts_tab_wrapper'); ?>>
            <div class="ts-tabs-nav">
                <ul <?php echo $this->get_render_attribute_string('ts_tab_icon_position'); ?>>
                    <?php foreach ($settings['ts_adv_tabs_tab'] as $index => $tab) :
	                    $tab_id = $tab['ts_adv_tabs_tab_id'] ? $tab['ts_adv_tabs_tab_id'] : Ts::$_helper::str_to_css_id( $tab['ts_adv_tabs_tab_title'] );
	                    $tab_id = $tab_id === 'safari' ? 'ts-safari' : $tab_id;
                        $tab_count = $index + 1;
					    $tab_title_setting_key = $this->get_repeater_setting_key( 'ts_adv_tabs_tab_title', 'ts_adv_tabs_tab', $index );
                        $this->add_render_attribute( $tab_title_setting_key, [
                            'id' => $tab_id,
                            'class' => [ $tab['ts_adv_tabs_tab_show_as_default'], 'ts-tab-item-trigger' ],
                            'aria-selected' => 1 === $tab_count ? 'true' : 'false',
                            'data-tab' => $tab_count,
                            'role' => 'tab',
                            'tabindex' => 1 === $tab_count ? '0' : '-1',
                            'aria-controls' => $tab_id . '-tab',
                            'aria-expanded' => 'false',
                        ] );
                        $repeater_html_tag = !empty($tab['ts_adv_tabs_tab_title_html_tag']) ? $tab['ts_adv_tabs_tab_title_html_tag'] : 'span';
                        $repeater_tab_title = Ts::$_helper::ts_wp_kses($tab['ts_adv_tabs_tab_title']);
                    ?>
                        <li <?php $this->print_render_attribute_string( $tab_title_setting_key ); ?>>
                            <?php if( $settings['ts_adv_tab_icon_position'] === 'ts-tab-inline-icon' && $settings['ts_adv_tabs_tab_icon_alignment'] === 'after' ) : ?>
                                <?php 
                                $this->add_render_attribute( $tab_title_setting_key . '_repeater_tab_title_attr', [
                                    'class' => [ 'ts-tab-title', ' title-before-icon' ],
                                ] );

                                printf('<%1$s %2$s>%3$s</%1$s>', 
                                    $repeater_html_tag,
                                    $this->get_render_attribute_string( $tab_title_setting_key . '_repeater_tab_title_attr'), 
                                    $repeater_tab_title 
                                ); 
                                ?>
                            <?php endif; ?>
                            <?php if ($settings['ts_adv_tabs_icon_show'] === 'yes') :
                                if ($tab['ts_adv_tabs_icon_type'] === 'icon') : ?>
                                    <?php if ($tab_icon_is_new || $tab_icon_migrated) {
		                                Icons_Manager::render_icon( $tab['ts_adv_tabs_tab_title_icon_new'] );
                                    } else {
                                        echo '<i class="' . $tab['ts_adv_tabs_tab_title_icon'] . '"></i>';
                                    } ?>
                                <?php elseif ($tab['ts_adv_tabs_icon_type'] === 'image') : ?>
                                    <img src="<?php echo esc_attr($tab['ts_adv_tabs_tab_title_image']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($tab['ts_adv_tabs_tab_title_image']['id'], '_wp_attachment_image_alt', true)); ?>">
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if( $settings['ts_adv_tab_icon_position'] === 'ts-tab-inline-icon' && $settings['ts_adv_tabs_tab_icon_alignment'] !== 'after' ) : ?>
                                <?php 
                                $this->add_render_attribute( $tab_title_setting_key . '_repeater_tab_title_attr', [
                                    'class' => [ 'ts-tab-title', ' title-after-icon' ],
                                ] );

                                printf('<%1$s %2$s>%3$s</%1$s>', 
                                    $repeater_html_tag,
                                    $this->get_render_attribute_string( $tab_title_setting_key . '_repeater_tab_title_attr'), 
                                    $repeater_tab_title 
                                ); 
                                ?>
                            <?php endif; ?>
                            <?php if( $settings['ts_adv_tab_icon_position'] !== 'ts-tab-inline-icon' ) : ?>
                                <?php 
                                $this->add_render_attribute( $tab_title_setting_key . '_repeater_tab_title_attr', [
                                    'class' => [ 'ts-tab-title', ' title-after-icon' ],
                                ] );

                                printf('<%1$s %2$s>%3$s</%1$s>', 
                                    $repeater_html_tag,
                                    $this->get_render_attribute_string( $tab_title_setting_key . '_repeater_tab_title_attr'), 
                                    $repeater_tab_title 
                                ); 
                                ?>
                            <?php endif; ?>
                            </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="ts-tabs-content">
		        <?php foreach ($settings['ts_adv_tabs_tab'] as $tab) :
			        $ts_find_default_tab[] = $tab['ts_adv_tabs_tab_show_as_default'];
			        $tab_id = $tab['ts_adv_tabs_tab_id'] ? $tab['ts_adv_tabs_tab_id'] : Ts::$_helper::str_to_css_id( $tab['ts_adv_tabs_tab_title'] );
			        $tab_id = $tab_id === 'safari' ? 'tsl-safari-tab' : $tab_id . '-tab'; ?>

                    <div id="<?php echo $tab_id; ?>" class="clearfix ts-tab-content-item <?php echo esc_attr($tab['ts_adv_tabs_tab_show_as_default']); ?>" data-title-link="<?php echo $tab_id; ?>">
				        <?php if ('content' == $tab['ts_adv_tabs_text_type']) : ?>
					        <?php echo do_shortcode($tab['ts_adv_tabs_tab_content']); ?>
				        <?php elseif ('template' == $tab['ts_adv_tabs_text_type']) : ?>
					        <?php if (!empty($tab['ts_primary_templates'])) {
						        echo Plugin::$instance->frontend->get_builder_content($tab['ts_primary_templates'], true);
					        } ?>
				        <?php endif; ?>
                    </div>
		        <?php endforeach; ?>
            </div>
        </div>
    <?php 
	}
}
