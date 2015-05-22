<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package APP
 */

get_header(); ?>

<div class="bootstrap">

<?php while ( have_posts() ) : the_post(); ?>

	<?php app_get_template_part( 'content', 'single-property' ); ?>

<?php endwhile; // end of the loop. ?>

</div>

<?php get_footer(); ?>
