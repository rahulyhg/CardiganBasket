<?php

	/* Product Listing functions
	------------------------------------------------------------------------------------------------------------------- */

	function flexmarket_advance_product_sort( $args = array() ) {

		$defaults = array(
			'unique_id' => '',
			'sort' => false,
			'align' => 'align-right',
			'context' => 'list',
			'enablecustomqueries' => false,
			'customqueries' => NULL,
			'echo' => true,
			'paginate' => true,
			'page' => '',
			'per_page' => 9,
			'order_by' => 'date',
			'order' => 'DESC',
			'category' => '',
			'tag' => '',
			's' => '',
			'sentence' => '',
			'exact' => '',
			'counter' => '3',
			'span' => 'span4',
			'btnclass' => '',
			'iconclass' => '',
			'tagcolor' => '',
			'boxclass' => '',
			'boxstyle' => ''
		);

		$instance = wp_parse_args( $args, $defaults );
		extract( $instance );

		$output = '';

		if ($sort) {

			global $mp;

			$mp->start_session();

			if(isset($_POST['advancedsortformsubmitted'.$unique_id])) {

				if ($context == 'list') {
					$_SESSION['advancedsortcategory'.$unique_id] = (!empty($_POST['advancedsortcategory'.$unique_id])) ? esc_html(esc_attr(trim($_POST['advancedsortcategory'.$unique_id]))) : '';
				} else {
					$_SESSION['advancedsortcategory'.$unique_id] = '';
				}
				$_SESSION['advancedsortby'.$unique_id] = (!empty($_POST['advancedsortby'.$unique_id])) ? esc_html(esc_attr(trim($_POST['advancedsortby'.$unique_id]))) : '';
				$_SESSION['advancedsortdirection'.$unique_id] = (!empty($_POST['advancedsortdirection'.$unique_id])) ? esc_html(esc_attr(trim($_POST['advancedsortdirection'.$unique_id]))) : '';
			}

			$category = (!empty($_SESSION['advancedsortcategory'.$unique_id])) ? esc_html(esc_attr(trim($_SESSION['advancedsortcategory'.$unique_id]))) : $category;
			$order_by = (!empty($_SESSION['advancedsortby'.$unique_id])) ? esc_html(esc_attr(trim($_SESSION['advancedsortby'.$unique_id]))) : $order_by;
			$order = (!empty($_SESSION['advancedsortdirection'.$unique_id])) ? esc_html(esc_attr(trim($_SESSION['advancedsortdirection'.$unique_id]))) : $order;

			$output = apply_filters( 'flexmarket_listing_before_advanced_sort' , $output , $instance );

			$output .= '<div id="advanced-sort" class="'.$align.'">';
				$output .= '<a href="#adv-sort" role="button" data-toggle="modal" class="btn btn-large'.$btnclass.'"><i class="icon-th'.$iconclass.'"></i> '.__('Advanced Sort' , 'flexmarket').'</a>';
				$output .= '<div class="clear padding20"></div>';
			$output .= '</div>';

			// Advanced Modal
			$output .= '<div id="adv-sort" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="advancedSort" aria-hidden="true">';
				
				$output .= '<div class="modal-header">';
			    	$output .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
			    	$output .= '<h4>'.__('Advanced Sort' , 'flexmarket').'</h4>';
				$output .= '</div>';

				$output .= '<div class="modal-body">';

					$output .= '<div class="row-fluid">';

						$output .= '<form class="form-horizontal" action="'.$_SERVER["REQUEST_URI"].'#advanced-sort" id="advanced-sort-form" method="post">';

							if ($context == 'list') {

								// By Category   
								$output .= '<div class="input-prepend">';
									$output .= '<span class="add-on">'.__('By Category' , 'flexmarket').':</span>';
									$output .= '<select name="advancedsortcategory'.$unique_id.'" id="advancedsortcategory'.$unique_id.'">';
										$output .= '<option value="">Show All</option>';

											$args = array(
												'taxonomy' => 'product_category',
												'orderby' => 'name',
												'order' => 'ASC'
											  );

											$categories = get_categories($args);

											if  ($categories) {
											  foreach($categories as $cat) {
											    $output .= '<option value="'.$cat->category_nicename.'"'.($cat->category_nicename == $category ? ' selected="selected"' : '').'>'.$cat->name.'</option>';
											  }
											}

									$output .= '</select>';
								$output .= '</div>';

								$output .= '<div class="clear padding10"></div>';

							}

							// Sort By
							$output .= '<div class="input-prepend">';
								$output .= '<span class="add-on">'.__('Sort By' , 'flexmarket').':</span>';
								$output .= '<select name="advancedsortby'.$unique_id.'" id="advancedsortby'.$unique_id.'">';
									$output .= '<option value="date"'.($order_by == 'date' ? ' selected="selected"' : '').'>Release Date</option>';
									$output .= '<option value="title"'.($order_by == 'title' ? ' selected="selected"' : '').'>Name</option>';
									$output .= '<option value="price"'.($order_by == 'price' ? ' selected="selected"' : '').'>Price</option>';
									$output .= '<option value="sales"'.($order_by == 'sales' ? ' selected="selected"' : '').'>Sales</option>';
								$output .= '</select>';
							$output .= '</div>';

							$output .= '<div class="clear padding10"></div>';

							// Sort Direction
							$output .= '<div class="input-prepend">';
								$output .= '<span class="add-on">'.__('Sort Direction' , 'flexmarket').':</span>';
								$output .= '<select name="advancedsortdirection'.$unique_id.'" id="advancedsortdirection'.$unique_id.'">';
									$output .= '<option value="DESC"'.($order == 'DESC' ? ' selected="selected"' : '').'>Descending</option>';
									$output .= '<option value="ASC"'.($order == 'ASC' ? ' selected="selected"' : '').'>Ascending</option>';
								$output .= '</select>';
							$output .= '</div>';

							$output .= '<div class="clear padding10"></div>';

							$output .= '<button type="submit" class="btn'.$btnclass.' advanced-sort-btn pull-right" data-toggle="button"><i class="icon-th'.$iconclass.'"></i> Sort</button>';

							$output .= '<input type="hidden" name="advancedsortformsubmitted'.$unique_id.'" id="advancedsortformsubmitted'.$unique_id.'" value="true" />';

						$output .= '</form>';

				    $output .= '</div>'; // row-fluid

				$output .= '</div>'; // modal body

			$output .= '</div>'; // advanced-sort

			$output = apply_filters( 'flexmarket_listing_after_advanced_sort' , $output , $instance );

		}

		$output = apply_filters( 'flexmarket_listing_before_grid' , $output , $instance );

			$output .= '<div id="mpt-product-grid">';

				$query_args = array(
					'enablecustomqueries' => $enablecustomqueries,
					'customqueries' => $customqueries,
					'echo' => false,
					'paginate' => $paginate,
					'page' => $page,
					'per_page' => $per_page,
					'order_by' => $order_by,
					'order' => $order,
					'category' => $category,
					'tag' => $tag,
					's' => '',
					'sentence' => '',
					'exact' => '',
					'counter' => $counter,
					'span' => $span,
					'btnclass' => $btnclass,
					'iconclass' => $iconclass,
					'tagcolor' => $tagcolor,
					'boxclass' => $boxclass,
					'boxstyle' => $boxstyle
				);

				$output .= flexmarket_list_product_in_grid( $query_args );

			$output .= '</div>';

		$output = apply_filters( 'flexmarket_listing_after_grid' , $output , $instance );

	  	if ($echo)
	    	echo apply_filters( 'func_flexmarket_advance_product_sort' , $output , $instance );
	  	else
	    	return apply_filters( 'func_flexmarket_advance_product_sort' , $output , $instance );

	}

	function flexmarket_list_product_in_grid( $args = array() ) {

		$defaults = array(
			'echo' => true,
			'enablecustomqueries' => false,
			'customqueries' => NULL,
			'paginate' => true,
			'page' => '',
			'per_page' => 9,
			'order_by' => 'date',
			'order' => 'DESC',
			'category' => '',
			'tag' => '',
			's' => '',
			'sentence' => '',
			'exact' => '',
			'counter' => '3',
			'span' => 'span4',
			'btnclass' => '',
			'iconclass' => '',
			'tagcolor' => '',
			'boxclass' => '',
			'boxstyle' => ''
		);

		$instance = wp_parse_args( $args, $defaults );
		extract( $instance );

		global $wp_query, $mp;

		//setup taxonomy if applicable
		if ($category) {
		    $taxonomy_query = '&product_category=' . sanitize_title($category);
		} else if ($tag) {
		    $taxonomy_query = '&product_tag=' . sanitize_title($tag);
		} else if (isset($wp_query->query_vars['taxonomy']) && ($wp_query->query_vars['taxonomy'] == 'product_category' || $wp_query->query_vars['taxonomy'] == 'product_tag')) {
		    $term = get_queried_object(); //must do this for number tags
		    $taxonomy_query = '&' . $term->taxonomy . '=' . $term->slug;
		} else {
		    $taxonomy_query = '';
		}
		  
		//setup pagination
		$paged = false;
		if ($paginate) {
		  	if ($paginate === 'nopagingblock') {
		  		$paginate_query = '&showposts='.intval($per_page);
		  	} else {
		  		$paged = true;	
		  	}
		} else if ($paginate === '') {
		    if ($mp->get_setting('paginate'))
		      	$paged = true;
		    else
		      	$paginate_query = '&nopaging=true';
		} else {
		    $paginate_query = '&nopaging=true';
		}

		//get page details
		if ($paged) {
		    //figure out perpage
		    if (intval($per_page)) {
		      	$paginate_query = '&posts_per_page='.intval($per_page);
		    } else {
		      	$paginate_query = '&posts_per_page='.$mp->get_setting('per_page');
			}

		    //figure out page
		    if (isset($wp_query->query_vars['paged']) && $wp_query->query_vars['paged'])
		      	$paginate_query .= '&paged='.intval($wp_query->query_vars['paged']);

		    if (intval($page))
		      	$paginate_query .= '&paged='.intval($page);
		    else if ($wp_query->query_vars['paged'])
		      	$paginate_query .= '&paged='.intval($wp_query->query_vars['paged']);
		 }

		//get order by
		if (!$order_by) {
		    if ($mp->get_setting('order_by') == 'price')
		      	$order_by_query = '&meta_key=mp_price_sort&orderby=meta_value_num';
		    else if ($mp->get_setting('order_by') == 'sales')
		      	$order_by_query = '&meta_key=mp_sales_count&orderby=meta_value_num';
		    else
		      	$order_by_query = '&orderby='.$mp->get_setting('order_by');
		} else {
		  	if ('price' == $order_by)
		  		$order_by_query = '&meta_key=mp_price_sort&orderby=meta_value_num';
		    else if('sales' == $order_by)
		      $order_by_query = '&meta_key=mp_sales_count&orderby=meta_value_num';
		    else
		    	$order_by_query = '&orderby='.$order_by;
		}

		//get order direction
		if (!$order) {
		    $order_query = '&order='.$mp->get_setting('order');
		} else {
		    $order_query = '&order='.$order;
		}

		//The Query
		if ( $enablecustomqueries && !empty($customqueries) ) {
			$the_query = $customqueries;
		} else {
			$the_query = new WP_Query('post_type=product&post_status=publish' . $taxonomy_query . $paginate_query . $order_by_query . $order_query);
		}

		$output = '<div class="row-fluid">';

		$count = 1;

		if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();

		  	$id = get_the_ID();

			$product_args = array(
				'echo' => false,
				'post_id' => $id,
				'span' => $span,
				'imagesize' => 'tb-360',
				'btnclass' => $btnclass,
				'iconclass' => $iconclass,
				'tagcolor' => $tagcolor,
				'class' => $boxclass,
				'style' => $boxstyle
			);

			$output .= flexmarket_load_single_product_in_box( $product_args );
			
			if ($count == $counter) {
				
				$count = 0;
				$output .= '</div>';
				$output .= '<div class="clear padding20"></div>';
				$output .= '<div class="row-fluid">';
			}

			$count++;

		endwhile; endif;

		$output .= '</div>';

		// load pagination
		if ($paged) {

		  	$output .= '<div class="clear"></div>';
			$output .= '<div class="pull-right">';

			    $total_pages = $the_query->max_num_pages;  

			    if ($total_pages > 1){ 

			      $current_page = max(1, get_query_var('paged')); 

			       $output .= '<div class="pagination">';
			       $output .= paginate_links(array(  
			          'base' => get_pagenum_link(1) . '%_%',  
			          'format' => 'page/%#%',  
			          'current' => $current_page,  
			          'total' => $total_pages,  
			          'prev_text'    => __('« Previous' , 'flexmarket'),
					  'next_text'    => __('Next »' , 'flexmarket'),
			          'type'  => 'list'
			        ));  
			       $output .= '</div>';
			    }

			$output .= '</div>';

		}

		$output .= wp_reset_query();
		$output .= '<div class="clear padding20"></div>';

	  	if ($echo)
	    	echo apply_filters( 'func_flexmarket_list_product_in_grid' , $output , $instance );
	  	else
	    	return apply_filters( 'func_flexmarket_list_product_in_grid' , $output , $instance );

	}

	function flexmarket_load_single_product_in_box( $args = array() ) {

		$defaults = array(
			'echo' => true,
			'post_id' => NULL,
			'span' => 'span4',
			'imagesize' => 'tb-360',
			'btnclass' => '',
			'iconclass' => '',
			'tagcolor' => '',
			'class' => '',
			'style' => ''
		);

		$instance = wp_parse_args( $args, $defaults );
		extract( $instance );

  		global $id, $mp;
  		$post_id = ( NULL === $post_id ) ? $id : $post_id;

		if (is_multisite()) {
			$blog_id = get_current_blog_id();
		} else {
			$blog_id = 1;
		}

		if ($class == 'thetermsclass') {
			$class = '';
		  	$terms = get_the_terms( $post_id, 'product_category' );
			if (!empty($terms)) {
				foreach ($terms as $thesingleterm) {
					$class .= ' '.$thesingleterm->slug;
				}
			}
		}

		switch ($span) {
			case 'span6':
				$maxwidth = '560';
				$imagesize = 'tb-860';
				$btnsize = '';
				break;
			case 'span3':
				$maxwidth = '360';
				$btnsize = ' btn-small';
				break;
			case 'span4':
				$maxwidth = '360';
				$btnsize = '';
				break;
		}

		$output = '<div class="'.$span.' well well-small'.$class.'"'.$style.'>';

		$fullimage = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full');

		$output = apply_filters('flexmarket_product_box_before_image' , $output , $instance );
		$output .= '<div class="image-box" style="max-width: '.$maxwidth.'px;">';
		$output .= '<a href="'.get_permalink( $post_id ).'">' . ( has_post_thumbnail( $post_id ) ? get_the_post_thumbnail($post_id , $imagesize) : '<img src="'.apply_filters('mp_default_product_img', $mp->plugin_url . 'images/default-product.png').'" class="mp_default_product_image" />' ) . '</a>'; 
			$output .= '<div class="hover-block hidden-phone">';
					$output .= '<div class="btn-group">';
						$button = '<a href="'.get_permalink($post_id).'" class="btn'.$btnclass.'">'.get_the_title($post_id).'</a>';
						$button .= '<a href="'.$fullimage[0].'" rel="prettyPhoto[mp-product-'.$post_id.'" class="btn'.$btnclass.'"><i class="icon-zoom-in'.$iconclass.'"></i></a>';
						$output .= apply_filters( 'flexmarket_product_box_btn_group' , $button , $instance );
					$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		$output = apply_filters('flexmarket_product_box_after_image' , $output , $instance );

		$output .= '<div class="clear padding5"></div>';

			$output .= '<div class="hidden-phone">';
				$output .= '<div class="product-meta row-fluid">';
					$output .= '<div class="span6">';
					$output .= '<p>';
					$output .= ($span == 'span3' ? '<small>' : '');
					$output .= flexmarket_product_price(false, $post_id, '' , $tagcolor);
					$output .= ($span == 'span3' ? '</small>' : '');
					$output .= '</p>';
					$output .= '</div>';
					$output .= '<div class="span6 atc">';
					$output .= flexmarket_buy_button(false, 'list', $post_id, $btnclass.$btnsize , $iconclass);
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="visible-phone align-center">';

				$output .= '<p>';
				$output .= apply_filters( 'flexmarket_product_box_title_mobile' , get_the_title($post_id) . '<br />' , $instance );
				$output .= flexmarket_product_price(false, $post_id, '' , $tagcolor);
				$output .= '</p>';
				$output .= flexmarket_buy_button(false, 'list', $post_id, $btnclass, $iconclass);

			$output .= '</div>';	

		$output .= '</div>';

	  	if ($echo)
	    	echo apply_filters( 'func_flexmarket_load_single_product_in_box' , $output , $instance );
	  	else
	    	return apply_filters( 'func_flexmarket_load_single_product_in_box' , $output , $instance );
		
	}


	/* Buy Button
	------------------------------------------------------------------------------------------------------------------- */

	function flexmarket_buy_button( $echo = true, $context = 'list', $post_id = NULL , $btnclass = '' ) {

		$instance = array(
			'echo' => $echo,
			'context' => $context,
			'post_id' => $post_id,
			'btnclass' => $btnclass
		);

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

		    $button = '<a class="btn'.$btnclass.'" href="' . esc_url($product_link) . '">' . __('Buy Now', 'flexmarket') . '</a>';

		} else if ($mp->get_setting('disable_cart')) {
		    
		    $button = '';
		    
		} else {
		    $variation_select = '';
		    $button = '<form class="mp_buy_form'.($context == 'list' ? '' : ' form-inline').'" method="post" action="' . mp_cart_link(false, true) . '">';

		    if ($all_out) {
		      	$button .= '<span class="mp_no_stock btn disabled'.$btnclass.'">' . __('Out of Stock', 'flexmarket') . '</span>';
		    } else {

			    $button .= '<input type="hidden" name="product_id" value="' . $post_id . '" />';

				//create select list if more than one variation
				if (is_array($meta["mp_price"]) && count($meta["mp_price"]) > 1 && empty($meta["mp_file"])) {
			      	$variation_select = '<select class="mp_product_variations" name="variation">';
					foreach ($meta["mp_price"] as $key => $value) {
					  	$disabled = (in_array($key, $no_inventory)) ? ' disabled="disabled"' : '';
					  	$variation_select .= '<option value="' . $key . '"' . $disabled . '>' . esc_html($meta["mp_var_name"][$key]) . ' - ';
						if ($meta["mp_is_sale"] && $meta["mp_sale_price"][$key]) {
			        		$variation_select .= $mp->format_currency('', $meta["mp_sale_price"][$key]);
			    		} else {
			        		$variation_select .= $mp->format_currency('', $value);
			      		}
			      		$variation_select .= "</option>\n";
			    	}
			      	$variation_select .= "</select>&nbsp;\n";
			 	} else {
			      	$button .= '<input type="hidden" name="variation" value="0" />';
				}

			    if ($context == 'list') {
				    if ($variation_select) {
			        	$button .= '<a href="' . get_permalink($post_id) . '" class="btn'.$btnclass.'">' . __('Choose Option', 'flexmarket') . '</a>';
				    } else if ($mp->get_setting('list_button_type') == 'addcart') {
				        $button .= '<input type="hidden" name="action" value="mp-update-cart" />';
				        $button .= '<input class="mp_button_addcart btn'.$btnclass.'" type="submit" name="addcart" value="' . __('Add To Cart', 'flexmarket') . '" />';
				    } else if ($mp->get_setting('list_button_type') == 'buynow') {
				        $button .= '<input class="mp_button_buynow btn'.$btnclass.'" type="submit" name="buynow" value="' . __('Buy Now', 'flexmarket') . '" />';
				    }
			    } else {

			      	$button .= $variation_select;

			      	//add quantity field if not downloadable
			      	if ($mp->get_setting('show_quantity') && empty($meta["mp_file"])) {
			        	$button .= '<span class="mp_quantity"><label>' . __('Quantity:', 'flexmarket') . ' <input class="mp_quantity_field input-mini" type="text" name="quantity" value="1" /></label></span>&nbsp;';
			      	}

			      	if ($mp->get_setting('product_button_type') == 'addcart') {
			        	$button .= '<input type="hidden" name="action" value="mp-update-cart" />';
			        	$button .= '<input class="mp_button_addcart btn'.$btnclass.'" type="submit" name="addcart" value="' . __('Add To Cart', 'flexmarket') . '" />';
			      	} else if ($mp->get_setting('product_button_type') == 'buynow') {
			        	$button .= '<input class="mp_button_buynow btn'.$btnclass.'" type="submit" name="buynow" value="' . __('Buy Now', 'flexmarket') . '" />';
			      	}
			    }

		    }

		    $button .= '</form>';
		}

		if ($echo)
		    echo apply_filters( 'flexmarket_buy_button_tag', $button, $instance );
		else
		    return apply_filters( 'flexmarket_buy_button_tag', $button, $instance );
	}


	/* Product price
	------------------------------------------------------------------------------------------------------------------- */

	function flexmarket_product_price( $echo = true, $post_id = NULL, $label = true , $iconclass = '' , $context = '' ) {

		$instance = array(
			'echo' => $echo,
			'context' => $context,
			'post_id' => $post_id,
			'label' => $label,
			'iconclass' => $iconclass
		);

		global $id, $mp;
		$post_id = ( NULL === $post_id ) ? $id : $post_id;

		$label = ($label === true) ? __('Price: ', 'flexmarket') : $label;

		$meta = get_post_custom($post_id);
	  	//unserialize
	  	foreach ($meta as $key => $val) {
		  	$meta[$key] = maybe_unserialize($val[0]);
		  	if (!is_array($meta[$key]) && $key != "mp_is_sale" && $key != "mp_track_inventory" && $key != "mp_product_link" && $key != "mp_file" && $key != "mp_price_sort")
		    	$meta[$key] = array($meta[$key]);
		}

		if ((is_array($meta["mp_price"]) && count($meta["mp_price"]) == 1) || !empty($meta["mp_file"])) {
		    if ($meta["mp_is_sale"]) {
			    $price = '<span class="mp_special_price"><del class="mp_old_price">'.$mp->format_currency('', $meta["mp_price"][0]).'</del> ';
			    $price .= '<span itemprop="price" class="mp_current_price">'.$mp->format_currency('', $meta["mp_sale_price"][0]).'</span></span>';
			} else {
			    $price = '<span itemprop="price" class="mp_normal_price"><span class="mp_current_price">'.$mp->format_currency('', $meta["mp_price"][0]).'</span></span>';
			}
		} else if (is_array($meta["mp_price"]) && count($meta["mp_price"]) > 1 && !is_singular('product')) { //only show from price in lists
			if ($meta["mp_is_sale"]) {
		        //do some crazy stuff here to get the lowest price pair ordered by sale prices
		      	asort($meta["mp_sale_price"], SORT_NUMERIC);
		      	$lowest = array_slice($meta["mp_sale_price"], 0, 1, true);
		      	$keys = array_keys($lowest);
		      	$mp_price = $meta["mp_price"][$keys[0]];
		     	$mp_sale_price = array_pop($lowest);
			    $price = __('From', 'flexmarket').' <span class="mp_special_price"><del class="mp_old_price">'.$mp->format_currency('', $mp_price).'</del>';
			    $price .= '<span itemprop="price" class="mp_current_price">'.$mp->format_currency('', $mp_sale_price).'</span></span>';
			} else {
			    sort($meta["mp_price"], SORT_NUMERIC);
				$price = __('From', 'flexmarket').' <span itemprop="price" class="mp_normal_price"><span class="mp_current_price">'.$mp->format_currency('', $meta["mp_price"][0]).'</span></span>';
			}
		} else {
			if ($context == 'widget') {
			    if ($meta["mp_is_sale"]) {
			        //do some crazy stuff here to get the lowest price pair ordered by sale prices
			      	asort($meta["mp_sale_price"], SORT_NUMERIC);
			      	$lowest = array_slice($meta["mp_sale_price"], 0, 1, true);
			      	$keys = array_keys($lowest);
			      	$mp_price = $meta["mp_price"][$keys[0]];
			     	$mp_sale_price = array_pop($lowest);
				    $price = __('From', 'flexmarket').' <span class="mp_special_price"><del class="mp_old_price">'.$mp->format_currency('', $mp_price).'</del>';
				    $price .= '<span itemprop="price" class="mp_current_price">'.$mp->format_currency('', $mp_sale_price).'</span></span>';
				} else {
			      	sort($meta["mp_price"], SORT_NUMERIC);
				    $price = __('From', 'flexmarket').' <span itemprop="price" class="mp_normal_price"><span class="mp_current_price">'.$mp->format_currency('', $meta["mp_price"][0]).'</span></span>';
				}
			} else {
				return '';
			}
		}

		if ($echo)
		    echo apply_filters( 'flexmarket_product_price_tag', '<i class="icon-tags'.$iconclass.'"></i> ' . $label . $price , $instance );
		else
		    return apply_filters( 'flexmarket_product_price_tag', '<i class="icon-tags'.$iconclass.'"></i> ' . $label . $price , $instance );
	}

	/* Related Products
	------------------------------------------------------------------------------------------------------------------- */

	add_filter( 'mp_related_products' , 'flexmarket_related_products' , 15 , 5 );

	function flexmarket_related_products( $output = '' , $product_id = NULL , $in_same_category = NULL , $limit = NULL , $simple_list = NULL ) {

		global $mp, $post;
		
		$categories = array();
		$simple_list = ( is_null( $simple_list ) ? $mp->get_setting('related_products->simple_list') : ( $simple_list == 'true' ? true : false ) );

		if ( $simple_list )
			return $output;

		$same_category = ( is_null( $in_same_category ) ) ? $mp->get_setting('related_products->in_same_category') : ( $in_same_category == 'true') ? true : false;
		
		$limit = (!$limit) ? $mp->get_setting('related_products->show_limit') : $limit;
		
		if( !$product_id ) {
			$product_id = ( isset($post) && $post->post_type == 'product' ? $post->ID : false );
			$product_details = get_post($product_id);
		} else {
			$product_details = get_post($product_id);
		}
		
		if(!$product_details)
			return '';	
		
		//setup the default args
		$query_args = array(
			'post_type' 	 => 'product',
			'posts_per_page' => intval($limit),
			'post__not_in' 	 => array($product_id),
			'tax_query' 	 => array(), //we'll add these later
		);
		
		//get the tags for this product
		$tags = get_the_terms( $product_id, 'product_tag');
		$tag_list = array();
		
		if( $tags ) {
			$tag_list = array();
			foreach($tags as $tag) {
				$tag_list[] = $tag->term_id;
			}
			//add the tag taxonomy query
			$query_args['tax_query'][] = array(
					'taxonomy' => 'product_tag',
					'field' => 'id',
					'terms' => $tag_list,
					'operator' => 'IN'
			);
		}
		
		//are we limiting to only the assigned categories
		if( $same_category ) {
			$product_cats = get_the_terms( $product_id, 'product_category' );
			if($product_cats) {
				foreach($product_cats as $cat) {
					$categories[] = $cat->term_id;
				}
				
				$query_args['tax_query'][] = array(
						'taxonomy' => 'product_category',
						'field' => 'id',
						'terms' => $categories,
						'operator' => 'IN'
				);
				
			}
		}

		if( count($tag_list) > 0 || count($categories) > 0 ) {
			//make the query
			$related_query = new WP_Query( $query_args );
			
			//we'll use the $mp settings and functions
			$layout_type = $mp->get_setting('list_view');
			$output = '<div id="mp_related_products" class="mp_' . $layout_type . '">';
			//do we have posts?
			if( $related_query->post_count ) {
				$output .= '<div class="mp_related_products_title"><h4>' . apply_filters( 'mp_related_products_title', __('Related Products','flexmarket') ) . '</h4></div>';
				$output .= flexmarket_advance_product_sort( array(
					'echo' => false,
					'enablecustomqueries' => true,
					'customqueries' => $related_query,
					'paginate' => false,
					'btnclass' => mpt_load_mp_btn_color(),
					'tagcolor' => mpt_load_icontag_color(),
					) );
			} else {
				$output .= '<div class="mp_related_products_title"><h4>'. apply_filters( 'mp_related_products_title_none', __('No Related Products','flexmarket') ) . '</h4></div>';
			}
	
			$output .= '</div>';
		}

		return $output;
	}