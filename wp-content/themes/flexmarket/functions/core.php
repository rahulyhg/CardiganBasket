<?php

/**
 * general setting functions.
 *
 */

	// load site logo
	function mpt_load_site_logo() {
		$themefolder = get_template_directory_uri();
		$mpt_logo_upload = esc_url(get_option('mpt_sitelogo'));
		if(!empty($mpt_logo_upload)) {
			echo '<center><a href="'.home_url().'"><img src="'.$mpt_logo_upload.'" alt="" /></a></center>';
		 } else {
			echo '<center><a href="'.home_url().'"><img src="'.$themefolder.'/img/site-logo.png" alt="" /></a></center>';
		}
	}

	//load site favicon
	function mpt_load_favicon() {
		$mpt_favicon_upload = esc_url(get_option('mpt_favicon'));
		if(!empty($mpt_favicon_upload)) {
			echo $mpt_favicon_upload;
		 } else {
			echo '';
		}
	}

	//load footer text
	function mpt_load_footer_text() {
		$customfooter = get_option('mpt_cus_footer');
		$custom = wp_kses( $customfooter, array(
					'a' => array(
						'href' => array(),
						'title' => array()
						),
					'br' => array(),
					'em' => array(),
					'strong' => array() 
					) ); 
		$date = date("Y");
		$sitename = esc_attr(get_bloginfo('name'));
			if(!empty($custom)) {
				echo '<p>'.$custom.'</p>';
			 } else {
				echo '<p>Copyright &copy;'.$date.' '.$sitename.'</p>';
			}
	}
	
/**
 * Styling Options.
 *
 */	

	function mpt_load_base_style() {
		$themefolder = get_template_directory_uri();

		echo '<link href="'.$themefolder.'/styles/color-black.css" type="text/css" rel="stylesheet" />';
	}
	
	function mpt_load_google_web_font_header() {
		$selected = get_option('mpt_theme_header_font');
		$customfont = get_option('mpt_theme_custom_web_font');
		$customheaderfont = esc_attr(get_option('mpt_theme_custom_web_font_header'));

		if ($customfont != 'true' || empty($customheaderfont)) {
			$selected = str_replace(' ', '+', $selected);
			echo '<link href="http://fonts.googleapis.com/css?family='.$selected.'" rel="stylesheet" type="text/css">';
		}
	}
	
	function mpt_load_google_web_font_body() {
		$selected = get_option('mpt_theme_body_font');
		$customfont = get_option('mpt_theme_custom_web_font');
		$custombodyfont = esc_attr(get_option('mpt_theme_custom_web_font_body'));

		if ($customfont != 'true' || empty($custombodyfont)) {
			$selected = str_replace(' ', '+', $selected);
			echo '<link href="http://fonts.googleapis.com/css?family='.$selected.'" rel="stylesheet" type="text/css">';
		}
	}

	function mpt_load_custom_google_font_header() {
		$customfont = get_option('mpt_theme_custom_web_font');
		$customheaderfont = esc_attr(get_option('mpt_theme_custom_web_font_header'));

		if ($customfont == 'true' && !empty($customheaderfont)) {
			echo '<link href="http://fonts.googleapis.com/css?family='.$customheaderfont.'" rel="stylesheet" type="text/css">';
		}
	}

	function mpt_load_custom_google_font_body() {
		$customfont = get_option('mpt_theme_custom_web_font');
		$custombodyfont = esc_attr(get_option('mpt_theme_custom_web_font_body'));

		if ($customfont == 'true' && !empty($custombodyfont)) {
			echo '<link href="http://fonts.googleapis.com/css?family='.$custombodyfont.'" rel="stylesheet" type="text/css">';
		}
	}

	function mpt_load_bg_patterns($bgpattern) {
		$themefolder =  get_template_directory_uri();
		switch ($bgpattern) {
			case 'pattern_1':
				return "background-image: url('".$themefolder."/img/patterns/pat_01.png');";
			break;
			case 'pattern_2':
				return "background-image: url('".$themefolder."/img/patterns/pat_02.png');";
			break;
			case 'pattern_3':
				return "background-image: url('".$themefolder."/img/patterns/pat_03.png');";
			break;
			case 'pattern_4':
				return "background-image: url('".$themefolder."/img/patterns/pat_04.png');";
			break;
			case 'pattern_5':
				return "background-image: url('".$themefolder."/img/patterns/pat_05.png');";
			break;
			case 'pattern_6':
				return "background-image: url('".$themefolder."/img/patterns/pat_06.png');";
			break;
			case 'pattern_7':
				return "background-image: url('".$themefolder."/img/patterns/pat_07.png');";
			break;
			case 'pattern_8':
				return "background-image: url('".$themefolder."/img/patterns/pat_08.png');";
			break;
			case 'pattern_9':
				return "background-image: url('".$themefolder."/img/patterns/pat_09.png');";
			break;
			case 'pattern_10':
				return "background-image: url('".$themefolder."/img/patterns/pat_10.png');";
			break;

		}
	}	
	
/**
 * Footer Setting functions.
 *
 */	

	function mpt_footer_widget_setting_1() {
		$selected = get_option('mpt_footer_widget_setting');
		if($selected == 'widget633') {
				echo '6';
		} elseif ($selected == 'widget336') {
				echo '3';
		} else {
				echo '4';
		}
	}
	
	function mpt_footer_widget_setting_2() {
		$selected = get_option('mpt_footer_widget_setting');
		if($selected == 'widget633') {
				echo '3';
		} elseif ($selected == 'widget336') {
				echo '3';
		} else {
				echo '4';
		}
	}
	
	function mpt_footer_widget_setting_3() {
		$selected = get_option('mpt_footer_widget_setting');
		if($selected == 'widget633') {
				echo '3';
		} elseif ($selected == 'widget336') {
				echo '6';
		} else {
				echo '4';
		}
	}


/**
 * Social Icon functions.
 *
 */	

	function mpt_social_icon_section() {

		for ($i=1; $i < 9; $i++) { 
			
			$profileurl = esc_url(get_option('mpt_social_icon_'.$i.'_url'));
			$selected = get_option('mpt_social_icon_'.$i.'_icon');

			switch ( $selected ) {
				case 'Facebook':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Facebook"><i class="icon-facebook-sign icon-large"></i></a></li>';
					break;

				case 'Dribbble':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Dribbble"><i class="icon-dribbble icon-large"></i></a></li>';
					break;

				case 'Flickr':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Flickr"><i class="icon-flickr icon-large"></i></a></li>';
					break;

				case 'FourSquare':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="FourSquare"><i class="icon-foursquare icon-large"></i></a></li>';
					break;

				case 'Google Plus':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Google Plus"><i class="icon-google-plus-sign icon-large"></i></a></li>';
					break;

				case 'Instagram':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Instagram"><i class="icon-instagram icon-large"></i></a></li>';
					break;

				case 'Linkedin':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Linkedin"><i class="icon-linkedin-sign icon-large"></i></a></li>';
					break;

				case 'Pinterest':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Pinterest"><i class="icon-pinterest-sign icon-large"></i></a></li>';
					break;

				case 'RenRen':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="RenRen"><i class="icon-renren icon-large"></i></a></li>';
					break;

				case 'Skype':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Skype"><i class="icon-skype icon-large"></i></a></li>';
					break;

				case 'Tumblr':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Tumblr"><i class="icon-tumblr-sign icon-large"></i></a></li>';
					break;				

				case 'Twitter':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Twitter"><i class="icon-twitter-sign icon-large"></i></a></li>';
					break;

				case 'VK':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="VK"><i class="icon-vk icon-large"></i></a></li>';
					break;				

				case 'Weibo':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Weibo"><i class="icon-weibo icon-large"></i></a></li>';
					break;

				case 'Xing':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="Xing"><i class="icon-xing icon-large"></i></a></li>';
					break;				

				case 'YouTube':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="YouTube"><i class="icon-youtube-sign icon-large"></i></a></li>';
					break;

				case 'RSS':
					echo '<li><a href="'.( $profileurl ? $profileurl : '#' ).'" target="_blank" Title="RSS"><i class="icon-rss-sign icon-large"></i></a></li>';
					break;

				case 'None':
				default:
					echo '';
					break;
			}

		}
	}
	
/**
 * SEO functions.
 *
 */	
	//load site title
	function mpt_load_site_title() {
		$customtitle = esc_attr(get_option('mpt_cus_title'));
		$selected = get_option('mpt_enable_custom_title');
		$blogtitle = esc_attr(get_bloginfo('name'));
		if($selected == 'true') {
			if(!empty($customtitle)) {
				echo $customtitle;
			 } else {
				echo $blogtitle;
			}
		} else {
				echo $blogtitle;
			}
	}
	
	//load meta description
	function mpt_load_meta_desc() {
		$metadesc = esc_attr(get_option('mpt_cus_meta_desc'));
		$selected = get_option('mpt_enable_meta_desc');
		$blogdesc = esc_attr(get_bloginfo('description'));
		if($selected == 'true') {
			if(!empty($metadesc)) {
				echo $metadesc;
			 } else {
				echo $blogdesc;
			}
		} else {
				echo $blogdesc;
			}
	}

	//load meta keywords
	function mpt_load_meta_keywords() {
		$metakey = esc_attr(get_option('mpt_cus_meta_keywords'));
		$selected = get_option('mpt_enable_meta_keywords');
		if($selected == 'true') {
			if(!empty($metakey)) {
				echo $metakey;
			 } else {
				echo '';
			}
		} else {
				echo '';
			}
	}

/**
 * Code Integration function.
 *
 */
	function mpt_load_header_code() {
		$headercode = get_option('mpt_header_code');
		$selected = get_option('mpt_enable_header_code');
		if($selected == 'true') {
			if(!empty($headercode)) {
				echo $headercode;
			 }
		}
	}

	function mpt_load_body_code() {
		$bodycode = get_option('mpt_body_code');
		$selected = get_option('mpt_enable_body_code');
		if($selected == 'true') {
			if(!empty($bodycode)) {
				echo $bodycode;
			 }
		}
	}
	
	function mpt_load_top_code() {
		$topcode = get_option('mpt_top_code');
		$selected = get_option('mpt_enable_top_code');
		if($selected == 'true') {
			if(!empty($topcode)) {
				echo $topcode.'<div class="clear padding10"></div>';
			 }
		}
	}
	
	function mpt_load_bottom_code() {
		$bottomcode = get_option('mpt_bottom_code');
		$selected = get_option('mpt_enable_bottom_code');
		if($selected == 'true') {
			if(!empty($bottomcode)) {
				echo $bottomcode.'<div class="clear padding10"></div>';
			 }
		}
	}

/**
 * Post Functions.
 *
 */

	function mpt_load_featured_image( $args = array() ) {

	  	$defaults = array(
			'echo' => false,
			'post_id' => NULL,
			'content_type' => 'single',
			'imagesize' => 'full',
			'prettyphoto' => false,
			'btnclass' => '',
			'iconclass' => '',
		);

	  	$instance = wp_parse_args( $args, $defaults );
	  	extract( $instance );

	  	global $id;
	  	$post_id = ( NULL === $post_id ) ? $id : $post_id;

		$fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $imagesize );

		if ( $image[1] < 360 ) {
			$style = ' style="max-width: 360px;"';
		} elseif ( $image[1] < 560 ) {
			$style = ' style="max-width: 560px;"';
		} else {
			$style = ' style="max-width: 860px;"';
		}

		$output = '<div class="featured-image-box add-fadeinup-effects-parent"'.$style.'>';

			$output .= '<div class="hover-btn add-fadeinup-effects-child">';

			if ($prettyphoto == 'true') {
				$output .= '<a href="'.$fullimage[0].'" class="btn btn-flat btn-block btn-block-20'.$btnclass.'" rel="prettyPhoto"><i class="icon-search'.$iconclass.'"></i>'.__( ' View Image' , 'flexmarket' ).'</a>';
			} else {
				$output .= '<a href="'.get_permalink( $post_id ).'" class="btn btn-flat btn-block btn-block-20'.$btnclass.'"><i class="icon-search'.$iconclass.'"></i>'.__( ' Read Post' , 'flexmarket' ).'</a>';
			}

			$output .= '</div>'; // End hover-btn

		if ($prettyphoto == 'true') {
			$output .= '<a href="'.$fullimage[0].'" rel="prettyPhoto">';
		} else {
			$output .= '<a href="'.get_permalink($post_id).'" >';
		}
				$output .= get_the_post_thumbnail( $post_id , $imagesize );

			$output .= '</a>';

		$output .= '</div>'; // End image-box
		
	  	if ($echo)
	    	echo apply_filters( 'func_mpt_load_featured_image' , $output , $instance );
	  	else
	    	return apply_filters( 'func_mpt_load_featured_image' , $output , $instance );
	}

	function mpt_load_image_carousel( $args = array() ) {

	  	$defaults = array(
			'echo' => false,
			'post_id' => NULL,
			'content_type' => 'single',
			'imagesize' => 'full',
			'prettyphoto' => false,
			'btnclass' => '',
			'iconclass' => '',
		);

	  	$instance = wp_parse_args( $args, $defaults );
	  	extract( $instance );

	  	global $id;
	  	$post_id = ( NULL === $post_id ) ? $id : $post_id;

		$image1 = get_post_meta( $id, '_mpt_video_featured_image_2', true );
		$imageurl1 = esc_url($image1);
		$image2 = get_post_meta( $id, '_mpt_video_featured_image_3', true );
		$imageurl2 = esc_url($image2);
		$fullimage = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full');

		$output = '<div class="flexslider featured-image-slider">';
			$output .= '<ul class="slides">';
				// silde 1
				$output .= '<li>';
					$output .= ( $prettyphoto == 'true' ? '<a href="'.$fullimage[0].'" rel="prettyPhoto[carousel-'.$post_id.']">' : '<a href="'.get_permalink($post_id).'">' );
						$output .= '<img src="'.$fullimage[0].'" />';
					$output .= '</a>';
				$output .= '</li>';

				// slide 2
				$output .= '<li>';
					$output .= ( $prettyphoto == 'true' ? '<a href="'.$imageurl1.'" rel="prettyPhoto[carousel-'.$post_id.']">' : '<a href="'.get_permalink($post_id).'">' );
						$output .= '<img src="'.$imageurl1.'" />';
					$output .= '</a>';
				$output .= '</li>';

				// slide 3
				$output .= '<li>';
					$output .= ( $prettyphoto == 'true' ? '<a href="'.$imageurl2.'" rel="prettyPhoto[carousel-'.$post_id.']">' : '<a href="'.get_permalink($post_id).'">' );
						$output .= '<img src="'.$imageurl2.'" />';
					$output .= '</a>';
				$output .= '</li>';

			$output .= '</ul>';
		$output .= '</div>';

		$output .= '<script type="text/javascript">jQuery(document).ready(function () {
						jQuery(".featured-image-slider").flexslider({
							namespace: "flex-",
							selector: ".slides > li",
							animation: "fade",
							slideshow: '.( $content_type == 'single' ? 'true' : 'false' ).',
							animationLoop: false,
							smoothHeight: true,
						});
					});</script>';
		
	  	if ($echo)
	    	echo apply_filters( 'func_mpt_load_image_carousel' , $output , $instance );
	  	else
	    	return apply_filters( 'func_mpt_load_image_carousel' , $output , $instance );
	}

	function get_image_id($image_url) {
		global $wpdb;
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_url'";
		$id = $wpdb->get_var($query);
		return $id;
	}

	function mpt_load_video_post( $args = array() ) {

	  	$defaults = array(
			'echo' => false,
			'post_id' => NULL,
			'content_type' => 'single',
			'imagesize' => 'full',
			'prettyphoto' => false,
			'videoheight' => 195,
			'btnclass' => '',
			'iconclass' => '',
		);

	  	$instance = wp_parse_args( $args, $defaults );
	  	extract( $instance );

	  	global $id;
	  	$post_id = ( NULL === $post_id ) ? $id : $post_id;
		
		$video = get_post_meta( $post_id, '_mpt_post_video_url', true );
		$videourl = esc_url($video);
		$videotype = get_post_meta( $post_id, '_mpt_post_video_type', true );
		$videocode = '';

		if (!empty($videoheight)) {
			$videoheight = ' height="'.$videoheight.'"';
		}

		switch ($videotype) {
			case 'youtube':
				$youtube = array(
					"http://youtu.be/",
					"http://www.youtube.com/watch?v=",
					"http://www.youtube.com/embed/"
					);
				$videonum = str_replace($youtube, "", $videourl);
				$videocode = 'http://www.youtube.com/embed/' . $videonum;
				break;
			case 'vimeo':
				$vimeo = array(
					"http://vimeo.com/",
					"http://player.vimeo.com/video/"
					);
				$videonum = str_replace($vimeo, "", $videourl);
				$videocode = 'http://player.vimeo.com/video/' . $videonum;
				break;
		}

		$output = '<div class="video-box">';
			$output .= '<iframe src="'.$videocode.'?title=1&amp;byline=1&amp;portrait=1" width="100%"'.$videoheight.' frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		$output .= '</div>';
		
	  	if ($echo)
	    	echo apply_filters( 'func_mpt_load_video_post' , $output , $instance );
	  	else
	    	return apply_filters( 'func_mpt_load_video_post' , $output , $instance );
	}


/**
 * MarketPress Settings Functions.
 *
 */

	function mpt_load_mp_btn_color() {
		$selected = get_option('mpt_mp_main_btn_color');

		switch ($selected) {
			case 'Grey':
				$class = '';
				break;
			case 'Blue':
				$class = ' btn-primary';
				break;
			case 'Light Blue':
				$class = ' btn-info';
				break;
			case 'Green':
				$class = ' btn-success';
				break;
			case 'Yellow':
				$class = ' btn-warning';
				break;
			case 'Red':
				$class = ' btn-danger';
				break;
			case 'Black':
				$class = ' btn-inverse';
				break;
			
			default:
				$class = ' btn-inverse';
				break;
		}

		return $class;
	}

	function mpt_load_whiteicon_in_btn() {
		$selected = get_option('mpt_mp_main_btn_color');

		switch ($selected) {
			case 'Grey':
				$class = '';
				break;
			case 'Blue':
				$class = ' icon-white';
				break;
			case 'Light Blue':
				$class = ' icon-white';
				break;
			case 'Green':
				$class = ' icon-white';
				break;
			case 'Yellow':
				$class = ' icon-white';
				break;
			case 'Red':
				$class = ' icon-white';
				break;
			case 'Black':
				$class = ' icon-white';
				break;
			
			default:
				$class = ' icon-white';
				break;
		}

		return $class;
	}

	function mpt_load_icontag_color() {
		$selected = get_option('mpt_mp_main_icon_tag_color');

		switch ($selected) {
			case 'White':
				$class = ' icon-white';
				break;
			case 'Blue':
				$class = ' icon-blue';
				break;
			case 'Light Blue':
				$class = ' icon-lightblue';
				break;
			case 'Green':
				$class = ' icon-green';
				break;
			case 'Yellow':
				$class = ' icon-yellow';
				break;
			case 'Red':
				$class = ' icon-red';
				break;
			case 'Black':
				$class = '';
				break;
			
			default:
				$class = '';
				break;
		}

		return $class;
	}

	function mpt_load_product_listing_layout() {
		$selected = get_option('mpt_mp_listing_layout');

		switch ($selected) {
			case '2 Columns':
				return 'span6';
				break;
			case '3 Columns':
				return 'span4';
				break;
			case '4 Columns':
				return 'span3';
				break;
			
			default:
				return 'span4';
				break;
		}

	}

	function mpt_load_product_listing_counter() {
		$selected = get_option('mpt_mp_listing_layout');

		switch ($selected) {
			case '2 Columns':
				return '2';
				break;
			case '3 Columns':
				return '3';
				break;
			case '4 Columns':
				return '4';
				break;
			
			default:
				return '3';
				break;
		}
	}

	function mpt_enable_advanced_sort() {

		if (get_option('mpt_enable_advanced_sort') == 'true') 
			return true;
		else 
			return false;
	}

	function mpt_advanced_sort_btn_position() {
		$selected = get_option('mpt_advanced_soft_btn_position');

		switch ($selected) {
			case 'Left':
				return 'align-left';
				break;
			case 'Center':
				return 'align-center';
				break;
			case 'Right':
				return 'align-right';
				break;
			
			default:
				return 'align-right';
				break;
		}
	}

?>