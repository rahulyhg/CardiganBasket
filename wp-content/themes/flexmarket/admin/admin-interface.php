<?php
// Admin Interface

$functions_path = get_template_directory() . '/';
function siteoptions_add_admin() {
    global $query_string;
    if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'siteoptions' ) {
		if (isset($_REQUEST['m413_save']) && 'reset' == $_REQUEST['m413_save']) {
			$options =  get_option('m413_template');
			of_reset_options($options,'siteoptions');
			header("Location: admin.php?page=siteoptions&reset=true");
			die;
		}
    }
    $mbb_page = add_theme_page('Theme Options', 'Theme Options', 'edit_theme_options', 'siteoptions','siteoptions_options_page');
	add_action("admin_print_scripts-$mbb_page", 'm413_load_only');
	add_action("admin_print_styles-$mbb_page",'m413_style_only');
}
add_action('admin_menu', 'siteoptions_add_admin');

// reset options

function of_reset_options($options,$page = ''){
	global $wpdb;
	$query_inner = '';
	$count = 0;
	$excludes = array( 'blogname' , 'blogdescription' );
	foreach($options as $option){
		if(isset($option['id'])){
			$count++;
			$option_id = $option['id'];
			$option_type = $option['type'];
			//Skip assigned id's
			if(in_array($option_id,$excludes)) { continue; }
			if($count > 1){ $query_inner .= ' OR '; }
			if($option_type == 'multicheck'){
				$multicount = 0;
				foreach($option['options'] as $option_key => $option_option){
					$multicount++;
					if($multicount > 1){ $query_inner .= ' OR '; }
					$query_inner .= "option_name = '" . $option_id . "_" . $option_key . "'";
				}
			} else if(is_array($option_type)) {
				$type_array_count = 0;
				foreach($option_type as $inner_option){
					$type_array_count++;
					$option_id = $inner_option['id'];
					if($type_array_count > 1){ $query_inner .= ' OR '; }
					$query_inner .= "option_name = '$option_id'";
				}
			} else {
				$query_inner .= "option_name = '$option_id'";
			}
		}
	}
	//When Theme Options page is reset - Add the m413_options option
	if($page == 'siteoptions'){
		$query_inner .= " OR option_name = 'm413_options'";
	}
	//echo $query_inner;
	$query = "DELETE FROM $wpdb->options WHERE $query_inner";
	$wpdb->query($query);
}

// create options page

function siteoptions_options_page(){
    $options =  get_option('m413_template');
    $themename =  get_option('m413_themename');
?>

<div class="wrap" id="m413_container">
  <div id="m413-popup-save" class="m413-save-popup">
    <div class="m413-save-save">Options Updated</div>
  </div>
  <div id="m413-popup-reset" class="m413-save-popup">
    <div class="m413-save-reset">Options Reset</div>
  </div>
  <form action="" enctype="multipart/form-data" id="m413form">
    <div id="header">
      <div class="logo">
        <h2>Theme Options Panel</h2>
      </div>
      <div class="icon-option"> </div>
      <div class="clear"></div>
    </div>
    <?php
        $return = siteoptions_machine($options);
        ?>
    <div id="main">
      <div id="m413-nav">
        <ul>
          <?php echo $return[1] ?>
        </ul>
      </div>
      <div id="content"> <?php echo $return[0]; /* Settings */ ?> </div>
      <div class="clear"></div>
    </div>
    <div class="save_bar_top">
    <img style="display:none;" src="<?php echo get_template_directory_uri() ?>/admin/images/wpspin_light.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
    <input type="submit" value="Save All Changes" class="button-primary" />
  </form>
  <form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" style="display:inline" id="m413form-reset">
    <span class="submit-footer-reset">
    <input name="reset" type="submit" value="Reset Options" class="button submit-button reset-button" onclick="return confirm('CAUTION: Any and all settings will be lost! Click OK to reset.');" />
    <input type="hidden" name="m413_save" value="reset" />
    </span>
  </form>
</div>
<?php  if (!empty($update_message)) echo $update_message; ?>
<div style="clear:both;"></div>
</div>
<!--wrap-->
<?php
}

// load the styles for options area

function m413_style_only() {
	wp_enqueue_style('admin-style', get_template_directory_uri().'/admin/admin-style.css');
	wp_enqueue_style('color-picker', get_template_directory_uri().'/admin/colorpicker.css');
	$color = get_user_option('admin_color');
	if ($color == "fresh")
		{
		wp_enqueue_style('admin-style-grey', get_template_directory_uri().'/admin/admin-style-grey.css');
		wp_enqueue_style('color-picker', get_template_directory_uri().'/admin/colorpicker.css');
		}
	global $wp_version;
	if ( 3.5 <= $wp_version ) {
		wp_enqueue_script('thickbox');  
        wp_enqueue_style('thickbox');  
        wp_enqueue_script('media-upload');
		wp_enqueue_media(); 
	}
}

// load the javascript for the options area

function m413_load_only() {

	add_action('admin_head', 'm413_admin_head');
	wp_enqueue_script('jquery-ui-core');
	wp_register_script('jquery-input-mask', get_template_directory_uri().'/admin/js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
	wp_enqueue_script('jquery-input-mask');
	wp_enqueue_script('color-picker', get_template_directory_uri().'/admin/js/colorpicker.js', array('jquery'));
	wp_enqueue_script('ajaxupload', get_template_directory_uri().'/admin/js/ajaxupload.js', array('jquery'));

	function m413_admin_head() {
	?>

<script type="text/javascript" language="javascript">

		jQuery(document).ready(function(){

		// Race condition to make sure js files are loaded
		if (typeof AjaxUpload != 'function') {
			return ++counter < 6 && window.setTimeout(init, counter * 500);
		}

			//Color Picker
			<?php $options = get_option('m413_template');

			foreach($options as $option){
			if($option['type'] == 'color' OR $option['type'] == 'typography' OR $option['type'] == 'border'){
				if($option['type'] == 'typography' OR $option['type'] == 'border'){
					$option_id = $option['id'];
					$temp_color = get_option($option_id);
					$option_id = $option['id'] . '_color';
					$color = $temp_color['color'];
				}
				else {
					$option_id = $option['id'];
					$color = get_option($option_id);
				}
				?>
				 jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '<?php echo $color; ?>');
				 jQuery('#<?php echo $option_id; ?>_picker').ColorPicker({
					color: '<?php echo $color; ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						//jQuery(this).css('border','1px solid red');
						jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '#' + hex);
						jQuery('#<?php echo $option_id; ?>_picker').next('input').attr('value','#' + hex);

					}
				  });
			  <?php } } ?>

		});

		</script>

		<?php
		//AJAX Upload
		?>
<script type="text/javascript">
			jQuery(document).ready(function(){

				var i = 0;
				jQuery('#m413-nav li a').attr('id', function() {
				   i++;
				   return 'item'+i;
				});


			var flip = 0;

			jQuery('#expand_options').click(function(){
				if(flip == 0){
					flip = 1;
					jQuery('#m413_container #m413-nav').hide();
					jQuery('#m413_container #content').width(755);
					jQuery('#m413_container .group').add('#m413_container .group h2').show();

					jQuery(this).text('[-]');

				} else {
					flip = 0;
					jQuery('#m413_container #m413-nav').show();
					jQuery('#m413_container #content').width(579);
					jQuery('#m413_container .group').add('#m413_container .group h2').hide();
					jQuery('#m413_container .group:first').show();
					jQuery('#m413_container #m413-nav li').removeClass('current');
					jQuery('#m413_container #m413-nav li:first').addClass('current');

					jQuery(this).text('[+]');

				}

			});

				jQuery('.group').hide();
				jQuery('.group:first').fadeIn();

				jQuery('.group .collapsed').each(function(){
					jQuery(this).find('input:checked').parent().parent().parent().nextAll().each(
						function(){
           					if (jQuery(this).hasClass('last')) {
           						jQuery(this).removeClass('hidden');
           						return false;
           					}
           					jQuery(this).filter('.hidden').removeClass('hidden');
           				});
           		});

				jQuery('.group .collapsed input:checkbox').click(unhideHidden);

				function unhideHidden(){
					if (jQuery(this).attr('checked')) {
						jQuery(this).parent().parent().parent().nextAll().removeClass('hidden');
					}
					else {
						jQuery(this).parent().parent().parent().nextAll().each(
							function(){
           						if (jQuery(this).filter('.last').length) {
           							jQuery(this).addClass('hidden');
									return false;
           						}
           						jQuery(this).addClass('hidden');
           					});

					}
				}

				jQuery('.m413-radio-img-img').click(function(){
					jQuery(this).parent().parent().find('.m413-radio-img-img').removeClass('m413-radio-img-selected');
					jQuery(this).addClass('m413-radio-img-selected');

				});
				jQuery('.m413-radio-img-label').hide();
				jQuery('.m413-radio-img-img').show();
				jQuery('.m413-radio-img-radio').hide();
				jQuery('#m413-nav li:first').addClass('current');
				jQuery('#m413-nav li a').click(function(evt){

						jQuery('#m413-nav li').removeClass('current');
						jQuery(this).parent().addClass('current');

						var clicked_group = jQuery(this).attr('href');

						jQuery('.group').hide();

							jQuery(clicked_group).fadeIn();

						evt.preventDefault();

					});

				if('<?php if(isset($_REQUEST['reset'])) { echo $_REQUEST['reset'];} else { echo 'false';} ?>' == 'true'){

					var reset_popup = jQuery('#m413-popup-reset');
					reset_popup.fadeIn();
					window.setTimeout(function(){
						   reset_popup.fadeOut();
						}, 2000);
						//alert(response);

				}

			//Update Message popup
			jQuery.fn.center = function () {
				this.animate({"top":( jQuery(window).height() - this.height() - 200 ) / 2+jQuery(window).scrollTop() + "px"},100);
				this.css("left", 250 );
				return this;
			}


			jQuery('#m413-popup-save').center();
			jQuery('#m413-popup-reset').center();
			jQuery(window).scroll(function() {

				jQuery('#m413-popup-save').center();
				jQuery('#m413-popup-reset').center();

			});



			//Media Uploader
			jQuery(document).on('click', 'span.image_upload_button', function(event) {
				var jQueryclicked = jQuery(this), frame,
				input_id = jQueryclicked.prev().attr('id'),
				media_type = jQueryclicked.attr('rel');

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( frame ) {
				frame.open();
				return;
				}

				// Create the media frame.
				frame = wp.media.frames.customHeader = wp.media({
				// Set the media type
				library: {
				type: media_type
				},
				});

				// When an image is selected, run a callback.
				frame.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = frame.state().get('selection').first();
				jQuery('#' + input_id).val(attachment.attributes.url);
				jQuery('#' + input_id).parent().find('.m413-uploaded-image img').attr('src', attachment.attributes.url);
				});

				frame.open();

			});

/* Top save button
jQuery(document).ready( function(){
  // bind "click" event for links with title="submit"
  jQuery("a[title=submit]").click( function(){
    // it submits the form it is contained within
    jQuery(this).parents("form").submit();
  });
}); */


			//Save everything else
			jQuery('#m413form').submit(function(){

					function newValues() {
					  var serializedValues = jQuery("#m413form").serialize();
					  return serializedValues;
					}
					jQuery(":checkbox, :radio").click(newValues);
					jQuery("select").change(newValues);
					jQuery('.ajax-loading-img').fadeIn();
					var serializedReturn = newValues();

					var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';

					 //var data = {data : serializedReturn};
					var data = {
						<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'siteoptions'){ ?>
						type: 'options',
						<?php } ?>

						action: 'm413_ajax_post_action',
						data: serializedReturn
					};

					jQuery.post(ajax_url, data, function(response) {
						var success = jQuery('#m413-popup-save');
						var loading = jQuery('.ajax-loading-img');
						loading.fadeOut();
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut();


						}, 2000);
					});

					return false;

				});

			});
		</script>
<?php }
}

// ajax saving

add_action('wp_ajax_m413_ajax_post_action', 'm413_ajax_callback');

function m413_ajax_callback() {
	global $wpdb; // access to the database

	$save_type = $_POST['type'];
	//Uploads
	if($save_type == 'upload'){

		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';
		$uploaded_file = wp_handle_upload($filename,$override);

				$upload_tracking[] = $clickedID;
				update_option( $clickedID , $uploaded_file['url'] );

		 if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }
		 else { echo $uploaded_file['url']; } // Is the Response
	}
	elseif($save_type == 'image_reset'){

			$id = $_POST['data']; // Acts as the name
			global $wpdb;
			$query = "DELETE FROM $wpdb->options WHERE option_name LIKE '$id'";
			$wpdb->query($query);

	}
	elseif ($save_type == 'options' OR $save_type == 'framework') {
		$data = $_POST['data'];

		parse_str($data,$output);
		//print_r($output);

		//Pull options
        	$options = get_option('m413_template');

		foreach($options as $option_array){

			$id = $option_array['id'];
			$old_value = get_option($id);
			$new_value = '';

			if(isset($output[$id])){
				$new_value = $output[$option_array['id']];
			}

			if(isset($option_array['id'])) { // Non - Headings...


					$type = $option_array['type'];

					if ( is_array($type)){
						foreach($type as $array){
							if($array['type'] == 'text'){
								$id = $array['id'];
								$std = $array['std'];
								$new_value = $output[$id];
								if($new_value == ''){ $new_value = $std; }
								update_option( $id, stripslashes($new_value));
							}
						}
					}
					elseif($new_value == '' && $type == 'checkbox'){ // Checkbox Save

						update_option($id,'false');
					}
					elseif ($new_value == 'true' && $type == 'checkbox'){ // Checkbox Save

						update_option($id,'true');
					}
					elseif($type == 'multicheck'){ // Multi Check Save

						$option_options = $option_array['options'];

						foreach ($option_options as $options_id => $options_value){

							$multicheck_id = $id . "_" . $options_id;

							if(!isset($output[$multicheck_id])){
							  update_option($multicheck_id,'false');
							}
							else{
							   update_option($multicheck_id,'true');
							}
						}
					}

					elseif($type != 'upload_min'){

						update_option($id,stripslashes($new_value));
					}
				}
			}

	}

  die();

}

// various option types

function siteoptions_machine($options) {

    $counter = 0;
	$menu = '';
	$output = '';
	foreach ($options as $value) {

		$counter++;
		$val = '';
		//Start Heading
		 if ( $value['type'] != "heading" )
		 {
		 	$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
			//$output .= '<div class="section section-'. $value['type'] .'">'."\n".'<div class="option-inner">'."\n";
			if(isset( $value['type'] )) {
				$output .= '<div class="section section-'.$value['type'].' '. $class .'">'."\n";
			}

			if(isset( $value['name'] )) {
				$output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
			}			
			$output .= '<div class="option">'."\n" . '<div class="controls">'."\n";

		 }
		 //End Heading
		$select_value = '';
		switch ( $value['type'] ) {

		case 'text':
			$val = $value['std'];
			$std = get_option($value['id']);
			if ( $std != "") { $val = $std; }
			$output .= '<input class="m413-input" name="'. $value['id'] .'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $val .'" />';
		break;


		case 'select':

			$output .= '<select class="m413-input" name="'. $value['id'] .'" id="'. $value['id'] .'">';

			$select_value = get_option($value['id']);

			foreach ($value['options'] as $option) {

				$selected = '';

				 if($select_value != '') {
					 if ( $select_value == $option) { $selected = ' selected="selected"';}
			     } else {
					 if ( isset($value['std']) )
						 if ($value['std'] == $option) { $selected = ' selected="selected"'; }
				 }

				 $output .= '<option'. $selected .'>';
				 $output .= $option;
				 $output .= '</option>';

			 }
			 $output .= '</select>';


		break;


		case 'fontsize':

		/* Font Size */
			$val = $default['size'];
			if ( $typography_stored['size'] != "") { $val = $typography_stored['size']; }
			$output .= '<select class="m413-typography m413-typography-size" name="'. $value['id'].'_size" id="'. $value['id'].'_size">';
				for ($i = 9; $i < 71; $i++){
					if($val == $i){ $active = 'selected="selected"'; } else { $active = ''; }
					$output .= '<option value="'. $i .'" ' . $active . '>'. $i .'px</option>'; }
			$output .= '</select>';


		break;


		case "multicheck":

			$std =  $value['std'];

			foreach ($value['options'] as $key => $option) {

			$tt_key = $value['id'] . '_' . $key;
			$saved_std = get_option($tt_key);

			if(!empty($saved_std))
			{
				  if($saved_std == 'true'){
					 $checked = 'checked="checked"';
				  }
				  else{
					  $checked = '';
				  }
			}
			elseif( $std == $key) {
			   $checked = 'checked="checked"';
			}
			else {
				$checked = '';                                                                                    }
			$output .= '<input type="checkbox" class="checkbox m413-input" name="'. $tt_key .'" id="'. $tt_key .'" value="true" '. $checked .' /><label for="'. $tt_key .'">'. $option .'</label><br />';

			}
		break;


		case 'textarea':

			$cols = '8';
			$ta_value = '';

			if(isset($value['std'])) {

				$ta_value = $value['std'];

				if(isset($value['options'])){
					$ta_options = $value['options'];
					if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
					} else { $cols = '8'; }
				}

			}
				$std = get_option($value['id']);
				if( $std != "") { $ta_value = stripslashes( $std ); }
				$output .= '<textarea class="m413-input" name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>';


		break;

		case 'textarea-large':

			$cols = '8';
			$ta_value = '';

			if(isset($value['std'])) {

				$ta_value = $value['std'];

				if(isset($value['options'])){
					$ta_options = $value['options'];
					if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
					} else { $cols = '8'; }
				}

			}
				$std = get_option($value['id']);
				if( $std != "") { $ta_value = stripslashes( $std ); }
				$output .= '<textarea class="m413-input" name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $cols .'" rows="24">'.$ta_value.'</textarea>';


		break;


		case "radio":

			 $select_value = get_option( $value['id']);

			 foreach ($value['options'] as $key => $option)
			 {

				 $checked = '';
				   if($select_value != '') {
						if ( $select_value == $key) { $checked = ' checked'; }
				   } else {
					if ($value['std'] == $key) { $checked = ' checked'; }
				   }
				$output .= '<input class="m413-input m413-radio" type="radio" name="'. $value['id'] .'" value="'. $key .'" '. $checked .' />' . $option .'<br />';

			}

		break;


		case "checkbox":

		   $std = $value['std'];

		   $saved_std = get_option($value['id']);

		   $checked = '';

			if(!empty($saved_std)) {
				if($saved_std == 'true') {
				$checked = 'checked="checked"';
				}
				else{
				   $checked = '';
				}
			}
			elseif( $std == 'true') {
			   $checked = 'checked="checked"';
			}
			else {
				$checked = '';
			}
			$output .= '<input type="checkbox" class="checkbox m413-input" name="'.  $value['id'] .'" id="'. $value['id'] .'" value="true" '. $checked .' />';

		break;


		case "upload":

			$output .= siteoptions_uploader_function($value['id'],$value['std'],null);

		break;


		case "upload_min":

			$output .= siteoptions_uploader_function($value['id'],$value['std'],'min');

		break;
		case "color":
			$val = $value['std'];
			$stored  = get_option( $value['id'] );
			if ( $stored != "") { $val = $stored; }
			$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
			$output .= '<input class="m413-color" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $val .'" />';
		break;


		case "images":
			$i = 0;
			$select_value = get_option( $value['id']);

			foreach ($value['options'] as $key => $option)
			 {
			 $i++;

				 $checked = '';
				 $selected = '';
				   if($select_value != '') {
						if ( $select_value == $key) { $checked = ' checked'; $selected = 'm413-radio-img-selected'; }
				    } else {
						if ($value['std'] == $key) { $checked = ' checked'; $selected = 'm413-radio-img-selected'; }
						elseif ($i == 1  && !isset($select_value)) { $checked = ' checked'; $selected = 'm413-radio-img-selected'; }
						elseif ($i == 1  && $value['std'] == '') { $checked = ' checked'; $selected = 'm413-radio-img-selected'; }
						else { $checked = ''; }
					}

				$output .= '<span>';
				$output .= '<input type="radio" id="m413-radio-img-' . $value['id'] . $i . '" class="checkbox m413-radio-img-radio" value="'.$key.'" name="'. $value['id'].'" '.$checked.' />';
				$output .= '<div class="m413-radio-img-label">'. $key .'</div>';
				$output .= '<img src="'.$option.'" alt="" class="m413-radio-img-img '. $selected .'" onClick="document.getElementById(\'m413-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
				$output .= '</span>';

			}

		break;

		case "info":
			$default = $value['std'];
			$output .= $default;
		break;
/*
		case "typography":
			unset($font_size, $font_style, $font_face, $font_color);

			$typography_defaults = array(
				'size' => '',
				'face' => '',
				'style' => '',
				'color' => ''
				);

			$typography_stored = wp_parse_args($val, $typography_defaults);

			$typography_options = array(
				'sizes' => m413_recognized_font_sizes(),
				'faces' => m413_recognized_font_faces(),
				'styles' => m413_recognized_font_styles(),
				'color' => true
				);

			if ( isset( $value['options'])){
				$typography_options = wp_parse_args( $value['options'], $typography_options);
			}

			//font sizes
			if ( $typography_options['sizes']){
				$font_size = '<select class="m413-typography m413-typography-size" name="'.esc_attr($option_name.'['.$value['id'].'][size]').'" id="'.esc_attr($value['id'].'_size' ) . '">';
				$sizes = $typography_options['sizes'];
				foreach ($sizes as $i){
					$size = $i . 'px';
					$font_size .= '<option value="'.esc_attr($size).'" '.selected($typography_stored['size'], $size, false). '>'. exc_html($size). '</option>';
				}
				$font_size .= '</select>';
			}

			//font face
			if ( $typography_options['faces'] ) {
				$font_face = '<select class="m413-typography m413-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
				$faces = $typography_options['faces'];
				foreach ( $faces as $key => $face ) {
					$font_face .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
				}
				$font_face .= '</select>';
			}

			//font style
			if ( $typography_options['styles'] ) {
				$font_style = '<select class="m413-typography m413-typography-style" name="'.$option_name.'['.$value['id'].'][style]" id="'. $value['id'].'_style">';
				$styles = $typography_options['styles'];
				foreach ( $styles as $key => $style ) {
					$font_style .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
				}
				$font_style .= '</select>';
			}

			//font color
			if ( $typography_options['color'] ) {
				$font_color = '<div id="' . esc_attr( $value['id'] ) . '_color_picker" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $typography_stored['color'] ) . '"></div></div>';
				$font_color .= '<input class="m413-color m413-typography m413-typography-color" name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" type="text" value="' . esc_attr( $typography_stored['color'] ) . '" />';
			}

			// Allow modification/injection of typography fields
			$typography_fields = compact( 'font_size', 'font_face', 'font_style', 'font_color' );
			$typography_fields = apply_filters( 'm413_typography_fields', $typography_fields, $typography_stored, $option_name, $value );
			$output .= implode( '', $typography_fields );

			break;
*/
		case "heading":

			if($counter >= 2){
			   $output .= '</div>'."\n";
			}
			$str_value = strtolower($value['name']);
			$jquery_click_hook = preg_replace("/[^A-Za-z0-9]/", "", $str_value );
			$jquery_click_hook = "m413-option-" . $jquery_click_hook;
			$menu .= '<li><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $value['name'] .'</a></li>';
			$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
		break;
		
		case "divider":
			$output .= '';
		break;
		
		}

		// if TYPE is an array, formatted into smaller inputs... ie smaller values
		if ( is_array($value['type'])) {
			foreach($value['type'] as $array){

					$id = $array['id'];
					$std = $array['std'];
					$saved_std = get_option($id);
					if($saved_std != $std){$std = $saved_std;}
					$meta = $array['meta'];

					if($array['type'] == 'text') { // Only text at this point

						 $output .= '<input class="input-text-small m413-input" name="'. $id .'" id="'. $id .'" type="text" value="'. $std .'" />';
						 $output .= '<span class="meta-two">'.$meta.'</span>';
					}
				}
		}
		if ( $value['type'] != "heading" ) {
			if ( $value['type'] != "checkbox" )
				{
				$output .= '<br/>';
				}
			if(!isset($value['desc'])){ $explain_value = ''; } else{ $explain_value = $value['desc']; }
			$output .= '</div><div class="explain">'. $explain_value .'</div>'."\n";
			$output .= '<div class="clear"> </div></div></div>'."\n";
			}

	}
    $output .= '</div>';
    return array($output,$menu);

}

// file uploads

function siteoptions_uploader_function($id,$std,$mod){

	$uploader = '';
    $upload = get_option($id);

	if($mod != 'min') {
			$val = $std;
            if ( get_option( $id ) != "") { $val = get_option($id); }
            $uploader .= '<input class="m413-input" name="'. $id .'" id="'. $id .'_upload" type="text" value="'. $val .'" />';
	}

	$uploader .= '<span class="button image_upload_button" id="'.$id.'" rel="image">Upload Image</span>';

	if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}

	$uploader .= "\n";
    $uploader .= '<div class="clear"></div>' . "\n";
	if(!empty($upload)){
    	$uploader .= '<a class="m413-uploaded-image" href="'. $upload . '">';
    	$uploader .= '<img class="m413-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
    	$uploader .= '</a>';
		}
	$uploader .= '<div class="clear"></div>' . "\n";


return $uploader;
}