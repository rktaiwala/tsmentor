<?php
/**
 * Plugin Name: Techsarathy Elementor Addon
 * Description: Related Products by current category for Elementor.
 * Version:     1.0.0
 * Author:      rktaiwala
 * Author URI:  https://techsarathy.com/
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
define( 'TS_MENTOR_VERSION', '2.25' );
define( 'TS_MENTOR_URL', plugins_url( '/', __FILE__ ) );
define( 'TS_MENTOR_ASSET_URL', TS_MENTOR_URL.'/assets/' );
define( 'TS_MENTOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'TS_MENTOR_PATH_INCLUDES', TS_MENTOR_PATH.'includes/' );
define( 'TS_MENTOR_ASSET_PATH', TS_MENTOR_PATH.'assets/' );
define( 'TS_MENTOR_PATH_MODULES', TS_MENTOR_PATH_INCLUDES.'modules' );
define( 'TS_MENTOR_BASE', plugin_basename( __FILE__ ) );
define( 'TS_MENTOR_FILE', __FILE__ );
define( 'TS_MENTOR_UPLOAD_DIR', 'tsmentor' );
//function ts_mentor_addon() {
if( !function_exists('is_plugin_active') ) { 
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}  
    if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
        return;
    }else{
        //$files = glob( TS_PRO_PATH . '/includes/base/*.php');
        //array_merge($files, glob( TS_PRO_PATH . '/includes/classes/*.php'));
        //foreach ($files as $file) {
       //     require($file);   
       // }
        
        require_once TS_MENTOR_PATH . 'vendor/autoload.php';
        require TS_MENTOR_PATH . 'includes/bootstrap.php';
    }
	

//}
//add_action( 'plugins_loaded', 'ts_mentor_addon' );
