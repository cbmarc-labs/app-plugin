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
$min_price		= 0;
$max_price		= 500000;

// Safe values
if( isset( $wp_query->query_vars['type'] ) && !empty( $wp_query->query_vars['type'] ) )
	$type = sanitize_text_field( $wp_query->query_vars['type'] );

if( isset( $wp_query->query_vars['transaction'] ) && !empty( $wp_query->query_vars['transaction'] ) )
	$transaction = sanitize_text_field( $wp_query->query_vars['transaction'] );

if( isset( $wp_query->query_vars['min_rooms'] ) && !empty( $wp_query->query_vars['min_rooms'] ) )
	$min_rooms = intval( $wp_query->query_vars['min_rooms'] );

if( isset( $wp_query->query_vars['min_price'] ) && !empty( $wp_query->query_vars['min_price'] ) )
	$min_price = intval( $wp_query->query_vars['min_price'] );

if( isset( $wp_query->query_vars['max_price'] ) && !empty( $wp_query->query_vars['max_price'] ) )
	$max_price = intval( $wp_query->query_vars['max_price'] );

if( isset( $wp_query->query_vars['min_m2'] ) && !empty( $wp_query->query_vars['min_m2'] ) )
	$min_m2 = intval( $wp_query->query_vars['min_m2'] );

?>

<script type="text/javascript">
<!--
	jQuery(document).ready(function( $ ) {

		priceFormat = wNumb({
			decimals: 0,
			thousand: '.',postfix: ' €',});
			
		$('.price-range-slider').noUiSlider({
			start: [ <?php echo $min_price; ?>, <?php echo $max_price; ?> ],
			step: 10000,
			range: {
				'min': [  0 ],
				'max': [  500000 ]
			},
			format: priceFormat,
			connect: true,
		});

		$('.price-range-slider').Link('lower').to($('.price-range-min'));
		$('.price-range-slider').Link('upper').to($('.price-range-max'));

		$('.price-range-slider').change(function() {
			price_range = $('.price-range-slider').val();
			
			min_price = priceFormat.from(price_range[0]);
			max_price = priceFormat.from(price_range[1]);

			$('[name=min_price]').val(min_price);
			$('[name=max_price]').val(max_price);
		});
		
	});
//-->
</script>

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
				<label for="" class="control-label">Habitaciones mínimas</label>
				<input type="number" name="min_rooms" min="0" class="form-control" value="<?php echo $min_rooms; ?>" />
			</div>
			
			<input type="hidden" name="min_price" class="property-search-price-range-min" value="<?php echo $min_price; ?>" />
			<input type="hidden" name="max_price" class="property-search-price-range-max" value="<?php echo $max_price; ?>" />
			<div class="col-xs-12 col-sm-4 form-group text-center">
				<label class="control-label">
					<span class="price-range-min"></span> - <span class="price-range-max"></span>
				</label>
				<div class="price-range-slider"></div>
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