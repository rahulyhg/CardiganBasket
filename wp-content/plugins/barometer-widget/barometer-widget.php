<?php
/**
 * Plugin Name: Barometer-widget plugin
 * Description: Calculate how much money has been spent by customers using the Teifi Basket E-commerce Site.
 * Author: Mark Davies
 */
// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of widget
'wpb_widget', 

// Widget name will appear in UI
__('MPMultisite Widget', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Calculate how much money has been spent by customers using the Teifi Basket E-commerce Site', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
global $wpdb,$mp;
global $switched;
//$blog_id = $GLOBALS['current_blog']->blog_id;
$main=0;
$blog_list = get_blog_list( 0, 'all' );
$main=0;
foreach ($blog_list AS $blog)
{
    $table1 = $wpdb->get_blog_prefix($blog['blog_id']) . 'posts';
    $table2 = $wpdb->get_blog_prefix($blog['blog_id']) . 'postmeta';
    global $wpdb;
    $post_id = $wpdb->get_results("SELECT * FROM $table2 INNER JOIN $table1 ON $table2.post_id = $table1.ID  WHERE post_status = 'order_received' AND meta_key='mp_order_total' ");
		
                        for($i=0; $i<count($post_id); $i++){
		                  $post_id[$i]->meta_value."</br>";
                            $main = $post_id[$i]->meta_value + $main;	
                        }
}
 ?>
<span class="order"><?php echo $mp->format_currency('', $main); ?>&nbsp;&nbsp;has been put back into Cardigan from customers shopping here.</span>
<?php  

echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
?>