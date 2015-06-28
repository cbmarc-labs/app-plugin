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

				<main class='content <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content','post_type'=>'property'));?> style="padding-top:10px;">
                    
                    <div class="bootstrap">
                    <div class="container-fluid">
                    <div class="row">
                    
                    <?php app_get_template( 'global/form-property-filter.php' ); ?>

                    
                    <?php
                    
                    $it = 1;
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

				<!--end content-->
				</main>
		
		<?php		
				// Previous/next page navigation.
			echo avia_pagination('', 'nav');
		

				//get the sidebar
				$avia_config['currently_viewing'] = 'blog';
				get_sidebar();

				?>

			</div><!--end container-->

		</div><!-- close default .container_wrap element -->




<?php get_footer(); ?>
