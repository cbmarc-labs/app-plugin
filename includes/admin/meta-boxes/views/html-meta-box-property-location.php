<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<script type="text/javascript">
<!--
	jQuery(document).ready(function( $ ) {

		var geocoder;
		var map;

		function initialize() {

		    geocoder = new google.maps.Geocoder();

		    //var latlng = new google.maps.LatLng(-34.397, 150.644);
		    var latlng = new google.maps.LatLng(40.2085, -3.713);
		    var mapOptions = {
		        zoom: 5,
		        center: latlng
		    };

		    map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
		}

		function codeAddress() {
			var address = $('#meta_box_property_location_address').val();
			var city = $('#meta_box_property_location_city').val();
			var province = $('#meta_box_property_location_province').val();

		    geocoder.geocode({
		        'address': address+', '+city+', '+province
		    }, function (results, status) {

		        if (status == google.maps.GeocoderStatus.OK) {

		        	$('#meta_box_property_location_geocode').val(results[0].geometry.location);

		        	map.setZoom(14);

		            // Center map on location
		            map.setCenter(results[0].geometry.location);

		            // Add marker on location
		            var marker = new google.maps.Marker({
		                map: map,
		                position: results[0].geometry.location
		            });

		        } else {

		            alert("Geocode was not successful for the following reason: " + status);
		        }
		    });
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
				<input id="meta_box_property_location_address" class="" type="text" />
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
				<input id="meta_box_property_location_city" class="" type="text" />
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
				<input id="meta_box_property_location_province" class="" type="text" />
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
				<input id="meta_box_property_location_geocode" class="" type="text" />
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<input id="meta_box_property_location_address_button" type="button" value="Localizar en el mapa" class="button">
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<div id="googleMap" style="height:380px;"></div>
			</td>
		</tr>
		
	</tbody>
</table>