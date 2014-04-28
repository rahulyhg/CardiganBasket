<?php 

/* Separator block
----------------------------------------------------------------------------------------------------------- */

	class AQ_Separator_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => __('Separator','flexmarket'),
				'size' => 'span12',
			);
			
			//create the block
			parent::__construct('aq_separator_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'horizontal_line' => 'none',
				'line_color' => '#e5e5e5',
				'pattern' => '1',
				'height' => '5'
			);
			
			$line_options = array(
				'none' => __('None','flexmarket'),
				'solid' => __('Solid','flexmarket'),
				'dashed' => __('Dashed','flexmarket'),
				'dotted' => __('Dotted','flexmarket'),
			);
			
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			$line_color = isset($line_color) ? $line_color : '#353535';

			do_action( $id_base . '_before_form' , $instance );
			
			?>
			<div class="description note">
				<?php _e('Use this block to clear the floats between two or more separate blocks vertically.', 'flexmarket') ?>
			</div>

			<div class="description fourth">
				<label for="<?php echo $this->get_field_id('horizontal_line') ?>">
					<?php _e('Pick a horizontal line', 'flexmarket') ?><br/>
					<?php echo aq_field_select('horizontal_line', $block_id, $line_options, $horizontal_line); ?>
				</label>
			</div>
			<div class="description fourth">
				<label for="<?php echo $this->get_field_id('height') ?>">
					<?php _e('Height', 'flexmarket') ?><br/>
					<?php echo aq_field_input('height', $block_id, $height, 'min', 'number') ?> px
				</label>
				
			</div>
			<div class="description half last">
				<label for="<?php echo $this->get_field_id('line_color') ?>">
					<?php _e('Pick a line color', 'flexmarket') ?><br/>
					<?php echo aq_field_color_picker('line_color', $block_id, $line_color, $defaults['line_color']) ?>
				</label>
				
			</div>
			<?php

			do_action( $id_base . '_after_form' , $instance );
			
		}
		
		function block($instance) {
			extract($instance);

			$output = '';
			
			switch($horizontal_line) {
				case 'none':
					$output .= '<div class="cf" style="height: '.esc_attr($height).'px;margin-bottom: '.esc_attr($height).'px;"></div><div class="clear"></div>';
					break;
				case 'solid':
					$output .= '<div class="cf" style="border-bottom: 1px solid '.$line_color.';height: '.esc_attr($height).'px;margin-bottom: '.esc_attr($height).'px;"></div><div class="clear"></div>';
					break;
				case 'dashed':
					$output .= '<div class="cf" style="border-bottom: 1px dashed '.$line_color.';height: '.esc_attr($height).'px;margin-bottom: '.esc_attr($height).'px;"></div><div class="clear"></div>';
					break;
				case 'dotted':
					$output .= '<div class="cf" style="border-bottom: 1px dotted '.$line_color.';height: '.esc_attr($height).'px;margin-bottom: '.esc_attr($height).'px;"></div><div class="clear"></div>';
					break;
			}

			echo apply_filters( 'aq_separator_block_output' , $output , $instance );
			
		}
		
	}

/* Blog Updates block
----------------------------------------------------------------------------------------------------------- */

	class AQ_Blog_Updates_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => __('Blog Updates','flexmarket'),
				'size' => 'span12',
			);
			
			//create the block
			parent::__construct('aq_blog_updates_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'layout' => '4col',
				'entries' => '4',
				'excerpt' => '25',
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

			do_action( $id_base . '_before_form' , $instance );
			
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

			<div class="description half">
				<label for="<?php echo $this->get_field_id('excerpt') ?>">
					<?php _e('Total words in Excerpt', 'flexmarket') ?><br/>
					<?php echo aq_field_input('excerpt', $block_id, $excerpt, $size = 'full') ?>
					<em style="padding-left: 5px; font-size: 0.75em;">Leave it blank or enter "0" to disable excerpt.</em>
				</label>
			</div>
			
			<?php

			do_action( $id_base . '_after_form' , $instance );
		}
		
		function block($instance) {
			extract($instance);

			switch ($layout) {
				case '2col':
					$span = 'span6';
					$imagesize = 'tb-860';
					$counter = '2';
					$videoheight = '195';
					break;
				case '3col':
					$span = 'span4';
					$imagesize = 'tb-360';
					$counter = '3';
					$videoheight = '245';
					break;
				case '4col':
					$span = 'span3';
					$imagesize = 'tb-360';
					$counter = '4';
					$videoheight = '145';
					break;							
				default:
					$span = 'span3';
					$imagesize = 'tb-360';
					$counter = '4';
					$videoheight = '145';
					break;
			}

			$count = 1;
			query_posts( 'showposts='.$entries.'&post_type=post' );

			$output = '<div id="blog-updates">';

				if (have_posts()) : while (have_posts()) : the_post();

					$incomplete_row = true;

					if ( $count == 1 )
						$output .= '<div class="row-fluid">';

					$output .= '<div class="' . $span . ' well well-small">';

						$id = get_the_ID();
						$de_post = get_post( $id );
						$temp = get_post_meta( $id, '_mpt_post_select_temp', true );

						$args =  array(
							'echo' => false,
							'post_id' => $id,
							'content_type' => 'list',
							'imagesize' => $imagesize,
							'videoheight' => $videoheight
						);

						if ($temp == 'image-carousel') {
							$output .= mpt_load_image_carousel( $args );
						} else if ($temp == 'video') {
							$output .= mpt_load_video_post( $args );
						} else {
							$output .= mpt_load_featured_image( $args );
						}
					
						$output .= '<a href="' . get_permalink( $id ) . '"><h3 class="post-title">' . get_the_title( $id ) . '</h3></a>';
						$output .= '<p class="post-meta">Posted By ' . get_the_author_meta( 'display_name' , $de_post->post_author ) . ' on ' . get_the_date() . '</p>';

						if (!empty($excerpt) || $excerpt == '0')
							$output .= ( !empty($de_post->post_excerpt) ? $de_post->post_excerpt : ( !empty($de_post->post_content) ? wp_trim_words($de_post->post_content , $excerpt ) : '' ) );

					$output .= '</div>'; // End well

					if ( $count == $counter ) {
						$output .= '</div>'; // End - row-fluid
						$incomplete_row = false;
						$count = 0;
					}

					$count++;

				endwhile; endif;
				wp_reset_query();

				if ( $incomplete_row )
					$output .= '</div>'; // End - row-fluid

			$output .= '</div>'; // End - blog-updates

			echo apply_filters( 'aq_blog_updates_block_output' , $output , $instance );

		}
		
	}

/* AQ_Button_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Button_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => __('Button','flexmarket'),
			'size' => 'span6',
		);
		
		//create the block
		parent::__construct('aq_button_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'text' => __('Button','flexmarket'),
			'link' => '#',
			'color' => 'grey',
			'btnsize' => 'default',
			'icontype' => 'none',
			'whiteicon' => '0',
			'align' => 'none',
			'btnlinkopen' => 'same',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$color_options = array(
			'grey' => __('Grey','flexmarket'),
			'blue' => __('Blue','flexmarket'),
			'lightblue' => __('Light Blue','flexmarket'),
			'green' => __('Green','flexmarket'),
			'red' => __('Red','flexmarket'),
			'yellow' => __('Yellow','flexmarket'),
			'black' => __('Black','flexmarket'),
		);

		$size_options = array(
			'default' => __('Default','flexmarket'),
			'mini' => __('Mini','flexmarket'),
			'small' => __('Small','flexmarket'),
			'large' => __('Large','flexmarket'),
			'huge' => __('Huge','flexmarket'),
			'block' => __('Block','flexmarket'),
		);

		$align_options = array(
			'none' => __('None','flexmarket'),
			'left' => __('Left','flexmarket'),
			'center' => __('Center','flexmarket'),
			'right' => __('Right','flexmarket')
		);

		$btnlinkopen_options = array(
			'same' => __('Same Window','flexmarket'),
			'new' => __('New Window','flexmarket')
		);

		global $aqpb_customclass;
		$icontype_options = $aqpb_customclass->load_awesome_icon_list();

		do_action( $id_base . '_before_form' , $instance );
		
		?>
		<p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				<?php _e('Button Text', 'flexmarket') ?>
				<?php echo aq_field_input('text', $block_id, $text, $size = 'full') ?>
			</label>
		</p>
		
		<p class="description two-third">
			<label for="<?php echo $this->get_field_id('link') ?>">
				<?php _e('Button Link', 'flexmarket') ?>
				<?php echo aq_field_input('link', $block_id, $link, $size = 'full') ?>
			</label>	
		</p>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('btnlinkopen') ?>">
				<?php _e('Link Open In', 'flexmarket') ?><br/>
				<?php echo aq_field_select('btnlinkopen', $block_id, $btnlinkopen_options, $btnlinkopen); ?>
			</label>
		</div>

		<div class="description third">
			<label for="<?php echo $this->get_field_id('color') ?>">
				<?php _e('Button Color', 'flexmarket') ?><br/>
				<?php echo aq_field_select('color', $block_id, $color_options, $color); ?>
			</label>
		</div>

		<div class="description third">
			<label for="<?php echo $this->get_field_id('btnsize') ?>">
				<?php _e('Button Size', 'flexmarket') ?><br/>
				<?php echo aq_field_select('btnsize', $block_id, $size_options, $btnsize); ?>
			</label>
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('align') ?>">
				<?php _e('Align', 'flexmarket') ?><br/>
				<?php echo aq_field_select('align', $block_id, $align_options, $align); ?>
			</label>
		</div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('icontype') ?>">
				<?php _e('Icon Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('icontype', $block_id, $icontype_options, $icontype); ?>
				<small>( <a href="http://fortawesome.github.io/Font-Awesome/3.2.1/icons/" target="_blank"><?php _e( 'Click here' , 'flexmarket' ); ?></a><?php _e( ' for the complete list of 361 icons.' , 'flexmarket' ); ?> )</small>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('whiteicon') ?>">
				<?php _e('White Icon?', 'flexmarket') ?> <?php echo aq_field_checkbox('whiteicon', $block_id, $whiteicon); ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="cf"></div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function block($instance) {
		extract($instance);

		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$class = (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? ' style="'.esc_attr($style).'"' : '');

		$iconclass = '';

		if ($whiteicon == '1') { $iconclass .= ' icon-white';}
		
		if ($icontype == 'none') {
			$iconoutput = '';
		} else {
			$iconoutput = '<i class="'.$icontype.$iconclass.'"></i> ';
		}

		switch ($color) {
			case 'grey':
				$class .= '';
				break;
			case 'blue':
				$class .= ' btn-primary';
				break;
			case 'lightblue':
				$class .= ' btn-info';
				break;
			case 'green':
				$class .= ' btn-success';
				break;
			case 'yellow':
				$class .= ' btn-warning';
				break;
			case 'red':
				$class .= ' btn-danger';
				break;
			case 'black':
				$class .= ' btn-inverse';
				break;
			
		}

		switch ($btnsize) {
			case 'default':
				$class .= '';
				break;
			case 'large':
				$class .= ' btn-large';
				break;
			case 'small':
				$class .= ' btn-small';
				break;
			case 'mini':
				$class .= ' btn-mini';
				break;	
			case 'block':
				$class .= ' btn-block';
				break;	
			case 'huge':
				$class .= ' btn-big';
				break;	
		}

		switch ($align) {
			case 'none':
				$frontdiv = '';
				$enddiv = '';
				break;
			case 'left':
				$frontdiv = '<div class="align-left">';
				$enddiv = '</div>';
				break;
			case 'center':
				$frontdiv = '<div class="align-center">';
				$enddiv = '</div>';
				break;
			case 'right':
				$frontdiv = '<div class="align-right">';
				$enddiv = '</div>';
				break;

		}
		
		$output = $frontdiv.'<a href="'.esc_url($link).'"'.($btnlinkopen == 'new' ? ' target="_blank"' : '' ).'><button'.$id.' class="btn'.$class.'"'.$style.'>'.$iconoutput.strip_tags($text).'</button></a>'.$enddiv;
		
		echo apply_filters( 'aq_button_block_output' , $output , $instance );
	}
	
}

/* AQ_Contact_Block
----------------------------------------------------------------------------------------------------------- */

	class AQ_Contact_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => __('Contact Form','flexmarket'),
				'size' => 'span6',
			);
			
			//create the block
			parent::__construct('aq_contact_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'sendtoemail' => '',
				'btntext' => __('Send Message','flexmarket'),
				'btncolor' => 'black',
				'btnsize' => 'large',
				'shortcode' => '',
				'id' => '',
				'class' => '',
				'style' => ''
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$btncolor_options = array(
				'grey' => __('Grey','flexmarket'),
				'blue' => __('Blue','flexmarket'),
				'lightblue' => __('Light Blue','flexmarket'),
				'green' => __('Green','flexmarket'),
				'red' => __('Red','flexmarket'),
				'yellow' => __('Yellow','flexmarket'),
				'black' => __('Black','flexmarket'),
			);

			$btnsize_options = array(
				'default' => __('Default','flexmarket'),
				'mini' => __('Mini','flexmarket'),
				'small' => __('Small','flexmarket'),
				'large' => __('Large','flexmarket'),
				'block' => __('Block','flexmarket'),
			);

			do_action( $id_base . '_before_form' , $instance );
			
			?>
			
			<div class="description">
				<label for="<?php echo $this->get_field_id('title') ?>">
					<?php _e('Title (optional)', 'flexmarket') ?><br/>
					<?php echo aq_field_input('title', $block_id, $title) ?>
				</label>
			</div>

			<div class="description">
				<label for="<?php echo $this->get_field_id('sendtoemail') ?>">
					<?php _e('Send To Email', 'flexmarket') ?><br/>
					<?php echo aq_field_input('sendtoemail', $block_id, $sendtoemail) ?>
				</label>
			</div>

			<div class="description third">
				<label for="<?php echo $this->get_field_id('btntext') ?>">
					<?php _e('Button Text', 'flexmarket') ?><br/>
					<?php echo aq_field_input('btntext', $block_id, $btntext) ?>
				</label>
			</div>

			<div class="description third">
				<label for="<?php echo $this->get_field_id('btnsize') ?>">
					<?php _e('Button Size', 'flexmarket') ?><br/>
					<?php echo aq_field_select('btnsize', $block_id, $btnsize_options, $btnsize); ?>
				</label>
			</div>

			<div class="description third last">
				<label for="<?php echo $this->get_field_id('btncolor') ?>">
					<?php _e('Button Color', 'flexmarket') ?><br/>
					<?php echo aq_field_select('btncolor', $block_id, $btncolor_options, $btncolor); ?>
				</label>
			</div>

			<div class="cf"></div>


			<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

			<div class="description">
				<label for="<?php echo $this->get_field_id('class') ?>">
					<?php _e('class (optional)', 'flexmarket') ?><br/>
					<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
				</label>
			</div>

			<div class="cf"></div>

			<div class="description">
				<label for="<?php echo $this->get_field_id('style') ?>">
					<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
					<?php echo aq_field_input('style', $block_id, $style) ?>
				</label>
			</div>

			<?php

			do_action( $id_base . '_after_form' , $instance );
			
		}
		
		function block($instance) {
			extract($instance);

			$userclass = (!empty($class) ? ' '.esc_attr($class) : '');
			$style = (!empty($style) ? ' style="'.esc_attr($style).'"' : '');

			$btnclass = 'btn';
			$theemailsent = '';

			switch ($btncolor) {
				case 'grey':
					$btnclass .= '';
					break;
				case 'blue':
					$btnclass .= ' btn-primary';
					break;
				case 'lightblue':
					$btnclass .= ' btn-info';
					break;
				case 'green':
					$btnclass .= ' btn-success';
					break;
				case 'yellow':
					$btnclass .= ' btn-warning';
					break;
				case 'red':
					$btnclass .= ' btn-danger';
					break;
				case 'black':
					$btnclass .= ' btn-inverse';
					break;
				
			}

			switch ($btnsize) {
				case 'default':
					$btnclass .= '';
					break;
				case 'large':
					$btnclass .= ' btn-large';
					break;
				case 'small':
					$btnclass .= ' btn-small';
					break;
				case 'mini':
					$btnclass .= ' btn-mini';
					break;	
				case 'block':
					$btnclass .= ' btn-block';
					break;	
			}

			  if(isset($_POST['submitted'])) {

			    if(sanitize_text_field($_POST['inputname']) === '') {
			      $thenameerror = __( 'Please enter your name below.' , 'flexmarket' );
			      $haserror = true;
			    } else {
			      $thename = sanitize_text_field($_POST['inputname']);
			    }

			    if(sanitize_text_field($_POST['inputemail']) === '')  {
			      $theemailerror = __('Please enter your valid email address below.','flexmarket');
			      $haserror = true;
			    } else if (!is_email(sanitize_text_field($_POST['inputemail']))) {
			      $theemailerror = __('You entered an invalid email address.','flexmarket');
			      $haserror = true;
			    } else {
			      $theemail = sanitize_text_field($_POST['inputemail']);
			    }

			    if(sanitize_text_field($_POST['inputsubject']) === '') {
			      $subjecterror = __('Please enter the subject line below.','flexmarket');
			      $haserror = true;
			    } else {
			      $subject = sanitize_text_field($_POST['inputsubject']);
			    }

			    if(sanitize_text_field($_POST['themessage']) === '') {
			      $commenterror = __('Please enter a message below.','flexmarket');
			      $haserror = true;
			    } else {
			      if(function_exists('stripslashes')) {
			        $comments = stripslashes(sanitize_text_field($_POST['themessage']));
			      } else {
			        $comments = sanitize_text_field($_POST['themessage']);
			      }
			    }

			    if(!isset($haserror)) {
			      $sendtoemail = is_email($sendtoemail);

			      if (!empty($sendtoemail) && $sendtoemail !="false") {
			      	$theemailto = $sendtoemail;
			      } else {
			      	$theemailto = get_bloginfo('admin_email');
			      }
			      
			      $body = "Name: $thename \n\nEmail: $theemail \n\nMessage: $comments";
			      $headers = 'From: '.$thename.' <'.$theemailto.'>' . "\r\n" . 'Reply-To: ' . $theemail;

			      wp_mail($theemailto, $subject, $body, $headers);
			      $theemailsent = 'true';
			    }			    

			  }

			$output = '';

			if ( !empty($title) )
				$output .= '<h3 class="contact-form-block-title">' . esc_attr($title) . '</h3>';

		  	$output .= '<div id="contact-form-' . $block_id . '" class="contact-form-block well' . $userclass . '"' . $style . '>';

			  	$output .= '<form action="' . ( is_home() ? get_home_url().'/' : get_permalink() ) . '#contact-form-' . $block_id . '" class="sa-form" id="contact-form" method="post">';

				  	$output .= ( $theemailsent == 'true' ? '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . __('Your message was sent successfully.' , 'flexmarket' ) . '</strong>' . __('We will get back to you as soon as possible.' , 'flexmarket') . '</div>' : '' );

				  	// Name
				  	$output .= '<div class="control-group">';
					  	$output .= '<label class="control-label" for="inputname"><b>' . __('Your Name:' , 'flexmarket' ) . '</b></label>';
					  	$output .= (!empty($thenameerror) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$thenameerror.'</div>' : '');
					  	$output .= '<div class="controls">';
					  		$output .= '<input name="inputname" class="width-100 mobile-full-width" id="inputname" type="text" value="' . ( !empty($thename) ? $thename : '' ) . '">';
					  	$output .= '</div>'; // End - Controls
				  	$output .= '</div>'; // End control-group

				  	// Email
				  	$output .= '<div class="control-group">';
					  	$output .= '<label class="control-label" for="inputemail"><b>' . __('Your Email:' , 'flexmarket' ) . '</b></label>';
					  	$output .= (!empty($theemailerror) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$theemailerror.'</div>' : '');
					  	$output .= '<div class="controls">';
					  		$output .= '<input name="inputemail" class="width-100 mobile-full-width" id="inputemail" type="text" value="' . ( !empty($theemail) ? $theemail : '' ) .'">';
					  	$output .= '</div>'; // End - Controls
				  	$output .= '</div>'; // End control-group

				  	// Subject
				  	$output .= '<div class="control-group">';
					  	$output .= '<label class="control-label" for="inputsubject"><b>' . __('Subject:' , 'flexmarket' ) . '</b></label>';
					  	$output .= (!empty($subjecterror) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$subjecterror.'</div>' : '');
					  	$output .= '<div class="controls">';
					  		$output .= '<input name="inputsubject" class="width-100 mobile-full-width" id="inputsubject" type="text" value="' . ( !empty($subject) ? $subject : '' ) . '">';
					  	$output .= '</div>'; // End - Controls
				  	$output .= '</div>'; // End control-group

				  	// message
				  	$output .= '<div class="control-group">';
					  	$output .= '<label class="control-label" for="inputmessage"><b>' . __('Message:' , 'flexmarket' ) . '</b></label>';
					  	$output .= (!empty($commenterror) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'.$commenterror.'</div>' : '');
					  	$output .= '<div class="controls">';
					  		$output .= '<textarea rows="5" class="width-100 mobile-full-width" name="themessage" id="themessage">' . ( !empty($comments) ? $comments : '' ) . '</textarea>';
					  	$output .= '</div>'; // End - Controls
				  	$output .= '</div>'; // End control-group

				  	// Button
				  	$output .= '<div class="align-left">';
				  		$output .= '<button type="submit" class="' . $btnclass . '">' . esc_attr($btntext) . '</button>';
				  	$output .= '</div>';
				  	$output .= '<input type="hidden" name="submitted" id="submitted" value="true" />';

				$output .= '</form>';

		  	$output .= '</div>'; // End contact-form-block

		  	echo apply_filters( 'aq_contact_block_output' , $output , $instance );
			
		}
		
	}

/* AQ_CTA_Block
----------------------------------------------------------------------------------------------------------- */

	class AQ_CTA_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => __('Call To Action','flexmarket'),
				'size' => 'span12',
			);
			
			//create the block
			parent::__construct('aq_cta_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'headline' => '',
				'subheadline' => '',
				'heading' => 'h2',
				'align' => 'left',
				'bgcolor' => '#F2EFEF',
				'textcolor'	=> '#676767',
				'bordercolor' => '#00a5f7',
				'btntext' => 'Learn More',
				'btncolor' => 'grey',
				'btnsize' => 'large',
				'btnlink' => '',
				'btnicon' => 'none',
				'btnlinkopen' => 'same',
				'id' => '',
				'class' => '',
				'style' => ''
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$heading_style = array(
				'h1' => 'H1',
				'h2' => 'H2',
				'h3' => 'H3',
				'h4' => 'H4',
				'h5' => 'H5',
				'h6' => 'H6',
			);

			$align_options = array(
				'left' => __('Left','flexmarket'),
				'center' => __('Center','flexmarket'),
				'right' => __('Right','flexmarket')
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

			$btnsize_options = array(
				'default' => __('Default','flexmarket'),
				'mini' => __('Mini','flexmarket'),
				'small' => __('Small','flexmarket'),
				'large' => __('Large','flexmarket')
			);

			$btnlinkopen_options = array(
				'same' => __('Same Window','flexmarket'),
				'new' => __('New Window','flexmarket')
			);

			$btnicontype_options = array(
				'none' => 'none',
				'icon-adjust' => 'icon-adjust',
				'icon-align-center' => 'icon-align-center',
				'icon-align-justify' => 'icon-align-justify',
				'icon-align-left' => 'icon-align-left',
				'icon-align-right' => 'icon-align-right',
				'icon-arrow-down' => 'icon-arrow-down',
				'icon-arrow-left' => 'icon-arrow-left',
				'icon-arrow-right' => 'icon-arrow-right',
				'icon-arrow-up' => 'icon-arrow-up',
				'icon-asterisk' => 'icon-asterisk',
				'icon-backward' => 'icon-backward',
				'icon-ban-circle' => 'icon-ban-circle',
				'icon-barcode' => 'icon-barcode',
				'icon-bell' => 'icon-bell',
				'icon-bold' => 'icon-bold',
				'icon-book' => 'icon-book',
				'icon-bookmark' => 'icon-bookmark',
				'icon-briefcase' => 'icon-briefcase',
				'icon-bullhorn' => 'icon-bullhorn',
				'icon-calendar' => 'icon-calendar',
				'icon-camera' => 'icon-camera',
				'icon-certificate' => 'icon-certificate',
				'icon-check' => 'icon-check',
				'icon-chevron-down' => 'icon-chevron-down',
				'icon-chevron-left' => 'icon-chevron-left',
				'icon-chevron-right' => 'icon-chevron-right',
				'icon-chevron-up' => 'icon-chevron-up',
				'icon-circle-arrow-down' => 'icon-circle-arrow-down',
				'icon-circle-arrow-left' => 'icon-circle-arrow-left',
				'icon-circle-arrow-right' => 'icon-circle-arrow-right',
				'icon-circle-arrow-up' => 'icon-circle-arrow-up',
				'icon-cog' => 'icon-cog',
				'icon-comment' => 'icon-comment',
				'icon-download' => 'icon-download',
				'icon-download-alt' => 'icon-download-alt',
				'icon-edit' => 'icon-edit',
				'icon-eject' => 'icon-eject',
				'icon-envelope' => 'icon-envelope',
				'icon-exclamation-sign' => 'icon-exclamation-sign',
				'icon-eye-close' => 'icon-eye-close',
				'icon-eye-open' => 'icon-eye-open',
				'icon-facetime-video' => 'icon-facetime-video',
				'icon-fast-backward' => 'icon-fast-backward',
				'icon-fast-forward' => 'icon-fast-forward',
				'icon-file' => 'icon-file',
				'icon-film' => 'icon-film',
				'icon-filter' => 'icon-filter',
				'icon-fire' => 'icon-fire',
				'icon-flag' => 'icon-flag',
				'icon-folder-close' => 'icon-folder-close',
				'icon-folder-open' => 'icon-folder-open',
				'icon-font' => 'icon-font',
				'icon-forward' => 'icon-forward',
				'icon-fullscreen' => 'icon-fullscreen',
				'icon-gift' => 'icon-gift',
				'icon-globe' => 'icon-globe',
				'icon-hand-down' => 'icon-hand-down',
				'icon-hand-left' => 'icon-hand-left',
				'icon-hand-right' => 'icon-hand-right',
				'icon-hand-up' => 'icon-hand-up',
				'icon-hdd' => 'icon-hdd',
				'icon-headphones' => 'icon-headphones',
				'icon-heart' => 'icon-heart',
				'icon-home' => 'icon-home',
				'icon-inbox' => 'icon-inbox',
				'icon-indent-left' => 'icon-indent-left',
				'icon-indent-right' => 'icon-indent-right',
				'icon-info-sign' => 'icon-info-sign',
				'icon-italic' => 'icon-italic',
				'icon-leaf' => 'icon-leaf',
				'icon-list' => 'icon-list',
				'icon-list-alt' => 'icon-list-alt',
				'icon-lock' => 'icon-lock',
				'icon-magnet' => 'icon-magnet',
				'icon-map-marker' => 'icon-map-marker',
				'icon-minus' => 'icon-minus',
				'icon-minus-sign' => 'icon-minus-sign',
				'icon-move' => 'icon-move',
				'icon-music' => 'icon-music',
				'icon-off' => 'icon-off',
				'icon-ok' => 'icon-ok',
				'icon-ok-circle' => 'icon-ok-circle',
				'icon-ok-sign' => 'icon-ok-sign',
				'icon-pause' => 'icon-pause',
				'icon-pencil' => 'icon-pencil',
				'icon-picture' => 'icon-picture',
				'icon-plane' => 'icon-plane',
				'icon-play' => 'icon-play',
				'icon-play-circle' => 'icon-play-circle',
				'icon-plus' => 'icon-plus',
				'icon-plus-sign' => 'icon-plus-sign',
				'icon-print' => 'icon-print',
				'icon-qrcode' => 'icon-qrcode',
				'icon-question-sign' => 'icon-question-sign',
				'icon-random' => 'icon-random',
				'icon-refresh' => 'icon-refresh',
				'icon-remove' => 'icon-remove',
				'icon-remove-circle' => 'icon-remove-circle',
				'icon-remove-sign' => 'icon-remove-sign',
				'icon-repeat' => 'icon-repeat',
				'icon-resize-full' => 'icon-resize-full',
				'icon-resize-horizontal' => 'icon-resize-horizontal',
				'icon-resize-small' => 'icon-resize-small',
				'icon-resize-vertical' => 'icon-resize-vertical',
				'icon-retweet' => 'icon-retweet',
				'icon-road' => 'icon-road',
				'icon-screenshot' => 'icon-screenshot',
				'icon-search' => 'icon-search',
				'icon-share' => 'icon-share',
				'icon-share-alt' => 'icon-share-alt',
				'icon-shopping-cart' => 'icon-shopping-cart',
				'icon-signal' => 'icon-signal',
				'icon-star' => 'icon-star',
				'icon-star-empty' => 'icon-star-empty',
				'icon-step-backward' => 'icon-step-backward',
				'icon-step-forward' => 'icon-step-forward',
				'icon-stop' => 'icon-stop',
				'icon-tag' => 'icon-tag',
				'icon-tags' => 'icon-tags',
				'icon-tasks' => 'icon-tasks',
				'icon-text-height' => 'icon-text-height',
				'icon-text-width' => 'icon-text-width',
				'icon-th' => 'icon-th',
				'icon-th-large' => 'icon-th-large',
				'icon-th-list' => 'icon-th-list',
				'icon-thumbs-down' => 'icon-thumbs-down',
				'icon-thumbs-up' => 'icon-thumbs-up',
				'icon-time' => 'icon-time',
				'icon-tint' => 'icon-tint',
				'icon-trash' => 'icon-trash',
				'icon-upload' => 'icon-upload',
				'icon-user' => 'icon-user',
				'icon-volume-down' => 'icon-volume-down',
				'icon-volume-off' => 'icon-volume-off',
				'icon-volume-up' => 'icon-volume-up',
				'icon-warning-sign' => 'icon-warning-sign',
				'icon-wrench' => 'icon-wrench',
				'icon-zoom-in' => 'icon-zoom-in',
				'icon-zoom-out' => 'icon-zoom-out'
			);

			do_action( $id_base . '_before_form' , $instance );
			
			?>
			<div class="description">
				<label for="<?php echo $this->get_field_id('title') ?>">
					<?php _e('Title (optional - won\'t display)', 'flexmarket') ?>
					<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
				</label>
			</div>
			
			<div class="description">
				<label for="<?php echo $this->get_field_id('headline') ?>">
					<?php _e('Headline', 'flexmarket') ?>
					<?php echo aq_field_textarea('headline', $block_id, $headline, $size = 'full') ?>
				</label>
			</div>

			<div class="description">
				<label for="<?php echo $this->get_field_id('subheadline') ?>">
					<?php _e('Subheadline', 'flexmarket') ?>
					<?php echo aq_field_textarea('subheadline', $block_id, $subheadline, $size = 'full') ?>
				</label>
			</div>

			<div class="description half">
				<label for="<?php echo $this->get_field_id('heading') ?>">
					<?php _e('Heading Type', 'flexmarket') ?><br/>
					<?php echo aq_field_select('heading', $block_id, $heading_style, $heading); ?>
				</label>
			</div>

			<div class="description half last">
				<label for="<?php echo $this->get_field_id('align') ?>">
					<?php _e('Text Align', 'flexmarket') ?><br/>
					<?php echo aq_field_select('align', $block_id, $align_options, $align); ?>
				</label>
			</div>

			<div class="description third">
				<label for="<?php echo $this->get_field_id('bgcolor') ?>">
					<?php _e('Pick a background color', 'flexmarket') ?><br/>
					<?php echo aq_field_color_picker('bgcolor', $block_id, $bgcolor) ?>
				</label>
			</div>

			<div class="description third">
				<label for="<?php echo $this->get_field_id('textcolor') ?>">
					<?php _e('Pick a text color', 'flexmarket') ?><br/>
					<?php echo aq_field_color_picker('textcolor', $block_id, $textcolor) ?>
				</label>
			</div>

			<div class="description third last">
				<label for="<?php echo $this->get_field_id('bordercolor') ?>">
					<?php _e('Pick a border color', 'flexmarket') ?><br/>
					<?php echo aq_field_color_picker('bordercolor', $block_id, $bordercolor) ?>
				</label>
			</div>

			<div class="description half">
				<label for="<?php echo $this->get_field_id('btntext') ?>">
					<?php _e('Button Text', 'flexmarket') ?>
					<?php echo aq_field_input('btntext', $block_id, $btntext, $size = 'full') ?>
				</label>
			</div>
			
			<div class="description half last">
				<label for="<?php echo $this->get_field_id('btnlink') ?>">
					<?php _e('Button Link', 'flexmarket') ?>
					<?php echo aq_field_input('btnlink', $block_id, $btnlink, $size = 'full') ?>
				</label>	
			</div>

			<div class="description fourth">
				<label for="<?php echo $this->get_field_id('btnlinkopen') ?>">
					<?php _e('Link Open In', 'flexmarket') ?><br/>
					<?php echo aq_field_select('btnlinkopen', $block_id, $btnlinkopen_options, $btnlinkopen); ?>
				</label>
			</div>

			<div class="description fourth">
				<label for="<?php echo $this->get_field_id('btncolor') ?>">
					<?php _e('Button Color', 'flexmarket') ?><br/>
					<?php echo aq_field_select('btncolor', $block_id, $btncolor_options, $btncolor); ?>
				</label>
			</div>

			<div class="description fourth">
				<label for="<?php echo $this->get_field_id('btnsize') ?>">
					<?php _e('Button Size', 'flexmarket') ?><br/>
					<?php echo aq_field_select('btnsize', $block_id, $btnsize_options, $btnsize); ?>
				</label>
			</div>

			<div class="description fourth last">
				<label for="<?php echo $this->get_field_id('btnicon') ?>">
					<?php _e('Button Icon', 'flexmarket') ?><br/>
					<?php echo aq_field_select('btnicon', $block_id, $btnicontype_options, $btnicon); ?>
				</label>
			</div>

			<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

			<div class="description half">
				<label for="<?php echo $this->get_field_id('id') ?>">
					<?php _e('id (optional)', 'flexmarket') ?><br/>
					<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
				</label>
			</div>

			<div class="description half last">
				<label for="<?php echo $this->get_field_id('class') ?>">
					<?php _e('class (optional)', 'flexmarket') ?><br/>
					<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
				</label>
			</div>

			<div class="cf"></div>

			<div class="description">
				<label for="<?php echo $this->get_field_id('style') ?>">
					<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
					<?php echo aq_field_input('style', $block_id, $style) ?>
				</label>
			</div>
			
			<?php

			do_action( $id_base . '_after_form' , $instance );
		}
		
		function block($instance) {
			extract($instance);

			$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
			$class = (!empty($class) ? ' '.esc_attr($class) : '');
			$style = (!empty($style) ? ' ' . esc_attr($style) : '');

			switch ($align) {
				case 'left':
					$alignclass = ' align-left';
					break;
				case 'center':
					$alignclass = ' align-center';
					break;
				case 'right':
					$alignclass = ' align-right';
					break;

			}

			$btnclass = 'cta-btn btn cta-btn-' . esc_attr($heading);

			switch ($btncolor) {
				case 'grey':
					$btnclass .= '';
					break;
				case 'blue':
					$btnclass .= ' btn-primary';
					break;
				case 'lightblue':
					$btnclass .= ' btn-info';
					break;
				case 'green':
					$btnclass .= ' btn-success';
					break;
				case 'yellow':
					$btnclass .= ' btn-warning';
					break;
				case 'red':
					$btnclass .= ' btn-danger';
					break;
				case 'black':
					$btnclass .= ' btn-inverse';
					break;
				
			}

			switch ($btnsize) {
				case 'default':
					$btnclass .= '';
					break;
				case 'large':
					$btnclass .= ' btn-large';
					break;
				case 'small':
					$btnclass .= ' btn-small';
					break;
				case 'mini':
					$btnclass .= ' btn-mini';
					break;	
			}
			
			$output = '<div'.$id.' class="cta well well-shadow'.$class.'" style="background: '.esc_attr($bgcolor).'; border-left: 3px solid '.esc_attr($bordercolor).'; '.$style.'">';

				$output .= '<div class="media">';
					// button
					$output .= '<a href="'.esc_url($btnlink).'" '.($btnlinkopen == 'new' ? 'target="_blank"' : '' ).'>';
							$output .= '<button class="'.$btnclass.' pull-right">'.($btnicon == 'none' ? '' : '<i class="'.$btnicon.($btncolor == 'grey' ? '' : ' icon-white').'"></i> ').esc_attr($btntext).'</button>';
						$output .= '</a>';

					$output .= '<div class="media-body">';
						$output .= '<'.$heading.' class="cta-heading-text" style="color: '.esc_attr($textcolor).';">';
								$output .= do_shortcode(mpt_content_kses(htmlspecialchars_decode($headline)));
						$output .= '</'.$heading.'>';
						$output .= '<p class="cta-headline" style="color: '.esc_attr($textcolor).';">';
							$output .= do_shortcode(mpt_content_kses(htmlspecialchars_decode($subheadline)));
						$output .= '</p>';
					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>'; // End - cta

			echo apply_filters( 'aq_cta_block_output' , $output , $instance );
		}
		
	}

/* AQ_Features_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Features_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => __('Features','flexmarket'),
			'size' => 'span3',
		);
		
		//create the block
		parent::__construct('aq_features_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'title' => '',
			'heading' => 'h3',
			'text' => '',
			'align' => 'center',
			'bgcolor' => '#fff',
			'textcolor' => '#676767',
			'media' => '',
			'imagesize' => 'full',
			'imagetype' => 'none',
			'enablebtn' => '1',
			'btntext' => 'Learn More',
			'btnlink' => '',
			'btncolor' => 'black',
			'btnsize' => 'default',
			'btnlinkopen' => 'same',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$heading_style = array(
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		);

		$align_options = array(
			'left' => __('Left','flexmarket'),
			'center' => __('Center','flexmarket'),
			'right' => __('Right','flexmarket')
		);

		$imagetype_options = array(
			'none' => __('None','flexmarket'),
			'rounded' => __('Rounded','flexmarket'),
			'circle' => __('Circle','flexmarket'),
			'polaroid' => __('Polaroid','flexmarket')
		);

		$imagesize_options = array(
			'thumbnail' => __('Thumbnail','flexmarket'),
			'medium' => __('Medium','flexmarket'),
			'large' => __('Large','flexmarket'),
			'full' => __('Full','flexmarket'),
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

		$btnsize_options = array(
			'default' => __('Default','flexmarket'),
			'mini' => __('Mini','flexmarket'),
			'small' => __('Small','flexmarket'),
			'large' => __('Large','flexmarket'),
			'block' => __('Block','flexmarket'),
		);

		$btnlinkopen_options = array(
			'same' => __('Same Window','flexmarket'),
			'new' => __('New Window','flexmarket')
		);
		
		do_action( $id_base . '_before_form' , $instance );

		?>
		<div class="description two-third">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Title', 'flexmarket') ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('heading') ?>">
				<?php _e('Heading Style', 'flexmarket') ?><br/>
				<?php echo aq_field_select('heading', $block_id, $heading_style, $heading); ?>
			</label>
		</div>

		<div class="cf" style="height: 20px"></div>
		
		<div class="description">
			<label for="<?php echo $this->get_field_id('media') ?>">
				<?php _e('Upload an Image', 'flexmarket') ?>
				<?php echo aq_field_upload('media', $block_id, $media, 'image') ?>
			</label>
		</div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('imagesize') ?>">
				<?php _e('Image Size', 'flexmarket') ?><br/>
				<?php echo aq_field_select('imagesize', $block_id, $imagesize_options, $imagesize); ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('imagetype') ?>">
				<?php _e('Image Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('imagetype', $block_id, $imagetype_options, $imagetype); ?>
			</label>
		</div>

		<div class="cf" style="height: 20px"></div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				<?php _e('Content', 'flexmarket') ?>
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
		</div>

		<div class="cf" style="height: 20px"></div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('enablebtn') ?>">
				<?php _e('Enable Button', 'flexmarket') ?> <?php echo aq_field_checkbox('enablebtn', $block_id, $enablebtn); ?>
			</label>
		</div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('btntext') ?>">
				<?php _e('Button Text', 'flexmarket') ?>
				<?php echo aq_field_input('btntext', $block_id, $btntext, $size = 'full') ?>
			</label>
		</div>

		<div class="description fourth">
			<label for="<?php echo $this->get_field_id('btncolor') ?>">
				<?php _e('Button Color', 'flexmarket') ?><br/>
				<?php echo aq_field_select('btncolor', $block_id, $btncolor_options, $btncolor); ?>
			</label>
		</div>

		<div class="description fourth last">
			<label for="<?php echo $this->get_field_id('btnsize') ?>">
				<?php _e('Button Size', 'flexmarket') ?><br/>
				<?php echo aq_field_select('btnsize', $block_id, $btnsize_options, $btnsize); ?>
			</label>
		</div>

		<div class="description two-third">
			<label for="<?php echo $this->get_field_id('btnlink') ?>">
				<?php _e('Button Link', 'flexmarket') ?>
				<?php echo aq_field_input('btnlink', $block_id, $btnlink, $size = 'full') ?>
			</label>	
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('btnlinkopen') ?>">
				<?php _e('Link Open In', 'flexmarket') ?><br/>
				<?php echo aq_field_select('btnlinkopen', $block_id, $btnlinkopen_options, $btnlinkopen); ?>
			</label>	
		</div>

		<div class="cf" style="height: 20px"></div>

		<div class="description third">
			<label for="<?php echo $this->get_field_id('align') ?>">
				<?php _e('Align', 'flexmarket') ?><br/>
				<?php echo aq_field_select('align', $block_id, $align_options, $align); ?>
			</label>
		</div>

		<div class="description third">
			<label for="<?php echo $this->get_field_id('bgcolor') ?>">
				<?php _e('Pick a background color', 'flexmarket') ?><br/>
				<?php echo aq_field_color_picker('bgcolor', $block_id, $bgcolor) ?>
			</label>
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('textcolor') ?>">
				<?php _e('Pick a text color', 'flexmarket') ?><br/>
				<?php echo aq_field_color_picker('textcolor', $block_id, $textcolor) ?>
			</label>
		</div>

		<div class="cf" style="height: 20px"></div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="cf"></div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function block($instance) {
		extract($instance);

		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$userclass = (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? esc_attr($style) : '');

		switch ($imagetype) {
			case 'none':
				$imageclass = '';
				break;
			case 'rounded':
				$imageclass = ' img-rounded';
				break;
			case 'circle':
				$imageclass = ' img-circle';
				break;
			case 'polaroid':
				$imageclass = ' img-polaroid';
				break;			
		}

		$imageid = get_image_id(esc_url($media));
		$image = wp_get_attachment_image_src( $imageid , $imagesize);

		$btnclass = ' btn';

		switch ($btncolor) {
			case 'grey':
				$btnclass .= '';
				break;
			case 'blue':
				$btnclass .= ' btn-primary';
				break;
			case 'lightblue':
				$btnclass .= ' btn-info';
				break;
			case 'green':
				$btnclass .= ' btn-success';
				break;
			case 'yellow':
				$btnclass .= ' btn-warning';
				break;
			case 'red':
				$btnclass .= ' btn-danger';
				break;
			case 'black':
				$btnclass .= ' btn-inverse';
				break;
			
		}

		switch ($btnsize) {
			case 'default':
				$btnclass .= '';
				break;
			case 'large':
				$btnclass .= ' btn-large';
				break;
			case 'small':
				$btnclass .= ' btn-small';
				break;
			case 'mini':
				$btnclass .= ' btn-mini';
				break;	
			case 'block':
				$btnclass .= ' btn-block';
				break;	
		}

		switch ($align) {
			case 'left':
				$alignclass = ' align-left';
				break;
			case 'center':
				$alignclass = ' align-center';
				break;
			case 'right':
				$alignclass = ' align-right';
				break;

		}

		$output = '<div'.$id.' class="features well well-shadow'.$alignclass.$userclass.'" style="background: '.$bgcolor.';color: '.$textcolor.';'.$style.'">';
			$output .= '<img src="'.$image[0].'" class="features-block-image'.$imageclass.'" />';
			$output .= '<'.$heading.' class="features-block-title">'.strip_tags($title).'</'.$heading.'>';
			$output .= '<div class="features-block-text opacity8">'.wpautop(do_shortcode(mpt_content_kses(htmlspecialchars_decode($text)))).'</div>';

		if ($enablebtn == '1' ) {
			$output .= '<a href="'.esc_url($btnlink).'"'.($btnlinkopen == 'new' ? ' target="_blank"' : '').' class="features-block-btn-link">';
				$output .= '<button class="features-block-btn'.$btnclass.'">'.esc_attr($btntext).'</button>';
			$output .= '</a>';
		}

		$output .= '</div>';

		echo apply_filters( 'aq_features_block_output' , $output , $instance );
	}
	
}

/* AQ_Heading_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Heading_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => __('Heading Text','flexmarket'),
			'size' => 'span6',
		);
		
		//create the block
		parent::__construct('aq_heading_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'title' => __('This is a heading text','flexmarket'),
			'heading' => 'h1',
			'pageheader' => '0',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$heading_style = array(
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		);

		do_action( $id_base . '_before_form' , $instance );
		
		?>
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Heading Text', 'flexmarket') ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>

		<div class="cf"></div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('heading') ?>">
				<?php _e('Heading Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('heading', $block_id, $heading_style, $heading); ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('pageheader') ?>">
				<?php _e('Page Header?', 'flexmarket') ?> <?php echo aq_field_checkbox('pageheader', $block_id, $pageheader); ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="cf"></div>

		<p class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</p>
		
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function block($instance) {
		extract($instance);

		$headingclass = '';

		if ($pageheader == '1') {
			$headingclass = 'page-header';
		}
		
		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$headingclass .= (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? ' style="' . esc_attr($style).'"' : '');

		if (!empty($headingclass)) {
			$classoutput = ' class="'.$headingclass.'"';
		} else {
			$classoutput = '';
		}

		$output = '<'.$heading.$id.$classoutput.$style.'>'.strip_tags($title).'</'.$heading.'>';

		echo apply_filters( 'aq_heading_block_output' , $output , $instance );
	}
	
}

/* AQ_Image_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Image_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => __('Image','flexmarket'),
			'size' => 'span6',
		);
		
		//create the block
		parent::__construct('aq_image_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'text' => '',
			'link' => '',
			'media' => '',
			'imagesize' => 'full',
			'type' => 'none',
			'align' => 'none',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$align_options = array(
			'none' => __('None','flexmarket'),
			'left' => __('Left','flexmarket'),
			'center' => __('Center','flexmarket'),
			'right' => __('Right','flexmarket')
		);

		$imagetype_options = array(
			'none' => __('None','flexmarket'),
			'rounded' => __('Rounded','flexmarket'),
			'circle' => __('Circle','flexmarket'),
			'polaroid' => __('Polaroid','flexmarket')
		);

		$imagesize_options = array(
			'thumbnail' => __('Thumbnail','flexmarket'),
			'medium' => __('Medium','flexmarket'),
			'large' => __('Large','flexmarket'),
			'full' => __('Full','flexmarket'),
		);

		do_action( $id_base . '_before_form' , $instance );
		
		?>
		<div class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Image Title (optional)', 'flexmarket') ?><br />
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>
		
		<div class="description">
			<label for="<?php echo $this->get_field_id('media') ?>">
				<?php _e('Upload Your Image', 'flexmarket') ?><br />
				<?php echo aq_field_upload('media', $block_id, $media, 'image') ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('link') ?>">
				<?php _e('Link to Page / Post', 'flexmarket') ?><br />
				<?php echo aq_field_input('link', $block_id, $link, $size = 'full') ?><br />
				<em style="font-size: 0.8em; padding-left: 5px;"><?php _e('Leave it blank if you want to link to image', 'flexmarket') ?></em>
			</label>
		</div>

		<div class="description third">
			<label for="<?php echo $this->get_field_id('imagesize') ?>">
				<?php _e('Image Size', 'flexmarket') ?><br/>
				<?php echo aq_field_select('imagesize', $block_id, $imagesize_options, $imagesize); ?>
			</label>
		</div>

		<div class="description third">
			<label for="<?php echo $this->get_field_id('type') ?>">
				<?php _e('Image Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('type', $block_id, $imagetype_options, $type); ?>
			</label>
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('align') ?>">
				<?php _e('Align', 'flexmarket') ?><br/>
				<?php echo aq_field_select('align', $block_id, $align_options, $align); ?>
			</label>
		</div>

		<div class="cf"></div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="cf"></div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function block($instance) {
		extract($instance);

		$classoutput = '';

		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$userclass = (!empty($class) ? esc_attr($class) : '');
		$style = (!empty($style) ? ' style="'.esc_attr($style).'"' : '');

		switch ($type) {
			case 'none':
				$classoutput .= '';
				break;
			case 'rounded':
				$classoutput .= 'img-rounded ';
				break;
			case 'circle':
				$classoutput .= 'img-circle ';
				break;
			case 'polaroid':
				$classoutput .= 'img-polaroid ';
				break;			
		}

		switch ($align) {
			case 'none':
				$frontdiv = '';
				$enddiv = '';
				break;
			case 'left':
				$frontdiv = '<div class="align-left">';
				$enddiv = '</div>';
				break;
			case 'center':
				$frontdiv = '<div class="align-center">';
				$enddiv = '</div>';
				break;
			case 'right':
				$frontdiv = '<div class="align-right">';
				$enddiv = '</div>';
				break;

		}

		$classoutput .= $userclass;

		$imageid = get_image_id(esc_url($media));

		$fullimage = wp_get_attachment_image_src( $imageid , 'full');

		$image = wp_get_attachment_image_src( $imageid , $imagesize);

		$output = $frontdiv;
		$output .= (!empty($link) ? '<a href="'.esc_url($link).'">' : '<a href="'.$fullimage[0].'" rel="prettyPhoto[image-block]">'); 
		$output .= '<img src="'.$image[0].'"'.$id.(!empty($classoutput) ? ' class="'.$classoutput.'"' : '').$style.' />';
		$output .= '</a>';
		$output .= $enddiv;

		echo apply_filters( 'aq_image_block_output' , $output , $instance );
	}
		
}

/* AQ_List_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_List_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __('List','flexmarket'),
			'size' => 'span6',
		);
		
		//create the widget
		parent::__construct('AQ_List_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_list_add_new', array($this, 'add_list_item'));
		
	}
	
	function form($instance) {
	
		$defaults = array(
			'title' => '',
			'heading' => 'h4',
			'items' => array(
				1 => array(
					'title' => __('New Item','flexmarket'),
					'content' => '',
					'icontype' => 'none',
					'iconcolor' => 'black',
				)
			),
			'type'	=> 'bullet',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$list_type = array(
			'bullet' => __('Bullet','flexmarket'),
			'number' => __('Number','flexmarket'),
			'icon' => __('Icon','flexmarket'),
			'unstyled' => __('Unstyled','flexmarket'),
		);

		$heading_style = array(
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		);

   		if (session_id() == "")
      		session_start();

      	$_SESSION['session_aq_block_list_type'] = $type;

      	do_action( $id_base . '_before_form' , $instance );
		
		?>

		<div class="description two-third">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Title (optional)', 'flexmarket') ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('heading') ?>">
				<?php _e('Heading Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('heading', $block_id, $heading_style, $heading); ?>
			</label>
		</div>

		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$items = is_array($items) ? $items : $defaults['items'];
				$count = 1;
				foreach($items as $item) {	
					$this->item($item, $count, $type);
					$count++;
				}
				?>
			</ul>
			<a href="#" rel="list" class="aq-sortable-add-new button"><?php _e('Add New', 'flexmarket') ?></a>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('type') ?>">
				<?php _e('List Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('type', $block_id, $list_type, $type) ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>
		
		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>

		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function item($item = array(), $count = 0, $type = '') {

		$iconcolor_options = array(
			'black' => __('Black','flexmarket'),
			'blue' => __('Blue','flexmarket'),
			'green' => __('Green','flexmarket'),
			'lightblue' => __('Light Blue','flexmarket'),
			'red' => __('Red','flexmarket'),
			'white' => __('White','flexmarket'),
			'yellow' => __('Yellow','flexmarket'),
		);

		global $aqpb_customclass;
		$icontype_options = $aqpb_customclass->load_awesome_icon_list();

		?>
		<li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<?php do_action( 'aq_list_block_before_item_form' , $item , $count , $type ); ?>
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $item['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e('Open / Close', 'flexmarket') ?></a>
				</div>
			</div>
			
			<div class="sortable-body">
				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title">
						<?php _e('Item Name (won\'t publish)', 'flexmarket') ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][title]" value="<?php echo $item['title'] ?>" />
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content">
						<?php _e('Item Content', 'flexmarket') ?><br/>
						<textarea id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $item['content'] ?></textarea>
					</label>
				</div>

			<?php if ($type == 'icon') { ?> 	

				<?php $specialid = $this->get_field_id('items').'-'.$count; ?>

				<div class="tab-desc description half">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icontype">
						<?php _e('Icon type', 'flexmarket') ?><br/>
						<select id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icontype" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][icontype]">
							<?php 
								foreach($icontype_options as $key=>$value) {
									echo '<option value="'.$key.'" '.selected( $item['icontype'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
							?>
						</select>
						<small>( <a href="http://fortawesome.github.io/Font-Awesome/3.2.1/icons/" target="_blank"><?php _e( 'Click here' , 'flexmarket' ); ?></a><?php _e( ' for the complete list of 361 icons.' , 'flexmarket' ); ?> )</small>
					</label>
				</div>

				<div class="tab-desc description half last">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-iconcolor">
						<?php _e('Icon Color', 'flexmarket') ?><br/>
						<select id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-iconcolor" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][iconcolor]">
							<?php 
								foreach($iconcolor_options as $key=>$value) {
									echo '<option value="'.$key.'" '.selected( $item['iconcolor'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
							?>
						</select>
				</div>

			<?php } ?>

				<p class="tab-desc description"><a href="#" class="sortable-delete"><?php _e('Delete', 'flexmarket') ?></a></p>
			</div>

			<?php do_action( 'aq_list_block_after_item_form' , $item , $count , $type ); ?>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		
		$output = '';
		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$userclass = (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? ' '.esc_attr($style) : '');

		$classoutput = '';

		switch ($type) {
			case 'bullet':
				$classoutput .= '';
				$liststyle = 'list-style-type:disc;';
				break;
			case 'number':
				$classoutput .= '';
				$liststyle = 'list-style-type:decimal;';
				break;	
			case 'icon':
				$classoutput .= 'unstyled';
				$liststyle = '';
				break;	
			case 'unstyled':
				$classoutput .= 'unstyled';
				$liststyle = 'list-style-type:none;';
				break;	
		}

		$classoutput .= $userclass;

		$output .= (!empty($title) ? '<'.$heading.'>'.esc_attr($title).'</'.$heading.'>' : '' );
		$output .= '<'.($type == 'number' ? 'ol' : 'ul').$id.(!empty($classoutput) ? ' class=" '.$classoutput.'"' : '').' style="'.$liststyle.$style.'">';

		if ($type == 'icon') {

			if (!empty($items)) {

				foreach( $items as $item ) {

					switch ($item['iconcolor']) {
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

					$output .= '<li>';
					$output .= '<i class="'.$item['icontype'].$tagcolor.'"></i> ';
					$output .= do_shortcode(mpt_content_kses(htmlspecialchars_decode($item['content'])));
					$output .= '</li>';
				}
			}

		} else {

			if (!empty($items)) {

				foreach( $items as $item ) {
					
					$output .= '<li>';
					$output .= do_shortcode(mpt_content_kses(htmlspecialchars_decode($item['content'])));
					$output .= '</li>';
				}

			}

		}
		
		$output .= '</'.($type == 'number' ? 'ol' : 'ul').'>';
			
		echo apply_filters( 'aq_block_list_output' , $output , $instance );
		
	}
	
	/* AJAX add row */
	function add_list_item() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

   		if (session_id() == "")
      		session_start();

      	$type = isset( $_SESSION['session_aq_block_list_type'] ) ? esc_attr( $_SESSION['session_aq_block_list_type'] ) : 'bullet';
		
		//default key/value for the row
		$item = array(
			'title' => __('New Item','flexmarket'),
			'content' => '',
			'icontype' => 'none',
			'iconcolor' => 'black',
		);
		
		if($count) {
			$this->item($item, $count, $type);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}
}

/* AQ_Map_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Map_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => __('Google Map','flexmarket'),
			'size' => 'span6',
		);
		
		//create the block
		parent::__construct('aq_map_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'title' => '',
			'heading' => 'h3',
			'address' => '',
			'width' => '560',
			'height' => '280',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$heading_style = array(
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		);

		do_action( $id_base . '_before_form' , $instance );
		
		?>
		
		<div class="description two-third">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Title (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('title', $block_id, $title) ?>
			</label>
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('heading') ?>">
				<?php _e('Heading Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('heading', $block_id, $heading_style, $heading); ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('address') ?>">
				<?php _e('Address', 'flexmarket') ?><br/>
				<?php echo aq_field_textarea('address', $block_id, $address, $size = 'full') ?>
			</label>
		</div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('width') ?>">
				<?php _e('Map Width', 'flexmarket') ?><br/>
				<?php echo aq_field_input('width', $block_id, $width) ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('height') ?>">
				<?php _e('Map Height', 'flexmarket') ?><br/>
				<?php echo aq_field_input('height', $block_id, $height) ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="cf"></div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>

		<?php

		do_action( $id_base . '_after_form' , $instance );
		
	}
	
	function block($instance) {
		extract($instance);

		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$userclass = (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? ' style="'.esc_attr($style).'"' : '');
		
		$output = '';

		$addresscode = str_replace(" ", "+", esc_attr($address));

		$output .= '<div'.$id.' class="google-map-block'.$userclass.'"'.$style.'>';
			$output .= (!empty($title) ? '<'.$heading.'>'.strip_tags($title).'</'.$heading.'>' : '');
			$output .= '<div class="well well-small">';
				$output .= '<img src="http://maps.google.com/maps/api/staticmap?size='.esc_attr($width).'x'.esc_attr($height).'&zoom=15&maptype=roadmap&markers=color:green|'.$addresscode.'&sensor=false" alt="Business Location" />';
			$output .= '</div>'; // End - well
		$output .= '</div>'; // End - google-map-block

		echo apply_filters( 'aq_map_block_output' , $output , $instance );
		
	}
	
}

/* AQ_Pricing_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Pricing_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __('Pricing Package','flexmarket'),
			'size' => 'span4',
		);
		
		//create the widget
		parent::__construct('AQ_Pricing_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_pricing_add_new', array($this, 'add_item'));
		
	}
	
	function form($instance) {
	
		$defaults = array(
			'title' => __('New Package','flexmarket'),
			'subtitle' => '',
			'items' => array(
				1 => array(
					'content' => __('New Item','flexmarket'),
					'icontype' => 'none',
					'iconcolor' => 'black',
				)
			),
			'bgcolor' => '#fff',
			'textcolor'	=> '#676767',
			'featured' => '0',
			'price' => '$9.99',
			'btntext' => __('SIGN UP','flexmarket'),
			'btnlink' => '',
			'btncolor' => 'black',
			'btnsize' => 'default',
			'btnlinkopen' => 'same',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$btncolor_options = array(
			'grey' => __('Grey','flexmarket'),
			'blue' => __('Blue','flexmarket'),
			'lightblue' => __('Light Blue','flexmarket'),
			'green' => __('Green','flexmarket'),
			'red' => __('Red','flexmarket'),
			'yellow' => __('Yellow','flexmarket'),
			'black' => __('Black','flexmarket'),
		);

		$btnsize_options = array(
			'default' => __('Default','flexmarket'),
			'mini' => __('Mini','flexmarket'),
			'small' => __('Small','flexmarket'),
			'large' => __('Large','flexmarket'),
			'block' => __('Block','flexmarket'),
		);

		$btnlinkopen_options = array(
			'same' => __('Same Window','flexmarket'),
			'new' => __('New Window','flexmarket')
		);

		do_action( $id_base . '_before_form' , $instance );
		
		?>

		<div class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Title', 'flexmarket') ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('subtitle') ?>">
				<?php _e('Subtitle', 'flexmarket') ?>
				<?php echo aq_field_input('subtitle', $block_id, $subtitle, $size = 'full') ?>
			</label>
		</div>

		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$items = is_array($items) ? $items : $defaults['items'];
				$count = 1;
				foreach($items as $item) {	
					$this->item($item, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="pricing" class="aq-sortable-add-new button"><?php _e('Add New', 'flexmarket') ?></a>
			<p></p>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('featured') ?>">
				<?php _e('Featured?', 'flexmarket') ?> <?php echo aq_field_checkbox('featured', $block_id, $featured); ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('price') ?>">
				<?php _e('Price', 'flexmarket') ?>
				<?php echo aq_field_input('price', $block_id, $price, $size = 'full') ?>
			</label>
		</div>

		<div class="cf" style="height: 10px"></div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('btntext') ?>">
				<?php _e('Button Text', 'flexmarket') ?>
				<?php echo aq_field_input('btntext', $block_id, $btntext, $size = 'full') ?>
			</label>
		</div>

		<div class="description fourth">
			<label for="<?php echo $this->get_field_id('btncolor') ?>">
				<?php _e('Button Color', 'flexmarket') ?><br/>
				<?php echo aq_field_select('btncolor', $block_id, $btncolor_options, $btncolor); ?>
			</label>
		</div>

		<div class="description fourth last">
			<label for="<?php echo $this->get_field_id('btnsize') ?>">
				<?php _e('Button Size', 'flexmarket') ?><br/>
				<?php echo aq_field_select('btnsize', $block_id, $btnsize_options, $btnsize); ?>
			</label>
		</div>

		<div class="description two-third">
			<label for="<?php echo $this->get_field_id('btnlink') ?>">
				<?php _e('Button Link', 'flexmarket') ?>
				<?php echo aq_field_input('btnlink', $block_id, $btnlink, $size = 'full') ?>
			</label>	
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('btnlinkopen') ?>">
				<?php _e('Link Open In', 'flexmarket') ?><br/>
				<?php echo aq_field_select('btnlinkopen', $block_id, $btnlinkopen_options, $btnlinkopen); ?>
			</label>	
		</div>

		<div class="cf" style="height: 10px"></div>

		<div class="description fourth">
			<label for="<?php echo $this->get_field_id('bgcolor') ?>">
				<?php _e('Pick a background color', 'flexmarket') ?><br/>
				<?php echo aq_field_color_picker('bgcolor', $block_id, $bgcolor) ?>
			</label>
		</div>

		<div class="description fourth last">
			<label for="<?php echo $this->get_field_id('textcolor') ?>">
				<?php _e('Pick a text color', 'flexmarket') ?><br/>
				<?php echo aq_field_color_picker('textcolor', $block_id, $textcolor) ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function item($item = array(), $count = 0 ) {

		$iconcolor_options = array(
			'black' => __('Black','flexmarket'),
			'white' => __('White','flexmarket'),
		);

		global $aqpb_customclass;
		$icontype_options = $aqpb_customclass->load_awesome_icon_list();

		?>
		<li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<?php do_action( 'aq_pricing_block_before_item_form' , $item , $count ); ?>
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $item['content'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e('Open / Close', 'flexmarket') ?></a>
				</div>
			</div>
			
			<div class="sortable-body">
				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content">
						<?php _e('Content', 'flexmarket') ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][content]" value="<?php echo $item['content'] ?>" />
					</label>
				</div>

				<?php $specialid = $this->get_field_id('items').'-'.$count; ?>

				<div class="tab-desc description half">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icontype">
						<?php _e('Icon type', 'flexmarket') ?><br/>
						<select id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icontype" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][icontype]">
							<?php 
								foreach($icontype_options as $key=>$value) {
									echo '<option value="'.$key.'" '.selected( $item['icontype'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
							?>
						</select>
						<small>( <a href="http://fortawesome.github.io/Font-Awesome/3.2.1/icons/" target="_blank"><?php _e( 'Click here' , 'flexmarket' ); ?></a><?php _e( ' for the complete list of 361 icons.' , 'flexmarket' ); ?> )</small>
					</label>
				</div>

				<div class="tab-desc description half last">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-iconcolor">
						<?php _e('Icon Color', 'flexmarket') ?><br/>
						<select id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-iconcolor" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][iconcolor]">
							<?php 
								foreach($iconcolor_options as $key=>$value) {
									echo '<option value="'.$key.'" '.selected( $item['iconcolor'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
							?>
						</select>
				</div>

				<p class="tab-desc description"><a href="#" class="sortable-delete"><?php _e('Delete', 'flexmarket') ?></a></p>
			</div>

			<?php do_action( 'aq_pricing_block_after_item_form' , $item , $count ); ?>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		
		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$class = (!empty($class) ? ' '. esc_attr($class) : '');
		$style = (!empty($style) ? ' '.esc_attr($style) : '');

		$btnclass = 'btn';

		switch ($btncolor) {
			case 'grey':
				$btnclass .= '';
				break;
			case 'blue':
				$btnclass .= ' btn-primary';
				break;
			case 'lightblue':
				$btnclass .= ' btn-info';
				break;
			case 'green':
				$btnclass .= ' btn-success';
				break;
			case 'yellow':
				$btnclass .= ' btn-warning';
				break;
			case 'red':
				$btnclass .= ' btn-danger';
				break;
			case 'black':
				$btnclass .= ' btn-inverse';
				break;
			
		}

		switch ($btnsize) {
			case 'default':
				$btnclass .= '';
				break;
			case 'large':
				$btnclass .= ' btn-large';
				break;
			case 'small':
				$btnclass .= ' btn-small';
				break;
			case 'mini':
				$btnclass .= ' btn-mini';
				break;	
			case 'block':
				$btnclass .= ' btn-block';
				break;	
		}
		
		$output = '<div'.$id.' class="pricingtable'.($featured == '1' ? ' featured' : '').$class.'" style="background: '.$bgcolor.';color: '.$textcolor.';'.$style.'"">';
			$output .= '<h2>'.esc_attr($title);
				$output .= ( !empty($subtitle) ? '<br /><span>'.esc_attr($subtitle).'</span>' : '' );
			$output .= '</h2>';
			$output .= '<ul>';
				
				if (!empty($items)) {
					foreach( $items as $item ) {
						$output .= '<li>';
						$output .= ($item['icontype'] == 'none' ? '' : '<i class="'.$item['icontype'].($item['iconcolor'] == 'white' ? ' icon-white' : '').'"></i> ');
						$output .= do_shortcode(mpt_content_kses(htmlspecialchars_decode($item['content'])));
						$output .= '</li>';					
					}
				}
			
			$output .= '</ul>';
			$output .= '<h4>'.esc_attr($price).'</h4>';

			if (!empty($btnlink)) {

				$output .= '<div class="btnclass">';
					$output .= '<a href="'.esc_url($btnlink).'"'.($btnlinkopen == 'new' ? ' target="_blank"' : '').'>';
						$output .= '<button class="'.$btnclass.'">'.esc_attr($btntext).'</button>';
					$output .= '</a>';
				$output .= '</div>';

			}

		$output .= '</div>';
			
		echo apply_filters( 'aq_block_pricing_output' , $output , $instance );
		
	}
	
	/* AJAX add item */
	function add_item() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the item
		$item = array(
			'content' => __('New Item','flexmarket'),
			'icontype' => 'none',
			'iconcolor' => 'black',
		);
		
		if($count) {
			$this->item($item, $count);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}
}

/* AQ_Progress_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Progress_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __('Progress Bars','flexmarket'),
			'size' => 'span6',
		);
		
		//create the widget
		parent::__construct('AQ_Progress_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_bar_add_new', array($this, 'add_bar'));
		
	}
	
	function form($instance) {
	
		$defaults = array(
			'title' => '',
			'heading' => 'h4',
			'bars' => array(
				1 => array(
					'title' => __('New Bar','flexmarket'),
					'width' => '80',
					'barcolor' => 'blue',
				)
			),
			'type' => 'basic',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$heading_style = array(
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		);

		$type_options = array(
			'basic' => __('Basic','flexmarket'),
			'striped' => __('Striped','flexmarket'),
			'animated' => __('Animated','flexmarket'),
			'stacked' => __('Stacked','flexmarket'),
		);

		do_action( $id_base . '_before_form' , $instance );
		
		?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Title (optional)', 'flexmarket') ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('heading') ?>">
				<?php _e('Heading Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('heading', $block_id, $heading_style, $heading); ?>
			</label>
		</div>

		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$bars = is_array($bars) ? $bars : $defaults['bars'];
				$count = 1;
				foreach($bars as $bar) {	
					$this->bar($bar, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="bar" class="aq-sortable-add-new button"><?php _e('Add New', 'flexmarket') ?></a>
			<p></p>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('type') ?>">
				<?php _e('Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('type', $block_id, $type_options, $type) ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>
		
		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function bar($bar = array(), $count = 0) {

		$barcolor_options = array(
			'blue' => __('Blue','flexmarket'),
			'green' => __('Green','flexmarket'),
			'yellow' => __('Yellow','flexmarket'),
			'red' => __('Red','flexmarket'),
		);

		?>
		<li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<?php do_action( 'aq_progress_block_before_item_form' , $bar , $count ); ?>
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $bar['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e('Open / Close', 'flexmarket') ?></a>
				</div>
			</div>
			
			<div class="sortable-body">
				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('bars') ?>-<?php echo $count ?>-title">
						<?php _e('Name', 'flexmarket') ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('bars') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('bars') ?>[<?php echo $count ?>][title]" value="<?php echo $bar['title'] ?>" />
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('bars') ?>-<?php echo $count ?>-width">
						<?php _e('Width', 'flexmarket') ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('bars') ?>-<?php echo $count ?>-width" class="input-min" name="<?php echo $this->get_field_name('bars') ?>[<?php echo $count ?>][width]" value="<?php echo $bar['width'] ?>" /> %
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('bars') ?>-<?php echo $count ?>-barcolor">
						<?php _e('Color', 'flexmarket') ?><br/>
						<select id="<?php echo $this->get_field_id('bars') ?>-<?php echo $count ?>-barcolor" name="<?php echo $this->get_field_name('bars') ?>[<?php echo $count ?>][barcolor]">
							<?php 
								foreach($barcolor_options as $key=>$value) {
									echo '<option value="'.$key.'" '.selected($bar['barcolor'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
							?>
						</select>
					</label>
				</div>

				<p class="tab-desc description"><a href="#" class="sortable-delete"><?php _e('Delete', 'flexmarket') ?></a></p>
			</div>

			<?php do_action( 'aq_progress_block_after_item_form' , $bar , $count ); ?>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		
		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$userclass = (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? ' style="'.esc_attr($style).'"' : '');

		$classoutput = '';

		switch ($type) {
			case 'basic':
				$classoutput .= 'progress';
				break;
			case 'striped':
				$classoutput .= 'progress progress-striped';
				break;
			case 'animated':
				$classoutput .= 'progress progress-striped active';
				break;
			case 'stacked':
				$classoutput .= 'progress';
				break;
		}


		$output = '<div'.$id.' class="well well-shadow'.$userclass.'"'.$style.'>';

			$output .= (!empty($title) ? '<'.$heading.'>'.strip_tags($title).'</'.$heading.'>' : '');

			if ($type == 'stacked') {

				if (!empty($bars)) {

					$output .= ( !empty($title) ? '<p>'.esc_attr($title).'</p>' : '');
					$output .= '<div class="'.$classoutput.'">';

					foreach( $bars as $bar ) {

						switch ($bar['barcolor']) {
							case 'blue':
								$barclass = ' bar-info';
								break;
							case 'green':
								$barclass = ' bar-success';
								break;
							case 'yellow':
								$barclass = ' bar-warning';
								break;
							case 'red':
								$barclass = ' bar-danger';
								break;							
						}

						$output .= '<div class="bar'.$barclass.'" style="width: '.esc_attr($bar['width']).'%"></div>';
					}

					$output .= '</div>';
				}

			} else {

				if (!empty($bars)) {

					foreach( $bars as $bar ) {

						switch ($bar['barcolor']) {
							case 'blue':
								$colorclass = ' progress-info';
								break;
							case 'green':
								$colorclass = ' progress-success';
								break;
							case 'yellow':
								$colorclass = ' progress-warning';
								break;
							case 'red':
								$colorclass = ' progress-danger';
								break;							
						}

						$output .= (!empty($bar['title']) ? '<p>'.esc_attr($bar['title']).'</p>' : '');
						$output .= '<div class="'.$classoutput.$colorclass.'">';
						$output .= '<div class="bar" style="width: '.esc_attr($bar['width']).'%"></div>';
						$output .= '</div>';
					}
				}
			
			}

		$output .= '</div>'; // End - well
			
		echo apply_filters( 'aq_block_bar_output' , $output , $instance );
		
	}
	
	/* AJAX add bar */
	function add_bar() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the bar
		$bar = array(
			'title' => __('New Bar','flexmarket'),
			'width' => '80',
			'barcolor' => 'blue',
		);
		
		if($count) {
			$this->bar($bar, $count);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}
}

/* AQ_Shortcode_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Shortcode_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => __('Shortcode Block','flexmarket'),
			'size' => 'span6',
		);
		
		//create the block
		parent::__construct('aq_shortcode_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'title' => '',
			'shortcode' => '',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		do_action( $id_base . '_before_form' , $instance );
		
		?>
		<div class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Title (optional)', 'flexmarket') ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>
		
		<div class="description">
			<label for="<?php echo $this->get_field_id('shortcode') ?>">
				<?php _e('Shortcode', 'flexmarket') ?>
				<?php echo aq_field_textarea('shortcode', $block_id, $shortcode, $size = 'full') ?><br />
				<small>( <?php _e('For a certain shortcode, double qoute might not work in this shortcode block. Please use single qoute instead.', 'flexmarket') ?> )</small>
			</label>
		</div>
		
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function block($instance) {
		extract($instance);
		
		$output = do_shortcode( strip_tags( $shortcode ) );

		echo apply_filters( 'aq_shortcode_block_output' , $output , $instance );
	}
}

/* AQ_Staff_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Staff_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => __('Team Member','flexmarket'),
			'size' => 'span3',
		);
		
		//create the block
		parent::__construct('aq_staff_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'title' => '',
			'position' => '',
			'media' => '',
			'text' => '',
			'fb' => '',
			'twitter' => '',
			'email' => '',
			'bgcolor' => '#F8F8F8',
			'textcolor' => '#676767',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		do_action( $id_base . '_before_form' , $instance );
		
		?>
		<div class="description half">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Name', 'flexmarket') ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('position') ?>">
				<?php _e('Title', 'flexmarket') ?>
				<?php echo aq_field_input('position', $block_id, $position, $size = 'full') ?>
			</label>
		</div>

		<div class="cf" style="height: 10px"></div>
		
		<div class="description">
			<label for="<?php echo $this->get_field_id('media') ?>">
				<?php _e('Upload Photo', 'flexmarket') ?>
				<?php echo aq_field_upload('media', $block_id, $media, 'image') ?>
				<em style="font-size: 0.8em; padding-left: 5px;"><?php _e('Recommended size: 360 x 270 pixel', 'flexmarket') ?></em>
			</label>
		</div>

		<div class="cf" style="height: 10px"></div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				<?php _e('Description', 'flexmarket') ?>
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
		</div>

		<div class="cf" style="height: 10px"></div>

		<div class="description third">
			<label for="<?php echo $this->get_field_id('fb') ?>">
				<?php _e('Facebook Profile', 'flexmarket') ?>
				<?php echo aq_field_input('fb', $block_id, $fb, $size = 'full') ?>
			</label>
		</div>

		<div class="description third">
			<label for="<?php echo $this->get_field_id('twitter') ?>">
				<?php _e('Twitter Profile', 'flexmarket') ?>
				<?php echo aq_field_input('twitter', $block_id, $twitter, $size = 'full') ?>
			</label>
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('email') ?>">
				<?php _e('Email', 'flexmarket') ?>
				<?php echo aq_field_input('email', $block_id, $email, $size = 'full') ?>
			</label>
		</div>

		<div class="cf" style="height: 10px"></div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('bgcolor') ?>">
				<?php _e('Pick a background color', 'flexmarket') ?><br/>
				<?php echo aq_field_color_picker('bgcolor', $block_id, $bgcolor) ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('textcolor') ?>">
				<?php _e('Pick a text color', 'flexmarket') ?><br/>
				<?php echo aq_field_color_picker('textcolor', $block_id, $textcolor) ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="cf" style="height: 10px"></div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="cf"></div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function block($instance) {
		extract($instance);

		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$userclass = (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? ' '.esc_attr($style) : '');

		$output = '<div id="staff-block">';

			$output .= '<div' . $id . ' class="well well-small' . $userclass . '" style="background: ' . $bgcolor . '; color: ' . $textcolor . ';' . $style . '">';

				if (!empty($media)) { 
					$attachid = get_image_id(esc_url($media));
					$output .= '<center>';
						$output .= wp_get_attachment_image($attachid , 'tb-360');
					$output .= '</center>';
				}

				$output .= '<div class="inner">';		
					
					$output .= '<h3 style="color: ' . $textcolor . ';">' . strip_tags($title) .' <small style="color: ' . $textcolor . ';">' . strip_tags($position) . '</small></h3>';

					$output .= wpautop( do_shortcode( mpt_content_kses( htmlspecialchars_decode($text) ) ) );
					
					$output .= '<center><div class="btn-group">';
				    
						if (!empty($fb)) { 
						   $output .= '<a href="' . esc_url($fb) . '" class="btn"><i class="icon-facebook-sign icon-large"></i></a>';
					    }
						   
						if (!empty($twitter)) { 
						    $output .= '<a href="' . esc_url($twitter) . '" class="btn"><i class="icon-twitter-sign icon-large"></i></a>';
					    }

					    if (!empty($email) && is_email($email) != 'false') { 
						    $output .= '<a href="mailto:' . is_email($email) . '" class="btn"><i class="icon-envelope icon-large"></i></a>';
					    }
			    	
			    	$output .= '</div></center>';

			    $output .= '</div>'; // end - inner

			$output .= '</div>'; // end - well

		$output .= '</div>'; // End - staff-block

		echo apply_filters( 'aq_staff_block_output' , $output , $instance );
	}
}

/* AQ_Table_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Table_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __('Table','flexmarket'),
			'size' => 'span12',
		);
		
		//create the widget
		parent::__construct('AQ_Table_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_row_add_new', array($this, 'add_row'));
		
	}
	
	function form($instance) {
	
		$defaults = array(
			'rows' => array(
				1 => array(
					'title' => __('New Row','flexmarket'),
					'rowcolor' => 'default',
					'column1' => '',
					'column2' => '',
					'column3' => '',
					'column4' => '',
					'column5' => '',
					'column6' => '',
					'column7' => '',
					'column8' => '',
					'column9' => '',
					'column10' => '',
					'column11' => '',
					'column12' => '',
				)
			),
			'columns' => '4',
			'types'	=> array('default'),
			'id' => '',
			'class' => '',
			'style' => ''
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$table_type = array(
			'default' => __('Default','flexmarket'),
			'striped' => __('Striped','flexmarket'),
			'bordered' => __('Bordered','flexmarket'),
			'hover' => __('Hover','flexmarket'),
			'condensed' => __('Condensed','flexmarket')
		);

		$columns_per_row = array(
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
			'12' => '12'
		);

   		if (session_id() == "")
      		session_start();

      	$_SESSION['session_aq_table_block_columns'] = $columns;

      	do_action( $id_base . '_before_form' , $instance );
		
		?>
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$rows = is_array($rows) ? $rows : $defaults['rows'];
				$count = 1;
				foreach($rows as $row) {	
					$this->row($row, $count, $columns);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="row" class="aq-sortable-add-new button"><?php _e('Add New', 'flexmarket') ?></a>
			<p></p>
		</div>
		<div class="description half">
			<label for="<?php echo $this->get_field_id('columns') ?>">
				<?php _e('Number of Columns (per row)', 'flexmarket') ?><br/>
				<?php echo aq_field_select('columns', $block_id, $columns_per_row, $columns) ?>
			</label>
		</div>
		<div class="description half last">
			<label for="<?php echo $this->get_field_id('types') ?>">
				<?php _e('Table Type', 'flexmarket') ?> <em style="font-size: 0.8em;"><?php _e('(CTRL + click to select multiple options)', 'flexmarket') ?></em><br/>
				<?php echo aq_field_multiselect('types', $block_id, $table_type, $types) ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function row( $row = array(), $count = 0, $columns = 4 ) {

		$color_options = array(
			'default' => __('Default','flexmarket'),
			'green' => __('Green','flexmarket'),
			'blue' => __('Blue','flexmarket'),
			'red' => __('Red','flexmarket'),
			'yellow' => __('Yellow','flexmarket')
		);

		?>
		<li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<?php do_action( 'aq_table_block_before_item_form' , $row , $count , $columns ); ?>
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $row['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e('Open / Close', 'flexmarket') ?></a>
				</div>
			</div>
			
			<div class="sortable-body">
				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('rows') ?>-<?php echo $count ?>-title">
						<?php _e('Row Name (won\'t publish)', 'flexmarket') ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('rows') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('rows') ?>[<?php echo $count ?>][title]" value="<?php echo $row['title'] ?>" />
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('rows') ?>-<?php echo $count ?>-rowcolor">
						<?php _e('Row Color', 'flexmarket') ?><br/>
						<select id="<?php echo $this->get_field_id('rows') ?>-<?php echo $count ?>-rowcolor" name="<?php echo $this->get_field_name('rows') ?>[<?php echo $count ?>][rowcolor]">
							<?php 
								foreach($color_options as $key=>$value) {
									echo '<option value="'.$key.'" '.selected( $row['rowcolor'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
							?>
						</select>
						
					</label>
				</div>
				
				<div class="cf"></div>

				<?php for ($i=1; $i <= $columns; $i++) { ?>

				<p class="tab-desc description">
					<label for="<?php echo $this->get_field_id('rows') ?>-<?php echo $count ?>-column-<?php echo $i; ?>">
						<?php _e('Column', 'flexmarket') ?> <?php echo $i; ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('rows') ?>-<?php echo $count ?>-column-<?php echo $i; ?>" class="input-full" name="<?php echo $this->get_field_name('rows') ?>[<?php echo $count ?>][column<?php echo $i; ?>]" value="<?php echo $row['column'.$i] ?>" />
					</label>
				</p>

				<?php } ?>

				<p class="tab-desc description"><a href="#" class="sortable-delete"><?php _e('Delete', 'flexmarket') ?></a></p>
			</div>

			<?php do_action( 'aq_table_block_after_item_form' , $row , $count , $columns ); ?>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);

		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$class = (!empty($class) ? 'table '. esc_attr($class) : 'table');
		$style = (!empty($style) ? ' style="'.esc_attr($style).'"' : '');

		foreach( $types as $type ) {

			switch ($type) {
				case 'striped':
					$class .= ' table-striped';
					break;
				case 'bordered':
					$class .= ' table-bordered';
					break;	
				case 'hover':
					$class .= ' table-hover';
					break;	
				case 'condensed':
					$class .= ' table-condensed';
					break;	
			}

		}
		
		$output = '<table'.$id.' class="'.$class.'"'.$style.'>';
			
			foreach( $rows as $row ) {

				switch ($row['rowcolor']) {
					case 'default':
						$colorclass = '';
						break;

					case 'blue':
						$colorclass = ' class="info"';
						break;

					case 'green':
						$colorclass = ' class="success"';
						break;

					case 'yellow':
						$colorclass = ' class="warning"';
						break;

					case 'red':
						$colorclass = ' class="error"';
						break;
				
					default:
						$colorclass = '';
						break;
				}

				$output .= '<tr'.$colorclass.'>';

				for ($i=1; $i <= $columns; $i++) {
					$output .= '<td>';
					$output .= wpautop(do_shortcode(mpt_content_kses(htmlspecialchars_decode($row['column'.$i]))));
					$output .= '</td>';
				}

				$output .= '</tr>';
			}
		
		$output .= '</table>';
			
		echo apply_filters( 'aq_table_block_output' , $output , $instance );
		
	}
	
	/* AJAX add row */
	function add_row() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

		$columns = isset( $_SESSION['session_aq_table_block_columns'] ) ? esc_attr( $_SESSION['session_aq_table_block_columns'] ) : 4;
		
		//default key/value for the row
		$row = array(
			'title' => __('New Row','flexmarket'),
			'rowcolor' => 'default',
			'column1' => '',
			'column2' => '',
			'column3' => '',
			'column4' => '',
			'column5' => '',
			'column6' => '',
			'column7' => '',
			'column8' => '',
			'column9' => '',
			'column10' => '',
			'column11' => '',
			'column12' => '',
		);
		
		if($count) {
			$this->row( $row , $count , $columns );
		} else {
			die(-1);
		}
		
		die();
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}
}

/* AQ_Testimonials_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Testimonials_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __('Testimonial Block','flexmarket'),
			'size' => 'span4',
		);
		
		//create the widget
		parent::__construct('AQ_Testimonials_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_test_add_new', array($this, 'add_test_item'));
		
	}
	
	function form($instance) {
	
		$defaults = array(
			'title' => __('What Our Clients Say','flexmarket'),
			'items' => array(
				1 => array(
					'title' => __('New Testimonial','flexmarket'),
					'content' => '',
					'position' => '',
					'link' => '',
					'photo' => '',
				)
			),
			'speed' => '4000',
			'pause' => 'yes',
			'bgcolor' => '#f1f1f1',
			'textcolor' => '#676767',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$pause_options = array(
			'yes' => __('Yes','flexmarket'),
			'no' => __('No','flexmarket'),
		);

		do_action( $id_base . '_before_form' , $instance );
		
		?>

		<div class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Title', 'flexmarket') ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>

		<div class="cf"></div>

		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$items = is_array($items) ? $items : $defaults['items'];
				$count = 1;
				foreach($items as $item) {	
					$this->item($item, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="test" class="aq-sortable-add-new button"><?php _e('Add New', 'flexmarket') ?></a>
			<p></p>
		</div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('speed') ?>">
				<?php _e('interval (in millisecond)', 'flexmarket') ?><br />
				<?php echo aq_field_input('speed', $block_id, $speed, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('pause') ?>">
				<?php _e('Pause on hover?', 'flexmarket') ?><br />
				<?php echo aq_field_select('pause', $block_id, $pause_options, $pause); ?>
			</label>
		</div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('bgcolor') ?>">
				<?php _e('Pick a background color', 'flexmarket') ?><br/>
				<?php echo aq_field_color_picker('bgcolor', $block_id, $bgcolor) ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('textcolor') ?>">
				<?php _e('Pick a text color', 'flexmarket') ?><br/>
				<?php echo aq_field_color_picker('textcolor', $block_id, $textcolor) ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>
		
		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function item($item = array(), $count = 0) {

		?>
		<li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<?php do_action( 'aq_test_block_before_item_form' , $item , $count ); ?>
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $item['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e('Open / Close', 'flexmarket') ?></a>
				</div>
			</div>
			
			<div class="sortable-body">
				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title">
						<?php _e('Name', 'flexmarket') ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][title]" value="<?php echo $item['title'] ?>" />
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-position">
						<?php _e('Position', 'flexmarket') ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-position" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][position]" value="<?php echo $item['position'] ?>" />
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-photo">
						<?php _e('Photo', 'flexmarket') ?> <em style="font-size: 0.8em;"><?php _e('(Recommended size: 50 x 50 pixel)', 'flexmarket') ?></em><br/>
						<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-photo" class="input-full input-upload" value="<?php echo $item['photo'] ?>" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][photo]">
						<a href="#" class="aq_upload_button button" rel="image"><?php _e('Upload', 'flexmarket') ?></a><p></p>
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-link">
						<?php _e('Website', 'flexmarket') ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][link]" value="<?php echo $item['link'] ?>" />
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content">
						<?php _e('Testimonial', 'flexmarket') ?><br/>
						<textarea id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $item['content'] ?></textarea>
					</label>
				</div>

				<p class="tab-desc description"><a href="#" class="sortable-delete"><?php _e('Delete', 'flexmarket') ?></a></p>
			</div>

			<?php do_action( 'aq_test_block_after_item_form' , $item , $count ); ?>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		
		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$class = (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? ' style="'.esc_attr($style).'"' : '');

		$output = '<div'.$id.' class="well well-small well-shadow'.$class.'"'.$style.'>';

		$output .= (!empty($title) ? '<h5 class="page-header" style="color: '.$textcolor.';border-bottom: 1px dashed '.$textcolor.'">'.esc_attr($title).'</h5>' : '' );

		$output .= '<div id="testimonialsCarousel-'.$block_id.'" class="carousel testimonials carousel-fade slide" style="margin-bottom: 0px;">';
			$output .= '<div class="carousel-inner">';

				if (!empty($items)) {

					$i = 1;

					foreach( $items as $item ) {

						$output .= '<div class="'.($i == 1 ? 'active ' : '').'item">';

							$output .= '<p><em style="font-size: 0.9em;line-height: 1.5em;opacity: 0.8;">';
							$output .= do_shortcode(mpt_content_kses(htmlspecialchars_decode($item['content'])));
							$output .= '</em></p>';
							$output .= (!empty($item['photo']) ? '<img src="'.esc_url($item['photo']).'" class="img-circle pull-left" style="margin-right: 10px;" />' : '');
							$output .= '<h4>';
								$output .= (!empty($item['link']) ? '<a href="'.esc_url($item['link']).'" target="_blank">' : '');
									$output .= do_shortcode(strip_tags($item['title']));
								$output .= (!empty($item['link']) ? '</a>' : '');
								$output .= (!empty($item['position']) ? '<br /><small style="font-size: 0.8em;opacity: 0.8;">' : '');
									$output .= do_shortcode(strip_tags($item['position']));
								$output .= (!empty($item['position']) ? '</small>' : '');
							$output .= '</h4>';

						$output .= '</div>'; // End -item
						$i++;
					}
				}
			
			$output .= '</div>'; // End - carousel-inner
		$output .= '</div>'; // End - testimonials

		$output .= '<div class="clear"></div>';
		$output .= '<div class="pull-right">';
		$output .= '<a class="fade-in-effect" href="#testimonialsCarousel-'.$block_id.'" data-slide="prev"><i class="icon-chevron-left"></i></a>';
		$output .= '<a class="fade-in-effect" href="#testimonialsCarousel-'.$block_id.'" data-slide="next"><i class="icon-chevron-right"></i></a>';
		$output .= '</div> ';
		$output .= '<div class="clear"></div>';

		$output .= '</div>';
		$output .= '<script type="text/javascript">jQuery(document).ready(function () {jQuery(".testimonials").carousel({interval: ' . esc_attr($speed) . '' . ($pause == 'yes' ? ',pause: "hover"' : '') . '})});</script>';

		echo apply_filters( 'aq_test_block_output' , $output , $instance );
		
	}
	
	/* AJAX add testimonial */
	function add_test_item() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the testimonial
		$item = array(
			'title' => __('New Testimonial','flexmarket'),
			'content' => '',
			'position' => '',
			'link' => '',
			'photo' => '',
		);
		
		if($count) {
			$this->item($item, $count);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}
}

/* AQ_Video_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Video_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => __('Video Box','flexmarket'),
			'size' => 'span6',
		);
		
		//create the block
		parent::__construct('aq_video_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'title' => '',
			'heading' => 'h4',
			'height' => '260',
			'video' => '',
			'type' => 'youtube',
			'id' => '',
			'class' => '',
			'style' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$videotype = array(
			'youtube' => 'Youtube',
			'vimeo' => 'Vimeo',
		);

		$heading_style = array(
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		);

		do_action( $id_base . '_before_form' , $instance );
		
		?>
		<div class="description half">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Title (optional)', 'flexmarket') ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('heading') ?>">
				<?php _e('Heading Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('heading', $block_id, $heading_style, $heading); ?>
			</label>
		</div>
		
		<div class="description">
			<label for="<?php echo $this->get_field_id('video') ?>">
				<?php _e('Video URL', 'flexmarket') ?>
				<?php echo aq_field_input('video', $block_id, $video, $size = 'full') ?>
				<em style="font-size: 0.8em; padding-left: 5px;">(<?php _e('example: ', 'flexmarket') ?><code>http://vimeo.com/51333291</code> or <code>http://youtu.be/iOiE6XMy0y8</code>)</em>
			</label>
		</div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('type') ?>">
				<?php _e('Video Type', 'flexmarket') ?><br/>
				<?php echo aq_field_select('type', $block_id, $videotype, $type); ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('height') ?>">
				<?php _e('Video Height', 'flexmarket') ?>
				<?php echo aq_field_input('height', $block_id, $height, $size = 'full') ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)', 'flexmarket') ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function block($instance) {
		extract($instance);
		
		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$class = (!empty($class) ? ' '. esc_attr($class) : '');
		$style = (!empty($style) ? ' style="'.esc_attr($style).'"' : '');

		$video = esc_url($video);

		switch ($type) {
			case 'youtube':
				$youtube = array(
					"http://youtu.be/",
					"http://www.youtube.com/watch?v=",
					"http://www.youtube.com/embed/"
					);
				$videonum = str_replace($youtube, "", $video);
				$videocode = 'http://www.youtube.com/embed/' . $videonum;
				break;
			case 'vimeo':
				$vimeo = array(
					"http://vimeo.com/",
					"http://player.vimeo.com/video/"
					);
				$videonum = str_replace($vimeo, "", $video);
				$videocode = 'http://player.vimeo.com/video/' . $videonum;
				break;
		}

		$output = (!empty($title) ? '<'.$heading.'>'.esc_attr($title).'</'.$heading.'>' : '' );;
		$output .= '<div'.$id.' class="video-box'.$class.'"'.$style.'>';
			$output .= '<iframe src="'.$videocode.'" width="100%" height="'.esc_attr($height).'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		$output .= '</div>';

		echo apply_filters( 'aq_video_block_output' , $output , $instance );
	}
	
}

/* AQ_Well_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Well_Block extends AQ_Block {
	
	/* PHP5 constructor */
	function __construct() {
		
		$block_options = array(
			'name' => __('Well Box','flexmarket'),
			'size' => 'span6',
		);
		
		//create the widget
		parent::__construct('aq_well_block', $block_options);
		
	}

	function form($instance) {
		echo '<p class="empty-column">',
		__('Drag block items into this well box', 'flexmarket'),
		'</p>';
		echo '<ul class="blocks column-blocks cf"></ul>';
	}
	
	function form_callback($instance = array()) {
		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;
		
		//insert the dynamic block_id & block_saving_id into the array
		$this->block_id = 'aq_block_' . $instance['number'];
		$instance['block_saving_id'] = 'aq_blocks[aq_block_'. $instance['number'] .']';
		
		extract($instance);
		
		$col_order = $order;
		
		//column block header
		if(isset($template_id)) {
			echo '<li id="template-block-'.$number.'" class="block block-aq_column_block '.$size.'">',
					'<div class="block-settings-column cf" id="block-settings-'.$number.'">',
						'<p class="empty-column">',
							__('Drag block items into this Well box', 'flexmarket'),
						'</p>',
						'<ul class="blocks column-blocks cf">';
					
			//check if column has blocks inside it
			$blocks = aq_get_blocks($template_id);
			
			//outputs the blocks
			if($blocks) {
				foreach($blocks as $key => $child) {
					global $aq_registered_blocks;
					extract($child);
					
					//get the block object
					$block = $aq_registered_blocks[$id_base];
					
					if($parent == $col_order) {
						$block->form_callback($child);
					}
				}
			} 
			echo 		'</ul>';
			
		} else {
			
	 		$title = $title ? '<span class="in-block-title"> : '.$title.'</span>' : '';
	 		$resizable = $resizable ? '' : 'not-resizable';
	 		
	 		echo '<li id="template-block-'.$number.'" class="block block-aq_column_block '. $size .' '.$resizable.'">',
	 				'<dl class="block-bar">',
	 					'<dt class="block-handle">',
	 						'<div class="block-title">',
	 							$name , $title, 
	 						'</div>',
	 						'<span class="block-controls">',
	 							'<a class="block-edit" id="edit-'.$number.'" title="Edit Block" href="#block-settings-'.$number.'">Edit Block</a>',
	 						'</span>',
	 					'</dt>',
	 				'</dl>',
	 				'<div class="block-settings cf" id="block-settings-'.$number.'">';

			$this->form($instance);
		}
				
		//form footer
		$this->after_form($instance);
	}
	
	//form footer
	function after_form($instance) {
		extract($instance);
		
		$block_saving_id = 'aq_blocks[aq_block_'.$number.']';
 		$userclass = !empty($userclass) ? esc_attr($userclass) : '';
 		$style = !empty($style) ? esc_attr($style) : '';

			echo '<div class="cf" style="height: 20px"></div>';
			echo 'Class (optional)<br/><input type="text" class="widefat" name="'.$this->get_field_name('userclass').'" value="'.$userclass.'" />';
			echo '<div class="cf" style="height: 10px"></div>';
			echo 'Additional inline css styling (optional)<br/><input type="text" class="widefat" name="'.$this->get_field_name('style').'" value="'.$style.'" />';
			echo '<div class="cf" style="height: 10px"></div>';
			echo '<div class="block-control-actions cf"><a href="#" class="delete">Delete</a></div>';
			echo '<input type="hidden" class="id_base" name="'.$this->get_field_name('id_base').'" value="'.$id_base.'" />';
			echo '<input type="hidden" class="name" name="'.$this->get_field_name('name').'" value="'.$name.'" />';
			echo '<input type="hidden" class="order" name="'.$this->get_field_name('order').'" value="'.$order.'" />';
			echo '<input type="hidden" class="size" name="'.$this->get_field_name('size').'" value="'.$size.'" />';
			echo '<input type="hidden" class="parent" name="'.$this->get_field_name('parent').'" value="'.$parent.'" />';
			echo '<input type="hidden" class="number" name="'.$this->get_field_name('number').'" value="'.$number.'" />';
		echo '</div>',
			'</li>';
	}
	
	function block_callback($instance) {
		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;
		
		extract($instance);
		
		$col_order = $order;
		$col_size = absint(preg_replace("/[^0-9]/", '', $size));
		
		//column block header
		if(isset($template_id)) {

	 		$column_class = $first ? 'aq-first' : '';

	 		$userclass = (!empty($userclass) ? ' ' . esc_attr($userclass).'"' : '');
	 		$style = (!empty($style) ? ' style="' . esc_attr($style).'"' : '');
	 		
	 		echo '<div id="aq-block-'.$number.'" class="aq-block aq-block-'.$id_base.' '.$size.' '.$column_class.' well cf'.$userclass.'"'.$style.'>';
			
			//define vars
			$overgrid = 0; $span = 0; $first = false;
			
			//check if column has blocks inside it
			$blocks = aq_get_blocks($template_id);
			
			//outputs the blocks
			if($blocks) {
				foreach($blocks as $key => $child) {
					global $aq_registered_blocks;
					extract($child);
					
					if(class_exists($id_base)) {
						//get the block object
						$block = $aq_registered_blocks[$id_base];
						
						//insert template_id into $child
						$child['template_id'] = $template_id;
						
						//display the block
						if($parent == $col_order) {
							
							$child_col_size = absint(preg_replace("/[^0-9]/", '', $size));
							
							$overgrid = $span + $child_col_size;
							
							if($overgrid > $col_size || $span == $col_size || $span == 0) {
								$span = 0;
								$first = true;
							}
							
							if($first == true) {
								$child['first'] = true;
							}
							
							$block->block_callback($child);
							
							$span = $span + $child_col_size;
							
							$overgrid = 0; //reset $overgrid
							$first = false; //reset $first
						}
					}
				}
			}

			echo '<div class="clear"></div>';
			echo '</div>'; 
			
			$this->after_block($instance);
			
		} else {
			//show nothing
		}
	}
	
}

/* AQ_Slider_Block
----------------------------------------------------------------------------------------------------------- */

class AQ_Slider_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => 'Slider Block',
			'size' => 'span12',
		);
		
		//create the widget
		parent::__construct('AQ_Slider_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_slide_add_new', array($this, 'add_slide'));
		
	}
	
	function form($instance) {
	
		$defaults = array(
			'title' => '',
			'slides' => array(
				1 => array(
					'title' => __( '1st Slide', 'flexmarket' ),
					'content' => '',
					'button' => 'yes',
					'btntext' => __('Learn More', 'flexmarket' ),
					'btncolor' => 'yellow',
					'linkopen' => 'same',
					'link' => '',
					'image' => '',
				)
			),
			'speed' => '4000',
			'pause' => 'yes',
			'showcontrolnav' => 'yes',
			'showdirectionnav' => 'yes',
			'class' => '',
			'style' => ''
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$pause_options = array(
			'yes' => __('Yes' , 'flexmarket' ),
			'no' => __('No' , 'flexmarket' ),
		);

		do_action( $id_base . '_before_form' , $instance );
		
		?>

		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$slides = is_array($slides) ? $slides : $defaults['slides'];
				$count = 1;
				foreach($slides as $slide) {	
					$this->slide($slide, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="slide" class="aq-sortable-add-new button"><?php _e( 'Add New' , 'flexmarket' ); ?></a>
			<p></p>
		</div>

		<div class="cf"></div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('speed') ?>">
				<?php _e( 'interval (in millisecond)' , 'flexmarket' ); ?><br/>
				<?php echo aq_field_input('speed', $block_id, $speed, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('pause') ?>">
				<?php _e( 'Pause on hover?' , 'flexmarket' ); ?><br/>
				<?php echo aq_field_select('pause', $block_id, $pause_options, $pause); ?>
			</label>
		</div>

		<div class="cf"></div>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('showcontrolnav') ?>">
				<?php _e( 'Show Control Nav' , 'flexmarket' ); ?><br/>
				<?php echo aq_field_select('showcontrolnav', $block_id, $pause_options, $showcontrolnav); ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('showdirectionnav') ?>">
				<?php _e( 'Show Direction Nav' , 'flexmarket' ); ?><br/>
				<?php echo aq_field_select('showdirectionnav', $block_id, $pause_options, $showdirectionnav); ?>
			</label>
		</div>

		<div class="cf"></div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e( 'class (optional)' , 'flexmarket' ); ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e( 'Additional inline css styling (optional)' , 'flexmarket' ); ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function slide($slide = array(), $count = 0) {

		$btncolor_options = array(
			'grey' => __('Grey', 'flexmarket' ),
			'blue' => __('Blue', 'flexmarket' ),
			'lightblue' => __('Light Blue', 'flexmarket' ),
			'green' => __('Green', 'flexmarket' ),
			'red' => __('Red', 'flexmarket' ),
			'yellow' => __('Yellow', 'flexmarket' ),
			'black' => __('Black', 'flexmarket' ),
		);

		$enablebtn_options = array(
			'yes' => __('Yes', 'flexmarket' ),
			'no' => __('No', 'flexmarket' ),
		);

		$linkopen_options = array(
			'same' => __('Same Window', 'flexmarket' ),
			'new' => __('New Window', 'flexmarket' )
		);

		?>
		<li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $slide['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e( 'Open / Close' , 'flexmarket' ); ?></a>
				</div>
			</div>
			
			<div class="sortable-body">
				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-title">
						<?php _e( 'Title' , 'flexmarket' ); ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][title]" value="<?php echo $slide['title'] ?>" />
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-content">
						<?php _e( 'Content' , 'flexmarket' ); ?><br/>
						<textarea id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $slide['content'] ?></textarea>
					</label>
				</div>

				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-image">
						<?php _e( 'Image' , 'flexmarket' ); ?> <em style="font-size: 0.8em;">(<?php _e( 'Recommended width: 1170 px' , 'flexmarket' ); ?>)</em><br/>
						<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-image" class="input-full input-upload" value="<?php echo $slide['image'] ?>" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][image]">
						<a href="#" class="aq_upload_button button" rel="image"><?php _e( 'Upload' , 'flexmarket' ); ?></a><p></p>
					</label>
				</div>

				<div class="tab-desc description two-third">
					<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-link">
						<?php _e( 'Link To' , 'flexmarket' ); ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][link]" value="<?php echo $slide['link'] ?>" />
					</label>
				</div>

				<div class="tab-desc description third last">
					<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-linkopen">
						<?php _e( 'Link Open In' , 'flexmarket' ); ?><br/>
						<select id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-linkopen" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][linkopen]">
							<?php 
								foreach($linkopen_options as $key=>$value) {
									echo '<option value="'.$key.'" '.selected( $slide['linkopen'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
							?>
						</select>
					</label>
				</div>				

				<div class="tab-desc description third">
					<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-button">
						<?php _e( 'Show Button' , 'flexmarket' ); ?><br/>
						<select id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-button" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][button]">
							<?php 
								foreach($enablebtn_options as $key=>$value) {
									echo '<option value="'.$key.'" '.selected( $slide['button'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
							?>
						</select>
						
					</label>
				</div>

				<div class="tab-desc description third">
					<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-btntext">
						<?php _e( 'Button Text' , 'flexmarket' ); ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-btntext" class="input-full" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][btntext]" value="<?php echo $slide['btntext'] ?>" />
					</label>
				</div>

				<div class="tab-desc description third last">
					<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-btncolor">
						<?php _e( 'Button Color' , 'flexmarket' ); ?><br/>
						<select id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-btncolor" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][btncolor]">
							<?php 
								foreach($btncolor_options as $key=>$value) {
									echo '<option value="'.$key.'" '.selected( $slide['btncolor'] , $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
							?>
						</select>
				</div>


				<p class="tab-desc description"><a href="#" class="sortable-delete"><?php _e( 'Delete' , 'flexmarket' ); ?></a></p>
			</div>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);

		$themefolder = get_template_directory_uri();
		
		$class = (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? ' style="'.esc_attr($style).'"' : '');

		$output = '<div id="slider-block-'.$block_id.'" class="flexslider slider-block'. ( !empty($showcontrolnav) ?  ( $showcontrolnav == 'no' ? '' : ' slider-control-nav' ) : ' slider-control-nav' ) .$class.'"'.$style.'>';
		$output .= '<ul class="slides">';

			if (!empty($slides)) {

				foreach( $slides as $slide ) {

					switch ($slide['btncolor']) {
						case 'grey':
							$btnclass = '';
							break;
						case 'blue':
							$btnclass = ' btn-primary';
							break;
						case 'lightblue':
							$btnclass = ' btn-info';
							break;
						case 'green':
							$btnclass = ' btn-success';
							break;
						case 'yellow':
							$btnclass = ' btn-warning';
							break;
						case 'red':
							$btnclass = ' btn-danger';
							break;
						case 'black':
							$btnclass = ' btn-inverse';
							break;
						
					}

					$output .= '<li class="single-slide">';					

					$output .= (!empty($slide['link']) ? '<a href="'.esc_url($slide['link']).'"'.($slide['linkopen'] == 'same' ? '' : ' target="_blank"').'>' : '');
					$output .= (!empty($slide['image']) ? '<img src="'.esc_url($slide['image']).'" class="slider-block-image" />' : '');
					$output .= (!empty($slide['link']) ? '</a>' : '');

					if (!empty($slide['content']) || !empty($slide['title']) || $slide['button'] == 'yes') {

						$output .= '<div class="single-slide-caption-container">';
							$output .= '<div class="single-slide-caption">';
								$output .= '<div class="row-fluid">';
									$output .= '<div class="'.($slide['button'] == 'yes' ? 'span9' : 'span12').'">';
										$output .= '<h4 class="single-slide-title">'.strip_tags($slide['title']).'</h4>';
										$output .= '<div class="single-slide-contents">' . wpautop(do_shortcode(strip_tags($slide['content']))) . '</div>';
									$output .= '</div>'; // end - span

									if ($slide['button'] == 'yes') {
										$output .= '<div class="span3">';
											$output .= '<div class="single-slide-btn-container">';
												$output .= '<a href="'.esc_url($slide['link']).'" class="single-slide-btn btn btn-12-19'.$btnclass.'">'.strip_tags($slide['btntext']).'</a>';
											$output .= '</div>'; // end - single-slide-btn-container
										$output .= '</div>'; // end - span
									}

								$output .= '</div>'; // end - row-fluid
							$output .= '</div>'; // end - single-slide-caption
						$output .= '</div>'; // end - slider-caption-container
					}
					
					$output .= '</li>'; // end - single-slide
				}
			}
		
		$output .= '</ul>'; // End slides

		$output .= '</div>'; // End slider-block

		$output .= '<script type="text/javascript">
						jQuery(document).ready(function () {
							jQuery("#slider-block-'.$block_id.'").flexslider({
								namespace: "flex-",
								selector: ".slides > li.single-slide",
								animation: "slide",
								smoothHeight: true,
								slideshowSpeed: '.esc_attr($speed).',
								controlNav: '. ( !empty($showcontrolnav) ? ( $showcontrolnav == 'no' ? "false" : "true" ) : "true" ).',
								directionNav: '.( !empty($showcontrolnav) ? ( $showdirectionnav == 'no' ? "false" : "true" ) : "true" ).',  
								'.($pause == 'yes' ? 'pauseOnHover: true,' : '').'
							});
						});
					</script>';
			
		echo apply_filters( 'aq_slider_block_output' , $output , $instance );
		
	}
	
	/* AJAX add testimonial */
	function add_slide() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the testimonial
		$slide = array(
			'title' => __('New Slide' , 'flexmarket' ),
			'content' => '',
			'button' => 'yes',
			'btntext' => __('Learn More' , 'flexmarket' ),
			'btncolor' => 'yellow',
			'linkopen' => 'same',
			'link' => '',
			'image' => '',
		);
		
		if($count) {
			$this->slide($slide, $count);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}
}