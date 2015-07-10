<?php 
$rand_int1 = substr( mt_rand(), 0, 2 );
$rand_int2 = substr( mt_rand(), 0, 1 );
$rand_int3 = substr( mt_rand(), 0, 1 );

$_SESSION['captcha_answer'] = $rand_int1 + $rand_int2 - $rand_int3;
?>

<div class="page-header">
	<h4><?php _e( 'Contact', 'app' ); ?></h4>
</div>

<div class="well">
	<form action="" method="post">
	
		<input id="url" type="hidden" name="url" value="<?php the_permalink() ?>" />
	
		<div class="col-xs-12">
			<label for="name"><?php _e( 'Name', 'app' ); ?></label>
			<input style="width:100%;" id="name" type="text" name="name" value="" />
		</div>
		
		<div class="form-group col-xs-12 has-error">
			<label for="email" class="control-label"><?php _e( 'Email', 'app' ); ?></label>
			<input id="email" type="text" name="email" class="form-control" value="" />
		</div>
		
		<div class="col-xs-12">
			<label for="message"><?php _e( 'Message', 'app' ); ?></label>
			<textarea id="message" name="message" rows="5"><?php _e( 'I am looking for information on property ', 'app' ); the_title(); ?></textarea>
		</div>
		
		<div class="col-xs-12">
			<label for="captcha">
			<?php 
				_e( 'What is ', 'app' ); 
				echo $rand_int1 . ' + ' . $rand_int2 . ' - ' . $rand_int3 . '?';
			?>
			</label>
			<input id="captcha" type="text" name="captcha" class="form-control" value="" />
		</div>
		
		<div class="col-xs-12">
			<button class="btn btn-primary form-control" type="submit">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;<?php _e( 'Accept', 'app' ); ?>
			</button>
		</div>
		
	</form>

	<div class="clearfix"></div>
</div>