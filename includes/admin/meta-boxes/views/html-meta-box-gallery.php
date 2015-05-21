<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<input type="hidden" name="_gallery_ids" id="_gallery_ids" value="<?php echo $data['_gallery_ids']; ?>" />

<button class="button" id="app_meta_box_gallery_select"><?php APP_Lang::_ex( 'general_select' ); ?></button>

<div id="_gallery_img"><?php echo $data['_gallery_img']; ?></div>