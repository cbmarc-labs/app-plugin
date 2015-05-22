<?php
/**
 * Single Property Image
 *
 * @author 		cbmarc
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $property;

?>
<div class="images">
eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
<?php 
		echo $property->get_gallery_attachment_ids();
?>

</div>
