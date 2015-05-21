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
aaaaaaaaaaaaaaaaaaaaaaaaa
	<?php
	
		print_r( $property->get_gallery_attachment_ids() );
		
	?>
aaaaaaaaaaaaaaaaaaaaaaaaa
</div>
