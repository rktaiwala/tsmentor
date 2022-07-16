<?php

namespace TS;
use TS\Classes\ModuleManager;
use TS\Classes\Dashboard;
use TS\Traits\Core;
use TS\Traits\Generator;
use TS\Traits\Enqueue;
class Plugin
{
    use Core;
    use Generator;
    use Enqueue;
    
    // request unique id container
    protected $uid = null;
    
    // used for internal css
    protected $css_strings;

    // used for internal js
    protected $js_strings;

    // used to store custom js
    protected $custom_js_strings;
    
    public static $module_manager = null;
    private static $_instance = null;

	public static $_level = 0;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {		
        $this->includes();
        add_action('elementor/init', [$this, 'add_elementor_support']);
        add_action( 'plugins_loaded', [ $this, 'ts_plugins_loaded' ], 11 );
        
        // register hooks
        
    }

    protected function register_hooks()
    {
        // Core
        //add_action('init', [$this, 'i18n']);
        // TODO::RM
        //add_filter('eael/active_plugins', [$this, 'is_plugin_active'], 10, 1);

        add_filter('tsmentor/is_plugin_active', [$this, 'is_plugin_active'], 10, 1);
        //add_action('elementor/editor/after_save', array($this, 'save_global_values'), 10, 2);
        //add_action('trashed_post', array($this, 'save_global_values_trashed_post'), 10, 1);

        // Enqueue
        //add_action('eael/before_enqueue_styles', [$this, 'before_enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'editor_enqueue_scripts']);
        add_action('wp_head', [$this, 'enqueue_inline_styles']);
        add_action('wp_footer', [$this, 'enqueue_inline_scripts']);

        // Generator
        add_action('wp', [$this, 'init_request_data']);
        //add_filter('elementor/frontend/builder_content_data', [$this, 'collect_loaded_templates'], 10, 2);
        //add_action('wp_print_footer_scripts', [$this, 'update_request_data']);

	    
	    
        


    }
    public function ts_plugins_loaded(){
        
        if ( ! did_action( 'elementor/loaded' ) ) {
			/* TO DO */
            
			add_action( 'admin_notices', [ $this, 'ts_pro_fail_load' ] );
			return;
		}
        $this->get_ts_contants();
        self::$module_manager = new ModuleManager();
        Dashboard::init();
        $this->register_hooks();
    }
    
    public function ts_pro_fail_load() {

		$plugin = 'elementor/elementor.php';

		if ( _is_elementor_installed() ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			$message      = sprintf( __( '<b>Techsarathy Addons Pro</b> is not working because you need to activate the <b>Elementor</b> plugin.', 'ae-pro' ), '<strong>', '</strong>' );
			$action_url   = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
			$button_label = __( 'Activate Elementor', 'ae-pro' );
		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}
			$message      = sprintf( __( '<b>Techsarathy Addons Pro</b> is not working because you need to install the <b>Elementor</b> plugin.', 'ae-pro' ), '<strong>', '</strong>' );
			$action_url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$button_label = __( 'Install Elementor', 'ae-pro' );
		}

		$button = '<p><a href="' . $action_url . '" class="button-primary">' . $button_label . '</a></p><p></p>';

		printf( esc_html( '<div class="%1$s"><p>%2$s</p>%3$s</div>' ), 'notice notice-error',  $message ,  $button  );
	}
    
    private function includes()
    {
		include_once( TS_PRO_PATH_INCLUDES . 'func/functions.php' );
    }

    public function get_ts_contants(){
        if (is_plugin_active( 'woocommerce/woocommerce.php' )) {
			define('TS_WOO', true);
		} else {
			define('TS_WOO', false);
		}
    }
    public function add_elementor_support()
    {

        //$this->includes();
        
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'ts-addons',
            [
                'title' => 'TS Addons',
                'icon'  => 'fa fa-plug',
            ],
            1
        );
    }
}

Plugin::instance();