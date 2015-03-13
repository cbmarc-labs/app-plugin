<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Metabox_Calendar_Events' ) ) :

/**
 * APP_Metabox_Calendar_Events
*
* Calendario para el plugin the events calendar 
*
* @class 		APP_Metabox_Calendar_Events
* @version		1.0.0
* @package		application/includes/admin/metaboxes/APP_Metabox_Calendar_Events
* @category		Class
* @author 		cbmarc
*/
class APP_Metabox_Calendar_Events
{
	// The single instance of the class
	private static $_instance;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		App::log("APP_Metabox_Calendar_Events Class Initialized");
		
		wp_enqueue_script( 'jquery-ui-datepicker' );
		
		wp_enqueue_style( 'app-metabox-calendar_events-style', APP_TEMPLATE_DIR . 'assets/css/jquery-ui-timepicker-addon.min.css' );
		
		wp_enqueue_script( 'app-metabox-calendar-datepicker-ca-script', APP_TEMPLATE_DIR . 'assets/js/datepicker-ca.js', array( 'jquery-ui-datepicker' ) );
		wp_enqueue_script( 'app-metabox-calendar-timepicker-script', APP_TEMPLATE_DIR . 'assets/js/jquery-ui-timepicker-addon.min.js', array( 'jquery-ui-datepicker' ) );
		wp_enqueue_script( 'app-metabox-calendar-timepicker-ca-script', APP_TEMPLATE_DIR . 'assets/js/jquery-ui-timepicker-ca.js', array( 'jquery-ui-datepicker' ) );
		wp_enqueue_script( 'app-metabox-calendar-script', APP_TEMPLATE_DIR . 'assets/js/app-metabox-calendar.js', array( 'jquery-ui-datepicker' ), '1.0.0', true );

		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
		
		add_action( 'save_post', array( &$this, 'save_post' ), 15, 2 );
	}

	// --------------------------------------------------------------------

	/**
	 * getInstance method
	 *
	 * @access public
	 */
	public static function instance()
	{
		if ( is_null( self::$_instance ) )
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}

	// --------------------------------------------------------------------

	/**
	 * add_meta_boxes method
	 *
	 * @access public
	 */
	public function add_meta_boxes()
	{
		$screens = array( TribeEvents::POSTTYPE );
		
		foreach ( $screens as $screen )
		{
			add_meta_box(
				'app_metabox_calendar_events',
				__( 'Repeticions del esdeveniment' ), 
				array( &$this, 'meta_box_callback' ),
				$screen
			);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * meta_box_callback method
	 *
	 * @access public
	 */
	public function meta_box_callback()
	{
		global $post;
		
		$_AppCalendarPickerStart = get_post_meta( $post->ID, '_AppCalendarPickerStart', 1);
		$_AppCalendarPickerEnd = get_post_meta( $post->ID, '_AppCalendarPickerEnd', 1);
		
		// no seguir si es un esdeveniment amb recurrencia del propi tribe
		if(tribe_is_recurring_event( $post->ID ))
		{
			echo "Aquest esdeveniment no pot tenir repeticions perquè hi han recurrències.";
			
			return;
		}
		
		// no seguir si es un app child del esdeveniment
		$is_app_repeating = get_post_meta( $post->ID, '_AppCalendarParent');
		if($is_app_repeating[0] > 0)
		{
			echo "Aquest esdeveniment no pot tenir repeticions perquè no és l'entrada principal.";
			
			?>
			<script type="text/javascript">
			<!--
			jQuery(document).ready(function() {
				jQuery(".recurrence-row").hide();
			});
			//-->
			</script>
			<?php 
				
			return;
		}
		
		?>
<script type="text/javascript">
<!--
	jQuery(document).ready(function() {
		if(jQuery("#_AppCalendarPickerStart").val()) {
			jQuery(".recurrence-row").hide();
		}
		
		jQuery('[name="recurrence[type]"]').change(function(){
			if(jQuery(this).val() != "None") {
				jQuery("._AppCalendarPicker").hide();
				jQuery("._AppCalendarPickerText").show();
			} else {
				jQuery("._AppCalendarPicker").show();
				jQuery("._AppCalendarPickerText").hide();
			}
		});
		
		jQuery("._AppCalendarPicker").appCalendarPicker({
			datesStart: '<?php echo $_AppCalendarPickerStart ?>',
			datesEnd: '<?php echo $_AppCalendarPickerEnd ?>',
			
			onUpdate: function(datesStart, datesEnd){
				jQuery("#_AppCalendarPickerStart").val(datesStart);
				jQuery("#_AppCalendarPickerEnd").val(datesEnd);
			}
		});
		
	});
//-->
</script>

<div class="_AppCalendarPickerText" style="display:none;">Si hi han recurrències no hi poden haver repeticions.</div>
<div class="_AppCalendarPicker"></div>

<input type="hidden" name="_AppCalendarPicker_noncedata" id="_AppCalendarPicker_noncedata" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
<input type="hidden" name="_AppCalendarPickerStart" id="_AppCalendarPickerStart" value="<?php echo $_AppCalendarPickerStart; ?>" />
<input type="hidden" name="_AppCalendarPickerEnd" id="_AppCalendarPickerEnd" value="<?php echo $_AppCalendarPickerEnd; ?>" />

		<?php
	}

	// --------------------------------------------------------------------

	/**
	 * save_post method
	 *
	 * @access public
	 */
	public function save_post($post_id, $post)
	{
		// If this isn't a 'tribe_events' post, don't update it.
		if ( TribeEvents::POSTTYPE != $post->post_type )
		{
			return;
		}
		
		// Si hi ha recurrencia normal del tribe events no se segueix
		if ( $_POST["recurrence"]["type"] != 'None' )
		{
			return;
		}
		
		// Nomes es guarda el esdeveniment pare
		if ( !$_POST['_AppCalendarPickerStart'] )
		{
			return;
		}
		
		if ( empty( $_POST["_AppCalendarPicker_noncedata"] ) )
		{
			return;
		}
		
		if ( !wp_verify_nonce( $_POST['_AppCalendarPicker_noncedata'], plugin_basename(__FILE__) ) )
		{
			return;
		}
		
		// Verification of User
		if ( !current_user_can( 'edit_post', $post->ID ) )
		{
			return;
		}
		
		// OK, we're authenticated: we need to find and save the data
		$datesStart = $_POST['_AppCalendarPickerStart'];
		$datesEnd = $_POST['_AppCalendarPickerEnd'];
		
		if ( get_post_meta( $post->ID, '_AppCalendarPickerStart', FALSE ) )
		{
			update_post_meta( $post->ID, '_AppCalendarPickerStart', $datesStart );
			update_post_meta( $post->ID, '_AppCalendarPickerEnd', $datesEnd );
		}
		else
		{
			add_post_meta( $post->ID, '_AppCalendarPickerStart', $datesStart );
			add_post_meta( $post->ID, '_AppCalendarPickerEnd', $datesEnd );
			
			add_post_meta( $post->ID, '_AppCalendarParent', 0 );
		}
		
		unset($_POST['_AppCalendarPickerStart']);
		
		// delete all child posts
		$posts = get_posts( array(
			'post_type'      => TribeEvents::POSTTYPE,
			'posts_per_page' => -1,
			'meta_query' => array(
					array(
							'key'     => '_AppCalendarParent',
							'value'   => 0,
							'compare' => '>'
					)
			)
		) );
		
		if (is_array($posts) && count($posts) > 0)
		{
			// Delete all the Children of the Parent Page
			foreach($posts as $post)
			{
				wp_delete_post($post->ID, true);
			}
		}
		
		// create new child ones
		$datesStartArr = explode( ",", $datesStart );
		$datesEndArr = explode( ",", $datesEnd );
		
		for($it = 0; $it < count($datesStartArr); $it ++)
		{
			$startTimestamp = strtotime( $datesStartArr[$it] );
			
			$instance = new TribeEventsPro_RecurrenceInstance( $post_id, $startTimestamp );
			$instance->save();
			
			$post_child_id = $instance->get_id();
			
			wp_update_post(
				array(
      				'ID' 			=> $post_child_id,
      				'post_parent'	=> 0,
				)
			);
			
			$duration = strtotime( $datesEndArr[$it] ) - $startTimestamp;
			
			update_post_meta($post_child_id, '_EventEndDate', $datesEndArr[$it]);
			update_post_meta($post_child_id, '_EventDuration', $duration);
			
			update_post_meta( $post_child_id, '_AppCalendarParent', $post_id );
		}
	}

} // end class APP_Metabox_Gallery

endif;

/**
 * Create instance
 */
global $APP_Metabox_Calendar_Events;
if( class_exists( 'APP_Metabox_Calendar_Events' ) && !$APP_Metabox_Calendar_Events )
{
	$APP_Metabox_Calendar_Events = APP_Metabox_Calendar_Events::instance();
}