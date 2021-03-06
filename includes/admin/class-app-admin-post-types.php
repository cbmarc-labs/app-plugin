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
		
		add_filter( "manage_edit-property_sortable_columns", array( $this, 'manage_edit_sortable_columns' ) );
		
		add_action( 'quick_edit_custom_box',  array( $this, 'quick_edit_custom_box' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		
		add_filter( "request", array( $this, 'request' ) );
		
		if ( ! function_exists( 'duplicate_post_plugin_activation' ) ) {
			include( 'class-app-admin-duplicate-property.php' );
		}
	}

	// --------------------------------------------------------------------

	/**
	 * manage_posts_columns method
	 *
	 * @access public
	 */
	function manage_posts_columns( $columns )
	{
		$col_featured_image	= array( 'featured_image' => __( 'Featured Image' , 'app' ) );
		$col_price			= array( 'price' => __( 'Price', 'app' ) );
		$col_m2				= array( 'm2' => __( 'Square meters', 'app' ) );
		
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
					echo '<img width="64" src="' . APP()->plugin_url() . '/assets/img/no_photo_available.jpg" />';
				}
				
				echo '</a>';
				
				break;
			case 'price':
				echo '<span class="autonumeric" data-a-dec="," data-a-sep="." data-v-min="0" data-v-max="9999999" data-a-sign=" €" data-p-sign="s">' . get_post_meta( $post_id , '_property_price' , true ) . '</span>';
				
				$property_rooms = get_post_meta( $post_id, '_property_rooms', 1 );
				
				echo '
					<div class="hidden" id="app_inline_' . $post_id . '">
						<div class="property_rooms">' . $property_rooms . '</div>
					</div>
				';
				
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
	 * quick_edit_custom_box method
	 *
	 * @access public
	 */
	public function quick_edit_custom_box( $column_name, $post_type )
	{
		if( 'price' != $column_name || 'property' != $post_type ) {
			return;
		}
	
		include( APP()->plugin_path() . '/includes/admin/views/html-quick-edit-property.php' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * save_post method
	 *
	 * @access public
	 */
	public function save_post( $post_id, $post )
	{	
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
	
		// Don't save revisions and autosaves
		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return $post_id;
		}
	
		// Check post type is property
		if ( 'property' != $post->post_type ) {
			return $post_id;
		}
	
		// Check user permission
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	
		// Check nonces
		if ( ! isset( $_REQUEST['app_quick_edit_nonce'] ) ) {
			return $post_id;
		}
		if ( isset( $_REQUEST['app_quick_edit_nonce'] ) && ! wp_verify_nonce( $_REQUEST['app_quick_edit_nonce'], 'app_quick_edit_nonce' ) ) {
			return $post_id;
		}
	
		if ( isset( $_REQUEST['_property_rooms'] ) ) {
			$property_rooms	= preg_replace( '/\D/', "", $_POST['_property_rooms'] );
			update_post_meta( $post_id, '_property_rooms', app_clean( $_REQUEST['_property_rooms'] ) );
		}
	
		return $post_id;
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