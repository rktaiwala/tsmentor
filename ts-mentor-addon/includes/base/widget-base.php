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
    protected function get_enq_list(){}
    public function get_script_depends() {
         $scripts=[];
        $enqueable=$this->get_enq_list();
        if(!empty($enqueable)){
            foreach($enqueable as $type=>$enqueue){
                if(empty($enqueue)) continue;
                if($type=='js'){
                    // enqueue
                    foreach($enqueue as $script){
                        if(isset($script['file']) && !isset($script['elementor'])){
                            $dependent=[];
                            if(isset($script['dependent'])){
                                if(!is_array($script['dependent'])){
                                    $dependent=array($script['dependent']);
                                }else{
                                    $dependent=$script['dependent'];
                                }
                            }
                            $this->ts_register_script($script['name'],(TS_MENTOR_ASSET_URL . '/js/' . $script['file']. '.js'),$dependent);
                           
                            $scripts[]=$script['name'];
                            
                        }else if(isset($script['file']) && (isset($script['elementor']))){
                            $this->ts_register_script($script['name'],$script['file']);
                            
                        }else{
                            $scripts[]=$script['name'];
                        }
                        
                    }

                }
            }
        }
        return $scripts;
    }
    private function ts_register_script($name,$url,$dependent=[]){
         wp_register_script($name,$url,$dependent,TS_MENTOR_VERSION, true);
    }
    public function get_style_depends() {
        $styles=[];
        $enqueable=$this->get_enq_list();
        if(!empty($enqueable)){
            foreach($enqueable as $type=>$enqueue){
                if(empty($enqueue)) continue;
                if($type=='css'){
                    // enqueue
                    foreach($enqueue as $style){
                        wp_register_style(
                            $style['name'],
                            (TS_MENTOR_ASSET_URL . '/css/' . $style['file']. '.css'),
                            false,
                        );
                        $styles[]=$style['name'];
                    }

                }
            }
        }
        return $styles;
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
    
    final public function get_unescaped_setting( $setting, $repeater_name = null, $index = null ) {
		if ( $repeater_name ) {
			$repeater = $this->get_settings_for_display( $repeater_name );
			$output = $repeater[ $index ][ $setting ];
		} else {
			$output = $this->get_settings_for_display( $setting );
		}

		return $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
    public function get_widget_css_config( $widget_name ) {
		$direction = is_rtl() ? '-rtl' : '';

		$has_custom_breakpoints = $this->is_custom_breakpoints_widget();

		$file_name = 'widget-' . $widget_name . $direction . '.min.css';

		// The URL of the widget's external CSS file that is loaded in case that the CSS content is too large to be printed inline.
		$file_url = Ts::instance()->get_frontend_file_url( $file_name, $has_custom_breakpoints );

		// The local path of the widget's CSS file that is being read and saved in the DB when the CSS content should be printed inline.
		$file_path = Ts::instance()->get_frontend_file_path( $file_name, $has_custom_breakpoints );

		return [
			'key' => $widget_name,
			'version' => TS_MENTOR_VERSION,
			'file_path' => $file_path,
			'data' => [
				'file_url' => $file_url,
			],
		];
	}
}
