<?php

class Maven_member_settings extends Maven_member_base {

    var $base_setting_name = "maven-setting-";
    var $action_save_setting = "maven_member-save-settings";
	var $error_login_message = '';
	
	/* settings options
	 *	field name => variable name
	 */
	var $settings_options = array(
		"restricted"						=> "dialog-restricted",
        "login"								=> "control-login",
        "block_title"						=> "block-title",
        "dialog_block_title"				=> "dialog-block-title",
        "activation_default"				=> "activation-default",
		"activation_url"				=> "activation-url",
        "activation_url_type"				=> "activation-url-type",
        "login_page"						=> "login-url",
        "auto_logout_limit"					=> "auto-logout-idle-limit",
        "auto_logout_enabled"				=> "auto-logout-enabled",

        "successful_registration_page"		=> "successful-registration-page",
        "registration_page"					=> "registration-page",
        "registration_template_container"	=> "registration-template-container",
        "registration_template_field"		=> "registration-template-field",
        "registration_template_required"	=> "registration-template-required",
		"registration_on"					=> "registration-on",
		"email_activation_template"			=> "email-activation-template",
		"send_activation_email_default"		=> "send-activation-email-default",
		"default_registration_role"			=> "default-registration-role",
		"selected_captcha"					=> "registration-active-captcha",
		"is_captcha_enabled"				=> "registration-is-captcha-enabled",
	);
	
    public function __construct() {
        parent::__construct();

        $this->load_model("settings");

        add_action("init", array(&$this, 'init'));
    }

    public function init() {

        if (is_admin()) {
            $url = $this->get_activation_url();
			$this->save();
//            if (!$url)
//                add_action('admin_notices', array(&$this, 'notice_activation_url'));
        }
    }

    public function save(){
		if(isset($_GET['maven-action']) && $_GET['maven-action'] == $this->action_save_setting && isset($_POST['_wpnonce'])){
			if($this->validate_nonce($this->action_save_setting)){
				switch ($this->get_post_var('btnSaveGeneral')){
					case 'save':
						$this->save_settings();
					break;
					case 'reset':
						$this->reset_settings();
					break;
				}
				
			}
		}
	}

    public function notice_activation_url() {
        $link = "<a href='" . $this->get_site_url() . "/wp-admin/admin.php?page=maven_member-section-settings'>".__('Setting',maven_translation_key())."</a>";

        echo $this->get_notice(__("Maven: You don't have selected an activation url.&nbsp;&nbsp;",maven_translation_key()) . $link);
    }

    private function get_setting_name($setting) {
        return "{$this->base_setting_name}{$setting}";
    }

    public function get_setting($setting) {
        return $this->settings_m->get_setting($this->get_setting_name($setting));
    }

    public function save_setting($setting, $value) {
//        $this->user_can();
//        $this->check_ajax_nonce($this->action_save_setting);

        $this->settings_m->save_setting($this->get_setting_name($setting), $value);
    }

    public function get_activation_type() {
        $url_type = $this->get_setting("activation-url-type");

        return $url_type;
    }

    public function get_activation_url() {
        $url_type = $this->get_setting("activation-url-type");

        if ($url_type) {
            if ($url_type == "page")
            {
		$page = get_permalink($this->get_setting("activation-url"));
		return $page;
	    }
            else
                return $this->get_setting("activation-url");
        }

        return '';
    }

    public function get_login_url() {
        $login = $this->get_setting("login-url");

        if ($login)
            return get_permalink($login);

        return $this->get_site_url();
    }

    public function get_successul_registration_url() {
        $reg = $this->get_setting("successful-registration-page");

        if ($reg)
            return get_permalink($reg);

        return '';
    }
    
    public function get_registration_url() {
        $reg = $this->get_setting("registration-page");

        if ($reg)
            return get_permalink($reg);

        return '';
    }
	
	public function get_password_reminder_url() {
        $reg = $this->get_setting("password-reminder-page");

        if ($reg)
            return get_permalink($reg);
		else
			return $this->get_site_url().'/wp-login.php?action=lostpassword';

        return '';
    }
    
    public function get_login_control($atts=array()) {
        global $post;
		// fix for homepages

		if(isset($atts['redirect_to'])){
			$post_url = $atts['redirect_to'];
		}
		if(!isset($post_url)){
			if ( ( is_home() || is_front_page() ) )
				$post_url = home_url();
			else
				$post_url = get_permalink($post->ID);
		}
		//TODO: in the new FWK use it as get_error
		$error_message = get_transient('mvn_login_error');
		if($error_message)
		{
			$this->error_login_message = '<p class="mvn-login-error">'.$error_message.'</p>';
			delete_transient('mvn_login_error');
		}

        $fields = $this->get_setting("control-login");
        $registration_page = $this->get_registration_url();
        $password_reminder = $this->get_password_reminder_url();
		
        $fields = str_replace("{register_page}",$registration_page,$fields);
        $fields = str_replace("{password_reminder_page}",$password_reminder,$fields);
		
        $site_url = $this->get_site_url();
        $hidden_redirect = "<input type='hidden' name='redirect_to' value='{$post_url}' />";
		$hidden_identify = "<input type='hidden' name='mvn_login' value='1' />";

        $form_tag = "{$this->error_login_message}<form action='{$site_url}/wp-login.php' method='post'>{$fields}{$hidden_redirect}{$hidden_identify}</form>";

        return $form_tag;
    }
	
	public function get_restricted_message()
	{
		return $this->get_setting("dialog-restricted");
	}
	
	public function get_full_login_control() {
        global $post;

        if ( ( is_home() || is_front_page() ) )
			$post_url = home_url();
		else
			$post_url = get_permalink($post->ID);

        $fields = $this->get_setting("control-login");
        $registration_page = $this->get_registration_url();
		$password_reminder = $this->get_password_reminder_url();
        
        $fields = str_replace("{register_page}",$registration_page,$fields);
		$fields = str_replace("{password_reminder_page}",$password_reminder,$fields);
        
		//TODO: in the new FWK use it as get_error
		$error_message = get_transient('mvn_login_error');
		if($error_message)
		{
			$this->error_login_message = '<p class="mvn-login-error">'.$error_message.'</p>';
			delete_transient('mvn_login_error');
		}
		
        $site_url = $this->get_site_url();
        $hidden_redirect = "<input type='hidden' name='redirect_to' value='{$post_url}' />";
		$hidden_identify = "<input type='hidden' name='mvn_login' value='1' />";

        $form_tag = "<form action='{$site_url}/wp-login.php' method='post'>{$fields}{$hidden_redirect}{$hidden_identify}</form>";

        $new_content = $this->get_restricted_message() . $this->error_login_message . $form_tag;

        return $new_content;
    }

    public function reset_settings() {
        
        $this->get_registration_class()->reset_fields();
        
        $categories = $this->get_categories_class()->get_all();
        
        foreach($categories as $category)
            $this->get_categories_class()->reset_roles($category->term_id);
		
		set_transient("setting_message", __('Resetted settings.',maven_translation_key()), '30');
		
		$this->redirect_to_referer(array('maven-action' => 'reset-successful'));
    }

    

    public function save_settings() {
        $this->user_can();
        //$this->check_ajax_nonce($this->action_save_setting);

        foreach($this->settings_options as $field => $var){
           $this->save_setting($var, $this->get_post_var($var));
        }
		$result=$this->save_captchas();
		if($result===true){
			set_transient("setting_message", __('Settings saved successfully.',maven_translation_key()), '30');
		}else{
			set_transient("setting_message", __('Settings saved successfully.<br/>'.$result,maven_translation_key()), '30');
		}
		
		
		
		$this->redirect_to_referer(array('maven-action' => 'save-successful'));
    }
    
    public function save_captchas() {
        $this->user_can();
		$this->get_addons_class()->get_captchas();
		$options=$this->get_addons_class()->get_captcha_options_ids();
		$settings = explode(',', $options);
        
        

	    $captchas = array();
	    
            foreach ($settings as $setting) {
                $captchas[$setting] = $this->get_post_var($setting);
            }

	    $result = $this->get_addons_class()->save_options($captchas);
	    
	    if ($result===true)
			return true;
	    else
			return $result;
        
    }
    
    

    public function is_auto_logout_enabled() {
        return $this->get_setting("auto-logout-enabled");
    }

    public function activation_by_default()
    {
         return $this->get_setting("activation-default");
    }
    
    public function get_auto_logout_limit() {
        return $this->get_setting("auto-logout-idle-limit");
    }
    
    public function get_default_registration_role() {
        return $this->get_setting("default-registration-role");
    }
    
    public function get_registration_template_container() {
        return $this->get_setting("registration-template-container");
    }
    
    public function get_registration_template_field() {
        return $this->get_setting("registration-template-field");
    }
    
    public function get_registration_template_required() {
        return $this->get_setting("registration-template-required");
    }
        
    public function is_registration_enabled()
    {
        return $this->get_setting("registration-on")=="1"?false:true;
    }
    
    public function get_registration_captcha(){
        return $this->get_setting("registration-active-captcha");
    }
    
    public function is_captcha_enabled(){
        return $this->get_setting("registration-is-captcha-enabled");
    }
    

    public function show_form() {
				
		$msj=get_transient("setting_message");
		
		if($msj){
			echo $this->get_notice($msj);
			delete_transient("setting_message");
		}
		
		$this->data["title"] = __("Settings",maven_translation_key());

        $this->add_nonce_field($this->action_save_setting);
        $this->add_new_button(false);
        
		$this->add_data('form_action', add_query_arg(array('maven-action' => $this->action_save_setting)));
        //TODO: Do it more dinamically
//        $this->data["restricted"] = $this->get_setting("dialog-restricted");
//        $this->data["login"] = $this->get_setting("control-login");
//        $this->data["block_title"] = $this->get_setting("block-title");
//        $this->data["dialog_block_title"] = $this->get_setting("dialog-block-title");
//        $this->data["activation_default"] = $this->get_setting("activation-default");
//
//        $this->data["activation_url_type"] = $this->get_setting("activation-url-type");
//		$this->data["activation_url"] = $this->get_setting("activation-url");
//        $this->data["login_page"] = $this->get_setting("login-url");
//        $this->data["auto_logout_limit"] = $this->get_setting("auto-logout-idle-limit");
//        $this->data["auto_logout_enabled"] = $this->get_setting("auto-logout-enabled");
//
//        $this->data["successful_registration_page"] = $this->get_setting("successful-registration-page");
//        $this->data["registration_page"] = $this->get_setting("registration-page");
//        $this->data["registration_template_container"] = $this->get_setting("registration-template-container");
//        $this->data["registration_template_field"] = $this->get_setting("registration-template-field");
//        $this->data["registration_template_required"] = $this->get_setting("registration-template-required");
//		$this->data["email_activation_template"] = $this->get_setting("email-activation-template");
//		$this->data["send_activation_email_default"] = $this->get_setting("send-activation-email-default");
        
		foreach($this->settings_options as $field => $var){
           $this->data[$field] = $this->get_setting($var);
        }

        $this->add_data("roles", $this->get_roles_class()->get_roles());
        $this->data["default_registration_role"] = $this->get_setting("default-registration-role");
        
        
        
	
	// Get captchas
        $this->add_data("captchas", $this->get_addons_class()->get_captchas());
		$this->add_data("captcha_options_ids", $this->get_addons_class()->get_captcha_options_ids());
        

//        switch ($this->data["activation_url_type"]) {
//            case "page": $this->data["page"] = $this->get_setting("activation-url");
//                break;
//            case "url": $this->data["activation_url"] = $this->get_setting("activation-url");
//                break;
//            case "message": $this->data["activation_message"] = $this->get_setting("activation-url");
//                break;
//        }

        $this->load_admin_view("settings");
    }

}

?>