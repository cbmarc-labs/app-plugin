<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'APP_Query' ) ) :

/**
 * APP_Query
 *
 * APP_Query
 *
 * @class 		APP_Query
 * @version		1.0.0
 * @package		application/includes/APP_Query
 * @category	Class
 * @author 		marc
 */
class APP_Query
{
	/**
	 * The Constructor
	 */
	public function __construct()
	{
		if( ! is_admin() ) {
			add_filter( 'query_vars', array( $this, 'query_vars'), 0 );
			add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * query_vars method
	 *
	 * @access public
	 */
	public function query_vars( $vars )
	{		
		return $vars;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * pre_get_posts method
	 * 
	 * filtra la llista al front-end
	 *
	 * @access public
	 */
	public function pre_get_posts( $query )
	{
		if( ! $query->is_main_query() ) {
			return;
		}
		
		if( ! $query->is_post_type_archive( 'project' ) && 
				! $query->is_tax( get_object_taxonomies( 'project' ) ) ) {
			return;
		}
		
		$meta_query = $query->get('meta_query');
		
		$query->set( 'meta_query', $meta_query );
		
		add_filter( 'posts_where', array( &$this, 'posts_where' ) );
 		
 		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * posts_where method
	 *
	 * @access public
	 */
	public function posts_where( $where = '' )
	{		
		return $where;
	}
}

endif;

return new APP_Query();
