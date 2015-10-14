<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Widget_Slider' ) ) :

/**
 * APP_Widget_Slider
 *
 * Clase APP_Widget_Slider
 *
 * @class 		APP_Widget_Slider
 * @version		1.0.0
 * @package		Application/includes/widgets/APP_Widget_Slider
 * @category	Class
 * @author 		cbmarc
 */
class APP_Widget_Slider extends WP_Widget
{
	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{		
		parent::__construct(
				'APP_Widget_Slider', // Base ID
				__( 'App Slider', 'app' ), // Name
				array( 'description' => __( 'Displays a slider on the page', 'app' ) )
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
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'app' ); ?> :</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" 
				name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" 
				value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'images' ); ?>"><?php _e( 'Images', 'app' ); ?> :</label>
			<input data-ids="jajaja" class="app-widget-slider widefat button button-primary"
				id="<?php echo $this->get_field_id( 'images' ); ?>" 
				name="<?php echo $this->get_field_name( 'images' ); ?>" type="button" 
				value="<?php _e( 'Choose images', 'app' ); ?>">
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
} // end class APP_Widget_Slider

endif;