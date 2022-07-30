<?php
/*
Module Name: Custom Post Type Lists
Widget Id: ts-cpt
Type: widget
Enabled: true
Dir: cpt
*/
namespace TS\Modules\Cpt\Widgets;

use TS\Base\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;
use TS\Modules\Cpt\Module;

class TsCpt extends Widget_Base {
    
    const DEFAULT_COLUMNS_AND_ROWS = 4;
    
	public function get_name() {
		return 'ts_custom_post_list';
	}

	public function get_title() {
		return esc_html__( 'Custom Post List', 'tsmentor' );
	}

	public function get_icon() {
		return 'eicon-post';
	}

	public function get_categories() {
		return [ 'ts-addons' ];
	}

	public function get_keywords() {
		return [ 'post', 'cpt','custom post' ];
	}
    protected function get_devices_default_args() {
		$devices_required = [];

		// Make sure device settings can inherit from larger screen sizes' breakpoint settings.
		foreach ( Breakpoints_Manager::get_default_config() as $breakpoint_name => $breakpoint_config ) {
			$devices_required[ $breakpoint_name ] = [
				'required' => false,
			];
		}

		return $devices_required;
	}

	protected function add_columns_responsive_control() {
		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'prefix_class' => 'elementor-grid%s-',
				'min' => 1,
				'max' => 12,
				'default' => self::DEFAULT_COLUMNS_AND_ROWS,
				'tablet_default' => '3',
				'mobile_default' => '2',
				'required' => true,
				'device_args' => $this->get_devices_default_args(),
				'min_affected_device' => [
					Controls_Stack::RESPONSIVE_DESKTOP => Controls_Stack::RESPONSIVE_TABLET,
					Controls_Stack::RESPONSIVE_TABLET => Controls_Stack::RESPONSIVE_TABLET,
				],
			]
		);
	}
    public function get_post_types () {
		$post_types = ts_get_post_types();
		return $post_types;
	}
    protected function register_content_controls() {

		// Content Tab Start

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'List', 'tsmentor' ),
			]
		);
        
        $this->add_control(
			'post_type',
			[
				'label' => __( 'Source', 'tsmentor' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_post_types(),
				'default' => key( $this->get_post_types() ),
			]
		);

		$this->add_control(
			'show_post_by',
			[
				'label' => __( 'Show post by:', 'tsmentor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'recent',
				'options' => [
					'recent' => __( 'Recent Post', 'tsmentor' ),
					'selected' => __( 'Selected Post', 'tsmentor' ),
				],

			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Limit', 'tsmentor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
				'dynamic' => [ 'active' => true ],
				'condition' => [
					'show_post_by' => [ 'recent' ]
				]
			]
		);

		$repeater = [];

		foreach ( $this->get_post_types() as $key => $value ) {

			$repeater[$key] = new Repeater();

			$repeater[$key]->add_control(
				'title',
				[
					'label' => __( 'Title', 'tsmentor' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => __( 'Customize Title', 'tsmentor' ),
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$repeater[$key]->add_control(
				'post_id',
				[
					'label' => __( 'Select ', 'tsmentor' ) . $value,
					'label_block' => true,
					'type' => 'ts-select2',
					'multiple' => false,
					'placeholder' => 'Search ' . $value,
                    'source_name' => 'post_type',
                    'source_type' => $key,
				]
			);

			$this->add_control(
				'selected_list_' . $key,
				[
					'label' => '',
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater[$key]->get_controls(),
					'title_field' => '{{ title }}',
					'condition' => [
						'show_post_by' => 'selected',
						'post_type' => $key
					],
				]
			);
		}

		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_settings',
			[
				'label' => __( 'Settings', 'tsmentor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'feature_image',
			[
				'label' => __( 'Featured Image', 'tsmentor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'tsmentor' ),
				'label_off' => __( 'Hide', 'tsmentor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'feature_image_pos',
			[
				'label' => __( 'Image Position', 'tsmentor' ),
				'label_block' => false,
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'tsmentor' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'tsmentor' ),
						'icon' => 'eicon-v-align-top',
					],
				],
				'style_transfer' => true,
				'condition' => [
					'feature_image' => 'yes'
				],
				'selectors_dictionary' => [
					'left' => 'flex-direction: row',
					'top' => 'flex-direction: column',
				],
				'selectors' => [
					'{{WRAPPER}} .ts-post-list .ts-post-list-item a' => '{{VALUE}};',
					'{{WRAPPER}} .ts-post-list-item a img' => 'margin-right: 0px;',
				],
			]
		);
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_image',
				'default' => 'thumbnail',
				'exclude' => [
					'custom'
				],
				'condition' => [
					'feature_image' => 'yes'
				]
			]
		);

        $this->add_control(
			'content',
			[
				'label' => __( 'Show Content', 'tsmentor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'tsmentor' ),
				'label_off' => __( 'Hide', 'tsmentor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        $this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'tsmentor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'h1' => [
						'title' => __( 'H1', 'tsmentor' ),
						'icon' => 'eicon-editor-h1'
					],
					'h2' => [
						'title' => __( 'H2', 'tsmentor' ),
						'icon' => 'eicon-editor-h2'
					],
					'h3' => [
						'title' => __( 'H3', 'tsmentor' ),
						'icon' => 'eicon-editor-h3'
					],
					'h4' => [
						'title' => __( 'H4', 'tsmentor' ),
						'icon' => 'eicon-editor-h4'
					],
					'h5' => [
						'title' => __( 'H5', 'tsmentor' ),
						'icon' => 'eicon-editor-h5'
					],
					'h6' => [
						'title' => __( 'H6', 'tsmentor' ),
						'icon' => 'eicon-editor-h6'
					]
				],
				'default' => 'h2',
				'toggle' => false,
			]
		);
        $this->add_control(
			'item_align',
			[
				'label' => __( 'Alignment', 'tsmentor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'tsmentor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'tsmentor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'tsmentor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => true,
				'selectors_dictionary' => [
					'left' => 'justify-content: flex-start',
					'center' => 'justify-content: center',
					'right' => 'justify-content: flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .ts-post-list .ts-post-list-item a' => '{{VALUE}};'
				],
				'condition' => [
					'feature_image_pos' => 'left',
				]
			]
		);

		$this->end_controls_section();
	}
    
    /**
     * Register widget style controls
     */
	protected function register_style_controls () {
		$this->__post_list_style_controls();
		$this->__title_style_controls();
		$this->__excerpt_style_controls();
	}
    protected function __post_list_style_controls () {

		$this->start_controls_section(
			'_section_post_list_style',
			[
				'label' => __( 'List', 'tsmentor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'list_item_common',
			[
				'label' => __( 'Common', 'tsmentor' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'list_item_margin',
			[
				'label' => __( 'Margin', 'tsmentor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ts-post-list .ts-post-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'list_item_padding',
			[
				'label' => __( 'Padding', 'tsmentor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ts-post-list .ts-post-list-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();
	}

	protected function __title_style_controls () {

		$this->start_controls_section(
			'_section_post_list_title_style',
			[
				'label' => __( 'Title', 'tsmentor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'tsmentor' ),
				'scheme' => Schemes\Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .ts-post-list-title',
			]
		);

		$this->start_controls_tabs( 'title_tabs' );
		$this->start_controls_tab(
			'title_normal_tab',
			[
				'label' => __( 'Normal', 'tsmentor' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'tsmentor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-post-list-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_hover_tab',
			[
				'label' => __( 'Hover', 'tsmentor' ),
			]
		);

		$this->add_control(
			'title_hvr_color',
			[
				'label' => __( 'Color', 'tsmentor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ts-post-list .ts-post-list-item a:hover .ts-post-list-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}
    
    protected function __excerpt_style_controls () {

		$this->start_controls_section(
			'_section_list_excerpt_style',
			[
				'label' => __( 'Content', 'tsmentor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content' => 'yes',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'label' => __( 'Typography', 'tsmentor' ),
				'scheme' => Schemes\Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .tsa-post-list-excerpt p',
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => __( 'Color', 'tsmentor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ts-post-list-excerpt p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_space',
			[
				'label' => __( 'Space Top', 'tsmentor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .ts-post-list-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['post_type'] ){
			return;
		}

		$args = [
			'post_status'      => 'publish',
			'post_type'        => $settings['post_type'],
			'suppress_filters' => false,
		];

		if ( 'recent' === $settings['show_post_by'] ) {
			$args['posts_per_page'] = $settings['posts_per_page'];
		}

		$customize_title = [];
		$ids = [];

		if ( 'selected' === $settings['show_post_by'] ) {
			$args['posts_per_page'] = -1;
			$lists = $settings['selected_list_' . $settings['post_type']];

			if ( ! empty( $lists ) ) {
				foreach ( $lists as $index => $value ) {
					//trim function to remove extra space before post ID
					if( is_array($value['post_id']) ){
						$post_id = ! empty($value['post_id'][0]) ? trim($value['post_id'][0]) : '';
					}else{
						$post_id = ! empty($value['post_id']) ? trim($value['post_id']) : '';
					}
					$ids[] = $post_id;
					if ( $value['title'] ) $customize_title[$post_id] = $value['title'];
				}
			}

			$args['post__in'] = (array) $ids;
			$args['orderby'] = 'post__in';
		}

		if ( 'selected' === $settings['show_post_by'] && empty( $ids ) ) {
			$posts = [];
		} else {
			$posts = get_posts( $args );
		}

		$this->add_render_attribute( 'wrapper', 'class', [ 'ts-post-list-wrapper' ] );
		$this->add_render_attribute( 'wrapper-inner', 'class', [ 'ts-post-list' ] );
		
		$this->add_render_attribute( 'item', 'class', [ 'ts-post-list-item' ] );

		if ( count( $posts ) !== 0 ) :?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<ul <?php $this->print_render_attribute_string( 'wrapper-inner' ); ?> >
					<?php foreach ( $posts as $post ): ?>
						<li <?php $this->print_render_attribute_string( 'item' ); ?>>
							<a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>">
								<?php if ( 'yes' === $settings['feature_image'] ):
									echo get_the_post_thumbnail( $post->ID, $settings['post_image_size'] );
								elseif ( 'yes' === $settings['list_icon'] && $settings['icon'] ) :
									echo '<span class="ts-post-list-icon">';
									Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
									echo '</span>';
								endif; ?>
								<div class="ts-post-list-content">
									<?php
									$title = $post->post_title;
									if ( 'selected' === $settings['show_post_by'] && array_key_exists( $post->ID, $customize_title ) ) {
										$title = $customize_title[$post->ID];
									}
									if (  $title ) {
										printf( '<%1$s %2$s>%3$s</%1$s>',
											ts_escape_tags( $settings['title_tag'], 'h2' ),
											'class="ts-post-list-title"',
											esc_html( $title )
										);
									}
									?>
									<?php if ( 'yes' === $settings['content'] ): ?>
										<div class="ts-post-list-excerpt">
											<?php
												if ( 'post' !== $settings['post_type'] && has_excerpt($post->ID) ) {
													printf('<p>%1$s</p>',
														wp_trim_words(get_the_excerpt($post->ID))
													);
												}else{
													printf('<p>%1$s</p>',
														wp_trim_words(get_the_content(null,false,$post->ID), 25, '.')
													);
												}
											?>
										</div>
									<?php endif; ?>
								</div>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php
		else:
			printf( '%1$s %2$s %3$s',
				__( 'No ', 'tsmentor' ),
				esc_html( $settings['post_type'] ),
				__( 'Found', 'tsmentor' )
			);
		endif;
	}
}