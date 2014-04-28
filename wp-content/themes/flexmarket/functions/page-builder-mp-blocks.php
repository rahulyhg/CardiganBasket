<?php 

	/* AQ_MP_Product_Grid_Block
	------------------------------------------------------------------------------------------------------------------- */

	class AQ_MP_Product_Grid_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => __('[MP] Product Grid','flexmarket'),
				'size' => 'span12',
			);
			
			//create the block
			parent::__construct('aq_mp_product_grid_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'layout' => '3col',
				'entries' => '9',
				'showcategory' => 'no',
				'showpagination' => 'no',
				'align' => 'align-center',
				'order_by' => 'date', 
				'arrange' => 'DESC',
				'taxonomy_type' => 'none',
				'taxonomy' => '',
				'bgcolor' => '#fff',
				'btncolor' => 'yellow',
				'iconcolor' => 'black',
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$layout_options = array(
				'2col' => __('2 Columns','flexmarket'),
				'3col' => __('3 Columns','flexmarket'),
				'4col' => __('4 Columns','flexmarket')
			);

			$btncolor_options = array(
				'grey' => __('Grey','flexmarket'),
				'blue' => __('Blue','flexmarket'),
				'lightblue' => __('Light Blue','flexmarket'),
				'green' => __('Green','flexmarket'),
				'red' => __('Red','flexmarket'),
				'yellow' => __('Yellow','flexmarket'),
				'black' => __('Black','flexmarket'),
			);

			$iconcolor_options = array(
				'grey' => __('Grey','flexmarket'),
				'blue' => __('Blue','flexmarket'),
				'lightblue' => __('Light Blue','flexmarket'),
				'green' => __('Green','flexmarket'),
				'red' => __('Red','flexmarket'),
				'yellow' => __('Yellow','flexmarket'),
				'black' => __('Black','flexmarket'),
			);

			$taxonomy_type_options = array(
				'none' => __('No Filter','flexmarket'),
				'category' => __('Category','flexmarket'),
				'tag' => __('Tag','flexmarket'),
			);

			$showcategory_options = array(
				'yes' => __('Show Category Menu','flexmarket'),
				'advsoft' => __('Show Advanced Sort Button','flexmarket'),
				'no' => __('Nothing','flexmarket'),
			);

			$showpagination_options = array(
				'yes' => __('Yes','flexmarket'),
				'no' => __('No','flexmarket'),
			);

			$align_options = array(
				'align-left' => __('Align Left','flexmarket'),
				'align-center' => __('Align Center','flexmarket'),
				'align-right' => __('Align Right','flexmarket'),
			);

			$order_by_options = array(
				'title' => __('Product Name','flexmarket'),
				'date' => __('Publish Date','flexmarket'),
				'ID' => __('Product ID','flexmarket'),
				'author' => __('Product Author','flexmarket'),
				'sales' => __('Number of Sales','flexmarket'),
				'price' => __('Product Price','flexmarket'),
				'rand' => __('Random','flexmarket'),
			);

			$order_options = array(
				'DESC' => __('Descending','flexmarket'),
				'ASC' => __('Ascending','flexmarket'),
			);

			do_action( $id_base . '_before_form' , $instance );
			
			?>

			<div class="description third">
				<label for="<?php echo $this->get_field_id('layout') ?>">
					<?php _e('Layout', 'flexmarket') ?><br/>
					<?php echo aq_field_select('layout', $block_id, $layout_options, $layout); ?>
				</label>
			</div>

			<div class="description third">
				<label for="<?php echo $this->get_field_id('entries') ?>">
					<?php _e('Number of Entries (per page)', 'flexmarket') ?><br/>
					<?php echo aq_field_input('entries', $block_id, $entries) ?>
				</label>
			</div>

			<div class="description third last">
				<label for="<?php echo $this->get_field_id('showpagination') ?>">
					<?php _e('Show Pagination', 'flexmarket') ?><br/>
					<?php echo aq_field_select('showpagination', $block_id, $showpagination_options, $showpagination); ?>
				</label>
			</div>

			<div class="description half">
				<label for="<?php echo $this->get_field_id('showcategory') ?>">
					<?php _e('Additional Functions', 'flexmarket') ?><br />
					<?php echo aq_field_select('showcategory', $block_id, $showcategory_options, $showcategory); ?>
				</label><div class="cf"></div>
				<label for="<?php echo $this->get_field_id('align') ?>">
				<?php echo aq_field_select('align', $block_id, $align_options, $align); ?>
				</label>
			</div>
			
			<div class="description half last">
				<label for="<?php echo $this->get_field_id('taxonomyfilter') ?>">
					<?php _e('Taxonomy Filter:', 'flexmarket') ?><br />
					<?php echo aq_field_select('taxonomy_type', $block_id, $taxonomy_type_options, $taxonomy_type); ?> <?php echo aq_field_input('taxonomy', $block_id, $taxonomy, $size = 'full') ?>
				</label>
			</div>

			<div class="description half">
				<label for="<?php echo $this->get_field_id('order_by') ?>">
					<?php _e('Order Products By:', 'flexmarket') ?><br />
					<?php echo aq_field_select('order_by', $block_id, $order_by_options, $order_by); ?>
				</label>
			</div>	

			<div class="description half last">
				<label for="<?php echo $this->get_field_id('arrange') ?>">
					<br />
					<?php echo aq_field_select('arrange', $block_id, $order_options, $arrange); ?>
				</label>
			</div>	

			<div class="description third">
				<label for="<?php echo $this->get_field_id('bgcolor') ?>">
					<?php _e('Pick a background color', 'flexmarket') ?><br/>
					<?php echo aq_field_color_picker('bgcolor', $block_id, $bgcolor) ?>
				</label>
			</div>

			<div class="description third">
				<label for="<?php echo $this->get_field_id('btncolor') ?>">
					<?php _e('Button Color', 'flexmarket') ?><br/>
					<?php echo aq_field_select('btncolor', $block_id, $btncolor_options, $btncolor); ?>
				</label>
			</div>

			<div class="description third last">
				<label for="<?php echo $this->get_field_id('iconcolor') ?>">
					<?php _e('Icon Color', 'flexmarket') ?><br/>
					<?php echo aq_field_select('iconcolor', $block_id, $iconcolor_options, $iconcolor); ?>
				</label>
			</div>
			
			<?php

			do_action( $id_base . '_after_form' , $instance );
		}
		
		function block($instance) {
			extract($instance);

			$entries = intval($entries);
			$pagination = !empty($showpagination) ? ( $showpagination == 'yes' ? true : 'nopagingblock') : 'nopagingblock';

		    if ($taxonomy_type == 'category') {
		      	$taxonomy_category = esc_attr($taxonomy);
		      	$taxonomy_tag = '';
		      	$context = $taxonomy_type;
		    } else if ($taxonomy_type == 'tag') {
		      	$taxonomy_tag = esc_attr($taxonomy);
		      	$taxonomy_category = '';
		      	$context = $taxonomy_type;
		    } else {
		    	$taxonomy_category = '';
		    	$taxonomy_tag = '';
		    	$context = 'list';
		    }

			switch ($btncolor) {
				case 'grey':
					$btnclass = '';
					$iconclass = '';
					break;
				case 'blue':
					$btnclass = ' btn-primary';
					$iconclass = ' icon-white';
					break;
				case 'lightblue':
					$btnclass = ' btn-info';
					$iconclass = ' icon-white';
					break;
				case 'green':
					$btnclass = ' btn-success';
					$iconclass = ' icon-white';
					break;
				case 'yellow':
				default:
					$btnclass = ' btn-warning';
					$iconclass = ' icon-white';
					break;
				case 'red':
					$btnclass = ' btn-danger';
					$iconclass = ' icon-white';
					break;
				case 'black':
					$btnclass = ' btn-inverse';
					$iconclass = ' icon-white';
					break;
				
			}

			switch ($iconcolor) {
				case 'blue':
					$tagcolor = ' icon-blue';
					break;
				case 'lightblue':
					$tagcolor = ' icon-lightblue';
					break;
				case 'green':
					$tagcolor = ' icon-green';
					break;
				case 'yellow':
					$tagcolor = ' icon-yellow';
					break;
				case 'red':
					$tagcolor = ' icon-red';
					break;
				case 'white':
					$tagcolor = ' icon-white';
					break;		
				case 'black':
				default:
					$tagcolor = '';
					break;
			}

			switch ($layout) {
				case '2col':
					$span = 'span6';
					$counter = '2';
					break;
				case '3col':
				default:
					$span = 'span4';
					$counter = '3';
					break;
				case '4col':
					$span = 'span3';
					$counter = '4';
					break;
			}

			if (get_query_var('paged')) {
				$page = intval(get_query_var('paged'));
			} elseif (get_query_var('page')) {
				$page = intval(get_query_var('page'));
			} else {
				$page = 1;
			}

			$output = '';
			
			if ($showcategory == 'yes') {

				$output .= '<ul class="mpt-product-categories ' . $align . '">';

					$output .= '<li>' . __( 'By Category:' , 'flexmarket' ) . '</li>';
					$output .= '<li id="all">' . __( 'All' , 'flexmarket' ) . '</li>';

					$args = array(
						'taxonomy' => 'product_category',
						'orderby' => 'name',
						'order' => 'ASC'
					  );

					$categories = get_categories($args);

					if  ($categories) {
					  foreach($categories as $category) {
					    $output .= '<li id="'.$category->slug. '">'.$category->name. '</li>';
					  }
					}

				$output .= '</ul>';

				$output .= '<div class="clear"></div>';

			}

			$query_args = array(
				'unique_id' => $block_id,
				'sort' => ($showcategory == 'advsoft' ? true : false),
				'align' => $align,
				'context' => $context,
				'echo' => false,
				'paginate' => $pagination,
				'page' => $page,
				'per_page' => $entries,
				'order_by' => $order_by,
				'order' => $arrange,
				'category' => $taxonomy_category,
				'tag' => $taxonomy_tag,
				'counter' => $counter,
				'span' => $span,
				'btnclass' => $btnclass,
				'iconclass' => $iconclass,
				'tagcolor' => $tagcolor,
				'boxclass' => 'thetermsclass',
				'boxstyle' => ' background: '.esc_attr($bgcolor).';'
			);

			$output .= flexmarket_advance_product_sort( $query_args );

			echo apply_filters( 'aq_mp_product_grid_block' , $output , $instance );

		}
		
	}

	/* AQ_MPcart_Block
	------------------------------------------------------------------------------------------------------------------- */

	class AQ_MPcart_Block extends AQ_Block {
		
		function __construct() {
			$block_options = array(
				'name' => __('[MP] Shopping Cart','flexmarket'),
				'size' => 'span4',
			);
			
			parent::__construct('AQ_MPcart_Block', $block_options);
		}
		
		function form($instance) {

		    $instance = wp_parse_args( (array) $instance, array( 'title' => __('Shopping Cart', 'flexmarket'), 'custom_text' => '', 'only_store_pages' => 0 ) );
			$title = $instance['title'];
			$custom_text = $instance['custom_text'];

			do_action( 'aq_mpcart_block_before_form' , $instance );

		  	?>
				<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'flexmarket') ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
				<p><label for="<?php echo $this->get_field_id('custom_text'); ?>"><?php _e('Custom Text:', 'flexmarket') ?><br />
			    <textarea class="widefat" id="<?php echo $this->get_field_id('custom_text'); ?>" name="<?php echo $this->get_field_name('custom_text'); ?>"><?php echo esc_attr($custom_text); ?></textarea></label>
			    </p>
		  	<?php

		  	do_action( 'aq_mpcart_block_after_form' , $instance );

		}
		
		function block($instance) {

			global $mp;

			$output = '<div id="sidebar" style="border-left: none; padding: 0px; margin-bottom: 0px;">';

				$output .= '<div class="well well-small">';

				  $title = $instance['title'];
					if ( !empty( $title ) ) { $output .= '<h4 class="page-header">' . apply_filters('widget_title', $title) . '</h4>'; };

			    if ( !empty($instance['custom_text']) )
			      $output .= '<div class="custom_text">' . $instance['custom_text'] . '</div>';

				    $output .= '<div id="mp_cart_page" class="mp_cart_widget_content">';
				    	$output .= mp_show_cart( 'widget' , NULL , false );
				    $output .= '</div>';

			    $output .= '</div>'; // End well

			$output .= '</div>'; // End #sidebar

			echo apply_filters( 'aq_mpcart_block_output' , $output , $instance );
		}
		
	}

	/* AQ_MP_Product_Carousel_Block
	------------------------------------------------------------------------------------------------------------------- */

	class AQ_MP_Product_Carousel_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => __('[MP] Product Carousel','flexmarket'),
				'size' => 'span12',
			);
			
			//create the block
			parent::__construct('aq_mp_product_carousel_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'layout' => '3col',
				'entries' => '9',
				'showcategory' => 'no',
				'order_by' => 'date', 
				'arrange' => 'DESC',
				'taxonomy_type' => 'none',
				'taxonomy' => '',
				'bgcolor' => '#f1f1f1',
				'textcolor' => '#676767',
				'btncolor' => 'yellow',
				'iconcolor' => 'black',
				'speed' => '4000',
				'pause' => 'yes'
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$layout_options = array(
				'2col' => __('2 Columns','flexmarket'),
				'3col' => __('3 Columns','flexmarket'),
				'4col' => __('4 Columns','flexmarket')
			);

			$entries_options = array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
				'10' => '10',
				'11' => '11',
				'12' => '12',
				'13' => '13',
				'14' => '14',
				'15' => '15',
				'16' => '16',
				'17' => '17',
				'18' => '18',
				'19' => '19',
				'20' => '20'
			);

			$btncolor_options = array(
				'grey' => __('Grey','flexmarket'),
				'blue' => __('Blue','flexmarket'),
				'lightblue' => __('Light Blue','flexmarket'),
				'green' => __('Green','flexmarket'),
				'red' => __('Red','flexmarket'),
				'yellow' => __('Yellow','flexmarket'),
				'black' => __('Black','flexmarket'),
			);

			$iconcolor_options = array(
				'blue' => __('Blue','flexmarket'),
				'lightblue' => __('Light Blue','flexmarket'),
				'green' => __('Green','flexmarket'),
				'red' => __('Red','flexmarket'),
				'yellow' => __('Yellow','flexmarket'),
				'white' => __('White','flexmarket'),
				'black' => __('Black','flexmarket'),
			);

			$taxonomy_type_options = array(
				'none' => __('No Filter','flexmarket'),
				'category' => __('Category','flexmarket'),
				'tag' => __('Tag','flexmarket'),
			);

			$pause_options = array(
				'yes' => __('Yes','flexmarket'),
				'no' => __('No','flexmarket'),
			);

			$order_by_options = array(
				'title' => __('Product Name','flexmarket'),
				'date' => __('Publish Date','flexmarket'),
				'ID' => __('Product ID','flexmarket'),
				'author' => __('Product Author','flexmarket'),
				'sales' => __('Number of Sales','flexmarket'),
				'price' => __('Product Price','flexmarket'),
				'rand' => __('Random','flexmarket'),
			);

			$order_options = array(
				'DESC' => __('Descending','flexmarket'),
				'ASC' => __('Ascending','flexmarket'),
			);
			
			?>

			<div class="description half">
				<label for="<?php echo $this->get_field_id('layout') ?>">
					<?php _e('Layout', 'flexmarket') ?><br/>
					<?php echo aq_field_select('layout', $block_id, $layout_options, $layout); ?>
				</label>
			</div>

			<div class="description half last">
				<label for="<?php echo $this->get_field_id('entries') ?>">
					<?php _e('Number of Entries', 'flexmarket') ?><br/>
					<?php echo aq_field_select('entries', $block_id, $entries_options, $entries); ?>
				</label>
			</div>

			<div class="description fourth">
				<label for="<?php echo $this->get_field_id('speed') ?>">
					<?php _e('interval (in millisecond)', 'flexmarket') ?><br />
					<?php echo aq_field_input('speed', $block_id, $speed, $size = 'full') ?>
				</label>
			</div>

			<div class="description fourth">
				<label for="<?php echo $this->get_field_id('pause') ?>">
					<?php _e('Pause on hover?', 'flexmarket') ?><br />
					<?php echo aq_field_select('pause', $block_id, $pause_options, $pause); ?>
				</label>
			</div>
			
			<div class="description half last">
				<label for="<?php echo $this->get_field_id('taxonomyfilter') ?>">
					<?php _e('Taxonomy Filter:', 'flexmarket') ?><br />
					<?php echo aq_field_select('taxonomy_type', $block_id, $taxonomy_type_options, $taxonomy_type); ?> <?php echo aq_field_input('taxonomy', $block_id, $taxonomy, $size = 'full') ?>
				</label>
			</div>

			<div class="description half">
				<label for="<?php echo $this->get_field_id('order_by') ?>">
					<?php _e('Order Products By:', 'flexmarket') ?><br />
					<?php echo aq_field_select('order_by', $block_id, $order_by_options, $order_by); ?>
				</label>
			</div>	

			<div class="description half last">
				<label for="<?php echo $this->get_field_id('arrange') ?>">
					<br />
					<?php echo aq_field_select('arrange', $block_id, $order_options, $arrange); ?>
				</label>
			</div>	

			<div class="description fourth">
				<label for="<?php echo $this->get_field_id('bgcolor') ?>">
					<?php _e('Pick a background color', 'flexmarket') ?><br/>
					<?php echo aq_field_color_picker('bgcolor', $block_id, $bgcolor) ?>
				</label>
			</div>

			<div class="description fourth">
				<label for="<?php echo $this->get_field_id('textcolor') ?>">
					<?php _e('Pick a text color', 'flexmarket') ?><br/>
					<?php echo aq_field_color_picker('textcolor', $block_id, $textcolor) ?>
				</label>
			</div>

			<div class="description fourth last">
				<label for="<?php echo $this->get_field_id('btncolor') ?>">
					<?php _e('Button Color', 'flexmarket') ?><br/>
					<?php echo aq_field_select('btncolor', $block_id, $btncolor_options, $btncolor); ?>
				</label>
			</div>

			<div class="description fourth last">
				<label for="<?php echo $this->get_field_id('iconcolor') ?>">
					<?php _e('Icon Color', 'flexmarket') ?><br/>
					<?php echo aq_field_select('iconcolor', $block_id, $iconcolor_options, $iconcolor); ?>
				</label>
			</div>
			
			<?php
		}
		
		function block($instance) {
			extract($instance);

			$themefolder = get_template_directory_uri();

		    //setup taxonomy if applicable
		    if ($taxonomy_type == 'category') {
		      	$taxonomy_query = '&product_category=' . $taxonomy;
		    } else if ($taxonomy_type == 'tag') {
		      	$taxonomy_query = '&product_tag=' . $taxonomy;
		    } else {
		    	$taxonomy_query = '';
		    }

		    //get order by
		    if ($order_by) {
		      	if ($order_by == 'price')
		        	$order_by_query = '&meta_key=mp_price&orderby=mp_price';
		      	else if ($order_by == 'sales')
		        	$order_by_query = '&meta_key=mp_sales_count&orderby=mp_sales_count';
		      	else
		        	$order_by_query = '&orderby='.$order_by;
		    } else {
		      	$order_by_query = '&orderby=title';
		    }

			switch ($btncolor) {
				case 'grey':
					$btnclass = '';
					$iconclass = '';
					break;
				case 'blue':
					$btnclass = ' btn-primary';
					$iconclass = ' icon-white';
					break;
				case 'lightblue':
					$btnclass = ' btn-info';
					$iconclass = ' icon-white';
					break;
				case 'green':
					$btnclass = ' btn-success';
					$iconclass = ' icon-white';
					break;
				case 'yellow':
					$btnclass = ' btn-warning';
					$iconclass = ' icon-white';
					break;
				case 'red':
					$btnclass = ' btn-danger';
					$iconclass = ' icon-white';
					break;
				case 'black':
					$btnclass = ' btn-inverse';
					$iconclass = ' icon-white';
					break;
				
			}

			switch ($iconcolor) {
				case 'blue':
					$tagcolor = ' icon-blue';
					break;
				case 'lightblue':
					$tagcolor = ' icon-lightblue';
					break;
				case 'green':
					$tagcolor = ' icon-green';
					break;
				case 'yellow':
					$tagcolor = ' icon-yellow';
					break;
				case 'red':
					$tagcolor = ' icon-red';
					break;
				case 'white':
					$tagcolor = ' icon-white';
					break;		
				case 'black':
					$tagcolor = '';
					break;
				
			}

		?>

			<div id="productCarousel-<?php echo $block_id; ?>" class="carousel productcarousel slide" style="background: <?php echo esc_attr($bgcolor) ?>; color: <?php echo esc_attr($textcolor) ?>;">

				<!-- Control -->
	            <div class="pull-right">
		            <a class="fade-in-effect" href="#productCarousel-<?php echo $block_id; ?>" data-slide="prev"><i class="icon-circle-arrow-left"></i></a>
		            <a class="fade-in-effect" href="#productCarousel-<?php echo $block_id; ?>" data-slide="next"><i class="icon-circle-arrow-right"></i></a>
	            </div>

	            <div class="clear padding10"></div>
	           
	            <div class="carousel-inner">

					<div class="item active">
						<div class="row-fluid">

					<?php

						switch ($layout) {
							case '2col':
								$span = 'span6';
								$imagesize = 'tb-860';
								$counter = '2';
								break;
							case '3col':
								$span = 'span4';
								$imagesize = 'tb-360';
								$counter = '3';
								break;
							case '4col':
								$span = 'span3';
								$imagesize = 'tb-360';
								$counter = '4';
								$style = 'false';
								break;							
							default:
								$span = 'span4';
								$imagesize = 'tb-360';
								$counter = '3';
								break;
						}

						query_posts( 'post_type=product&showposts=' . $entries . $taxonomy_query . $order_by_query . '&order=' . $arrange );
						$count = 1;
						$num = 1;
					?>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	

							<?php $id = get_the_ID(); ?>

							<?php 

								$product_args = array(
									'echo' => true,
									'post_id' => $id,
									'span' => $span,
									'imagesize' => $imagesize,
									'btnclass' => $btnclass,
									'iconclass' => $iconclass,
									'tagcolor' => $tagcolor,
								);

								flexmarket_load_single_product_in_box( $product_args ) 
							?>

							<?php if ( $num == $entries ): ?>

							<?php else: ?>

								<?php if ( $count == $counter ): ?>
									</div><!-- / row-fluid -->
									</div><!-- / item -->
									<div class="item">
									<div class="row-fluid">
									<?php $count = 0; ?>
								<?php endif; ?>

							<?php endif; ?>

							<?php $count++; ?>
							<?php $num++; ?>

						<?php endwhile; endif; ?>

						</div><!-- / row-fluid -->

					</div><!-- / item -->

					<?php wp_reset_query(); ?>

				</div> <!-- / carousel-inner --> 

			</div> <!-- / product-carousel -->

			<script type="text/javascript">

				jQuery(document).ready(function () {
					jQuery(".productcarousel").carousel({
						interval: <?php echo esc_attr($speed); ?>
						<?php echo ($pause == 'yes' ? ',pause: "hover"' : ''); ?>
					})
				});

			</script>

		<?php

		}
		
	}