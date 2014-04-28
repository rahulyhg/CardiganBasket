<?php
/*
Plugin Name: MP Floating Cart
Plugin URI: http://www.marketpressthemes.com
Description: A shopping cart that hovers or "floats" above your MarketPress site.
Author: Nathan Onn (MarketPressThemes.com)
Version: 1.1.0
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

	if(!defined('MPFC_PATH')) define( 'MPFC_PATH', plugin_dir_path( __FILE__ ));
	if(!defined('MPFC_DIR')) define( 'MPFC_DIR', plugin_dir_url( __FILE__ ));

	if ( class_exists( 'MarketPress' ) ) {

		if( !class_exists('MPFloatingCart') ) {


			class MPFloatingCart {

			    private $plugin_path;
			    private $plugin_url;
			    private $l10n;
			    private $floatcart;

			    function __construct() 
			    {	
			        $this->plugin_path = MPFC_PATH;
			        $this->plugin_url = MPFC_DIR;
			        $this->l10n = 'floating-cart';
			        $this->filter_hook_prefix = 'mpfc_func_';

			        add_action( 'admin_menu', array(&$this, 'admin_menu'), 99 );
			        
			        // Include and create a new FloatCartSettingsFramework
			        require_once( $this->plugin_path .'settings.php' );
			        $this->floatcart = new FloatCartSettingsFramework( $this->plugin_path .'inc/fc-settings.php' );
			        // Add an optional settings validation filter (recommended)
			        add_filter( $this->floatcart->get_option_group() .'_settings_validate', array(&$this, 'fc_validate_settings') );

			        // register related CSS & JS
					add_action('wp_enqueue_scripts', array(&$this, 'register_related_css_style') , 9999 );
					add_action('wp_enqueue_scripts', array(&$this, 'register_related_js') , 9999 );

					// add action to wp_footer
					add_action('wp_footer' , array(&$this, 'mp_floating_shopping_cart') );

			    }
			    
			    function admin_menu()
			    {
			    	add_submenu_page( 'edit.php?post_type=product', __( 'Floating Cart', $this->l10n ), __( 'Floating Cart', $this->l10n ), 'manage_options', 'mpt-floating-cart', array(&$this, 'settings_page') );
			    }
			    
			    function settings_page()
				{
				    // Your settings page
				    ?>
					<div class="wrap">
						<div id="icon-options-general" class="icon32"></div>
						<h2>Floating Cart</h2>
						<?php 
						// Output your settings form
						$this->floatcart->settings(); 
						?>
					</div>
					<?php
				}
				
				function fc_validate_settings( $input )
				{
				    // Do your settings validation here
				    // Same as $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting
			    	return apply_filters( $this->filter_hook_prefix . 'fc_validate_settings' , $input );
				}

				// register CSS 
				function register_related_css_style() {
					wp_enqueue_style('css-animated-style', $this->plugin_url . 'css/animate.min.css', null, null);
					wp_enqueue_style('font-awesome-css', $this->plugin_url . 'css/font-awesome.min.css', null, '3.2.2');
					wp_enqueue_style('magnific-popup', $this->plugin_url . 'css/magnific-popup.css', null, null);
					wp_enqueue_style('floating-cart-css', $this->plugin_url . 'css/mpfc.css', null, null);
					wp_enqueue_style('floating-cart-css-responsive', $this->plugin_url . 'css/mpfc-responsive.css', null, null);
				}

				// register JS
				function register_related_js() {
					wp_enqueue_script('cssanimated-hover-js', $this->plugin_url . 'js/css-animated-hover.js', array('jquery'));
					wp_enqueue_script('magnific-popup', $this->plugin_url . 'js/jquery.magnific-popup.min.js', array('jquery'));
				}

				function mp_floating_shopping_cart() {

					$settings = wpsf_get_settings( $this->plugin_path .'inc/fc-settings.php' );

					$enablefc = esc_attr($settings['fcsettings_general_enable_floating_cart']);

					$btnposition = esc_attr($settings['fcsettings_general_button_position']);
					$showcartitem = esc_attr($settings['fcsettings_general_show_cart_total_item']);
					$showcartamount = esc_attr($settings['fcsettings_general_show_cart_total_amount']);

					switch ( $btnposition ) {
						case 'top-left':
							$btnposition = ' mpfc-top-left';
							break;

						case 'top-right':
						default:
							$btnposition = ' mpfc-top-right';
							break;

						case 'middle-left':
							$btnposition = ' mpfc-middle-left';
							break;

						case 'middle-right':
							$btnposition = ' mpfc-middle-right';
							break;

						case 'bottom-left':
							$btnposition = ' mpfc-bottom-left';
							break;

						case 'bottom-right':
							$btnposition = ' mpfc-bottom-right';
							break;
					}

					switch ($settings['fcsettings_general_button_color_predefined']) {
						case 'grey':
						default:
							$btnclass = '';
							break;
						case 'blue':
							$btnclass = ' mpfc-btn-primary';
							break;
						case 'lightblue':
							$btnclass = ' mpfc-btn-info';
							break;
						case 'green':
							$btnclass = ' mpfc-btn-success';
							break;
						case 'yellow':
							$btnclass = ' mpfc-btn-warning';
							break;
						case 'red':
							$btnclass = ' mpfc-btn-danger';
							break;
						case 'black':
							$btnclass = ' mpfc-btn-inverse';
							break;
					}

					$instance = array(
						'settings' => $settings,
						'enablefc' => $enablefc,
						'btnposition' => $btnposition,
						'showcartitem' => $showcartitem,
						'showcartamount' => $showcartamount,
						'btnclass' => $btnclass
					);

					$output = '';

					if ( $enablefc == 'yes') {

						// floating cart button
						$output .= '<div class="floating-cart add-fadeinright-effects-parent'. ( $settings['fcsettings_general_fc_mobile_view'] == 'no' ? '' : ' hidden-phone' ) .'">';
							$output .= '<a class="mpfc-btn' . $btnclass . $btnposition . ' add-fadeinright-effects-child popup-with-zoom-anim" href="#cart-section">';
								$output .= '<i class="icon-shopping-cart icon-large"></i>';
								$output .= $this->floating_cart_contents_in_button( $settings );
							$output .= '</a>';
						$output .= '</div>'; // end floating-cart

						// cart modal
						$output .= '<div id="cart-section" class="mp-floating-cart-modal zoom-anim-dialog mfp-hide">';
								$output .= '<h3 class="mpfc-modal-heading-text">' . __( 'Shopping Cart', 'floating-cart' ) . '</h3>';
								$output .= '<div class="mp_cart_widget_content">';
									$output .= mp_show_cart( 'widget' , null , false );
								$output .= '</div>'; // end - mp_cart_widget_content
						$output .= '</div>';// #cart-section

						$output .= ( $showcartamount == 'yes' || $showcartitem == 'yes' ? '
							<script type="text/javascript">
								jQuery(document).ready(function () {

									jQuery(".popup-with-zoom-anim").magnificPopup({
									          type: "inline",
									          fixedContentPos: false,
									          fixedBgPos: true,
									          overflowY: "auto",
									          closeBtnInside: true,
									          preloader: false, 
									          midClick: true,
									          removalDelay: 300,
									          mainClass: "mpfc-mfp-zoom-in"
									        });

									jQuery(document).ajaxComplete(function(e, xhr, settings) {

										'. ( $showcartamount == 'yes' ? '
									    	var FCartTotalAmount = jQuery(".mp-floating-cart-modal table.mp_cart_contents_widget td.mp_cart_col_total").html();
									    	jQuery(".floating-cart span.cart-total-amount").html(FCartTotalAmount);
										' : '' ) . 

										( $showcartitem == 'yes' ? '
											var FCartTotalItems = 0;
											jQuery.each(jQuery(".mp-floating-cart-modal table.mp_cart_contents_widget td.mp_cart_col_quant"),function(){
												var FCartQty = jQuery(this).html() - 0;
												if(!isNaN(FCartQty)){
													FCartTotalItems += FCartQty;
												}
											});
											jQuery(".floating-cart span.cart-total-items").html(FCartTotalItems);
										' : '' ) . '

									});
								});
							</script>' : '' );

						if ( $settings['fcsettings_general_fc_only_in_store'] == 'yes' ) 
							$output = ( mp_is_shop_page() ? $output : '' );

					}

					echo apply_filters( $this->filter_hook_prefix . 'mp_floating_shopping_cart' , $output , $instance );
				}

				function floating_cart_contents_in_button( $settings = '' ){

					$showbtntext = esc_attr($settings['fcsettings_general_show_button_text']);
					$buttontext = esc_attr($settings['fcsettings_general_button_text']);
					$showcartitem = esc_attr($settings['fcsettings_general_show_cart_total_item']);
					$showcartamount = esc_attr($settings['fcsettings_general_show_cart_total_amount']);

					$instance = array(
						'showbtntext' => $showbtntext,
						'buttontext' => $buttontext,
						'showcartitem' => $showcartitem,
						'showcartamount' => $showcartamount
					);

					$output = '';

					if ( $showcartitem == 'yes' )
						$output .= '<span class="cart-total-items">'.mp_items_count_in_cart().'</span><span class="cart-total-items-text">'.__( ' item(s)' , 'floating-cart' ) . '</span>';

					if ( $showcartitem == 'yes' && $showcartamount ==  'yes'  )
						$output .= '<span class="cart-separator"> - </span>';

					if ( $showcartamount ==  'yes' )
						$output .= '<span class="cart-total-amount">'.$this->floating_cart_total_amount_in_cart().'</span>';
					
					if ( $showbtntext == 'yes' )
						$output .= '<span class="view-cart">'.__( $buttontext, 'floating-cart' ).'</span>';

					return apply_filters( $this->filter_hook_prefix . 'floating_cart_contents_in_button' , $output , $instance );
				}

				function floating_cart_total_amount_in_cart() {

				  	global $mp, $blog_id;
				  	$blog_id = (is_multisite()) ? $blog_id : 1;
				  	$current_blog_id = $blog_id;

					$global_cart = $mp->get_cart_contents(true);
				  	if (!$mp->global_cart)  //get subset if needed
				  		$selected_cart[$blog_id] = $global_cart[$blog_id];
				  	else
				    	$selected_cart = $global_cart;

				    $totals = array();

				    if ( !empty($selected_cart)) {

					    foreach ($selected_cart as $bid => $cart) {

							if (is_multisite())
						        switch_to_blog($bid);

						    if (!empty($cart)) {
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

					return apply_filters( $this->filter_hook_prefix . 'floating_cart_total_amount_in_cart' , $mp->format_currency('', $total) );
				}

			}

			global $mpfc;
			$mpfc = new MPFloatingCart();


		} // end if !class_exists('MPFloatingCart')

	} // end if class_exists('MarketPress')