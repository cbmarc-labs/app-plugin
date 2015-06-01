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

<h1>Transacción</h1>

<?php
$terms = get_the_terms( $post->ID, 'property-transaction' );

$out = array();
if ( $terms && ! is_wp_error( $terms ) ) {
	foreach ( $terms as $term ) {
		$out[] = '<a href="' . get_term_link( $term->slug, 'property-transaction' ) . '">' . $term->name . "</a>";
	}
}
?>

<p><?php echo implode( ", ", $out ); ?></p>
