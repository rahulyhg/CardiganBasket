<?php


/*
Captcha Name: Maven Recaptcha
Description: This is a reCaptcha implementation
Version:     0.1
Author:      Emiliano Jankowski
License:     
*/

class Maven_dummy_captcha extends Maven_base_captcha{
    
    public function __construct() {
         
    }
    
    function get_captcha(){
        
        return __("There is no captcha selected",maven_translation_key());
    }
    
    function validate(){
        
    }
    
    function get_error_description(){
        
    }
    
    
    function get_options(){
	return array();
	
    }
    
    function save_options($options) {
	
    }
    
}


?>
