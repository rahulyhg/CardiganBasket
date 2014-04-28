<?php

class Maven_member_pages_model extends Maven_member_base_model {

	public function __construct() {
		parent::__construct();
	}

	public function get_page_templates()
	{
		$wp_templates = get_page_templates();
		$page_templates = $this->get_page_templates_roles();
		
		ksort( $wp_templates );
		$templates = array();

		foreach($wp_templates as $key=>$value)
		{
			$template = new stdClass();
			$template->name = $key;
			$template->id = str_replace(".php","",$value);
			$template->file_name = $value;
			$template->roles_keys = "";
			if (isset($page_templates[$template->id]))
				$template->roles_keys = $page_templates[$template->id];
			
			$templates[] = $template;
		}
		
		return $templates;
	}

	public function get_current_template_roles()
	{
		// Get the template name
		$id = get_queried_object_id();
		$template = get_post_meta($id, '_wp_page_template', true);
		$template = str_replace(".php","",$template);

		$templates = $this->get_page_templates_roles();

		if (isset($templates[$template]))
			return explode(",",$templates[$template]);

		return array();
	}


	private function get_page_templates_roles()
	{
		// Get option templates
		$templates = get_option("maven-templates-roles");

		if(!$templates)
			$templates = array();

		return $templates;
	}

	public function save_page_template_roles($template,$roles)
	{
		$templates = $this->get_page_templates_roles();
		
		$templates[$template] = $roles;
		
		$value = update_option("maven-templates-roles", $templates);

		return $value;
	}

}

?>