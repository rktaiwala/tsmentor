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
    /**
     * Register widget controls
     */
    protected function register_controls() {
        do_action( 'tsmentor_start_register_controls', $this );

        $this->register_content_controls();

        $this->register_style_controls();

        do_action( 'tsmentor_end_register_controls', $this );
	}

    /**
     * Register content controls
     *
     * @return void
     */
    abstract protected function register_content_controls();

    /**
     * Register style controls
     *
     * @return void
     */
    abstract protected function register_style_controls();

}
