<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Admin_Duplicate_Property' ) ) :

/**
 * APP_Admin_Duplicate_Property
*
* APP_Admin_Duplicate_Property
*
* @class 		APP_Admin_Duplicate_Property
* @version		1.0.0
* @package		application/includes/admin/APP_Admin_Duplicate_Property
* @category		Class
* @author 		cbmarc
*/
class APP_Admin_Duplicate_Property
{

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		add_action( 'admin_action_duplicate_property', array( $this, 'duplicate_property_action' ) );
		add_filter( 'post_row_actions', array( $this, 'dupe_link' ), 10, 2 );
		add_filter( 'page_row_actions', array( $this, 'dupe_link' ), 10, 2 );
		add_action( 'post_submitbox_start', array( $this, 'dupe_button' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * dupe_link method
	 *
	 * @access public
	 */
	public function dupe_link( $actions, $post )
	{
		if ( $post->post_type != 'property' ) {
			return $actions;
		}

		$actions['duplicate'] = '<a href="' . wp_nonce_url( admin_url( 'edit.php?post_type=property&action=duplicate_property&amp;post=' . $post->ID ), 'app-duplicate-property_' . $post->ID ) . '" title="' . __( 'Make a duplicate from this property', 'app' )
			. '" rel="permalink">' .  __( 'Duplicate', 'app' ) . '</a>';

		return $actions;
	}

	// --------------------------------------------------------------------

	/**
	 * dupe_button method
	 *
	 * @access public
	 */
	public function dupe_button()
	{
		global $post;

		if ( ! is_object( $post ) ) {
			return;
		}

		if ( $post->post_type != 'property' ) {
			return;
		}

		if ( isset( $_GET['post'] ) ) {
			$notifyUrl = wp_nonce_url( admin_url( "edit.php?post_type=property&action=duplicate_property&post=" . absint( $_GET['post'] ) ), 'app-duplicate-property_' . $_GET['post'] );
			?>
			<div id="duplicate-action"><a class="submitduplicate duplication" href="<?php echo esc_url( $notifyUrl ); ?>"><?php _e( 'Copy to a new draft', 'app' ); ?></a></div>
			<?php
		}
	}

	// --------------------------------------------------------------------

	/**
	 * duplicate_property_action method
	 *
	 * @access public
	 */
	public function duplicate_property_action()
	{
		if ( empty( $_REQUEST['post'] ) ) {
			wp_die( __( 'No property to duplicate has been supplied!', 'app' ) );
		}

		// Get the original page
		$id = isset( $_REQUEST['post'] ) ? absint( $_REQUEST['post'] ) : '';

		check_admin_referer( 'app-duplicate-property_' . $id );

		$post = $this->get_property_to_duplicate( $id );

		// Copy the page and insert it
		if ( ! empty( $post ) ) {
			$new_id = $this->duplicate_property( $post );

			// Redirect to the edit screen for the new draft page
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_id ) );
			exit;
		} else {
			wp_die( __( 'Product creation failed, could not find original property:', 'app' ) . ' ' . $id );
		}
	}

	// --------------------------------------------------------------------

	/**
	 * duplicate_property method
	 *
	 * @access public
	 */
	public function duplicate_property( $post, $parent = 0, $post_status = '' )
	{
		global $wpdb;

		$new_post_author    = wp_get_current_user();
		$new_post_date      = current_time( 'mysql' );
		$new_post_date_gmt  = get_gmt_from_date( $new_post_date );

		if ( $parent > 0 ) {
			$post_parent        = $parent;
			$post_status        = $post_status ? $post_status : 'publish';
			$suffix             = '';
		} else {
			$post_parent        = $post->post_parent;
			$post_status        = $post_status ? $post_status : 'draft';
			$suffix             = ' ' . __( '(Copy)', 'app' );
		}

		// Insert the new template in the post table
		$wpdb->insert(
			$wpdb->posts,
			array(
				'post_author'               => $new_post_author->ID,
				'post_date'                 => $new_post_date,
				'post_date_gmt'             => $new_post_date_gmt,
				'post_content'              => $post->post_content,
				'post_content_filtered'     => $post->post_content_filtered,
				'post_title'                => $post->post_title . $suffix,
				'post_excerpt'              => $post->post_excerpt,
				'post_status'               => $post_status,
				'post_type'                 => $post->post_type,
				'comment_status'            => $post->comment_status,
				'ping_status'               => $post->ping_status,
				'post_password'             => $post->post_password,
				'to_ping'                   => $post->to_ping,
				'pinged'                    => $post->pinged,
				'post_modified'             => $new_post_date,
				'post_modified_gmt'         => $new_post_date_gmt,
				'post_parent'               => $post_parent,
				'menu_order'                => $post->menu_order,
				'post_mime_type'            => $post->post_mime_type
			)
		);

		$new_post_id = $wpdb->insert_id;

		// Copy the taxonomies
		$this->duplicate_post_taxonomies( $post->ID, $new_post_id, $post->post_type );

		// Copy the meta information
		$this->duplicate_post_meta( $post->ID, $new_post_id );

		return $new_post_id;
	}

	// --------------------------------------------------------------------

	/**
	 * get_property_to_duplicate method
	 *
	 * @access public
	 */
	private function get_property_to_duplicate( $id )
	{
		global $wpdb;

		$id = absint( $id );

		if ( ! $id ) {
			return false;
		}

		$post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );

		if ( isset( $post->post_type ) && $post->post_type == "revision" ) {
			$id   = $post->post_parent;
			$post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );
		}

		return $post[0];
	}

	// --------------------------------------------------------------------

	/**
	 * duplicate_post_taxonomies method
	 *
	 * @access public
	 */
	private function duplicate_post_taxonomies( $id, $new_id, $post_type )
	{
		$taxonomies = get_object_taxonomies( $post_type );

		foreach ( $taxonomies as $taxonomy ) {

			$post_terms = wp_get_object_terms( $id, $taxonomy );
			$post_terms_count = sizeof( $post_terms );

			for ( $i=0; $i<$post_terms_count; $i++ ) {
				wp_set_object_terms( $new_id, $post_terms[$i]->slug, $taxonomy, true );
			}
		}
	}


	// --------------------------------------------------------------------
	
	/**
	 * duplicate_post_meta method
	 *
	 * @access public
	 */
	private function duplicate_post_meta( $id, $new_id )
	{
		global $wpdb;

		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%d;", absint( $id ) ) );

		if ( count( $post_meta_infos ) != 0 ) {

			$sql_query_sel = array();
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";

			foreach ( $post_meta_infos as $meta_info ) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes( $meta_info->meta_value );
				$sql_query_sel[]= "SELECT $new_id, '$meta_key', '$meta_value'";
			}

			$sql_query.= implode( " UNION ALL ", $sql_query_sel );
			$wpdb->query($sql_query);
		}
	}

}

endif;

return new APP_Admin_Duplicate_Property();
