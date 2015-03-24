<form action="" method="get">

	<fieldset>
		<div><h3>Filtre</h3></div>
		<p>Utilitzeu aquest formulari per filtrar.</p>
		
		<input name="post_type" value="<?php echo APP_Post_Type_Real_Estate::POST_TYPE; ?>" type="hidden">
	
		<p>
			<label for="rooms">Habitacions *</label>
			<input maxlength="2" name="rooms" id="rooms" value="" type="text">
		</p>
		
		<p>
			<input value="Buscar" type="submit">			
		</p>
	
	</fieldset>
	
</form>