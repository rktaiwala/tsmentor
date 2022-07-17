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
    
    public static function str_to_css_id( $str ) {
		$str = strtolower( $str );

		//Make alphanumeric (removes all other characters)
		$str = preg_replace( "/[^a-z0-9_\s-]/", "", $str );

		//Clean up multiple dashes or whitespaces
		$str = preg_replace( "/[\s-]+/", " ", $str );

		//Convert whitespaces and underscore to dash
		$str = preg_replace( "/[\s_]/", "-", $str );

		return $str;
	}
    public static function ts_wp_kses($text){
        return wp_kses($text,self::ts_allowed_tags());
    }
    public static function ts_allowed_tags(){
        return [
            'a' => [
                'href' => [],
                'title' => [],
                'class' => [],
                'rel' => [],
                'id' => [],
                'style' => []
            ],
            'q' => [
                'cite' => [],
                'class' => [],
                'id' => [],
            ],
            'img' => [
                'src' => [],
                'alt' => [],
                'height' => [],
                'width' => [],
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'span' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'dfn' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'time' => [
                'datetime' => [],
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'cite' => [
                'title' => [],
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'hr' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'b' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'p' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'i' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'u' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            's' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'br' => [],
            'em' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'code' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'mark' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'small' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'abbr' => [
                'title' => [],
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'strong' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'del' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'ins' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'sub' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'sup' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'div' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'strike' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'acronym' => [],
            'h1' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'h2' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'h3' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'h4' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'h5' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'h6' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'button' => [
                'class' => [],
                'id' => [],
                'style' => [],
            ],
            'center' => [
	            'class' => [],
	            'id'    => [],
	            'style' => [],
            ],
        ];
    }
    
    public static function get_query_post_list($post_type = 'any', $limit = -1, $search = '')
    {
        global $wpdb;
        $where = '';
        $data = [];

        if (-1 == $limit) {
            $limit = '';
        } elseif (0 == $limit) {
            $limit = "limit 0,1";
        } else {
            $limit = $wpdb->prepare(" limit 0,%d", esc_sql($limit));
        }

        if ('any' === $post_type) {
            $in_search_post_types = get_post_types(['exclude_from_search' => false]);
            if (empty($in_search_post_types)) {
                $where .= ' AND 1=0 ';
            } else {
                $where .= " AND {$wpdb->posts}.post_type IN ('" . join("', '",
                    array_map('esc_sql', $in_search_post_types)) . "')";
            }
        } elseif (!empty($post_type)) {
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_type = %s", esc_sql($post_type));
        }

        if (!empty($search)) {
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", '%' . esc_sql($search) . '%');
        }

        $query = "select post_title,ID  from $wpdb->posts where post_status = 'publish' $where $limit";
        $results = $wpdb->get_results($query);
        if (!empty($results)) {
            foreach ($results as $row) {
                $data[$row->ID] = $row->post_title;
            }
        }
        return $data;
    }
}