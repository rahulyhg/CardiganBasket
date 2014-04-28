<?php

	function flexmarket_display_wp_post_query( $args = array() ) {

	  	$defaults = array(
			'echo' => true,
			'paginate' => true,
			'page' => '', 
			'per_page' => '', 
			'order_by' => 'date', 
			'order' => 'DESC',
			'searchterms' => '',
			'category' => '', 
			'tag' => '',
			'author' => '',
			'day' => '',
			'month' => '',
			'year' => '',
			'columns' => '1col',
			'imagesize' => 'full',
			'btnclass' => '',
			'iconclass' => '',
			'boxclass' => '',
			'boxstyle' => ''
		);

	  	$instance = wp_parse_args( $args, $defaults );
	  	extract( $instance );

	  	if ( $columns == '2col' || $columns == '3col' ) {
	  		wp_enqueue_script( 'jquery-masonry' );
	  		add_action('wp_footer' , 'flexmarket_add_blog_related_js');
	  	}

	  	$per_page = !empty($per_page) ? $per_page : get_option('posts_per_page');

		if ( empty($page) && get_query_var('paged') ) {
			$page = intval(get_query_var('paged'));
		} elseif ( empty($page) && get_query_var('page') ) {
			$page = intval(get_query_var('page'));
		} elseif ( empty($page) ) {
			$page = 1;
		}

		  //setup taxonomy if applicable
		if ($category) {
		    $taxonomy_query = '&cat=' . sanitize_title($category);
		} else if ($tag) {
		    $taxonomy_query = '&tag=' . sanitize_title($tag);
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
		} else {
		    $paginate_query = '&nopaging=true';
		}

		  //get page details
		if ($paged) {
		    //figure out perpage
		    if (intval($per_page)) {
		      $paginate_query = '&posts_per_page='.intval($per_page);
			} else {
		      $paginate_query = '&posts_per_page='.get_option('posts_per_page');
			}

			if ($page) {
				$paginate_query .= '&paged='.intval($page);
			} else {
				$paginate_query .= '&paged=1';
			}
		}

	  	// get search
		if ( !empty($searchterms) ) {
			$search_query = '&s=' . esc_attr( $searchterms );
		} else {
			$search_query = '';
		}

		$author_query = !empty($author) ? '&author_name=' . esc_attr($author) : '';
		$day_query = !empty($day) ? '&day=' . esc_attr($day) : '';
		$month_query = !empty($month) ? '&monthnum=' . esc_attr($month) : '';
		$year_query = !empty($year) ? '&year=' . esc_attr($year) : '';

		//get order by
		$order_by_query = '&orderby='.esc_attr($order_by);

		//get order direction
		$order_query = '&order='.esc_attr($order);

		//The Query
		$the_query = new WP_Query( 'post_type=post&post_status=publish' . $taxonomy_query . $paginate_query . $order_by_query . $order_query . $search_query . $author_query . $year_query . $month_query . $day_query);

		// load pagination
		if ($paged) {

		  	$paginate_output = '<div class="clear"></div>';
			$paginate_output .= '<div class="pull-right">';

			    $total_pages = $the_query->max_num_pages;  

			    if ($total_pages > 1){ 

			    	if ( get_query_var('paged') ) {
			    		$current_page = max(1, get_query_var('paged') ); 
			    	} elseif ( get_query_var('page') ) {
			    		$current_page = max(1, get_query_var('page') ); 
			    	} else {
			    		$current_page = 1;
			    	}

			    	if ( is_home() || is_front_page() ) {
			    		$paginate_links_query = 'base='.get_home_url().'%_%&current=' . $current_page .'&total=' . $total_pages . '&type=list';
			    	} else {
			    		$paginate_links_query = 'base='.get_pagenum_link(1).'%_%&format=page/%#%&current=' . $current_page .'&total=' . $total_pages . '&type=list&prev_text='.__('« Previous' , 'flexmarket').'&next_text=' . __('Next »' , 'flexmarket');
			    	}

				    $paginate_output .= '<div class="pagination">';
				    	$paginate_output .= paginate_links( $paginate_links_query );
			       	$paginate_output .= '</div>';
			    }

			$paginate_output .= '</div>';

	  	} else {
	  		$paginate_output = '';
	  	}

		$output = '<div id="flexmarket-wp-posts"'.( $columns == '2col' || $columns == '3col' ? ' class="span-box-container"' : '' ).'>';

			if ($the_query->have_posts()) : 

				while ($the_query->have_posts()) : $the_query->the_post();

					$post_id = get_the_ID();

				  	$single_args = array(
						'echo' => false,
						'post_id' => $post_id,
						'imagesize' => $imagesize,
						'columns' => $columns,
						'btnclass' => $btnclass,
						'iconclass' => $iconclass,
						'class' => $boxclass,
						'style' => $boxstyle
					);

					$output .= flexmarket_load_wp_single_post( $single_args );

				endwhile;

			else :

				// If nothing found
				$output .= '<h2>'.__( 'Nothing Found.' , 'flexmarket' ).'</h2>';
				$output .= '<p>' . __('Perhaps try one of the links below:' , 'flexmarket' ) . '</p>';
				$output .= '<div class="padding10"></div>';
					$output .= '<h4>' . __( 'Most Used Categories' , 'flexmarket' ) . '</h4>';
					$output .= '<ul>';
						$output .= wp_list_categories( array( 'taxonomy' => 'category' , 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 , 'echo' => 0 ) );
					$output .= '</ul>';
				$output .= '<div class="padding20"></div>';
				//$output .= '<p>' . __( 'Or, use the search box below:' , 'flexmarket' ) . '</p>';
				//$output .= get_search_form( false );
				//$output .= '<div class="padding20"></div>';
				
			endif;
			wp_reset_query();
		  	$output .= '<div class="clear"></div>';

		$output .= '</div>'; // End - flexmarket-wp-posts

		$output .= $paginate_output;

	  	$output .= '<div class="clear"></div>';


	  	if ($echo)
	    	echo $output;
	  	else
	    	return $output;		
	}

	function flexmarket_load_wp_single_post( $args = array() ) {

	  	$defaults = array(
			'echo' => true,
			'post_id' => NULL,
			'columns' => '1col',
			'imagesize' => 'full',
			'btnclass' => '',
			'iconclass' => '',
			'class' => '',
			'style' => ''
		);

	  	$instance = wp_parse_args( $args, $defaults );
	  	extract( $instance );

	  	$post = get_post( $post_id );
	  	$comments = $post->comment_count == 0 ? __( 'No comments' , 'flexmarket' ) : ( $post->comment_count > 1 ? $post->comment_count . __(' comments' , 'flexmarket' ) : __( '1 comment' , 'flexmarket' ) );
	  	$temp = get_post_meta( $post_id , '_mpt_post_select_temp', true );

		$year  = get_the_time('Y' , $post_id); 
		$month = get_the_time('M' , $post_id); 
		$day   = get_the_time('j' , $post_id);

		$style = ( !empty($style) ? ' style="'.esc_attr($style).'"' : '' );
		$class = ( !empty($class) ? ' '.esc_attr($class) : '' );

		if ( has_post_thumbnail($post_id) || $temp == 'video' ) {
			// featured image(s)
			$featured = '<div class="'.( $columns == '1col' ? 'span5 ' : '' ).'align-center">';

			$featured_args = array(
				'echo' => false,
				'post_id' => $post_id,
				'content_type' => 'list',
				'prettyphoto' => false,
				'imagesize' => ( $columns == '2col' || $columns == '3col' ? 'tb-860' : 'tb-360' ),
				'videoheight' => 195,
				'btnclass' => '',
				'iconclass' => '',
			); 

			if ($temp == 'image-carousel') {
				$featured .= mpt_load_image_carousel( $featured_args );
			} else if ($temp == 'video') {
				$featured .= mpt_load_video_post( $featured_args );
			} else {
				$featured .= mpt_load_featured_image( $featured_args );
			}
									
			$featured .= '</div>'; // End - span	  	
			$featured .= '<div class="clear padding10'.( $columns == '1col' ? ' visible-phone' : '' ).'"></div>';

		} else {
			$featured = '';
		}
		
		$output = ( $columns == '2col' ? '<div class="span-box span-2x">' : ( $columns == '3col' ? '<div class="span-box span-3x">' : '' ) );

		  	$output .= '<div class="well blog-post btn-color-skin-parent'.$class.'"'.$style.'>';

		  		$output .= $columns == '2col' || $columns == '3col' ? $featured : '';

		  		$output .= '<div class="row-fluid">';

					// date
					$output .= '<div class="'.( $columns == '2col' || $columns == '3col' ? 'span3 ' : 'span2 ' ).'align-center">';
						$output .= '<div class="date">';
							$output .= '<span class="month">' . $month . '</span><div class="clear"></div><span class="day">' . $day . '</span><div class="clear"></div><span class="year">' . $year . '</span>';
						$output .= '</div>';
						$output .= '<div class="comments"><a href="' . get_comments_link( $post_id ) . '">' . $comments . '</a></div>';
					$output .= '</div>'; // End - span

					$output .= '<div class="clear padding10 visible-phone"></div>';

		  			$output .= $columns == '1col' ? $featured : '';

		  			// contents
		  			$output .= '<div class="span'.( $columns == '1col' ? ( has_post_thumbnail($post_id) || $temp == 'video' ? '5' : '10' ) : '9' ).'">';
						$output .= '<a href="' . get_permalink( $post_id ) . '"><h3 class="post-title">' . get_the_title( $post_id ) . '</h3></a>';
						
						$output .= '<div class="post-meta">';
							$output .= '<span>Posted By <a href="'.get_author_posts_url( $post->post_author ).'">'.get_the_author_meta( 'display_name' , $post->post_author ).'</a>' . ' In '  . ( $post->post_type == 'product' ? get_the_term_list( $post_id , 'product_category' , '' , ' | ' , '' ) . get_the_term_list( $post_id , 'product_tag' , ' | ' , ' | ' , '' ) : get_the_category_list( ' | ' , '' , $post_id ) . get_the_tag_list( ' | ' , ' | ' , '' ) ) .  '</span>';
						$output .= '</div>';

						$output .= '<div class="clear padding5"></div>';

						$output .= '<div class="post-excerpt">' . ( !empty($post->post_excerpt) ? $post->post_excerpt : ( !empty($post->post_content) ? wp_trim_words($post->post_content , 45 ) : '' ) ) . '</div>';

						$output .= '<div class="align-right">';
							$output .= '<a href="' . get_permalink( $post_id ) . '">';
								$output .= '<button class="btn btn-12-19'.( !empty($btnclass) ? $btnclass : ' btn-color-skin' ).' hidden-phone" type="button">Read More &raquo;</button>';
								$output .= '<button class="btn btn-block btn-block-20'.( !empty($btnclass) ? $btnclass : ' btn-color-skin' ).' visible-phone" type="button">Read More &raquo;</button>';
							$output .= '</a>';
						$output .= '</div>';

		  			$output .= '</div>'; // End - span	

		  		$output .= '</div>'; // End - row-fluid

		  	$output .= '</div>'; // End - blog-post

		$output .= ( $columns == '2col' || $columns == '3col' ? '</div>' : '' ); // End - span-box  	

	  	if ($echo)
	    	echo apply_filters( 'func_flexmarket_load_wp_single_post' , $output , $instance );
	  	else
	    	return apply_filters( 'func_flexmarket_load_wp_single_post' , $output , $instance );
	}

	function flexmarket_add_blog_related_js() {

		$output = '<script type="text/javascript">
						jQuery(document).ready(function () {
					    	jQuery("#flexmarket-wp-posts").imagesLoaded( function(){
							  	jQuery(this).masonry({
							    	itemSelector : ".span-box"
							  	});
							});
						});
					</script>';

	 	echo apply_filters( 'flexmarket_add_blog_related_js' , $output );
	}