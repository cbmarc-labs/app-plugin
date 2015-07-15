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
			<td><?php _e( 'Property', 'app' ); ?> :</td>
			<td>
				<span>
					<?php if ( is_string( get_post_status( $data['message_property_id'] ) ) === FALSE ): ?>
					<?php _e( 'The property does not exist.', 'app' ); ?>
					<?php else: ?>
					<a href="<?php echo get_permalink( $data['message_property_id'] ); ?>"><?php echo get_the_title( $data['message_property_id'] ); ?></a>
					<?php endif; ?>
				</span>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Name', 'app' ); ?> :</td>
			<td>
				<span><?php echo $data['message_name']; ?></span>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Email', 'app' ); ?> :</td>
			<td>
				<span><a href="mailto:<?php echo $data['message_email']; ?>"><?php echo $data['message_email']; ?></a></span>
			</td>
		</tr>
		
		<tr>
			<td><?php _e( 'Phone', 'app' ); ?> :</td>
			<td>
				<span><?php echo $data['message_phone']; ?></span>
			</td>
		</tr>
		
	</tbody>
</table>