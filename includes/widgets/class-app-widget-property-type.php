<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Widget_Property_Type' ) ) :

/**
 * APP_Widget_Property_Type
 *
 * Clase APP_Widget_Property_Type
 *
 * @class 		APP_Widget_Property_Type
 * @version		1.0.0
 * @package		Application/includes/widgets/APP_Widget_Property_Type
 * @category	Class
 * @author 		cbmarc
 */
class APP_Widget_Property_Type extends WP_Widget
{
	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		App_Log::log( 'APP_Widget_Property_Type Class Initialized' );
		
		parent::__construct(
				'APP_Widget_Property_Type', // Base ID
				__('Widget Property Type', 'app'), // Name
				array( 'description' => __( 'Widget Property Type', 'app' ) )
		);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		
		echo $before_widget;
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		$args = array(
				'show_option_all'    => '',
				'orderby'            => 'name',
				'order'              => 'ASC',
				'style'              => 'list',
				'show_count'         => 0,
				'hide_empty'         => 1,
				'use_desc_for_title' => 0,
				'child_of'           => 0,
				'feed'               => '',
				'feed_type'          => '',
				'feed_image'         => '',
				'exclude'            => '',
				'exclude_tree'       => '',
				'include'            => '',
				'hierarchical'       => 1,
				'title_li'           => '',//__( 'Categories' ),
				'show_option_none'   => __( '' ),
				'number'             => null,
				'echo'               => 1,
				'depth'              => 0,
				'current_category'   => 0,
				'pad_counts'         => 0,
				'taxonomy'           => $instance['type'],
				'walker'             => null
		);
		
		wp_list_categories( $args );
		
		echo $after_widget;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'New title', 'text_domain' );
		}
		
		$type = 1;
		if( isset( $instance['type'] ) ) {
			$type = $instance['type'];
		}
		
		$taxonomies = get_object_taxonomies( 'property', 'objects' );
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" 
				name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" 
				value="<?php echo esc_attr( $title ); ?>">
			
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type:' ); ?></label>	
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat" style="width:100%;">
			<?php 
			foreach( $taxonomies as $taxonomy ) {
				echo '<option ';
				if ( $taxonomy->name == $type ) echo 'selected="selected"';
				echo ' value="' . $taxonomy->name . '">' . $taxonomy->labels->name . '</option>';
			}
			?>
            </select>
		</p>
		<?php 
	}

	// --------------------------------------------------------------------
	
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';

		return $instance;
	}
} // end class APP_Widget_Property_Type

endif;