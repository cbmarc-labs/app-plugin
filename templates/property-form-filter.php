<?php 

global $wp_rewrite, $wp_query;
if( isset( $wp_rewrite ) && is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) {
	$action = get_post_type_archive_link( APP_Post_Type_Property::POST_TYPE );
}

// default values
$type		= 0;
$min_rooms	= '';
$max_rooms	= '';
$min_price	= 0;
$max_price	= 100000;

// Safe values
if( isset( $wp_query->query_vars['type'] ) && !empty( $wp_query->query_vars['type'] ) )
	$type = sanitize_text_field( $wp_query->query_vars['type'] );

if( isset( $wp_query->query_vars['min_rooms'] ) && !empty( $wp_query->query_vars['min_rooms'] ) )
	$min_rooms = intval( $wp_query->query_vars['min_rooms'] );

if( isset( $wp_query->query_vars['max_rooms'] ) && !empty( $wp_query->query_vars['max_rooms'] ) )
	$min_rooms = intval( $wp_query->query_vars['max_rooms'] );

if( isset( $wp_query->query_vars['min_price'] ) && !empty( $wp_query->query_vars['min_price'] ) )
	$min_price = intval( $wp_query->query_vars['min_price'] );

if( isset( $wp_query->query_vars['max_price'] ) && !empty( $wp_query->query_vars['max_price'] ) )
	$max_price = intval( $wp_query->query_vars['max_price'] );

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
				'max': [  100000 ]
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

<div class="bootstrap">

<?php if( isset( $action ) ): ?>
<form action="<?php echo $action; ?>" method="get">
<?php else:?>
<form action="<?php echo site_url( '/' ); ?>" method="get">
	<input type="hidden" name="post_type" value=<?php echo APP_Post_Type_Property::POST_TYPE; ?> />
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
						'show_option_all'    => 'Any Type',
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
						'taxonomy'           => APP_Post_Type_Property::TAX_TYPE,
						'hide_if_empty'      => false,
						'walker'             => new SH_Walker_TaxonomyDropdown(),
						'value'              => 'slug'
					);
				
					wp_dropdown_categories( $args );
				?>
			</div>
	
			<div class="col-xs-12 col-sm-4 form-group">
				<label for="" class="control-label">Mínim d'habitacions</label>
				<input type="number" name="min_rooms" min="0" class="form-control" value="<?php echo $min_rooms; ?>" />
			</div>
			
			<div class="col-xs-12 col-sm-4 form-group">
				<label for="" class="control-label">Màxim d'habitacions</label>
				<input type="number" name="max_rooms" min="0" class="form-control" value="<?php echo $max_rooms; ?>" />
			</div>
			
			<input type="hidden" name="min_price" class="property-search-price-range-min" value="<?php echo $min_price; ?>" />
			<input type="hidden" name="max_price" class="property-search-price-range-max" value="<?php echo $max_price; ?>" />
			<div class="col-xs-12 col-sm-4 form-group text-center">
				<label class="control-label"><span class="price-range-min"></span> - <span class="price-range-max"></span></label>
				<div class="price-range-slider"></div>
			</div>
			
			<div class="col-xs-12 col-sm-4 form-group">
				<label class="control-label"></label>
				<button class="btn btn-primary form-control" type="submit">
					<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Cercar
				</button>
			</div>
			
		</div>
	</div>
</div>
	
</form>

</div>