<?php
/**
 * Single Property Image
 *
 * @author 		cbmarc
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $property;

$reference	= get_post_meta( $post->ID, '_property_reference', 1 );
$rooms		= get_post_meta( $post->ID, '_property_rooms', 1 );
$baths		= get_post_meta( $post->ID, '_property_baths', 1 );
$area		= get_post_meta( $post->ID, '_property_area', 1 );
$price		= get_post_meta( $post->ID, '_property_price', 1 );

$energy_value	= get_post_meta( $post->ID, '_property_energy', 1 );
$energy_letter	= get_post_meta( $post->ID, '_property_energy_letter', 1 );

switch( $energy_value ) {
	case 1: $energy = __( 'Yes', 'app' ) . ' (' . $energy_letter . ')'; break;
	case 2: $energy = __( 'No', 'app' ); break;
	case 3: $energy = __( 'Letter', 'app' ) . ' (' . $energy_letter . ')'; break;
	case 4: $energy = __( 'In process', 'app' ) . ' (' . $energy_letter . ')'; break;
}

?>

<h3 class="currency" style="margin-top:0px;font-weight:bolder;"><?php echo $price; ?></h3>

<ul class="more-info">
	<li class="info-label"><span><?php _e( 'Reference', 'app' ); ?></span><span style="float:right;"><?php echo $reference; ?></span></li>
	<li class="info-label"><span><?php _e( 'Rooms', 'app' ); ?></span><span style="float:right;"><?php echo $rooms; ?></span></li>
	<li class="info-label"><span><?php _e( 'Baths', 'app' ); ?></span><span style="float:right;"><?php echo $baths; ?></span></li>
	<li class="info-label"><span><?php _e( 'Area', 'app' ); ?></span><span style="float:right;"><?php echo $area; ?>&nbsp;m&sup2;</span></li>
	<?php if ( isset( $energy ) ) :?>
	<li class="info-label"><span><?php _e( 'Energy Certificate', 'app' ); ?></span><span style="float:right;"><?php echo $energy; ?></span></li>
	<?php endif; ?>
</ul>