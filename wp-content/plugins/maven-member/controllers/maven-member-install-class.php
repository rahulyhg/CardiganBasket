<?php

class Maven_Install {

    //TODO: Use the setting class to retrieve and save the settings
    public function activate() {

        //Minutes
        update_option('maven-setting-auto-logout-idle-limit', 20 * 60);
        update_option('maven-setting-auto-logout-enabled', 1);

        $this->update_user_time();

        add_role("maven-default-role", "Maven Default Role", array("read" => true));
        
	if(!get_option("maven-setting-default-registration-role"))
	    update_option('maven-setting-default-registration-role', "maven-default-role");
		
		
        if(!get_option("maven-setting-email-activation-template"))
	    update_option('maven-setting-email-activation-template', 1);

	if(!get_option("maven-setting-dialog-restricted"))
	    update_option("maven-setting-dialog-restricted", __("This content is restricted to site members.  If you are an existing user, please login.",maven_translation_key()));

	if(!get_option("maven-setting-control-login"))
	    update_option("maven-setting-control-login", "<br />\n<br />\n<label>User</label><input type='text' name='log' id='log' value='' size='20' /><br />\n<label>Password</label><input type='password' name='pwd' id='pwd' size='20' />\n<input type='submit' name='submit' value='Send' class='button' /><br/>\nDon't you have a user yet? <a href='{register_page}' >Register! </a>\nLost your password? <a href='{password_reminder_page}' >Click here</a>");

	if(!get_option("maven-setting-block-title"))
	    update_option("maven-setting-block-title", "0");

	if(!get_option("maven-setting-dialog-block-title"))
	    update_option("maven-setting-dialog-block-title", __("You can't see the title",maven_translation_key()));
        
	if(!get_option("maven-setting-registration-active-captcha")){
	    update_option("maven-setting-registration-active-captcha", "maven_recaptcha.php");
	    update_option("maven-setting-registration-is-captcha-enabled", "0");
	}
	
	if(!get_option("maven-setting-registration-template-required"))
	    update_option("maven-setting-registration-template-required", "(*)");
	
        
	if(!get_option("maven-setting-registration-template-container")){
	    update_option("maven-setting-registration-template-container", "<table >\n<tbody >{\$fields} \n <tr><td colspan='2'>{\$captcha}</td></tr>\n</tbody></table><input type='submit' name='submit' value='".__('Register',maven_translation_key())."' class='button' />");
	    update_option("maven-setting-registration-template-field", "<tr><td ><span>{\$field_name}</span>{\$required} <br /></td><td >{\$field_control}</td></tr>");
	    update_option("maven-setting-registration-registration-template-required", "(*)");
	}
	
	if(!get_option("maven-setting-email-activation-template"))
		update_option("maven-setting-email-activation-template", "You has been activated on {blog_name}. ");
	
	if(!get_option("maven-setting-send-activation-email-default"))
		update_option("maven-setting-send-activation-email-default", "0");
	

	if (get_option("maven-settings-pages-created")!="1"){
	    
	
	    // Add registration page
	    global $user_ID;

	    $page = array();
	    $page['post_type']    = 'page';
	    $page['post_content'] = '';
	    $page['post_parent']  = 0;
	    $page['post_author']  = $user_ID;
	    $page['post_status']  = 'publish';
	    $page['post_title']   = __('Maven Member',maven_translation_key());
	    $parentid = wp_insert_post ($page);
	    
	    
	    $page = array();
	    $page['post_type']    = 'page';
	    $page['post_content'] = '[mvn-registration]';
	    $page['post_parent']  = $parentid;
	    $page['post_author']  = $user_ID;
	    $page['post_status']  = 'publish';
	    $page['post_title']   = __('Maven Registration Page',maven_translation_key());
	    $pageid = wp_insert_post ($page);
	    if ($pageid != 0)
		 update_option("maven-setting-registration-page", $pageid);

	    $page = array();
	    $page['post_type']    = 'page';
	    $page['post_content'] = __('Registration successfuly made',maven_translation_key());
	    $page['post_parent']  = $parentid;
	    $page['post_author']  = $user_ID;
	    $page['post_status']  = 'publish';
	    $page['post_title']   = __('Maven Registration successful Page',maven_translation_key());
	    $pageid = wp_insert_post ($page);
	    if ($pageid != 0)
		 update_option("maven-setting-successful-registration-page", $pageid);

	    $page = array();
	    $page['post_type']    = 'page';
	    $page['post_content'] = __('You have not been activated yet',maven_translation_key());
	    $page['post_parent']  = $parentid;
	    $page['post_author']  = $user_ID;
	    $page['post_status']  = 'publish';
	    $page['post_title']   = __('Activation required',maven_translation_key());
	    $pageid = wp_insert_post ($page);
	    if ($pageid != 0)
		 update_option("maven-setting-activation-url", $pageid);
	    
	    
	    update_option("maven-settings-pages-created", "1");
	
	}

    }

    function deactivate() {
        delete_option('maven-setting-auto-logout-idle-limit');
        delete_option('maven-setting-auto-logout-enabled');
    }

    function update_user_time() {
        if (is_user_logged_in()) {
            update_user_meta(get_current_user_id(), 'maven-setting-last-active-time', time());
        }
    }

}

?>
