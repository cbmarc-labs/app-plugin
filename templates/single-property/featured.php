<?php
/**
 * Single Property
 *
 * @author 		cbmarc
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$args = array(
	'post_type'            => 'property',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => 3,
	'meta_query'=> array(
			array(
					'key' => '_property_featured',
					'compare' => '=',
					'value' => 1
			)
	)
);

$properties = new WP_Query( $args );

if ( $properties->have_posts() ) : ?>

<div class="bootstrap">
	<div class="container-fluid">
	
		<div class="featured properties">

			<div class="page-header">
				<h4><?php _e( 'Featured properties', 'app' ); ?></h4>
			</div>
			
			<div class="row">
				<?php while ( $properties->have_posts() ) : $properties->the_post(); ?>

					<?php app_get_template_part( 'content', 'property' ); ?>

				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>
</div>

<?php endif;

wp_reset_postdata();