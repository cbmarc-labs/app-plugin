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

<div class="page-header">
	<h4><?php _e( 'Type', 'app' ); ?></h4>
</div>

<?php
$terms = get_the_terms( $post->ID, 'property-type' );

$out = array();
if ( $terms && ! is_wp_error( $terms ) ) {
	foreach ( $terms as $term ) {
		$out[] = '<a href="' . get_term_link( $term->slug, 'property-type' ) . '">' . $term->name . "</a>";
	}
}
?>

<p><?php echo implode( ", ", $out ); ?></p>
