<div class="page-header">
	<h4><?php _e( 'Contact', 'app' ); ?></h4>
</div>

<div class="well">
<form action="" method="post">

	<div class="col-xs-12">
		<label for="name"><?php _e( 'Name', 'app' ); ?></label>
		<input style="width:100%;" id="name" type="text" name="name" value="" />
	</div>
	
	<div class="col-xs-12">
		<label for="email"><?php _e( 'Email', 'app' ); ?></label>
		<input id="email" type="text" name="email" value="" />
	</div>
	
	<div class="col-xs-12">
		<label for="message"><?php _e( 'Message', 'app' ); ?></label>
		<textarea id="message" name="message" rows="5"></textarea>
	</div>
	
	<div class="col-xs-12">
		<button class="btn btn-primary form-control" type="submit">
			<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;<?php _e( 'Accept', 'app' ); ?>
		</button>
	</div>
	
</form>

<div class="clearfix"></div>
</div>