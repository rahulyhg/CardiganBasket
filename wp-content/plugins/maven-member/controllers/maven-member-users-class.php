<?php

class Maven_member_users extends Maven_member_base {

	public function __construct() {
		parent::__construct();

		$this->load_model("users");

		add_action('init', array(&$this, 'init'));
	}

	public function init()
	{
		if (is_super_admin()){
		// add Actions
		add_action('edit_user_profile', array(&$this, 'add_fields'));
		add_action( 'show_user_profile', array(&$this, 'add_fields' ));
		add_action( 'personal_options_update',  array(&$this, 'save_fields' ));
		add_action( 'edit_user_profile_update',  array(&$this, 'save_fields' ));
		
		
		add_action('edit_user_profile', array(&$this, 'add_roles_fields'));
		//add_action('show_user_profile', array(&$this, 'add_roles_fields' ));
		
		add_action('profile_update', array(&$this, 'save_roles'), 10, 2);
		// this action runs after wp saved user info
		add_action('user_register', array(&$this, 'save_roles'));
		}
		// add filters
		add_filter('editable_roles',array(&$this, 'filter_editable_roles'));
	}
	
	/*
	 * remove maven roles from the roles combobox in the add and edit user.
	 */
	function filter_editable_roles($editable_roles) {
	    global $pagenow;
	    $roles = array();
	    if (in_array($pagenow, array('user-edit.php', 'user-new.php'))) {
		    $roles = maven_manager()->roles_class->get_roles();
		    foreach ($roles as $role => $role_info) {
			    if (array_key_exists($role, $editable_roles))
				    unset($editable_roles[$role]);
		    }
	    }

	    return $editable_roles;
	}

	
	/**
	 * Add maven roles
	 * @param object $user
	 */
	function add_roles_fields($user) {

		// Get all registration fields
		$roles = $this->get_roles_class()->get_roles();

		// Get user maven roles, to do this, filter user capabilities and compare if it is a maven role
		$saved_roles = $this->get_roles($user->ID);
		//$saved_roles = array_filter(array_keys($user->wp_capabilities), array(&$this->mvn_roles, 'is_maven_role'));
		// this permit not show roles when the user edited is an admin
		$this->data["is_admin"] = false;
		if(in_array('administrator', $user->roles))
			$this->data["is_admin"] = true;
		
		if ($roles) {
			foreach ($roles as &$role) {
				if (in_array($role, $saved_roles)) {
					$role->selected = 1;
				}else
					$role->selected = 0;
			}
		}
//
//		$this->output->add_data("mvn_member_roles", $roles);
//
//		$this->output->load_admin_wp_view("wp-user-form-roles");
		
		$this->data["mvn_member_roles"] = $roles;
		
		$this->load_admin_wp_view("wp-user-form-roles");
	}

	/**
	 * Save maven roles related with the user
	 * @param int $user_id
	 * @param object|null $old_data Null when it is a new user, object with user information when it is an update
	 * @return null|anything Null if the current user can't edit users
 	 */
	function save_roles($user_id, $old_data = null) {
		if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

		$roles = ($this->get_post_var('mvn_member_roles') ? (array)$this->get_post_var('mvn_member_roles') : array());
		$role_selected = $this->get_post_var('role') ? $this->get_post_var('role') : '';
		if($old_data){
                    if (is_array($roles) && count($roles)>0)
                    {
                            $existing_roles = $this->get_roles($user_id);

                            foreach($existing_roles as $role)
                            {
                                    if (!in_array($role->internal_name,$roles))
                                            $this->remove_user_from_role($user_id,$role->internal_name);
                            }


                            foreach($roles as $role)
                            {
                                    if (!$this->has_role($user_id,$role)){
                                            $this->add_role_to_user($user_id, $role);
                                    }
                            }
                    }
                    else {
                            if(!empty($role_selected))
                                    $this->reset_roles($user_id, $role_selected);
                    }
                }else{
                    $default_role = $this->get_setting_class()->get_default_registration_role();
                    if ($default_role)
                        $this->get_users_class()->add_role_to_user($user_id, $default_role);
                }
	}
	/**
	 * Add registration fields
	 * @param array $tag
	 */
	function add_fields($user) {

		// Get all registration fields
		$fields =  $this->get_registration_class()->get_non_wp_fields();

		
		// Get saved registration fields
		$saved_fields = $this->get_registration_fields( $user->ID);
                if ($saved_fields){
                    foreach($fields as $field)
                    {
                            foreach($saved_fields as $saved_field)
                            {
                                    if ($field->id == $saved_field->id )
                                                    $field->value = $saved_field->value;
                            }
                    }
                }
		
		$this->data["fields"] = $fields;
		
		$this->load_admin_wp_view("wp-user-form");
	}


	function save_fields($user_id ) {

		if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

		$fields =  $this->get_registration_class()->get_non_wp_fields();
		foreach($fields as $field){
			$field->value = $this->get_post_var("maven-{$field->id}");
		}

		$this->save_registration_fields($user_id,$fields);
	}

	function save_registration_fields($user_id,$fields){
		$this->save_meta($user_id, 'maven-member-registration-fields',$fields);
	}

	function get_registration_fields($user_id){
		return $this->get_meta($user_id, 'maven-member-registration-fields',true);
	}

	function get_meta($user_id,$meta_key,$single=false)
	{
		return $this->users_m->get_meta($user_id,$meta_key,$single);
	}
	
	public function get_users($with_roles=false) {
		$users = $this->users_m->get_all();

		if (!$with_roles)
			return $users;
		else
		{
			foreach($users as $user)
			{
				$user->enabled = $this->is_enabled($user->ID);
				
				//var_dump($user);
				$user->roles_keys = array();
				$user->roles = $this->get_roles($user->ID);
				
				if (!$user->roles)
					$user->roles = array();

				//var_dump($user->roles);echo '<br/>';
				
				$user->roles_names = '';
                                $roles_keys =array();
				if ($user->roles)
					foreach($user->roles as $role)
					{
						$user->roles_names .= !$user->roles_names?$role->name:",{$role->name}";
						$roles_keys[] =$role->internal_name;
                                                //var_dump($role);echo '<br/>';
//						var_dump($user->roles_keys);echo '<br/>';
					}
                                        
                                
                               $user->roles_keys = $roles_keys;
					
			}

			return $users;
		}
	}

	public function ajax_get_users() {
		$users = $this->users_m->get_all();

		$this->send_ajax_result($users);
	}

	function ajax_delete_user($user_id)
	{
		
		
		$user_id = $this->get_post_var("user_id");
		$this->delete_user($user_id);

		$this->send_ajax_result($user_id);
	}

	function delete_user($user_id)
	{
		$this->user_can();
		
		$this->users_m->delete_user($user_id);
	}

	function ajax_save_user()
	{
		$user_id = $this->get_post_var("user_id");
		$value = $this->get_post_var("value");

		$enable = $this->enable_user($user_id,$value);

		$this->ajax_add_roles_to_user();
	}

	public function insert_user($userdata)
	{
		$this->user_can();
		
		$user_id = $this->users_m->insert_user($userdata);
                
                if ($this->get_setting_class()->activation_by_default())
                {
                    $this->enable_user($user_id, 1);
                }
                
                return $user_id;
	}
        
        public function register_user($userdata)
	{
		$user_id = $this->users_m->insert_user($userdata);
                
                if ($this->get_setting_class()->activation_by_default())
                {
                    $this->enable_user($user_id, 1);
                }
		else
		    $this->enable_user($user_id, 0);
                
                return $user_id;
	}

	public function ajax_add_roles_to_user() {

		$this->user_can();

		
		$user_id = $this->get_post_var("user_id");
		$roles = $this->validate_role_name($this->get_post_var("roles"));
		$result = array("message" => "add_role_to_user");
		if ($roles)
		{
			$existing_roles = $this->get_roles($user_id);
			$roles = explode(",", $roles);

			foreach($existing_roles as $role)
			{
				if (!in_array($role->internal_name,$roles))
					$this->remove_user_from_role($user_id,$role->internal_name);
			}


			foreach($roles as $role)
			{
				if (!$this->has_role($user_id,$role))
					$this->add_role_to_user($user_id, $role);
			}
		}
		else
		{
			$existing_roles = $this->get_system_roles($user_id);
			$current_role = '';
			if( is_array($existing_roles) ) {
				foreach ($existing_roles as $role) {
					if( maven_manager()->roles_class->is_system_role($role) )
						$current_role = $role;
				}
			}
			$this->reset_roles($user_id, $current_role);
		}

		$result["result"] = __("Inserted",maven_translation_key());

		$this->send_ajax_result($result);
	}

	public function remove_user_from_role($user_id,$role)
	{

		$this->user_can();
		
		$this->users_m->remove_user_from_role($user_id, $this->validate_role_name($role));

		// Get existings user roles
		$existing_roles = $this->get_roles($user_id);

		// If the user doesn't have roles, set the default
		//if (!$existing_roles || count($existing_roles )<=0)
		//	$this->users_m->reset_roles($user_id);
	}

	public function add_role_to_user($user_id, $role) {

		return $this->users_m->add_role_to_user($user_id, $role);
	}

	public function current_user_can($roles) {
		$user_can = false;
		
		if (is_array($roles))
		{	foreach($roles as $role)
			{
				// TODO: check this because woul be better if all $roles have the same info
				// this fix was used because, in some places the $role is only a text with the role name
				// and in other places it has an array and the role name is in the internal_name property
				if(isset($role->internal_name))
					$user_can = current_user_can($role->internal_name);
				else
					$user_can = current_user_can($role);
				
				if ($user_can)
					return true;
			}
		}
		else
			$user_can = current_user_can($this->validate_role_name($role));

		return $user_can;
		
	}

	private function has_role($user_id,$role)
	{
		return $this->users_m->has_role($user_id,$role);
	}
	
	/*
	 * Check if the user has roles created with maven-member plugin
	 */
	public function has_roles($user_id)
	{
		return $this->get_roles($user_id);
	}

	private function validate_role_name($role_name) {
		return stripslashes(strtolower($role_name));
	}
	
	public function get_roles($user_id) {
		return $this->get_roles_class()->get_roles_by_user($user_id);
	}
	
	public function get_system_roles($user_id) {
		return $this->get_roles_class()->get_system_roles_by_user($user_id);
	}

	public function ajax_add_user()
	{

		$this->user_can();
		
		$user_name = $this->get_post_var("user_name");
		$password = $this->get_post_var("password");
		$user_email = $this->get_post_var("user_email");
        $enable = $this->get_post_var("enabled");
		
		if($this->email_exists($user_email)){
			$this->send_ajax_result('','The email already exist.',true);
		}
		if($this->username_exists($user_name)){
			$this->send_ajax_result('','The username already exist.',true);
		}
		$user = $this->users_m->add_user($user_name,$password,$user_email);
                
        $this->enable_user($user, $enable);
                
		$roles = $this->validate_role_name($this->get_post_var("roles"));

		$roles = explode(",", $roles);
		foreach($roles as $role)
		{
			if (!$this->has_role($user,$role))
				$this->add_role_to_user($user, $role);
		}

                // Get user info
                $user = $this->users_m->get_user($user);
                
                $user->roles_keys = array();
                $user->roles = $this->get_roles($user->ID);

                if (!$user->roles)
                        $user->roles = array();

                $roles_names = '';
				$roles_keys =array();
                if ($user->roles)
                        foreach($user->roles as $role)
                        {
                                $roles_names .= !$roles_names?$role->name:",{$role->name}";
								$roles_keys[] =$role->internal_name;
                        }
                                        
                $user->enabled = $enable;
                
                $new_row = "<tr id='user-row-{$user->ID}'>";
                    $new_row .="<td class='username column-username'>";
                    $new_row .="{$user->display_name}<br />";
                    $new_row .="<div class='row-actions'>";
                        $new_row .="<a class='maven-edit' href='{$user->ID}'>".__('Edit',maven_translation_key())."</a>";
                
                        if(!$user->enabled)
                            $new_row .="<a class='maven-enable on' href='#{$user->ID}'>| ".__('Enable',maven_translation_key())."</a>";  
                        else
                            $new_row .="<a class='maven-enable off' href='#{$user->ID}'>| ".__('Disable',maven_translation_key())."</a>";
                
                            $new_row .="<a class='maven-remove confirm' href='#{$user->ID}'>| ".__('Delete',maven_translation_key())."</a>";
                    $new_row .="</div>";			
                    $new_row .="<div id='inline-{$user->ID}' class='hidden'>";
                        $new_row .="<div class='user_name'>{$user->display_name}</div>";			
                        $roles_keys = implode(',', $roles_keys);
                        $new_row .="<div class='user_existing_roles'>{$roles_keys}</div>";
                        $new_row .="<div class='user_enabled'>{$user->enabled}</div>";
                    $new_row .="</div>";			
                    $new_row .="</td>";
					$new_row .='<td class="username column-username">';
					$new_row .=	'<span class="user-names">&nbsp;</span>';
					$new_row .='</td>';
                    $new_row .="<td class='username column-username'>";
                        $new_row .="<span class='roles-names'>{$roles_names}</span>";
                    $new_row .="</td>";
                    $new_row .="<td class='username column-username'>";
                    $enable = $user->enabled?'checked="checked"':'';
                        $new_row .="<input class='list-user-enabled' type='checkbox' {$enable} disabled='disabled' />";
                    $new_row .="</td>";
		$new_row .="</tr>";
					
                $result = array();
                $result["user"] = $user;
                $result["new_row"] = $new_row;
		$this->send_ajax_result($result);
	}
	
	public function add_user($user_name,$password,$user_email)
	{
		$this->user_can();
		
		return $this->users_m->add_user($user_name,$password,$user_email);
	}

	function update_user_info($userdata)
	{
		return $this->users_m->update_user_info($userdata);
	}

	function get_user_info($user_id)
	{
		return $this->users_m->get_user_info($user_id);
	}

	function username_exists($user_name)
	{
		return $this->users_m->username_exists($user_name);
	}
	
	function email_exists( $email )
	{
		return $this->users_m->email_exists( $email );
	}
	
	public function ajax_get_roles() {
		$user_id = $this->get_post_var("user_id");
		$result = array("message" => "get_roles");
		$result["result"] = $this->get_roles($user_id);

		$this->send_ajax_result($result);
	}

	/**
	 * Method to reset roles and assign a default one
	 * @param int $user_id
	 * @param string $role  Role to assign if it is empty default wp role would be used
	 */
	public function reset_roles($user_id, $role = '') {

		$this->user_can();
		
		$this->users_m->reset_roles($user_id, $role);
	}

	public function ajax_reset_roles() {
		$user_id = $this->get_post_var("user_id");

		$this->reset_roles($user_id);

		$this->users_m->save_meta($user_id,'enabled',null);
		
		$this->send_ajax_result('',$user_id);
	}


	function is_current_user_enabled()
	{
		//TODO: Move it to the model
		$current_user = wp_get_current_user();
		//var_dump($current_user);
		return $this->is_enabled($current_user->ID);
				
	}
	
	function is_user_enabled($user)
	{
		//TODO: Move it to the model
		//$current_user = wp_get_current_user();
		//var_dump($current_user);
		return $this->is_enabled($user->id);
				
	}

	function is_user_logged_in()
	{
		return is_user_logged_in();
	}


	function is_enabled($user_id)
	{
		//var_dump($user_id);
		$enabled = $this->users_m->get_meta($user_id,'enabled',true);

		//TODO: Why do I have to use this comparation? 
		if (!$enabled AND $this->has_roles($user_id))
			return false;

		return true;
	}

	function enable_user($user_id,$value)
	{
		if ($user_id )
		{
			$result = $this->users_m->save_meta($user_id,'enabled',$value);
			if($result AND $value == 1)
				maven_manager()->registration_class->wp_user_activated_notification($user_id);
			return $result;
		}
		return false;
	}

	function save_meta($user_id, $key,$value)
	{
		return $this->users_m->save_meta($user_id,$key,$value);
	}

	function ajax_enable_user( )
	{
		$user_id = $this->get_post_var("user_id");
		$value = $this->get_post_var("value");
		
		$result = array();
		$result["result"] = $this->enable_user($user_id,$value);
		$result["value"] = $value;
                
		
		$this->send_ajax_result($result,"ajax_enable_user");
	}

	public function show_form() {
		$this->data["title"] = __("Users",maven_translation_key());
		$users = $this->get_users(true);
		$fields =  $this->get_registration_class()->get_non_wp_fields();
		$fields_value = array();
		foreach ($users as $index=>$user){

			$fields_value[$user->ID] = $this->get_meta($user->ID, 'maven-member-registration-fields',true);
			
			
			
		}
		
		$this->data["fields"] = $fields;
		$this->data["users"] = $users;
		$this->data["fields_value"] = $fields_value;
		$this->data["roles"] = $this->get_roles_class()->get_roles();
  
		$this->load_admin_view("users");
	}

}

?>