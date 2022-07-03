<?php

namespace TS;

use WP_Query;
use Elementor\Group_Control_Border;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use function is_array;
use WP_Term_Query;


class Helper {
    
    public function get_ts_woo_product_data() {
		
        global $product;
        if(is_null($product)){
            $args = [
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => 1,
            ];
            $preview_data = get_posts( $args );
            $product_data = wc_get_product( $preview_data[0]->ID );
        }else{
            $product_data = $product;
		
        }
        

		return $product_data;
	}
}