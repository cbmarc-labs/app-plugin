<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<input type="hidden" name="app_meta_box_real_estate_noncedata" value="<?php echo $fields[ 'nonce' ]; ?>" />

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
				<input type="text" name="app_meta_box_real_estate_rooms" id="app_meta_box_real_estate_rooms" value="<?php echo $fields[ 'rooms' ]; ?>" />
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