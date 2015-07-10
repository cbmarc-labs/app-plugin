<div class="col-sm-8">
	<?php app_get_template( 'single-property/image.php' ); ?>
	
	<div class="clearfix"></div>
	
	<h3>
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h3>

	<p><?php the_content(); ?></p>
	
</div>
<div class="col-sm-4 pull-right">
	<div class="page-header">
		<h4><?php _e( 'Property data', 'app' ); ?></h4>
	</div>
	
	<?php app_get_template( 'single-property/meta.php' ); ?>
	<?php app_get_template( 'single-property/type.php' ); ?>
	<?php app_get_template( 'single-property/transaction.php' ); ?>
	<?php app_get_template( 'single-property/features.php' ); ?>
	<?php app_get_template( 'single-property/location.php' ); ?>
	
	<?php app_get_template( 'single-property/form-contact.php' ); ?>
</div>

<div class="col-sm-8">
	<?php app_get_template( 'single-property/map.php' ); ?>
	<?php avia_social_share_links(); ?>
</div>

<div class="clearfix"></div>

<br><br>

<div class="col-sm-12">
	<?php app_get_template( 'single-property/related.php' ); ?>
</div>