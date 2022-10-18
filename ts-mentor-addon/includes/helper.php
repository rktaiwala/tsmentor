<?php

namespace TS;

use WP_Query;
use Elementor\Group_Control_Border;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use function is_array;
use WP_Term_Query;


class Helper {
    public static $meta_fields = [];
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
    public static function is_acf_pro($plugin)
    {
        if ($plugin == 'acf') {
            if (defined('ACF')) {
                return ACF;
            }
        }
        if ($plugin == 'advanced-custom-fields-pro') {
            if (defined('ACF_PRO')) {
                return ACF_PRO;
            }
        }
        return false;
    }
    public static function is_acf_active()
    {
        if (class_exists('ACF') && defined('ACF')) {
            return true;
        }
        return false;
    }
    public static function is_acfpro_active()
    {
        if (class_exists('ACF') && defined('ACF_PRO')) {
            return true;
        }
        return false;
    }
    public static function get_acf_field_settings($key)
    {
        if (isset(self::$meta_fields[$key]['settings'])) {
            return self::$meta_fields[$key]['settings'];
        }
        $field = self::get_acf_field_post($key);
        if ($field) {
            $settings = maybe_unserialize($field->post_content);
            self::$meta_fields[$key]['settings'] = $settings;
            return $settings;
        }
        return false;
    }
    public static function get_acf_field_id($key, $multi = false)
    {
        if (isset(self::$meta_fields[$key]['ID'])) {
            return self::$meta_fields[$key]['ID'];
        }
        global $wpdb;
        $query = 'SELECT ID FROM ' . $wpdb->posts . ' WHERE post_type LIKE "acf-field" AND post_excerpt LIKE "' . esc_sql($key) . '"';
        $results = $wpdb->get_results($query);
        if (count($results) > 1) {
            // bad acf configuration
            $field_ids = array();
            foreach ($results as $afields) {
                $field_ids[] = $afields->ID;
            }
            if ($multi) {
                return $field_ids;
            }
            return reset($field_ids);
        }
        $result = $wpdb->get_var($query);
        if ($result) {
            self::$meta_fields[$key]['ID'] = $result;
            return $result;
        }
        return false;
    }
    public static function get_acf_field_post($key, $multi = false)
    {
        if (isset(self::$meta_fields[$key]['post'])) {
            return self::$meta_fields[$key]['post'];
        }
        if (is_int($key)) {
            $post = get_post($key);
            self::$meta_fields[$key]['post'] = $post;
            return $post;
        }
        $field_id = self::get_acf_field_id($key, $multi);
        if ($field_id) {
            if (is_array($field_id)) {
                if ($multi) {
                    $posts = get_posts(array('post__in' => $field_id, 'posts_per_page' => -1));
                    self::$meta_fields[$key]['post'] = $posts;
                    return $posts;
                } else {
                    $field_id = reset($field_id);
                }
            }
            if ($field_id) {
                $post = get_post($field_id);
                self::$meta_fields[$key]['post'] = $post;
                return $post;
            }
        }
        self::$meta_fields[$key]['post'] = false;
        return false;
    }
    public static function get_acf_field_locations($aacf)
    {
        if (is_string($aacf)) {
            $aacf = self::get_acf_field_post($aacf);
        }
        if ($aacf) {
            $aacf_group = get_post($aacf->post_parent);
            if ($aacf_group) {
                if ($aacf_group->post_parent == 'acf-field') {
                    // may be in repeater or block or tab
                    $aacf_group = get_post($aacf->post_parent);
                }
                if ($aacf_group->post_parent == 'acf-field-group') {
                    return self::get_acf_group_locations($aacf_group);
                }
            }
        }
        return array();
    }
    public static function get_acf_group_locations($aacf_group)
    {
        $locations = array();
        if (is_string($aacf_group)) {
            $acf_groups = get_posts(array('post_type' => 'acf-field-group', 'post_excerpt' => $aacf_group, 'numberposts' => -1, 'post_status' => 'publish', 'suppress_filters' => false));
            if (!empty($acf_groups)) {
                $aacf_group = reset($acf_groups);
            } else {
                return false;
            }
        }
        $aacf_meta = maybe_unserialize($aacf_group->post_content);
        if (!empty($aacf_meta['location'])) {
            foreach ($aacf_meta['location'] as $gkey => $gvalue) {
                foreach ($gvalue as $rkey => $rvalue) {
                    $pieces = explode('_', $rvalue['param']);
                    $location = reset($pieces);
                    $locations[$location] = $location;
                    if ($location == 'page') {
                        $locations['post'] = 'post';
                    }
                    if ($location == 'current') {
                        $locations['user'] = 'user';
                    }
                }
            }
        }
        return $locations;
    }
    public static function get_acf_field_value($idField, $id_page = null, $format = true)
    {
        if (!$id_page) {
            $id_page = get_queried_object_id();
        }
        $dataACFieldPost = self::get_acf_field_post($idField);
        // field in a Repeater or in a Flexible content
        if ($dataACFieldPost) {
            $parentID = $dataACFieldPost->post_parent;
            $parent_settings = self::get_acf_field_settings($parentID);
            if (isset($parent_settings['type']) && ($parent_settings['type'] == 'repeater' || $parent_settings['type'] == 'flexible_content')) {
                $parent_post = get_post($parentID);
                $row = acf_get_loop('active');
                if (!$row) {
                    if (have_rows($parent_post->post_excerpt, $id_page)) {
                        the_row();
                    }
                }
                $sub_field_value = get_sub_field($idField);
                if ($sub_field_value !== false) {
                    return $sub_field_value;
                }
            }
        }
        // post
        $theField = get_field($idField, $id_page, $format);
        if (!$theField) {
            $locations = self::get_acf_field_locations($dataACFieldPost);
            if (is_tax() || is_category() || is_tag() || in_array('taxonomy', $locations)) {
                $term = get_queried_object();
                $theField = get_field($idField, $term, $format);
            }
            if (!$theField && is_author()) {
                $author_id = get_the_author_meta('ID');
                $theField = get_field($idField, 'user_' . $author_id, $format);
            }
            if (!$theField && in_array('user', $locations)) {
                $user_id = get_current_user_id();
                $theField = get_field($idField, 'user_' . $user_id, $format);
            }
            if (!$theField && in_array('options', $locations)) {
                $theField = get_field($idField, 'options', $format);
            }
            if (!$theField && in_array('nav', $locations)) {
                $menu = wp_get_nav_menu_object($id_page);
                $theField = get_field($idField, $menu, $format);
            }
        }
        return $theField;
    }
    public static function get_acf_fields($types = [], $group = \false, $select = \false)
    {
        if (!\TS\Helper::is_acf_active()) {
            return [];
        }
        $acf_list = [];
        if (\is_string($types)) {
            $types = \TS\Helper::str_to_array(',', $types);
        }
        if ($select) {
            $acf_list[0] = __('Select the field...', 'tsmentor');
        }
        // ACF Fields saved in the database
        $post_type = 'acf-field';
        $acf_fields = get_posts(['post_type' => $post_type, 'numberposts' => -1, 'post_status' => 'publish', 'orderby' => 'title', 'suppress_filters' => \false]);
        // ACF Fields saved in JSON or PHP
        if (acf_have_local_fields()) {
            $local_fields = acf_get_local_fields();
            foreach ($local_fields as $key => $value) {
                $acf_list[$value['key']] = $key . ' > ' . $value['label'] . ' [' . $value['key'] . '] (' . $value['type'] . ')';
            }
        }
        if (empty($acf_fields) && empty($local_fields)) {
            return [];
        }
        foreach ($acf_fields as $acf_field) {
            $acf_field_parent = \false;
            if ($acf_field->post_parent) {
                $acf_field_parent = get_post($acf_field->post_parent);
                if ($acf_field_parent) {
                    $acf_field_parent_settings = maybe_unserialize($acf_field_parent->post_content);
                }
            }
            $acf_field_settings = maybe_unserialize($acf_field->post_content);
            if (isset($acf_field_settings['type']) && (empty($types) || \in_array($acf_field_settings['type'], $types))) {
                if ($group && $acf_field_parent) {
                    if (empty($acf_list[$acf_field_parent->post_excerpt]) || \is_array($acf_list[$acf_field_parent->post_excerpt])) {
                        if (isset($acf_field_parent_settings['type']) && $acf_field_parent_settings['type'] == 'group') {
                            $acf_list[$acf_field_parent->post_excerpt]['options'][$acf_field_parent->post_excerpt . '_' . $acf_field->post_excerpt] = $acf_field->post_title . ' [' . $acf_field->post_excerpt . '] (' . $acf_field_settings['type'] . ')';
                        } else {
                            $acf_list[$acf_field_parent->post_excerpt]['options'][$acf_field->post_excerpt] = $acf_field->post_title . ' [' . $acf_field->post_excerpt . '] (' . $acf_field_settings['type'] . ')';
                        }
                        $acf_list[$acf_field_parent->post_excerpt]['label'] = $acf_field_parent->post_title;
                    }
                } else {
                    if ($acf_field_parent) {
                        if (isset($acf_field_parent_settings['type']) && $acf_field_parent_settings['type'] == 'group') {
                            $acf_list[$acf_field_parent->post_excerpt . '_' . $acf_field->post_excerpt] = $acf_field_parent->post_title . ' > ' . $acf_field->post_title . ' [' . $acf_field->post_excerpt . '] (' . $acf_field_settings['type'] . ')';
                            //.$acf_field->post_content; //post_name,
                        } else {
                            $acf_list[$acf_field->post_excerpt] = $acf_field_parent->post_title . ' > ' . $acf_field->post_title . ' [' . $acf_field->post_excerpt . '] (' . $acf_field_settings['type'] . ')';
                            //.$acf_field->post_content; //post_name,
                        }
                    }
                }
            }
        }
        return $acf_list;
    }
    
    public static function str_to_array($delimiter = ',', $string = '', $format = null)
    {
        if (\is_array($string)) {
            return $string;
        }
        $pieces = \explode($delimiter, $string);
        $pieces = \array_map('trim', $pieces);
        $tmp = array();
        foreach ($pieces as $value) {
            if ($value != '') {
                $tmp[] = $value;
            }
        }
        $pieces = $tmp;
        if ($format) {
            $pieces = \array_map($format, $pieces);
        }
        return $pieces;
    }
    public static function getRnd_num($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
    
    public static function checkbox_item($chk_item){
        ob_start();
        ?>
        <div class="ts-checkboxes-list__row ts-filter-row<?php echo $chk_item['class']; ?>">
            <label class="ts-checkboxes-list__item">
                <input
                    type="checkbox"
                    class="ts-checkboxes-list__input"
                    name="<?php echo $chk_item['name']; ?>"
                    value="<?php echo $chk_item['val']; ?>"
                    data-label="<?php echo $chk_item['label']; ?>"
                    <?php echo $chk_item['checked']; ?>
                >
                <div class="ts-checkboxes-list__button">
                    <span class="ts-checkboxes-list__label"><?php echo $chk_item['label']; ?> (<?php echo $chk_item['count']; ?>)</span>    
                </div>
            </label>
        </div>
    <?php
        $item=ob_get_clean();
        return $item;
    }
}