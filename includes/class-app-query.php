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
		$vars[] = "location";
		$vars[] = "min_rooms";
		$vars[] = "min_price";
		$vars[] = "max_price";
		$vars[] = "min_area";
		$vars[] = "feature";
		$vars[] = "sortby";
		
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
		
		if( ! $query->is_post_type_archive( 'property' ) && 
				! $query->is_tax( get_object_taxonomies( 'property' ) ) ) {
			return;
		}
        
		$query->set( 'posts_per_page', 12 );
		
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
		
		// Filter by location taxonomy
		if( isset( $query->query_vars['location'] ) && !empty( $query->query_vars['location'] ) ) {
			$safe_location = sanitize_text_field( $query->query_vars['location'] );
		
			if( $safe_location != '0' ) {
				$query->set( 'tax_query',
						array(
								array(
										'taxonomy' => 'property-location',
										'field'    => 'slug',
										'terms'    => $safe_location,
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
		if( isset( $query->query_vars['min_area'] ) && ! empty( $query->query_vars['min_area'] ) ) {
			$safe_min_area = intval( $query->query_vars['min_area'] );
			
			$meta_query[] = array(
				'key'		=> '_property_area',
				'value'		=> $safe_min_area,
				'type'		=> 'NUMERIC',
				'compare'	=> '>=',
			);
		}
		
		// filter by min_price
		if( isset( $query->query_vars['min_price'] ) && ! empty( $query->query_vars['min_price'] ) ) {
			$safe_min_price = intval( $query->query_vars['min_price'] );
			
			$meta_query[] = array(
				'key'		=> '_property_price',
				'value'		=> $safe_min_price,
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

		// Filter by location taxonomy
		if( isset( $query->query_vars['feature'] ) && !empty( $query->query_vars['feature'] ) ) {
			$features = $query->query_vars['feature'];
			
			foreach ($query->query_vars['feature'] as $f) {
				$features_array[] = sanitize_text_field( $f );
			}
		
			if (isset($features_array) ) {
				$query->set( 'tax_query',
						array(
								array(
										'taxonomy' => 'property-feature',
										'field'    => 'slug',
										'terms'    => $features_array
								)
						)
				);
			}
		}
		
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'DESC' );
		
		// Filter by sort
		if( isset( $query->query_vars['sortby'] ) && !empty( $query->query_vars['sortby'] ) ) {
			$orderby = $query->query_vars['sortby'];
			
			switch( $orderby ) {
				case 2: 
					$query->set( 'orderby', 'date' );
					$query->set( 'order', 'ASC' );
					break;
				case 3: 
					$query->set( 'orderby', 'meta_value_num' );
					$query->set( 'meta_key', '_property_price' );
					$query->set( 'order', 'ASC' );
					break;
				case 4: 
					$query->set( 'orderby', 'meta_value_num' );
					$query->set( 'meta_key', '_property_price' );
					$query->set( 'order', 'DESC' );
					break;
				case 5:
					$query->set( 'orderby', 'meta_value_num' );
					$query->set( 'meta_key', '_property_area' );
					$query->set( 'order', 'ASC' );
					break;
				case 6:
					$query->set( 'orderby', 'meta_value_num' );
					$query->set( 'meta_key', '_property_area' );
					$query->set( 'order', 'DESC' );
					break;
			}
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
