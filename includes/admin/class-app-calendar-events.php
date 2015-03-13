<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Calendar_Events' ) ) :

/**
 * APP_Calendar_Events
 *
 * La clase APP_Reserva controla el proceso del calendario de los eventos
 *
 * @class 		APP_Calendar_Events
 * @version		1.0.0
 * @package		Application/includes/admin/APP_Calendar_Events
 * @category	Class
 * @author 		marc
 */
class APP_Calendar_Events
{
	// The single instance of the class
	private static $_instance = null;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct ()
	{
		App::log( 'APP_Calendar_Events Class Initialized' );

		// Metabox del calendari per seleccionar dates aleatoriament
		include_once( 'metaboxes/class-app-metabox-calendar-events.php' );
		
		// nomes ensenya l'esdeveniment pare
		add_action( 'pre_get_posts', array( &$this, 'pre_get_posts' ) );
	}
	
	// --------------------------------------------------------------------

	/**
	 * parse_query method
	 *
	 * @access public
	 */
	public function pre_get_posts( $query )
	{
		if( is_admin() && isset( $_GET['post_type'] ) && $_GET['post_type'] == TribeEvents::POSTTYPE )
		{
			$query->set( 'meta_query', array(
					'relation' => 'OR',
					array(
	                	'key'     => '_AppCalendarParent',
	                	'value'    => 0,
	                	'compare' => '=',
	            	),
					array(
	                	'key'     => '_AppCalendarParent',
	                	'compare' => 'NOT EXISTS',
	            	),
				)
			);
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * instance method
	 *
	 * @access public
	 */
	public static function instance()
	{
		if(!self::$_instance)
		{
			self::$_instance = new self();
		}

		return self::$_instance;
	}
	
}

endif;

/**
 * Create instance
 */
global $APP_Calendar_Events;
if( class_exists( 'APP_Calendar_Events' ) && !$APP_Calendar_Events )
{
	$APP_Calendar_Events = APP_Calendar_Events::instance();
}