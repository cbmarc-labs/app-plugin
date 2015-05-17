<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<table>
	<thead>
		<th style="width:50%;"></th>
		<th style="width:50%;"></th>
	</thead>
	<tbody>
	
		<!-- <tr>
			<td colspan="2">
				<h4><?php APP_Lang::_ex( 'property_meta_box_property_location_title' ) ?></h4>
			</td>
		</tr> -->
		
		<div id="googleMap" style="height:380px;"></div>
		
		<script>
		var geocoder;
		var map;

		function initialize() {

		    geocoder = new google.maps.Geocoder();

		    var latlng = new google.maps.LatLng(-34.397, 150.644);
		    var mapOptions = {
		        zoom: 14,
		        center: latlng
		    };

		    map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);

		    // Call the codeAddress function (once) when the map is idle (ready)
		    google.maps.event.addListenerOnce(map, 'idle', codeAddress);
		}

		function codeAddress() {

		    // Define address to center map to
		    var address = 'carrer montserrat,43,el vendrell,tarragona';

		    geocoder.geocode({
		        'address': address
		    }, function (results, status) {

		        if (status == google.maps.GeocoderStatus.OK) {

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

		initialize();
		</script>
		
	</tbody>
</table>