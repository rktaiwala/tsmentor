<?php

namespace TS\Classes;
use Elementor\Core\Base\Module as Base_Module;
use TS\Helper;
if (!\defined('ABSPATH')) {
    exit;
    // Exit if accessed directly
}
class QueryModule extends Base_Module
{
    /**
     * Module constructor.
     *
     * @since 1.6.0
     */
    public function __construct()
    {
        $this->add_actions();
    }
    /**
     * Get Name
     *
     * Get the name of the module
     *
     * @since  1.6.0
     * @return string
     */
    public function get_name()
    {
        return 'ts-query-control';
    }
    /**
     * Add Actions
     *
     * Registeres actions to Elementor hooks
     *
     * @since  1.6.0
     * @return void
     */
    protected function add_actions()
    {
        add_action('elementor/ajax/register_actions', [$this, 'register_ajax_actions']);
    }
    public function ajax_call_filter_autocomplete(array $data)
    {
        if (empty($data['query_type']) || empty($data['q'])) {
            throw new \Exception('Bad Request');
        }
        $results = \call_user_func([$this, 'get_' . $data['query_type']], $data);
        return ['results' => $results];
    }
    
    protected function get_acf($data)
    {
        $results = [];
        $types = !empty($data['object_type']) ? $data['object_type'] : array();
        $acfs = Helper::get_acf_fields($types);
        if (!empty($acfs)) {
            foreach ($acfs as $akey => $acf) {
                if (\strlen($data['q']) > 2) {
                    if (\strpos($akey, $data['q']) === \false && \strpos($acf, $data['q']) === \false) {
                        continue;
                    }
                }
                $results[] = ['id' => $akey, 'text' => esc_attr($acf)];
            }
        }
        return $results;
    }
    
    public function ajax_call_control_value_titles($request)
    {
        $results = \call_user_func([$this, 'get_value_titles_for_' . $request['query_type']], $request);
        return $results;
    }
    protected function get_value_titles_for_acf($request)
    {
        $ids = (array) $request['id'];
        $results = [];
        foreach ($ids as $aid) {
            $acf = Helper::get_acf_field_post($aid);
            if ($acf) {
                $results[$aid] = $acf->post_title;
            }
        }
        return $results;
    }
    
    public function register_ajax_actions($ajax_manager)
    {
        $ajax_manager->register_ajax_action('ts_query_control_value_titles', [$this, 'ajax_call_control_value_titles']);
        $ajax_manager->register_ajax_action('ts_query_control_filter_autocomplete', [$this, 'ajax_call_filter_autocomplete']);
    }
}
