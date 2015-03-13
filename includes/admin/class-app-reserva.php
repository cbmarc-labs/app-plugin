<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Reserva' ) ) :

/**
 * APP_Reserva
 *
 * La clase APP_Reserva controla el proceso del formulario de reserva.
 *
 * @class 		APP_Reserva
 * @version		1.0.0
 * @package		Application/includes/APP_Reserva
 * @category	Class
 * @author 		marc
 */
class APP_Reserva
{
	// The single instance of the class
	private static $_instance = null;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct ()
	{
		App::log( 'APP_Reserva Class Initialized' );
		
		// Initialise
		add_action( "init", array( &$this, 'init' ) );
		
		add_action( "app_form_reverva", array( &$this, 'app_form_reverva' ) );
	}
	
	// --------------------------------------------------------------------

	/**
	 * instance method
	 *
	 * @access public
	 */
	public static function instance()
	{
		if(!self::$_instance)
		{
			self::$_instance = new self();
		}

		return self::$_instance;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * app_form_reverva method
	 * 
	 * retorna el formulario de la reserva por plantilla
	 *
	 * @access public
	 */
	public function app_form_reverva()
	{
		include( APP_TEMPLATE_PATH . '/templates/form-reserva.php');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * init method
	 *
	 * @access public
	 */
	public function init()
	{
		// es comprova que s'ha crear una reserva amb el formulari
		
		if ( isset($_POST['reservar']) )
		{
			$res_name  = ( isset($_POST['res_name']) )  ? trim($_POST['res_name']) : null;
			$res_quantity  = ( isset($_POST['res_quantity']) )  ? trim($_POST['res_quantity']) : null;
			$res_phone  = ( isset($_POST['res_phone']) )  ? trim($_POST['res_phone']) : null;
			$res_email  = ( isset($_POST['res_email']) )  ? trim($_POST['res_email']) : null;
			$res_comments  = ( isset($_POST['res_comments']) )  ? trim(strip_tags($_POST['res_comments'])) : null;
			
			$res_post_id  = ( isset($_POST['res_post_id']) )  ? $_POST['res_post_id'] : null;
			
			if ( $res_name == '' )
			{
				wp_die( __( 'El nom és obligatori.' ) );
			}
			
			if ( !is_email($res_email) )
			{
				wp_die( __('El email és obligatori.') );
			}
			
			$title = get_the_title( $res_post_id );
			$permalink = get_permalink( $res_post_id );
					
			$content = "S'ha fet una reserva per l'activitat:\n";
			$content .= "<a href='" . $permalink . "'>" . $title . "</a>\n\n";
			$content .= "Dades de la reserva:\n";
			$content .= "Nom: " . $res_name . "\n";
			$content .= "Nombre d'adults i nens: " . $res_quantity . "\n";
			$content .= "Telèfon: " . $res_phone . "\n";
			$content .= "Email: " . $res_email . "\n";
			$content .= "Data inici: " . tribe_get_start_date( $res_post_id, false) . "\n";
			$content .= "Comentaris:\n " . $res_comments . "\n";
			
			$res_start_date = tribe_get_start_date( $res_post_id, false, 'U');
			
			$data = array(
					'res_post_id' => $res_post_id,
					'res_name' => $res_name,
					'res_quantity' => $res_quantity,
					'res_phone' => $res_phone,
					'res_email' => $res_email,
					'res_comments' => $res_comments,
					'res_start_date' => $res_start_date,
			);
			
			// es crea un postype nou per la reserva
			global $APP_Post_Type_Reservas;
			$APP_Post_Type_Reservas->add_new_reserva( $title, $content, $data );
			
			// s'envia un correu
			$this->_send_email_administrator($content);
			$this->_send_email_client($res_email);
			
			// redirecciona per acreditar que s'ha fet la reserva
			wp_redirect( add_query_arg( 'reserva', 'submited', $permalink ) );
			
			exit;
		}
		
		if ( isset($_GET['export']) )
		{
			if ( is_user_logged_in() )
			{
				$filename = "reserves.csv";
				$post_id = $_GET['export'];
				
				$posts = $this->get_reserves_from_post( $post_id );
				
				$output = $this->getcsv(array("Nom", "Email", "Telèfon", "Adults/nens", "Comentaris"));
				
				foreach($posts as $post)
				{
					$res_name = get_post_meta( $post->ID, 'res_name', TRUE );
					$res_email = get_post_meta( $post->ID, 'res_email', TRUE );
					$res_phone = get_post_meta( $post->ID, 'res_phone', TRUE );
					$res_quantity = get_post_meta( $post->ID, 'res_quantity', TRUE );
					$res_comments = get_post_meta( $post->ID, 'res_comments', TRUE );
					
					$output .= $this->getcsv(
							array( $res_name, $res_email, $res_phone, $res_quantity, $res_comments)); 
				}
					
				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename='.$filename);
					
				echo $output;
				exit;				
			}
		}
	}


	// --------------------------------------------------------------------
	
	/**
	 * getcsv method
	 *
	 * @access private
	 */
	function getcsv($no_of_field_names)
	{
		$separate = '';
		$output = '';
	
		// do the action for all field names as field name
		foreach ($no_of_field_names as $field_name)
		{
			if (preg_match('/\\r|\\n|,|"/', $field_name))
			{
				$field_name = '' . str_replace(',',' ', $field_name) . '';
			}
			
			$output .= $separate . $field_name;
	
			//sepearte with the comma
			$separate = ',';
		}
	
		//make new row and line
		$output .= "\r\n";
		
		return $output;
	}

	// --------------------------------------------------------------------
	
	/**
	 * get_reserves_from_post method
	 *
	 * Envia correus als administradors conforme s'ha realitzat una reserva
	 *
	 * @access private
	 */
	public function get_reserves_from_post( $post_id )
	{
		$args = array(
				'post_type' => 'cpt_reservas',
				'meta_query' => array(
						array(
								'key' => 'res_post_id',
								'value' => $post_id,
						)
				)
		);
		
		$posts = get_posts( $args );
		
		return $posts;
	}

	// --------------------------------------------------------------------
	
	/**
	 * _send_email method
	 * 
	 * Envia correus als administradors conforme s'ha realitzat una reserva
	 *
	 * @access private
	 */
	private function _send_email_administrator($content)
	{
			$options = get_option('reservas_options');
			
			$send_email = $options[ 'send_email' ];
			
			$pieces = explode(",", $send_email);
			
			// envia correus als administradors
			if( !empty($pieces) )
			{
				foreach($pieces as $p)
				{
					$email = trim($p);
					
					if( is_email( $email ) )
					{
						wp_mail( $email, "Reserva realitzada", $content );
					}
				}
			}
	}

	// --------------------------------------------------------------------
	
	/**
	 * _send_email_client method
	 * 
	 * Envia correus al client conforme s'ha realitzat la reserva
	 *
	 * @access private
	 */
	private function _send_email_client($res_email)
	{
			$options = get_option('reservas_options');
			
			$send_email_text = $options[ 'send_email_text' ];
			
			// envia correu de resposta al destinatari
			if( is_email( $res_email ) && !empty($send_email_text) )
			{
				wp_mail( $res_email, "Reserva realitzada", $send_email_text );
			}
	}
	
}

endif;

/**
 * Create instance
 */
global $APP_Reserva;
if( class_exists( 'APP_Reserva' ) && !$APP_Reserva )
{
	$APP_Reserva = APP_Reserva::instance();
}