<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<fieldset class="inline-edit-col-left">
	<div id="" class="inline-edit-col">

		<h4><?php _e( 'Property Data', 'app' ); ?></h4>

		<div class="">
			<label>
				<span class="title"><?php _e( 'Rooms', 'app' ); ?></span>
				<span class="input-text-wrap">
					<input class="" data-v-min="0" data-v-max="99" maxlength="2" type="text" style="width:100px"
						name="_property_rooms" id="_property_rooms" size="4"
						value="" />
				</span>
			</label>
			<br class="clear" />
		</div>

		<input type="hidden" name="app_quick_edit" value="1" />
		<input type="hidden" name="app_quick_edit_nonce" value="<?php echo wp_create_nonce( 'app_quick_edit_nonce' ); ?>" />
	</div>
</fieldset>
