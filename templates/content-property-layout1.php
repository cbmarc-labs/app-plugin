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

<div class="col-md-4">
	<div class="post-thumbnail">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php echo $property->get_post_thumbnail(); ?>
		</a>
	</div>
	<div class="prop-info">
		<?php
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	
		app_get_template( 'single-property/meta.php' );
		?>
	</div>
</div>