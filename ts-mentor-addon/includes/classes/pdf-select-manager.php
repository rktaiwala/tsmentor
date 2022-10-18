<?php
namespace TS\Classes;

defined( 'ABSPATH' ) || die();

/**
 * Posts Query Controller class
 */
class Pdf_Select_Manager {

	/**
	 * Ajax action name
	 */
	const ACTION = 'ts_get_pdf_query_data';

	/**
	 * Taxonomy tems query
	 */
	const PDF_THUMB = 'thumbnail';
	

	/**
	 * Initialization
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_ajax_' . self::ACTION, [ __CLASS__, 'do_lazy_query' ] );
	}

	protected static function get_query_handler() {
		$query = isset( $_POST['query'] ) ? $_POST['query'] : self::PDF_THUMB;
		$handlers = [
			self::PDF_THUMB   => 'get_thumbnails',
		];

		return isset( $handlers[ $query ] ) ? $handlers[ $query ] : $handlers[ self::PDF_THUMB ];
	}

	public static function do_lazy_query() {
        //var_dump($_POST);die();
		$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';

		try {
			if ( ! wp_verify_nonce( $nonce, self::ACTION ) ) {
				throw new \Exception( 'Invalid request' );
			}

			if ( ! current_user_can( 'edit_posts' ) ) {
				throw new \Exception( 'Unauthorized request' );
			}

			$handler = self::get_query_handler();
			$data = call_user_func( [ __CLASS__, $handler ] );
			wp_send_json_success( $data );
		} catch ( \Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}

		die();
	}

	

	protected static function get_pdf_url() {
		return isset( $_POST['pdf_url'] ) ? $_POST['pdf_url'] : '';
	}

	protected static function get_pdf_id() {
		return isset( $_POST['pdf_id'] ) ? $_POST['pdf_id'] : '';
	}

	
    
    public static function get_thumbnails(){
        $url = self::get_pdf_url();
        $attach_id = self::get_pdf_id();
        
        $fullsize_path = get_attached_file( $attach_id );
        
        if(empty($fullsize_path)) return;
        $img = new \Imagick();
        $img->setResolution(300, 300);
        $img->readImage("{$fullsize_path}[0]");
        $img->setImageFormat('jpg');
        $imgBuff = $img->getimageblob();
        $img->clear(); 
        $img = base64_encode($imgBuff);
        return $img;
    }
    
	
}

//Lazy_Query_Manager::init();
