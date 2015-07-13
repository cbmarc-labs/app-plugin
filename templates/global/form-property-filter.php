<?php 

global $wp_rewrite, $wp_query;

// Si te els permanlinks activats
if( isset( $wp_rewrite ) && is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) {
	$action = get_post_type_archive_link( 'property' );
	
	if ( is_post_type_archive( 'property' ) || is_tax( get_object_taxonomies( 'property' ) ) ) {
		global $wp;
	
		$action = home_url( add_query_arg( array(), $wp->request ) );
	}
}

// default values
$type			= 0;
$transaction	= 0;
$location		= 0;
$min_rooms		= '';
$min_area			= '';
$min_price		= 0;
$max_price		= 3000000;
$feature		= array();
$sortby			= 1;

// Safe values
if (isset( $wp_query->query_vars['type'] ) && !empty( $wp_query->query_vars['type'])) {
	$type = sanitize_text_field( $wp_query->query_vars['type'] );
}

if (isset( $wp_query->query_vars['transaction'] ) && !empty( $wp_query->query_vars['transaction'])) {
	$transaction = sanitize_text_field( $wp_query->query_vars['transaction'] );
}

if (isset( $wp_query->query_vars['location'] ) && !empty( $wp_query->query_vars['location'])) {
	$location = sanitize_text_field( $wp_query->query_vars['location'] );
}

if (isset( $wp_query->query_vars['min_rooms'] ) && !empty( $wp_query->query_vars['min_rooms'])) {
	$min_rooms = intval( $wp_query->query_vars['min_rooms'] );
}

if (isset( $wp_query->query_vars['min_price'] ) && !empty( $wp_query->query_vars['min_price'])) {
	$min_price = intval( $wp_query->query_vars['min_price'] );
}

if (isset( $wp_query->query_vars['max_price'] ) && !empty( $wp_query->query_vars['max_price'])) {
	$max_price = intval( $wp_query->query_vars['max_price'] );
}

if (isset( $wp_query->query_vars['min_area'] ) && !empty( $wp_query->query_vars['min_area'])) {
	$min_area = intval( $wp_query->query_vars['min_area'] );
}

if (isset($wp_query->query_vars['feature'] ) && !empty( $wp_query->query_vars['feature'])) {
	$feature = $wp_query->query_vars['feature'];
}

if (isset($wp_query->query_vars['sortby'] ) && !empty( $wp_query->query_vars['sortby'])) {
	$sortby = intval( $wp_query->query_vars['sortby'] );
}

?>

<div class="bootstrap">
	<div class="container-fluid">	
	
		<nav class="navbar navbar-default">
  			<div class="container-fluid">
    			<!-- Brand and toggle get grouped for better mobile display -->
    			<div class="navbar-header">
    				<div class="col-xs-12">
   						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
       						<span class="sr-only">Toggle search</span>
       						<span class="glyphicon glyphicon-search">&nbsp;<?php _e( 'Search', 'app' ); ?></span>
						</button>
					</div>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<br>      

<?php if ( isset( $action ) ) : ?>
	<form action="<?php echo $action; ?>" method="get">
<?php else: ?>
	<form action="<?php echo site_url( '/' ); ?>" method="get">
	<input type="hidden" name="post_type" value='property' />
<?php endif; ?>

	<input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
		<div class="row">
		
			<div class="col-xs-6 col-sm-3">
				<label for="type"><?php _e( 'Type', 'app' ); ?></label>
				<?php
					$args = array(
						'show_option_all'    => __( 'Any', 'app' ),
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
						'class'              => 'bootstrap-select',
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
			
			<div class="col-xs-6 col-sm-3">
				<label for="transaction"><?php _e( 'Transaction', 'app' ); ?></label>
				<?php
					$args = array(
						'show_option_all'    => __( 'Any', 'app' ),
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
						'class'              => '',
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
			
			<div class="col-xs-6 col-sm-3">
				<label for="transaction"><?php _e( 'Location', 'app' ); ?></label>
				<?php
					$args = array(
						'show_option_all'    => __( 'Any', 'app' ),
						'orderby'            => 'slug',
						'order'              => 'ASC',
						'show_count'         => 0,
						'hide_empty'         => 0,
						'child_of'           => 0,
						'exclude'            => '',
						'echo'               => 1,
						'selected'           => $location,
						'hierarchical'       => 1,
						'name'               => 'location',
						'id'                 => '',
						'class'              => '',
						'depth'              => 0,
						'tab_index'          => 0,
						'taxonomy'           => 'property-location',
						'hide_if_empty'      => false,
						'walker'             => new SH_Walker_TaxonomyDropdown(),
						'value'              => 'slug'
					);
				
					wp_dropdown_categories( $args );
				?>
			</div>
	
			<div class="col-xs-6 col-sm-3">
				<label for=""><?php _e( 'Min. floor', 'app' ); ?></label>
				<select name="min_area" id="min_area" style="width:100%">
					<option value=""><?php echo __( 'Any', 'app' ); ?></option>
					<?php foreach( array(50,100,150,200,250,300) as $value) : ?>
					<option value="<?php echo $value; ?>" 
					<?php selected( $value, $min_area ); ?>><?php echo $value ?> area</option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="col-xs-12 col-sm-6">
				<div class="text-center">
					<span><label id="nouislider-value-lower" class="currency" style="display:inherit;"></label></span>
					<span><label style="display:inherit;">&nbsp;/&nbsp;</label></span>
					<span><label id="nouislider-value-upper" class="currency" style="display:inherit;"></label></span>
				</div>
				<div id="nonlinear" style="margin:12px;"></div>
				<input type="hidden" name="min_price" value="0">
				<input type="hidden" name="max_price" value="0">
			</div>
			
			<script>
				var nonLinearSlider = document.getElementById('nonlinear');
				var skipValues = [
					document.getElementById('nouislider-value-lower'),
					document.getElementById('nouislider-value-upper')
				];

				jQuery('#nouislider-value-lower').autoNumeric('init', {
					vMax: '99999999999', vMin: '-9999999999999',
					pSign: 's', aSign: ' €',
					aDec: ',', aSep: '.' 
				});

				jQuery('#nouislider-value-upper').autoNumeric('init', {
					vMax: '99999999999', vMin: '-9999999999999',
					pSign: 's', aSign: ' €',
					aDec: ',', aSep: '.' 
				});
	
				noUiSlider.create(nonLinearSlider, {
					connect: true,
					start: [ <?php echo $min_price; ?>, <?php echo $max_price; ?> ],
					step: 50000,
					range: {
						'min': [ 0 ],
						'50%': [ 500000, 100000 ],
						'75%': [ 1000000, 500000 ],
						'max': [ 3000000 ]
					}
				});

				nonLinearSlider.noUiSlider.on('update', function ( values, handle ) {
					skipValues[handle].innerHTML = Math.round(values[handle]);

					jQuery('input[name="min_price"]').val(Math.round(values[0]));
					jQuery('input[name="max_price"]').val(Math.round(values[1]));

					jQuery('#nouislider-value-lower').autoNumeric('update');
					jQuery('#nouislider-value-upper').autoNumeric('update');
				});
			</script>
	
			<div class="col-xs-12 col-sm-3">
				<label for="min_rooms"><?php _e( 'Min. rooms', 'app' ); ?></label>
				<input id="min_rooms" type="number" name="min_rooms" min="0" value="<?php echo $min_rooms; ?>" />
			</div>
			
			<input id="sortby" type="hidden" name="sortby" value="<?php echo $sortby; ?>" />
			
			<div class="col-xs-12 col-sm-3">
				<label class="hidden-xs control-label">&nbsp;</label>
				<button class="btn btn-primary form-control" type="submit">
					<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;<?php _e( 'Search', 'app' ); ?>
				</button>
			</div>
			
			<div class="col-xs-12">
				<p class="hidden-sm hidden-md hidden-lg">&nbsp;</p>
				<p class="text-center">
					<a role="button" aria-expanded="false" aria-controls="collapseFilters" 
						data-toggle="collapse" data-target="#collapseFilters" 
						href="javascript:void(0)" onclick="return false;"><?php _e('Search by features', 'app'); ?></a>
				</p>
			
				<div class="collapse <?php echo empty($feature)?'':'in'; ?>" id="collapseFilters">
					<div class="col-xs-12">
	
						<?php $terms = get_terms( 'property-feature', 'hide_empty=0' ); ?>
						<?php if (!empty($terms) && !is_wp_error($terms)): ?>
						<ul class="text-center">
							<?php foreach ($terms as $term): ?>
							<li style="display: inline-block;margin-right:25px;">
								<div class="checkbox">
									<label>
										<input type='checkbox' name='feature[]' value='<?php echo $term->slug ?>'
										<?php echo in_array($term->slug, $feature)?'checked':''; ?> 
										/>
										<?php echo $term->name; ?>
									</label>
								</div>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
	
					</div>
				</div>
			</div>
			
		</div>

</form>

				</div>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div><!-- /.container-fluid -->
</div>