<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<table>
	<thead>
		<th style="width:50%;"></th>
		<th style="width:50%;"></th>
	</thead>
	<tbody>
	
		<!-- <tr>
			<td colspan="2">
				<h4><?php APP_Lang::_ex( 'property_meta_box_title' ) ?></h4>
			</td>
		</tr> -->
		
		<tr>
			<td><?php APP_Lang::_ex( 'property_field_rooms' ) ?> :</td>
			<td>
				<input class="autonumeric" data-v-min="0" data-v-max="99" maxlength="2" type="text" 
					name="_property_rooms" id="_property_rooms" 
					value="<?php echo $data[ 'rooms' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php APP_Lang::_ex( 'property_field_rooms_desc' ) ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php APP_Lang::_ex( 'property_field_baths' ) ?> :</td>
			<td>
				<input class="autonumeric" data-v-min="0" data-v-max="99" maxlength="2" type="text" 
					name="_property_baths" id="_property_baths" 
					value="<?php echo $data[ 'baths' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php APP_Lang::_ex( 'property_field_baths_desc' ) ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php APP_Lang::_ex( 'property_field_price' ) ?> :</td>
			<td>
				<input class="autonumeric" data-a-dec="," data-a-sep="." data-v-min="0" data-v-max="9999999"
					data-a-sign=" €" data-p-sign="s" 
					maxlength="20" type="text" name="_property_price" id="_property_price" 
					value="<?php echo $data[ 'price' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php APP_Lang::_ex( 'property_field_price_desc' ) ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php APP_Lang::_ex( 'property_field_m2' ) ?> :</td>
			<td>
				<input class="autonumeric" data-a-dec="," data-a-sep="." data-v-min="0" data-v-max="999999"
					maxlength="20" type="text" name="_property_m2" id="_property_m2"
					value="<?php echo $data[ 'm2' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php APP_Lang::_ex( 'property_field_m2_desc' ) ?></small>
			</td>
		</tr>
		
	</tbody>
</table>