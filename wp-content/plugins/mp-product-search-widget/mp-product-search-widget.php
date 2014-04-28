<?php
/*
Plugin Name: MP Product Search Widget
Plugin URI: http://www.marketpressthemes.com
Description: MarketPress Product Search Widget - Making It Easier For Your Customers To Find The Product They Want!
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

	if(!defined('MPPSW_PATH')) define( 'MPPSW_PATH', plugin_dir_path( __FILE__ ));
	if(!defined('MPPSW_DIR')) define( 'MPPSW_DIR', plugin_dir_url( __FILE__ ));

	if ( class_exists( 'MarketPress' ) ) {

		if( !class_exists('MPPSW') ) {

			class MPPSW {

			    private $plugin_path;
			    private $plugin_url;
			    private $plugin_slug;

			    function __construct() 
			    {
			        $this->plugin_path = MPPSW_PATH;
			        $this->plugin_url = MPPSW_DIR;
			        $this->plugin_slug = 'mppsw';
			        $this->plugin_option_group = 'mppsw_plugin';
			        $this->filter_hook_prefix = 'mppsw_func_';

			    	// register CSS & JS
			    	add_action('wp_enqueue_scripts', array(&$this, 'register_bootstrap_css_style') , 9998);
			    	add_action('wp_enqueue_scripts', array(&$this, 'register_related_css_style') , 9999);
			    	add_action('wp_enqueue_scripts', array(&$this, 'register_related_js') );

			    	// reister product search widget
			    	add_action( 'widgets_init', create_function('', 'return register_widget("MarketPress_Product_Search_Widget");') );
			    	if (is_multisite())
			    		add_action( 'widgets_init', create_function('', 'return register_widget("MarketPress_Global_Product_Search_Widget");') );

			    	// wp ajax
				    add_action( 'wp_ajax_nopriv_mppsw-search-query', array(&$this, 'process_search_query') );
				    add_action( 'wp_ajax_mppsw-search-query', array(&$this, 'process_search_query') );
				    add_action( 'wp_ajax_nopriv_mppsw-reset-search', array(&$this, 'reset_search_box') );
				    add_action( 'wp_ajax_mppsw-reset-search', array(&$this, 'reset_search_box') );
				    add_action( 'wp_ajax_nopriv_mppsw-update-search-results', array(&$this, 'update_results') );
				    add_action( 'wp_ajax_mppsw-update-search-results', array(&$this, 'update_results') );
			    }

			    // register Bootstrap CSS
				function register_bootstrap_css_style() {
					$current_theme = wp_get_theme();

					switch ($current_theme->Template) {
						case 'flexmarket':
							break;

						case 'pro':
							break;
						
						default:
							wp_enqueue_style('mppsw-bootstrap-css', $this->plugin_url . 'css/bootstrap.css', null, null);
							break;
					}
				}

				 // register CSS
				function register_related_css_style() {
					wp_enqueue_style('product-search-widget-css', $this->plugin_url . 'css/mp-product-search-widget.css', null, null);
				}

				// register JS
				function register_related_js() {
					wp_enqueue_script('bootstrap', $this->plugin_url . 'js/bootstrap.min.js', array('jquery'));
					wp_enqueue_script('product-search-widget-js', $this->plugin_url . 'js/mppsw.js', array('jquery'));
					wp_localize_script( 'product-search-widget-js', 'MPPSW_Ajax', array( 
						'ajaxUrl' => admin_url( 'admin-ajax.php', (is_ssl() ? 'https': 'http') ),
						'loadingList' => __('Loading...', 'mppsw'),
						'updatedList' => __('List Updated', 'mppsw'),
						'imgUrl' => MPPSW_DIR . 'img/ajax-loader.gif'
						));
				}

				// load search box
				function load_search_box( $settings = array() ) {

				  	$defaults = array(
						'id' => '',
						'echo' => false,
						'btnclass' => '',
						'iconclass' => '',
						'spancolor' => '',
						'showcategory' => true,
						'showtag' => true,
						'showpricerange' => false,
						'customcategories' => '',
						'customtags' => '',
						'globalsearch' => false
					);

				  	$settings = wp_parse_args( $settings, $defaults );
				  	extract( $settings );

				  	$this->start_session();

				  	$_SESSION['mppsw_settings'] = $settings;

					$output = '<div id="mp-product-search-widget">';
						$output .= '<div class="product-search-box">';
								$output = apply_filters( 'mppsw_search_box_before_form' , $output , $settings );
								$output .= '<form class="mppsw-product-search-form" method="post" >';
									$output = apply_filters( 'mppsw_search_form_before_contents' , $output , $settings );
									$output .= $this->load_search_form_contents( $settings );
									$output = apply_filters( 'mppsw_search_form_after_contents' , $output , $settings );
								$output .= '</form>';
								$output = apply_filters( 'mppsw_search_box_after_form' , $output , $settings );
								// product search results modal
								$output .= '<div class="mppsw-product-search-results-modal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="productsearchresultmodal" aria-hidden="true">';
								$output .= '</div>'; // End product-search-result-modal
						$output .= '</div>'; // End product-search-box 
					$output .= '</div>'; // End mp-product-search-widget

				  	if ($echo)
				    	echo apply_filters( $this->filter_hook_prefix . 'load_search_box' , $output , $settings );
				  	else
				    	return apply_filters( $this->filter_hook_prefix . 'load_search_box' , $output , $settings );
				}

				function load_search_form_contents( $settings = array() ) {

					global $mp;

				  	$defaults = array(
						'id' => '',
						'echo' => false,
						'btnclass' => '',
						'iconclass' => '',
						'spancolor' => '',
						'showcategory' => true,
						'showtag' => true,
						'showpricerange' => false,
						'customcategories' => '',
						'customtags' => '',
						'globalsearch' => false
					);

				  	$settings = wp_parse_args( $settings, $defaults );
				  	extract( $settings );

					// keywords
					$keywords = '<div class="input-prepend first-mppsw-label">';
						$keywords .= '<div class="row-fluid">';
							$keywords .= '<span class="add-on span4 align-left'.$spancolor.'">'.__( 'Keywords' , 'mppsw' ).'</span>';
							$keywords .= '<div class="clear visible-phone"></div>';
							$keywords .= '<input type="text" value="" class="span8 mppsw-span8-without-margin" name="mppswsearchterms" id="mppswsearchterms" /><br />';
						$keywords .= '</div>';
					$keywords .= '</div>';

					$output = apply_filters( 'mppsw_search_form_keywords' , $keywords , $settings );

					if ( $showcategory || $showtag ) {
						$tax_filter = '<div class="input-prepend">';
							$tax_filter .= '<div class="row-fluid">';
								$tax_filter .= '<span class="add-on span4 align-left'.$spancolor.'">'.__( 'Filter By' , 'mppsw' ).'</span>';
								$tax_filter .= '<div class="clear visible-phone"></div>';
								$tax_filter .= '<select class="span8 mppsw-span8-without-margin mppsw-filterbyselect" id="mppswtaxfilter" name="mppswtaxfilter">';
									$tax_filter .= '<option value="" selected="selected">'.__( 'None' , 'mppsw' ).'</option>';
									$tax_filter .= $showcategory ? '<option value="filterbycategory">'.__( 'Category' , 'mppsw' ).'</option>' : '';
									$tax_filter .= $showtag ? '<option value="filterbytag">'.__( 'Tag' , 'mppsw' ).'</option>' : '';
								$tax_filter .= '</select>';
							$tax_filter .= '</div>';
						$tax_filter .= '</div>';

						$output .= apply_filters( 'mppsw_search_form_tax_filter' , $tax_filter , $settings );
					}

				  	// by category
				  	$output .= '<div class="filter-by-category-select hide">';

					  	if ($showcategory) {

					  		if ( $globalsearch && is_multisite() ) {
						  		if (!empty($customcategories)) {
						  			$categories = $this->load_global_taxonomies_list( array( 'include' => 'product_category' , 'customlist' => $customcategories ) );
						  		} else {
						  			$categories = $this->load_global_taxonomies_list( array( 'include' => 'product_category' ) );
						  		}
					  		} else {
						  		if (!empty($customcategories)) {
						  			$customcategories = explode(',' , $customcategories);
						  			$customcategorylist = array();
						  			if (!empty($customcategories)) {
						  				foreach ($customcategories as $singlecatslug) {
						  					$singlecat = get_term_by('slug', $singlecatslug , 'product_category');
						  					$customcategorylist[] = $singlecat->term_id;
						  				}
						  			}
						  			$categories = get_terms( 'product_category' , array( 'include' => $customcategorylist ) );
						  		} else {
						  			$categories = get_terms( 'product_category' );
						  		}
					  		}
							
							if (!empty($categories)) {
								$cat_output = '<div class="input-prepend">';
									$cat_output .= '<div class="row-fluid">';
										$cat_output .= '<span class="add-on span4 align-left'.$spancolor.'">'.__( 'Category' , 'mppsw' ).'</span>';
										$cat_output .= '<div class="clear visible-phone"></div>';
										$cat_output .= '<select class="span8 mppsw-span8-without-margin" id="mppswcategory" name="mppswcategory">';
											$cat_output .= '<option value="" selected="selected">'.__( 'None' , 'mppsw' ).'</option>';
											foreach ($categories as $category) {
												$cat_output .= '<option value="'.$category->slug.'">'.esc_attr($category->name).'</option>';
											}
										$cat_output .= '</select>';
									$cat_output .= '</div>';
								$cat_output .= '</div>';

								$output .= apply_filters( 'mppsw_search_form_category' , $cat_output , $categories , $settings );
							}
					  	}
					
					$output .= '</div>'; // End - filter-by-category-select

					// by tag
					$output .= '<div class="filter-by-tag-select hide">';

						if ($showtag) {

							if ( $globalsearch && is_multisite() ) {
						  		if (!empty($customtags)) {
						  			$tags = $this->load_global_taxonomies_list( array( 'include' => 'product_tag' , 'customlist' => $customtags ) );
						  		} else {
						  			$tags = $this->load_global_taxonomies_list( array( 'include' => 'product_tag' ) );
						  		}
							} else {
						  		if (!empty($customtags)) {
						  			$customtags = explode(',' , $customtags);
						  			$customtaglist = array();
						  			if (!empty($customtags)) {
						  				foreach ($customtags as $singletagslug) {
						  					$singletag = get_term_by('slug', $singletagslug , 'product_tag');
						  					$customtaglist[] = $singletag->term_id;
						  				}
						  			}
						  			$tags = get_terms( 'product_tag' , array( 'include' => $customtaglist ) );
						  		} else {
						  			$tags = get_terms('product_tag');
						  		}
							}

							if (!empty($tags)){
								$tag_output = '<div class="input-prepend">';
									$tag_output .= '<div class="row-fluid">';
										$tag_output .= '<span class="add-on span4 align-left'.$spancolor.'">'.__( 'Tag' , 'mppsw' ).'</span>';
										$tag_output .= '<div class="clear visible-phone"></div>';
										$tag_output .= '<select class="span8 mppsw-span8-without-margin" id="mppswtag" name="mppswtag">';
											$tag_output .= '<option value="" selected="selected">'.__( 'None' , 'mppsw' ).'</option>';
											foreach ($tags as $tag) {
												$tag_output .= '<option value="'.$tag->slug.'">'.esc_attr($tag->name).'</option>';
											}
										$tag_output .= '</select>';
									$tag_output .= '</div>';
								$tag_output .= '</div>';	

								$output .= apply_filters( 'mppsw_search_form_tag' , $tag_output , $tags , $settings );		
							}
						}

					$output .= '</div>'; // End - filter-by-tag-select

					// price range
					if ($showpricerange ) {
						$price_output = '<div class="row-fluid">';
							$price_output .= '<div class="input-prepend">';
								$price_output .= '<span class="add-on mppsw-search-form-price-range align-left span12'.$spancolor.'">'.__( 'Price Range ' , 'mppsw' ).'(<small>'.$mp->format_currency().'</small>)</span>';
							$price_output .= '</div>';
						$price_output .= '</div>';		
						$price_output .= '<div class="clear padding5"></div>';
						$price_output .= '<div class="row-fluid">';
							$price_output .= '<div class="input-append span6">';
								$price_output .= '<input type="text" value="" class="span12" name="mppswlowestprice" id="mppswlowestprice" placeholder="'.__( 'Lowest Price Point' , 'mppsw' ).'" />';
							$price_output .= '</div>';;
							$price_output .= '<div class="clear visible-phone"></div>';
							$price_output .= '<div class="input-prepend span6">';							
								$price_output .= '<input type="text" value="" class="span12" name="mppswhighestprice" id="mppswhighestprice" placeholder="'.__( 'Highest Price Point' , 'mppsw' ).'" />';
							$price_output .= '</div>';
						$price_output .= '</div>';

						$output .= apply_filters( 'mppsw_search_form_price_range' , $price_output , $settings );	
					}

					// Submit Button
					$button = '<button type="submit" id="productsearchsubmit" class="mppsw-search-submit-button btn'.$btnclass.' btn-block"><i class="icon-search'.$iconclass.'"></i> '.__( 'Search' , 'mppsw' ).'</button>';
					$output .= apply_filters( 'mppsw_search_form_submit_btn' , $button , $settings );
					$output .= '<input type="hidden" name="action" value="mppsw-search-query" />';

				    return apply_filters( $this->filter_hook_prefix . 'load_search_form_contents' , $output , $settings );
				}

				// load search result modal
				function load_search_result_modal( $args = array() ) {

				  	$defaults = array(
				  		'id' => '',
						'echo' => false,
				    	'btnclass' => '',
						'iconclass' => '',
				    	'searchterms' => '',
						'perpage' => 10,
						'page' => 1,
						'orderby' => 'date',
						'order' => 'DESC',
						'category' => '',
						'tag' => '',
						'lowestprice' => false,
						'highestprice' => false,
						'globalsearch' => false
					);

				  	$theinstance = wp_parse_args( $args, $defaults );
				  	extract( $theinstance );

						$output = '<div class="modal-header">';
							$output .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
							$output .= apply_filters( 'mppsw_search_result_modal_title' , '<h3 class="align-center">'.__( 'Search Results' , 'mppsw' ).'</h3>' );
						$output .= '</div>'; // End modal-header

						$output .= '<div class="modal-body">';
							$output = apply_filters( 'mppsw_search_result_modal_body_before_results' , $output );
							$output .= '<div class="modal-product-search-results">';
								$output .= $this->load_search_results_listing( $theinstance );
							$output .= '</div>'; // End modal-product-search-results
							$output = apply_filters( 'mppsw_search_result_modal_body_after_results' , $output );
						$output .= '</div>'; // End modal-body

						$output .= '<div class="modal-footer">';
							$output = apply_filters( 'mppsw_search_result_modal_footer_before_button' , $output , $btnclass , $iconclass );
							$output .= apply_filters( 'mppsw_search_result_modal_footer_button' , '<button class="btn'.$btnclass.'" data-dismiss="modal" aria-hidden="true"><i class="icon-remove'.$iconclass.'"></i> '.__( 'Close', 'mppsw' ).'</button>' , $btnclass , $iconclass );
							$output = apply_filters( 'mppsw_search_result_modal_footer_after_button' , $output , $btnclass , $iconclass );
						$output .= '</div>'; // End modal-footer

				  	if ($echo)
				    	echo apply_filters( $this->filter_hook_prefix . 'load_search_result_modal' , $output , $theinstance );
				  	else
				    	return apply_filters( $this->filter_hook_prefix . 'load_search_result_modal' , $output , $theinstance );
				}

				// load search results
				function load_search_results_listing( $args = array() ) {

				  	$defaults = array(
						'echo' => false,
				    	'btnclass' => '',
						'iconclass' => '',
				    	'searchterms' => '',
						'perpage' => 10,
						'page' => 1,
						'orderby' => 'date',
						'order' => 'DESC',
						'category' => '',
						'tag' => '',
						'lowestprice' => false,
						'highestprice' => false,
						'globalsearch' => false
					);

				  	$theinstance = wp_parse_args( $args, $defaults );
				  	extract( $theinstance );

				  	$checkproducts = array(
				  			'searchterms' => $searchterms,
				  			'category' => $category,
							'tag' => $tag,
							'lowestprice' => $lowestprice,
							'highestprice' => $highestprice,
							'globalsearch' => $globalsearch
				  		);

				  	if ( $globalsearch && is_multisite()) {

				  		global $wpdb;

				  		$query = "SELECT blog_id, p.post_id, post_permalink, post_title, post_content FROM {$wpdb->base_prefix}mp_products p";

					  	//setup taxonomy if applicable
					  	if (!empty($category)) {
						    $category = esc_sql( sanitize_title( $category ) );
						    $query .= " INNER JOIN {$wpdb->base_prefix}mp_term_relationships r ON p.id = r.post_id INNER JOIN {$wpdb->base_prefix}mp_terms t ON r.term_id = t.term_id WHERE p.blog_public = 1 AND t.type = 'product_category' AND t.slug = '$category'";
					  	} elseif (!empty($tag)) {
						    $tag = esc_sql( sanitize_title( $tag ) );
						    $query .= " INNER JOIN {$wpdb->base_prefix}mp_term_relationships r ON p.id = r.post_id INNER JOIN {$wpdb->base_prefix}mp_terms t ON r.term_id = t.term_id WHERE p.blog_public = 1 AND t.type = 'product_tag' AND t.slug = '$tag'";
					  	} else {
						    $query .= " WHERE p.blog_public = 1";
					  	}

					  	// get search
						if ( !empty($searchterms) ) {
							// added slashes screw with quote grouping when done early, so done later
							$searchterms = stripslashes($searchterms);
							preg_match_all('/".*?("|$)|((?<=[\r\n\t ",+])|^)[^\r\n\t ",+]+/', $searchterms , $matches);
							$search_terms = array_map('_search_terms_tidy', $matches[0]);

							$n = '%';
							$search = '';
							$searchand = '';
							foreach( (array) $search_terms as $term ) {
								$term = esc_sql( like_escape( $term ) );
								$search .= "{$searchand}((p.post_title LIKE '{$n}{$term}{$n}') OR (p.post_content LIKE '{$n}{$term}{$n}'))";
								$searchand = ' AND ';
							}
							if ( !empty($search) ) {
								$query .= " AND ({$search}) ";
							}
						}

						// price range
						if ( $lowestprice && $highestprice ) {
							$query .= " AND p.price BETWEEN $lowestprice AND $highestprice";
						} elseif ( $lowestprice || $highestprice ) {
							if ($lowestprice)
								$query .= " WHERE p.price >= $lowestprice";
							if ($highestprice)
								$query .= " WHERE p.price <= $highestprice";
						}

						//get order by
						switch ($orderby) {

						    case 'title':
						      $query .= " ORDER BY p.post_title";
						      break;

						    case 'price':
						      $query .= " ORDER BY p.price";
						      break;

						    case 'sales':
						      $query .= " ORDER BY p.sales_count";
						      break;

						    case 'rand':
						      $query .= " ORDER BY RAND()";
						      break;

						    case 'date':
						    default:
						      $query .= " ORDER BY p.post_date";
						      break;
						}

						//get order direction
						if ($order == 'ASC') {
						    $query .= " ASC";
						} else {
						    $query .= " DESC";
						}

						//get page details
					  	$query .= " LIMIT " . intval(($page-1)*$perpage) . ", " . intval($perpage);

				  		$products = $wpdb->get_results( $query );

				  	} else {

					  	if ('price' == $orderby){
					  		$order_by = 'meta_value_num';
					  		$metakey = 'mp_price_sort';
					  	} else if('sales' == $orderby){
					  		$order_by = 'meta_value_num';
					  		$metakey = 'mp_sales_count';
					  	} else {
					  		$order_by = $orderby;
					  		$metakey = '';
					  	}

						$query_args = array(
								'post_type' => 'product',
								's'       	=> $searchterms,
								'posts_per_page' => $perpage,
								'paged'     => $page,
								'orderby'   => $order_by,
								'meta_key'  => $metakey,
								'order'    	=> $order,
								'product_category' => $category,
								'product_tag' => $tag
							);

						if ( $lowestprice && $highestprice ) {
							$query_args['meta_query'] = array(
										array(
											'key' => 'mp_price_sort',
											'value' => array( $lowestprice , $highestprice ),
											'type' => 'NUMERIC',
											'compare' => 'BETWEEN'
											)
									);
						} elseif ( $lowestprice || $highestprice ) {
							if ($lowestprice)
								$query_args['meta_query'] = array(
										array(
											'key' => 'mp_price_sort',
											'value' => $lowestprice,
											'type' => 'NUMERIC',
											'compare' => '>='
											)
									);
							if ($highestprice)
								$query_args['meta_query'] = array(
										array(
											'key' => 'mp_price_sort',
											'value' => $highestprice,
											'type' => 'NUMERIC',
											'compare' => '<='
											)
									);
						}

						$products = get_posts($query_args);
				  	}

					$maxpages = $this->num_product_found($checkproducts) ? $this->num_product_found($checkproducts) / $perpage : 1;
					$maxpages = ceil($maxpages);

					if (!empty($products)) {
						$output = '<form id="mppsw-listing-form" class="mppsw-search-results-listing-form" method="post">';

							$output = apply_filters( 'mppsw_search_results_listing_before_table_start' , $output , $theinstance );

							$output .= '<table class="table table-striped table-hover table-bordered mppsw-table-search-results">';

							$output = apply_filters( 'mppsw_search_results_listing_before_head' , $output , $theinstance );

							$output .= '<thead>';
								$output .= '<tr><td colspan="2" class="form-inline">';
									$output .= '<div class="row-fluid">';
										// soft by
										$sortby = '<div class="input-prepend span8">';
											$sortby .= '<span class="add-on span4 align-right">'.__( 'Sort By' , 'mppsw' ).'</span>';
											$sortby .= '<div class="clear visible-phone"></div>';
											$sortby .= '<select class="span4" id="mppsworderby" name="mppsworderby">';
												$sortby .= '<option value="date"'.($orderby == 'date' ? ' selected="selected"' : '').'>'.__( 'Date' , 'mppsw' ).'</option>';
												$sortby .= '<option value="title"'.($orderby == 'title' ? ' selected="selected"' : '').'>'.__( 'Title' , 'mppsw' ).'</option>';
												$sortby .= '<option value="price"'.($orderby == 'price' ? ' selected="selected"' : '').'>'.__( 'Price' , 'mppsw' ).'</option>';
												$sortby .= '<option value="sales"'.($orderby == 'sales' ? ' selected="selected"' : '').'>'.__( 'Sales' , 'mppsw' ).'</option>';
											$sortby .= '</select>';
											$sortby .= '<div class="clear visible-phone"></div>';
											$sortby .= '<select class="span4" id="mppsworder" name="mppsworder">';
													$sortby .= '<option value="DESC"'.($order == 'DESC' ? ' selected="selected"' : '').'>'.__('DESC' , 'mppsw').$i.'</option>';
													$sortby .= '<option value="ASC"'.($order == 'ASC' ? ' selected="selected"' : '').'>'.__('ASC' , 'mppsw').$i.'</option>';
											$sortby .= '</select>';
										$sortby .= '</div>';

										$output .= apply_filters( 'mppsw_search_results_update_sortby' , $sortby , $theinstance );
										$output .= apply_filters( 'mppsw_search_results_update_btn_top' , '<button type="submit" class="add-on mppsw-search-results-update-btn btn span3 offset1'.$btnclass.'"><i class="icon-th'.$iconclass.'"></i> '.__( 'Sort' , 'mppsw' ).'</button>' , $theinstance );

									$output .= '</div>'; // End - row-fluid
								$output .= '</td></tr>';
							$output .= '</thead>';

							$output = apply_filters( 'mppsw_search_results_listing_before_body' , $output , $theinstance );

							$output .= '<tbody class="mppsw-table-search-results-body">';

							foreach ($products as $product) {

								if ( $globalsearch && is_multisite() )
									switch_to_blog($product->blog_id);

								$product_id = $globalsearch && is_multisite() ? $product->post_id : $product->ID;

								$product_output = '<tr>';
									$product_output .= '<td>';
										$product_output .= '<div class="mppsw-product-image"><center>'.mp_product_image( false, 'widget', $product_id , 150 ).'</center></div>';
									$product_output .= '</td>';
									$product_output .= '<td>';
										$product_output .= '<h4><a href="'.get_permalink($product_id).'">'.get_the_title($product_id).'</a></h4>';
										$product_output .= apply_filters( 
											'mppsw_search_results_listing_product_excerpt', 
											'<p>' . (!empty($product->post_excerpt) ? $product->post_excerpt : wp_trim_words($product->post_content , 15) ) .'</p>', 
											$product_id , $product->post_excerpt , $product->post_content );
										$product_output .= apply_filters( 'mppsw_search_results_listing_product_price_button' , 
											'<div class="btn-group search-item-btn-group">
												<button class="btn'.$btnclass.' disabled">'.mp_product_price( false , $product_id , false ).'</button>
												<a href="'.get_permalink($product_id).'" class="btn'.$btnclass.'">'.__( 'Buy Now' , 'mppsw' ).'</a>
											</div>' , 
											$product_id );
									$product_output .= '</td>';
								$product_output .= '</tr>';
								$output .= apply_filters( 'mppsw_search_results_listing_product_output' , $product_output , $product , $theinstance );
							}

							if ( $globalsearch && is_multisite() )
								restore_current_blog();

							$output .= '</tbody>';

							$output = apply_filters( 'mppsw_search_results_listing_after_tbody' , $output , $theinstance );

							$output .= '<tr><td colspan="2">';
								$output .= '<div class="row-fluid">';
									// paginate
									$paginate = '<div class="input-prepend span6 offset4">';
										$paginate .= '<span class="add-on span4 align-right">'.__( 'Page' , 'mppsw' ).'</span>';
										$paginate .= '<div class="clear visible-phone"></div>';
										$paginate .= '<select class="span8" id="mppswpage" name="mppswpage">';
											for ($i=1; $i <= $maxpages ; $i++) { 
												$paginate .= '<option value="'.$i.'"'.($page == $i ? ' selected="selected"' : '').'>'.$i.'</option>';
											}
										$paginate .= '</select>';
									$paginate .= '</div>';
									$output .= apply_filters( 'mppsw_search_results_update_paginate' , $paginate , $theinstance );
									$output .= apply_filters( 'mppsw_search_results_update_btn_bottom' , '<button type="submit" class="add-on mppsw-search-results-update-btn btn span2'.$btnclass.'">'.__( 'Go' , 'mppsw' ).' <i class="icon-arrow-right'.$iconclass.'"></i></button>' , $theinstance );

								$output .= '</div>'; // End - row-fluid

							$output .= '</td></tr>';

							$output = apply_filters( 'mppsw_search_results_listing_before_table_end' , $output , $theinstance );

							$output .= '</table>';
							$output .= '<input type="hidden" id="mppswsearchterms" name="mppswsearchterms" value="'.$searchterms.'" />';
							$output .= '<input type="hidden" id="mppswcategory" name="mppswcategory" value="'.$category.'" />';
							$output .= '<input type="hidden" id="mppswtag" name="mppswtag" value="'.$tag.'" />';
							$output .= '<input type="hidden" id="mppswlowestprice" name="mppswlowestprice" value="'.$lowestprice.'" />';
							$output .= '<input type="hidden" id="mppswhighestprice" name="mppswhighestprice" value="'.$highestprice.'" />';
							$output .= '<input type="hidden" name="action" value="mppsw-update-search-results" />';
							$output = apply_filters( 'mppsw_search_results_listing_hidden_input' , $output , $theinstance );
						$output .= '</form>';
					} 

				  	if ($echo)
				    	echo apply_filters( $this->filter_hook_prefix . 'load_search_results_listing' , $output , $theinstance );
				  	else
				    	return apply_filters( $this->filter_hook_prefix . 'load_search_results_listing' , $output , $theinstance );
				}

				function num_product_found( $args = array() ) {

				  	$defaults = array(
			  			'searchterms' => '',
			  			'category' => '',
						'tag' => '',
						'lowestprice' => false,
						'highestprice' => false,
						'globalsearch' => false
					);

				  	$theinstance = wp_parse_args( $args, $defaults );
				  	extract( $theinstance );

				  	if ( $globalsearch && is_multisite()) {

				  		global $wpdb;

				  		$query = "SELECT blog_id, p.post_id, post_permalink, post_title, post_content FROM {$wpdb->base_prefix}mp_products p";

					  	//setup taxonomy if applicable
					  	if (!empty($category)) {
						    $category = esc_sql( sanitize_title( $category ) );
						    $query .= " INNER JOIN {$wpdb->base_prefix}mp_term_relationships r ON p.id = r.post_id INNER JOIN {$wpdb->base_prefix}mp_terms t ON r.term_id = t.term_id WHERE p.blog_public = 1 AND t.type = 'product_category' AND t.slug = '$category'";
					  	} elseif (!empty($tag)) {
						    $tag = esc_sql( sanitize_title( $tag ) );
						    $query .= " INNER JOIN {$wpdb->base_prefix}mp_term_relationships r ON p.id = r.post_id INNER JOIN {$wpdb->base_prefix}mp_terms t ON r.term_id = t.term_id WHERE p.blog_public = 1 AND t.type = 'product_tag' AND t.slug = '$tag'";
					  	} else {
						    $query .= " WHERE p.blog_public = 1";
					  	}	

						// price range
						if ( $lowestprice && $highestprice ) {
							$query .= " AND p.price BETWEEN $lowestprice AND $highestprice";
						} elseif ( $lowestprice || $highestprice ) {
							if ($lowestprice)
								$query .= " WHERE p.price BETWEEN ('$lowestprice' , '$highestprice')";
							if ($highestprice)
								$query .= " WHERE p.price BETWEEN ('$lowestprice' , '$highestprice')";
						}

					  	// get search
						if ( !empty($searchterms) ) {
							// added slashes screw with quote grouping when done early, so done later
							$searchterms = stripslashes($searchterms);
							preg_match_all('/".*?("|$)|((?<=[\r\n\t ",+])|^)[^\r\n\t ",+]+/', $searchterms , $matches);
							$search_terms = array_map('_search_terms_tidy', $matches[0]);

							$n = '%';
							$search = '';
							$searchand = '';
							foreach( (array) $search_terms as $term ) {
								$term = esc_sql( like_escape( $term ) );
								$search .= "{$searchand}((p.post_title LIKE '{$n}{$term}{$n}') OR (p.post_content LIKE '{$n}{$term}{$n}'))";
								$searchand = ' AND ';
							}
							if ( !empty($search) ) {
								$query .= " AND ({$search}) ";
							}
						}					

						// get page details
					  	$query .= " LIMIT 0, 999";

				  		$products = $wpdb->get_results( $query );
				  		$count = 0;

				  	} else {

						$query_args = array(
							'post_type' => 'product',
							's'       	=> $searchterms,
							'product_category' => $category,
							'product_tag' => $tag,
							'numberposts' => 99999,
							);

						if ( $lowestprice && $highestprice ) {
							$query_args['meta_query'] = array(
										array(
											'key' => 'mp_price_sort',
											'value' => array( $lowestprice , $highestprice ),
											'type' => 'NUMERIC',
											'compare' => 'BETWEEN'
											)
									);
						} elseif ( $lowestprice || $highestprice ) {
							if ($lowestprice)
								$query_args['meta_query'] = array(
										array(
											'key' => 'mp_price_sort',
											'value' => $lowestprice,
											'type' => 'NUMERIC',
											'compare' => '>='
											)
									);
							if ($highestprice)
								$query_args['meta_query'] = array(
										array(
											'key' => 'mp_price_sort',
											'value' => $highestprice,
											'type' => 'NUMERIC',
											'compare' => '<='
											)
									);
						}

						$products = get_posts($query_args);
						$count = 0;
				  	}					

					if (!empty($products)) {
						foreach ($products as $product) {
							$count++;
						}
						return apply_filters( $this->filter_hook_prefix . 'num_product_found' , $count , $theinstance );
					} else {
						return apply_filters( $this->filter_hook_prefix . 'num_product_found' , false , $theinstance );
					}
				}

			  	function start_session() {
			    	//start the sessions for cart handling
			    	if (session_id() == "")
			      		session_start();
			  	}

			  	// reset search box
			  	function reset_search_box() {

			  		$this->start_session();

					$settings = !empty($_SESSION['mppsw_settings']) ? $_SESSION['mppsw_settings'] : array( 
							'id' => '',
							'echo' => false,
							'btnclass' => '',
							'iconclass' => '',
							'showcategory' => true,
							'showtag' => true,
							'showpricerange' => false,
							'customcategories' => '',
							'customtags' => '',
							'globalsearch' => false
						);

					if (defined('DOING_AJAX') && DOING_AJAX) {
						echo apply_filters( $this->filter_hook_prefix . 'reset_search_box' , 'success||' . $this->load_search_form_contents($settings) , $settings );
						exit;
					}
			  	}

				// process search query
				function process_search_query() {

					$this->start_session();

					$searchterms = isset( $_POST['mppswsearchterms'] ) ? esc_attr(trim($_POST['mppswsearchterms'])) : '';
					$perpage = isset( $_POST['mppswperpage'] ) ? esc_attr(trim($_POST['mppswperpage'])) : 10;
					$page = isset( $_POST['mppswpage'] ) ? esc_attr(trim($_POST['mppswpage'])) : 1;
					$orderby = isset( $_POST['mppsworderby'] ) ? esc_attr(trim($_POST['mppsworderby'])) : 'date';
					$order = isset( $_POST['mppsworder'] ) ? esc_attr(trim($_POST['mppsworder'])) : 'DESC';
					$category = isset( $_POST['mppswcategory'] ) ? esc_attr(trim($_POST['mppswcategory'])) : '';
					$tag = isset( $_POST['mppswtag'] ) ? esc_attr(trim($_POST['mppswtag'])) : '';
					$lowestprice = isset( $_POST['mppswlowestprice'] ) ? ( is_numeric(trim($_POST['mppswlowestprice'])) ? trim($_POST['mppswlowestprice']) : false ) : false;
					$highestprice = isset( $_POST['mppswhighestprice'] ) ? ( is_numeric(trim($_POST['mppswhighestprice'])) ? trim($_POST['mppswhighestprice']) : false ) : false;
					$settings = !empty($_SESSION['mppsw_settings']) ? $_SESSION['mppsw_settings'] : array( 
							'id' => '',
							'echo' => false,
							'btnclass' => '',
							'iconclass' => '',
							'showcategory' => true,
							'showtag' => true,
							'showpricerange' => false,
							'customcategories' => '',
							'customtags' => '',
							'globalsearch' => false
						);

					do_action('mppsw_process_search_query');

				  	$theinstance = array(
				  		'id' => $settings['id'],
						'echo' => false,
				    	'btnclass' => $settings['btnclass'],
						'iconclass' => $settings['iconclass'],
				    	'searchterms' => $searchterms,
						'perpage' => $perpage,
						'page' => $page,
						'orderby' => $orderby,
						'order' => $order,
						'category' => $category,
						'tag' => $tag,
						'lowestprice' => $lowestprice,
						'highestprice' => $highestprice,
						'globalsearch' => $settings['globalsearch']
					);

				  	$checkproducts = array(
				  			'searchterms' => $searchterms,
				  			'category' => $category,
							'tag' => $tag,
							'lowestprice' => $lowestprice,
							'highestprice' => $highestprice,
							'globalsearch' => $settings['globalsearch']
				  		);

					$error = '<div class="alert alert-error alert-mppsw nomargin"><button type="button" class="close" data-dismiss="alert">&times;</button>';
						$error .= $this->num_product_found($checkproducts) ? '' : ' '. __( 'No Product(s) Found.' , 'mppsw' ). '<br />';
						$error .= '<div class="clear padding5"></div>';
						$error .= '<div class="btn-group">';
							$error .= '<button href="#" class="btn btn-small disabled'.$settings['btnclass'].'"><i class="icon-zoom-in'.$settings['iconclass'].'"></i> '.__( 'View Results' , 'mppsw' ).'</button>';
							$error .= '<button type="submit" class="mppsw-reset-search-link btn btn-small'.$settings['btnclass'].'"><i class="icon-refresh'.$settings['iconclass'].'"></i> '.__( 'Reset' , 'mppsw' ).'</button>';
						$error .= '</div>';
						$error .= '<input type="hidden" name="action" value="mppsw-reset-search" />';
						$error .= '<div class="clear"></div>';
					$error .= '</div>';
					$error = apply_filters( 'mppsw_process_search_results_error_tag', $error );

					$success = '<div class="alert alert-success nomargin">';
						$success .= ( $this->num_product_found($checkproducts) ? $this->num_product_found($checkproducts) : '' ).__(' Product(s) Found.', 'mppsw') . '<br />';
						$success .= '<div class="clear padding5"></div>';
						$success .= '<div class="btn-group">';
							$success .= '<button href=".mppsw-product-search-results-modal" data-toggle="modal" class="btn btn-small'.$settings['btnclass'].'"><i class="icon-zoom-in'.$settings['iconclass'].'"></i> '.__( 'View Results' , 'mppsw' ).'</button>';
							$success .= '<button type="submit" class="mppsw-reset-search-link btn btn-small'.$settings['btnclass'].'"><i class="icon-refresh'.$settings['iconclass'].'"></i> '.__( 'Reset' , 'mppsw' ).'</button>';
						$success .= '</div>';
						$success .= '<input type="hidden" name="action" value="mppsw-reset-search" />';
						$success .= '<div class="clear"></div>';
					$success .= '</div>';
					$success = apply_filters( 'mppsw_process_search_results_success_tag', $success );
					$modal = apply_filters( 'mppsw_process_search_results_load_modal' , $this->load_search_result_modal( $theinstance ) , $theinstance );

				    if ( $this->num_product_found($checkproducts) ) {

						if (defined('DOING_AJAX') && DOING_AJAX) {
							echo  apply_filters( $this->filter_hook_prefix . 'process_search_query' ,  'success||' . $success . '||' . $modal , $settings , $theinstance , $checkproducts );
							exit;
						}
				    	
				    } else {
						if (defined('DOING_AJAX') && DOING_AJAX) {
							echo apply_filters( $this->filter_hook_prefix . 'process_search_query' , 'error||' . $error . '|| ' , $settings , $theinstance , $checkproducts );
							exit;
						}
					}
				}	

				// update search results
				function update_results() {

					$this->start_session();

					$searchterms = isset( $_POST['mppswsearchterms'] ) ? esc_attr(trim($_POST['mppswsearchterms'])) : '';
					$perpage = isset( $_POST['mppswperpage'] ) ? esc_attr(trim($_POST['mppswperpage'])) : 10;
					$page = isset( $_POST['mppswpage'] ) ? esc_attr(trim($_POST['mppswpage'])) : 1;
					$orderby = isset( $_POST['mppsworderby'] ) ? esc_attr(trim($_POST['mppsworderby'])) : 'date';
					$order = isset( $_POST['mppsworder'] ) ? esc_attr(trim($_POST['mppsworder'])) : 'DESC';
					$category = isset( $_POST['mppswcategory'] ) ? esc_attr(trim($_POST['mppswcategory'])) : '';
					$tag = isset( $_POST['mppswtag'] ) ? esc_attr(trim($_POST['mppswtag'])) : '';
					$lowestprice = isset( $_POST['mppswlowestprice'] ) ? ( is_numeric(trim($_POST['mppswlowestprice'])) ? trim($_POST['mppswlowestprice']) : false ) : false;
					$highestprice = isset( $_POST['mppswhighestprice'] ) ? ( is_numeric(trim($_POST['mppswhighestprice'])) ? trim($_POST['mppswhighestprice']) : false ) : false;
					$settings = !empty($_SESSION['mppsw_settings']) ? $_SESSION['mppsw_settings'] : array( 
							'id' => '',
							'echo' => false,
							'btnclass' => '',
							'iconclass' => '',
							'showcategory' => true,
							'showtag' => true,
							'showpricerange' => false,
							'customcategories' => '',
							'customtags' => '',
							'globalsearch' => false
					);

					do_action('mppsw_update_results');

				  	$theinstance = array(
						'echo' => false,
				    	'btnclass' => $settings['btnclass'],
						'iconclass' => $settings['iconclass'],
				    	'searchterms' => $searchterms,
						'perpage' => $perpage,
						'page' => $page,
						'orderby' => $orderby,
						'order' => $order,
						'category' => $category,
						'tag' => $tag,
						'lowestprice' => $lowestprice,
						'highestprice' => $highestprice,
						'globalsearch' => $settings['globalsearch']
					);

				  	$checkproducts = array(
				  			'searchterms' => $searchterms,
				  			'category' => $category,
							'tag' => $tag,
							'lowestprice' => $lowestprice,
							'highestprice' => $highestprice,
							'globalsearch' => $settings['globalsearch']
				  		);

					$error = '<tr><td><div class="alert alert-error alert-mppsw nomargin"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.__( 'Error: No Product(s) Found.' , 'mppsw' ).'</strong>';
					$error .= '</div></td></tr>';
					$error = apply_filters( 'mppsw_update_results_error_tag', $error );

					$success = apply_filters( 'mppsw_update_results_load_listing' , $this->load_search_results_listing( $theinstance ) , $theinstance );

				    if ( $this->num_product_found($checkproducts) ) {

						if (defined('DOING_AJAX') && DOING_AJAX) {
							echo apply_filters( $this->filter_hook_prefix . 'update_results' , 'success||' . $success , $settings , $theinstance , $checkproducts );
							exit;
						}
				    	
				    } else {
						if (defined('DOING_AJAX') && DOING_AJAX) {
							echo apply_filters( $this->filter_hook_prefix . 'update_results' , 'error||' . $error , $settings , $theinstance , $checkproducts );
							exit;
						}
					}

				}

				function load_button_color($selected) {

					switch ($selected) {
						case 'grey':
							$class = '';
							break;
						case 'blue':
							$class = ' btn-primary';
							break;
						case 'lightblue':
							$class = ' btn-info';
							break;
						case 'green':
							$class = ' btn-success';
							break;
						case 'yellow':
							$class = ' btn-warning';
							break;
						case 'red':
							$class = ' btn-danger';
							break;
						case 'black':
							$class = ' btn-inverse';
							break;
						
						default:
							$class = '';
							break;
					}

					return apply_filters( $this->filter_hook_prefix . 'load_button_color' , $class , $selected );
				}

				function load_icon_color($selected) {
					switch ($selected) {
						case 'grey':
							$class = '';
							break;
						case 'blue':
							$class = ' icon-white';
							break;
						case 'lightblue':
							$class = ' icon-white';
							break;
						case 'green':
							$class = ' icon-white';
							break;
						case 'yellow':
							$class = ' icon-white';
							break;
						case 'red':
							$class = ' icon-white';
							break;
						case 'black':
							$class = ' icon-white';
							break;
						
						default:
							$class = '';
							break;
					}

					return apply_filters( $this->filter_hook_prefix . 'load_icon_color' , $class , $selected );
				}

				function load_input_span_color($selected) {

					switch ($selected) {
						case 'grey':
							$class = '';
							break;
						case 'blue':
							$class = ' add-on-primary';
							break;
						case 'lightblue':
							$class = ' add-on-info';
							break;
						case 'green':
							$class = ' add-on-success';
							break;
						case 'yellow':
							$class = ' add-on-warning';
							break;
						case 'red':
							$class = ' add-on-danger';
							break;
						case 'black':
							$class = ' add-on-inverse';
							break;
						
						default:
							$class = '';
							break;
					}

					return apply_filters( $this->filter_hook_prefix . 'load_input_span_color' , $class , $selected );
				}

				function load_global_taxonomies_list( $args = array() ){

					$defaults = array(
						'include' => 'product_category',
						'customlist' => '',
						'limit' => 100,
						'order_by' => 'name',
						'order' => 'ASC',
					);

					$instance = wp_parse_args( $args, $defaults );
					extract( $instance );

				  	global $wpdb;

				  	$order_by = ($order_by == 'count') ? $order_by : 'name';
				  	$order = ($order == 'DESC') ? $order : 'ASC';
				  	$limit = intval($limit);

				  	if (!empty($customlist)) {
				  		$customlist = esc_sql( sanitize_text_field( $customlist ) );
				  		$customlist = explode(',' , $customlist);
				  		$customtaxlist = '';
				  		$count = 1;
				  		if (!empty($customlist)) {
					  		foreach ($customlist as $singleslug) {
					  			$customtaxlist .= ( $count == 1 ? "" : "," )."'".$singleslug."'";
					  			$count++;
					  		}	
				  		}
				  		$custom = " AND t.slug IN ($customtaxlist)";
				  	} else {
				  		$custom = '';
				  	}

				  	if ($include == 'product_tag')
				    	$where = " WHERE t.type = 'product_tag'$custom";
				  	else if ($include == 'product_category')
				    	$where = " WHERE t.type = 'product_category'$custom";

				  	$tags = $wpdb->get_results( "SELECT name, slug, type, count(post_id) as count FROM {$wpdb->base_prefix}mp_terms t LEFT JOIN {$wpdb->base_prefix}mp_term_relationships r ON t.term_id = r.term_id$where GROUP BY t.term_id ORDER BY $order_by $order LIMIT $limit", OBJECT );

					if ( !$tags )
						return apply_filters( $this->filter_hook_prefix . 'load_global_taxonomies_list' , '' , $instance );			
					else
					  	return apply_filters( $this->filter_hook_prefix . 'load_global_taxonomies_list' , $tags , $instance );
				}
			}

			global $mppsw;
			$mppsw = new MPPSW();
		}

		// product search widget class
		class MarketPress_Product_Search_Widget extends WP_Widget {

			function MarketPress_Product_Search_Widget() {
				$widget_ops = array( 'classname' => 'mp_product_search_widget', 'description' => __( 'Give your customers the ability to find the product they want based on their preferences.', 'mppsw' ) );
				$this->WP_Widget('mp_product_search_widget', __('Product Search Widget', 'mppsw'), $widget_ops);
			}

			function widget( $args, $instance ) {

				if ($instance['only_store_pages'] && !mp_is_shop_page())
					return;

				extract( $args );

				global $mppsw;

				$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Product Search', 'mppsw') : $instance['title'], $instance, $this->id_base);
				$showcategory = $instance['showcategory'] ? true : false;
				$showtag = $instance['showtag'] ? true : false;
				$customcategories = !empty($instance['customcategories']) ? $instance['customcategories'] : '';
				$customtags = !empty($instance['customtags']) ? $instance['customtags'] : '';
				$showpricerange = $instance['showpricerange'] ? true : false;
				$colorskin = !empty($instance['colorskin']) ? $instance['colorskin'] : 'grey';
				$btnclass = $mppsw->load_button_color($colorskin);
				$iconclass = $mppsw->load_icon_color($colorskin);
				$spancolor = $mppsw->load_input_span_color($colorskin);

				$widget_settings = array(
						'id' => $this->id,
						'echo' => false,
						'btnclass' => $btnclass,
						'iconclass' => $iconclass,
						'spancolor' => $spancolor,
						'showcategory' => $showcategory,
						'showtag' => $showtag,
						'showpricerange' => $showpricerange,
						'customcategories' => $customcategories,
						'customtags' => $customtags,
						'globalsearch' => false
					);

				echo $before_widget;
				if ( $title )
					echo $before_title . $title . $after_title;

				echo $mppsw->load_search_box( $widget_settings );

				echo $after_widget;
			}

			function update( $new_instance, $old_instance ) {
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['showcategory'] = !empty($new_instance['showcategory']) ? true : false;
				$instance['customcategories'] = stripslashes( wp_filter_nohtml_kses( $new_instance['customcategories'] ) );
				$instance['customtags'] = stripslashes( wp_filter_nohtml_kses( $new_instance['customtags'] ) );
				$instance['showtag'] = !empty($new_instance['showtag']) ? true : false;
				$instance['showpricerange'] = !empty($new_instance['showpricerange']) ? true : false;
				$instance['colorskin'] = !empty($new_instance['colorskin']) ? $new_instance['colorskin'] : 'grey';
				$instance['only_store_pages'] = !empty($new_instance['only_store_pages']) ? true : false;

				return $instance;
			}

			function form( $instance ) {
				//Defaults
				$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'only_store_pages' => 0 ) );
				$title = esc_attr( $instance['title'] );
				$showcategory = isset($instance['showcategory']) ? (bool) $instance['showcategory'] : true;
				$customcategories = !empty($instance['customcategories']) ? $instance['customcategories'] : '';
				$customtags = !empty($instance['customtags']) ? $instance['customtags'] : '';
				$showtag = isset($instance['showtag']) ? (bool) $instance['showtag'] : true;
				$showpricerange = isset($instance['showpricerange']) ? (bool) $instance['showpricerange'] : true;
				$colorskin = !empty($instance['colorskin']) ? $instance['colorskin'] : 'grey';
				$only_store_pages = isset( $instance['only_store_pages'] ) ? (bool) $instance['only_store_pages'] : false;

				$output = '<p style="font-size: 0.85em;font-style: italic;">';
					$output .= '<span style="color: #9e0000;font-weight: bold;">'.__( 'IMPORTANT: ' , 'mppsw' ).'</span>'.__( 'Please read the ' , 'mppsw' ).'<a href="http://www.marketpressthemes.com/blog/tutorial/using-marketpress-product-search-widget/" target="_blank">'.__( 'tutorial' , 'mppsw' ).'</a>'.__( ' first before start using this widget.' , 'mppsw' );
				$output .= '</p>';
			
				$output .= '<p>'; 
					$output .= '<label for="'.$this->get_field_id('title').'">'.__( 'Title:' , 'mppsw' ).'</label>';
					$output .= '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" />';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<input type="checkbox" class="checkbox" id="'.$this->get_field_id('showcategory').'" name="'.$this->get_field_name('showcategory').'"'.checked( $showcategory , true , false ).' />';
					$output .= '<label for="'.$this->get_field_id('showcategory').'">'. __( ' Show Category Filter', 'mppsw' ).'</label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<label for="'.$this->get_field_id('customcategories').'">'.__('Custom Category List:', 'mppsw').'<br />';
					$output .= '<textarea class="widefat" id="'.$this->get_field_id('customcategories').'" name="'.$this->get_field_name('customcategories').'">'.esc_attr($customcategories).'</textarea><br />';
					$output .= '<span style="font-size: 0.85em;font-style: italic;line-height: 0.95em;">'.__( 'Enter only the category slug. The slugs should be separated by comas (ex: cat-1,cat-2,cat-3).' , 'mppsw' ).'</span></label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<input type="checkbox" class="checkbox" id="'.$this->get_field_id('showtag').'" name="'.$this->get_field_name('showtag').'"'.checked( $showtag , true , false ).' />';
					$output .= '<label for="'.$this->get_field_id('showtag').'">'. __( ' Show Tag Filter', 'mppsw' ).'</label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<label for="'.$this->get_field_id('customtags').'">'.__('Custom Tag List:', 'mppsw').'<br />';
					$output .= '<textarea class="widefat" id="'.$this->get_field_id('customtags').'" name="'.$this->get_field_name('customtags').'">'.esc_attr($customtags).'</textarea><br />';
					$output .= '<span style="font-size: 0.85em;font-style: italic;line-height: 0.95em;">'.__( 'Enter only the tag slug. The slugs should be separated by comas (ex: tag-1,tag-2,tag-3).' , 'mppsw' ).'</span></label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<input type="checkbox" class="checkbox" id="'.$this->get_field_id('showpricerange').'" name="'.$this->get_field_name('showpricerange').'"'.checked( $showpricerange , true , false ).' />';
					$output .= '<label for="'.$this->get_field_id('showpricerange').'">'. __( ' Show Price Range', 'mppsw' ).'</label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<label for="'.$this->get_field_id('colorskin').'">'.__('Color Skin ', 'mppsw');
						$output .= '<select id="'.$this->get_field_id('colorskin').'" name="'.$this->get_field_name('colorskin').'">';
							$output .= '<option value="grey"'.($colorskin == 'grey' ? ' selected="selected"' : '').'>'.__( 'Grey' , 'mppsw' ).'</option>';
							$output .= '<option value="blue"'.($colorskin == 'blue' ? ' selected="selected"' : '').'>'.__( 'Blue' , 'mppsw' ).'</option>';
							$output .= '<option value="lightblue"'.($colorskin == 'lightblue' ? ' selected="selected"' : '').'>'.__( 'Light Blue' , 'mppsw' ).'</option>';
							$output .= '<option value="green"'.($colorskin == 'green' ? ' selected="selected"' : '').'>'.__( 'Green' , 'mppsw' ).'</option>';
							$output .= '<option value="yellow"'.($colorskin == 'yellow' ? ' selected="selected"' : '').'>'.__( 'Yellow' , 'mppsw' ).'</option>';
							$output .= '<option value="red"'.($colorskin == 'red' ? ' selected="selected"' : '').'>'.__( 'Red' , 'mppsw' ).'</option>';
							$output .= '<option value="black"'.($colorskin == 'black' ? ' selected="selected"' : '').'>'.__( 'Black' , 'mppsw' ).'</option>';
						$output .= '</select>';
					$output .= '</label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<input type="checkbox" class="checkbox" id="'.$this->get_field_id('only_store_pages').'" name="'.$this->get_field_name('only_store_pages').'"'. checked( $only_store_pages , true , false ).' />';
					$output .= '<label for="'.$this->get_field_id('only_store_pages').'">'. __( ' Only show on store pages', 'mppsw' ).'</label>';
				$output .= '</p>';

				echo $output;
			
			}
		}

		// global product search widget class
		class MarketPress_Global_Product_Search_Widget extends WP_Widget {

			function MarketPress_Global_Product_Search_Widget() {
				$widget_ops = array( 'classname' => 'mp_global_product_search_widget', 'description' => __( 'Give your customers the ability to find the product they want across your marketpress network.', 'mppsw' ) );
				$this->WP_Widget('mp_global_product_search_widget', __('Global Product Search Widget', 'mppsw'), $widget_ops);
			}

			function widget( $args, $instance ) {

				if ($instance['only_store_pages'] && !mp_is_shop_page())
					return;

				extract( $args );

				global $mppsw;

				$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Global Product Search', 'mppsw') : $instance['title'], $instance, $this->id_base);
				$showcategory = $instance['showcategory'] ? true : false;
				$showtag = $instance['showtag'] ? true : false;
				$customcategories = !empty($instance['customcategories']) ? $instance['customcategories'] : '';
				$customtags = !empty($instance['customtags']) ? $instance['customtags'] : '';
				$showpricerange = $instance['showpricerange'] ? true : false;
				$colorskin = !empty($instance['colorskin']) ? $instance['colorskin'] : 'grey';
				$btnclass = $mppsw->load_button_color($colorskin);
				$iconclass = $mppsw->load_icon_color($colorskin);
				$spancolor = $mppsw->load_input_span_color($colorskin);

				$widget_settings = array(
						'id' => $this->id,
						'echo' => false,
						'btnclass' => $btnclass,
						'iconclass' => $iconclass,
						'spancolor' => $spancolor,
						'showcategory' => $showcategory,
						'showtag' => $showtag,
						'showpricerange' => $showpricerange,
						'customcategories' => $customcategories,
						'customtags' => $customtags,
						'globalsearch' => true
					);

				echo $before_widget;
				if ( $title )
					echo $before_title . $title . $after_title;

				echo $mppsw->load_search_box( $widget_settings );

				echo $after_widget;
			}

			function update( $new_instance, $old_instance ) {
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['showcategory'] = !empty($new_instance['showcategory']) ? true : false;
				$instance['customcategories'] = stripslashes( wp_filter_nohtml_kses( $new_instance['customcategories'] ) );
				$instance['customtags'] = stripslashes( wp_filter_nohtml_kses( $new_instance['customtags'] ) );
				$instance['showtag'] = !empty($new_instance['showtag']) ? true : false;
				$instance['showpricerange'] = !empty($new_instance['showpricerange']) ? true : false;
				$instance['colorskin'] = !empty($new_instance['colorskin']) ? $new_instance['colorskin'] : 'grey';
				$instance['only_store_pages'] = !empty($new_instance['only_store_pages']) ? true : false;

				return $instance;
			}

			function form( $instance ) {
				//Defaults
				$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'only_store_pages' => 0 ) );
				$title = esc_attr( $instance['title'] );
				$showcategory = isset($instance['showcategory']) ? (bool) $instance['showcategory'] : true;
				$customcategories = !empty($instance['customcategories']) ? $instance['customcategories'] : '';
				$customtags = !empty($instance['customtags']) ? $instance['customtags'] : '';
				$showtag = isset($instance['showtag']) ? (bool) $instance['showtag'] : true;
				$showpricerange = isset($instance['showpricerange']) ? (bool) $instance['showpricerange'] : true;
				$colorskin = !empty($instance['colorskin']) ? $instance['colorskin'] : 'grey';
				$only_store_pages = isset( $instance['only_store_pages'] ) ? (bool) $instance['only_store_pages'] : false;

				$output = '<p style="font-size: 0.85em;font-style: italic;">';
					$output .= '<span style="color: #9e0000;font-weight: bold;">'.__( 'IMPORTANT: ' , 'mppsw' ).'</span>'.__( 'Please read the ' , 'mppsw' ).'<a href="http://www.marketpressthemes.com/blog/tutorial/using-marketpress-product-search-widget/" target="_blank">'.__( 'tutorial' , 'mppsw' ).'</a>'.__( ' first before start using this widget.' , 'mppsw' );
				$output .= '</p>';
			
				$output .= '<p>'; 
					$output .= '<label for="'.$this->get_field_id('title').'">'.__( 'Title:' , 'mppsw' ).'</label>';
					$output .= '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" />';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<input type="checkbox" class="checkbox" id="'.$this->get_field_id('showcategory').'" name="'.$this->get_field_name('showcategory').'"'.checked( $showcategory , true , false ).' />';
					$output .= '<label for="'.$this->get_field_id('showcategory').'">'. __( ' Show Category Filter', 'mppsw' ).'</label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<label for="'.$this->get_field_id('customcategories').'">'.__('Custom Category List:', 'mppsw').'<br />';
					$output .= '<textarea class="widefat" id="'.$this->get_field_id('customcategories').'" name="'.$this->get_field_name('customcategories').'">'.esc_attr($customcategories).'</textarea><br />';
					$output .= '<span style="font-size: 0.85em;font-style: italic;line-height: 0.95em;">'.__( 'Enter only the category slug. The slugs should be separated by comas (ex: cat-1,cat-2,cat-3).' , 'mppsw' ).'</span></label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<input type="checkbox" class="checkbox" id="'.$this->get_field_id('showtag').'" name="'.$this->get_field_name('showtag').'"'.checked( $showtag , true , false ).' />';
					$output .= '<label for="'.$this->get_field_id('showtag').'">'. __( ' Show Tag Filter', 'mppsw' ).'</label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<label for="'.$this->get_field_id('customtags').'">'.__('Custom Tag List:', 'mppsw').'<br />';
					$output .= '<textarea class="widefat" id="'.$this->get_field_id('customtags').'" name="'.$this->get_field_name('customtags').'">'.esc_attr($customtags).'</textarea><br />';
					$output .= '<span style="font-size: 0.85em;font-style: italic;line-height: 0.95em;">'.__( 'Enter only the tag slug. The slugs should be separated by comas (ex: tag-1,tag-2,tag-3).' , 'mppsw' ).'</span></label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<input type="checkbox" class="checkbox" id="'.$this->get_field_id('showpricerange').'" name="'.$this->get_field_name('showpricerange').'"'.checked( $showpricerange , true , false ).' />';
					$output .= '<label for="'.$this->get_field_id('showpricerange').'">'. __( ' Show Price Range', 'mppsw' ).'</label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<label for="'.$this->get_field_id('colorskin').'">'.__('Color Skin ', 'mppsw');
						$output .= '<select id="'.$this->get_field_id('colorskin').'" name="'.$this->get_field_name('colorskin').'">';
							$output .= '<option value="grey"'.($colorskin == 'grey' ? ' selected="selected"' : '').'>'.__( 'Grey' , 'mppsw' ).'</option>';
							$output .= '<option value="blue"'.($colorskin == 'blue' ? ' selected="selected"' : '').'>'.__( 'Blue' , 'mppsw' ).'</option>';
							$output .= '<option value="lightblue"'.($colorskin == 'lightblue' ? ' selected="selected"' : '').'>'.__( 'Light Blue' , 'mppsw' ).'</option>';
							$output .= '<option value="green"'.($colorskin == 'green' ? ' selected="selected"' : '').'>'.__( 'Green' , 'mppsw' ).'</option>';
							$output .= '<option value="yellow"'.($colorskin == 'yellow' ? ' selected="selected"' : '').'>'.__( 'Yellow' , 'mppsw' ).'</option>';
							$output .= '<option value="red"'.($colorskin == 'red' ? ' selected="selected"' : '').'>'.__( 'Red' , 'mppsw' ).'</option>';
							$output .= '<option value="black"'.($colorskin == 'black' ? ' selected="selected"' : '').'>'.__( 'Black' , 'mppsw' ).'</option>';
						$output .= '</select>';
					$output .= '</label>';
				$output .= '</p>';

				$output .= '<p>';
					$output .= '<input type="checkbox" class="checkbox" id="'.$this->get_field_id('only_store_pages').'" name="'.$this->get_field_name('only_store_pages').'"'. checked( $only_store_pages , true , false ).' />';
					$output .= '<label for="'.$this->get_field_id('only_store_pages').'">'. __( ' Only show on store pages', 'mppsw' ).'</label>';
				$output .= '</p>';

				echo $output;
			
			}

		}
	}