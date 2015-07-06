<?php app_get_template( 'global/form-property-filter.php' ); ?>
				                    
	<?php if ( have_posts() ) : ?>
                    
	<div class="bootstrap">
		<div class="container-fluid">
			<div class="row">

				<?php
				$it = 1;
                    
				// Start the Loop.
				while ( have_posts() ) : the_post();
                    
					app_get_template_part( 'content', 'property' );
		                     
					if( ! ( $it % 3 ) ) {
						echo '<div class="clearfix visible-md visible-lg"></div>';
					}
		                     
					if( ! ( $it % 2 ) ) {
						echo '<div class="clearfix visible-sm"></div>';
					}
		                    
					$it ++;
                    
				// End the loop.
				endwhile;
				?>

		</div>
	</div>
</div>

<?php 
else :
?>

<article class="entry">
	<header class="entry-content-header">
		<h1 class='post-title entry-title'><?php _e('Nothing Found', 'avia_framework'); ?></h1>
	</header>

	<p class="entry-content" <?php avia_markup_helper(array('context' => 'entry_content')); ?>><?php _e('Sorry, no posts matched your criteria', 'avia_framework'); ?></p>

	<footer class="entry-footer"></footer>
</article>

<?php 					
endif;

echo "<div class=''>".avia_pagination('', 'nav')."</div>";
?>
