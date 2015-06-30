<?php
/**
 * Single Property Image
 *
 * @author 		cbmarc
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $property;

$rooms	= get_post_meta( $post->ID, '_property_rooms', 1 );
$baths	= get_post_meta( $post->ID, '_property_baths', 1 );
$m2		= get_post_meta( $post->ID, '_property_m2', 1 );
$price	= get_post_meta( $post->ID, '_property_price', 1 );

?>

<h3 class="currency" style="margin-top:0px;font-weight:bolder;"><?php echo $price; ?></h3>

<ul class="more-info">
	<li class="info-label"><span><?php _e( 'Rooms', 'app' ); ?></span><span style="float:right;"><?php echo $rooms; ?></span></li>
	<li class="info-label"><span><?php _e( 'Baths', 'app' ); ?></span><span style="float:right;"><?php echo $baths; ?></span></li>
	<li class="info-label"><span><?php _e( 'Floor space', 'app' ); ?></span><span style="float:right;"><?php echo $m2; ?></span></li>
</ul>