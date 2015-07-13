<div class="page-header">
	<h4><?php _e( 'Enquire Now', 'app' ); ?></h4>
</div>

<div class="well">
	<form action="" method="post" id="propertyFormEnquireNow">
		
		<input type="hidden" name="action" value="enquire_now" />
	
		<input id="url" type="hidden" name="url" value="<?php the_permalink() ?>" />
	
		<div class="form-group col-xs-12" style="padding:0;margin:0;">
			<label for="name"><?php _e( 'Name', 'app' ); ?></label>
			<input style="width:100%;" id="name" type="text" minlength="2" maxlength="50" name="name" value="marc" required />
		</div>
		
		<div class="form-group col-xs-12" style="padding:0;margin:0;">
			<label for="email" class="control-label"><?php _e( 'Email', 'app' ); ?></label>
			<input id="email" type="email" name="email" minlength="2" maxlength="50" class="form-control" value="cbmarc@gmail.com" required />
		</div>
		
		<div class="form-group col-xs-12" style="padding:0;margin:0;">
			<label for="phone" class="control-label"><?php _e( 'Phone', 'app' ); ?></label>
			<input id="phone" type="text" name="phone" maxlength="50" class="form-control" value="" />
		</div>
		
		<div class="form-group col-xs-12" style="padding:0;margin:0;">
			<label for="message"><?php _e( 'Message', 'app' ); ?></label>
			<textarea id="message" name="message" rows="5"><?php _e( 'I am looking for information on property ', 'app' ); the_title(); ?></textarea>
		</div>
		
		<div class="col-xs-12" style="padding:0;margin:0;">
			<button class="btn btn-primary form-control" type="submit">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;<?php _e( 'Send Message', 'app' ); ?>
			</button>
		</div>
		
	</form>

	<div class="clearfix"></div>
</div>