<?php
/**
 * Single Property
 *
 * @author 		cbmarc
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $property;

if ( empty( $property ) || ! $property->exists() ) {
	return;
}

$related = $property->get_related();

if ( sizeof( $related ) == 0 ) return;

$args = array(
	'post_type'            => 'property',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => 3,
	//'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $property->id )
);

$properties = new WP_Query( $args );

if ( $properties->have_posts() ) : ?>

	<div class="related properties">

		<h2 class="page-header"><?php _e( 'Propiedades relacionadas', 'app' ); ?></h2>
<div class="row">
			<?php while ( $properties->have_posts() ) : $properties->the_post(); ?>

				<?php app_get_template_part( 'content', 'property' ); ?>

			<?php endwhile; // end of the loop. ?>
</div>
	</div>

<?php endif;

wp_reset_postdata();