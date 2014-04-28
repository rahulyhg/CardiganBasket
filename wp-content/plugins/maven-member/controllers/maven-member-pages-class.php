<?php

class Maven_member_pages extends Maven_member_base {

    var $role_key = "maven-page-role";

    public function get_role_key()
    {
        return $this->role_key;
    }
    
    public function __construct() {
        parent::__construct();

        $this->load_model("pages");

        add_action('init', array(&$this, 'init'));
    }

    public function init() {

        if (is_super_admin() || current_user_can('manage_options')) {
            add_action('save_post', array(&$this, 'save_data'));
            add_action('add_meta_boxes', array(&$this, 'add_customBox'));
        }
    }

    /* Adds a box to the main column on the Post and Page edit screens */

    public function add_customBox() {

        add_meta_box(
                'myplugin_sectionid', __('Maven roles', 'myplugin_textdomain'), array(&$this, 'add_fields'), 'page'
        );
    }

    function add_fields($post, $metabox) {

        //var_dump($post->ID);
        // Use nonce for verification
        //wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

        $this->data["title"] = __("Maven Roles",maven_translation_key());

        // Get all roles
        $roles = $this->get_roles_class()->get_roles();

        $existing_roles = array();

        if ($post->ID)
            $existing_roles = $this->get_roles($post->ID);

        if (!$existing_roles)
            $existing_roles = array();

        foreach ($roles as $role) {
            $role->selected = false;

            foreach ($existing_roles as $aux) {

                if (trim($role->internal_name) == trim($aux)) {
                    $role->selected = true;
                    break;
                }
            }
        }
        $this->data["roles"] = $roles;
        $this->load_admin_wp_view("wp-page-form");
    }

    public function remove_role($role)
    {
        //Get all pages 
        $pages = get_pages();
        
        
        foreach ($pages as $pagg) {
                
                $existing_roles = $this->get_roles($pagg->ID);
                
                if ($existing_roles && is_array($existing_roles))
                {
		    foreach($existing_roles as $existing_role_key=> $existing_role)
                    {
			if ($existing_role == $role)
                            unset($existing_roles[$existing_role_key]);
		    }
		    
                    //TODO: Move it into the model
                    update_post_meta($pagg->ID, $this->role_key, $existing_roles);
                }
        }
    }
    
    
    private function get_roles($id)
    {
        return get_post_meta($id, $this->role_key, true);
    }
    
    function save_data($post_id) {

        //		  // verify this came from the our screen and with proper authorization,
        //		  // because save_post can be triggered at other times
        //
	//		  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) ) )
        //			  return $post_id;
        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (isset($_POST['post_type'])) {
            // Check permissions
            if ('page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return $post_id;
            }
            else {
                if (!current_user_can('edit_post', $post_id))
                    return $post_id;
            }


            if ($this->get_post_var($this->role_key)) {

                $meta = get_post_meta($post_id, $this->role_key, true);

                $meta = $this->get_post_var($this->role_key);

                update_post_meta($post_id, $this->role_key, $meta);
            }
            else
                update_post_meta($post_id, $this->role_key, null);
        }
    }

    function ajax_save_page_template_roles() {
        $page = $this->get_post_var("template");
        $roles = $this->get_post_var("roles");
        $reset = $this->get_post_var("reset");
        if ($reset)
            $roles = array();

        $result = array();
        $result["saved"] = $this->pages_m->save_page_template_roles($page, $roles);

        $result["roles"] = '';
        if ($roles) {
            $roles_arr = array();
            foreach (explode(",", $roles) as $role)
                $roles_arr[] = $this->get_roles_class()->get($role);

            $result["roles"] = $roles_arr;
        }


        $this->send_ajax_result($result);
    }

    public function get_current_template_roles() {
        $roles = $this->pages_m->get_current_template_roles();
        $aux_roles = array();

        foreach ($roles as $role)
            $aux_roles[] = $this->get_roles_class()->get($role);

        return $aux_roles;
    }

    private function get_page_templates() {
        $templates = $this->pages_m->get_page_templates();

        foreach ($templates as $template) {
            $template->roles_names = '';
            if ($template->roles_keys) {
                $keys = explode(",", $template->roles_keys);
                $role_names = '';
                foreach ($keys as $key) {
                    $aux_role = $this->get_roles_class()->get($key);

                    if (!$role_names)
                        $role_names = $aux_role->name;
                    else
                        $role_names .= "," . $aux_role->name;
                }

                $template->roles_names = $role_names;
            }
        }

        return $templates;
    }

    /**
     * Load the role view
     */
    public function show_templates() {

        $this->set_title(__("Templates",maven_translation_key()));
        $this->add_data("templates", $this->get_page_templates());
        $this->add_data("roles", $this->get_roles_class()->get_roles());
        $this->add_new_button(false);
                
        $this->load_admin_view("templates");
    }

}

?>