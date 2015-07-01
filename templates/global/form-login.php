<?php
/**
 * Login form
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form method="post" class="login">

	<p>
		<label for="username"><?php _e( 'Username or email', 'app' ); ?> <span class="required">*</span></label>
		<input type="text" class="input-text" name="username" id="username" />
	</p>
	<p>
		<label for="password"><?php _e( 'Password', 'app' ); ?> <span class="required">*</span></label>
		<input class="input-text" type="password" name="password" id="password" />
	</p>
	<div class="clear"></div>

	<p class="form-row">
		<?php wp_nonce_field( 'app-login' ); ?>
		<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'app' ); ?>" />
		<label for="rememberme" class="inline">
			<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'app' ); ?>
		</label>
	</p>
	<p class="lost_password">
		<a href="#"><?php _e( 'Lost your password?', 'app' ); ?></a>
	</p>

	<div class="clear"></div>

</form>
