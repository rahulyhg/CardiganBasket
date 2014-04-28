<?php
// set default options once we have setup everything
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php?page=siteoptions" ) {
	//Call action that sets
	add_action('admin_head','mbb_option_setup');
}

function mbb_option_setup(){

	//Update EMPTY options
	$mbb_array = array();
	add_option('mbb_options',$mbb_array);

	$template = get_option('mbb_template');
	$saved_options = get_option('mbb_options');

	foreach($template as $option) {
		if($option['type'] != 'heading'){
			$id = $option['id'];
			$std = $option['std'];
			$db_option = get_option($id);
			if(empty($db_option)){
				if(is_array($option['type'])) {
					foreach($option['type'] as $child){
						$c_id = $child['id'];
						$c_std = $child['std'];
						update_option($c_id,$c_std);
						$mbb_array[$c_id] = $c_std;
					}
				} else {
					update_option($id,$std);
					$mbb_array[$id] = $std;
				}
			}
			else { //So just store the old values over again.
				$mbb_array[$id] = $db_option;
			}
		}
	}
	update_option('mbb_options',$mbb_array);
}

// Admin Setup

function siteoptions_admin_head() { ?>

<script type="text/javascript">
jQuery(function(){
var message = '<p><strong>Activation Successful!</strong> This theme\'s settings are located under <a href="<?php echo admin_url('admin.php?page=siteoptions'); ?>">Appearance > Theme Options</a>.</p>';
jQuery('.themes-php #message2').html(message);
});
</script>

    <?php }

add_action('admin_head', 'siteoptions_admin_head');