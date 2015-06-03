<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$map	= explode( ",", $data['property_location_map'] );
$marker	= explode( ",", $data['property_location_marker'] );

// default values
$map_lat	= '40.2085';
$map_lng	= '-3.713';
$map_zoom	= 5;

if( isset( $map[0] ) && isset( $map[1] ) && isset( $map[2] ) ) {
	$map_lat	= $map[0];
	$map_lng	= $map[1];
	$map_zoom	= $map[2];
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
					document.getElementById("property_map_container"), {
						scrollwheel: false,
				        zoom: <?php echo $map_zoom; ?>,
				        streetViewControl: false,
				        center: new google.maps.LatLng('<?php echo $map_lat; ?>', '<?php echo $map_lng; ?>')
				    }
			);
	
			marker = new google.maps.Marker({
			    map: map
			});

			<?php if( isset( $marker[0] ) && isset( $marker[1] ) ): ?>
				var myLatlng = new google.maps.LatLng(<?php echo $marker[0]; ?>, <?php echo $marker[1]; ?>);
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

		function searchAddress() {
			var address = $('#property_location_address').val();

		    geocoder.geocode({
		        'address': address
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

			var map_data = lat+','+lng+','+zoom;
			$('#property_location_map').val(map_data);

			var m = marker.getPosition();
			var marker_data = '';
			if(m){
				var mlat = m.lat();
				var mlng = m.lng();

				var marker_data = mlat+','+mlng;
			}

			$('#property_location_marker').val(marker_data);
		}

		google.maps.event.addDomListener(window, 'load', initialize);

		$('#property_location_search_button').click(function(){
			searchAddress();
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
		
		<tr>
			<td> <?php _e( 'Address', 'app' ); ?> :</td>
			<td>
				<input id="property_location_address" style="width:100%;"
					name="property_location_address" class="" type="text" 
					value="<?php echo $data['property_location_address']; ?>"/>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<small><?php _e( 'e.g.', 'app' ); ?>: carrer santa anna, 1, el vendrell, tarragona</small>
			</td>
		</tr>
		
		<input id="property_location_map" name="property_location_map" type="hidden" 
					value="<?php echo $data['property_location_map']; ?>" />
		<input id="property_location_marker" name="property_location_marker" type="hidden" 
					value="<?php echo $data['property_location_marker']; ?>" />
		
		<tr>
			<td colspan="2">
				<input id="property_location_search_button" type="button" 
					value="<?php _e( 'Locate on the map', 'app' ); ?>" class="button">
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<div id="property_map_container" style="height:380px;"></div>
			</td>
		</tr>
		
	</tbody>
</table>