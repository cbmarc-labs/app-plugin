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

<h1>Imágenes</h1>

<?php 
$images_ids = $property->get_gallery_attachment_ids();

$images_array = explode( ",", $images_ids );

foreach( $images_array as $id ):
?>

<img width="64" height="64" src="<?php echo wp_get_attachment_url( $id ); ?>" class="">

<?php endforeach; ?>
