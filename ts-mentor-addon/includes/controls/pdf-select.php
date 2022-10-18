<?php

namespace TS\Controls;

use Elementor\Base_Data_Control;
use TS\Classes\Pdf_Select_Manager;

defined( 'ABSPATH' ) || die();

class Pdf_Select extends Base_Data_Control {

	/**
	 * Control identifier
	 */
	const TYPE = 'ts-pdf-select';

	/**
	 * Set control type.
	 */
	public function get_type() {
		return self::TYPE;
	}

	/**
	 * Enqueue control scripts and styles.
	 */
	public function enqueue() {
        wp_enqueue_media();
		wp_enqueue_script(
			'ts-pdf-select',
			TS_MENTOR_ASSET_URL . '/js/edit/pdf-select.min.js',
			['jquery'],
			TS_MENTOR_VERSION
		);
        wp_enqueue_script(
			'ts-pdf-js',
			'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js',
			['jquery'],
			TS_MENTOR_VERSION
		);
        
        
		wp_localize_script(
			'ts-pdf-select',
			'ts_pdf_select',
			[
                'nonce' => wp_create_nonce( Pdf_Select_Manager::ACTION ),
				'action' => Pdf_Select_Manager::ACTION,
				'ajax_url' => admin_url( 'admin-ajax.php' )
			]
		);
	}

	/**
	 * Get select2 control default settings.
	 *
	 * Retrieve the default settings of the select2 control. Used to return the
	 * default settings while initializing the select2 control.
	 *
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'label_block' => true,
            'library_type'=> 'application/pdf',
            'thumbnail' =>''
		];
	}

	/**
	 * Render select2 control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
            <# console.log(data) #>
			<# if ( data.label ) {#>
			<label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<# if ( !!data.controlValue.thumbnail ) { #>
                    <img src='{{{ data.controlValue.thumbnail}}}'>
					<small style="display:block; width:100%; padding-top:7px;">
						{{{ data.controlValue.pdf }}}
					</small>
				<# } #>
				
				<div class="elementor-control-input-wrapper"
					style="display:flex; margin-right:-10px; width:calc( 100% + 10px );">
					<div style="flex-grow:1;">
						<a href="#"
							class="tnc-select-file elementor-button elementor-button-success"
							style="padding:10px 15px; text-align:center; display:block; margin-right:10px;"
							id="select-file-<?php echo esc_attr( $control_uid ); ?>">
							<# if ( !data.controlValue.pdf ) { #>
								<?php echo __("Select"); ?>
							<# } #>
							<# if ( !!data.controlValue.pdf ) { #>
								<?php echo __("Edit"); ?>
							<# } #>
						</a>
					</div>

					<# if ( !!data.controlValue.pdf ) { #>
						<div style="flex-shrink:1;">
							<a href="{{{ data.controlValue }}}" target="_blank"
								class="tnc-view-file elementor-button elementor-button-warning"
								style="padding:10px 15px; text-align:center; margin-right:10px;"
								id="select-file-<?php echo esc_attr( $control_uid ); ?>-link"
								title="<?php echo __("View"); ?>">
								<i class="eicon-link" style="margin-right:0;"></i>
							</a>
							<a href="#"
								class="tnc-remove-file elementor-button elementor-button-danger"
								style="padding:10px 15px; text-align:center; margin-right:10px;"
								id="select-file-<?php echo esc_attr( $control_uid ); ?>-remove"
								title="<?php echo __("Remove"); ?>">
								<i class="eicon-trash" style="margin-right:0;"></i>
							</a>
						</div>
					<# } #>
					
					<input type="hidden"
						class="tnc-selected-fle-url"
						id="<?php echo esc_attr( $control_uid ); ?>"
						data-setting="{{ data.name }}"
						placeholder="{{ data.placeholder }}">
                    <input type="hidden"
						class="tnc-selected-fle-thumbnail"
						id="<?php $this->print_control_uid( 'thumbnail' ); ?>"
						data-setting="thumbnail"
						>
				</div>
			
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
