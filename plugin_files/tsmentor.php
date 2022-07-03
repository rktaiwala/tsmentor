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
define( 'TS_PRO_VERSION', '2.25' );
define( 'TS_PRO_URL', plugins_url( '/', __FILE__ ) );
define( 'TS_PRO_PATH', plugin_dir_path( __FILE__ ) );
define( 'TS_PRO_BASE', plugin_basename( __FILE__ ) );
define( 'TS_PRO_FILE', __FILE__ );
//function ts_mentor_addon() {
    
    if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
        return;
    }else{
        //$files = glob( TS_PRO_PATH . '/includes/base/*.php');
        //array_merge($files, glob( TS_PRO_PATH . '/includes/classes/*.php'));
        //foreach ($files as $file) {
       //     require($file);   
       // }
        
        require_once TS_PRO_PATH . 'vendor/autoload.php';
        require TS_PRO_PATH . 'includes/bootstrap.php';
    }
	

//}
//add_action( 'plugins_loaded', 'ts_mentor_addon' );
