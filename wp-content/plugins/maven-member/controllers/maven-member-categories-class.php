<?php

class Maven_member_categories extends Maven_member_base {

    var $role_key = "maven-role";
    var $system_categories = array("Uncategorized");
    var $action_general = "category-action-general";

    public function __construct() {
        parent::__construct();

        $this->load_model("categories");

        add_action('init', array(&$this, 'init'));
    }

    public function init() {
	
	if ($this->is_category_page()){
	    add_action('category_add_form_fields', array(&$this, 'add_fields'));
	    add_action('category_edit_form_fields', array(&$this, 'add_fields'));
	    add_action('edited_category', array(&$this, 'save_fields'));
	    add_action('created_category', array(&$this, 'save_fields'));
	
	    }

        //add_filter('manage_edit-category_columns',   array(&$this, 'categoriesColumnsHeader'));
        //TODO: This filter doesn't work
        //add_filter('manage_category_custom_column',  'categoriesColumnsRow', 10, 3);
    }

    function categoriesColumnsHeader($columns) {
        $columns['maven_roles'] = __('Maven roles',maven_translation_key());
        return $columns;
    }

    function categoriesColumnsRow($empty, $columnName, $id) {
        if ($columnName == 'maven_roles') {
            return $id;
        }
    }

    /**
     * Add roles to the category form
     * @param array $tag
     */
    function add_fields($tag) {

        // Get all roles
        $roles = $this->get_roles_class()->get_roles();

        // If we are editing a category
        if ($tag && isset($tag->term_id)) {
            $existing_role = $this->get_category_roles($tag->term_id);
            if ($existing_role) {
                foreach ($roles as $role) {
                    $role->selected = false;

                    foreach ($existing_role as $ex_role) {
                         
                        if ($role->internal_name == $ex_role->internal_name)
                            $role->selected = true;
                    }
                }
            }
        }
         
        foreach($roles as $role)
            if (!isset($role->selected))
                    $role->selected = false;
         

         
        $this->data["roles"] = $roles;
        $this->load_admin_wp_view("wp-category-form");
    }

    public function ajax_reset_roles() {
        $cat_id = $this->get_post_var("cat_id");

        $result = $this->reset_roles($cat_id);

        if ($result)
            $this->send_ajax_result(__("Reseted",maven_translation_key()));
        else
            $this->send_ajax_result(__("Not Reseted",maven_translation_key()));
    }
    
    public function reset_roles($cat_id) {

        $meta = $this->categories_m->get_category_meta($cat_id);

        if (!$meta)
            $meta = array();

        $meta[$this->role_key] = null;

        return $this->categories_m->update_category_meta($cat_id, $meta);
    }

    public function ajax_update_category() {
        
        //$this->check_ajax_nonce($this->action_general);
        
        $cat_id = $this->get_post_var("cat_id");
        $cat_name = $this->get_post_var("cat_name");
        $reset = $this->get_post_var("reset");
        $roles = null;

        $result = array();

        $cat = $this->categories_m->update_category($cat_id, $cat_name);
        
        if ($reset) {
            $cat_id = $this->get_post_var("cat_id");

            $meta = $this->categories_m->get_category_meta($cat_id);

            if (!$meta)
                $meta = array();

            $meta[$this->role_key] = null;

            $this->categories_m->update_category_meta($cat_id, $meta);

            $result["reseted"] = true;
        }
        else
           // Check if it has roles
            $roles = $this->ajax_add_roles(true);
            
        $result["reset"] = $reset;
        
        $result["roles"] = $roles;
        $result["category"] = $cat;

        $this->send_ajax_result($result);
    }

    public function save_fields($cat_id) {
		if(!$this->is_maven_action())
			return;
		
        if ($this->get_post_var($this->role_key)) {

            $meta = $this->categories_m->get_category_meta($cat_id);
            if (!$meta)
                $meta = array();
            
            $meta[$this->role_key] = $this->get_post_var($this->role_key);

            $this->categories_m->update_category_meta($cat_id, $meta);
        }
		else {
            $meta = $this->categories_m->get_category_meta($cat_id);

            $meta[$this->role_key] = "";

            $this->categories_m->update_category_meta($cat_id, $meta);
        }
    }

    //TODO: Add a "add_roles" method for non-ajax calls
    public function ajax_add_roles($return=false, $id=null) {
        $cat_id = $this->get_post_var("cat_id");
        $roles = $this->get_post_var("roles");

        if ($id)
            $cat_id = $id;

        if ($roles && $cat_id) {
            $meta = $this->categories_m->get_category_meta($cat_id);

            if (!$meta)
                $meta = array();

            $new_roles= explode(",", $roles);

            if (isset($meta[$this->role_key]) && $meta[$this->role_key])
			{
				foreach($meta[$this->role_key] as $e_role)
				{
					if (!in_array($e_role,$new_roles))
						$this->remove_category_role($cat_id,$e_role);
				}
			}
            
			$meta[$this->role_key] = $new_roles;
                    
            //Validate roles
            foreach ($meta[$this->role_key] as $role) {
                if (!$this->get_roles_class()->is_role($role))
                    $this->send_ajax_result(__("Role doesn't exists:",maven_translation_key()) . $role);
            }

            $result = $this->categories_m->update_category_meta($cat_id, $meta);

            $roles = $meta[$this->role_key];
            $return_roles = array();

            foreach ($roles as $role) {
                $complete_role = $this->get_roles_class()->get($role);
                $return_roles[] = $complete_role;
            }

            if ($return)
                return $return_roles;
            else
                $this->send_ajax_result($meta[$this->role_key]);
        }

        if (!$return)
            $this->send_ajax_result(__("Not saved",maven_translation_key()));
    }

    public function get_category_roles($cat_id) {

        $meta = $this->categories_m->get_category_meta($cat_id);
                
        $roles = null;

        
        //&& $meta[$this->role_key][0]->name 
        if ($meta && $meta[$this->role_key] && count($meta[$this->role_key])>0 ){
            $roles = $meta[$this->role_key];

            // We need full role information
            for ($i = 0; $i <= count($roles) - 1; $i++)
			{				
				$role = $roles[$i];
				if (is_object($role))
				{	
					// TODO: check this because woul be better if all $roles have the same info
					// this fix was used because, in some places the $role is only a text with the role name
					// and in other places it has an array and the role name is in the internal_name property
					if(isset($role->internal_name))
						$roles[$i] = $this->get_roles_class()->get($role->internal_name);
					else
						$roles[$i] = $this->get_roles_class()->get($role->name);
				}
				else
					$roles[$i] = $this->get_roles_class()->get($role);
			}
        }

        return $roles;
    }

    public function ajax_get_category_roles() {

        $cat_id = $this->get_post_var("cat_id");

        $roles = $this->get_category_roles($cat_id);

        $this->send_ajax_result($roles);
    }

    public function get_post_categories() {
        return $this->categories_m->get_post_categories();
    }

    public function remove_category_role($id_category, $role) {
        $this->categories_m->delete_category_meta($id_category, $this->role_key);
    }

    public function get_parents() {
        $categories = $this->categories_m->get_parents();
        $categories = $this->fill_categories($categories);
        
        return $categories;
    }

    private function fill_categories($categories) {
        // Mark the system categories
        foreach ($categories as $category) {
            if (in_array($category->name, $this->system_categories))
                $category->is_system = true;
            else
                $category->is_system = false;

            $category->roles_keys = array();
            $category->roles = $this->get_category_roles($category->term_id);
           
            
            if (!isset($category->roles) || !$category->roles)
                $category->roles = array();


            $category->roles_names = '';
            if ($category->roles)
                foreach ($category->roles as $role) {
                    $category->roles_names .= ! $category->roles_names ? $role->name : ",{$role->name}";
                    $category->roles_keys[] = $role->internal_name;
                }
        }

        return $categories;
    }

    public function get_all() {
        $categories = $this->categories_m->get_all();

        return $this->fill_categories($categories);
    }

    public function remove_role_from_all_category($role) {
        $categories = $this->get_all();
        foreach ($categories as $category) {
            
            $meta = $this->categories_m->get_category_meta($category->term_id);

            if ($meta && $meta[$this->role_key])
            {        
                //Array with the roles
                $existing_roles = $this->get_category_roles($category->term_id);

                if ($existing_roles && count($existing_roles)>0 && $existing_roles[0]->name )
                {
                    foreach($existing_roles as $existing_role_key=> $existing_role)
                    {
			if ($existing_role->internal_name == $role)
                            unset($existing_roles[$existing_role_key]);
		    }
		    
                    $meta[$this->role_key] = $existing_roles;
                    
                    //var_dump($existing_roles);    
                    $this->categories_m->update_category_meta($category->term_id, $meta);
                }  
            }
            //$existing_roles = $this->get_category_roles($category->term_id);
            //var_dump($existing_roles);
        }
    }

    function add_category($name) {
        return $this->categories_m->add_category($name);
    }

    function ajax_add_category() {
        $name = $this->get_post_var("cat_name");
        $id = $this->add_category($name);

        // Check if it has roles
        $roles = $this->ajax_add_roles(true, $id);

        $this->send_ajax_result(array("id" => $id, "name" => $name, "roles" => $roles));
    }

    function ajax_delete_category() {
        $id = $this->get_post_var("cat_id");
        $result = $this->delete_category($id);
        $this->send_ajax_result(array("id" => $id, "result" => $result));
    }

    function delete_category($id) {
        return $this->categories_m->delete_category($id);
    }

    /**
     * Load the role view
     */
    public function show_form() {
        $this->data["title"] = __("Categories",maven_translation_key());
        $this->data["categories"] = $this->get_parents();
        $this->data["roles"] = $this->get_roles_class()->get_roles();
        $this->add_nonce_field($this->action_general);

        $this->load_admin_view("categories");
    }

}

?>