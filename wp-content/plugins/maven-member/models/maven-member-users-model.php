<?php

class Maven_member_users_model extends Maven_member_base_model {

	//var $system_users = array('admin');

	public function __construct() {
		parent::__construct();
	}

        function get_user($user_id)
        {
            $user = get_userdata($user_id);
            
            // Reove the user password
            $user->user_pass = "";
            
            return $user;
        }
        
	function get_super_admin(){
	    
	    $users = get_users();
	    
	    foreach($users as $user)
	    {
		    if (is_super_admin($user->ID))
			    return $user;
	    }
	}
	
	
	function get_all() {
		
		$users = get_users();
		$user_aux = array();
                
		
		// Remove the user's passwords
		foreach($users as $user)
		{
			if (!is_super_admin($user->ID))
			{
				$user->user_pass = ':)';

				$meta = $this->get_meta($user->ID,'enabled');
				$first_name = $this->get_meta($user->ID,'first_name');
				$last_name = $this->get_meta($user->ID,'last_name');
				$user->enabled = false;

				//TODO: Improve this crazy question
				if (isset($meta[0]) && !empty($meta[0]) && $meta[0]=="true")
					$user->enabled = (bool)$meta[0];
				
				$user->first_name = (isset($first_name[0]) && !empty($first_name[0]))? $first_name[0] : '';
				$user->last_name = isset($last_name[0]) && !empty($last_name[0])? $last_name[0] : '';
				
				$user_aux[] = $user;
			}
			
		}

		return $user_aux;
	}

	public function add_role_to_user($user_id, $role) {
		$user = new WP_User($user_id);

		$user->add_role($role);
	}

	
	function has_role($user_id,$role)
	{
		return user_can($user_id, $role);
	}

	function remove_user_from_role($user_id,$role)
	{
		$user = new WP_User($user_id);
		
		$user->remove_role($role);
	}
	
	/**
	 * This method set a user role and remove all others roles asociated to the user
	 * Take care when you use this method
	 * @param int $user_id
	 * @param string $role Role to assign if it is empty default wp role would be used
	 */
	function reset_roles($user_id, $role = '')
	{
		if(empty($role))
			$role = get_option("default_role");
		$user = new WP_User($user_id);
		$user->set_role($role);
	}

	function get_meta($user_id,$meta_key,$single=false)
	{
		return get_user_meta($user_id,$meta_key,$single);
	}

	function save_meta($user_id,$key,$value)
	{
//		$meta = $this->get_meta($user_id,$key);
//
//		if (!$meta)
//			$result = add_user_meta($user_id,$key,$value);
//		else
		$result = update_user_meta($user_id,$key,$value);

		return $result;
	}

	/**
	 * Add user
	 * @param string $user_name
	 * @param string $password
	 * @param string $user_email
	 * @return user ID
	 */
	function add_user($user_name,$password,$user_email)
	{
		$user_id = username_exists( $user_name );
		if ( !$user_id ) 
			return wp_create_user( $user_name, $password, $user_email );


		return null;

	}

	/**
	 * Insert/Update a user with all the information
	 * @param <type> $userdata 
	 */
	function insert_user($userdata)
	{
//		* The $userdata array can contain the following fields:
// * 'ID' - An integer that will be used for updating an existing user.
// * 'user_pass' - A string that contains the plain text password for the user.
// * 'user_login' - A string that contains the user's username for logging in.
// * 'user_nicename' - A string that contains a nicer looking name for the user.
// *		The default is the user's username.
// * 'user_url' - A string containing the user's URL for the user's web site.
// * 'user_email' - A string containing the user's email address.
// * 'display_name' - A string that will be shown on the site. Defaults to user's
// *		username. It is likely that you will want to change this, for both
// *		appearance and security through obscurity (that is if you don't use and
// *		delete the default 'admin' user).
// * 'nickname' - The user's nickname, defaults to the user's username.
// * 'first_name' - The user's first name.
// * 'last_name' - The user's last name.
// * 'description' - A string containing content about the user.
// * 'rich_editing' - A string for whether to enable the rich editor. False
// *		if not empty.
// * 'user_registered' - The date the user registered. Format is 'Y-m-d H:i:s'.
// * 'role' - A string used to set the user's role.
// * 'jabber' - User's Jabber account.
// * 'aim' - User's AOL IM account.
// * 'yim' - User's Yahoo IM account.

		return wp_insert_user($userdata);
		
	}

	function username_exists($user_name)
	{
		return username_exists( $user_name );
	}
	
	function email_exists( $email )
	{
		return email_exists( $email );
	}
	
	function update_user_info($userdata)
	{
		return wp_update_user( $userdata );
	}

	function get_user_info($user_id)
	{
		return get_userdata($user_id);
	}

	function delete_user($user_id)
	{
	    if ($this->change_posts_owner($user_id))
		return wp_delete_user($user_id);
	}
	
	function change_posts_owner($old_user_id)
	{
	    global $wpdb;
	    
	    $admin = $this->get_super_admin();
	    if ($admin){
		$query = $wpdb->prepare("UPDATE {$wpdb->posts} SET post_author={$admin->ID} WHERE post_author={$old_user_id} ;");
	    
		$wpdb->query($query);
		
		return true;
	    }
	    
	    return false;
	}

	// Get user meta SELECT user_id, meta_key, meta_value FROM wp_usermeta WHERE user_id IN (3)
}

?>