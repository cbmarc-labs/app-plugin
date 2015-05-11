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
		
		<tr>
			<td>Preu :</td>
			<td>
				<input maxlength="20" type="text" name="app_meta_box_real_estate_price" id="app_meta_box_real_estate_price" value="<?php echo $fields[ 'price' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small>Preu del immoble.</small>
			</td>
		</tr>
		
		<tr>
			<td>Metres quadrats :</td>
			<td>
				<input maxlength="20" type="text" name="app_meta_box_real_estate_m2" id="app_meta_box_real_estate_m2" value="<?php echo $fields[ 'm2' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small>Preu del immoble.</small>
			</td>
		</tr>
		
	</tbody>
</table>