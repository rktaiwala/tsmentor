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
	
}

Ts::instance();
