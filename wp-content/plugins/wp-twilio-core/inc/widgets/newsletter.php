<?php

class twl_newseletter_widget extends WP_Widget {
  
	function __construct() {
		
		parent::__construct('twl_newseletter_widget',__('SMS Newsletter', 'twilio-core'), array( 'description' => __( 'Display SMS Newsletter subscription widget', 'twilio-core' ) ) 
		);
		
	}
	  
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $args['before_widget'];
		
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		require(TWL_PATH . 'inc/views/newsletter_form.php');
		
		echo $args['after_widget'];
	}
			  
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'twilio-core' );
		}
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
	<?php 
	}
		  
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		return $instance;
	}
	 
} 

