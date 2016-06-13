<?php
function register_d_contact_widget() {
    register_widget( 'd_contact' );
}
add_action( 'widgets_init', 'register_d_contact_widget' );

class d_contact extends WP_Widget {
	private $themename = 'deeds';

	public function __construct() {
		parent::__construct(
			'd_contact_widget',
			__('D Contact', $this->themename),
			array( 'description' => __( 'Display contact detail from theme options page.', $this->themename ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$html  = '<ul>';

		if(print_option('contact-address') != '') {
			$html .= '<li><i class="icon-home"></i>'.print_option("contact-address").'</li>';
		}

		if(print_option('contact-phone') != '') {
			$html .= '<li><i class="icon-phone"></i>'.print_option("contact-phone").'</li>';
		}

		if(print_option('contact-fax') != '') {
			$html .= '<li><i class="icon-print"></i>'.print_option("contact-fax").'</li>';
		}

		if(print_option('contact-email') != '') {
			$html .= '<li><i class="icon-envelope"></i>'.print_option("contact-email").'</li>';
		}

		$html .= '</ul>';

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		echo $html;
		echo $args['after_widget'];
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Contact', $this->themename );
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
?>