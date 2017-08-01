class image_widget extends WP_Widget {
 
public function __construct() {
		parent::__construct(
	 		'image_widget',
			'Image Upload Widget',
 
			array( 'description' => __( 'A widget to upload image', 'iuw' ), ) /*description*/
		);
	}
 
	/* $instance Saved values from database*/
	public function widget( $args, $instance ) {
		extract( $args );
		$name = apply_filters( 'widget_name', $instance['name'] );
		$name = apply_filters( 'widget_link', $instance['link'] );
		$image_uri = apply_filters( 'widget_image_uri', $instance['image_uri'] );
		echo $before_widget; ?>
        	<a href="<?php echo esc_url($instance['link']); ?>"><img src="<?php echo esc_url($instance['image_uri']); ?>" /></a>
        
    <?php
		echo $after_widget;
	}
 
	/*$new_instance Values just sent to be saved.
	 *$old_instance Previously saved values from database.
	 *
	 * Updated safe values to be saved.*/
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['name'] = ( ! empty( $new_instance['name'] ) ) ? strip_tags( $new_instance['name'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
		$instance['image_uri'] = ( ! empty( $new_instance['image_uri'] ) ) ? strip_tags( $new_instance['image_uri'] ) : '';
		return $instance;
	}
 
	/*array $instance Previously saved values from database*/
	public function form( $instance ) {
        if ( isset( $instance[ 'image_uri' ] ) ) {
			$image_uri = $instance[ 'image_uri' ];
		}
		else {
			$image_uri = __( '', 'iuw' );
		}
		if ( isset( $instance[ 'name' ] ) ) {
			$name = $instance[ 'name' ];
		}
		else {
			$name = __( 'New title', 'iuw' );
		}
		if ( isset( $instance[ 'link' ] ) ) {
			$link = $instance[ 'link' ];
		}
		else {
			$link = __( 'http://', 'iuw' );
		}
		
		?>
		<p>
      <label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Title', 'iuw'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('name'); ?>" id="<?php echo $this->get_field_id('name'); ?>" value="<?php echo $name; ?>" class="widefat" />
    </p>
    <!-- <p>
      <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link', 'iuw'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('link'); ?>" id="<?php echo $this->get_field_id('link'); ?>" value="<?php echo $link; ?>" class="widefat" />
    </p> -->
    
    <p>
      <label for="<?php echo $this->get_field_id('image_uri'); ?>">Image</label><br />
        <img class="custom_media_image" src="<?php echo $image_uri; ?>" style="margin:0;padding:0;max-width:50%;float:left;display:inline-block" />
        <input type="text" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $image_uri; ?>">
       </p>
       <p>
        <input type="button" value="<?php _e( 'Upload Image', 'iuw' ); ?>" class="button custom_media_upload" id="custom_image_uploader"/>
    </p>
		<?php 
	}
	
}
add_action( 'widgets_init', create_function( '', 'register_widget( "image_widget" );' ) );
function iuw_wdScript(){
  wp_enqueue_media();
  wp_enqueue_script( 'adsScript', get_theme_file_uri( '/assets/js/image-upload-widget.js' ), array( 'jquery' ), '1.0', true );
} //call appropriate js path
add_action('admin_enqueue_scripts', 'iuw_wdScript');
