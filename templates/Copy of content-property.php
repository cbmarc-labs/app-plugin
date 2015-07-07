<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package APP
 */

global $property;

?>

<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
	<div class="box-effect1">
		<div class="box-container">
		
			<div class="post-thumbnail">
				<a href="<?php echo esc_url( get_permalink() ); ?>" style="display: block !important;">
					<?php echo $property->get_post_thumbnail(); ?>
				</a>
			</div>
			
			<div class="clearfix"></div>
			
			<div class="prop-info">
			
				<div class="prop-title" style="min-height: 44px;">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
					<?php
					if( strlen( $post->post_title ) > 45 ) {
						echo substr( the_title( $before = '', $after = '', FALSE ), 0, 45 ) . '...';
					} else {
						the_title();
					} 
					?>
					</a>
				</div>
				
				<div class="">			
					<?php app_get_template( 'single-property/meta.php' ); ?>
				</div>
				
			</div>
			
		</div>
	</div>
</div>