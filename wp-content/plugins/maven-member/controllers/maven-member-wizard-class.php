<?php

class Maven_member_wizard extends Maven_member_base {

	public function __construct() {
		parent::__construct();

		add_action('init', array(&$this, 'init'));
	}

	public function init()
	{
		
	}


	public function show_form() {
		$this->data["title"] = __("Wizard!",maven_translation_key());
		$this->data["categories"] = $this->get_categories_class()->get_parents();
		$this->data["users"] = $this->get_users_class()->get_users(true);
		$this->add_new_button(false);
		$this->load_admin_view("wizard");
	}

}

?>