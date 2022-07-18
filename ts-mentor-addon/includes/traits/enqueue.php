<?php

namespace TS\Traits;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

use \Essential_Addons_Elementor\Classes\Helper as EnqueueHelper;

trait Enqueue
{
   

    public function enqueue_scripts()
    {
        if (!apply_filters('tsmentor/is_plugin_active', 'elementor/elementor.php')) {
            return;
        }

        if ($this->is_running_background()) {
            return;
        }

        if ($this->uid === null) {
            return;
        }
		//fix asset loading issue if no custom elementor css is not used.
	    $this->loaded_templates[] = get_the_ID();
        

	    // localize object
	    $this->localize_objects = apply_filters( 'tsmentor/localize_objects', [
		    'ajaxurl'        => admin_url( 'admin-ajax.php' ),
		    'nonce'          => wp_create_nonce( 'tsmentor' ),
		    'page_permalink' => get_the_permalink(),
            'cart_redirectition' => get_option( 'woocommerce_cart_redirect_after_add' ),
            'cart_page_url' =>  apply_filters('tsmentor/is_plugin_active', 'woocommerce/woocommerce.php') ? wc_get_cart_url():'',
	    ] );

        wp_enqueue_script(
            $this->uid.'gen',
            $this->safe_url(TS_MENTOR_ASSET_URL . '/js/general.min.js'),
            false,
            time()
        );
            
        if(is_admin()){
            wp_enqueue_style(
                $this->uid.'main',
                $this->safe_url(TS_MENTOR_ASSET_URL . '/admin/css/tsmentor.css'),
                false,
                time()
            );

        }
        // edit mode
        /*if ($this->is_edit_mode()) {
            $widgets = $this->module_manager->get_modules();

            // if no widget in page, return
            if (empty($widgets)) {
                return;
            }

            // run hook before enqueue scripts
            do_action('tsmentor/before_enqueue_scripts', $widgets);
            foreach($widgets  as $group => $widget ) {

				foreach ( $widget['modules'] as $modulekey => $module ) {
                   
					if ( $module['enabled'] ) {
						$class_name = str_replace( '-', ' ', $modulekey );
						$class_name = str_replace( ' ', '', ucwords( $class_name ) );
						$class_name = 'TS\Modules\\' . $class_name . '\Module';
						$enqueable=$class_name::get_enqueuable();
						
					}
                    if(empty($enqueable)) continue;
                    
                    foreach($enqueable as $type=>$enqueue){
                        
                        if($type=='css'){
                            // enqueue
                            foreach($enqueue as $style){
                                wp_enqueue_style(
                                    $this->uid.$style['name'],
                                    $this->safe_url(TS_MENTOR_ASSET_URL . '/css/' . $style['file']. '.css'),
                                    false,
                                    time()
                                );
                            }
                            
                        }
                        if($type=='js'){
                            foreach($enqueue as $script){
                                wp_enqueue_script(
                                    $this->uid.$script['name'],
                                    $this->safe_url(TS_MENTOR_ASSET_URL . '/js/' . $script['file']. '.js'),
                                    false,
                                    time()
                                );
                            }
                            
                        }
                        
                    }
                    
                    
				}
                
            }
            
            

            
        }*/
            
    }
    

    // editor styles
    public function editor_enqueue_scripts()
    {
        // ea icon font
        wp_enqueue_style(
            'ts-icon',
            $this->safe_url(TS_MENTOR_URL . 'assets/admin/css/tsicon.css'),
            false,
	        TS_MENTOR_VERSION
        );

        
    }

    // inline enqueue styles
    public function enqueue_inline_styles()
    {
        if ($this->is_edit_mode() || $this->is_preview_mode()) {
            if ($this->css_strings) {
	            printf( '<style id="%1$s">%2$s</style>', esc_attr( $this->uid ), $this->css_strings );
            }
        }
    }

    // inline enqueue scripts
    public function enqueue_inline_scripts()
    {
        // view/edit mode mode
        if ($this->is_edit_mode() || $this->is_preview_mode()) {
            if ($this->js_strings) {
                printf('<script>%1$s</script>','var localize ='.wp_json_encode($this->localize_objects));
	            printf( '<script id="%1$s">%2$s</script>', esc_attr( $this->uid ), $this->js_strings );
            }
        }
    }

    

   
}