<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Add an nonce field so we can check for it later.
wp_nonce_field( 'app_meta_box_real_estate', 'app_meta_box_real_estate_nonce' );

?>

<table>
	<thead>
		<th style="width:50%;"></th>
		<th style="width:50%;"></th>
	</thead>
	<tbody>
	
		<tr>
			<td colspan="2">
				<h4>Dades generals</h4>
			</td>
		</tr>
		
		<tr>
			<td>Habitacions :</td>
			<td>
				<input maxlength="2" type="text" name="app_meta_box_real_estate_rooms" id="app_meta_box_real_estate_rooms" value="<?php echo $fields[ 'rooms' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small>Número d'habitacions del immoble.</small>
			</td>
		</tr>
		
	</tbody>
</table>