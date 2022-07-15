<?php

namespace TS\Traits;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

use \Elementor\Plugin;


trait Core
{
    /**
     * Extending plugin links
     *
     * @since 3.0.0
     */
    public function i18n()
    {
        load_plugin_textdomain('ts-mentor');
    }

    /**
     * Check if a plugin is active
     *
     * @since 3.0.0
     */
    public function is_plugin_active($plugin)
    {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        return is_plugin_active($plugin);
    }
    
    /**
     * Check if wp running in background
     *
     * @since 3.0.0
     */
    public function is_running_background()
    {
        if (wp_doing_cron()) {
            return true;
        }

        if (wp_doing_ajax()) {
            return true;
        }
        
        if (!empty($_REQUEST['action']) && !$this->check_background_action( sanitize_text_field( $_REQUEST['action'] ) )) {
            return true;
        }

        return false;
    }
    /**
     * Allow to load asset for some pre defined action query param in elementor preview
     * @return bool
     */
    public function check_background_action($action_name){
        $allow_action = [
        	'subscriptions',
	        'mepr_unauthorized',
	        'home',
	        'subscriptions',
	        'payments',
	        'newpassword',
	        'manage_sub_accounts',
	        'ppw_postpass',
        ];
        if (in_array($action_name, $allow_action)){
            return true;
        }
        return false;
    }
    
    /**
     * Check if elementor edit mode or not
     *
     * @since 3.0.0
     */
    public function is_edit_mode()
    {
        if (isset($_REQUEST['elementor-preview'])) {
            return true;
        }

        return false;
    }

    /**
     * Check if elementor edit mode or not
     *
     * @since 3.0.0
     */
    public function is_preview_mode()
    {
        if (isset($_REQUEST['elementor-preview'])) {
            return false;
        }

        if (!empty($_REQUEST['action']) && !$this->check_background_action( sanitize_text_field( $_REQUEST['action'] ) )) {
            return false;
        }


        return true;
    }
    
    /**
     * Generate safe url
     *
     * @since v3.0.0
     */
    public function safe_url($url)
    {
        if (is_ssl()) {
            $url = wp_parse_url($url);

            if (!empty($url['host'])) {
                $url['scheme'] = 'https';
            }

            return $this->unparse_url($url);
        }

        return $url;
    }

    public function unparse_url($parsed_url)
    {
        $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        $user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

        return "$scheme$user$pass$host$port$path$query$fragment";
    }

}