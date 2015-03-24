<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Real_Estate' ) ) :

/**
 * APP_Real_Estate
 *
 * Clase APP_Real_Estate
 *
 * @class 		APP_Real_Estate
 * @version		1.0.0
 * @package		Application/includes/admin/APP_Real_Estate
 * @category	Class
 * @author 		cbmarc
 */
class APP_Real_Estate
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
		App::log( 'APP_Real_Estate Class Initialized' );
		
		// Post Type
		include_once( 'post-types/class-app-post-type-real-estate.php' );
		
		// Metabox
		include_once( 'meta-boxes/class-app-meta-box-real-estate.php' );
		
		// Initialise
		add_action( "init", array( &$this, 'init' ) );
		
		add_action( "app_real_estate_form_filter", array( &$this, 'app_real_estate_form_filter' ) );
		//add_action( 'pre_get_posts', array( &$this, 'pre_get_posts' ) );
		
		add_action( 'save_post', array( &$this, 'save_post' ), 1, 2 );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * app_form_real_estate_filter method
	 * 
	 * retorna el formulari del filtre
	 *
	 * @access public
	 */
	public function app_real_estate_form_filter()
	{
		include( APP_TEMPLATE_PATH . '/templates/real-estate-form-filter.php');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * pre_get_posts method
	 * 
	 * filtra la llista al front-end
	 *
	 * @access public
	 */
	public function pre_get_posts( $query )
	{
		// Check if on frontend and main query is modified
		if( is_admin() && $query->is_main_query() && 
				$query->query_vars['post_type'] == APP_Post_Type_Real_Estate::POST_TYPE )
		{
			//$query->set('meta_key', 'project_type');
			//$query->set('meta_value', 'design');
			//$query->set('post__not_in', array(1,2,3) );
			/*
			 * $tax_query = array(  
                array(
                    'taxonomy' => 'writer',
                    'field' => 'name',
                    'terms' => $current_user_name
                )
            )
            $query->set( 'tax_query', $tax_query );
            
            
            
            $query->set( 'meta_query', array(
            'relation' => 'OR',
            // this is the part that gets a key with no value
            array(
                'key'     => '_restricted_key',
                'value    => 'oeusnth', // just has to be something because of a bug in WordPress
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key'     => '_restricted_key',
                'value'   => get_current_user_id(),
                'compare' => '==',
            ),
        );
            
            
            
            
			 */
			
			add_filter( 'posts_where', array( &$this, 'posts_where' ) );
 		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * posts_where method
	 *
	 * @access public
	 */
	public function posts_where( $where = '' )
	{
		//$today = date( 'Y-m-d' );
		//$where .= " AND post_date >= '$today'";
		
		return $where;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * init method
	 *
	 * @access public
	 */
	public function init()
	{
		//if( !admin()) || wp_admin() ??¿?¿?¿? is_admin(), is this post_type
		if ( isset( $_POST[ 'rst_form' ] ) )
		{
			//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
			$args = array(
				//'cat'			=> 19,
				'meta_key'		=> $counties,
				'meta_value'	=> $counties,
				//'paged'			=> $paged,
			);
  
			//query_posts($args);
		}
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
	 * save_post method
	 *
	 * @access public
	 */
	public function save_post( $post_id, $post )
	{
		/*
		 * We need to verify this came from our screen and with proper authorization,
		* because the save_post action can be triggered at other times.
		*/
		
		// Check if our nonce is set.
		if ( ! isset( $_POST['app_meta_box_real_estate_nonce'] ) )
		{
			return;
		}
		
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['app_meta_box_real_estate_nonce'], 'app_meta_box_real_estate' ) )
		{
			return;
		}
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		{
			return;
		}
		
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) &&
				APP_Post_Type_Real_Estate::POST_TYPE == $_POST['post_type'] )
		{
			if ( ! current_user_can( 'edit_page', $post_id ) )
			{
				return;
			}
		
		}
		else
		{
			if ( ! current_user_can( 'edit_post', $post_id ) )
			{
				return;
			}
		}
		
		// OK, we're authenticated: we need to find and save the data
		$safe_rooms = intval( $_POST[ 'app_meta_box_real_estate_rooms' ] );
		if ( ! $safe_rooms )
		{
			$safe_rooms = '';
		}
		
		update_post_meta( $post_id, '_app_real_estate_rooms', $safe_rooms );
	}
	
}

endif;

/**
 * Create instance
 */
global $APP_Real_Estate;
if( class_exists( 'APP_Real_Estate' ) && !$APP_Real_Estate )
{
	$APP_Real_Estate = APP_Real_Estate::instance();
}