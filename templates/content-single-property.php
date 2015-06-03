<h1>Título</h1>
<a href="<?php the_permalink(); ?>">
	<?php the_title(); ?>
</a>

<h1>Descripción</h1>
<?php the_content(); ?>

<?php app_get_template( 'single-property/related.php' ); ?>

<h1>Meta</h1>

<?php app_get_template( 'single-property/meta.php' ); ?>

<?php app_get_template( 'single-property/image.php' ); ?>
<?php app_get_template( 'single-property/type.php' ); ?>
<?php app_get_template( 'single-property/transaction.php' ); ?>
<?php app_get_template( 'single-property/features.php' ); ?>
<?php app_get_template( 'single-property/location.php' ); ?>
<?php app_get_template( 'single-property/map.php' ); ?>