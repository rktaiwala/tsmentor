<?php
/*
Widget Name: Related Products Current Category
Type: widget
Enabled: true
Dir: woocommerce
*/
namespace TS\Modules\Woocommerce\Widgets;
use TS\Base\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;
use TS\Modules\Woocommerce\Module;
class TsWooRpByCat extends Widget_Base {
    const DEFAULT_COLUMNS_AND_ROWS = 4;
	public function get_name() {
		return 'ts_related_products';
	}

	public function get_title() {
		return esc_html__( 'Related Products Current Category', 'elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'ts-addons' ];
	}

	public function get_keywords() {
		return [ 'products', 'related' ];
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
    protected function register_content_controls(){
        $this->__ts_register_controls();
    }
    protected function register_style_controls(){
        
    }
    protected function __ts_register_controls() {

		// Content Tab Start

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'elementor-pro' ),
			]
		);

		$this->add_columns_responsive_control();

		$this->add_control(
			'rows',
			[
				'label' => esc_html__( 'Rows', 'elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => self::DEFAULT_COLUMNS_AND_ROWS,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'max' => 20,
					],
				],
			]
		);

		$this->add_control(
			'paginate',
			[
				'label' => esc_html__( 'Pagination', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				
			]
		);

		$this->add_control(
			'allow_order',
			[
				'label' => esc_html__( 'Allow Order', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);

		$this->add_control(
			'wc_notice_frontpage',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Ordering is not available if this widget is placed in your front page. Visible on frontend only.', 'elementor-pro' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition' => [
					'paginate' => 'yes',
					'allow_order' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_result_count',
			[
				'label' => esc_html__( 'Show Result Count', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);

		$this->end_controls_section();

	}
	protected function render() {
		if ( WC()->session ) {
			wc_print_notices();
		}

		$settings = $this->get_settings_for_display();
        $content = Module::get_products_related_content( $settings );
        if ( $content ) {
			$content = str_replace( '<ul class="products', '<ul class="products elementor-grid', $content );

			// PHPCS - Woocommerce output
			echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} 
	}
}