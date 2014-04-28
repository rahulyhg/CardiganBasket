<?php
/*
Plugin Name: MP Checkout Recommendation
Plugin URI: http://www.marketpressthemes.com
Description: MarketPress Checkout Recommendation - Offers checkout recommendation for your customers, just like amazon.com and Etsy.com does it!
Author: Nathan Onn (MarketPressThemes.com)
Version: 1.0.1
Author URI: http://www.marketpressthemes.com

Copyright 2012 - 2013 Smashing Advantage Enterprise.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

	if(!defined('MPCR_PATH')) define( 'MPCR_PATH', plugin_dir_path( __FILE__ ));
	if(!defined('MPCR_DIR')) define( 'MPCR_DIR', plugin_dir_url( __FILE__ ));

	if ( class_exists( 'MarketPress' ) ) {

		if( !class_exists('MPCR') ) {

			class MPCR {

			    private $plugin_path;
			    private $plugin_url;
			    private $plugin_slug;

			    function __construct() 
			    {
			        $this->plugin_path = MPCR_PATH;
			        $this->plugin_url = MPCR_DIR;
			        $this->plugin_slug = 'mpcr';
			        $this->plugin_option_group = 'mpcr_plugin';

			        // Include and create a new MPCRSettingsFramework
			        add_action( 'admin_menu', array(&$this, 'admin_menu'), 99 );
			        require_once( MPCR_PATH .'settings.php' );
			        $this->mpcrsettings = new MPCRSettingsFramework( MPCR_PATH .'inc/mpcr-settings.php' , 'mpcr' );
			        add_filter( $this->mpcrsettings->get_option_group() .'_settings_validate', array(&$this, 'validate_settings') );			    	

			    	// Initialize the metabox class
			    	add_action( 'init', array(&$this, 'initialize_cmb_meta_boxes' ), 100 );
					if ( ! class_exists( 'cmb_Meta_Box' ) ) 
						add_filter( 'cmb_meta_boxes', array(&$this, 'load_metaboxes') );;

					$pluginsettings = get_option( 'mpcr_settings' );

					if ( $pluginsettings['mpcr_general_settings_enable_checkout_recommendation'] == 'yes' ) {

				    	// register CSS & JS
				    	add_action('wp_enqueue_scripts', array(&$this, 'register_related_css_style') , 9999 );
				    	add_action('wp_enqueue_scripts', array(&$this, 'register_related_js') );

				    	global $mp;

				    	// Display Checkout Recommendation in checkout page
				    	if (!$mp->global_cart)
				    		add_filter('mp_checkout_error_checkout', array(&$this, 'display_checkout_recommendation') , 9 );
				    	else
				    		add_filter('mp_checkout_error_checkout', array(&$this, 'display_checkout_recommendation_global_cart') , 9 );

					}

			    }

			    function admin_menu()
			    {
			        add_submenu_page( 'edit.php?post_type=product', __( 'Checkout Recommendation', 'mpcr' ), __( 'Checkout Recommendation', 'mpcr' ), 'manage_options', 'mpt-checkout-recommendation-plugin', array(&$this, 'settings_page') );
			    }
			    
			    function settings_page()
				{
				    // Your settings page
				    ?>
					<div class="wrap">
						<div id="icon-options-general" class="icon32"></div>
						<h2>MarketPress Checkout Recommendation</h2>
						<?php 
						// Output your settings form
						$this->mpcrsettings->settings(); 
						?>
					</div>
					<?php
				}
				
				function validate_settings( $input )
				{
			    	return $input;
				}

				function register_related_css_style() {
					wp_enqueue_style('css-animated-style', MPCR_DIR . 'css/animate.min.css', null, null);
					wp_enqueue_style('checkout-recommendation-css', MPCR_DIR . 'css/mpcr.css', null, null);
					wp_enqueue_style('checkout-recommendation-responsive-css', MPCR_DIR . 'css/mpcr-responsive.css', null, null);

					$pluginsettings = get_option( 'mpcr_settings' );
					switch ( $pluginsettings['mpcr_general_settings_cr_color_skin'] ) {
						case 'blue':
							$cssfile = 'css/mpcr-blue.css';
							break;

						case 'lightblue':
							$cssfile = 'css/mpcr-lightblue.css';
							break;

						case 'green':
							$cssfile = 'css/mpcr-green.css';
							break;

						case 'red':
							$cssfile = 'css/mpcr-red.css';
							break;

						case 'yellow':
							$cssfile = 'css/mpcr-yellow.css';
							break;

						case 'black':
							$cssfile = 'css/mpcr-black.css';
							break;

						case 'grey':
							$cssfile = 'css/mpcr-grey.css';
							break;

						default:
							$cssfile = 'css/mpcr-grey.css';
							break;
					}

					wp_enqueue_style('checkout-recommendation-styling-css', MPCR_DIR . $cssfile , null, null);
				}

				function register_related_js() {
					wp_enqueue_script('mpcr-js', MPCR_DIR . 'js/mpcr.js', array('jquery'));
				}

				function initialize_cmb_meta_boxes() {

					if ( ! class_exists( 'cmb_Meta_Box' ) ) {
						require_once($this->plugin_path . 'inc/metaboxes/init.php');
					}
						
				}

				function load_metaboxes( array $meta_boxes ) {

					$prefix = '_mpcr_';

					$productlisting = array( array( 'name' => 'Select a Product', 'value' => '' ) );
					$products = get_posts( array('post_type' => 'product' , 'orderby' => 'title', 'order' => 'ASC' , 'numberposts' => -1) );

					if (!empty($products) && is_array($products)) {
						foreach ($products as $product) {
							$productlisting[] = array( 
								'name' => $product->post_title, 
								'value' => $product->ID
								);
						}
					}

					$meta_boxes[] = array(
						'id'         => 'checkout_recommendation_metabox',
						'title'      => 'Checkout Recommendation',
						'pages'      => array('product'), // Post type
						'context'    => 'normal',
						'priority'   => 'core',
						'show_names' => true, // Show field names on the left
						'fields'     => array(
							array(
								'name'    => 'First Recommended Product',
								'desc'    => '',
								'id'      => $prefix . 'cr_product_1',
								'type'    => 'select',
								'options' => $productlisting,
							),
							array(
								'name'    => 'Second Recommended Product',
								'desc'    => '',
								'id'      => $prefix . 'cr_product_2',
								'type'    => 'select',
								'options' => $productlisting,
							),
							array(
								'name'    => 'Third Recommended Product',
								'desc'    => '',
								'id'      => $prefix . 'cr_product_3',
								'type'    => 'select',
								'options' => $productlisting,
							),
							array(
								'name'    => 'Fourth Recommended Product',
								'desc'    => '',
								'id'      => $prefix . 'cr_product_4',
								'type'    => 'select',
								'options' => $productlisting,
							),
						),
					);

					return $meta_boxes;

				}

			  	function display_checkout_recommendation( $contents = NULL ) {

			  		global $wp_query;
				    $checkoutstep = get_query_var( 'checkoutstep' );
				    $pluginsettings = get_option( 'mpcr_settings' );
				    $recommend_items = $this->get_recommendation_items();

				    $query_args = array(
				    	'post_type' => 'product',
				    	'post_status' => 'publish',
				    	'showposts' => apply_filters( 'mpcr_query_args_showposts' , 9999 ),
				    	'post__in' => apply_filters( 'mpcr_query_args_post_in' , $recommend_items )
				    );

				    $query_args = apply_filters( 'mpcr_query_args_extra' , $query_args , $recommend_items );

					//The Query
					$the_query = new WP_Query( $query_args );

					$counter = 1;
					$count = 1;
					$max_items_per_row = apply_filters( 'mpcr_query_args_counter' , $this->get_counter_num() );

				    if ( ( $checkoutstep == 'checkout-edit' || empty($checkoutstep) ) && $wp_query->query_vars['pagename'] == 'cart' && mp_items_in_cart() && $the_query->have_posts() ) {			    	
				    	$output = '<div id="mp-checkout-recommendation">';

				    		$output .= '<h3 class="container-title">' . esc_attr( $pluginsettings['mpcr_general_settings_cr_title'] ) . '</h3>';

				    		$output .= '<div class="mpcr-row-container">';

				    			$output .= '<div class="mpcr-row-fluid activated">';

								while ( $the_query->have_posts() ) : $the_query->the_post();

									if ( $counter == $max_items_per_row ) {
										$counter = 1;
										$output .= '</div>'; // End - mpcr-row-fluid
										$output .= '<div class="mpcr-row-fluid">';
									}

									$post_id = get_the_ID();

								  	$single_args = array(
								  		'post_id' => $post_id,
										'imagesize' => apply_filters( 'mpcr_product_box_args_imagesize' , 'thumbnail' ),
										'span' => apply_filters( 'mpcr_product_box_args_span' , 'mpcr-span-box' . $this->get_items_per_row() ),
										'class' => apply_filters( 'mpcr_product_box_args_boxclass' , '' ),
										'style' => apply_filters( 'mpcr_product_box_args_boxstyle' , '' )
									);

									if ( $this->item_not_in_cart($post_id) ) {
										$output .= $this->load_single_product_box( $single_args );
										$counter++;
										$count++;
									}
										
								endwhile;
								
					    		$output .= '</div>'; // End - mpcr-row-fluid

					    		$output .= '<button class="mpcr-btn mpcr-previous-btn"' . ( $count > $max_items_per_row ? '' : ' disabled' ) . '>&laquo;</button>';
				    			$output .= '<button class="mpcr-btn mpcr-next-btn"' . ( $count > $max_items_per_row ? '' : ' disabled' ) . '>&raquo;</button>';

					    	$output .= '</div>'; // End - mpcr-container

				    	$output .= '</div>'; // End - mp-checkout-recommendation

				    	$output .= '<div class="clear padding20"></div>';
				    	
				    } else {

				    	$output = '';

				    }

				    wp_reset_query();

				    return $output;			  		
			  	}

			  	function display_checkout_recommendation_global_cart( $contents = NULL ) {

			  		global $wp_query, $mp, $blog_id;
			  		$checkoutstep = get_query_var( 'checkoutstep' );
			  		$pluginsettings = get_option( 'mpcr_settings' );

					$blog_id = (is_multisite()) ? $blog_id : 1;
					$current_blog_id = $blog_id;

					$items = array();

					$global_cart = $mp->get_cart_contents(true);
					
					if (!$mp->global_cart)
					  	$selected_cart[$blog_id] = $global_cart[$blog_id];
					else
					    $selected_cart = $global_cart;

					$counter = 1;
					$count = apply_filters( 'mpcr_query_args_counter' , $this->get_counter_num() );

				    if ( ( $checkoutstep == 'checkout-edit' || empty($checkoutstep) ) && $wp_query->query_vars['pagename'] == 'cart' && mp_items_in_cart() ) {			    	
				    	$output = '<div id="mp-checkout-recommendation">';

				    		$output .= '<h3 class="container-title">' . esc_attr( $pluginsettings['mpcr_general_settings_cr_title'] ) . '</h3>';

				    		$output .= '<div class="mpcr-row-container">';

				    			$output .= '<div class="mpcr-row-fluid activated">';

								if (is_array($selected_cart) && count($selected_cart)) {

								    foreach ( $selected_cart as $bid => $cart ) {

										if (is_multisite())
							        		switch_to_blog($bid);

							        	foreach ($cart as $product_id => $variations) {
											
											for ($i=1; $i < 5 ; $i++) {

												if ( $counter == $count ) {
													$counter = 1;
													$output .= '</div>'; // End - mpcr-row-fluid
													$output .= '<div class="mpcr-row-fluid">';
												}
												
												$item_id = esc_attr(get_post_meta( $product_id, '_mpcr_cr_product_'.$i, true ));

												if ( !empty($item_id) ) {
													$in_array = in_array( array( $item_id , $bid ) , $items ) ? false : true;
													if ( $in_array && $this->item_not_in_cart($item_id) ) {
													  	$single_args = array(
													  		'post_id' => $item_id,
															'imagesize' => apply_filters( 'mpcr_product_box_args_imagesize' , 'thumbnail' ),
															'span' => apply_filters( 'mpcr_product_box_args_span' , 'mpcr-span-box' . $this->get_items_per_row() ),
															'class' => apply_filters( 'mpcr_product_box_args_boxclass' , '' ),
															'style' => apply_filters( 'mpcr_product_box_args_boxstyle' , '' )
														);

														$output .= $this->load_single_product_box( $single_args );
														$counter++;
														$items[] = array( $item_id , $bid);
													}
												}
											}
							        	}

								    }

								    //go back to original blog
								    if (is_multisite())
								      	switch_to_blog($current_blog_id);
								    
								}
							
					    		$output .= '</div>'; // End - mpcr-row-fluid

					    		$output .= '<button class="mpcr-btn mpcr-previous-btn">&laquo;</button>';
				    			$output .= '<button class="mpcr-btn mpcr-next-btn">&raquo;</button>';

					    	$output .= '</div>'; // End - mpcr-container

				    	$output .= '</div>'; // End - mp-checkout-recommendation

				    	$output .= '<div class="clear padding20"></div>';
				    	
				    } else {

				    	$output = '';

				    }


			  		return $output;
			  	}

			  	function load_single_product_box( $args = array() ) {

				  	$defaults = array(
				  		'post_id' => '',
						'imagesize' => 'thumbnail',
						'span' => 'mpcr-span-box span-6x',
						'class' => '',
						'style' => ''
					);

				  	$instance = wp_parse_args( $args, $defaults );
				  	extract( $instance );

			  		global $id;
			  		$post_id = ( NULL === $post_id ) ? $id : $post_id;

					$style = ( !empty($style) ? ' style="'.esc_attr($style).'"' : '' );
					$class = ( !empty($class) ? ' '.esc_attr($class) : '' );

					if (is_multisite()) {
						$blog_id = get_current_blog_id();
					} else {
						$blog_id = 1;
					}

					$output = '<div class="'.$span.' mpcr-product-box">';


						if (has_post_thumbnail( $post_id ) ) {
							$image = '<div class="single-box-image-section">';
								$image .= '<a href="'.get_permalink($post_id).'" class="single-box-image-link">' . get_the_post_thumbnail( $post_id , $imagesize , array( 'class' => 'single-box-image' ) ) . '</a>';
					    		$image .= '<div class="single-box-price-label">';
					    			$image .= mp_product_price( false , $post_id , false );
					    		$image .= '</div>';
							$image .= '</div>'; // End - single-box-image-section
							$image .= '<div class="clear"></div>';
							$output .= apply_filters( 'mpcr_single_box_image' , $image , $instance );
						}

						$output .= '<div class="single-box-title-section">';
							$output .= '<a href="'.get_permalink($post_id).'" class="single-box-title">'. wp_trim_words( get_the_title($post_id) , 5 ) . '</a>';
						$output .= '</div>'; // End - single-box-title-section
						$output .= '<div class="clear"></div>';
			    		$output .= $this->mpcr_buy_button( $post_id );

				    $output .= '</div>'; // End - span	

				    return $output;
			  	}

			  	function mpcr_buy_button( $post_id = NULL ) {

				  	global $id, $mp;
				  	$post_id = ( NULL === $post_id ) ? $id : $post_id;

				  	$meta = get_post_custom($post_id);
				  	//unserialize
				  	foreach ($meta as $key => $val) {
					  	$meta[$key] = maybe_unserialize($val[0]);
					  	if (!is_array($meta[$key]) && $key != "mp_is_sale" && $key != "mp_track_inventory" && $key != "mp_product_link" && $key != "mp_file")
					    	$meta[$key] = array($meta[$key]);
					}

				  	//check stock
				  	$no_inventory = array();
				  	$all_out = false;
				  	if ($meta['mp_track_inventory']) {
				    	$cart = $mp->get_cart_contents();
				    	if (isset($cart[$post_id]) && is_array($cart[$post_id])) {
						    foreach ($cart[$post_id] as $variation => $data) {
						      if ($meta['mp_inventory'][$variation] <= $data['quantity'])
						        $no_inventory[] = $variation;
								}
								foreach ($meta['mp_inventory'] as $key => $stock) {
						      if (!in_array($key, $no_inventory) && $stock <= 0)
						        $no_inventory[] = $key;
								}
							}

						//find out of stock items that aren't in the cart
						foreach ($meta['mp_inventory'] as $key => $stock) {
				      		if (!in_array($key, $no_inventory) && $stock <= 0)
				        		$no_inventory[] = $key;
						}

						if (count($no_inventory) >= count($meta["mp_price"]))
						  	$all_out = true;
				  	}

				  	//display an external link or form button
				  	if (isset($meta['mp_product_link']) && $product_link = $meta['mp_product_link']) {

				    	$button = '<a class="mp_link_buynow mpcr-btn" href="' . esc_url($product_link) . '">' . __('Buy Now &raquo;', 'mpcr') . '</a>';

				  	} else if ($mp->get_setting('disable_cart')) {

				    	$button = '';

				  	} else {

					    $variation = mp_has_variations($post_id) ? true : false;
					    $button = '<form class="mpcr_buy_form" method="post" action="' . mp_cart_link(false, true) . '">';

					    if ($all_out) {

					      $button .= '<span class="mp_no_stock">' . __('Out of Stock', 'mpcr') . '</span>';

					    } else {

						    $button .= '<input type="hidden" name="product_id" value="' . $post_id . '" />';

					      	if ($variation) {

				        		$button .= '<a class="mp_link_buynow mpcr-btn" href="' . get_permalink($post_id) . '">' . __('Choose Option &raquo;', 'mpcr') . '</a>';

					      	} else if ($mp->get_setting('list_button_type') == 'addcart') {

					        	$button .= '<button class="mpcr-btn" type="submit" name="addcart">' . __('Add To Cart &raquo;', 'mpcr') . '</button>';

					      	} else if ($mp->get_setting('list_button_type') == 'buynow') {

					        	$button .= '<button class="mpcr-btn" type="submit" name="buynow>' . __('Buy Now &raquo;', 'mpcr') . '</button>';

					      	}
						    
					    }

				    	$button .= '</form>';
				  	}

				  	return $button;
			  	}

			  	function item_not_in_cart( $post_id = NULL ) {

				  	global $id, $mp, $blog_id;
				  	$post_id = ( NULL === $post_id ) ? $id : $post_id;
				  	$item_not_in_cart = true;

					$blog_id = (is_multisite()) ? $blog_id : 1;

					$global_cart = $mp->get_cart_contents(true);
					
					if (!$mp->global_cart)
					  	$selected_cart[$blog_id] = $global_cart[$blog_id];
					else
					    $selected_cart = $global_cart;

					if (is_array($selected_cart) && count($selected_cart)) {

					    foreach ($selected_cart as $cart) {

					    	if ( array_key_exists( $post_id , $cart) )
					    		$item_not_in_cart = false;
					    }
					    
					}

					return $item_not_in_cart;
			  	}

			  	function get_recommendation_items() {

				  	global $mp, $blog_id;
				  	$items = array();

					$blog_id = (is_multisite()) ? $blog_id : 1;
					$current_blog_id = $blog_id;

					$global_cart = $mp->get_cart_contents(true);
					
					if (!$mp->global_cart)
					  	$selected_cart[$blog_id] = $global_cart[$blog_id];
					else
					    $selected_cart = $global_cart;

					if (is_array($selected_cart) && count($selected_cart)) {

					    foreach ( $selected_cart as $bid => $cart ) {

							if (is_multisite())
				        		switch_to_blog($bid);

				        	foreach ($cart as $product_id => $variations) {
								for ($i=1; $i < 5 ; $i++) { 
									$items[] = esc_attr(get_post_meta( $product_id, '_mpcr_cr_product_'.$i, true ));
								}
				        	}

					    }

					    //go back to original blog
					    if (is_multisite())
					      	switch_to_blog($current_blog_id);
					    
					}

					return $items;
			  	}

			  	function get_items_per_row() {

			  		$pluginsettings = get_option( 'mpcr_settings' );
			  		$span = ' span-4x';

			  		switch ($pluginsettings['mpcr_general_settings_cr_items_per_row']) {
			  			case 'span-2x':
			  				$span = ' span-2x';
			  				break;
			  			case 'span-3x':
			  				$span = ' span-3x';
			  				break;
			  			case 'span-5x':
			  				$span = ' span-5x';
			  				break;
			  			case 'span-6x':
			  				$span = ' span-6x';
			  				break;
			  			case 'span-4x':
			  			default:
			  				$span = ' span-4x';
			  				break;
			  		}

			  		return $span;
			  	}

			  	function get_counter_num() {

			  		$pluginsettings = get_option( 'mpcr_settings' );
			  		$counter = 5;

			  		switch ($pluginsettings['mpcr_general_settings_cr_items_per_row']) {
			  			case 'span-2x':
			  				$counter = 3;
			  				break;
			  			case 'span-3x':
			  				$counter = 4;
			  				break;
			  			case 'span-5x':
			  				$counter = 6;
			  				break;
			  			case 'span-6x':
			  				$counter = 7;
			  				break;
			  			case 'span-4x':
			  			default:
			  				$counter = 5;
			  				break;
			  		}

			  		return $counter;

			  	}

			}

			global $mpcr;
			$mpcr = new MPCR();
		}

	}