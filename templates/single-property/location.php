<?php
/**
 * Single Property
 *
 * @author 		cbmarc
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $property;

?>

<h1><?php _e( 'Location', 'app' ); ?></h1>

<?php 
$args = array(
		'taxonomy'		=> 'property-location',
		'style'			=> 'none',
		'hierarchical'	=> true,
		'echo'			=> 0,
);

$separator = ' &gt; ';

$terms = wp_list_categories( $args );
$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

echo $terms;
?>
