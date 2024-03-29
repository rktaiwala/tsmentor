<?php

namespace TS\Classes;

use Elementor\Controls_Manager;


class ModuleManager {


	const TAB_TS_MENTOR = 'tab_ts_mentor';
    const WIDGETS_DB_KEY = 'tsmentor_inactive_widgets';
	private static $modules = [];

	public function __construct() {

		$this->init_modules();
		$this->elementor_widget_registered();

		//add_filter( 'elementor/init', [ $this, 'add_ts_tab' ], 10, 1 );

		add_action( 'wp_ajax_aep_module', [ $this, 'save_modules' ] );

		add_action( 'wp_ajax_aep_save_config', [ $this, 'save_config' ] );

		add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ], -999 );
        if ( defined( 'ELEMENTOR_VERSION' ) ) {
		    if ( version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) {
			    add_action( 'elementor/controls/register', array( $this, 'register_controls' ) );
		    } else {
			    add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );
		    }
	    }
		
	}

    public static function get_inactive_widgets() {
		 return get_option( self::WIDGETS_DB_KEY, [] );
	}

	public static function save_inactive_widgets( $widgets = [] ) {
		update_option( self::WIDGETS_DB_KEY, $widgets );
	}
    /**
	 * Register custom controls
	 *
	 * @since v4.4.2
	 */
	public function register_controls( $controls_manager ) {
		if ( version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) {
			$controls_manager->register( new \TS\Controls\Select2() );
			$controls_manager->register( new \TS\Controls\Lazy_Select() );
			$controls_manager->register( new \TS\Controls\TS_Query() );
            $controls_manager->register( new \TS\Controls\Pdf_Select() );
		} else {
			$controls_manager->register_control( 'ts-select2', new \TS\Controls\Select2() );
			$controls_manager->register_control( 'ts-lazy-select', new \TS\Controls\Lazy_Select() );
			$controls_manager->register_control( 'ts_query', new \TS\Controls\TS_Query() );
            $controls_manager->register_control( 'ts-pdf-select', new \TS\Controls\Pdf_Select() );
		}
	}

	public function register_category($elements_manager) {
		$elements_manager->add_category(
			'ts-addons',
            [
                'title' => 'TS Addons',
                'icon'  => 'fa fa-plug',
            ],
			1
		);
	}

    
    
	public function init_modules() {
		// Test Work
		self::$modules = [];
        $scaned_widgets=scan_widgets();
        
	   /*$this->modules['woocommerce'] = [
			'label'   => __( 'WooCommerce Integration', 'tsmentor' ),
			'modules' => [
				'woocommerce' => [
					'label'         => __( 'WooCommerce Widgets', 'tsmentor' ),
					'type'          => 'widget',
					'enabled'       => true,
					'not-available' => __( "Requires 'WooCommerce' plugin installed and activated", 'tsmentor' ),
				],

				
			],
		];
        $this->modules['advancetabs'] = [
			'label'   => __( 'Advance Tabs', 'tsmentor' ),
			'modules' => [
				'advancetabs' => [
					'label'         => __( 'Tabs Widgets', 'tsmentor' ),
					'type'          => 'widget',
					'enabled'       => true,
				],

				
			],
		];*/
        foreach($scaned_widgets as $wid_key=>$wid_data){
            self::$modules[$wid_key] = [
                'label'   => __( $wid_data['Name'], 'tsmentor' ),
                'modules' => [
                    $wid_data['Dir'] => [
                        'label'         => __( $wid_data['Name'], 'tsmentor' ),
                        'type'          => $wid_data['Type'],
                        'enabled'       => $wid_data['Enabled'],
                        'icon'       => $wid_data['Icon'],

                    ],


                ],
            ];
            
        }
		$saved_modules = get_option( 'tsmentor_modules' );

		if ( $saved_modules !== false ) {
			foreach ( self::$modules as $group => $modules ) {

				foreach ( $modules['modules'] as $modulekey => $moduleName ) {

					if ( isset( $saved_modules[ $modulekey ] ) ) {
						self::$modules[ $group ]['modules'][ $modulekey ]['enabled'] = $saved_modules[ $modulekey ];
					} else {
						self::$modules[ $group ]['modules'][ $modulekey ]['enabled'] = true;
					}
				}
			}
		}

		self::$modules = apply_filters( 'wts_ts_active_modules', self::$modules );
	}

	public static function get_modules() {
		return self::$modules;
	}

	public function elementor_widget_registered() {
		$modules = self::$modules;
		

		foreach ( $modules as $group ) {

			if ( is_array( $group['modules'] ) && count( $group['modules'] ) ) {

				foreach ( $group['modules'] as $key => $value ) {

					if ( $value['enabled'] ) {
						$class_name = str_replace( '-', ' ', $key );
						$class_name = str_replace( ' ', '', ucwords( $class_name ) );
						$class_name = 'TS\Modules\\' . $class_name . '\Module';
						$class_name::instance();
					}
				}
			}
		}
	}

	public function add_ae_tab() {
		Controls_Manager::add_tab( self::TAB_AE_PRO, __( 'TS PRO', 'ae-pro' ) );
	}

	public function save_modules() {
		$module_data = $_POST['moduleData'];

		// get saved modules
		$saved_modules = get_option( 'tsmentor_modules' );

		foreach ( $module_data as $key => $action ) {

			if ( $action === 'deactivate' ) {
				$saved_modules[ $key ] = false;
			} else {
				$saved_modules[ $key ] = true;
			}
		}

		update_option( 'tsmentor_modules', $saved_modules );

		wp_send_json(
			[
				'modules' => $saved_modules,
			]
		);
	}


	public function save_config() {
		check_ajax_referer( 'ts_ajax_nonce', 'nonce' );

		$gmap_api = sanitize_text_field( $_POST['config']['ts_pro_gmap_api'] );

		update_option( 'ts_pro_gmap_api', trim( $gmap_api ) );

		wp_send_json(
			[
				'success' => 1,
			]
		);
	}
}
