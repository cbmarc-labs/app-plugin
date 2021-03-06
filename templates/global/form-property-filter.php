<?php 

global $wp_rewrite, $wp_query;
if( isset( $wp_rewrite ) && is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) {
	$action = get_post_type_archive_link( 'property' );
}

// default values
$type			= 0;
$transaction	= 0;
$location		= 0;
$min_rooms		= '';
$min_m2			= '';
$max_price		= '';

// Safe values
if( isset( $wp_query->query_vars['type'] ) && !empty( $wp_query->query_vars['type'] ) )
	$type = sanitize_text_field( $wp_query->query_vars['type'] );

if( isset( $wp_query->query_vars['transaction'] ) && !empty( $wp_query->query_vars['transaction'] ) )
	$transaction = sanitize_text_field( $wp_query->query_vars['transaction'] );

if( isset( $wp_query->query_vars['location'] ) && !empty( $wp_query->query_vars['location'] ) )
	$location = sanitize_text_field( $wp_query->query_vars['location'] );

if( isset( $wp_query->query_vars['min_rooms'] ) && !empty( $wp_query->query_vars['min_rooms'] ) )
	$min_rooms = intval( $wp_query->query_vars['min_rooms'] );

if( isset( $wp_query->query_vars['max_price'] ) && !empty( $wp_query->query_vars['max_price'] ) )
	$max_price = intval( $wp_query->query_vars['max_price'] );

if( isset( $wp_query->query_vars['min_m2'] ) && !empty( $wp_query->query_vars['min_m2'] ) )
	$min_m2 = intval( $wp_query->query_vars['min_m2'] );

?>

<div class="bootstrap">
	<div class="container-fluid">
	
		<nav class="navbar navbar-default">
  			<div class="container-fluid">
    			<!-- Brand and toggle get grouped for better mobile display -->
    			<div class="navbar-header">
    				<div class="col-xs-12">
   						<button style="width:100%" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
       						<span class="sr-only">Toggle search</span>
       						<span class="glyphicon glyphicon-search">&nbsp;<?php _e( 'Search', 'app' ); ?></span>
						</button>
					</div>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<br>      

<?php if( isset( $action ) ): ?>
<form action="<?php echo $action; ?>" method="get">
<?php else:?>
<form action="<?php echo site_url( '/' ); ?>" method="get">
	<input type="hidden" name="post_type" value='property' />
<?php endif; ?>
	<input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
		<div class="row">
		
			<div class="col-xs-12 col-sm-3">
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
			
			<div class="col-xs-12 col-sm-3">
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
			
			<div class="col-xs-12 col-sm-3">
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
	
			<div class="col-xs-12 col-sm-3">
				<label for=""><?php _e( 'Min. floor', 'app' ); ?></label>
				<select name="min_m2" id="min_m2" style="width:100%">
					<option value="">Todos</option>
					<?php foreach( array(50,100,150,200,250,300) as $value) : ?>
					<option value="<?php echo $value; ?>" 
					<?php selected( $value, $min_m2 ); ?>><?php echo $value ?> m2</option>
					<?php endforeach; ?>
				</select>
			</div>
	
			<div class="col-xs-12 col-sm-4">
				<label for=""><?php _e( 'Max. price', 'app' ); ?></label>
				<select name="max_price" id="max_price">
					<option value="">Todos</option>
					<?php foreach( array(50000,100000,150000,200000,250000,300000,
							350000,400000,450000,500000,550000,600000,650000,700000,800000,
							1000000,1500000,3000000) as $value) : ?>
					<option value="<?php echo $value; ?>" 
					<?php selected( $value, $max_price ); ?>><?php echo number_format($value, 0, ',', '.') ?> €</option>
					<?php endforeach; ?>
				</select>
			</div>
	
			<div class="col-xs-12 col-sm-4">
				<label for="min_rooms"><?php _e( 'Min. rooms', 'app' ); ?></label>
				<input id="min_rooms" type="number" name="min_rooms" min="0" value="<?php echo $min_rooms; ?>" />
			</div>
			
			<div class="col-xs-12 col-sm-4">
				<label class="control-label">&nbsp;</label>
				<button class="btn btn-primary form-control" type="submit">
					<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;<?php _e( 'Search', 'app' ); ?>
				</button>
			</div>
			
		</div>

</form>

				</div>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div><!-- /.container-fluid -->
</div>