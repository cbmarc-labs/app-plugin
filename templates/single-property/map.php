<?php
/**
 * Single Property
 *
 * @author 		cbmarc
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $property;

$ubicacion = get_post_meta( $post->ID, '_property_location_address', 1 );

$map	= explode( ",", get_post_meta( $post->ID, '_property_location_map', 1 ) );
$marker	= explode( ",", get_post_meta( $post->ID, '_property_location_marker', 1 ) );

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
		}

		google.maps.event.addDomListener(window, 'load', initialize);
		
	});
//-->
</script>

<h1>Ubicación</h1>

<?php echo $ubicacion; ?>


<div id="property_map_container" style="height:380px;"></div>
