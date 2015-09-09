<?php
/**
 * Single Property Image
 *
 * @author 		cbmarc
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $property;

$images_ids = $property->get_gallery_attachment_ids();

if( $images_ids ) {
	$images_array = explode( ",", $images_ids );
	$it = 0;
	$active = 'active';
	$selected = 'selected';
	
	$thumbnails = '';
	$indicators = '';
	$inner = '';
	foreach( $images_array as $id ) {
		$image_url = wp_get_attachment_image_src( $id, 'large' );
		
		$thumbnails .= '<li class="col-xs-2"><a href="#" class="' . $selected . '"><img id="carousel-selector-' . $it . '" src="' . wp_get_attachment_thumb_url( $id ) . '" class="img-responsive img-thumbnail" style="width:100%;height:75px;"></a></li>';
		$indicators .= '<li data-target="#property-carousel" data-slide-to="' . $it . '" class="' . $active . '"></li>'; 
		$inner .= '<div class="item ' . $active . '" data-slide-number="' . $it . '"><img src="' . $image_url[0] . '"></div>';
		
		$active = '';
		$selected = '';
		
		$it ++;
	}
}

?>

<div id="property-carousel" class="carousel slide" data-ride="carousel">

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

<!-- thumb navigation carousel -->
<div class="hidden-xs" id="slider-thumbs">
	<ul class="list-inline">
		<?php echo $thumbnails; ?>
	</ul>
</div>