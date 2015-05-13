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
	
		<!-- <tr>
			<td colspan="2">
				<h4><?php echo App::lang( 'cpt_real_estate_meta_box_title' ) ?></h4>
			</td>
		</tr> -->
		
		<tr>
			<td><?php echo App::lang( 'cpt_real_estate_field_rooms' ) ?> :</td>
			<td>
				<input class="autonumeric" data-v-min="0" data-v-max="99" maxlength="2" type="text" name="app_meta_box_real_estate_rooms" id="app_meta_box_real_estate_rooms" value="<?php echo $fields[ 'rooms' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php echo App::lang( 'cpt_real_estate_field_rooms_desc' ) ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php echo App::lang( 'cpt_real_estate_field_price' ) ?> :</td>
			<td>
				<input class="currency" maxlength="20" type="text" name="app_meta_box_real_estate_price" id="app_meta_box_real_estate_price" value="<?php echo $fields[ 'price' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php echo App::lang( 'cpt_real_estate_field_price_desc' ) ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php echo App::lang( 'cpt_real_estate_field_m2' ) ?> :</td>
			<td>
				<input class="autonumeric" data-a-dec="," data-a-sep="." data-v-min="0" data-v-max="999999.99" maxlength="20" type="text" name="app_meta_box_real_estate_m2" id="app_meta_box_real_estate_m2" value="<?php echo $fields[ 'm2' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php echo App::lang( 'cpt_real_estate_field_m2_desc' ) ?></small>
			</td>
		</tr>
		
	</tbody>
</table>