<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Add an nonce field so we can check for it later.
wp_nonce_field( 'app_meta_box_gallery', 'app_meta_box_gallery_nonce' );

?>

<input type="hidden" name="app_meta_box_gallery_metadata" id="app_meta_box_gallery_metadata" value="<?php echo $galleryString; ?>" />

<button class="button" id="app_meta_box_gallery_select">Seleccionar</button>
<button class="button" id="app_meta_box_gallery_removeall">Borrar</button>

<div id="app_meta_box_gallery_images"><?php echo $galleryHTML; ?></div>