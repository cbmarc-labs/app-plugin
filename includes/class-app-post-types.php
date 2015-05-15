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
		App::log( 'APP_Property Class Initialized' );
		
		// Initialise
		add_action( 'init', array( &$this, 'init' ) );
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
					'name' => App::lang( 'property' )
				),
		        'menu_icon'				=> 'dashicons-format-aside',
				'public'				=> true,
				'show_ui'				=> true,
				'has_archive'			=> true,
        		'publicly_queryable'	=> true,
				'query_var'				=> true,
				'show_in_menu' => true,
				'show_in_nav_menus' => true,
				'supports' => array(
						'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'
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
					'name' => App::lang( 'property-type' )
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
					'name' => App::lang( 'property-transaction' )
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
					'name' => App::lang( 'property-feature' )
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
			)
		);
	}
	
}


APP_Post_Types::instance();