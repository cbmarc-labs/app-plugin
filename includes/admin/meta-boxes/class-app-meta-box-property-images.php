<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Meta_Box_Property_Images
 *
 * APP_Meta_Box_Property_Images
 *
 * @class 		APP_Meta_Box_Property_Images
 * @version		1.0.0
 * @package		application/includes/admin/APP_Meta_Box_Property_Images
 * @category		Class
 * @author 		cbmarc
 */
class APP_Meta_Box_Property_Images
{
	// --------------------------------------------------------------------

	/**
	 * output method
	 *
	 * @access public
	 */
	public static function output( $post ) {
		?>
		<div id="property_images_container">
			<ul class="property_images">
				<?php
					if ( metadata_exists( 'post', $post->ID, '_property_image_gallery' ) ) {
						$property_image_gallery = get_post_meta( $post->ID, '_property_image_gallery', true );
					} else {
						// Backwards compat
						$attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_key=_app_exclude_image&meta_value=0' );
						$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
						$property_image_gallery = implode( ',', $attachment_ids );
					}

					$attachments = array_filter( explode( ',', $property_image_gallery ) );

					if ( $attachments ) {
						foreach ( $attachments as $attachment_id ) {
							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
								' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
								<ul class="actions">
									<li><a href="#" class="delete tips" data-tip="' . __( 'Delete image', 'app' ) . '">' . __( 'Delete', 'app' ) . '</a></li>
								</ul>
							</li>';
						}
					}
				?>
			</ul>

			<input type="hidden" id="property_image_gallery" name="property_image_gallery" value="<?php echo esc_attr( $property_image_gallery ); ?>" />

		</div>
		<p class="add_property_images hide-if-no-js">
			<a href="#" data-choose="<?php _e( 'Add Images to Property Gallery', 'app' ); ?>" data-update="<?php _e( 'Add to gallery', 'app' ); ?>" data-delete="<?php _e( 'Delete image', 'app' ); ?>" data-text="<?php _e( 'Delete', 'app' ); ?>"><?php _e( 'Add property gallery images', 'app' ); ?></a>
		</p>
		<?php
	}
	// --------------------------------------------------------------------

	/**
	 * save method
	 *
	 * @access public
	 */
	public static function save( $post_id, $post )
	{
		$attachment_ids = isset( $_POST['property_image_gallery'] ) ? array_filter( explode( ',', app_clean( $_POST['property_image_gallery'] ) ) ) : array();

		update_post_meta( $post_id, '_property_image_gallery', implode( ',', $attachment_ids ) );
	}
}
