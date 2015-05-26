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

?>

<?php if( $rooms ) : ?>
<span class="glyphicon glyphicon-th" aria-hidden="true"></span> <?php echo $rooms; ?> Habitaciones
<?php endif; ?>

<?php if( $baths ) : ?>
<span class="glyphicon glyphicon-th" aria-hidden="true"></span> <?php echo $baths; ?> Baños
<?php endif; ?>

<?php if( $m2 ) : ?>
<span class="glyphicon glyphicon-th" aria-hidden="true"></span> <?php echo $m2; ?> m2
<?php endif; ?>