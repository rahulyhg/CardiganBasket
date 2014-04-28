<?php

class Maven_member_settings_model extends Maven_member_base_model {

	public function __construct() {
		parent::__construct();
	}

	public function get_setting($setting)
	{
		$option = get_option($setting);

		if ($option!==false)
			return html_entity_decode($option);

		return false;
	}

	/**
	 * Check if the setting already exists
	 * @param string $setting
	 * @return bool
	 */
	public function exists_setting($setting)
	{
		
		return $this->get_setting($setting)!==false;
	}

	/**
	 * Add or update a setting
	 * @param string $setting
	 * @param string $value
	 */
	public function save_setting($setting,$value)
	{
		$value = htmlentities(stripslashes($value));
		$result = false;
		
		if ($this->exists_setting($setting))
		{
			$result = update_option ($setting, $value);
		}
		else
		{
			$result = add_option ($setting,$value);
		}

		return $result;
	}

}

?>