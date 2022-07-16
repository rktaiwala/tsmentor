<?php
/*
Module Name: Advance Tabs
Type: widget
Enabled: true
Dir: advancetabs
*/
namespace TS\Modules\Advancetabs;

use TS\Base\ModuleBase;

class Module extends ModuleBase {
    
    
    
    

	public function get_widgets() {
		return [
            'ts-adv-tabs',
		];
	}
    
    public static function get_enqueuable(){
        return [
            'css' => [
                    [
                        'file' => 'advanced-tabs.min',
                        'name' => 'adv-tab-css',
                        
                    ],
                ],
            'js' => [
                [
                    'file' => 'advanced-tabs.min',
                    'name' => 'adv-tab-js',
                    
                ],
            ],
        ];
    }

    
}
