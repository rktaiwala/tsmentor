<?php



function ts_get_dashboard_link($suffix = '#home') {
	return add_query_arg(['page' => 'ts-addons' . $suffix], admin_url('admin.php'));
}

function ts_has_pro(){
    return false;
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

        $ts_widgets[ $widget_data['Dir'] ] = $widget_data;
    }

    //uasort( $wp_plugins, '_sort_uname_callback' );

    //$cache_plugins[ $plugin_folder ] = $wp_plugins;
    //wp_cache_set( 'plugins', $cache_plugins, 'plugins' );

    return $ts_widgets;

}