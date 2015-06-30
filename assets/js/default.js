jQuery(document).ready(function($){

	$('.autonumeric').autoNumeric('init');
	$('.currency').autoNumeric(
			'init', {
				vMax: '99999999999', vMin: '-9999999999999',
				pSign: 's', aSign: ' €',
				aDec: ',', aSep: '.' 
			}
	);
	$('.numeric').autoNumeric(
			'init', {
				vMax: '999999999.99', vMin: '-99999999999.99',
				aDec: ',', aSep: '.' 
			}
	);
	
});