<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Post_Type_Property' ) ) :

/**
 * APP_Post_Type_Property
 *
 * APP_Post_Type_Property
 *
 * @class 		APP_Post_Type_Property
 * @version		1.0.0
 * @package		application/includes/admin/post-types/APP_Post_Type_Property
 * @category	Class
 * @author 		cbmarc
 */
class APP_Post_Type_Property
{
	// singleton instance
	private static $_instance;
	
	// Post type name
	const POST_TYPE = 'property';
	
	// Taxonomy type name
	const TAX_TYPE = 'property-type';
	
	// Taxonomy transaction name
	const TAX_STATUS = 'property-status';
	
	// Taxonomy transaction name
	const TAX_FEATURE = 'property-feature';

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		App::log( 'APP_Post_Type_Property Class Initialized' );
		
		// Initialise
		add_action( "init", array( &$this, 'init' ) );
		
		add_filter( "request", array( $this, 'request' ) );
		
		add_filter( "nav_menu_items_" . self::POST_TYPE, array( $this, 'nav_menu_items' ), 10, 3 );
		
		add_filter( "manage_" . self::POST_TYPE . "_posts_columns", array( $this, 'manage_posts_columns' ) );
		add_action( "manage_" . self::POST_TYPE . "_posts_custom_column", array( $this, 'manage_posts_custom_column' ) , 5, 2);
		
		add_filter( "manage_edit-" . self::POST_TYPE . "_sortable_columns", array( &$this, 'manage_edit_sortable_columns' ) );
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
			self::POST_TYPE, 
			array(
				'labels'				=> array(
					'name' => App::lang( self::POST_TYPE )
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
						'title', 'editor', 'excerpt', 'thumbnail'
				),
				'rewrite' => array(
						'slug'			=> self::POST_TYPE,
						'with_front'	=> false,
						'pages'			=> true,
						'feeds'			=> true,
						'ep_mask'		=> EP_PERMALINK,
				)
			)
		);
		
		// Type Taxonomy
		register_taxonomy(
			self::TAX_TYPE,
			array( self::POST_TYPE ),
			array(
				'labels'            => array(
					'name' => App::lang( self::TAX_TYPE )
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
			)
		);
		
		// Transaction Taxonomy
		register_taxonomy(
			self::TAX_STATUS,
			array( self::POST_TYPE ),
			array(
				'labels'            => array(
					'name' => App::lang( self::TAX_STATUS )
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
			)
		);
		
		// Features Taxonomy
		register_taxonomy(
			self::TAX_FEATURE,
			array( self::POST_TYPE ),
			array(
				'labels'            => array(
					'name' => App::lang( self::TAX_FEATURE )
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
			)
		);
	}

	// --------------------------------------------------------------------

	/**
	 * request method
	 *
	 * @access public
	 */
	function request( $vars ) {
		if ( isset( $vars[ 'orderby' ] ) && 'rooms' == $vars[ 'orderby' ] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => '_app_property_rooms',
				'orderby' => 'meta_value_num'
			) );
		} elseif ( isset( $vars[ 'orderby' ] ) && 'price' == $vars[ 'orderby' ] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => '_app_property_price',
				'orderby' => 'meta_value_num'
			) );
		} elseif( isset( $vars[ 'orderby' ] ) && 'm2' == $vars[ 'orderby' ] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => '_app_property_m2',
				'orderby' => 'meta_value_num'
			) );
		} elseif( !isset( $_GET[ 'orderby' ] ) ) {
			$vars = array_merge( $vars, array(
					'order' => 'desc',
					'orderby' => 'date'
			) );
		}
		
		return $vars;
	}

	// --------------------------------------------------------------------

	/**
	 * manage_posts_columns method
	 *
	 * @access public
	 */
	function manage_posts_columns( $columns )
	{
		$col_featured_image	= array( 'featured_image' => __('Featured Image') );
		$col_rooms			= array( 'rooms' => App::lang( 'cpt_property_field_rooms' ) );
		$col_price			= array( 'price' => App::lang( 'cpt_property_field_price' ) );
		$col_m2				= array( 'm2' => App::lang( 'cpt_property_field_m2' ) );
		
		$columns = array_slice( $columns, 0, 1, true ) + $col_featured_image + array_slice( $columns, 1, NULL, true );
		$columns = array_slice( $columns, 0, 3, true ) + $col_rooms + array_slice( $columns, 3, NULL, true );
		$columns = array_slice( $columns, 0, 4, true ) + $col_price + array_slice( $columns, 4, NULL, true );
		$columns = array_slice( $columns, 0, 5, true ) + $col_m2 + array_slice( $columns, 5, NULL, true );
		
		return $columns;
	}

	// --------------------------------------------------------------------

	/**
	 * manage_posts_custom_column method
	 *
	 * @access public
	 */
	function manage_posts_custom_column( $column, $post_id )
	{
		switch ( $column ) {
			case 'featured_image':
				echo '<a href="' . admin_url( "post.php?post=$post_id&action=edit" ) . '">';
				
				if( has_post_thumbnail() ) {
					echo get_the_post_thumbnail( $post_id, array( 64, 64 ) );
				} else {
					echo '<img width="64" src="' . APP_TEMPLATE_DIR . 'assets/img/no_photo_available.jpg" />';
				}
				
				echo '</a>';
				
				break;
			case 'rooms':
				echo get_post_meta( $post_id , '_app_property_rooms' , true );
				
				break;
			case 'price':
				echo '<span class="currency">' . get_post_meta( $post_id , '_app_property_price' , true ) . '</span>';
				
				break;
			case 'm2':
				echo '<span class="numeric">' . get_post_meta( $post_id , '_app_property_m2' , true ) . '</span>';
				
				break;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * manage_edit_sortable_columns method
	 *
	 * @access public
	 */
	function manage_edit_sortable_columns( $columns )
	{
		$columns[ 'rooms' ]	= 'rooms';
		$columns[ 'price' ]	= 'price';
		$columns[ 'm2' ]	= 'm2';
			
		return $columns;
	}

	// --------------------------------------------------------------------

	/**
	 * nav_menu_items method
	 *
	 * @access public
	 */
	function nav_menu_items( array $posts, array $meta_box, array $post_type )
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
			'post_title'   => 'All',
			'label'        => 'All', # http://core.trac.wordpress.org/ticket/24840
			'type'         => 'custom',
			'url'          => get_post_type_archive_link( self::POST_TYPE ),
		) );
		
		return $posts;
	}

} // end class APP_Post_Type_Property

endif;

/**
 * Create instance
 */
global $APP_Post_Type_Property;
if( class_exists( 'APP_Post_Type_Property' ) && ! $APP_Post_Type_Property ) {
	$APP_Post_Type_Property = APP_Post_Type_Property::instance();
}