<?php

class Maven_member_registration_model extends Maven_member_base_model {

	private $maven_fields_key = "maven_members_fields";

	private $maven_default_fields;

	public function __construct() {
		parent::__construct();

		$this->maven_default_fields = array(
			//     order,   label(localized),      				optionname,   type,      native, display,can_be_modify,required
			array ( 0, __('Username',maven_translation_key()),               'user_login', 'text',      true,true, false,true),
			array ( 1, __('Password',maven_translation_key()),            'user_pass',  'password',      true,true, false,true ),
			array ( 2, __('Email',maven_translation_key()),               'user_email', 'text',      true,true, false,true),
			array ( 3,  __('First Name',maven_translation_key()),         'first_name', 'text',     true,true, true,false ),
			array ( 4,  __('Last Name',maven_translation_key()),          'last_name',  'text',     true,true, true,false),
			array ( 5,  __('Address 1',maven_translation_key()),          'addr1',      'text',     false,true, true,false),
			array ( 6,  __('Address 2',maven_translation_key()),          'addr2',      'text',     false,true, true,false),
			array ( 7,  __('City',maven_translation_key()),               'city',       'text',     false,true, true,false),
			array ( 8,  __('State',maven_translation_key()),              'thestate',   'text',     false,true, true,false),
			array ( 9,  __('Zip',maven_translation_key()),                'zip',        'text',     false,true, true,false),
			array ( 10,  __('Country',maven_translation_key()),            'country',    'text',     false,true, true,false),
			array ( 11,  __('Day Phone',maven_translation_key()),          'phone1',     'text',     false,true, true,false),
		   array ( 12,  __('Website',maven_translation_key()),          'website',     'text',     false,true, true,false)
                    
			
		);
	}

	public function get_fields()
	{

		$fields = array();
		
		$maven_fields = get_option($this->maven_fields_key);

		$maven_fields = count($maven_fields)>1?$maven_fields:$this->maven_default_fields;

		foreach($maven_fields as $option)
		{
			$field = new stdClass();
			$field->order = $option[0];
			$field->name = __($option[1],maven_translation_key());
			$field->id = $option[2];
			$field->native= $option[4];
			$field->display= $option[5];
			$field->can_be_modify= $option[6];
			$field->value = '';
			$field->type = $option[3];
                        $field->required = $option[7];
			$fields[] = $field;
		}
		
                //$fields = $this->compatibility_add_missing_fields($fields);
                
                usort($fields, array(&$this,"comparison"));
                
		return $fields;
	}
        
        function comparison($a, $b)
        {
            if ($a->order == $b->order) {
                return 0;
            }
            return ($a->order < $b->order) ? -1 : 1;
        }


        
        private function compatibility_add_missing_fields($fields)
        {
            $found = false;
            foreach($fields as $field)
            {
                if ($field->id=="user_login")
                {
                    $found = true;
                    break;
                }
                    
            }
            
            if (!$found)
            {
                    $field = new stdClass();
                    $field->order = 0;
                    $field->name = "Login";
                    $field->id = "user_login";
                    $field->native= true;
                    $field->display= true;
                    $field->can_be_modify= false;
                    $field->value = '';
                    $field->type = "text";
                    $field->required = true;
                    $field->custom_name = '';
                    $fields[] = $field;
                    
                    
                    $field = new stdClass();
                    $field->order = 0;
                    $field->name = "Password";
                    $field->id = "user_pass";
                    $field->native= true;
                    $field->display= true;
                    $field->can_be_modify= false;
                    $field->value = '';
                    $field->type = "password";
                    $field->custom_name = '';
                    $field->required = true;
                    $fields[] = $field;
            }
            
            return $fields;
        }

        private function compatibility($field)
        {
            $default_required = array("user_login","user_pass","user_email");
            
            // 1.0.4 compatibility
            if (isset($option[7]))
                return $option[7];
            else
            {
                if (in_array($field->id,$default_required))
                    return true;
                else
                    return false;
            }
            
            return false;
        }

	public function get_non_wp_fields()
	{

		$fields = array();

		$maven_fields = $this->get_fields();

		foreach($maven_fields as $field)
		{
			if (!$field->native)
				$fields[] = $field;
		}


		return $fields;
	}

	public function update_fields($fields)
	{
		//update_option('mavenmembers_fields',$maven_fields,'','yes'); // using update_option to allow for forced update

		$maven_fields = array();

		foreach($fields as $field)
		{
			$field_arr = array();
			$field_arr[0] = $field->order;
			$field_arr[1] = $field->name;
			$field_arr[2] = $field->id;
			$field_arr[3] = $field->type;
			$field_arr[4] = $field->native;
			$field_arr[5] = $field->display;
			$field_arr[6] = $field->can_be_modify;
                        $field_arr[7] = $field->required;

			$maven_fields[] = $field_arr;
		}
		
		$result = update_option($this->maven_fields_key,$maven_fields); // using update_option to allow for forced update

		return $result;
	}

	public function remove_field($id)
	{
		// Get all fields and add the new one to the end
		$all_fields = $this->get_fields();
		$i = 0;
		foreach($all_fields  as $field)
		{
			if ($field->id == $id)
				unset($all_fields[$i]);
			$i++;
		}

		return $this->update_fields($all_fields);
	}


	public function insert_field($name,$display,$required)
	{
		// Get all fields and add the new one to the end
		$all_fields = $this->get_fields();

		$field = new stdClass();
		$field->order = 99999;
		$field->name = $name;
		$field->id = sanitize_title($name);
		$field->native= false;
		$field->display= $display;
		$field->can_be_modify= true;
		$field->value = '';
		$field->type = "text";
                $field->required = $required;

		$all_fields[] = $field;

		// Update the fields
		$this->update_fields($all_fields);
		
		return $field;
			
		
	}

	public function reset_fields()
	{
		return update_option($this->maven_fields_key,$this->maven_default_fields);
	}


}

?>