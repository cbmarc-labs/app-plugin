<?php
	global $avia_config, $more;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */
	 get_header();
	
		
		$showheader = true;
		if(avia_get_option('frontpage') && $blogpage_id = avia_get_option('blogpage'))
		{
			if(get_post_meta($blogpage_id, 'header', true) == 'no') $showheader = false;
		}
		
	 	if($showheader)
	 	{
			echo avia_title(array('title' => avia_which_archive()));
		}
	?>

		<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

			<div class='container template-blog '>

				<main class='content <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content','post_type'=>'post'));?>>

					<?php app_get_template( 'global/form-property-filter.php' ); ?>
				
                    <div class="category-term-description">
                        <?php echo term_description(); ?>
                    </div>
                    
                    <?php if ( have_posts() ) : ?>
                    
					<div class="bootstrap">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-12">
									<?php app_get_template( 'global/form-login.php' ); ?>
								</div>
							</div>
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

				<!--end content-->
				</main>

				<?php

				//get the sidebar
				//$avia_config['currently_viewing'] = 'blog';
				get_sidebar();

				?>

			</div><!--end container-->

		</div><!-- close default .container_wrap element -->




<?php get_footer(); ?>
