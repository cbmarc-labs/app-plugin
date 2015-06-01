<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<table>
	<thead>
		<th style="width:50%;"></th>
		<th style="width:50%;"></th>
	</thead>
	<tbody>
		
		<tr>
			<td><?php _e( 'Rooms', 'app' ); ?> :</td>
			<td>
				<input class="autonumeric" data-v-min="0" data-v-max="99" maxlength="2" type="text" 
					name="property_rooms" id="property_rooms" size="4"
					value="<?php echo $data['property_rooms']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Number of rooms', 'app' ); ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Baths', 'app' ); ?> :</td>
			<td>
				<input class="autonumeric" data-v-min="0" data-v-max="99" maxlength="2" type="text" 
					name="property_baths" id="property_baths" size="4"
					value="<?php echo $data['property_baths']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Number of bathrooms', 'app' ); ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Price', 'app' ); ?> :</td>
			<td>
				<input class="autonumeric" data-a-dec="," data-a-sep="." data-v-min="0" data-v-max="9999999"
					data-a-sign=" €" data-p-sign="s" size="20"
					maxlength="20" type="text" name="property_price" id="property_price" 
					value="<?php echo $data['property_price']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Property price', 'app' ); ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Square meters', 'app' ); ?> :</td>
			<td>
				<input class="autonumeric" data-a-dec="," data-a-sep="." data-v-min="0" data-v-max="999999"
					maxlength="20" type="text" name="property_m2" id="property_m2" size="16"
					value="<?php echo $data['property_m2']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Property square meters', 'app' ); ?></small>
			</td>
		</tr>
		
	</tbody>
</table>