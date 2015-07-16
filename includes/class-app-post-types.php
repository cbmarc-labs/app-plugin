<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Post_Types
 *
 * Clase APP_Post_Types
 *
 * @class 		APP_Post_Types
 * @version		1.0.0
 * @package		Application/includes/APP_Post_Types
 * @category	Class
 * @author 		marc
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
		if ( post_type_exists('project') ) {
			return;
		}
		
		register_post_type(
			'project', 
			array(
				'labels'				=> array(
					'name' => __( 'projects', 'app' )
				),
		        'menu_icon'				=> 'dashicons-tablet',
				'public'				=> true,
				'show_ui'				=> true,
				// only with wpml 3.2
				'has_archive'			=> __( 'projects', 'app' ),
        		'publicly_queryable'	=> true,
				'query_var'				=> true,
				'show_in_menu'			=> true,
				'show_in_nav_menus'		=> true,
				'supports' => array(
						'title', 'editor', 'thumbnail'
				),
				'rewrite' => array(
						// only with wpml
						'slug'			=> _x( 'project', 'URL slug', 'app' ),
						'with_front'	=> false,
						'pages'			=> true,
						'feeds'			=> true,
						'ep_mask'		=> EP_PERMALINK,
				)
			)
		);
	}
	
}

APP_Post_types::init();