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

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	<div class="carousel-inner" role="listbox">

<?php

$images_ids = $property->get_gallery_attachment_ids();

if( $images_ids ) {
	$images_array = explode( ",", $images_ids );
	$active = 'active';
	
	foreach( $images_array as $id ) {
		echo '<div class="item ' . $active . '">';
		echo '<img width="100%;" src="' . wp_get_attachment_url( $id ) . '">';
		echo '</div>';
		
		$active = '';
	}
}

?>

</div>
<!-- Controls -->
  <a class="left carousel-control" onclick="jQuery(this).closest('.carousel').carousel('prev');" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" onclick="jQuery(this).closest('.carousel').carousel('next');" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>