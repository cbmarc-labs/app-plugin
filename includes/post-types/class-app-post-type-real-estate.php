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
		
		//add_filter( "nav_menu_items_cpt_real_estate", array( $this, 'nav_menu_items' ), 10, 3 );
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
	function nav_menu_items(  array $posts, array $meta_box, array $post_type  )
	{
		global $_nav_menu_placeholder;
		$pto = $post_type['args'];
		$_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval( $_nav_menu_placeholder ) - 1 : -1;
		# Add our 'All Posts' item to the beginning of the list:
		array_unshift( $posts, (object) array(
			'ID'           => 0,
			'object_id'    => $_nav_menu_placeholder,
			'post_content' => '',
			'post_excerpt' => '',
			'post_parent'  => 0,
			'post_type'    => 'nav_menu_item',
			'post_title'   => 'sssss',
			'label'        => 'dddddd', # http://core.trac.wordpress.org/ticket/24840
			'type'         => 'custom',
			'url'          => get_post_type_archive_link( 'cpt_real_estate' ),
		) );
		return $posts;
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
				'labels'				=> $labels,
		        'menu_icon'				=> 'dashicons-format-aside',
				'public'				=> true,
				'show_ui'				=> true,
				'has_archive'			=> true,
        		'publicly_queryable'	=> true,
				'query_var'				=> true,
				'show_in_menu' => true,
				'show_in_nav_menus' => true,
				'supports' => array(
						'title', 'editor', 'excerpt', 'thumbnail'
				),
				'rewrite' => array(
						'slug'			=> self::POST_TYPE,
						'with_front'	=> false,
						'pages'			=> true,
						'feeds'			=> true,
						'ep_mask'		=> EP_PERMALINK,
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