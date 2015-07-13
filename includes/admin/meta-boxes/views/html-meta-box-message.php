<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<table style="width:100%;">
	<thead>
		<th style="width:20%;"></th>
		<th style="width:80%;"></th>
	</thead>
	<tbody>
		
		<tr>
			<td><?php _e( 'Name', 'app' ); ?> :</td>
			<td>
				<input style="width:100%;" type="text" value="<?php echo $data['message_name']; ?>" readonly />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Sender name' , 'app' ); ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Email', 'app' ); ?> :</td>
			<td>
				<input style="width:100%;" type="text" value="<?php echo $data['message_email']; ?>" readonly />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Sender email', 'app' ); ?></small>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Phone', 'app' ); ?> :</td>
			<td>
				<input style="width:100%;" type="text" value="<?php echo $data['message_phone']; ?>" readonly />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'Sender phone', 'app' ); ?></small>
			</td>
		</tr>
		
	</tbody>
</table>