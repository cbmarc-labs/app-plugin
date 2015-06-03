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

	// --------------------------------------------------------------------

	/**
	 * init method
	 *
	 * @access public
	 */
	public static function init()
	{
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
	}

	// --------------------------------------------------------------------

	/**
	 * register_post_types method
	 *
	 * @access public
	 */
	public static function register_post_types()
	{
		if ( post_type_exists('property') ) {
			return;
		}
		
		register_post_type(
			'property', 
			array(
				'labels'				=> array(
					'name' => __( 'Properties', 'app' )
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
	}

	// --------------------------------------------------------------------
	
	/**
	 * register_taxonomies method
	 *
	 * @access public
	 */
	public static function register_taxonomies()
	{
		if ( taxonomy_exists( 'property-type' ) ) {
			return;
		}
		
		// Type Taxonomy
		register_taxonomy(
				'property-type',
				array( 'property' ),
				array(
						'labels'	=> array(
								'name'	=> __( 'Types', 'app' )
						),
				'show_ui'			=> true,
				'show_admin_column'	=> true,
				'query_var'			=> true,
				)
		);
		
		// Transaction Taxonomy
		register_taxonomy(
				'property-transaction',
				array( 'property' ),
				array(
						'labels'	=> array(
								'name'	=> __( 'Transactions', 'app' )
						),
				'show_ui'			=> true,
				'show_admin_column'	=> true,
				'query_var'			=> true,
			)
		);
		
		// Features Taxonomy
		register_taxonomy(
				'property-feature',
				array( 'property' ),
				array(
						'labels'	=> array(
								'name'	=> __( 'Features', 'app' )
						),
				'show_ui'			=> true,
				'show_admin_column'	=> true,
				'query_var'			=> true,
				)
		);
		
		// Location Taxonomy
		register_taxonomy(
				'property-location',
				array( 'property' ),
				array(
						'labels'	=> array(
								'name'	=> __( 'Locations', 'app' )
						),
				'show_ui'			=> true,
				'show_admin_column'	=> true,
				'query_var'			=> true,
				'hierarchical'		=> true
				)
		);
	}
	
}

APP_Post_types::init();