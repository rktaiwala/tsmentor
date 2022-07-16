<?php



function ts_get_dashboard_link($suffix = '#home') {
	return add_query_arg(['page' => 'ts-addons' . $suffix], admin_url('admin.php'));
}

function ts_has_pro(){
    return false;
}

function ts_get_b64_icon() {
	return 'data:image/png;base64,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';
}

function get_module_widget_data( $widget_file, $markup = true, $translate = true ) {
    $default_headers = array(
        'Name'        => 'Widget Name',
        'Type'        => 'Type',
        'Enabled'     => 'Enabled',
        'Dir'         => 'Dir',
        
    );
    $widget_data = get_file_data( $widget_file, $default_headers, 'ts_widget' );
    
    return $widget_data;
}

function scan_widgets($widget_folder=''){
        
    $ts_widgets  = array();
    $widgets_root = TS_PRO_PATH_MODULES;

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

        $ts_widgets[ $widget_data['Dir'] ][] = $widget_data;
    }

    //uasort( $wp_plugins, '_sort_uname_callback' );

    //$cache_plugins[ $plugin_folder ] = $wp_plugins;
    //wp_cache_set( 'plugins', $cache_plugins, 'plugins' );

    return $ts_widgets;

}