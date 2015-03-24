<?php 

global $wp_rewrite, $wp_query;
if( isset( $wp_rewrite ) && is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() )
{
	$action = get_post_type_archive_link( APP_Post_Type_Real_Estate::POST_TYPE );
}

?>

<?php if( isset( $action ) ): ?>
<form action="<?php echo $action; ?>" method="get">
<?php else:?>
<form action="<?php echo site_url( '/' ); ?>" method="get">
	<input type="text" name="post_type" value=<?php echo APP_Post_Type_Real_Estate::POST_TYPE; ?> />
<?php endif; ?>

	<fieldset>
		<div><h3>Filtre</h3></div>
		<p>Utilitzeu aquest formulari per filtrar.</p>
		
		<p>
			<label for="type">Tipus</label>
			<select name="type">
				<option value=""></option>
			</select>
			<input name="type" id="type" value="<?php /*echo $wp_query->query_vars['type'];*/ ?>" type="text">
		</p>
		
	
		<p>
			<label for="min_rooms">Mínim d'habitacions</label>
			<input maxlength="2" name="min_rooms" id="min_rooms" value="<?php echo $wp_query->query_vars[ 'min_rooms' ]; ?>" type="text">
		</p>
		
		<p>
			<label for="max_rooms">Màxim d'habitacions *</label>
			<input maxlength="2" name="max_rooms" id="max_rooms" value="<?php echo $wp_query->query_vars[ 'max_rooms' ]; ?>" type="text">
		</p>
		
		<p>
			<input value="Buscar" type="submit">			
		</p>
	
	</fieldset>
	
</form>