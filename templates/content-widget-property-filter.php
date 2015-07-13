<?php 

global $wp_rewrite, $wp_query;
if( isset( $wp_rewrite ) && is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) {
	$action = get_post_type_archive_link( 'property' );
}

// default values
$type			= 0;
$transaction	= 0;
$min_rooms		= '';
$min_area			= '';
$max_price		= '';

// Safe values
if( isset( $wp_query->query_vars['type'] ) && !empty( $wp_query->query_vars['type'] ) )
	$type = sanitize_text_field( $wp_query->query_vars['type'] );

if( isset( $wp_query->query_vars['transaction'] ) && !empty( $wp_query->query_vars['transaction'] ) )
	$transaction = sanitize_text_field( $wp_query->query_vars['transaction'] );

if( isset( $wp_query->query_vars['min_rooms'] ) && !empty( $wp_query->query_vars['min_rooms'] ) )
	$min_rooms = intval( $wp_query->query_vars['min_rooms'] );

if( isset( $wp_query->query_vars['max_price'] ) && !empty( $wp_query->query_vars['max_price'] ) )
	$max_price = intval( $wp_query->query_vars['max_price'] );

if( isset( $wp_query->query_vars['min_area'] ) && !empty( $wp_query->query_vars['min_area'] ) )
	$min_area = intval( $wp_query->query_vars['min_area'] );

?>

<br>

<div class="bootstrap">

<?php if( isset( $action ) ): ?>
<form action="<?php echo $action; ?>" method="get">
<?php else:?>
<form action="<?php echo site_url( '/' ); ?>" method="get">
	<input type="hidden" name="post_type" value='property' />
<?php endif; ?>

<div class="container-fluid" style="padding:0px;">
	<div class="well">
		<div class="row">
		
			<div class="col-xs-12">
				<h3>Filtre inmobles</h3>
				<hr>
			</div>
		
			<div class="col-xs-12 form-group">
				<label for="type" class="control-label">Tipus</label>
				<?php
					$args = array(
						'show_option_all'    => 'Todos',
						'orderby'            => 'slug',
						'order'              => 'ASC',
						'show_count'         => 0,
						'hide_empty'         => 0,
						'child_of'           => 0,
						'exclude'            => '',
						'echo'               => 1,
						'selected'           => $type,
						'hierarchical'       => 1,
						'name'               => 'type',
						'id'                 => '',
						'class'              => 'form-control',
						'depth'              => 0,
						'tab_index'          => 0,
						'taxonomy'           => 'property-type',
						'hide_if_empty'      => false,
						'walker'             => new SH_Walker_TaxonomyDropdown(),
						'value'              => 'slug'
					);
				
					wp_dropdown_categories( $args );
				?>
			</div>
			
			<div class="col-xs-12 form-group">
				<label for="transaction" class="control-label">Transacción</label>
				<?php
					$args = array(
						'show_option_all'    => 'Todos',
						'orderby'            => 'slug',
						'order'              => 'ASC',
						'show_count'         => 0,
						'hide_empty'         => 0,
						'child_of'           => 0,
						'exclude'            => '',
						'echo'               => 1,
						'selected'           => $transaction,
						'hierarchical'       => 1,
						'name'               => 'transaction',
						'id'                 => '',
						'class'              => 'form-control',
						'depth'              => 0,
						'tab_index'          => 0,
						'taxonomy'           => 'property-transaction',
						'hide_if_empty'      => false,
						'walker'             => new SH_Walker_TaxonomyDropdown(),
						'value'              => 'slug'
					);
				
					wp_dropdown_categories( $args );
				?>
			</div>
	
			<div class="col-xs-12 form-group">
				<label for="" class="control-label">Superficie mínima</label>
				<select name="min_area" class="form-control">
					<option value="">Todos</option>
					<?php foreach( array(50,100,150,200,250,300) as $value) : ?>
					<option value="<?php echo $value; ?>" 
					<?php selected( $value, $min_area ); ?>><?php echo $value ?> area</option>
					<?php endforeach; ?>
				</select>
			</div>
	
			<div class="col-xs-12 form-group">
				<label for="" class="control-label">Precio máximo</label>
				<select name="max_price" class="form-control">
					<option value="">Todos</option>
					<?php foreach( array(50000,100000,150000,200000,250000,300000,
							350000,400000,450000,500000,550000,600000,650000,700000,800000,
							1000000,1500000,3000000) as $value) : ?>
					<option value="<?php echo $value; ?>" 
					<?php selected( $value, $max_price ); ?>><?php echo number_format($value, 0, ',', '.') ?> €</option>
					<?php endforeach; ?>
				</select>
			</div>
	
			<div class="col-xs-12 form-group">
				<label for="" class="control-label">Habitaciones mínimas</label>
				<input type="number" name="min_rooms" min="0" class="form-control" value="<?php echo $min_rooms; ?>" />
			</div>
			
			<div class="col-xs-12 form-group">
				<label class="control-label">&nbsp;</label>
				<button class="btn btn-primary form-control" type="submit">
					<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Buscar
				</button>
			</div>
			
		</div>
	</div>
</div>
	
</form>

</div>