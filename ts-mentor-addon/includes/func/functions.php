<?php



function ts_get_dashboard_link($suffix = '#home') {
	return add_query_arg(['page' => 'ts-addons' . $suffix], admin_url('admin.php'));
}

function ts_has_pro(){
    return defined('TS_MENTOR_PRO_VERSION');
}

function ts_get_b64_icon() {
	return 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1OC43IiBoZWlnaHQ9IjUzLjciIHZpZXdCb3g9IjAgMCA1OC43IDUzLjciPgogIDxkZWZzPgogICAgPHN0eWxlPgogICAgICAuYSB7CiAgICAgICAgZmlsbDogI2E3YWFhZDsKICAgICAgfQogICAgPC9zdHlsZT4KICA8L2RlZnM+CiAgPHRpdGxlPnRzbG9nb2ljb24xPC90aXRsZT4KICA8Zz4KICAgIDxwYXRoIGNsYXNzPSJhIiBkPSJNMjAuNywxMy41aDh2Ny40aDkuNHM4LjgsMCw4LjguMWEyNS44MiwyNS44MiwwLDAsMC02LjgsNi40bC0yLC4xSDI4LjhhLjEuMSwwLDAsMC0uMS4xVjUwLjVjMCw0LjMsMS45LDYuNiw1LjYsNi42aDMuOXY5LjhhLjEuMSwwLDAsMS0uMS4xSDMyLjJjLTcuNywwLTExLjYtNC4xLTExLjYtMTIuNGwuMS00MS4xWiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTIwLjYgLTEzLjQpIi8+CiAgICA8cGF0aCBjbGFzcz0iYSIgZD0iTTY1LjMsMjIuOGwtMS4yLjNhOC42Niw4LjY2LDAsMCwxLTEsLjJjLS40LjEtMS4xLjMtMi4zLjdzLTIuMy44LTMuMywxLjJhMjYuODYsMjYuODYsMCwwLDAtMy40LDEuN0EyOS42MywyOS42MywwLDAsMCw1MC45LDI5YTEyLjA2LDEyLjA2LDAsMCwwLTIuMSwyLjRBNS4yNCw1LjI0LDAsMCwwLDQ4LDM0YzAsLjIuMy42LDEsMWEyMC44NSwyMC44NSwwLDAsMCw0LjIsMS45YzEuOC42LDMuOCwxLjMsNiwyczQuNSwxLjYsNi44LDIuNWE0Ni4wNiw0Ni4wNiwwLDAsMSw2LjMsMywxNy41LDE3LjUsMCwwLDEsNSw0LjMsOS4wOSw5LjA5LDAsMCwxLDIsNS44LDE1LjgyLDE1LjgyLDAsMCwxLS4zLDMuMiwxMC43MSwxMC43MSwwLDAsMS0uOSwyLjcsNi4yNSw2LjI1LDAsMCwxLTEuOCwyLjIsMTcuNjgsMTcuNjgsMCwwLDEtMi4yLDEuNiw5Ljc2LDkuNzYsMCwwLDEtMi45LDEuMSwxOS40NiwxOS40NiwwLDAsMS0zLjEuNywyNy43NSwyNy43NSwwLDAsMS0zLjcuNWwtNC4xLjNjLTEuMy4xLTIuOC4xLTQuNi4ycy00LjMuMS03LjcuMWwtOS44LS4yYS4xLjEsMCwwLDEtLjEtLjFWNTdsMS43LjFjNCwuMiw4LjIuMywxMi44LjNoNy41YTIyLjYyLDIyLjYyLDAsMCwwLDIuNy0uMSwyMi44NiwyMi44NiwwLDAsMCwyLjUtLjIsOC4zLDguMywwLDAsMCwyLS41LDEwLjA5LDEwLjA5LDAsMCwwLDEuNS0uNywxLjc4LDEuNzgsMCwwLDAsLjctLjgsMi45LDIuOSwwLDAsMCwuMy0xLjRjMC0uNC0uNC0uOS0xLjEtMS40YTIwLjM3LDIwLjM3LDAsMCwwLTQuMi0yLjJjLTEuOC0uOC0zLjktMS41LTYuMS0yLjNzLTQuNS0xLjctNi44LTIuNmE2Mi4zOSw2Mi4zOSwwLDAsMS02LjMtMi44LDE5LjI2LDE5LjI2LDAsMCwxLTUtMy41LDcuMDksNy4wOSwwLDAsMS0yLjItNC44LDExLjU3LDExLjU3LDAsMCwxLDEuNS01LjcsMTUuMzQsMTUuMzQsMCwwLDEsMy44LTQuNiw0Ny43NSw0Ny43NSwwLDAsMSw0LjktMy42LDM5LDM5LDAsMCwxLDUuMy0yLjhjMS43LS43LDMuMy0xLjMsNC43LTEuOHMyLjYtLjksMy42LTEuMmwzLjMtMWEuMS4xLDAsMCwxLC4xLjFaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMjAuNiAtMTMuNCkiLz4KICA8L2c+Cjwvc3ZnPgo=';
}

function get_module_widget_data( $widget_file, $markup = true, $translate = true ) {
    $default_headers = array(
        'Name'        => 'Module Name',
        'Type'        => 'Type',
        'Enabled'     => 'Enabled',
        'Dir'         => 'Dir',
        'Icon'         => 'Icon',
        
    );
    $widget_data = get_file_data( $widget_file, $default_headers, 'ts_widget' );
    
    return $widget_data;
}

function scan_widgets($widget_folder=''){
        
    $ts_widgets  = array();
    $widgets_root = TS_MENTOR_PATH_MODULES;

    if ( ! empty( $widget_folder ) ) {
        $widgets_root .= $widget_folder;
    }

    // Files in modules directory.
    $modules_dir  = @opendir( $widgets_root );
    $widget_files = array();

    if ( $modules_dir ) {
        while ( ( $file = readdir( $modules_dir ) ) !== false ) {
            if ( '.' === substr( $file, 0, 1 ) ) {
                continue;
            }

            if ( is_dir( $widgets_root . '/' . $file ) ) {
                $widgets_subdir = @opendir( $widgets_root . '/' . $file );

                if ( $widgets_subdir ) {
                    while ( ( $subfile = readdir( $widgets_subdir ) ) !== false ) {
                        if ( '.' === substr( $subfile, 0, 1 ) ) {
                            continue;
                        }

                        if ( '.php' === substr( $subfile, -4 ) ) {
                            $widget_files[] = "$file/$subfile";
                        }
                    }

                    closedir( $widgets_subdir );
                }
            } 
        }

        closedir( $modules_dir );
    }

    if ( empty( $widget_files ) ) {
        return $ts_widgets;
    }

    foreach ( $widget_files as $widget_file ) {
        if ( ! is_readable( "$widgets_root/$widget_file" ) ) {
            continue;
        }

        // Do not apply markup/translate as it will be cached.
        $widget_data = get_module_widget_data( "$widgets_root/$widget_file", false, false );

        if ( empty( $widget_data['Name'] ) ) {
            continue;
        }
        if($widget_data['Enabled']=='yes')
        $ts_widgets[ $widget_data['Dir'] ] = $widget_data;
    }

    //uasort( $wp_plugins, '_sort_uname_callback' );

    //$cache_plugins[ $plugin_folder ] = $wp_plugins;
    //wp_cache_set( 'plugins', $cache_plugins, 'plugins' );

    return $ts_widgets;

}

function ts_get_post_types($args = [], $diff_key = []) {
	$default = [
		'public'            => true,
		'show_in_nav_menus' => true,
	];
    $default_exclude=[ 'elementor_library', 'attachment' ];
    
	$args       = array_merge($default, $args);
	$default_exclude = array_merge($default_exclude, $diff_key);
    
	$post_types = get_post_types($args, 'objects');
	$post_types = wp_list_pluck($post_types, 'label', 'name');

	if (!empty($default_exclude)) {
		$post_types = array_diff_key($post_types, $default_exclude);
	}
	return $post_types;
}

function ts_escape_tags($tag, $default = 'span', $extra = []) {

	$supports = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p'];

	$supports = array_merge($supports, $extra);

	if (!in_array($tag, $supports, true)) {
		return $default;
	}

	return $tag;
}
function ts_get_terms($taxonomy){
    $args = [
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ];

    $terms = get_terms( $args );
    $data=[];
    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return $data;
    }
    
    foreach ( $terms as $term ) {
        $label = $term->name;
        $data[] = [
            'id' => $term->term_taxonomy_id,
            'text' => $label,
            'count'=>$term->count,
        ];
    }
    return $data;
}

function get_current_post(){
    $post_data='post';
    if(isset($GLOBALS['post'])) $post_data = $GLOBALS['post'];
    return get_post($post_data);
    
}
function ts_distance_calculate($cr_lat,$cr_lon,$cmp_lat,$cmp_lon){
    $earth_radius = 6371;
    $distance= ( $earth_radius * acos( 
					cos( radians($cr_lat) ) * 
					cos( radians( $cmp_lat ) ) * 
					cos( radians( $cmp_lon ) - radians($cr_lon) ) + 
					sin( radians($cr_lat) ) * 
					sin( radians( $cmp_lat ) ) 
				) );
    return $distance;
}
function ts_get_posts_nearby($args,$current_post,$map_field_name){
    $posts=[];
    if (isset($args) && count($args)) {
        $p_query = new \WP_Query($args);
        
        $counter = 0;
        if ($p_query->have_posts()) {
            global $wp_query;
            $original_queried_object = get_queried_object();
            $original_queried_object_id = get_queried_object_id();
            while ($p_query->have_posts()) {
                $p_query->the_post();
                $id_page = get_the_ID();
                $wp_query->queried_object_id = $id_page;
                $wp_query->queried_object = get_post();
                $map_field = TS\Helper::get_acf_field_value($map_field_name, get_the_ID());
                
                if (!empty($map_field)) {
                    $indirizzo = $map_field['address'];
                    $lat = $map_field['lat'];
                    $lng = $map_field['lng'];
                    if (!is_numeric($lat) || !is_numeric($lng)) {
                        continue;
                    }
                    // link to post
                    $postlink = get_the_permalink($id_page);
                    
                    $postTitle = wp_kses_post(get_the_title($id_page));
                        
                    $distance=ts_distance_calculate($current_post['lat'],$current_post['lng'],$lat,$lng);
                    $distance=number_format((float)$distance, 2, '.', '');   
                    $posts[]= ['title'=>$postTitle,'link'=>$postlink,'distance'=>$distance];

                }
            }
            // Reset the post data to prevent conflicts with WP globals
            $wp_query->queried_object = $original_queried_object;
            $wp_query->queried_object_id = $original_queried_object_id;
            wp_reset_postdata();
        }
    }
    usort($posts,'sortByDistance');
    return $posts;
}
function radians($degrees){          
    return 0.0174532925 * $degrees;
} 
function sortByDistance(array $a, array $b){
    if ($a['distance'] < $b['distance']) {
        return -1;
    } else if ($a['distance'] > $b['distance']) {
        return 1;
    } else {
        return 0;
    }

}

function ts_get_user_most_recent_post($user){
    global $wpdb;
    $recent  = $wpdb->get_row( $wpdb->prepare("SELECT ID, post_date FROM {$wpdb->prefix}posts WHERE post_author = %d AND post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 1", (int)$user ), ARRAY_A);
    
    if( ! isset( $recent['ID'] ) )
        return new WP_Error( 'No post found for selected user' );
    
    
    return get_post( $recent['ID'], 'ARRAY_A' );
    
    
}
function ts_user_last_post_how_recent($user,$days=7){
    $today = strtotime( date( 'Y-m-d' ) );
    
    $post=ts_get_user_most_recent_post($user);
    
    if(is_wp_error($post)) return false;
    $post_time= strtotime( $post['post_date'] );
    $expire = strtotime( '-'. $days .'days', $today );
    // is the expiration date older than today? 
    // if so, disable the user's access
    if ( $post_time > $expire )
    {
        return true;	
    }
    return false;
}

/**
 * Checks to see if the specified user id has a uploaded the image via wp_admin.
 *
 * @return bool  Whether or not the user has a gravatar
 */
function is_uploaded_via_wp_admin( $gravatar_url ) {

   $parsed_url   = wp_parse_url( $gravatar_url );

   $query_args = ! empty( $parsed_url['query'] ) ? $parsed_url['query'] : '';

   // If query args is empty means, user has uploaded gravatar.
   return empty( $query_args );

}

function has_gravatar( $user ) {

   $gravatar_url = get_avatar_url( $user );
    // 1. Check if uploaded from WP Dashboard.
   if ( is_uploaded_via_wp_admin( $gravatar_url ) ) {
      return true;
   }
   // 2. Check if uploaded from gravatar site by adding 404 in the url query param 
   $gravatar_url = sprintf( '%s&d=404', $gravatar_url );

   // Make a request to $gravatar_url and get the header
   $headers = @get_headers( $gravatar_url );

   // If request status is 200, which means user has uploaded the avatar on gravatar ste
   return preg_match( "|200|", $headers[0] );
}
function get_color_comb(){
    $colors=[
        ['bg'=>'#E2856E','txt'=>'#fff'],
        ['bg'=>'#0F1A20','txt'=>'#fff'],
        ['bg'=>'#F42C04','txt'=>'#fff'],
        ['bg'=>'#ADA296','txt'=>'#000'],
        ['bg'=>'#60AFFF','txt'=>'#000'],
        ['bg'=>'#88A2AA','txt'=>'#fff'],
        ['bg'=>'#586F7C','txt'=>'#fff'],
        ['bg'=>'#28C2FF','txt'=>'#fff'],
        ['bg'=>'#3066BE','txt'=>'#fff'],
        ['bg'=>'#963484','txt'=>'#fff'],
    ];
    $array_copy = $colors;
    shuffle($array_copy);
    $rdm = array_rand($array_copy, 1);
    return $colors[$rdm];
}