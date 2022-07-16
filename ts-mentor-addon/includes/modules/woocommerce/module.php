<?php
/*
Module Name: Woocommerce
Type: widget
Enabled: true
Dir: woocommerce
*/
namespace TS\Modules\Woocommerce;

use TS\Base\ModuleBase;

class Module extends ModuleBase {
    
    
    
    

	public function get_widgets() {
		return [
			'ts-woo-rp-by-cat',
            'ts-woo-title',
			
		];
	}
    
    /**
	 * Parse Product Widget Args.
	 *
	 * A general function to construct an arguments array for the new query types in the
	 * Products widget according to the widget's settings.
	 * These arguments will later be passed to the WooCommerce template functions.
	 *
	 * @since 3.7.0
	 * @access private
	 *
	 * @param array $settings The widget settings.
	 * @param string $type The query type to create arguments for.
	 *
	 * @return array $args
	 */
	private static function parse_product_widget_args( $settings, $type = 'related' ) {
		$limit_key = 'related' === $type ? 'posts_per_page' : 'limit';

		$args = [
			$limit_key => '-1',
			'columns' => ! empty( $settings['columns'] ) ? $settings['columns'] : 4,
			'orderby' => ! empty( $settings['orderby'] ) ? $settings['orderby'] : 'rand',
			'order' => ! empty( $settings['order'] ) ? $settings['order'] : 'desc',
		];

		if ( ! empty( $settings['rows'] ) ) {
			$args[ $limit_key ] = $args['columns'] * $settings['rows'];
		}

		return $args;
	}
    /**
	 * Get Product Widget Content.
	 *
	 * A general function to create markup for the new query types in the Products widget.
	 *
	 * @since 3.7.0
	 * @access private
	 *
	 * @param array $settings The widget settings.
	 * @param string $type The query type to create content for.
	 * @param string $title_hook The hook name to filter in the widget title.
	 * @param string $title_key The control ID for the section title.
	 *
	 * @return mixed The content or false
	 */
	private static function get_product_widget_content( $settings, $type, $title_hook, $title_key = '' ) {
		add_filter( $title_hook, function ( $heading ) use ( $settings, $title_key ) {
			$title_text = isset( $settings[ $title_key ] ) ? $settings[ $title_key ] : '';

			if ( ! empty( $title_text ) ) {
				return $title_text;
			}

			return $heading;
		}, 10, 1 );

		ob_start();

		$args = self::parse_product_widget_args( $settings, $type );

		if ( 'related' === $type ) {
            
			woocommerce_related_products( $args );
		} elseif ( 'upsells' === $type ) {
			woocommerce_upsell_display( $args['limit'], $args['columns'], $args['orderby'], $args['order'] );
		} else {
			/**
			 * We need to wrap this content in the 'woocommerce' class for the layout to have the correct styling.
			 * Because this will only be used as a separate widget on the Cart page,
			 * the normal 'woocommerce' div from the cart widget will be closed before this content.
			 */
			echo '<div class="woocommerce">';
				woocommerce_cross_sell_display( $args['limit'], $args['columns'], $args['orderby'], $args['order'] );
			echo '</div>';
		}

		$products_html = ob_get_clean();

		remove_filter( $title_hook, function(){}, 10 );
		remove_filter( 'woocommerce_get_related_product_cat_terms', ['TS\Base\ModuleBase\Module','rp_sub_cats'], 20, 2 );

		if ( $products_html ) {
			$products_html = str_replace( '<ul class="products', '<ul class="products elementor-grid', $products_html );

			return wp_kses_post( $products_html );
		}

		return false;
	}

    public function rp_sub_cats($terms, $product_id){
        $prodterms = get_the_terms($product_id, 'product_cat');
        if (count($prodterms) === 1) {
            return $terms;
        }

        // Loop through the product categories and remove parent categories
        $subcategories = array();
        foreach ($prodterms as $k => $prodterm) {
            if ($prodterm->parent === 0) {
                unset($prodterms[$k]);
            } else {
                $subcategories[] = $prodterm->term_id;
            }
        }
        return $subcategories;
    }
    /**
	 * Get Products Related Content.
	 *
	 * A function to return content for the 'related' products query type in the Products widget.
	 * This function is declared in the Module file so it can be accessed during a WC fragment refresh
	 * and also be used in the Product widget's render method.
	 *
	 * @since 3.7.0
	 * @access public
	 *
	 * @param array $settings
	 *
	 * @return mixed The content or false
	 */
	public static function get_products_related_content( $settings ) {
		global $product;

		$product = wc_get_product();

		if ( ! $product ) {
			return;
		}
        add_filter( 'woocommerce_get_related_product_cat_terms', [__CLASS__,'rp_sub_cats'], 20, 2 );
		return self::get_product_widget_content(
			$settings,
			'related',
			'woocommerce_product_related_products_heading',
			'products_related_title_text'
		);
	}
}
