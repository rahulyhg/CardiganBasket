<?php

/**
 * Custom admin login header logo
 */
 
 /* auto-detect the server so you only have to enter the front/from half of the email address, including the @ sign */
function xyz_filter_wp_mail_from($email){
/* start of code lifted from wordpress core, at http://svn.automattic.com/wordpress/tags/3.4/wp-includes/pluggable.php */
$sitename = strtolower( $_SERVER['SERVER_NAME'] );
if ( substr( $sitename, 0, 4 ) == 'www.' ) {
$sitename = substr( $sitename, 4 );
}
/* end of code lifted from wordpress core */
$myfront = "order@";
$myback = $sitename;
$myfrom = $myfront . $myback;
return $myfrom;
}
add_filter("wp_mail_from", "xyz_filter_wp_mail_from");

/* enter the full name you want displayed alongside the email address */
/* from http://miloguide.com/filter-hooks/wp_mail_from_name/ */
function xyz_filter_wp_mail_from_name($from_name){
return "Teifi Basket";
}
add_filter("wp_mail_from_name", "xyz_filter_wp_mail_from_name");



 
 // remove the site title from the store list
function custom_framemarket_list_shops( $blogs ){
		if ( !empty($blogs) && isset($blogs[0]) && $blogs[0]->blog_id == 1 ) {
			unset($blogs[0]);
		}
	return $blogs;
}
add_filter( 'framemarket_list_shops', 'custom_framemarket_list_shops' ); 
 
 
 
// redirect to homepage when a user logs out 
add_action('wp_logout','go_home');
function go_home(){
  wp_redirect( home_url() );
  exit();
}

//Mark Davies - function to remove the 'register' link in wp-login
 add_action( 'login_head', 'hide_login_nav' );
 
 /**
 * Disable admin bar on the frontend of your website
 * for subscribers.
 */
/*function themeblvd_disable_admin_bar() { 
	if( ! current_user_can('edit_posts') )
		add_filter('show_admin_bar', '__return_false');	
}
add_action( 'after_setup_theme', 'themeblvd_disable_admin_bar' );
*/

// Hides the Admin Bar
function my_function_admin_bar(){
	 return false; 
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');
		
 
/**
 * Redirect back to homepage and not allow access to 
 * WP admin for Subscribers.
 */
/*function themeblvd_redirect_admin(){
	if ( ! current_user_can( 'edit_posts' ) ){
		wp_redirect( site_url() );
		exit;		
	}
}
add_action( 'admin_init', 'themeblvd_redirect_admin' );
*/


/* On Logout, redirect to homepage*/
/*add_action('wp_logout','go_home');
function go_home(){
 $domain_name =  preg_replace('/^www\./','',$_SERVER['SERVER_NAME']);
  wp_redirect( $domain_name );
  exit();
}
*/

function hide_login_nav()
{
    ?><style>#nav{display:none}</style><?php
}
 
//Mark Davies - function for adding the local badge from the custom field into my category page
function custom_mp_product_list_content(  $product_content, $post_id ){
	if(is_tax( 'product_category' )){
		//grab custom local badge
		$your_custom_field = get_post_meta( $post_id, 'ct_Locally_Ma_checkbox_5706', true);
		if ( $your_custom_field == 'Yes' ) {
			$local_badge = '<img src='.content_url().'/themes/framemarket/images/locally_made_icon.png width=172px; height=172px; style="position: absolute; z-index:5000" />';
			$product_content = $local_badge.$product_content;
		}
	}
	return $product_content;
}
add_filter('mp_product_list_content', 'custom_mp_product_list_content', 10 , 2); 
 
 
// Mark Davies 
function custom_login_logo() {
    echo '<style type="text/css">'.
             'h1 a { background-image:url('.get_bloginfo( 'template_directory' ).'/images/login-logo.png) !important; }'.
         '</style>';
}
add_action( 'login_head', 'custom_login_logo' );

/*
//Mark Davies
add_filter('wp_mail_from','yoursite_wp_mail_from');
function yoursite_wp_mail_from($content_type) {
  return 'admin@teifibasket.co.uk';
}
add_filter('wp_mail_from_name','yoursite_wp_mail_from_name');
function yoursite_wp_mail_from_name($name) {
  return 'Teifi Basket';
}
*/



add_action( 'after_setup_theme', 'gridmarket_setup', 10 );
function gridmarket_setup() {

		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 720;
		}
	}


function framemarket_enqueue_styles(){
	$version = '1.4';

	global $bp_existed;


	if ( (!is_admin()) && ($bp_existed == 'true') ) {
		wp_enqueue_style( 'buddypress-default', get_template_directory_uri() . '/buddypress/bp-default.css', array( 'framemarket' ), $version);
	}

	if ( !is_admin() ) {
		wp_enqueue_style( 'framemarket', get_template_directory_uri() . '/css/framemarket.css', array(), $version);

		wp_enqueue_style( 'gridmarket', get_stylesheet_directory_uri() . '/css/grid.css', array( 'framemarket' ), $version);

				$themename = wp_get_theme();
				$themeinput = $themename . '_styleinput';

				$options = get_option('framemarket_theme_options');
				$stylesheet = isset($options[$themeinput]) ? $options[$themeinput] : '';

				if ($stylesheet != ""){
					wp_enqueue_style( 'gridmarket_style', get_stylesheet_directory_uri() .  '/styles/' . $stylesheet . '.css', array( 'framemarket' ), $version);

				}
				else{
				wp_enqueue_style( 'gridmarket_cardigan-colours', get_stylesheet_directory_uri() . '/styles/cardigan-colours.css', 'cardigan-colours');
				}

				wp_enqueue_style( 'gridmarket_custom', get_stylesheet_directory_uri() . '/css/custom.css', array( 'framemarket' ), $version);
			 }

}



function gridmarket_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer one', 'framemarket' ),
			'id'            => 'footer-one',
			'description'   => 'Footer one',
			'before_widget' => '<div id="%1$s" class="footer-widget side widget %2$s">',
        	'after_widget' => '</div>',
        	'before_title' => '<h3 class="widgettitle">',
        	'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer two', 'framemarket' ),
			'id'            => 'footer-two',
			'description'   => 'Footer two',
		'before_widget' => '<div id="%1$s" class="footer-widget side widget %2$s">',
        	'after_widget' => '</div>',
        	'before_title' => '<h3 class="widgettitle">',
        	'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer three', 'framemarket' ),
			'id'            => 'footer-three',
			'description'   => 'Footer three',
			'before_widget' => '<div id="%1$s" class="footer-widget side widget %2$s">',
        	'after_widget' => '</div>',
        	'before_title' => '<h3 class="widgettitle">',
        	'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer four', 'framemarket' ),
			'id'            => 'footer-four',
			'description'   => 'Footer four',
			'before_widget' => '<div id="%1$s" class="footer-widget side widget %2$s">',
        	'after_widget' => '</div>',
        	'before_title' => '<h3 class="widgettitle">',
        	'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer five', 'framemarket' ),
			'id'            => 'footer-five',
			'description'   => 'Footer five',
			'before_widget' => '<div id="%1$s" class="footer-widget side widget %2$s end">',
        	'after_widget' => '</div>',
        	'before_title' => '<h3 class="widgettitle">',
        	'after_title' => '</h3>'
		)
	);
}
add_action( 'widgets_init', 'gridmarket_widgets_init' );
require_once ( get_stylesheet_directory() . '/functions/theme.php' );

/*
add_action( 'init', 'add_custom_fields_to_product' );

function add_custom_fields_to_product() {

	add_post_type_support( 'product', 'custom-fields' );

}
*/
								

?>