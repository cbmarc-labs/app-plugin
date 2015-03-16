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
		
		// quan s'esborra un post, s'han de borrar els posts fills també
		add_action( 'delete_post', array( &$this, 'delete_post' ) );
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
	 * parse_query method
	 *
	 * @access public
	 */
	public function delete_post( $post_id )
	{
		global $wpdb;
		global $post_type;
		
		// If this isn't a 'tribe_events' post, don't update it.
		if ( TribeEvents::POSTTYPE != $post_type )
		{
			return;
		}
		
		// Verification of User
		if ( !current_user_can( 'edit_post', $post_id ) )
		{
			return;
		}
		
		// delete all child posts
		$posts = get_posts( array(
			'post_type'      => TribeEvents::POSTTYPE,
			'posts_per_page' => -1,
			'meta_query' => array(
					array(
							'key'     => '_AppCalendarParent',
							'value'   => $post_id,
							'compare' => '='
					)
			)
		) );
		
		if (is_array($posts) && count($posts) > 0)
		{
			App::log( 'Borrandoooooooooooooooooooooooo ' . $post->ID );
		
			// Delete all the Children of the Parent Page
			foreach($posts as $post)
			{
				wp_delete_post($post->ID, true);
			}
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