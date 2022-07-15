<?php

namespace TS\Traits;

if ( !defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

use \Elementor\Plugin;

trait Generator {
	public function init_request_data() {
		if ( !apply_filters( 'tsmentor/is_plugin_active', 'elementor/elementor.php' ) ) {
			return;
		}

		if ( is_admin() ) {
			return;
		}

		if ( $this->is_running_background() ) {
			return;
		}

		$uid = null;

		if ( $this->is_preview_mode() ) {
			if ( is_front_page() ) {
				$uid = 'front-page';
			} else if ( is_home() ) {
				$uid = 'home';
			} else if ( is_post_type_archive() ) {
				$post_type = get_query_var( 'post_type' );

				if ( is_array( $post_type ) ) {
					$post_type = reset( $post_type );
				}

				$uid = 'post-type-archive-' . $post_type;
			} else if ( is_category() ) {
				$uid = 'category-' . get_queried_object_id();
			} else if ( is_tag() ) {
				$uid = 'tag-' . get_queried_object_id();
			} else if ( is_tax() ) {
				$uid = 'tax-' . get_queried_object_id();
			} else if ( is_author() ) {
				$uid = 'author-' . get_queried_object_id();
			} elseif ( is_year() ) {
				$uid = 'year-' . get_the_date( 'y' );
			} elseif ( is_month() ) {
				$uid = 'month-' . get_the_date( 'm-y' );
			} elseif ( is_day() ) {
				$uid = 'day-' . get_the_date( 'j-m-y' );
			} else if ( is_archive() ) {
				$uid = 'archive-' . get_queried_object_id();
			} else if ( is_search() ) {
				$uid = 'search';
			} else if ( is_single() || is_page() || is_singular() ) {
				$uid = 'singular-' . get_queried_object_id();
			} else if ( is_404() ) {
				$uid = 'error-404';
			}
		} elseif ( $this->is_edit_mode() ) {
			$uid = 'tsmentor-edit';
		}

		// set request uid
		if ( $uid && $this->uid == null ) {
			$this->uid                     = $this->generate_uid( $uid );
			//$this->request_requires_update = $this->request_requires_update();
		}
		//exit;
	}

	public function generate_uid( $str ) {
		return substr( md5( $str ), 0, 9 );
	}

	public function get_temp_uid() {
		return $this->generate_uid( 'tsmentor-view' );
	}

	
}