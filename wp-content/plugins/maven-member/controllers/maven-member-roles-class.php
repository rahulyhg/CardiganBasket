<?php


class Maven_member_roles extends Maven_member_base {

        var $action_role = "action-general-role";
        
	public function __construct() {
		parent::__construct();
		$this->load_model("roles");
		$this->load_model("users");
	}

	public function get_roles() {
		return $this->roles_m->get_all();
	}

	public function ajax_get_roles() {
		$this->send_ajax_result($this->roles_m->get_all());
	}

	public function remove_role($role) {

		$this->user_can();
		
		if (!$role)
		    return false;
		
		$role = $this->validate_role_name($role);
		
		// Get the users with the role
		$users = $this->get_users_by_role($role);
				
		if ($users){
			
			//Remove the from from the users
			foreach($users as $user)
				$this->get_users_class()->remove_user_from_role($user->ID,$role);
		}

		//TODO: Remove the roles from pages/posts
		$this->get_categories_class()->remove_role_from_all_category($role);
                
                $this->get_pages_class()->remove_role($role);
                
		$this->roles_m->remove($role);
	}

	public function ajax_remove_role() {
            
                $this->check_ajax_nonce($this->action_role);
            
		$role = $this->get_post_var("role_name");

		$this->remove_role($role);

		$this->send_ajax_result($role, false);
	}

	/**
	 *
	 * @param string $role
	 * @return WP_Role
	 */
	public function get($role) {
		return $this->roles_m->get($this->validate_role_name($role));
	}

	public function get_users_by_role($role)
	{
		$users = $this->roles_m->get_users_by_role($this->validate_role_name($role));

		return $users;
	}
	
	public function ajax_get_users_by_role()
	{
		$role = $this->get_post_var("role_name");
		
		$users = $this->get_users_by_role($role);

		$this->send_ajax_result($users,$role);
	}

	public function ajax_get_roles_by_user() {
		$user_id = $this->get_post_var("user_id");

		$this->send_ajax_result($this->get_roles_by_user($user_id),"ajax_get_user_roles");
	}

	public function get_roles_by_user($user_id) {

		return $this->roles_m->get_roles_by_user($user_id);
	}
	
	public function get_system_roles_by_user($user_id) {

		return $this->roles_m->get_system_roles_by_user($user_id);
	}

	/**
	 * Add a new role
	 * @param string $role_name
	 * @param array $capabilities
	 * @return string Role name strip
	 */
	public function add_role($role_name, $capabilities=null) {

		$this->user_can();

		
		if ($role_name) {

			//sanitize_title($role_name);
			$display_role = $role_name;

			// It's very important that we lower case the role name
			$role_name = $this->validate_role_name($role_name);

			//function add_role($role_name, $display_role, $capabilities)
			
			$this->roles_m->add_role($role_name,$display_role,$capabilities);

			return $role_name;
		}
	}

	
	private function validate_role_name($role_name) {
		return sanitize_title(stripslashes(strtolower($role_name)));
	}

	public function ajax_update_role() {
		$role_id = $this->get_post_var("role_id");
		$new_role = $this->get_post_var("value");

		$new_role = $this->update_role($role_id, $new_role);

		$this->send_ajax_result($new_role, false);
	}

	/**
	 * Update a role name
	 * @param string $oldrole
	 * @param string $new_role
	 */
	public function update_role($oldrole, $new_role) {

		$this->user_can();
		
		// ********************************************************
		// There is no way to update a role name using WP Core, so we need to add a new one and remove the old one
		// ********************************************************
		//TODO: Validate if the role exists
		if (!empty($new_role) && !empty($oldrole)) {
			$original = $new_role;

			// Get the old role
			$oldrole = $this->get($oldrole);

			// Add the new role
			$new_role = $this->add_role($new_role, $oldrole->capabilities);

			// Get the users asociated with the old role
			$users = $this->roles_m->get_users_by_role($oldrole->name);

			if ($users && count($users) > 0) {
				foreach ($users as $user) {
					$this->users_m->add_role_to_user($user, $new_role);
				}
			}

			$this->remove_role($oldrole->name);

			return $original;
		}

		return __("Invalid",maven_translation_key());
	}

	function is_role($role_name)
	{
		return $this->roles_m->is_role($role_name);
	}
	
	function is_system_role($role_name)
	{
		return $this->roles_m->is_system_role($role_name);
	}

	/**
	 * Add a role throw ajax
	 */
	public function ajax_add_role() {
		
		$this->user_can();
		//$this->check_ajax_nonce($this->action_role);

		$display_role = $this->get_post_var("role_name");
		$role_name = $this->add_role($display_role);

		$result = array("display_name"=>$display_role,"role_name"=>$role_name);
		$this->send_ajax_result($result);
	}
	

	/**
	 * Load the role view
	 */
	public function show_form() {
		$this->data["title"] = __("Roles",maven_translation_key());
		$this->data["roles"] = $this->get_roles();  
                $this->add_nonce_field($this->action_role);

		$this->load_admin_view("roles");
	}

}


?>