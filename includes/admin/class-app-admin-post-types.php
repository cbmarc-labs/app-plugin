<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Admin_Post_Types' ) ) :

/**
 * APP_Admin_Post_Types
 *
 * APP_Admin_Post_Types
 *
 * @class 		APP_Admin_Post_Types
 * @version		1.0.0
 * @package		application/includes/admin/APP_Admin_Post_Types
 * @category	Class
 * @author 		cbmarc
 */
class APP_Admin_Post_Types
{

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		add_filter( "nav_menu_items_property", array( $this, 'nav_menu_items' ), 10, 3 );
		
		add_filter( "manage_property_posts_columns", array( $this, 'manage_posts_columns' ) );
		add_action( "manage_property_posts_custom_column", array( $this, 'manage_posts_custom_column' ) , 5, 2);
		
		add_filter( "manage_edit-property_sortable_columns", array( &$this, 'manage_edit_sortable_columns' ) );
		
		add_filter( "request", array( $this, 'request' ) );
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
		$col_price			= array( 'price' => APP_Lang::_x( 'property_field_price' ) );
		$col_m2				= array( 'm2' => APP_Lang::_x( 'property_field_m2' ) );
		
		$columns = array_slice( $columns, 0, 1, true ) + $col_featured_image + array_slice( $columns, 1, NULL, true );
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
			case 'price':
				echo '<span class="autonumeric" data-a-dec="," data-a-sep="." data-v-min="0" data-v-max="9999999" data-a-sign=" €" data-p-sign="s">' . get_post_meta( $post_id , '_property_price' , true ) . '</span>';
				
				break;
			case 'm2':
				echo '<span class="autonumeric" data-a-dec="," data-a-sep="." data-v-min="0" data-v-max="999999">' . get_post_meta( $post_id , '_property_m2' , true ) . '</span>';
				
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
		$columns[ 'price' ]	= 'price';
		$columns[ 'm2' ]	= 'm2';
			
		return $columns;
	}

	// --------------------------------------------------------------------

	/**
	 * request method
	 *
	 * @access public
	 */
	function request( $vars ) {
		if ( isset( $vars[ 'orderby' ] ) && 'price' == $vars[ 'orderby' ] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => '_property_price',
				'orderby' => 'meta_value_num'
			) );
		} elseif( isset( $vars[ 'orderby' ] ) && 'm2' == $vars[ 'orderby' ] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => '_property_m2',
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
			'url'          => get_post_type_archive_link( 'property' ),
		) );
		
		return $posts;
	}
}

endif;

new APP_Admin_Post_Types();