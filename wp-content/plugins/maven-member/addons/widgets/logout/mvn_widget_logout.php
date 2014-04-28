<?php

class Mvn_Widget_Logout extends WP_Widget{
    
    function Mvn_Widget_Logout(){
	$widget_opts = array(
	    'classname'=>'Mvn_Widget_Logout',
	    'description'=>'Display a logout link.'
	);
	
	$this->WP_Widget('Mvn_Widget_Logout', __('Maven Member LogIn/Logout',maven_translation_key()), $widget_opts);
	
    }
    
    function form($instance){
	$defaults= array('template'=>'<a href="{logout_url}">'.__('Logout',maven_translation_key()).'</a>',
					 'redirect_url' =>'',
					 'template_in'=>'{login_form}',
					);
	$instance = wp_parse_args((array)$instance,$defaults);
	
	$template = esc_attr($instance['template']);
	$template_in = esc_attr($instance['template_in']);
	$redirect_url = esc_attr($instance['redirect_url']);
	
	$name = $this->get_field_name('template');
	$name_in = $this->get_field_name('template_in');
	$name_redirect_url = $this->get_field_name('redirect_url');
	?>
	    <p>
			<label for="<?php echo $name_in?>"><?php _e("Template"); ?>:LogIn</label>
			<textarea  class="widefat" id="<?php echo $name_in?>" name="<?php echo $name_in?>" ><?php echo $template_in?></textarea>
			<br/>
			<small><?php _e("Use the {login_form} variable in the template to show the login"); ?></small>
			<br/>
			<label for="<?php echo $name_redirect_url?>"><?php _e("Redirect URL"); ?>:</label>
			<br/>
			<input type="text" id="<?php echo $name_redirect_url?>" name="<?php echo $name_redirect_url?>" value="<?php echo $redirect_url?>" />
			<br/>
			<small><?php _e("Use to redirect after login."); ?></small>
			<br/>
			<label for="<?php echo $name?>"><?php _e("Template"); ?>:LogOut</label>
			<textarea  class="widefat" id="<?php echo $name?>" name="<?php echo $name?>" ><?php echo $template?></textarea>
			<br/>
			<small><?php _e("Use the {logout_url} variable in the template"); ?></small>
			
	    </p>

	<?php 
    }
    
    function update($newinstance,$old_instance){
	return $newinstance;
    }
    
    function widget($args,$instance){
	$defaults= array('template'=>'<a href="{logout_url}">'.__('Logout',maven_translation_key()).'</a>',
					 'redirect_url' =>'',
					 'template_in'=>'{login_form}',
					);
	
	//var_dump($args);
	extract($args);
	// TODO: add the url as an option in the widget
	$url = wp_logout_url(home_url());
	$template = '';
	if (is_user_logged_in())
	{
	    $template = $instance['template'] ? $instance['template'] : $defaults['template'];
	    $template = str_replace("{logout_url}", $url, $template);
	}else{
		$template = $instance['template_in'] ? $instance['template_in'] : $defaults['template_in'];
		$template = str_replace("{login_form}", maven_manager()->get_setting_class()->get_login_control(array('redirect_to'=>$instance['redirect_url'])), $template);
		
	}
	
	// TODO: add a filter to do this
	echo $before_widget;
	echo $template;
	echo $after_widget;
    }
}

add_action('widgets_init','mvn_widget_logout_register');

function mvn_widget_logout_register(){
    register_widget("Mvn_Widget_Logout");
}
?>
