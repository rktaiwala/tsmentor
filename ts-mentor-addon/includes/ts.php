<?php

namespace TS;

use function class_exists;
use Elementor;
use Elementor\Plugin;

class Ts {


	private static $_instance = null;

	public $_hook_positions = [];

	public static $_helper = null;
	

	public static $module_manager = null;

	public static $_theme = null;

	public static $_widget_debug = false;

	

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function init() {

		//add_post_type_support( 'ae_global_templates', 'elementor' );
		//add_filter( 'widget_text', 'do_shortcode' );

		/**
		 *   Widget Debug Mode
		 **/
		self::$_widget_debug = apply_filters( 'ts/widget_debug', self::$_widget_debug );
	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {

		

		self::$_helper = new Helper();
		

		

	}
	public function get_frontend_file_url( $frontend_file_name, $custom_file ) {
		if ( $custom_file ) {
			//$frontend_file = $this->get_frontend_file( $frontend_file_name );

			//$frontend_file_url = $frontend_file->get_url();
		} else {
			$frontend_file_url = TS_MENTOR_ASSET_URL . 'css/' . $frontend_file_name;
		}

		return $frontend_file_url;
	}

	public function get_frontend_file_path( $frontend_file_name, $custom_file ) {
		if ( $custom_file ) {
			//$frontend_file = $this->get_frontend_file( $frontend_file_name );

			//$frontend_file_path = $frontend_file->get_path();
		} else {
			$frontend_file_path = TS_MENTOR_ASSET_PATH . 'css/' . $frontend_file_name;
		}

		return $frontend_file_path;
	}
}

Ts::instance();
