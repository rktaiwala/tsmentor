<?php

namespace TS\Controls;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Control_Select2;
use Elementor\Modules\DynamicTags\Module as TagsModule;

class TS_Query extends Control_Select2
{
    public function get_type()
    {
        return 'ts_query';
    }

	public function enqueue() {
		wp_register_script( 'ts-query', TS_MENTOR_ASSET_URL . '/js/edit/ts-query.min.js',
			[ ], '1.0.1', true );
		
		wp_enqueue_script( 'ts-query' );
	}

    protected function get_default_settings()
    {
         return ['dynamic' => ['active' => true, 'categories' => [TagsModule::BASE_GROUP, TagsModule::TEXT_CATEGORY, TagsModule::NUMBER_CATEGORY]]];
    }

    public function content_template()
    {
        $control_uid = $this->get_control_uid();
        ?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
				<label for="<?php 
        echo $control_uid;
        ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-dynamic-switcher-wrapper">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select id="<?php 
        echo $control_uid;
        ?>" class="elementor-select2 elementor-control-tag-area" type="select2" {{ multiple }} data-setting="{{ data.name }}">
					<# _.each( data.options, function( option_title, option_value ) {
						var value = data.controlValue;
						if ( typeof value == 'string' ) {
							var selected = ( option_value === value ) ? 'selected' : '';
						} else if ( null !== value ) {
							var value = _.values( value );
							var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
						}
						#>
					<option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
					<# } ); #>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php 
    }
}