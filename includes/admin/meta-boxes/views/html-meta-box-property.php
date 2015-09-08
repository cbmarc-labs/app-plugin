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
			<td><?php _e( 'Reference', 'app' ); ?> :</td>
			<td>
				<input maxlength="100" type="text" 
					name="property_reference" id="property_reference" size="25"
					value="<?php echo $data['property_reference']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Property reference', 'app' ); ?></small>
			</td>
		</tr>
		
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
			<td><?php _e( 'Area', 'app' ); ?> :</td>
			<td>
				<input class="autonumeric" data-a-dec="," data-a-sep="." data-v-min="0" data-v-max="999999"
					maxlength="20" type="text" name="property_area" id="property_area" size="16"
					value="<?php echo $data['property_area']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Property area', 'app' ); ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Energy Certificate', 'app' ); ?> :</td>
			<td>
				<label><input type="radio" name="property_energy" value="1" <?php echo $data['property_energy'] == 1 ? 'checked' : ''; ?>><?php _e( 'Yes', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_energy" value="2" <?php echo $data['property_energy'] == 2 ? 'checked' : ''; ?>><?php _e( 'No', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_energy" value="3" <?php echo $data['property_energy'] == 3 ? 'checked' : ''; ?>><?php _e( 'Letter', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_energy" value="4" <?php echo $data['property_energy'] == 4 ? 'checked' : ''; ?>><?php _e( 'In process', 'app' ); ?></label>
				
				<br>
				
				<?php _e( 'Letter', 'app' ); ?> :
				<input maxlength="1" type="text" name="property_energy_letter" id="property_energy_letter" size="4"
					value="<?php echo $data['property_energy_letter']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Energy Certificate', 'app' ); ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Position', 'app' ); ?> :</td>
			<td>
				<label><input type="radio" name="property_position" value="1" <?php echo $data['property_position'] == 1 ? 'checked' : ''; ?>><?php _e( 'N', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_position" value="2" <?php echo $data['property_position'] == 2 ? 'checked' : ''; ?>><?php _e( 'NE', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_position" value="3" <?php echo $data['property_position'] == 3 ? 'checked' : ''; ?>><?php _e( 'E', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_position" value="4" <?php echo $data['property_position'] == 4 ? 'checked' : ''; ?>><?php _e( 'SE', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_position" value="5" <?php echo $data['property_position'] == 5 ? 'checked' : ''; ?>><?php _e( 'S', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_position" value="6" <?php echo $data['property_position'] == 6 ? 'checked' : ''; ?>><?php _e( 'SW', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_position" value="7" <?php echo $data['property_position'] == 7 ? 'checked' : ''; ?>><?php _e( 'W', 'app' ); ?></label>
				&nbsp;
				<label><input type="radio" name="property_position" value="8" <?php echo $data['property_position'] == 8 ? 'checked' : ''; ?>><?php _e( 'SW', 'app' ); ?></label>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Property position', 'app' ); ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Featured', 'app' ); ?> :</td>
			<td>
				<input type="checkbox" name="property_featured" id="property_featured"
					value="<?php echo $data['property_featured']; ?>" <?php echo $data['property_featured'] ? 'checked' : ''; ?>/>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Featured property', 'app' ); ?></small>
			</td>
		</tr>
		
	</tbody>
</table>