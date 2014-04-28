<?php 

	// Unregister default MarketPress widget
	function remove_default_mp_widget() {
		unregister_widget('MarketPress_Shopping_Cart');
		unregister_widget('MarketPress_Product_List');
		unregister_widget('MarketPress_Tag_Cloud_Widget');
	}

	add_action( 'widgets_init', 'remove_default_mp_widget' );


	// Re-register MP Custom Widget for FlexMarket
	function register_custom_widget_flexmarket() {
		register_widget( 'FlexMarket_Shopping_Cart' );
		register_widget('FlexMarket_Product_List');
		register_widget('FlexMarket_Tag_Cloud_Widget');
	}

	add_action( 'widgets_init', 'register_custom_widget_flexmarket' );

	// Shopping cart widget
	class FlexMarket_Shopping_Cart extends WP_Widget {

		function FlexMarket_Shopping_Cart() {
			$widget_ops = array('classname' => 'mp_cart_widget', 'description' => __('Shows dynamic shopping cart contents along with a checkout button for your MarketPress store.', 'flexmarket') );
			$this->WP_Widget('mp_cart_widget', __('Shopping Cart', 'flexmarket'), $widget_ops);
		}

		function widget($args, $instance) {
			global $mp;

	    if ( get_query_var('pagename') == 'cart' )
	      return;

			if ($instance['only_store_pages'] && !mp_is_shop_page())
				return;

			extract( $args );

			echo $before_widget;
		  $title = $instance['title'];
			if ( !empty( $title ) ) { echo $before_title . apply_filters('widget_title', $title) . $after_title; };

	    if ( !empty($instance['custom_text']) )
	      echo '<div class="custom_text">' . $instance['custom_text'] . '</div>';

	    echo '<div id="mp_cart_page" class="mp_cart_widget_content">';
	    	mp_show_cart('widget' , NULL , true );
	    echo '</div>';

	    echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = stripslashes( wp_filter_nohtml_kses( $new_instance['title']) );
			$instance['custom_text'] = stripslashes( wp_filter_kses( $new_instance['custom_text']) );
			$instance['only_store_pages'] = !empty($new_instance['only_store_pages']) ? 1 : 0;
			/*
			$instance['show_thumbnail'] = !empty($new_instance['show_thumbnail']) ? 1 : 0;
	    $instance['size'] = !empty($new_instance['size']) ? intval($new_instance['size']) : 25;
			*/

			return $instance;
		}

		function form( $instance ) {
	    $instance = wp_parse_args( (array) $instance, array( 'title' => __('Shopping Cart', 'flexmarket'), 'custom_text' => '', 'only_store_pages' => 0 ) );
			$title = $instance['title'];
			$custom_text = $instance['custom_text'];
			$only_store_pages = isset( $instance['only_store_pages'] ) ? (bool) $instance['only_store_pages'] : false;
			/*
			$show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : false;
			$size = !empty($instance['size']) ? intval($instance['size']) : 25;
			*/
	  ?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'flexmarket') ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('custom_text'); ?>"><?php _e('Custom Text:', 'flexmarket') ?><br />
	    <textarea class="widefat" id="<?php echo $this->get_field_id('custom_text'); ?>" name="<?php echo $this->get_field_name('custom_text'); ?>"><?php echo esc_attr($custom_text); ?></textarea></label>
	    </p>
			<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('only_store_pages'); ?>" name="<?php echo $this->get_field_name('only_store_pages'); ?>"<?php checked( $only_store_pages ); ?> />
			<label for="<?php echo $this->get_field_id('only_store_pages'); ?>"><?php _e( 'Only show on store pages', 'flexmarket' ); ?></label></p>
	  <?php
			/* Disable untill we can mod the cart
			<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_thumbnail'); ?>" name="<?php echo $this->get_field_name('show_thumbnail'); ?>"<?php checked( $show_thumbnail ); ?> />
			<label for="<?php echo $this->get_field_id('show_thumbnail'); ?>"><?php _e( 'Show Thumbnail', 'flexmarket' ); ?></label><br />
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Thumbnail Size:', 'flexmarket') ?> <input id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" size="3" value="<?php echo $size; ?>" /></label></p>
			*/
		}
	}	

	//Product listing widget
	class FlexMarket_Product_List extends WP_Widget {

		function FlexMarket_Product_List() {
			$widget_ops = array('classname' => 'mp_product_list_widget', 'description' => __('Shows a customizable list of products from your MarketPress store.', 'flexmarket') );
			$this->WP_Widget('mp_product_list_widget', __('Product List', 'flexmarket'), $widget_ops);
		}

		function widget($args, $instance) {
	    global $mp;

			if ($instance['only_store_pages'] && !mp_is_shop_page())
				return;

			extract( $args );

			echo $before_widget;
		  $title = $instance['title'];
			if ( !empty( $title ) ) { echo $before_title . apply_filters('widget_title', $title) . $after_title; };

	    if ( !empty($instance['custom_text']) )
	      echo '<div id="custom_text">' . $instance['custom_text'] . '</div>';

	    /* setup our custom query */

	    //setup taxonomy if applicable
	    if ($instance['taxonomy_type'] == 'category') {
	      $taxonomy_query = '&product_category=' . $instance['taxonomy'];
	    } else if ($instance['taxonomy_type'] == 'tag') {
	      $taxonomy_query = '&product_tag=' . $instance['taxonomy'];
	    } else {
	    	$taxonomy_query = '';
	    }

	    //figure out perpage
	    if (isset($instance['num_products']) && intval($instance['num_products']) > 0) {
	      $paginate_query = '&posts_per_page='.intval($instance['num_products']).'&paged=1';
	    } else {
	      $paginate_query = '&posts_per_page=10&paged=1';
	    }

		//get order by
		if ($instance['order_by']) {
		  if ($instance['order_by'] == 'price')
		    $order_by_query = '&meta_key=mp_price&orderby=meta_value_num';
		  else if ($instance['order_by'] == 'sales')
		    $order_by_query = '&meta_key=mp_sales_count&orderby=meta_value_num';
		  else
		    $order_by_query = '&orderby='.$instance['order_by'];
		} else {
		  $order_by_query = '&orderby=title';
		}

	    //get order direction
	    if ($instance['order']) {
	      $order_query = '&order='.$instance['order'];
	    } else {
	      $order_query = '&orderby=DESC';
	    }

	    //The Query
	    $custom_query = new WP_Query('post_type=product' . $taxonomy_query . $paginate_query . $order_by_query . $order_query);

	    //do we have products?
	    if (count($custom_query->posts)) {
	      echo '<ul id="flexmarket_product_list" class="">';
	      foreach ($custom_query->posts as $post) {

	      	$btnclass = mpt_load_mp_btn_color();

	        echo '<li>';
	        
	        echo '<div class="row-fluid">';
	        
		        if ($instance['show_thumbnail']) {
		        	echo '<div class="span4">';
		        		mp_product_image( true, 'widget', $post->ID, $instance['size'] );
		        	echo '</div>';
		        	echo '<div class="span8">';
		        } else {
		        	echo '<div class="span12">';
		        }
		          
			      	echo '<p class="mp_product_name"><a href="' . get_permalink( $post->ID ) . '">' . esc_attr($post->post_title) . '</a></p>';

			        if ($instance['show_excerpt'])
			          echo '<div class="mp_product_content">' . $mp->product_excerpt($post->post_excerpt, $post->post_content, $post->ID) . '</div>';

			        if ($instance['show_price'] || $instance['show_button']) {
			          echo '<div class="mp_product_meta'.($instance['show_excerpt'] ? ' align-right' : '').'">';

			          if ($instance['show_price'])
			            echo flexmarket_product_price(false, $post->ID, '' , '' , 'widget');

			          if ($instance['show_button'])
			            echo flexmarket_buy_button(false, 'list', $post->ID , $btnclass . ' btn-small');

			          echo '</div>';
			        }

			        echo '</div>'; //End span

	          echo '</div>'; // End Row-fluid
	        
	        echo '</li>';
	      }
	      echo '</ul>';
	    } else {
	      ?>
	      <div class="widget-error">
	  			<?php _e('No Products', 'flexmarket') ?>
	  		</div>
	  		<?php
	    }

	    echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = stripslashes( wp_filter_nohtml_kses( $new_instance['title'] ) );
			$instance['custom_text'] = stripslashes( wp_filter_kses( $new_instance['custom_text'] ) );

			$instance['num_products'] = intval($new_instance['num_products']);
			$instance['order_by'] = $new_instance['order_by'];
			$instance['order'] = $new_instance['order'];
			$instance['taxonomy_type'] = $new_instance['taxonomy_type'];
	    $instance['taxonomy'] = ($new_instance['taxonomy_type']) ? sanitize_title($new_instance['taxonomy']) : '';

	    $instance['show_thumbnail'] = !empty($new_instance['show_thumbnail']) ? 1 : 0;
	    $instance['size'] = !empty($new_instance['size']) ? intval($new_instance['size']) : 75;
	    $instance['show_excerpt'] = !empty($new_instance['show_excerpt']) ? 1 : 0;
	    $instance['show_price'] = !empty($new_instance['show_price']) ? 1 : 0;
	    $instance['show_button'] = !empty($new_instance['show_button']) ? 1 : 0;

			$instance['only_store_pages'] = !empty($new_instance['only_store_pages']) ? 1 : 0;

			return $instance;
		}

		function form( $instance ) {
	    $instance = wp_parse_args( (array) $instance, array( 'title' => __('Our Products', 'flexmarket'), 'custom_text' => '', 'num_products' => 10, 'order_by' => 'title', 'order' => 'DESC', 'show_thumbnail' => 1, 'size' => 50, 'only_store_pages' => 0 ) );
			$title = $instance['title'];
			$custom_text = $instance['custom_text'];

			$num_products = intval($instance['num_products']);
			$order_by = $instance['order_by'];
			$order = $instance['order'];
		    $taxonomy_type = (!empty($instance['taxonomy_type']) ? $instance['taxonomy_type'] : '' );
		    $taxonomy = (!empty($instance['taxonomy']) ? $instance['taxonomy'] : '' );

			$show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : false;
			$size = !empty($instance['size']) ? intval($instance['size']) : 50;
			$show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : false;
			$show_price = isset( $instance['show_price'] ) ? (bool) $instance['show_price'] : false;
			$show_button = isset( $instance['show_button'] ) ? (bool) $instance['show_button'] : false;

			$only_store_pages = isset( $instance['only_store_pages'] ) ? (bool) $instance['only_store_pages'] : false;
	  ?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'flexmarket') ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('custom_text'); ?>"><?php _e('Custom Text:', 'flexmarket') ?><br />
	    <textarea class="widefat" id="<?php echo $this->get_field_id('custom_text'); ?>" name="<?php echo $this->get_field_name('custom_text'); ?>"><?php echo esc_attr($custom_text); ?></textarea></label>
	    </p>

	    <h3><?php _e('List Settings', 'flexmarket'); ?></h3>
	    <p>
	    <label for="<?php echo $this->get_field_id('num_products'); ?>"><?php _e('Number of Products:', 'flexmarket') ?> <input id="<?php echo $this->get_field_id('num_products'); ?>" name="<?php echo $this->get_field_name('num_products'); ?>" type="text" size="3" value="<?php echo $num_products; ?>" /></label><br />
	    </p>
	    <p>
	    <label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('Order Products By:', 'flexmarket') ?></label><br />
	    <select id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
	      <option value="title"<?php selected($order_by, 'title') ?>><?php _e('Product Name', 'flexmarket') ?></option>
	      <option value="date"<?php selected($order_by, 'date') ?>><?php _e('Publish Date', 'flexmarket') ?></option>
	      <option value="ID"<?php selected($order_by, 'ID') ?>><?php _e('Product ID', 'flexmarket') ?></option>
	      <option value="author"<?php selected($order_by, 'author') ?>><?php _e('Product Author', 'flexmarket') ?></option>
	      <option value="sales"<?php selected($order_by, 'sales') ?>><?php _e('Number of Sales', 'flexmarket') ?></option>
	      <option value="price"<?php selected($order_by, 'price') ?>><?php _e('Product Price', 'flexmarket') ?></option>
	      <option value="rand"<?php selected($order_by, 'rand') ?>><?php _e('Random', 'flexmarket') ?></option>
	    </select><br />
	    <label><input value="DESC" name="<?php echo $this->get_field_name('order'); ?>" type="radio"<?php checked($order, 'DESC') ?> /> <?php _e('Descending', 'flexmarket') ?></label>
	    <label><input value="ASC" name="<?php echo $this->get_field_name('order'); ?>" type="radio"<?php checked($order, 'ASC') ?> /> <?php _e('Ascending', 'flexmarket') ?></label>
	    </p>
	    <p>
	    <label><?php _e('Taxonomy Filter:', 'flexmarket') ?></label><br />
	    <select id="<?php echo $this->get_field_id('taxonomy_type'); ?>" name="<?php echo $this->get_field_name('taxonomy_type'); ?>">
	      <option value=""<?php selected($taxonomy_type, '') ?>><?php _e('No Filter', 'flexmarket') ?></option>
	      <option value="category"<?php selected($taxonomy_type, 'category') ?>><?php _e('Category', 'flexmarket') ?></option>
	      <option value="tag"<?php selected($taxonomy_type, 'tag') ?>><?php _e('Tag', 'flexmarket') ?></option>
	    </select>
	    <input id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" type="text" size="17" value="<?php echo $taxonomy; ?>" title="<?php _e('Enter the Slug', 'flexmarket'); ?>" />
	    </p>

	    <h3><?php _e('Display Settings', 'flexmarket'); ?></h3>
	    <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_thumbnail'); ?>" name="<?php echo $this->get_field_name('show_thumbnail'); ?>"<?php checked( $show_thumbnail ); ?> />
			<label for="<?php echo $this->get_field_id('show_thumbnail'); ?>"><?php _e( 'Show Thumbnail', 'flexmarket' ); ?></label><br />
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Thumbnail Size:', 'flexmarket') ?> <input id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" size="3" value="<?php echo $size; ?>" /></label></p>

	    <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>"<?php checked( $show_excerpt ); ?> />
	    <label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e( 'Show Excerpt', 'flexmarket' ); ?></label><br />
	    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_price'); ?>" name="<?php echo $this->get_field_name('show_price'); ?>"<?php checked( $show_price ); ?> />
			<label for="<?php echo $this->get_field_id('show_price'); ?>"><?php _e( 'Show Price', 'flexmarket' ); ?></label><br />
	    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_button'); ?>" name="<?php echo $this->get_field_name('show_button'); ?>"<?php checked( $show_button ); ?> />
			<label for="<?php echo $this->get_field_id('show_button'); ?>"><?php _e( 'Show Buy Button', 'flexmarket' ); ?></label></p>

			<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('only_store_pages'); ?>" name="<?php echo $this->get_field_name('only_store_pages'); ?>"<?php checked( $only_store_pages ); ?> />
			<label for="<?php echo $this->get_field_id('only_store_pages'); ?>"><?php _e( 'Only show on store pages', 'flexmarket' ); ?></label></p>
		<?php
		}
	}

	//Product tags cloud
	class FlexMarket_Tag_Cloud_Widget extends WP_Widget {

		function FlexMarket_Tag_Cloud_Widget() {
			$widget_ops = array( 'classname' => 'mp_tag_cloud_widget', 'description' => __( "Your most used product tags in cloud format from your MarketPress store.") );
			$this->WP_Widget('mp_tag_cloud_widget', __('Product Tag Cloud', 'flexmarket'), $widget_ops);
		}

		function widget( $args, $instance ) {

			if ($instance['only_store_pages'] && !mp_is_shop_page())
				return;

			extract($args);
			$current_taxonomy = 'product_tag';
			if ( !empty($instance['title']) ) {
				$title = $instance['title'];
			} else {
				$title = '';
			}
			$title = apply_filters('widget_title', $title, $instance, $this->id_base);

			switch ($instance['tagcolor']) {
				case 'grey':
					$tagclass = '';
					break;
				case 'blue':
					$tagclass = ' label-info';
					break;
				case 'green':
					$tagclass = ' label-success';
					break;
				case 'yellow':
					$tagclass = ' label-warning';
					break;
				case 'red':
					$tagclass = ' label-important';
					break;
				case 'black':
					$tagclass = ' label-inverse';
					break;
				
				default:
					$tagclass = ' label-info';
					break;
			}

			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
			echo '<div>';
				echo '<span class="label'.$tagclass.'" style="padding: 5px; margin: 5px;">';
				wp_tag_cloud( apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy , 'separator' => '</span><span class="label'.$tagclass.'" style="padding: 5px; margin: 5px;">') ) );
			echo "</div>\n";
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance['title'] = strip_tags(stripslashes($new_instance['title']));
			$instance['tagcolor'] = strip_tags(stripslashes($new_instance['tagcolor']));
			$instance['only_store_pages'] = !empty($new_instance['only_store_pages']) ? 1 : 0;
			return $instance;
		}

		function form( $instance ) {
	    $instance = wp_parse_args( (array) $instance, array( 'title' => __('Product Tags', 'flexmarket'), 'only_store_pages' => 0 ) );
			$only_store_pages = isset( $instance['only_store_pages'] ) ? (bool) $instance['only_store_pages'] : false;

			$tagcolor_options = array(
				'blue' => 'Blue',
				'green' => 'Green',
				'red' => 'Red',
				'yellow' => 'Yellow',
				'black' => 'Black',
				'grey' => 'Grey',
			);

	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>

		<p>
			<label for="<?php echo $this->get_field_id('tagcolor') ?>">
				<?php _e('Tag Color') ?><br/>
				<select id="<?php echo $this->get_field_id('tagcolor') ?>" class="widefat" name="<?php echo $this->get_field_name('tagcolor') ?>">
					<?php 
						foreach($tagcolor_options as $key=>$value) {
							echo '<option value="'.$key.'" '.selected( $instance['tagcolor'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
						}
					?>
				</select>			
			</label>
		</p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('only_store_pages'); ?>" name="<?php echo $this->get_field_name('only_store_pages'); ?>"<?php checked( $only_store_pages ); ?> />
			<label for="<?php echo $this->get_field_id('only_store_pages'); ?>"><?php _e( 'Only show on store pages', 'flexmarket' ); ?></label></p>
		<?php
		}
	}

?>