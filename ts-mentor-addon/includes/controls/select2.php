<?php

namespace TS\Controls;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Base_Data_Control;

class Select2 extends Base_Data_Control
{
    public function get_type()
    {
        return 'ts-select2';
    }

	public function enqueue() {
		wp_register_script( 'ts-select2', TS_MENTOR_ASSET_URL . '/js/edit/select2.js',
			[ 'jquery-elementor-select2' ], '1.0.1', true );
		wp_localize_script(
			'ts-select2',
			'ts_select2_localize',
			[
				'ajaxurl'         => esc_url( admin_url( 'admin-ajax.php' ) ),
				'search_text'     => esc_html__( 'Search', 'tsmentor' ),
				'remove'          => __( 'Remove', 'tsmentor' ),
				'thumbnail'       => __( 'Image', 'tsmentor' ),
				'name'            => __( 'Title', 'tsmentor' ),
				'price'           => __( 'Price', 'tsmentor' ),
				'quantity'        => __( 'Quantity', 'tsmentor' ),
				'subtotal'        => __( 'Subtotal', 'tsmentor' ),
				'cl_login_status' => __( 'User Status', 'tsmentor' ),
				'cl_post_type'    => __( 'Post Type', 'tsmentor' ),
				'cl_browser'      => __( 'Browser', 'tsmentor' ),
				'cl_date_time'    => __( 'Date & Time', 'tsmentor' ),
				'cl_dynamic'      => __( 'Dynamic Field', 'tsmentor' ),
			]
		);
		wp_enqueue_script( 'ts-select2' );
	}

    protected function get_default_settings()
    {
        return [
            'multiple' => false,
            'source_name' => 'post_type',
            'source_type' => 'post',
        ];
    }

    public function content_template()
    {
        $control_uid = $this->get_control_uid();
        ?>
        <# var controlUID = '<?php echo esc_html( $control_uid ); ?>'; #>
        <# var currentID = elementor.panel.currentView.currentPageView.model.attributes.settings.attributes[data.name]; #>
        <div class="elementor-control-field">
            <# if ( data.label ) { #>
            <label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{data.label }}}</label>
            <# } #>
            <div class="elementor-control-input-wrapper elementor-control-unit-5">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
                <select id="<?php echo esc_attr( $control_uid ); ?>" {{ multiple }} class="ts-select2" data-setting="{{ data.name }}"></select>
            </div>
        </div>
        <#
        ( function( $ ) {
        $( document.body ).trigger( 'ts_select2_init',{currentID:data.controlValue,data:data,controlUID:controlUID,multiple:data.multiple} );
        }( jQuery ) );
        #>
        <?php
    }
}