<?php

class Maven_member_roles_model extends Maven_member_base_model {

	var $system_roles = array("administrator", "editor", "author", "contributor", "subscriber");

	public function __construct() {
		parent::__construct();
	}


	function get_all() {
		global $wp_roles;
		
		return $this->fill_roles($wp_roles->role_objects);
	}

	function remove($role) {
		global $wp_roles;

		// remove a role, same arguments as remove_role()
		$wp_roles->remove_role($role);
	}

	/**
	 * Validate if the role is a system role
	 * @param string $role 
	 */
	function is_system_role($role)
	{
		if ($role)
			return in_array($role,$this->system_roles);
	
		return false;
	}


	/**
	 * Get a role
	 * @global <type> $wp_roles
	 * @param string $role
	 * @return <type>
	 */
	function get($role) {
//		global $wp_roles;
//
//		if (!$wp_roles)
//			$wp_roles = new WP_Roles();

		if (!$this->is_system_role($role))
		{
                    $role = get_role($role);
                    
                    
                    $role = $this->fill_roles($role);
                    
                    
                    return $role;
                    //return null;
                }
                        

		return null;
	}

	/**
	 * Get users by role
	 * @param string $role
	 * @return array
	 */
	public function get_users_by_role($role) {
		$wp_user_search = new WP_User_Query(array('role' => $role));
		$users = $wp_user_search->get_results();

		// Remove the user's passwords
		foreach($users as $user)
			$user->user_pass = ':-)';

//				$users = json_encode($users);
//
//				echo $users;
//				die();


		return $users;
	}

	public function add_role($role_name, $display_role, $capabilities=null)
	{
		global $wp_roles;
		//TODO: What default capability do we need? array("read"=>true)
		// 
		// Check if it already exists
		if (!$wp_roles->is_role($role_name))
			return $wp_roles->add_role($role_name, $display_role, $capabilities);

	}

	public function is_role($role_name)
	{
		global $wp_roles;
		
		return $wp_roles->is_role($role_name);
	}

	private function fill_roles($data) {
		//var_dump($data);
		$roles = array();
		global $wp_roles;

		if (is_array($data))
		{
			foreach ($data as $key => $value) {

				// It's very important to remove the system roles
				if (!$this->is_system_role($key))
				{
					$role = new stdClass();
					$role->name = $wp_roles->role_names[$key];
					$role->capabilities = $value->capabilities;
					$role->internal_name = $key;
					//$role_names
					$roles[$value->name] = $role;

					
				}
			}

			return $roles;
		}
		else
		{
			$role = new stdClass();
			$role->name = $wp_roles->role_names[$data->name];
			$role->capabilities = $data->capabilities;
			$role->internal_name = $data->name;

			$roles[$data->name] = $role;

			return $role;
		}
		
	}



	function get_roles_by_user($user_id) {

		$user = new WP_User($user_id);

		$existing_roles = $this->get_all();
 
		$user_roles = array();
 

		if (!empty($user->roles) && is_array($user->roles)) {
			foreach($user->roles as $role)
			{
				if (!$this->is_system_role($role))
				{
					$user_roles[$role] = $existing_roles[$role];
				}
			}
 

			return $this->fill_roles($user_roles);
		}
		return $user_roles;
	}
	
	function get_system_roles_by_user($user_id) {

		$user = new WP_User($user_id);

		$existing_roles = $this->get_all();
 
		$user_roles = array();
 
		
		if (!empty($user->roles) && is_array($user->roles)) {
			foreach($user->roles as $role)
			{
				if ($this->is_system_role($role))
				{
					$user_roles[$role] = $role;
				}
			}
 
			return $user_roles;
		}
		return $user_roles;
	}


}

?>