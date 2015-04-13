<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !class_exists( 'APP_Post_Type_Real_Estate' ) ) :

/**
 * APP_Post_Type_Real_Estate
 *
 * APP_Post_Type_Real_Estate
 *
 * @class 		APP_Post_Type_Real_Estate
 * @version		1.0.0
 * @package		application/includes/admin/post-types/APP_Post_Type_Real_Estate
 * @category	Class
 * @author 		cbmarc
 */
class APP_Post_Type_Real_Estate
{
	// singleton instance
	private static $_instance;
	
	// Post type name
	const POST_TYPE = 'cpt_real_estate'; // app-real-estate
	
	// Taxonomy type name
	const TAX_TYPE = 'cpt_real_estate_type';

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		App::log( 'APP_Post_Type_Real_Estate Class Initialized' );
		
		// Initialise
		add_action( "init", array( &$this, 'init' ) );
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
		$labels = array(
				'name' => _x( 'Real Estate', 'Real Estate', 'app' ),
		);
		
		$args = array(
				/**
				 * Labels used when displaying the posts in the admin and sometimes on the front end.  These
				 * labels do not cover post updated, error, and related messages.  You'll need to filter the
				 * 'post_updated_messages' hook to customize those.
				 */
				'labels'              => $labels,
				
				/**
		         * The URI to the icon to use for the admin menu item. There is no header icon argument, so 
		         * you'll need to use CSS to add one.
		         */
		        'menu_icon'           => 'dashicons-format-aside', // string (defaults to use the post icon)
				
				/**
				 * Whether the post type should be used publicly via the admin or by front-end users.  This
				 * argument is sort of a catchall for many of the following arguments.  I would focus more
				 * on adjusting them to your liking than this argument.
				 */
				'public'              => true, // bool (default is FALSE)
				
				/**
				 * Whether to generate a default UI for managing this post type in the admin. You'll have
				 * more control over what's shown in the admin with the other arguments.  To build your
				 * own UI, set this to FALSE.
				 */
				'show_ui'             => true, // bool (defaults to 'public')
				
				/**
				 * Whether the post type has an index/archive/root page like the "page for posts" for regular
				 * posts. If set to TRUE, the post type name will be used for the archive slug.  You can also
				 * set this to a string to control the exact name of the archive slug.
				 */
				'has_archive'           => true, // bool|string (defaults to FALSE)
				
				/**
         		 * Whether queries can be performed on the front end as part of parse_request(). 
         		 */
        		'publicly_queryable'  => true, // bool (defaults to 'public').
				
				/**
				 * Sets the query_var key for this post type. If set to TRUE, the post type name will be used.
				 * You can also set this to a custom string to control the exact key.
				 */
				'query_var'             => true, // bool|string (defaults to TRUE - post type name)
				
				/**
				 * How the URL structure should be handled with this post type.  You can set this to an
				 * array of specific arguments or true|false.  If set to FALSE, it will prevent rewrite
				 * rules from being created.
				 */
				'rewrite' => array(
				
						/* The slug to use for individual posts of this type. */
						'slug'       => self::POST_TYPE, // string (defaults to the post type name)
				
						/* Whether to show the $wp_rewrite->front slug in the permalink. */
						'with_front' => false, // bool (defaults to TRUE)
				
						/* Whether to allow single post pagination via the <!--nextpage--> quicktag. */
						'pages'      => true, // bool (defaults to TRUE)
				
						/* Whether to create feeds for this post type. */
						'feeds'      => true, // bool (defaults to the 'has_archive' argument)
				
						/* Assign an endpoint mask to this permalink. */
						'ep_mask'    => EP_PERMALINK, // const (defaults to EP_PERMALINK)
				),
		);
				
		register_post_type( self::POST_TYPE, $args );
		
		// Taxonomies
		$labels = array(
				'name' => _x( 'Type', 'Taxonomy general name', 'app' ),
		);
		
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
		);
		
		// app_real_estate_types
		register_taxonomy( self::TAX_TYPE, array( self::POST_TYPE ), $args );
	}

} // end class APP_Post_Type_Real_Estate

endif;

/**
 * Create instance
 */
global $APP_Post_Type_Real_Estate;
if( class_exists( 'APP_Post_Type_Real_Estate' ) && ! $APP_Post_Type_Real_Estate ) {
	$APP_Post_Type_Real_Estate = APP_Post_Type_Real_Estate::instance();
}