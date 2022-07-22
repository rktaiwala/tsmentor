<?php

namespace TS\Traits;

use TS\Helper;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


trait Ajax {
	/**
	 * init_ajax_hooks
	 */
	public function init_ajax_hooks() {
        
        add_action( 'wp_ajax_ts_select2_search_post', [ $this, 'select2_ajax_posts_filter_autocomplete' ] );
		add_action( 'wp_ajax_nopriv_ts_select2_search_post', [ $this, 'select2_ajax_posts_filter_autocomplete' ] );
        add_action( 'wp_ajax_ts_select2_get_title', [ $this, 'select2_ajax_get_posts_value_titles' ] );
		add_action( 'wp_ajax_nopriv_ts_select2_get_title', [ $this, 'select2_ajax_get_posts_value_titles' ] );
    }
    
    /**
	 * Select2 Ajax Posts Filter Autocomplete
	 * Fetch post/taxonomy data and render in Elementor control select2 ajax search box
	 */
	public function select2_ajax_posts_filter_autocomplete() {
		$post_type   = 'post';
		$source_name = 'post_type';

		if ( ! empty( $_GET['post_type'] ) ) {
			$post_type = sanitize_text_field( $_GET['post_type'] );
		}

		if ( ! empty( $_GET['source_name'] ) ) {
			$source_name = sanitize_text_field( $_GET['source_name'] );
		}

		$search  = ! empty( $_GET['term'] ) ? sanitize_text_field( $_GET['term'] ) : '';
		$results = $post_list = [];
		switch ( $source_name ) {
			case 'taxonomy':
				$args = [
					'hide_empty' => false,
					'orderby'    => 'name',
					'order'      => 'ASC',
					'search'     => $search,
					'number'     => '5',
				];

				if ( $post_type !== 'all' ) {
					$args['taxonomy'] = $post_type;
				}

				$post_list = wp_list_pluck( get_terms( $args ), 'name', 'term_id' );
				break;
			case 'user':
				$users = [];

				foreach ( get_users( [ 'search' => "*{$search}*" ] ) as $user ) {
					$user_id           = $user->ID;
					$user_name         = $user->display_name;
					$users[ $user_id ] = $user_name;
				}

				$post_list = $users;
				break;
			default:
				$post_list = Helper::get_query_post_list( $post_type, 10, $search );
		}

		if ( ! empty( $post_list ) ) {
			foreach ( $post_list as $key => $item ) {
				$results[] = [ 'text' => $item, 'id' => $key ];
			}
		}
		wp_send_json( [ 'results' => $results ] );
	}
    
    public function select2_ajax_get_posts_value_titles() {

		if ( empty( $_POST['id'] ) ) {
			wp_send_json_error( [] );
		}

		if ( empty( array_filter( $_POST['id'] ) ) ) {
			wp_send_json_error( [] );
		}
		$ids         = array_map( 'intval', $_POST['id'] );
		$source_name = ! empty( $_POST['source_name'] ) ? sanitize_text_field( $_POST['source_name'] ) : '';

		switch ( $source_name ) {
			case 'taxonomy':
				$args = [
					'hide_empty' => false,
					'orderby'    => 'name',
					'order'      => 'ASC',
					'include'    => implode( ',', $ids ),
				];

				if ( $_POST['post_type'] !== 'all' ) {
					$args['taxonomy'] = sanitize_text_field( $_POST['post_type'] );
				}

				$response = wp_list_pluck( get_terms( $args ), 'name', 'term_id' );
				break;
			case 'user':
				$users = [];

				foreach ( get_users( [ 'include' => $ids ] ) as $user ) {
					$user_id           = $user->ID;
					$user_name         = $user->display_name;
					$users[ $user_id ] = $user_name;
				}

				$response = $users;
				break;
			default:
				$post_info = get_posts( [
					'post_type' => sanitize_text_field( $_POST['post_type'] ),
					'include'   => implode( ',', $ids )
				] );
				$response  = wp_list_pluck( $post_info, 'post_title', 'ID' );
		}

		if ( ! empty( $response ) ) {
			wp_send_json_success( [ 'results' => $response ] );
		} else {
			wp_send_json_error( [] );
		}
	}
}
