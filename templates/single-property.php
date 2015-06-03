<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package APP
 */

get_header(); ?>

<div class="bootstrap">
	<div class="row">
		<div class="col-xs-offset-1 col-xs-10">

		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php app_get_template_part( 'content', 'single-property' ); ?>
		
		<?php endwhile; // end of the loop. ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>
