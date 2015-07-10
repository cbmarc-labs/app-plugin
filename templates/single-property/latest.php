<?php
/**
 * Single Property
 *
 * @author 		cbmarc
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$args = array(
	'post_type'			=> 'property',
	'posts_per_page'	=> 3,
	'orderby'			=> 'date',
	'order'				=> 'DESC'
);

$properties = new WP_Query( $args );

if ( $properties->have_posts() ) : ?>

<div class="bootstrap">

	<h4 class="page-header"><?php _e( 'Latest properties', 'app' ); ?></h4>
	
	<div class="row">
		<?php while ( $properties->have_posts() ) : $properties->the_post(); ?>

			<?php app_get_template_part( 'content', 'property' ); ?>

		<?php endwhile; // end of the loop. ?>
	</div>
	
</div>

<?php endif;

wp_reset_postdata();