<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Post_Type_Concertades' ) ) :

/**
 * APP_Post_Type_Concertades
 *
 * APP_Post_Type_Concertades
 *
 * @class 		APP_Post_Type_Concertades
 * @version		1.0.0
 * @package		application/includes/admin/post-types/APP_Post_Type_Concertades
 * @category	Class
 * @author 		cbmarc
 */
class APP_Post_Type_Concertades
{

	// The single instance of the class
	private static $_instance;
	
	const POST_TYPE = 'cpt_concertades';

	private $plural = 'concertades';
	private $singular = 'concertada';

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		App::log( 'APP_Post_Type_Concertades Class Initialized' );
		
		// Initialise
		add_action( "init", array( &$this, 'init' ) );

		add_filter( "request", array( &$this, 'request' ) );
		add_filter( "manage_edit-" . self::POST_TYPE . "_sortable_columns", array( &$this, 'manage_edit_sortable_columns' ) );
		add_filter( "manage_" . self::POST_TYPE . "_posts_columns", array( &$this, 'manage_posts_columns' ) );

		add_action( "manage_" . self::POST_TYPE . "_posts_custom_column", array( &$this, 'manage_posts_custom_column' ) );

		add_action( 'admin_head', array( &$this, 'admin_head' ) );

		add_filter( "nav_menu_items_" . self::POST_TYPE, array( &$this, 'nav_menu_items' ), null, 3 );
	}

	// --------------------------------------------------------------------

	/**
	 * instance method
	 *
	 * @access public
	 */
	public static function instance()
	{
		if ( is_null( self::$_instance ) )
		{
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
		global $wp_rewrite;
		
		register_post_type( self::POST_TYPE, array(
				'labels' => array(
						'name'					=> _x( ucwords( $this->plural ), 'post type general name' ),
						'singular_name'			=> _x( ucwords( $this->plural ), 'post type singular name' ),
						'add_new'				=> _x( 'Add New ' . ucwords( $this->singular ), 'add new ' . $this->singular ),
						'add_new_item'			=> __( 'Add New ' . ucwords( $this->singular ) ),
						'edit_item'				=> __( 'Edit ' . ucwords( $this->singular ) ),
						'new_item'				=> __( 'New ' . ucwords( $this->singular ) ),
						'all_items'				=> __( 'Todas las ' . ucwords( $this->plural ) ),
						'view_item'				=> __( 'View ' . ucwords( $this->singular ) ),
						'search_items'			=> __( 'Search ' . ucwords( $this->singular ) ),
						'not_found'				=> __( 'No ' . ucwords( $this->plural ) . ' encontrada' ),
						'not_found_in_trash'	=> __( 'No ' . ucwords( $this->plural ) . ' encontrada en la papelera'),
						'parent_item_colon'		=> '',
						'menu_name'				=> ucwords( $this->plural )
				),
				'public'				=> true, //true
				'show_ui'				=> true,
				//'hierarchical'			=> true,
				'has_archive'			=> true,
				//'exclude_from_search'	=> false,
				'publicly_queryable'	=> true,
				'ep_mask'				=> EP_PERMALINK,
				//'taxonomies' => array('category'),
				'supports'			=> array( 'title', 'editor', 'thumbnail', 'excerpt' ),
				'query_var' => true, 'rewrite' => true
				/*'rewrite'				=> array(
						'slug'	=> $this->singular, 'with_front' => FALSE
						),*/
		) );
		
		$cat_name = 'Categoria de concertades';
		$cat_name_singular = 'Categoria';
		
		register_taxonomy( 'concertades_cat', self::POST_TYPE, array(
				'labels' => array(
						'name'=> _x( $cat_name, 'taxonomy general name' ),
						'singular_name' => _x( $cat_name_singular, 'taxonomy singular name' ),
						'add_new' => _x( 'Add New', $cat_name_singular ),
						'add_new_item' => __( 'Add New ' . $cat_name_singular ),
						'edit_item' => __( 'Edit ' . $cat_name_singular ),
						'new_item' => __( 'New ' . $cat_name_singular ),
						'all_items' => __( 'All ' . $cat_name ),
						'view_item' => __( 'View ' . $cat_name_singular ),
						'search_items' => __( 'Search ' . $cat_name ),
						'not_found' =>  __( 'No ' . $cat_name . ' found' ),
						'not_found_in_trash' => __('No ' . $cat_name . ' found in Trash'),
						'parent_item_colon' => '',
						'menu_name' => $cat_name
				),
				'public' => true,
				'has_archive' => true,
				'show_ui' => true,
				'hierarchical' => true,
				'query_var' => true, 'rewrite' => true
		) );
		
		$tag_name = 'Etiquetas de concertades';
		$tag_name_singular = 'Etiqueta';
		
		register_taxonomy( 'concertades_tag', self::POST_TYPE, array(
				'labels' => array(
						'name'=> _x( $tag_name, 'taxonomy general name' ),
						'singular_name' => _x( $tag_name_singular, 'taxonomy singular name' ),
						'add_new' => _x( 'Add New', $tag_name_singular ),
						'add_new_item' => __( 'Add New ' . $tag_name_singular ),
						'edit_item' => __( 'Edit ' . $tag_name_singular ),
						'new_item' => __( 'New ' . $tag_name_singular ),
						'all_items' => __( 'All ' . $tag_name ),
						'view_item' => __( 'View ' . $tag_name_singular ),
						'search_items' => __( 'Search ' . $tag_name ),
						'not_found' =>  __( 'No ' . $tag_name . ' found' ),
						'not_found_in_trash' => __('No ' . $tag_name . ' found in Trash'),
						'parent_item_colon' => '',
						'menu_name' => $tag_name
				),
				'public' => true,
				'has_archive' => true,
				'show_ui' => true,
				'hierarchical' => true,
				'query_var' => true, 'rewrite' => true
		) );
	}

	// --------------------------------------------------------------------

	/**
	 * request method
	 *
	 * @access public
	 */
	function request( $vars )
	{
		return $vars;
	}

	// --------------------------------------------------------------------

	/**
	 * manage_edit_sortable_columns method
	 *
	 * @access public
	 */
	function manage_edit_sortable_columns( $cols )
	{
		return $cols;
	}

	// --------------------------------------------------------------------

	/**
	 * manage_posts_columns method
	 *
	 * @access public
	 */
	function manage_posts_columns( $cols )
	{
		return $cols;
	}

	// --------------------------------------------------------------------

	/**
	 * manage_posts_custom_column method
	 *
	 * @access public
	 */
	function manage_posts_custom_column( $col )
	{
	}

	// --------------------------------------------------------------------

	/**
	 * admin_head method
	 *
	 * @access public
	 */
	function admin_head()
	{
		echo "";
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * rewrite_rules_array method
	 * 
	 * @access public
	 */
	function rewrite_rules_array( $rules )
	{		
		$new_rules = array(
			"{$this->plural}/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$" => 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$" => 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$" => 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$" => 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$" => 'index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$" => 'index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$" => 'index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/([0-9]{1,2})/?$" => 'index.php?year=$matches[1]&monthnum=$matches[2]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$" => 'index.php?year=$matches[1]&feed=$matches[2]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$" => 'index.php?year=$matches[1]&feed=$matches[2]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/page/?([0-9]{1,})/?$" => 'index.php?year=$matches[1]&paged=$matches[2]' . '&post_type=' . self::POST_TYPE,
			"{$this->plural}/([0-9]{4})/?$" => 'index.php?year=$matches[1]' . '&post_type=' . self::POST_TYPE,
		);
		
		return ($new_rules + $rules);
	}

	// --------------------------------------------------------------------

	/**
	 * nav_menu_items method
	 * 
	 * Crea un apartado en el apartado menu, para ver todas las entradas
	 *
	 * @access public
	 */
	public function nav_menu_items( $posts, $args, $post_type )
	{
		global $_nav_menu_placeholder, $wp_rewrite;
		
		$_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;
		$url = '?post_type=' . self::POST_TYPE;
		
		if( get_option('permalink_structure') )
		{
			$url = $this->plural;
		}
		
		array_unshift( $posts, (object) array(
				'ID' => 0,
				'object_id' => $_nav_menu_placeholder,
				'post_content' => '',
				'post_excerpt' => '',
				'post_title' => $post_type['args']->labels->all_items,
				'post_type' => 'nav_menu_item',
				'type' => 'custom',
				'url' => get_site_url() . "/" . $url
		) );
		
		return $posts;
	}

	// --------------------------------------------------------------------

	/**
	 * admin_bar_menu method
	 * 
	 * Crea un link en la parte superior del front-end para acceder a las entradas
	 *
	 * @access public
	 */	
	public function admin_bar_menu()
	{
		global $wp_admin_bar;
		
		$url = '?post_type=' . self::POST_TYPE;
		
		if( get_option('permalink_structure') )
		{
			$url = $this->plural;
		}
		
		$args = array(
				'id' => 'admin-bar-menu-' . self::POST_TYPE,
				'title' => ucwords( $this->plural ),
				'href' => get_site_url() . "/" . $url,
				'meta' => array(
						'class' => 'admin-bar-menu-class-' . self::POST_TYPE
				)
		);
		
		$wp_admin_bar->add_node($args);
	}

} // end class APP_Post_Type_Concertades

endif;

/**
 * Create instance
 */
global $APP_Post_Type_Concertades;
if( class_exists( 'APP_Post_Type_Concertades' ) && !$APP_Post_Type_Concertades )
{
	$APP_Post_Type_Concertades = APP_Post_Type_Concertades::instance();
}