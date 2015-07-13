<?php 

global $wp_query;

$sortby = 1;

if (isset($wp_query->query_vars['sortby'] ) && !empty( $wp_query->query_vars['sortby'])) {
	$sortby = intval( $wp_query->query_vars['sortby'] );
}

?>

<div class="bootstrap">
		<div class="col-xs-12">
			<div class="text-right">
		
				<label style="display:inline;"><?php _e( 'Sort by', 'app' ); ?></label>
				<select id="property-sort-select" style="display:inline;background-color:#fff;">
					<option value="1" <?php echo $sortby == 1 ? 'selected' : ''; ?>><?php _e( 'Date: Newest to Oldest', 'app' ); ?></option>
					<option value="2" <?php echo $sortby == 2 ? 'selected' : ''; ?>><?php _e( 'Date: Oldest to Newest', 'app' ); ?></option>
					<option value="3" <?php echo $sortby == 3 ? 'selected' : ''; ?>><?php _e( 'Price: Low to High', 'app' ); ?></option>
					<option value="4" <?php echo $sortby == 4 ? 'selected' : ''; ?>><?php _e( 'Price: High to Low', 'app' ); ?></option>
					<option value="5" <?php echo $sortby == 5 ? 'selected' : ''; ?>><?php _e( 'Area: Low to High', 'app' ); ?></option>
					<option value="6" <?php echo $sortby == 6 ? 'selected' : ''; ?>><?php _e( 'Area: High to Low', 'app' ); ?></option>
				</select>
			
			</div>
		</div>
</div>