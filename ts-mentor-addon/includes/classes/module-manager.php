<?php

namespace TS\Classes;

use Elementor\Controls_Manager;


class ModuleManager {


	const TAB_TS_PRO = 'tab_ts_pro';

	private $modules = [];

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
    /**
	 * Register custom controls
	 *
	 * @since v4.4.2
	 */
	public function register_controls( $controls_manager ) {
		if ( version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) {
			$controls_manager->register( new \TS\Controls\Select2() );
		} else {
			$controls_manager->register_control( 'eael-select2', new \TS\Controls\Select2() );
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
		$this->modules = [];
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
            $this->modules[$wid_key] = [
                'label'   => __( $wid_data['Name'], 'tsmentor' ),
                'modules' => [
                    $wid_data['Dir'] => [
                        'label'         => __( $wid_data['Name'], 'tsmentor' ),
                        'type'          => $wid_data['Type'],
                        'enabled'       => $wid_data['Enabled'],

                    ],


                ],
            ];
            
        }
		$saved_modules = get_option( 'tsmentor_modules' );

		if ( $saved_modules !== false ) {
			foreach ( $this->modules as $group => $modules ) {

				foreach ( $modules['modules'] as $modulekey => $moduleName ) {

					if ( isset( $saved_modules[ $modulekey ] ) ) {
						$this->modules[ $group ]['modules'][ $modulekey ]['enabled'] = $saved_modules[ $modulekey ];
					} else {
						$this->modules[ $group ]['modules'][ $modulekey ]['enabled'] = true;
					}
				}
			}
		}

		$this->modules = apply_filters( 'wts_ts_active_modules', $this->modules );
	}

	public function get_modules() {
		return $this->modules;
	}

	public function elementor_widget_registered() {
		$modules = $this->modules;
		

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
