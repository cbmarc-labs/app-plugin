<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Property' ) ) :

/**
 * APP_Property
 *
 * Clase APP_Property
 *
 * @class 		APP_Property
 * @version		1.0.0
 * @package		Application/includes/APP_Property
 * @category	Class
 * @author 		cbmarc
 */
class APP_Property
{
	// The single instance of the class
	private static $_instance = null;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		App::log( 'APP_Property Class Initialized' );
		
		// Post Types
		include_once( 'post-types/class-app-post-type-property.php' );
		
		// Metaboxes
		include_once( 'admin/meta-boxes/class-app-meta-box-property.php' );
		
		// Walkers
		include_once( 'walkers/mc-walker-taxonomy-dropdown.php' );
		
		// Widgets
		include_once( 'widgets/class-app-widget-property-filter-form.php' );
		
		// Initialise
		add_action( 'init', array( &$this, 'init' ) );
		
		add_filter( 'query_vars', array( &$this, 'query_vars' ) );
		
		add_action( 'app_property_form_filter', array( &$this, 'app_property_form_filter' ) );
		add_action( 'pre_get_posts', array( &$this, 'pre_get_posts' ) );
		
		add_action( 'save_post', array( &$this, 'save_post' ), 1, 2 );
		
		add_action( 'widgets_init', array( &$this, 'widgets_init' ) );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * app_property_form_filter method
	 *
	 * @access public
	 */
	public function app_property_form_filter()
	{		
		include( APP_TEMPLATE_PATH . '/templates/property-form-filter.php');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * widgets_init method
	 *
	 * @access public
	 */
	public function widgets_init()
	{
		register_widget( 'APP_Widget_Property_Filter_Form' );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * query_vars method
	 *
	 * @access public
	 */
	public function query_vars( $vars )
	{
		$vars[] = "type";
		$vars[] = "min_rooms";
		$vars[] = "max_rooms";
		$vars[] = "min_price";
		$vars[] = "max_price";
		
		return $vars;
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
		if( ! is_admin() && $query->is_main_query() && isset( $query->query_vars['post_type'] ) &&
				$query->query_vars['post_type'] == APP_Post_Type_Property::POST_TYPE ) {			
			//$query->set( 'meta_key', '_app_real_estate_rooms' );
			//$query->set( 'meta_value', $query->query_vars['rooms'] );
			
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
           */
            
			$meta_query = array();
			
			// filter by min rooms
			if( isset( $query->query_vars['min_rooms'] ) && 
				! empty( $query->query_vars['min_rooms'] ) ) {
				$safe_min_rooms = intval( $query->query_vars['min_rooms'] );
				
				$meta_query[] = array(
					'key'     => '_app_property_rooms',
					'value'   => $safe_min_rooms,
					'compare' => '>=',
				);
			}
			
			// filter by max rooms
			if( isset( $query->query_vars['max_rooms'] ) && 
				! empty( $query->query_vars['max_rooms'] ) ) {
				$safe_max_rooms = intval( $query->query_vars['max_rooms'] );
			
				$meta_query[] = array(
					'key'     => '_app_property_rooms',
					'value'   => $safe_max_rooms,
					'compare' => '<=',
				);
			}
			
			// Filter by type taxonomy
			if( isset( $query->query_vars['type'] ) && !empty( $query->query_vars['type'] ) ) {
				$safe_type = sanitize_text_field( $query->query_vars['type'] );
			
				if( $safe_type != '0' ) {
					$query->set( 
						'tax_query',
							array(
								array(
									'taxonomy' => APP_Post_Type_Property::TAX_TYPE,
									'field'    => 'slug',
									'terms'    => $safe_type,
								)
							)
					);
				}
			}
			
			$query->set( 'meta_query', $meta_query );
			
			//add_filter( 'posts_where', array( &$this, 'posts_where' ) );
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
		wp_enqueue_style( 'app-nouislider-style', APP_TEMPLATE_DIR . 
			'assets/lib/noUiSlider.7.0.10/jquery.nouislider.min.css' );
		
		wp_enqueue_script( 'app-nouislider-script', APP_TEMPLATE_DIR . 
			'assets/lib/noUiSlider.7.0.10/jquery.nouislider.all.min.js', array( 'jquery' ) );
	}
	
	// --------------------------------------------------------------------

	/**
	 * instance method
	 *
	 * @access public
	 */
	public static function instance()
	{
		if( ! self::$_instance ) {
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
		if ( ! isset( $_POST['app_meta_box_property_nonce'] ) ) {
			return;
		}
		
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['app_meta_box_property_nonce'], 'app_meta_box_property' ) ) {
			return;
		}
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) &&
				APP_Post_Type_Property::POST_TYPE == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		
		// OK, we're authenticated: we need to find and save the data		
		$rooms	= preg_replace( '/\D/', "", $_POST['app_meta_box_property_rooms'] );
		$price	= preg_replace( '/\D/', "", $_POST['app_meta_box_property_price'] ) / 100;
		$m2		= preg_replace( '/\D/', "", $_POST['app_meta_box_property_m2'] ) / 100;
		
		update_post_meta( $post_id, '_app_property_rooms', $rooms );
		update_post_meta( $post_id, '_app_property_price', $price );
		update_post_meta( $post_id, '_app_property_m2', $m2 );
	}
	
}

endif;

/**
 * Create instance
 */
global $APP_Property;
if( class_exists( 'APP_Property' ) && ! $APP_Property ) {
	$APP_Property = APP_Property::instance();
}