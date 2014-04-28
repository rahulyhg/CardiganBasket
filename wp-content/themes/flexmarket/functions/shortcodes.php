<?php 

/**
 * Button Shortcode.
 *
 **/

add_shortcode('button', 'tboot_button');
function tboot_button($atts, $content = null) {
	extract(shortcode_atts(array(
				"link" => "#",
				"color" => "grey",
				"size" => "normal",
				"icon" => "no",
				"icontype" => "",
				"whiteicon" => "no",
				"id" => '',
				"class" => ''
			), $atts));
	
	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? ' '.esc_attr($class) : '');
	$iconclass = '';
	
	$f_content = esc_attr($content);

	if ($link != '#') { 
		$f_link = esc_url($link);
	} else {
		$f_link = '';
	}


	if (!empty($icontype)) { $iconclass .= esc_attr(trim($icontype));}
	if ($whiteicon == 'yes') { $iconclass .= ' icon-white';}
	
	if ($icon == 'yes' && !empty($icontype)) {
		$iconoutput = '<i class="'.$iconclass.'"></i> ';
	} else {
		$iconoutput = '';
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

	switch ($size) {
		case 'normal':
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
	}
	
		
	return '<p><a href="'.$f_link.'"><button'.$id.' class="btn'.$class.'" >'.$iconoutput.$f_content.'</button></a></p>';
}

/**
 * Image Shortcode.
 *
 **/

add_shortcode('image', 'tboot_image');
function tboot_image($atts) {
	extract(shortcode_atts(array(
				"file" => "",
				"link" => "",
				"type" => "rounded",
				"align" => "",
				"id" => '',
				"class" => ''
			), $atts));

	$imagefile = esc_url($file);
	$output = '';
	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? esc_attr($class).' ' : '');
	$linkclassfront = '';
	$linkclassback = '';

	if (!empty($link)) {
		$imagelink = esc_url($link);
		$linkclassfront = '<a href="'.$imagelink.'">';
		$linkclassback = '</a>';
	} 

	if (!empty($align)) {

		switch ($align) {
			case 'left':
				$alignclass = 'pull-left';
				break;
			case 'right':
				$alignclass = 'pull-right';
				break;
		}
	} else {
		$clear = '<div class="clear padding5"></div>';
	}

	switch ($type) {
		case 'rounded':
			$class .= 'img-rounded';
			break;
		case 'circle':
			$class .= 'img-circle';
			break;
		case 'polaroid':
			$class .= 'img-polaroid';
			break;	
	}

	$output .= $clear;
	$output .= '<div class="'.$alignclass.'">';
	$output .= $linkclassfront;
	$output .= '<img src="'.$imagefile.'" class="'.$class.'"'.$id.'" />';
	$output .= $linkclassback;
	$output .= '</div>';

	if (!empty($file)) {
		return $output;
	} else {
		return '';
	}

}

/**
 * Code Wrapper Shortcode.
 *
 **/

add_shortcode('code', 'tboot_code');
function tboot_code($atts, $content = null) {
	
	$output = '';

	$output .= '<p><code>';
	$output .= esc_attr($content);
	$output .= '</code></p>';
	
	
	return $output;
}

add_shortcode('pre', 'tboot_pre');
function tboot_pre($atts, $content = null) {
	
	$output = '';

	$output .= '<pre>';
	$output .= mpt_content_kses($content);
	$output .= '</pre>';
	
	
	return $output;
}

/**
 * Table Shortcode.
 *
 **/

add_shortcode('table', 'tboot_table');
function tboot_table($atts, $content = null) {
	extract(shortcode_atts(array(
				"type" => "",
				"id" => '',
				"class" => ''
			), $atts));

	$content = mpt_content_kses($content);

	$output = '';
	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'table '. esc_attr($class) : 'table');

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

	$output .= '<table'.$id.' class="'.$class.'">';
	$output .= do_shortcode($content);
	$output .= '</table>';

	return $output;

}

add_shortcode('tr', 'tboot_tr');
function tboot_tr($atts, $content = null) {
	extract(shortcode_atts(array(
				"color" => "",
				"id" => '',
				"class" => ''
			), $atts));

	$content = mpt_content_kses($content);

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? esc_attr($class).' ' : '');

	$output = '';

	switch ($color) {
		case 'green':
			$class .= 'success';
			break;
		case 'red':
			$class .= 'error';
			break;
		case 'blue':
			$class .= 'info';
			break;	
		case 'yellow':
			$class .= 'warning';
			break;	
	}

	$instance = (!empty($id) ? $id : '');
	$instance = (!empty($class) ? ' class="'.$class.'"' : '');

	$output .= '<tr'.$instance.'">';
	$output .= do_shortcode($content);
	$output .= '</tr>';

	return $output;

}

add_shortcode('td', 'tboot_td');
function tboot_td($atts, $content = null) {

	extract(shortcode_atts(array(
				"id" => '',
				"class" => ''
			), $atts));

	$instance = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$instance = (!empty($class) ? ' class="'.esc_attr($class).'"' : '');

	$output = mpt_content_kses($content);

	return '<td'.$instance.'>'.do_shortcode($output).'</td>';

}


/**
 * Labels Shortcode.
 *
 **/

add_shortcode('label', 'tboot_label');
function tboot_label($atts, $content = null) {

	extract(shortcode_atts(array(
				"color" => '',
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'label ' . esc_attr($class) : 'label');

	$content = mpt_content_kses($content);

	switch ($color) {
		case 'green':
			$class .= ' label-success';
			break;
		case 'red':
			$class .= ' label-important';
			break;
		case 'blue':
			$class .= ' label-info';
			break;	
		case 'yellow':
			$class .= ' label-warning';
			break;	
		case 'black':
			$class .= ' label-inverse';
			break;	
	}

	return '<span'.$id.' class="'.$class.'">'.$content.'</span>';

}

/**
 * Badges Shortcode.
 *
 **/

add_shortcode('badge', 'tboot_badge');
function tboot_badge($atts, $content = null) {

	extract(shortcode_atts(array(
				"color" => '',
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'badge ' . esc_attr($class) : 'badge');

	$content = mpt_content_kses($content);

	switch ($color) {
		case 'green':
			$class .= ' badge-success';
			break;
		case 'red':
			$class .= ' badge-important';
			break;
		case 'blue':
			$class .= ' badge-info';
			break;	
		case 'yellow':
			$class .= ' badge-warning';
			break;	
		case 'black':
			$class .= ' badge-inverse';
			break;	
	}

	return '<span'.$id.' class="'.$class.'">'.$content.'</span>';

}

/**
 * hero unit shortcode
 *
 **/

add_shortcode('hero', 'tboot_hero_unit');
function tboot_hero_unit($atts, $content = null) {

	extract(shortcode_atts(array(
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'hero-unit ' . esc_attr($class) : 'hero-unit');

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<div'.$id.' class="'.$class.'">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

add_shortcode('herotitle', 'tboot_hero_unit_title');
function tboot_hero_unit_title($atts, $content = null) {

	extract(shortcode_atts(array(
				"heading" => 'h1',
				"id" => '',
				"class" => ''
			), $atts));

	$heading = esc_attr($heading);
	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? ' class="' . esc_attr($class).'"' : '');

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<'.$heading.''.$id.$class.'>';
	$output .= $content;
	$output .= '</'.$heading.'>';

	return $output;
}

add_shortcode('herocontents', 'tboot_hero_unit_contents');
function tboot_hero_unit_contents($atts, $content = null) {

	extract(shortcode_atts(array(
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? ' class="' . esc_attr($class).'"' : '');

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<p'.$id.$class.'>';
	$output .= $content;
	$output .= '</p>';

	return $output;
}

/**
 * Page Header shortcode
 *
 **/

add_shortcode('pageheader', 'tboot_page_header');
function tboot_page_header($atts, $content = null) {

	extract(shortcode_atts(array(
				"heading" => 'h1',
				"style" => '',
				"id" => '',
				"class" => ''
			), $atts));

	$heading = esc_attr($heading);
	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? ' class="page-header ' . esc_attr($class).'"' : ' class="page-header"');
	$style = (!empty($style) ? ' style="' . esc_attr($style).'"' : '');

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<'.$heading.''.$id.$class.$style.'>';
	$output .= $content;
	$output .= '</'.$heading.'>';

	return $output;
}

/**
 * Alerts Message shortcode
 *
 **/

add_shortcode('alert', 'tboot_alert_message');
function tboot_alert_message($atts, $content = null) {

	extract(shortcode_atts(array(
				"type" => '',
				"title" => '',
				"block" => false,
				"close" => true,
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'alert ' . esc_attr($class).'"' : 'alert');

	$class .= ($block == 'true' ? ' alert-block' : '');

	switch ($type) {
		case 'success':
			$class .= ' alert-success';
			break;
		case 'error':
			$class .= ' alert-error';
			break;
		case 'info':
			$class .= ' alert-info';
			break;	
	}

	$title = esc_attr($title);

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<div'.$id.' class="'.$class.'">';
	$output .= ($close == 'true' ? '<button type="button" class="close" data-dismiss="alert">×</button>' : '');
	$output .= ($block == 'true' ? (!empty($title) ? '<h4>'.$title.'</h4>' : '') : (!empty($title) ? '<strong>'.$title.'</strong> ' : ''));
	$output .= $content;
	$output .= '</div>';

	return $output;
}

/**
 * Well Box shortcode
 *
 **/

add_shortcode('well', 'tboot_well_box');
function tboot_well_box($atts, $content = null) {

	extract(shortcode_atts(array(
				"type" => '',
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'well ' . esc_attr($class).'"' : 'well');

	switch ($type) {
		case 'large':
			$class .= ' well-large';
			break;
		case 'small':
			$class .= ' well-small';
			break;
	}


	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<div'.$id.' class="'.$class.'">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

/**
 * Columns shortcode
 *
 **/
add_shortcode('row', 'tboot_row_fluid');
function tboot_row_fluid($atts, $content = null) {

	extract(shortcode_atts(array(
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'row-fluid ' . esc_attr($class) : 'row-fluid');

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<div'.$id.' class="'.$class.'">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

add_shortcode('one_half', 'tboot_one_half');
function tboot_one_half($atts, $content = null) {

	extract(shortcode_atts(array(
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'span6 ' . esc_attr($class) : 'span6');

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<div'.$id.' class="'.$class.'">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

add_shortcode('one_third', 'tboot_one_third');
function tboot_one_third($atts, $content = null) {

	extract(shortcode_atts(array(
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'span4 ' . esc_attr($class) : 'span4');

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<div'.$id.' class="'.$class.'">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

add_shortcode('two_third', 'tboot_two_third');
function tboot_two_third($atts, $content = null) {

	extract(shortcode_atts(array(
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'span8 ' . esc_attr($class) : 'span8');

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<div'.$id.' class="'.$class.'">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

add_shortcode('one_fourth', 'tboot_one_fourth');
function tboot_one_fourth($atts, $content = null) {

	extract(shortcode_atts(array(
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? 'span3 ' . esc_attr($class) : 'span3');

	$content = mpt_content_kses($content);
	$output = '';

	$output .= '<div'.$id.' class="'.$class.'">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

/**
 * Tooltip Shortcode
 *
 **/

add_shortcode('tooltip', 'tboot_tooltip');
function tboot_tooltip($atts, $content = null) {

	extract(shortcode_atts(array(
				"link" => '#',
				"title" => '',
				"placement" => 'top',
				"trigger" => 'hover',
				"id" => '',
				"class" => ''
			), $atts));

	$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
	$class = (!empty($class) ? ' class="tool-tip ' . esc_attr($class) . '"' : ' class="tool-tip"');

	$output = '';

	$output .= '<a href="'.esc_url($link).'" rel="tooltip" data-title="'.esc_attr($title).'" data-placement="'.esc_attr($placement).'" data-trigger="'.esc_attr($trigger).'" data-html="false"'.$id.$class.'>';
	$output .= esc_attr($content);
	$output .= '</a>';

	return $output;
}


/**
 * Other functions.
 *
 **/

	function mpt_content_kses($content) {
	
		$output = wp_kses($content, array(
						'a' => array(
							'href' => array(),
							'title' => array(),
							'target' => array()
							),
						'br' => array(),
						'em' => array(),
						'strong' => array() 
						)); 

		return trim($output);
	}

?>