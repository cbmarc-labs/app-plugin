<h1>Título</h1>

<a href="<?php the_permalink(); ?>">
	<?php the_title(); ?>
</a>

<h1>Descripción</h1>
<?php the_content(); ?>

<?php
app_get_template( 'single-property/related.php' );
app_get_template( 'single-property/meta.php' );
app_get_template( 'single-property/image.php' );
app_get_template( 'single-property/type.php' );
app_get_template( 'single-property/transaction.php' );
app_get_template( 'single-property/features.php' );
app_get_template( 'single-property/location.php' );
?>