<?php

class Maven_member_fields_model extends Maven_member_base_model {

	private $maven_fields_key = "maven_members_fields";

	private $maven_default_fields;

	public function __construct() {
		parent::__construct();

		$this->maven_default_fields = array(
			//     order,   label(localized),      				optionname,   type, display, required, native, checked value, checked by default
			array ( 1,  __('First Name', 'wp-members'),         'first_name', 'text',     'y', 'y', 'y' ),
			array ( 2,  __('Last Name', 'wp-members'),          'last_name',  'text',     'y', 'y', 'y' ),
			array ( 3,  __('Address 1', 'wp-members'),          'addr1',      'text',     'y', 'y', 'n' ),
			array ( 4,  __('Address 2', 'wp-members'),          'addr2',      'text',     'y', 'n', 'n' ),
			array ( 5,  __('City', 'wp-members'),               'city',       'text',     'y', 'y', 'n' ),
			array ( 6,  __('State', 'wp-members'),              'thestate',   'text',     'y', 'y', 'n' ),
			array ( 7,  __('Zip', 'wp-members'),                'zip',        'text',     'y', 'y', 'n' ),
			array ( 8,  __('Country', 'wp-members'),            'country',    'text',     'y', 'y', 'n' ),
			array ( 9,  __('Day Phone', 'wp-members'),          'phone1',     'text',     'y', 'y', 'n' ),
			array ( 10, __('Email', 'wp-members'),              'user_email', 'text',     'y', 'y', 'y' ),

		);
	}

	public function get_fields()
	{

		//update_option('mavenmembers_fields',$maven_fields,'','yes'); // using update_option to allow for forced update
		$fields = array();
		
		//$option = get_option($this->maven_fields_key);

		foreach($this->maven_default_fields as $option)
		{
			$field = new stdClass();
			$field->order = $option[0];
			$field->name = $option[1];
			$field->id = $option[2];

			$fields[] = $field;
		}

			
		if ($option===false)		
		{
			//Transform options into objects

			
			
		}
		return $fields;
	}

	

}

?>
