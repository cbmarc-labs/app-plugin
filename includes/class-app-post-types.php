<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Post_Types
 *
 * Clase APP_Post_Types
 *
 * @class 		APP_Property
 * @version		1.0.0
 * @package		Application/includes/APP_Post_Types
 * @category	Class
 * @author 		cbmarc
 */
class APP_Post_Types
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
		App_Log::log( 'APP_Property Class Initialized' );
		
		// Walkers
		include_once( 'walkers/mc-walker-taxonomy-dropdown.php' );
		
		// Widgets
		include_once( 'widgets/class-app-widget-property-filter-form.php' );
		
		// Initialise
		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'widgets_init', array( &$this, 'widgets_init' ) );
		
		add_filter( 'query_vars', array( &$this, 'query_vars' ) );
		
		add_action( 'app_property_form_filter', array( &$this, 'app_property_form_filter' ) );
		add_action( 'pre_get_posts', array( &$this, 'pre_get_posts' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * getInstance method
	 *
	 * @access public
	 */
	public static function instance()
	{
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}

	// --------------------------------------------------------------------

	/**
	 * init method
	 *
	 * @access public
	 */
	function init()
	{				
		register_post_type(
			'property', 
			array(
				'labels'				=> array(
					'name' => APP_Lang::_x( 'property' )
				),
		        'menu_icon'				=> 'dashicons-format-aside',
				'public'				=> true,
				'show_ui'				=> true,
				'has_archive'			=> true,
        		'publicly_queryable'	=> true,
				'query_var'				=> true,
				'show_in_menu'			=> true,
				'show_in_nav_menus'		=> true,
				'supports' => array(
						'title', 'editor', 'excerpt', 'thumbnail'
				),
				'rewrite' => array(
						'slug'			=> 'property',
						'with_front'	=> false,
						'pages'			=> true,
						'feeds'			=> true,
						'ep_mask'		=> EP_PERMALINK,
				)
			)
		);
		
		// Type Taxonomy
		register_taxonomy(
			'property-type',
			array( 'property' ),
			array(
				'labels'            => array(
					'name' => APP_Lang::_x( 'property-type' )
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
			)
		);
		
		// Transaction Taxonomy
		register_taxonomy(
			'property-transaction',
			array( 'property' ),
			array(
				'labels'            => array(
					'name' => APP_Lang::_x( 'property-transaction' )
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
			)
		);
		
		// Features Taxonomy
		register_taxonomy(
			'property-feature',
			array( 'property' ),
			array(
				'labels'            => array(
					'name' => APP_Lang::_x( 'property-feature' )
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
			)
		);
		
		wp_enqueue_style( 'app-nouislider-style', APP_TEMPLATE_DIR . 
			'assets/lib/noUiSlider.7.0.10/jquery.nouislider.min.css' );
		
		wp_enqueue_script( 'app-nouislider-script', APP_TEMPLATE_DIR . 
			'assets/lib/noUiSlider.7.0.10/jquery.nouislider.all.min.js', array( 'jquery' ) );
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
	 * app_property_form_filter method
	 *
	 * @access public
	 */
	public function app_property_form_filter()
	{		
		include( APP_PLUGIN_PATH . '/templates/property-form-filter.php');
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
		$vars[] = "transaction";
		$vars[] = "min_rooms";
		$vars[] = "max_price";
		$vars[] = "min_m2";
		
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
				$query->query_vars['post_type'] == 'property' ) {
            
			$meta_query = $query->get('meta_query');
			
			// Filter by type taxonomy
			if( isset( $query->query_vars['type'] ) && !empty( $query->query_vars['type'] ) ) {
				$safe_type = sanitize_text_field( $query->query_vars['type'] );
			
				if( $safe_type != '0' ) {
					$query->set( 
						'tax_query',
							array(
								array(
									'taxonomy' => 'property-type',
									'field'    => 'slug',
									'terms'    => $safe_type,
								)
							)
					);
				}
			}
			
			// Filter by type taxonomy
			if( isset( $query->query_vars['transaction'] ) && !empty( $query->query_vars['transaction'] ) ) {
				$safe_transaction = sanitize_text_field( $query->query_vars['transaction'] );
			
				if( $safe_transaction != '0' ) {
					$query->set( 
						'tax_query',
							array(
								array(
									'taxonomy' => 'property-transaction',
									'field'    => 'slug',
									'terms'    => $safe_transaction,
								)
							)
					);
				}
			}
			
			// filter by min rooms
			if( isset( $query->query_vars['min_rooms'] ) && 
				! empty( $query->query_vars['min_rooms'] ) ) {
				$safe_min_rooms = intval( $query->query_vars['min_rooms'] );
				
				$meta_query[] = array(
					'key'		=> '_property_rooms',
					'value'		=> $safe_min_rooms,
					'type'		=> 'NUMERIC',
					'compare'	=> '>=',
				);
			}
			
			// filter by min rooms
			if( isset( $query->query_vars['min_m2'] ) && 
				! empty( $query->query_vars['min_m2'] ) ) {
				$safe_min_m2 = intval( $query->query_vars['min_m2'] );
				
				$meta_query[] = array(
					'key'		=> '_property_m2',
					'value'		=> $safe_min_m2,
					'type'		=> 'NUMERIC',
					'compare'	=> '>=',
				);
			}
			
			// filter by max_price
			if( isset( $query->query_vars['max_price'] ) && 
				! empty( $query->query_vars['max_price'] ) ) {
				$safe_max_price = intval( $query->query_vars['max_price'] );
				
				$meta_query[] = array(
					'key'		=> '_property_price',
					'value'		=> $safe_max_price,
					'type'		=> 'NUMERIC',
					'compare'	=> '<=',
				);
			}
			
			$query->set( 'meta_query', $meta_query );
			
			add_filter( 'posts_where', array( &$this, 'posts_where' ) );
 		}
 		
 		return $query;
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
	
}


APP_Post_Types::instance();