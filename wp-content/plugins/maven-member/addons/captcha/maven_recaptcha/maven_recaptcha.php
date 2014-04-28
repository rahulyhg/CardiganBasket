<?php


/*
Captcha Name: Maven Recaptcha
Description: This is a reCaptcha implementation. To use it, you must get an API key from <a href='https://www.google.com/recaptcha/admin/create' target='_blank' >https://www.google.com/recaptcha/admin/create</a>
Version:     0.1
Author:      Emiliano Jankowski
License:     
*/

class maven_recaptcha extends Maven_base_captcha{
    
    var $public_key;
    var $private_key;
    var $response;
    var $error_message;
    var $options=array();
    
    public function __construct() {
        
        
        //Check if reCaptcha plugin is active
        
            $this->configure_captcha();
//        else{
//            
//            $recaptcha = new reCAPTCHA('recaptcha_options');
//            
//            // Read reCaptcha configuration
//            $reCapcha_config = WPPlugin::retrieve_options("recaptcha_options");
//             
//            $this->public_key = $reCapcha_config["public_key"];
//            $this->private_key = $reCapcha_config["private_key"];
//            $this->error_message = $reCapcha_config['incorrect_response_error'];
//        }
	    
	    
	    // admin notices
            //add_action('admin_notices', array(&$this, 'missing_keys_notice'));
    }
    
    
//    function missing_keys_notice() {
//	
//	if ($this->keys_missing())
//	    echo '<div class="error"><p><strong>You enabled reCAPTCHA, but some of the reCAPTCHA API Keys seem to be missing.</strong></p></div>';
//	
//	
//	if ($this->recaptcha_enabled() && $this->keys_missing()) {
//	    $this->create_error_notice('You enabled reCAPTCHA, but some of the reCAPTCHA API Keys seem to be missing.');
//	}
//    }
//    
//    function keys_missing()
//    {
//	return empty($this->private_key) || empty($this->public_key);
//    }
    
    private function configure_captcha()
    {
	if (!class_exists('reCAPTCHA'))
	    $this->add_library("maven_recaptcha/recaptchalib.php");   
        
        $this->public_key = get_option("maven-recaptcha-public-key");
        $this->private_key = get_option("maven-recaptcha-private-key");
        $this->error_message = "Errorrrrr!!";
            
    }
    
    function get_captcha(){
        $error = "";
	
        return  recaptcha_get_html($this->public_key, $error);
    }

    
    function validate(){
        
        if (isset($_POST["recaptcha_response_field"])) {
            $this->response = recaptcha_check_answer ($this->private_key,
                                            $_SERVER["REMOTE_ADDR"],
                                            $_POST["recaptcha_challenge_field"],
                                            $_POST["recaptcha_response_field"]);

            if ($this->response->is_valid) {
                    return true;
            } else {
                    # set the error code so that we can display it
                    return false;
            }
        }
        
        return false;
    }
    
    function get_error_description()
    {
        if ($this->response->error == 'incorrect-captcha-sol')
                    return get_option("maven-recaptcha-error-message");
        
        return $this->response->error;
    } 
    
    function get_options(){
	$aux_value = false;
	
	$pubkeyoption = new Maven_addon_option();
	$aux_value = get_option("maven-recaptcha-public-key");
	$pubkeyoption->value = $aux_value==false?"":$aux_value;
	$pubkeyoption->description = "";
	$pubkeyoption->name = _("Public key");
	$pubkeyoption->id = "maven-recaptcha-public-key";
	$pubkeyoption->type="input";
	
	$prikeyoption = new Maven_addon_option();
	$aux_value = get_option("maven-recaptcha-private-key");
	$prikeyoption->value = $aux_value==false?"":$aux_value;
	$prikeyoption->description = "";
	$prikeyoption->name = _("Private key");
	$prikeyoption->id = "maven-recaptcha-private-key";
	$prikeyoption->type="input";
	
	$erroroption = new Maven_addon_option();
	$aux_value = get_option("maven-recaptcha-error-message","<strong>ERROR</strong>: That reCAPTCHA response was incorrect.");
	$erroroption->value = $aux_value==false?"":$aux_value;
	$erroroption->description = "";
	$erroroption->name = _("Incorrect Guess");
	$erroroption->id = "maven-recaptcha-error-message";
	$erroroption->type="input";
	
	return array($pubkeyoption,$prikeyoption,$erroroption);
	
    }
    
    function save_options($options) {
	foreach($options as $option){
	    if ($option->id=="maven-recaptcha-public-key" || $option->id=="maven-recaptcha-private-key" || $option->id=="maven-recaptcha-error-message")
	    {
		if ($option->id=="maven-recaptcha-public-key"){
		    $validate = wp_remote_get("http://www.google.com/recaptcha/api/noscript?k={$option->value}");
		     
		    if (strpos($validate["body"],"Input error")!==false)
			return "There is an error in your reCaptcha keys. Please, check them. ";
		    
		}
		update_option ($option->id, $option->value);
	    }
	}
	
	return true;
	
    }
    
}


?>
