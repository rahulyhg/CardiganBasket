<?php

abstract class Maven_base_captcha
{
    abstract function get_captcha();
    abstract function validate();
    abstract function get_error_description();
    
    /**
     * Return an array with Maven_addon_option
     */
    abstract function get_options();
    
    /**
     * @param $options: array of Maven_addon_option
     */
    abstract function save_options($options);
    
    
    function add_library($name){
        require_once WBM_MEMBER_PLUGIN_DIR."addons/captcha/$name";
    }
    
     
    
}
?>
