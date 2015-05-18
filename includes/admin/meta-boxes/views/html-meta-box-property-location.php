<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$pieces = explode(",", $data[ 'location_geocode' ]);

// default values
$map_lat = '40.2085';
$map_lng = '-3.713';
$zoom = 5;

if( isset( $pieces[0] ) && isset( $pieces[1] ) && isset( $pieces[2] ) ) {
	$map_lat = $pieces[0];
	$map_lng = $pieces[1];
	$zoom = $pieces[2];
}
?>

<script type="text/javascript">
<!--
	jQuery(document).ready(function( $ ) {

		var geocoder = new google.maps.Geocoder();
		var map;
		var marker;

		function initialize() {
			map = new google.maps.Map(
					document.getElementById("googleMap"), {
				        zoom: <?php echo $zoom; ?>,
				        streetViewControl: false,
				        center: new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>)
				    }
			);
	
			marker = new google.maps.Marker({
			    map: map
			});

			<?php if( isset( $pieces[3] ) && isset( $pieces[4] ) ): ?>
				var myLatlng = new google.maps.LatLng(<?php echo $pieces[3]; ?>, <?php echo $pieces[4]; ?>);
				marker.setPosition(myLatlng);
			<?php endif; ?>

			google.maps.event.addListener(marker, "click", function(event) {
				marker.setPosition(null);
				updateInput();
			});

			google.maps.event.addListener(map, "click", function(event) {
				marker.setPosition(event.latLng);
				updateInput();
			});

			google.maps.event.addListener(map, 'idle', function(){
				updateInput();
			});
		}

		function codeAddress() {
			var address = $('#meta_box_property_location_address').val();
			var city = $('#meta_box_property_location_city').val();
			var province = $('#meta_box_property_location_province').val();

		    geocoder.geocode({
		        'address': address+', '+city+', '+province
		    }, function (results, status) {

		        if (status == google.maps.GeocoderStatus.OK) {

		            map.setZoom(14);
		            map.setCenter(results[0].geometry.location);
		            
		            marker.setPosition(results[0].geometry.location);

		            updateInput();

		        } else {
		            alert("Geocode was not successful for the following reason: " + status);
		        }
		    });
		}

		function updateInput() {
			var c = map.getCenter();
			var lat = c.lat();
			var lng = c.lng();
			var zoom = map.getZoom();

			var string = lat+','+lng+','+zoom;

			var m = marker.getPosition();
			if(m){
				var mlat = m.lat();
				var mlng = m.lng();

				string += ","+mlat+","+mlng;
			}

            $('#meta_box_property_location_geocode').val(string);
		}

		google.maps.event.addDomListener(window, 'load', initialize);

		$('#meta_box_property_location_address_button').click(function(){
			codeAddress();
		});
		
	});
//-->
</script>

<table style="width:100%">
	<thead>
		<th style="width:25%;"></th>
		<th style="width:75%;"></th>
	</thead>
	<tbody>
	
		<!-- <tr>
			<td colspan="2">
				<h4><?php APP_Lang::_ex( 'property_meta_box_property_location_title' ) ?></h4>
			</td>
		</tr> -->
		
		<tr>
			<td>Dirección :</td>
			<td>
				<input id="meta_box_property_location_address" style="width:100%;"
					name="meta_box_property_location_address" class="" type="text" 
					value="<?php echo $data[ 'location_address' ]; ?>"/>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small>Por ejemplo: calle nueva,5</small>
			</td>
		</tr>
		
		<tr>
			<td>Municipio :</td>
			<td>
				<input id="meta_box_property_location_city" style="width:50%;"
					name="meta_box_property_location_city" class="" type="text" 
					value="<?php echo $data[ 'location_city' ]; ?>"/>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small>Por ejemplo: El vendrell</small>
			</td>
		</tr>
		
		<tr>
			<td>Provincia :</td>
			<td>
				<input id="meta_box_property_location_province" style="width:40%;"
					name="meta_box_property_location_province" class="" type="text" 
					value="<?php echo $data[ 'location_province' ]; ?>"/>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small>Por ejemplo: Tarragona</small>
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<input id="meta_box_property_location_geocode" 
					name="meta_box_property_location_geocode" style="width:500px;" class="" type="hidden" 
					value="<?php echo $data[ 'location_geocode' ]; ?>" />
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<input id="meta_box_property_location_address_button" type="button" 
					value="Localizar en el mapa" class="button">
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<div id="googleMap" style="height:380px;"></div>
			</td>
		</tr>
		
	</tbody>
</table>