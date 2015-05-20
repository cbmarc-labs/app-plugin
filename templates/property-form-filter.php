<?php 

global $wp_rewrite, $wp_query;
if( isset( $wp_rewrite ) && is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) {
	$action = get_post_type_archive_link( 'property' );
}

// default values
$type			= 0;
$transaction	= 0;
$min_rooms		= '';
$min_m2			= '';
$max_price		= 500000;

// Safe values
if( isset( $wp_query->query_vars['type'] ) && !empty( $wp_query->query_vars['type'] ) )
	$type = sanitize_text_field( $wp_query->query_vars['type'] );

if( isset( $wp_query->query_vars['transaction'] ) && !empty( $wp_query->query_vars['transaction'] ) )
	$transaction = sanitize_text_field( $wp_query->query_vars['transaction'] );

if( isset( $wp_query->query_vars['min_rooms'] ) && !empty( $wp_query->query_vars['min_rooms'] ) )
	$min_rooms = intval( $wp_query->query_vars['min_rooms'] );

if( isset( $wp_query->query_vars['max_price'] ) && !empty( $wp_query->query_vars['max_price'] ) )
	$max_price = intval( $wp_query->query_vars['max_price'] );

if( isset( $wp_query->query_vars['min_m2'] ) && !empty( $wp_query->query_vars['min_m2'] ) )
	$min_m2 = intval( $wp_query->query_vars['min_m2'] );

?>

<br>

<div class="bootstrap">

<?php if( isset( $action ) ): ?>
<form action="<?php echo $action; ?>" method="get">
<?php else:?>
<form action="<?php echo site_url( '/' ); ?>" method="get">
	<input type="hidden" name="post_type" value='property' />
<?php endif; ?>

<div class="container-fluid">
	<div class="well">
		<div class="row">
		
			<div class="col-xs-12">
				<h3>Filtre</h3>
				<hr>
			</div>
			
			<div class="col-xs-12">
				<p>
				Utilitzeu aquest formulari per filtrar.
				</p>
			</div>
		
			<div class="col-xs-12 col-sm-4 form-group">
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
			
			<div class="col-xs-12 col-sm-4 form-group">
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
	
			<div class="col-xs-12 col-sm-4 form-group">
				<label for="" class="control-label">Superficie mínima</label>
				<select name="min_m2" class="form-control">
					<option value="">Todos</option>
					<option value="50" <?php echo $min_m2 == 50 ? 'selected="selected"':''; ?>>50 m2</option>
					<option value="100" <?php echo $min_m2 == 100 ? 'selected="selected"':''; ?>>100 m2</option>
					<option value="150" <?php echo $min_m2 == 150 ? 'selected="selected"':''; ?>>150 m2</option>
					<option value="200" <?php echo $min_m2 == 200 ? 'selected="selected"':''; ?>>200 m2</option>
					<option value="250" <?php echo $min_m2 == 250 ? 'selected="selected"':''; ?>>250 m2</option>
					<option value="300" <?php echo $min_m2 == 300 ? 'selected="selected"':''; ?>>300 m2</option>
				</select>
			</div>
	
			<div class="col-xs-12 col-sm-4 form-group">
				<label for="" class="control-label">Precio máximo</label>
				<select name="max_price" class="form-control">
					<option value="">Todos</option>
					<option value="50000" <?php echo $max_price == 50000 ? 'selected="selected"':''; ?>>50.000 €</option>
					<option value="100000" <?php echo $max_price == 100000 ? 'selected="selected"':''; ?>>100.000 €</option>
					<option value="150000" <?php echo $max_price == 150000 ? 'selected="selected"':''; ?>>150.000 €</option>
					<option value="200000" <?php echo $max_price == 200000 ? 'selected="selected"':''; ?>>200.000 €</option>
					<option value="250000" <?php echo $max_price == 250000 ? 'selected="selected"':''; ?>>250.000 €</option>
					<option value="300000" <?php echo $max_price == 300000 ? 'selected="selected"':''; ?>>300.000 €</option>
					<option value="350000" <?php echo $max_price == 350000 ? 'selected="selected"':''; ?>>350.000 €</option>
					<option value="400000" <?php echo $max_price == 400000 ? 'selected="selected"':''; ?>>400.000 €</option>
					<option value="450000" <?php echo $max_price == 450000 ? 'selected="selected"':''; ?>>450.000 €</option>
					<option value="500000" <?php echo $max_price == 500000 ? 'selected="selected"':''; ?>>500.000 €</option>
					<option value="550000" <?php echo $max_price == 550000 ? 'selected="selected"':''; ?>>550.000 €</option>
					<option value="600000" <?php echo $max_price == 600000 ? 'selected="selected"':''; ?>>600.000 €</option>
					<option value="650000" <?php echo $max_price == 650000 ? 'selected="selected"':''; ?>>650.000 €</option>
					<option value="700000" <?php echo $max_price == 700000 ? 'selected="selected"':''; ?>>700.000 €</option>
					<option value="750000" <?php echo $max_price == 750000 ? 'selected="selected"':''; ?>>750.000 €</option>
					<option value="800000" <?php echo $max_price == 800000 ? 'selected="selected"':''; ?>>800.000 €</option>
					<option value="1000000" <?php echo $max_price == 1000000 ? 'selected="selected"':''; ?>>1.000.000 €</option>
					<option value="1500000" <?php echo $max_price == 1500000 ? 'selected="selected"':''; ?>>1.500.000 €</option>
					<option value="3000000" <?php echo $max_price == 3000000 ? 'selected="selected"':''; ?>>3.000.000 €</option>
				</select>
			</div>
	
			<div class="col-xs-12 col-sm-4 form-group">
				<label for="" class="control-label">Habitaciones mínimas</label>
				<input type="number" name="min_rooms" min="0" class="form-control" value="<?php echo $min_rooms; ?>" />
			</div>
			
			<div class="col-xs-12 col-sm-4 form-group">
				<label class="control-label"></label>
				<button class="btn btn-primary form-control" type="submit">
					<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Buscar
				</button>
			</div>
			
		</div>
	</div>
</div>
	
</form>

</div>