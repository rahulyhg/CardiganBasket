<?php

class Maven_member_short_codes extends Maven_member_base {

    public function __construct() {
        parent::__construct();

        add_action("init", array(&$this, "init"));
    }

    public function init() {
        add_shortcode('mvn-login', array(&$this, 'shortcode_login'));

        add_shortcode('mvn-registration', array(&$this, 'shortcode_registration'));
    }

    function shortcode_login($atts, $content=null, $code="") {
        if ($atts)
            extract($atts);
		
        // $atts    ::= array of attributes
        // $content ::= text within enclosing form of shortcode element
        // $code    ::= the shortcode found, when == callback name
        // examples: [my-shortcode]
        //           [my-shortcode/]
        //           [my-shortcode foo='bar']
        //           [my-shortcode foo='bar'/]
        //           [my-shortcode]content[/my-shortcode]
        //           [my-shortcode foo='bar']content[/my-shortcode]

        return $this->get_setting_class()->get_login_control($atts);
    }

    function shortcode_registration($atts, $content=null, $code="") {
        if ($atts)
            extract($atts);

        // $atts    ::= array of attributes
        // $content ::= text within enclosing form of shortcode element
        // $code    ::= the shortcode found, when == callback name
        // examples: [my-shortcode]
        //           [my-shortcode/]
        //           [my-shortcode foo='bar']
        //           [my-shortcode foo='bar'/]
        //           [my-shortcode]content[/my-shortcode]
        //           [my-shortcode foo='bar']content[/my-shortcode]
        
        if ($this->get_setting_class()->is_registration_enabled())
            return $this->get_registration_class()->get_front_form();
        else
            return __("Registration is not enabled",maven_translation_key());
    }

}

?>