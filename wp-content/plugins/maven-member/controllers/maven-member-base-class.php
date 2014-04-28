<?php

class Maven_member_base {
    const PLUGIN_KEY = "maven_member";
    protected $data = array();

    public function __construct() {
        $this->data["plugin_url"] = $this->get_plugin_url();
        $this->data["plugin_image_url"] = $this->get_plugin_url() . "images/";
        $this->data["loading_image"] = $this->get_site_url() . "/wp-admin/images/wpspin_light.gif";
        $this->add_data("add_new_button", true);
    }

    protected function user_can() {
        // Check if the user has enough rights.
        if (!current_user_can('manage_options')) {
            wp_die(__('You don\'t have permissions to access this page.',maven_translation_key()));
        }
    }

    public function get_pluing_path() {
        return WBM_MEMBER_PLUGIN_DIR;
    }

    public function get_plugin_url() {
        return WBM_MEMBER_PLUGIN_URL;
    }

    protected function is_post() {
        return isset($_POST) && count($_POST)>0;
    }

//
//	function sendNotice($notice) {
////            $message = '<div class="updated fade"><p>' . $notice . '</p></div>';
////			//echo $message;
////			//echo $message;
////			$var = create_function('', "echo '$message';");
////			$var();
//            //add_action('admin_notices', create_function('', "echo '$message';"));
//
//			if ($notice != '') {
//			   $message = '<div class="updated fade"><p>' . $notice . '</p></div>';
//			   //$fnc =
//				add_action('admin_notices', );
//			}
//    }





    public function get_site_url() {
        return get_bloginfo('url');
    }

    public function get_host() {
        $url_parts = parse_url($this->get_site_url());

        if ($url_parts)
            return $url_parts["host"];

        return $this->get_site_url();
    }

    public function get_root_path() {
        $host = str_replace("http://", "", $this->get_host());
        $site = str_replace("http://", "", $this->get_site_url());

        if ($host == $site)
            return '';

        return str_replace($host, "", $site);
    }

    protected function get_js_url($resource, $extension="js") {
        return WBM_MEMBER_PLUGIN_URL . "js/{$resource}.{$extension}";
    }

    protected function get_css_url($resource) {
        return WBM_MEMBER_PLUGIN_URL . "css/{$resource}.css";
    }

    protected function get_fields_key() {
        return self::PLUGIN_KEY . "_fields";
    }

    protected function add_data($key, $value) {
        $this->data[$key] = $value;
    }
    
    protected function add_new_button($value=true)
    {
        $this->add_data("add_new_button", $value);
    }

    protected function load_admin_view($name) {

        $this->data["view"] = $this->get_admin_view($name);
        extract($this->data);
        include_once $this->get_pluing_path() . "/views/admin/base-view.php";
    }
    
    protected function load_admin_wp_view($name) {

        extract($this->data);
        include_once $this->get_pluing_path() . "/views/admin/$name-view.php";
    }

    protected function load_front_view($name) {

        extract($this->data);
        include_once $this->get_pluing_path() . "/views/$name-view.php";
    }

    protected function get_front_view($name) {
        $output = '';
        ob_start();
        extract($this->data);
        require_once($this->get_pluing_path() . "/views/$name-view.php");
        $output = ob_get_clean();
        return $output;
    }
    
     protected function get_admin_view($name) {
        $output = '';
        ob_start();
        extract($this->data);
        require_once($this->get_pluing_path() . "/views/admin/$name-view.php");
        $output = ob_get_clean();
        return $output;
    }

    protected function set_title($title) {
        $this->data["title"] = $title;
    }

    protected function load_model($model) {
        $model_name = "Maven_member_{$model}_model";
        $model_instance = "{$model}_m";
        $this->{$model_instance} = new $model_name;
    }

    /**
     * Return the value from post
     * @param <type> $key
     */
    protected function get_post_var($key) {
        if (isset($_POST[$key]))
            return $_POST[$key];

        return null;
    }

    protected function exists_post_var($key) {
        return isset($_POST) && isset($_POST[$key]);
    }
    
    protected function has_value_post_var($key) {
        return isset($_POST) && isset($_POST[$key]) && !empty($_POST[$key]);
    }

    protected function get_json_var($var, $default_value) {
        if (isset($_POST[$var]))
            return json_decode(stripslashes($_POST[$var]), true);
        else
            return $default_value;
    }

    protected function convert_to_json($data) {
        return json_encode($data);
    }

    /**
     * Send ajax response, in JSON
     * @param string $result
     */
    protected function send_ajax_result($result, $message="", $is_error = false,$json=true) {

        if ($json) {
            $result = array("is_error"=>$is_error, "message" => $message, "result" => $result);

            $result = $this->convert_to_json($result);
        }
        echo $result;
        die();
    }
    
    protected function send_ajax_error($result,$message)
    {
        $this->send_ajax_result($result,$message,true,true);
    }
    

    protected function is_my_plugin() {
        $pages = array("maven_member-section-fields", "maven_member-section-groups", "maven_member-section-users", "maven_member-section-settings", "maven_member-section-categories", "maven_member-section-import", "maven_member-section-templates", "maven_member-section-wizard", "maven_member-section-registration", "maven_member-section", "maven_member-section-help");

        if (isset($_GET['page'])) {
            return in_array($_GET['page'], $pages);
        }

        return false;
    }
    
    protected function is_category_page()
    {
	return ((isset($_GET['taxonomy']) && ($_GET['taxonomy'] == "category")) || (isset($_POST['taxonomy']) && $_POST['taxonomy'] == "category"));
    }

    protected function is_page($page) {

        switch ($page) {
            case "users":
                return $_GET['page'] == "maven_member-section-users";
            case "roles":
                return $_GET['page'] == "maven_member-section-groups";
            case "settings":
                return $_GET['page'] == "maven_member-section-settings";
            case "categories":
                return $_GET['page'] == "maven_member-section-categories";
            case "import":
                return $_GET['page'] == "maven_member-section-import";
            case "templates":
                return $_GET['page'] == "maven_member-section-templates";
            case "wizard":
                return $_GET['page'] == "maven_member-section-wizard";
            case "registration":
                return $_GET['page'] == "maven_member-section-registration";
        }

        return "not found";
    }

    protected function get_manager() {
        global $maven_manager;

        if (!$maven_manager)
            $maven_manager = new Maven_member_manager();


        return $maven_manager;
    }

    protected function get_blocker_class() {
        return $this->get_manager()->blocker_class;
    }

    protected function get_roles_class() {
        return $this->get_manager()->roles_class;
    }
    
    protected function get_addons_class() {
        return $this->get_manager()->addons_class;
    }

    protected function get_users_class() {
        return $this->get_manager()->users_class;
    }

    protected function get_categories_class() {
        return $this->get_manager()->categories_class;
    }

    public function get_setting_class() {
        return $this->get_manager()->settings_class;
    }

    protected function get_registration_class() {
        return $this->get_manager()->registration_class;
    }

    protected function get_pages_class() {
        return $this->get_manager()->pages_class;
    }

    protected function get_setting($setting) {
        return $this->get_manager()->settings_class->get_setting($setting);
    }

    protected function save_setting($setting, $value) {
        return $this->get_manager()->settings_class->save_setting($setting, $value);
    }

    protected function add_nonce($action) {
        $this->add_data("nonce", wp_create_nonce($this->convert_action_name($action)));
    }

    protected function add_nonce_field($action) {
        $this->add_data("nonce_field", wp_nonce_field($this->convert_action_name($action)));
    }

    protected function check_admin_nonce($action) {
        check_admin_referer($this->convert_action_name($action));
    }
    
    private function convert_action_name($action)
    {
        return self::PLUGIN_KEY . $action;
    }
    
    protected function check_nonce($action,$query_var=false) {
        
        $query_var = $query_var===false?"_wpnonce":$query_var;
        
        $nonce = $this->get_post_var($query_var);
        
        $result = wp_verify_nonce($nonce,$this->convert_action_name($action));
        
        if (!$result)
            $this->send_ajax_error ($result,__("Secutiry issue: Are you sure you want to do this?",maven_translation_key()));
    }
    
    protected function check_ajax_nonce($action)
    {
        $this->check_nonce($action,"_ajax_nonce");
    }
	
	function is_maven_action()
	{
		return $this->get_post_var(maven_global_key());
	}
	
	/**
	 * Validate the nonce
	 * @param string $action
	 * @param string $name
	 * @param string $method
	 * @param boolean $die
	 * @return boolean 
	 */
	public function validate_nonce($action, $query_var = '_wpnonce', $method='_POST', $die = true) {
		
		$error_message = '';
		
		$nonce = $this->get_post_var($query_var);
        
        $result = wp_verify_nonce($nonce,$this->convert_action_name($action));
		
		if ( wp_verify_nonce($nonce,$this->convert_action_name($action)) ) 
			return true;
		else
			$error_message = __('Action failed. Please refresh the page and retry.',maven_translation_key());
		
		if( $error_message && $die ) 
		{
			die( $error_message );
		}
		
		return false;
		
	}
	
	function redirect_to_referer($args='', $referer = '') {
		$query_args = wp_parse_args($args);
		if (empty($referer))
			$referer = wp_get_referer();

		if (is_array($query_args)) {
			foreach ($query_args as $key => $value)
			//Redirect back to the settings page that was submitted
				$referer = add_query_arg($key, $value, $referer);
		}
		wp_safe_redirect($referer);
		die('failed redirect?');
	}
	
	public function get_notice($message) {
        return "<div class='updated fade'><p>{$message}</p></div>";
    }
	

}

?>