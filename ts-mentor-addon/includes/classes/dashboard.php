<?php

namespace TS\Classes;


class Dashboard {

    const PAGE_SLUG = 'ts-addons';

    //const WIZARD_PAGE_SLUG = 'ts-addons-setup-wizard';

    const LICENSE_PAGE_SLUG = 'ts-addons-license';

    const WIDGETS_NONCE = 'ts_save_dashboard';

    const WIZARD_NONCE = 'wp_rest';

    static $menu_slug = '';

    public static $catwise_widget_map = [];
    public static $catwise_free_widget_map = [];

    static $wizard_slug = '';

    public static function init() {
        add_action( 'admin_menu', [ __CLASS__, 'add_menu' ], 21 );
        add_action( 'admin_menu', [ __CLASS__, 'update_menu_items' ], 99 );
        //add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
        add_action( 'wp_ajax_' . self::WIDGETS_NONCE, [ __CLASS__, 'save_data' ] );

        //add_action( 'admin_init', [ __CLASS__, 'activation_redirect' ] );
        add_filter( 'plugin_action_links_' . plugin_basename( TS_MENTOR_FILE ), [ __CLASS__, 'add_action_links' ] );

        //add_action( 'ts_save_dashboard_data', [ __CLASS__, 'save_widgets_data' ], 1);
        //add_action( 'ts_save_dashboard_data', [ __CLASS__, 'save_features_data' ] );
        //add_action( 'ts_save_dashboard_data', [ __CLASS__, 'save_credentials_data' ] );
        //add_action( 'ts_save_dashboard_data', [ __CLASS__, 'disable_unused_widget' ], 10);

        add_action( 'in_admin_header', [ __CLASS__, 'remove_all_notices' ], PHP_INT_MAX );

        
    }

    public static function is_page() {
        return ( isset( $_GET['page'] ) && ( $_GET['page'] === self::PAGE_SLUG || $_GET['page'] === self::LICENSE_PAGE_SLUG ) );
    }

    public static function remove_all_notices() {
        if ( self::is_page() ) {
            remove_all_actions( 'admin_notices' );
            remove_all_actions( 'all_admin_notices' );
        }
    }

    

    public static function add_action_links( $links ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return $links;
        }

        $links = array_merge( [
            sprintf( '<a href="%s">%s</a>',
                ts_get_dashboard_link(),
                esc_html__( 'Settings', 'tsmentor' )
            )
        ], $links );
        if ( ! ts_has_pro() ) {
            $links = array_merge( $links, [
                sprintf( '<a target="_blank" style="color:#e2498a; font-weight: bold;" href="%s">%s</a>',
                    'https://techsarathy.com/go/get-pro',
                    esc_html__( 'Get Pro', 'tsmentor' )
                )
            ] );
        }
        return $links;
    }

    public static function render_main() {
        self::load_template( 'main' );
    }
    public static function render_home() {
        self::load_template( 'home' );
    }
    private static function load_template( $template ) {
        $file = TS_MENTOR_PATH_INCLUDES . 'templates/admin/dashboard-' . $template . '.php';
        if ( is_readable( $file ) ) {
            include( $file );
        }
    }

    private static function load_wizard_template( $template ) {
        $file = TS_MENTOR_PATH_INCLUDES . 'templates/wizard/wizard-' . $template . '.php';
        if ( is_readable( $file ) ) {
            include( $file );
        }
    }
    public static function get_tabs() {
        $tabs = [
            'home' => [
                'title' => esc_html__( 'Home', 'ts-elementor-addons' ),
                'renderer' => [ __CLASS__, 'render_home' ],
            ],
            
        ];

        return apply_filters( 'happyaddons_dashboard_get_tabs', $tabs );
    }
    public static function add_menu() {
        self::$menu_slug = add_menu_page(
            __( 'TS Elementor Addons Dashboard', 'ts-elementor-addons' ),
            __( 'TS Addons', 'ts-elementor-addons' ),
            'manage_options',
            self::PAGE_SLUG,
            [ __CLASS__, 'render_main' ],
            ts_get_b64_icon(),
            58.5
        );

        

        $tabs = self::get_tabs();
        if ( is_array( $tabs ) ) {
            foreach ( $tabs as $key => $data ) {
                if ( empty( $data['renderer'] ) || ! is_callable( $data['renderer'] ) ) {
                    continue;
                }

                add_submenu_page(
                    self::PAGE_SLUG,
                    sprintf( __( '%s - TS Elementor Addons', 'ts-elementor-addons' ), $data['title'] ),
                    $data['title'],
                    'manage_options',
                    self::PAGE_SLUG . '#' . $key,
                    [ __CLASS__, 'render_main' ]
                );
            }
        }
    }

    public static function update_menu_items() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        global $submenu;
        $menu = $submenu[ self::PAGE_SLUG ];
        array_shift( $menu );
        $submenu[ self::PAGE_SLUG ] = $menu;
    }

    /**
	 * Set up a div for the app to render into.
	 */
	public static function wizard_page_wrapper() {
		?>
		<div class="wrap" id="ha-setup-wizard">
            <div id="loader-wrap" v-if="!loaded">
                <div class="loader">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
			<div id="wizard-root" :class="{ visible: loaded }">
                <div class="ha-setup-wizard__header">
                    <div class="ha-stepper">
                        <div class="ha-stepper__steps">
                            <ha-step
                                v-for="(step, index) in steps"
                                :active="currentPage"
                                :complete="step.isComplete"
                                :step="step.key"
                                :title="step.name"
                                :index="index+1"
                                @set-tab="setTab">
                            </ha-step>
                        </div>
                    </div>
                </div>
                <div class="ha-setup-wizard__container">
                    <div class="ha-setup-wizard__container_content">
                       
                    </div>
                </div>
            </div>
		</div>
		<?php
	}
}


