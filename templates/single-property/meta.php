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

<ul class="more-info">
	<li class="info-label"><span>Habitaciones</span><span style="float:right;"><?php echo $rooms; ?></span></li>
	<li class="info-label"><span>Baños</span><span style="float:right;"><?php echo $baths; ?></span></li>
	<li class="info-label"><span>m2</span><span style="float:right;"><?php echo $m2; ?></span></li>
	<li class="info-label"><span>precio</span><span style="float:right;" class="currency"><?php echo $price; ?></span></li>
</ul>