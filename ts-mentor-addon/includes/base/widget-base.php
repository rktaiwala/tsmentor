<?php

namespace TS\Base;

use TS\Ts;
abstract class Widget_Base extends \Elementor\Widget_Base {

    public function is_enabled() {

		return true;
	}
    
    public function is_debug_on() {

		if ( \TS\Ts::$_widget_debug ) {
			echo '<div class="ts-widget-debug ' . esc_html( $this->get_name() ) . '">' . esc_html( $this->get_title() ) . '</div>';
		}

		return \TS\Ts::$_widget_debug;
	}
    
    public function get_script_depends() {
        
        return [];
    }
    public function get_style_depends() {
        return [];
    }
}
