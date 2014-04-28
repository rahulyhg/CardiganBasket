<?php


class Maven_member_import extends Maven_member_base {

	public function __construct() {
		parent::__construct();

	}

	public function remove_users()
	{
		$users = $this->get_users_class()->get_users();

		$row = 0;
		foreach($users as $user)
		{
			$meta = $this->get_users_class()->get_meta($user->ID,"import");

			if ($meta)
			{
				$this->get_users_class()->delete_user($user->ID);
				$row++;
			}
		}
		$this->send_ajax_result(array("count"=>$row));
	}

	public function import_users($file_url =null,$roles_aux = null)
	{
		
		$file = $this->get_post_var("file");
		$roles = $this->get_post_var("roles");
		
		if($this->get_post_var("default_active")==1){
			$active = true;
		}else{
			$active = false;
		}
		if ($file_url)
			$file = $file_url;

		if ($roles_aux)
		{
			$roles = $roles_aux;

		}

		if ($roles)
			$roles = explode(",",$roles);
		
		$row = 1;
		$count = 0;
		$notAdded = array();
		$error ='';
		//TODO: Validate if it is a csv file and if it has the needed structure
		if ($file)
		{
			
			//fname	lname	userType	userid	email
			if ((@$handle = fopen($file, "r")) !== FALSE) {
				
				while ((@$data = fgetcsv($handle, 0, "|")) !== FALSE) {
					//$num = count($data);
					// This is because the first line is the hedar
					if(is_array($data) && (count($data)==3 || count($data)==5)){
						if ($row>1)
						{
							//var_dump($data);echo '<br/><br/><br/>';
							$fname = trim($data[1]);
							$lname = trim($data[0]);
							$email = trim($data[2]);
							
							if(count($data)==5){
								$userid = trim($data[3]);
								$password = trim($data[4]);
							}else{
								$userid = substr($fname, 0,1).$lname;
								$password = $userid;
							}
							//$userid = trim($data[3]);

							if ($email)
							{

								// Add a new WP user
								$wp_user_id = $this->get_users_class()->add_user($userid,$password,$email);
								
								if ($wp_user_id && (!isset($wp_user_id->errors)))
								{
									// Get the user info
									$wp_user = $this->get_users_class()->get_user_info($wp_user_id);

									$wp_user->first_name = $fname;
									$wp_user->last_name = $lname;

									$user_info = $this->get_users_class()->update_user_info(array("ID"=>$wp_user_id,"first_name"=>$wp_user->first_name,"last_name"=>$wp_user->last_name));

									$this->get_users_class()->save_meta($wp_user_id,"enabled",$active);

									$this->get_users_class()->save_meta($wp_user_id,"import",true);

									if ($roles)
									{	
										foreach($roles as $role)
											$this->get_users_class()->add_role_to_user($wp_user_id, $role);
									}
									$count++;
								}else{
									$notAdded[] = $row;
								}

							}
						}
					}else{
						$error='The file can´t be readed. Check the CSV format.';
					}
					$row++;
				}
				if($row==0){
					$error='The file can´t be readed. Check the CSV format.';
				}
			}else{
				$error='The file is not found. Check if file are uploaded in the upload pop up, "media library" tab';
			}
		}else{
			$error="You must choose a CSV file.";
		}
			

			$this->send_ajax_result(array("count"=>$count,"file"=>$file, "notAdded" => $notAdded, "error"=>$error));
		
	}

	public function show_form() {
		$this->data["title"] = __("Import",maven_translation_key());
		$this->data["roles"] = $this->get_roles_class()->get_roles();

		$this->add_new_button(false);
		$this->load_admin_view("import");
	}


}


?>