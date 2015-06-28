<?php
global $avia_config;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */
	 get_header();


 	 if( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title();
	 ?>

		<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

			<div class='container'>

				<main class='template-page template-portfolio content  <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content','post_type'=>'portfolio'));?>>


<div class="bootstrap">
	<div class="row">
		<div class="col-xs-12">

		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php app_get_template_part( 'content', 'single-property' ); ?>
		
		<?php endwhile; // end of the loop. ?>

		</div>
	</div>
</div>
</main>
</div></div>

<?php get_footer(); ?>
