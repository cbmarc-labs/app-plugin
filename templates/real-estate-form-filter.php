<?php 

global $wp_rewrite, $wp_query;
if( isset( $wp_rewrite ) && is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() )
{
	$action = get_post_type_archive_link( APP_Post_Type_Real_Estate::POST_TYPE );
}

echo "---------------------------> " . $testtest;

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
			<?php
				$safe_type = intval( $wp_query->get( 'type' ) );
			
				$args = array(
					'show_option_all'    => 'Any Type',
					'orderby'            => 'ID',
					'order'              => 'ASC',
					'show_count'         => 0,
					'hide_empty'         => 0,
					'child_of'           => 0,
					'exclude'            => '',
					'echo'               => 1,
					'selected'           => $safe_type,
					'hierarchical'       => 1,
					'name'               => 'type',
					'id'                 => '',
					'class'              => 'postform',
					'depth'              => 0,
					'tab_index'          => 0,
					'taxonomy'           => APP_Post_Type_Real_Estate::TAX_TYPE,
					'hide_if_empty'      => false,
				);
			
				wp_dropdown_categories( $args );
			?>
		</p>
		
	
		<p>
			<label for="min_rooms">Mínim d'habitacions</label>
			<?php $safe_min_rooms = empty($wp_query->query_vars['min_rooms'])?intval( $wp_query->get( 'min_rooms' ) ):''; ?>
			<input maxlength="2" name="min_rooms" id="min_rooms" value="<?php echo $safe_min_rooms; ?>" type="text">
		</p>
		
		<p>
			<label for="max_rooms">Màxim d'habitacions *</label>
			<?php $safe_max_rooms = intval( $wp_query->get( 'max_rooms' ) ); ?>
			<input maxlength="2" name="max_rooms" id="max_rooms" value="<?php echo $safe_max_rooms; ?>" type="text">
		</p>
		
		<p>
			<input value="Buscar" type="submit">			
		</p>
	
	</fieldset>
	
</form>