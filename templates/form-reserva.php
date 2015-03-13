<style>

.res_form_element {
	margin-left: 1%;
}

.res_form_label {
	display: inline;
}

.res_form_input {
	display:block;
	padding:13px;
	border-color: #e1e1e1;
	background-color: #fcfcfc;
	color: #808080;
	border-radius: 2px;
	width: 100%;
}

.res_form_half {
	width: 49%;
	float: left;
	clear: none;
}

@media only screen and (max-width: 479px) {

	.res_form_element{
		width:100%;
		clear: both;
		margin-right:0;
		float: none;
	}
	
}

</style>

<br>

<?php 
	if( tribe_get_start_date(get_the_ID(), false, 'Y-m-d') >= date('Y-m-d') || 
			tribe_get_end_date(get_the_ID(), false, 'Y-m-d') >= date('Y-m-d') ):
?>

<?php if ( isset($_GET['reserva']) ): ?>

<h3>Reserva realitzada correctament.</h3>

<?php else: ?>

<form action="" method="post">

	<fieldset>
		<div><h3>Fitxa de reserva de la activitat</h3><div style="border-color: #e1e1e1;"></div></div>
		<p>Utilitzeu aquest formulari per a contactar amb nosaltres directament, empleneu tots els camps obligatoris marcats amb un asterisc.</p>
	
		<p class="res_form_element res_form_half">
			<label class="res_form_label" for="res_name">Nom *</label>
			<input class="res_form_input" required="required" name="res_name" id="res_name" value="" aria-required="true" type="text">
		</p>
		
		<p class="res_form_element res_form_half">
			<label for="res_quantity">Nombre d'adults i nens</label>
			<input class="res_form_input" name="res_quantity" id="res_quantity" value="" size="10" aria-required="true" type="text">
		</p>
		
		<p class="res_form_element res_form_half">
			<label for="res_phone">Telèfon</label>
			<input class="res_form_input" name="res_phone" id="res_phone" value="" size="22" type="text">
		</p>
		
		<p class="res_form_element res_form_half">
			<label for="res_email">Email *</label>
			<input class="res_form_input" required="required" name="res_email" id="res_email" value="" size="22" type="email">
		</p>
		
		<p class="res_form_element">
			<label for="res_comments">Comentaris</label>
			<textarea class="res_form_input" name="res_comments" id="res_comments" rows="5" aria-required="true"></textarea>
		</p>
		
		<p class="res_form_element">
			<input name="res_post_id" value="<?=get_the_ID()?>" id="res_post_id" type="hidden">
			<input name="reservar" id="reservar" value="Enviar" type="submit">			
		</p>
	
	</fieldset>
	
</form>

<?php endif; ?>
<?php endif; ?>

<?php 

if ( is_user_logged_in() )
{
	global $APP_Reserva;
	$posts = $APP_Reserva->get_reserves_from_post( get_the_ID() );
	
	if ( $posts )
	{
		echo '<h3>Llistat de reserves per aquest esdeveniment.</h3>';
		echo '<table style="width:100%;">';
		echo '<thead>';
		echo '<th>Nom</th>';
		echo '<th>Email</th>';
		echo '<th>Telèfon</th>';
		echo '<th>Adults/nens</th>';
		echo '<th>Comentaris</th>';
		echo '</thead>';
		
		echo '<tbody>';
		
		foreach($posts as $post)
		{
			$res_name = get_post_meta( $post->ID, 'res_name', TRUE );
			$res_email = get_post_meta( $post->ID, 'res_email', TRUE );
			$res_phone = get_post_meta( $post->ID, 'res_phone', TRUE );
			$res_quantity = get_post_meta( $post->ID, 'res_quantity', TRUE );
			$res_comments = get_post_meta( $post->ID, 'res_comments', TRUE );
			
			echo '<tr>';
			echo '<td>' . $res_name . '</td>';
			echo '<td>' . $res_email . '</td>';
			echo '<td>' . $res_phone . '</td>';
			echo '<td>' . $res_quantity . '</td>';
			echo '<td>' . $res_comments . '</td>';
			echo '</tr>';
		}
		
		echo '</tbody>';
		echo '</table>';
		
		echo '<a href="' . add_query_arg( "export", get_the_ID() ) . '">Exportar a cvs</a>';
	}
	else
	{
		echo "<h3>No hi ha reserves per aquest esdeveniment.</h3>";
	}
}