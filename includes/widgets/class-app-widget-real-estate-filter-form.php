<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Widget_Real_Estate_Filter_Form' ) ) :

/**
 * APP_Widget_Real_Estate_Filter_Form
 *
 * Clase APP_Widget_Real_Estate_Filter_Form
 *
 * @class 		APP_Widget_Real_Estate_Filter_Form
 * @version		1.0.0
 * @package		Application/includes/widgets/APP_Widget_Real_Estate_Filter_Form
 * @category	Class
 * @author 		cbmarc
 */
class APP_Widget_Real_Estate_Filter_Form extends WP_Widget
{
	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		App::log( 'APP_Widget_Real_Estate_Filter_Form Class Initialized' );
		
		parent::__construct(
				'APP_Widget_Real_Estate_Filter_Form', // Base ID
				__('Real Estate Filter Form', 'app'), // Name
				array( 'description' => __( 'Real Estate Filter Form', 'app' ), )
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
		
		include_once( APP_TEMPLATE_PATH . 'templates/real-estate-form-filter.php' );
		
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
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'New title', 'text_domain' );
		}
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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

		return $instance;
	}
} // end class APP_Widget_Real_Estate_Filter_Form

endif;