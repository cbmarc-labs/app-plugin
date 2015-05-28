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
 * @author 		cbmarc
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
		$vars[] = "type";
		$vars[] = "transaction";
		$vars[] = "min_rooms";
		$vars[] = "max_price";
		$vars[] = "min_m2";
		
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
		
		if( !isset( $query->query_vars['post_type'] ) ) {
			return;
		}
		
		if( $query->query_vars['post_type'] !== 'property' ) {
			return;
		}
            
		$meta_query = $query->get('meta_query');
		
		// Filter by type taxonomy
		if( isset( $query->query_vars['type'] ) && !empty( $query->query_vars['type'] ) ) {
			$safe_type = sanitize_text_field( $query->query_vars['type'] );
		
			if( $safe_type != '0' ) {
				$query->set( 'tax_query',
						array(
								array(
										'taxonomy' => 'property-type',
										'field'    => 'slug',
										'terms'    => $safe_type,
								)
						)
				);
			}
		}
		
		// Filter by type taxonomy
		if( isset( $query->query_vars['transaction'] ) && !empty( $query->query_vars['transaction'] ) ) {
			$safe_transaction = sanitize_text_field( $query->query_vars['transaction'] );
		
			if( $safe_transaction != '0' ) {
				$query->set( 'tax_query',
						array(
								array(
										'taxonomy' => 'property-transaction',
										'field'    => 'slug',
										'terms'    => $safe_transaction,
								)
						)
				);
			}
		}
		
		// filter by min rooms
		if( isset( $query->query_vars['min_rooms'] ) && ! empty( $query->query_vars['min_rooms'] ) ) {
			$safe_min_rooms = intval( $query->query_vars['min_rooms'] );
			
			$meta_query[] = array(
				'key'		=> '_property_rooms',
				'value'		=> $safe_min_rooms,
				'type'		=> 'NUMERIC',
				'compare'	=> '>=',
			);
		}
		
		// filter by min rooms
		if( isset( $query->query_vars['min_m2'] ) && ! empty( $query->query_vars['min_m2'] ) ) {
			$safe_min_m2 = intval( $query->query_vars['min_m2'] );
			
			$meta_query[] = array(
				'key'		=> '_property_m2',
				'value'		=> $safe_min_m2,
				'type'		=> 'NUMERIC',
				'compare'	=> '>=',
			);
		}
		
		// filter by max_price
		if( isset( $query->query_vars['max_price'] ) && ! empty( $query->query_vars['max_price'] ) ) {
			$safe_max_price = intval( $query->query_vars['max_price'] );
			
			$meta_query[] = array(
				'key'		=> '_property_price',
				'value'		=> $safe_max_price,
				'type'		=> 'NUMERIC',
				'compare'	=> '<=',
			);
		}
		
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
