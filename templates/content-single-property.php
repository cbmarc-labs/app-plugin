<div class="row">
	<div class="col-sm-8">
		<?php app_get_template( 'single-property/image.php' ); ?>
	</div>
	<div class="col-sm-4">
		<h4><?php _e( 'Features', 'app' ); ?></h4>
		<?php app_get_template( 'single-property/meta.php' ); ?>
	</div>
</div>

<h3>
	<a href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a>
</h3>

<p>
	<?php the_content(); ?>
</p>

<?php app_get_template( 'single-property/type.php' ); ?>
<?php app_get_template( 'single-property/transaction.php' ); ?>
<?php app_get_template( 'single-property/features.php' ); ?>
<?php app_get_template( 'single-property/location.php' ); ?>
<?php app_get_template( 'single-property/map.php' ); ?>


<?php app_get_template( 'single-property/related.php' ); ?>

<?php avia_social_share_links(); ?>