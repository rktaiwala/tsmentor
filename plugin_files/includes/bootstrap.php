<?php

namespace TS;
use TS\Classes\ModuleManager;
class Plugin
{

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

		
		
        
        add_action('elementor/init', [$this, 'add_elementor_support']);
        add_action( 'plugins_loaded', [ $this, 'ts_plugins_loaded' ], 11 );
        

    }

    public function ts_plugins_loaded(){
        
        if ( ! did_action( 'elementor/loaded' ) ) {
			/* TO DO */
            
			add_action( 'admin_notices', [ $this, 'ts_pro_fail_load' ] );
			return;
		}
        $this->get_ts_contants();
        self::$module_manager = new ModuleManager();
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
        
       $paths=['/includes/base','/includes/classes','/includes/modules'];
        foreach($paths as $path){
            $dir      = new \RecursiveDirectoryIterator(TS_PRO_PATH.$path);
            $iterator = new \RecursiveIteratorIterator($dir);
            foreach ($iterator as $file) {
                $fname = $file->getFilename();
                if (preg_match('%\.php$%', $fname)) {
                    //echo $fname;
                    include($file->getPathname());
                }
            }
        }
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