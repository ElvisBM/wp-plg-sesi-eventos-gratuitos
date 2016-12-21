<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       elvisbmartins.com.br
 * @since      1.0.0
 *
 * @package    Sesi_Eventos_Gratuitos
 * @subpackage Sesi_Eventos_Gratuitos/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sesi_Eventos_Gratuitos
 * @subpackage Sesi_Eventos_Gratuitos/admin
 * @author     Elvis B. Martins <elvisbmartins@gmail.com>
 */
class Sesi_Eventos_Gratuitos_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sesi_Eventos_Gratuitos_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sesi_Eventos_Gratuitos_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */



		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sesi-eventos-gratuitos-admin.css', array(), $this->version, 'all' );

	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sesi_Eventos_Gratuitos_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sesi_Eventos_Gratuitos_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sesi-eventos-gratuitos-admin.js', array( 'jquery' ), $this->version, false );

	}

	/*
	 * Button get event sesi Free
	 */
	public function btn_sesi_get_event() {

    	echo '<a href="#" id="btn_get_event_sesi" class="btn_get_event_sesi btn-sesi" title="Pegar Eventos do Sesi">SESI Eventos Gratuitos</a>';

	}

	/*
	 *  cURL php from get event sesi
	 */
	private function curl_php( $url, $xml ){

     	$headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: " + $url, 
                    "Content-length: ".strlen($xml),
                ); 

     	$ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch); 
        curl_close($ch);

        $response =  simplexml_load_string(str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $response));
        $response = $response->Body;

        return $response;
	}

	private function upload_img_decode($image_code , $evento_Nome){

		$upload_dir  = wp_upload_dir();
    	$upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
    	$decoded_img = base64_decode( $image_code ) ;
    	$filename  = $evento_Nome . ".png";
    	$hashed_filename  = md5( $filename . microtime() ) . '_' . $filename;
        $image_upload  = file_put_contents( $upload_path . $hashed_filename, $decoded );

        //HANDLE UPLOADED FILE
		if( !function_exists( 'wp_handle_sideload' ) ) {

		  require_once( ABSPATH . 'wp-admin/includes/file.php' );

		}

		// Without that I'm getting a debug error!?
		if( !function_exists( 'wp_get_current_user' ) ) {

		  require_once( ABSPATH . 'wp-includes/pluggable.php' );

		}
		// @new
		$file             = array();
		$file['error']    = '';
		$file['tmp_name'] = $upload_path . $hashed_filename;
		$file['name']     = $hashed_filename;
		$file['type']     = 'image/png';
		$file['size']     = filesize( $upload_path . $hashed_filename );

		// upload file to server
		// @new use $file instead of $image_upload
		$file_return      = wp_handle_sideload( $file, array( 'test_form' => false ) );

		$filename = $file_return['file'];
		$attachment = array(
		 'post_mime_type' => $file_return['type'],
		 'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
		 'post_content' => '',
		 'post_status' => 'inherit',
		 'guid' => $wp_upload_dir['url'] . '/' . basename($filename)
		 );
		
		$attach_id = wp_insert_attachment( $attachment, $filename, 289 );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}

	/*
	 * Get Event Sesi, Set WP
	 */
	public function sesi_eventos_gratuitos_callback() {
	    global $wpdb; // this is how you get access to the database

	    $url_cidades = "https://inscricaoeventos.sesisp.org.br/eventos.asmx?op=getCidade";
	    $xml_cidades = '<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="https://inscricaoeventos.sesisp.org.br/"><SOAP-ENV:Body><ns1:getCidade/></SOAP-ENV:Body></SOAP-ENV:Envelope>';

	    $url_eventos = "https://inscricaoeventos.sesisp.org.br/eventos.asmx?op=getEvento";
		$xml_eventos = '<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="https://inscricaoeventos.sesisp.org.br/"><SOAP-ENV:Body><ns1:getEvento><ns1:CodigoCidade></ns1:CodigoCidade></ns1:getEvento></SOAP-ENV:Body></SOAP-ENV:Envelope>';

		$url_imagem = "https://inscricaoeventos.sesisp.org.br/eventos.asmx?op=getImagemEvento";
		$xml_imagem = '<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="https://inscricaoeventos.sesisp.org.br/"><SOAP-ENV:Body><ns1:getImagemEvento><ns1:CodigoEvento></ns1:CodigoEvento></ns1:getImagemEvento></SOAP-ENV:Body></SOAP-ENV:Envelope>';

	    

		$response_cidades = $this->curl_php( $url_cidades, $xml_cidades );
		$cidades = $response_cidades->getCidadeResponse->getCidadeResult;


		//User ID SESI
		$user_id = 37;
		$args = array(
		    'author'    =>  $user_id,
		    'post_type' =>  'product'
		);
		$user_posts = new WP_Query( $args );
		$cont_post = 1;
		$criapost =  true;


		// //Get API SESI
		foreach ($cidades->sttCidade as $cidade )
		{
		    //$response .= " cod " . $cod_cidade->Codigo;
		    $cod_cidade = "<ns1:CodigoCidade>".$cidade->Codigo."</ns1:CodigoCidade>";
		    $xml_eventos = str_replace("<ns1:CodigoCidade></ns1:CodigoCidade>", $cod_cidade, $xml_eventos);
		    $response_evento = $this->curl_php( $url_eventos, $xml_eventos );
		    $eventos = $response_evento->getEventoResponse->getEventoResult;

		    foreach ( $eventos->sttEvento as $evento ) {
		    	$cod_evento = "<ns1:CodigoEvento>" . $evento->Codigo. "</ns1:CodigoEvento>";
		    	$xml_imagem = str_replace("<ns1:CodigoEvento></ns1:CodigoEvento>", $cod_evento, $xml_imagem);
		    	$response_imagem = $this->curl_php( $url_imagem, $xml_imagem );

		    	//Verify Posts Get     	
				if ( $user_posts->have_posts() ) :
					while ( $user_posts->have_posts() ) : $user_posts->the_post();
						$title_post = esc_html(get_the_title()); 
						$evento_nome = esc_html($evento->Nome);
		    			if( $title_post == $evento_nome ){
		    				$criapost =  false;
		    			}
		    		endwhile;
				endif;
				wp_reset_postdata();

				if( $criapost == true ){
	    			$post = array(
					    'post_author' => $user_id,
					    'post_content' => $evento->Sinopse,
					    'post_status' => "publish",
					    'post_title' => esc_html($evento->Nome),
					    'post_parent' => '',
					    'post_type' => "product",
					);

					$image_id = $this->upload_img_decode( 
									$response_imagem->getImagemEventoResponse->getImagemEventoResult, 
									$evento->Nome 
								);
					//Create post
					$post_id = wp_insert_post( $post, $wp_error );
					if($post_id){
					    $attach_id = get_post_meta($product->parent_id, "_thumbnail_id", true);
					    add_post_meta($post_id, '_thumbnail_id', $image_id);
					}

					wp_set_object_terms( $post_id, $evento->Genero, 'product_cat' );
					wp_set_object_terms($post_id, 'simple', 'product_type');

					$cont_post++;
				}
		    }//EndForeach Eventos
		}//EndForeach Cidades
	 
	    // echo $cont_post ;
	    print_r( $cont_post );
	}//End Function Callback





}
