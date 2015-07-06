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

<?php

$images_ids = $property->get_gallery_attachment_ids();

if( $images_ids ) {
	$images_array = explode( ",", $images_ids );
	$it = 0;
	$active = 'active';
	
	$indicators = '';
	$inner = '';
	foreach( $images_array as $id ) {
		$indicators .= '<li data-target="#carousel-example-generic" data-slide-to="' . $it . '" class="' . $active . '"></li>'; 
		$inner .= '<div class="item ' . $active . '"><img width="100%;" style="height:400px;" src="' . wp_get_attachment_url( $id ) . '"></div>';
		
		$active = '';
		$it ++;
	}
}

?>

<ol class="carousel-indicators">
<?php echo $indicators; ?>
</ol>
<div class="carousel-inner" role="listbox">
<?php echo $inner; ?>
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