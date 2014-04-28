<?php

	require_once(get_template_directory() . '/functions/core.php');
	require_once(get_template_directory() . '/functions/blog-functions.php');

	if (!function_exists('m413_options')) {
		// Admin functions
		require_once(get_template_directory() . '/admin/admin-functions.php');
		require_once(get_template_directory() . '/admin/admin-interface.php');
		require_once(get_template_directory() . '/admin/theme-settings.php');
	}

	if ( ! class_exists( 'cmb_Meta_Box' ) ) {
		// register metaboxes
		require_once(get_template_directory() . '/functions/post-metabox.php');
		require_once(get_template_directory() . '/functions/page-metabox.php');
	}

	//add shortcodes functions
	require_once(get_template_directory() . '/functions/shortcodes.php');

	if(!class_exists('AQ_Page_Builder')) {
		//Register Aqua Page Builder 
		define( 'AQPB_PATH', get_template_directory() . '/functions/aqua-page-builder/' );
		define( 'AQPB_DIR', get_template_directory_uri() . '/functions/aqua-page-builder/' );
		define( 'AQPB_TEXT_DOMAIN_SLUG' , 'flexmarket' );
		require_once(get_template_directory() . '/functions/aqua-page-builder/aq-page-builder.php');
		require_once(get_template_directory() . '/functions/page-builder-blocks.php');
		if (class_exists( 'MarketPress' )) require_once(get_template_directory() . '/functions/page-builder-mp-blocks.php');
		require_once(get_template_directory() . '/functions/page-builder.php');
	}

	if ( class_exists( 'MarketPress' ) ) {
		//Register MarketPress related functions
		require_once(get_template_directory() . '/functions/mp-functions.php');
		require_once(get_template_directory() . '/functions/mp-metabox.php');
		require_once(get_template_directory() . '/functions/mp-widgets.php');
	}

	// Register Custom Navigation Walker
	require_once(get_template_directory() . '/functions/twitter_bootstrap_nav_walker.php');

	// register CSS 
	function mpt_register_style() {
		wp_enqueue_style('mp-reset-css', get_template_directory_uri() . '/css/mp-reset.css', null, null);
		wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.css', null, '3.2.3');
		wp_enqueue_style('bootstrap-responsive-css', get_template_directory_uri() . '/css/bootstrap-responsive.css', null, '3.2.3');
		wp_enqueue_style('prettyphoto-style', get_template_directory_uri() . '/css/prettyPhoto.css', null, null);
		wp_enqueue_style('css-animated-style', get_template_directory_uri() . '/css/animate.min.css', null, null);
		wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/css/font-awesome.min.css', null, '3.2.2');
		wp_enqueue_style('mpt-flexslider-css', get_template_directory_uri() . '/css/flexslider.css', null, '2.1');
		if ( class_exists('AQ_Page_Builder') )
			wp_enqueue_style('page-builder-custom-css', get_template_directory_uri() . '/css/page-builder.css', null, null);
		wp_enqueue_style('flexmarket-css', get_template_directory_uri() . '/css/flexmarket.css', null, '1.8.0');
		wp_enqueue_style('flexmarket-responsive-css', get_template_directory_uri() . '/css/flexmarket-responsive.css', null, '1.8.0');
		wp_enqueue_style('flexmarket-color-skin', get_template_directory_uri() . '/styles/color-black.css', null, '1.8.0');
	}
	add_action('wp_enqueue_scripts', 'mpt_register_style');

	// register JS
	function mpt_register_js(){
		wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'));
		wp_enqueue_script('filterablejs', get_template_directory_uri() . '/js/filterable.js', array('jquery'));
		wp_enqueue_script('prettyphotojs', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'));
		wp_enqueue_script('waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'));
		wp_enqueue_script('mpt-flexslider-js', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery') , '2.1');
		wp_enqueue_script('cssanimated-hover-js', get_template_directory_uri() . '/js/css-animated-hover.js', array('jquery'));
	}
	add_action('wp_enqueue_scripts', 'mpt_register_js');

	// register menu
	if(function_exists('register_nav_menus')){
		register_nav_menus(array(
		'mainmenu' => 'Main Menu'
				)
			);
	}

	// add sidebar
	if(function_exists('register_sidebar')){
			register_sidebar(array(
				'name' => 'Sidebar',
				'id' => 'sidebar',
				'description' => 'Widgets in this area will be shown on the right-hand side.',
				'before_widget' => '<div class="well well-small">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="page-header">',
				'after_title' => '</h4>'
			)
		);

			register_sidebar(array(
				'name' => 'Footer One',
				'id' => 'footer-one',
				'description' => 'First Footer Widget',
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '<h4 class="page-header"><span>',
				'after_title' => '</span></h4>'
			)
		);
			register_sidebar(array(
				'name' => 'Footer Two',
				'id' => 'footer-two',
				'description' => 'Second Footer Widget',
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '<h4 class="page-header"><span>',
				'after_title' => '</span></h4>'
			)
		);
			register_sidebar(array(
				'name' => 'Footer Three',
				'id' => 'footer-three',
				'description' => 'Three Footer Widget',
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '<h4 class="page-header"><span>',
				'after_title' => '</span></h4>'
			)
		);				
	}
	
	// add post type support to page and post
	add_action( 'init', 'add_extra_metabox' );
	function add_extra_metabox() {
		 add_post_type_support( 'page', 'excerpt' );
		 add_post_type_support( 'page', 'thumbnail' );
		 add_post_type_support( 'post', 'excerpt');
		 add_post_type_support( 'post', 'custom-fields');
		 add_post_type_support( 'post', 'comments');
	}

	// add comment function to Product Page
	if ( class_exists( 'MarketPress' ) ) {
		add_action( 'init', 'allow_comments_marketpress' );
		
		function allow_comments_marketpress() {
			add_post_type_support( 'product', 'comments' );
		}
	}
	
	// add thumbnail support to theme
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
	}

	// add additional image size
	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'tb-360', 360, 270 );
		add_image_size( 'tb-860', 860, 300 );
	}

	// set excerpt lenght to custom character length
	function the_excerpt_max_charlength($charlength) {
		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				echo mb_substr( $subex, 0, $excut );
			} else {
				echo $subex;
			}
			echo '[...]';
		} else {
			echo $excerpt;
		}
	}
		

 	// Initialize the metabox class.
	add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
	function cmb_initialize_cmb_meta_boxes() {

		if ( ! class_exists( 'cmb_Meta_Box' ) )
			require_once(get_template_directory() . '/functions/metabox/init.php');

	}

	// call for product listing functions
	add_action('flexmarket_product_listing_page' , 'flexmarket_list_products' , 10 , 2);
	add_action('flexmarket_category_page' , 'flexmarket_list_products' , 10 , 2);
	add_action('flexmarket_tag_page' , 'flexmarket_list_products' , 10 , 2);
	add_action('flexmarket_taxonomy_page' , 'flexmarket_list_products' , 10 , 2);

	function flexmarket_list_products( $unique_id = '' , $context = '' ) {

		$btnclass = mpt_load_mp_btn_color();
		$iconclass = mpt_load_whiteicon_in_btn();
		$tagcolor = mpt_load_icontag_color();
		$span = mpt_load_product_listing_layout();
		$counter = mpt_load_product_listing_counter();
		$entries = get_option('mpt_mp_listing_entries');
		$advancedsoft = mpt_enable_advanced_sort();
		$advancedsoftbtnposition = mpt_advanced_sort_btn_position();

		$args = array(
			'unique_id' => $unique_id,
			'sort' => $advancedsoft,
			'align' => $advancedsoftbtnposition,
			'context' => $context,
			'echo' => false,
			'paginate' => true,
			'per_page' => $entries,
			'counter' => $counter,
			'span' => $span,
			'btnclass' => $btnclass,
			'iconclass' => $iconclass,
			'tagcolor' => $tagcolor,
		);

		echo apply_filters( 'func_flexmarket_list_products' , flexmarket_advance_product_sort( $args ) , $args );		
	}
	
	
	
	
// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'df_disable_comments_post_types_support');

// Close comments on the front-end
function df_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function df_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');

// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'df_disable_comments_admin_bar');