<?php
/*
Plugin Name: MP Anywhere Cart
Plugin URI: http://www.marketpressthemes.com
Description: Display shopping cart in anywhere of your MarketPress site via wordpress shortcode.
Author: Nathan Onn (MarketPressThemes.com)
Version: 1.0.0
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

	if(!defined('MPAWC_PATH')) define( 'MPAWC_PATH', plugin_dir_path( __FILE__ ));
	if(!defined('MPAWC_DIR')) define( 'MPAWC_DIR', plugin_dir_url( __FILE__ ));

	if ( class_exists( 'MarketPress' ) ) {

		if( !class_exists('MPAWC') ) {

			class MPAWC {

			    private $plugin_path;
			    private $plugin_url;
			    private $plugin_slug;

			    function __construct() 
			    {
			        $this->plugin_path = MPAWC_PATH;
			        $this->plugin_url = MPAWC_DIR;
			        $this->plugin_slug = 'mpawc';
			        $this->plugin_option_group = 'mpaws_plugin';
			        $this->filter_hook_prefix = 'mpaws_func_';

			    	// register CSS & JS
			    	add_action('wp_enqueue_scripts', array(&$this, 'register_related_css_style') , 999 );
			    	add_action('wp_enqueue_scripts', array(&$this, 'register_related_js') , 999 );

			    	// Add Anywhere Cart shortcode
			    	add_shortcode( 'mpawc', array(&$this, 'anywhere_cart_sc') );

			    }


				 // register CSS
				function register_related_css_style() {
					wp_enqueue_style('prettyphoto-style', $this->plugin_url . 'css/prettyPhoto.css', null, null);
					wp_enqueue_style('css-animated-style', $this->plugin_url . 'css/animate.min.css', null, null);
					wp_enqueue_style('font-awesome-css', $this->plugin_url . 'css/font-awesome.min.css', null, '3.2.2');
					wp_enqueue_style('mpawc-css', $this->plugin_url . 'css/mpawc.css', null, '1.0.0');
				}

				// register JS
				function register_related_js() {
					wp_enqueue_script('prettyphotojs', $this->plugin_url . 'js/jquery.prettyPhoto.js', array('jquery'));
					wp_enqueue_script('cssanimated-hover-js', $this->plugin_url . 'js/css-animated-hover.js', array('jquery'));
				}

				// Anywhere Cart shortcode
				function anywhere_cart_sc( $atts ) {

					$instance = shortcode_atts( array(
						'design' => 'button',
						'cartstyle' => 'dropdown-click',
						'btncolor' => 'grey',
						'showcarttext' => 'no',
						'carttext' => __( 'View Cart' , $this->plugin_slug ),
						'showtotalitems' => 'yes',
						'showtotalamount' => 'yes',
						'onlystorepages' => 'no',
						'userclass' => '',
						'inlinestyle' => ''
					), $atts );

					extract( $instance );

					$cartstyle = (!empty($cartstyle) ? esc_attr($cartstyle) : '' );
					$showcarttext = (!empty($showcarttext) ? esc_attr($showcarttext) : '' );
					$carttext = (!empty($carttext) ? esc_attr($carttext) : '' );
					$showtotalitems = (!empty($showtotalitems) ? esc_attr($showtotalitems) : '' );
					$showtotalamount = (!empty($showtotalamount) ? esc_attr($showtotalamount) : '' );
					$btncolor = (!empty($btncolor) ? esc_attr($btncolor) : '' );
					$userclass = (!empty($userclass) ? esc_attr($userclass) : '' );
					$inlinestyle = (!empty($inlinestyle) ? esc_attr($inlinestyle) : '' );

					$anywhere_cart_output = '<div id="mp-anywhere-cart">';

						$args = array(
							'design' => $design,
							'cartstyle' => $cartstyle,
							'showcarttext' => $showcarttext,
							'carttext' => $carttext,
							'showtotalitems' => $showtotalitems,
							'showtotalamount' => $showtotalamount,
							'btncolor' => $btncolor,
							'userclass' => $userclass,
							'inlinestyle' => $inlinestyle
							);

						$anywhere_cart_output .= $this->load_btn_cart( $args );

					$anywhere_cart_output .= '</div>'; // End - mp-anywhere-cart

					$output = ( $onlystorepages == 'yes' ? ( mp_is_shop_page() ? $anywhere_cart_output : '' ) : $anywhere_cart_output );

					return apply_filters( $this->filter_hook_prefix . 'anywhere_cart_sc' , $output , $instance );		
				}

				function load_btn_cart( $args = array() ) {

					$defaults = array(
						'design' => 'button',
						'cartstyle' => 'dropdown-click',
						'showcarttext' => 'no',
						'carttext' => __( 'View Cart' , $this->plugin_slug ),
						'showtotalitems' => 'yes',
						'showtotalamount' => 'yes',
						'btncolor' => 'lightblue',
						'userclass' => '',
						'inlinestyle' => ''
					);

					$instance = wp_parse_args( $args, $defaults );
					extract( $instance );

					global $mp;

					switch ($btncolor) {
						case 'lightblue':
							$btncolor = ' mpawc-btn-lightblue';
							$actionscolor = ' mp_cart_actions_btn_lightblue';
							break;

						case 'blue':
							$btncolor = ' mpawc-btn-blue';
							$actionscolor = ' mp_cart_actions_btn_blue';
							break;

						case 'red':
							$btncolor = ' mpawc-btn-red';
							$actionscolor = ' mp_cart_actions_btn_red';
							break;

						case 'green':
							$btncolor = ' mpawc-btn-green';
							$actionscolor = ' mp_cart_actions_btn_green';
							break;

						case 'yellow':
							$btncolor = ' mpawc-btn-yellow';
							$actionscolor = ' mp_cart_actions_btn_yellow';
							break;

						case 'black':
							$btncolor = ' mpawc-btn-black';
							$actionscolor = ' mp_cart_actions_btn_black';
							break;

						case 'grey':
						default:
							$btncolor = '';
							$actionscolor = '';
							break;
					}

					switch ($design) {
						case 'flat':
							$btnclass = ' mpawc-btn-flat';
							break;

						case 'link':
							$btnclass = ' mpawc-btn-link';
							break;

						case 'box':
							$btnclass = ' mpawc-btn-box';
							break;
						
						case 'button':
						default:
							$btnclass = '';
							break;
					}

					$btnclass .= ' ' . esc_attr( $userclass );
					$inlinestyle = (!empty($inlinestyle) ? ' style="' . esc_attr($inlinestyle) . '"' : '' );

					$output = '<div class="mpawc-btn-cart'.( $cartstyle == 'dropdown-hover' || $cartstyle == 'dropdown-click' ? ' mpawc-dropdown-holder' : '' ).'">';

						// button
						$output .= ( $cartstyle == 'modal' ? '<a href="#mpawc-modal-cart" class="mpawc-btn mpawc-prettyphoto-link' . $btnclass . $btncolor . '"'.$inlinestyle.'>' : '<button class="mpawc-btn mpawc-dropdown-btn'.$btnclass.$btncolor.'"'.$inlinestyle.'>' );
							$output .= '<i class="icon-shopping-cart icon-large"></i> ';
							$output .= ( $showcarttext == 'text-before' && !empty($carttext) ? '<span class="mpawc-cart-text-before">'.esc_attr($carttext).'</span>' : '' );
							$output .= ( $showtotalamount == 'yes' ? '<span class="mpawc-total-cart-amount">'.$this->total_amount_in_cart().'</span>' : '' );
							$output .= ( $showtotalitems == 'yes' ? '<span class="mpawc-total-cart-items">'.mp_items_count_in_cart().'</span>' : '' );
							$output .= ( $showcarttext == 'text-after' && !empty($carttext) ? '<span class="mpawc-cart-text">'.esc_attr($carttext).'</span>' : '' );
						$output .= ( $cartstyle == 'modal' ? '</a>' : '</button>' );

						if ( $cartstyle == 'modal' ) 
							$output .= $this->load_cart_style_modal( array( 'actionscolor' => $actionscolor ) );
						else 
							$output .= $this->load_cart_style_dropdown( array( 'cartstyle' => $cartstyle , 'actionscolor' => $actionscolor ) );

					$output .= '</div>'; // end - mpawc-btn-cart

					// JS
					$output .= '
					<script type="text/javascript">
						jQuery(document).ready(function () {
						'.( $showtotalamount == 'yes' || $showtotalitems == 'yes' ? '
							jQuery(document).ajaxComplete(function(e, xhr, settings) {
							'. ( $showtotalamount == 'yes' ? '
						    	var mpCartTotalAmount = jQuery("#mp-anywhere-cart table.mp_cart_contents_widget td.mp_cart_col_total").html();
						    	jQuery("#mp-anywhere-cart .mpawc-btn span.mpawc-total-cart-amount").html(mpCartTotalAmount);
							' : '' ) . 
							( $showtotalitems == 'yes' ? '
								var mpCartTotalItems = 0;
								jQuery.each(jQuery("#mp-anywhere-cart table.mp_cart_contents_widget td.mp_cart_col_quant"),function(){
									var mpCartQty = jQuery(this).html() - 0;
									if(!isNaN(mpCartQty)){
										mpCartTotalItems += mpCartQty;
									}
								});
								jQuery("#mp-anywhere-cart .mpawc-btn span.mpawc-total-cart-items").html(mpCartTotalItems);
							' : '' ) . '
							});
						' : '' ) . ( $cartstyle == 'dropdown-hover' || $cartstyle == 'dropdown-click' ? '
					    	jQuery("#mp-anywhere-cart .mpawc-btn-cart button.mpawc-dropdown-btn").'.( $cartstyle == 'dropdown-hover' ? 'hover' : 'click' ).'(function() {
					    		 var mpawcCartDropdown = jQuery(this).next("div.mpawc-dropdown-cart");
					    		 jQuery(this).toggleClass("active");
					    		 mpawcCartDropdown.toggleClass("show-dropdown-cart animated fadeInDown");
					    	});
						' : '
					    	jQuery("a.mpawc-prettyphoto-link").prettyPhoto({
					    		social_tools: false,
					    		theme: "light_rounded",
					    		default_width: 360,
					    	});
						' ) . '
						});
					</script>';

					return apply_filters( $this->filter_hook_prefix . 'load_btn_cart' , $output , $instance );
				}

				function load_cart_style_dropdown( $args = array() ) {

					$defaults = array(
						'cartstyle' => 'dropdown-click',
						'actionscolor' => ''
					);

					$instance = wp_parse_args( $args, $defaults );
					extract( $instance );

					$output = '<div class="mpawc-dropdown-cart'.( $cartstyle == 'dropdown-hover' ? ' mpawc-dropdown-cart-hover' : '' ).' mpawc-table">';
						$output .= '<div class="mp_cart_widget_content'.$actionscolor.'">';
							$output .= mp_show_cart( 'widget' , NULL , false );
						$output .= '</div>'; // end - mp_cart_widget_content
					$output .= '</div>'; // end - dropdown cart

					return apply_filters( $this->filter_hook_prefix . 'load_cart_style_dropdown' , $output , $instance );
				}

				function load_cart_style_modal( $args = array() ) {

					$defaults = array(
						'actionscolor' => ''
					);

					$instance = wp_parse_args( $args, $defaults );
					extract( $instance );

					$output = '<div id="mpawc-modal-cart" class="mpawc-modal-cart-hide">';
						$output .= '<div id="mp-anywhere-cart">';
							$output .= '<div class="mpawc-modal-cart mpawc-table">';
								$output .= '<div class="mpawc-modal-cart-title">'.__( 'Shopping Cart' , $this->plugin_slug ).'</div>';
								$output .= '<div class="mp_cart_widget_content'.$actionscolor.'">';
									$output .= mp_show_cart( 'widget' , NULL , false );
								$output .= '</div>'; // end - mp_cart_widget_content
							$output .= '</div>'; // end - mpawc-table
						$output .= '</div>'; // end - mp-anywhere-cart
					$output .= '</div>'; // end - mpawc-modal-cart

					return apply_filters( $this->filter_hook_prefix . 'load_cart_style_modal' , $output , $instance );
				}

				function total_amount_in_cart() {

				  	global $mp, $blog_id;
				  	$blog_id = (is_multisite()) ? $blog_id : 1;
				  	$current_blog_id = $blog_id;

					$global_cart = $mp->get_cart_contents(true);

				  	if (!$mp->global_cart)  //get subset if needed
				  		$selected_cart[$blog_id] = $global_cart[$blog_id];
				  	else
				    	$selected_cart = $global_cart;

				    $totals = array();

				    if (!empty($selected_cart) && is_array($selected_cart)) {
					    foreach ($selected_cart as $bid => $cart) {

						if (is_multisite())
					        switch_to_blog($bid);

					    if (!empty($cart) && is_array($cart)){
						   	foreach ($cart as $product_id => $variations) {
						        foreach ($variations as $variation => $data) {
						          $totals[] = $data['price'] * $data['quantity'];
						        }
						      }
						    }
					    }
				    } 
				    
					if (is_multisite())
				      switch_to_blog($current_blog_id);

				    $total = array_sum($totals);

					return apply_filters( $this->filter_hook_prefix . 'total_amount_in_cart' , $mp->format_currency( '' , $total ) );
				}


			} // end class MPSWC

			global $mpawc;

			$mpawc = new MPAWC();

		} // end if !class_exists('MPAWC')

	} // end if class_exists('MarketPress')
