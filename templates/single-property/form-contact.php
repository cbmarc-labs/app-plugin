<div class="page-header">
	<h4><?php _e( 'Enquire Now', 'app' ); ?></h4>
</div>

<?php 

global $wp_query;

if ( isset( $wp_query->query_vars['status'] ) 
		&& ! empty( $wp_query->query_vars['status'] )
		&& $wp_query->query_vars['status'] == 'sent' ) :
?>

<div class="alert alert-success">
	<p><?php _e( 'Thanks for sending us a message.', 'app' ); ?></p>
</div>

<?php else: ?>

<div class="well">
	<form action="" method="post" id="propertyFormEnquireNow">
		
		<?php wp_nonce_field( 'app-enquire_now' ); ?>
		<input type="hidden" name="action" value="enquire_now" />
	
		<input id="permalink" type="hidden" name="permalink" value="<?php the_permalink() ?>" />
		<input id="title" type="hidden" name="title" value="<?php the_title() ?>" />
	
		<div class="form-group col-xs-12" style="padding:0;margin:0;">
			<label for="name"><?php _e( 'Name', 'app' ); ?> *</label>
			<input style="width:100%;" id="name" type="text" minlength="2" maxlength="50" name="name" value="" required />
		</div>
		
		<div class="form-group col-xs-12" style="padding:0;margin:0;">
			<label for="email" class="control-label"><?php _e( 'Email', 'app' ); ?> *</label>
			<input id="email" type="email" name="email" minlength="2" maxlength="50" class="form-control" value="" required />
		</div>
		
		<div class="form-group col-xs-12" style="padding:0;margin:0;">
			<label for="phone" class="control-label"><?php _e( 'Phone', 'app' ); ?></label>
			<input id="phone" type="text" name="phone" maxlength="50" class="form-control" value="" />
		</div>
		
		<div class="form-group col-xs-12" style="padding:0;margin:0;">
			<label for="message"><?php _e( 'Message', 'app' ); ?></label>
			<textarea id="message" name="message" rows="5"><?php _e( 'I am looking for information on property ', 'app' ); echo ": "; the_title(); ?></textarea>
		</div>
		
		<div class="col-xs-12" style="padding:0;margin:0;">
			<button class="btn btn-primary form-control" type="submit">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;<?php _e( 'Send Message', 'app' ); ?>
			</button>
		</div>
		
	</form>

	<div class="clearfix"></div>
</div>

<?php endif; ?>