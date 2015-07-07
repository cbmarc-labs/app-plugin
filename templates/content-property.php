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

<div class="col-sm-6 col-md-4">
	<div class="box-effect1">
		<div class="thumbnail">
		
			<a href="<?php echo esc_url( get_permalink() ); ?>" style="display: block !important;">
				<?php echo $property->get_post_thumbnail(); ?>
			</a>
			
			<div class="caption">
				<h5 style="min-height:40px;">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
						<?php the_title(); ?>
					</a>
				</h5>
					
				<p>		
					<?php app_get_template( 'single-property/meta.php' ); ?>
				</p>
			</div>
			
		</div>
	</div>
</div>