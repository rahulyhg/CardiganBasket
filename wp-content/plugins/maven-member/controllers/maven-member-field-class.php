<?php

class Maven_member_field extends Maven_member_base {

	public function __construct() {
		parent::__construct();
	}

	private function get_fields() {
		$fields = array();

		// Get the existing member fields
		$fields_aux = get_option($this->get_fields_key());

		for ($row = 0; $row < count($fields_aux); $row++) {

			$field = new stdClass();
			$field->id = $fields_aux[$row][0];
			$field->label = $fields_aux[$row][1];
			$field->optionname = $fields_aux[$row][2];
			$field->type = $fields_aux[$row][3];
			$field->display = $fields_aux[$row][4];
			$field->required = $fields_aux[$row][5];
			$field->native = $fields_aux[$row][6];
			$field->checked_value = $fields_aux[$row][7];
			$field->checked_by_default = $fields_aux[$row][8];

			$fields[] = $field;
		}

		return $fields;
	}

	public function show_form() {

		$this->data["title"] = __("This is the title",maven_translation_key());
		$this->data["fields"] = $this->get_fields();

		$this->load_admin_view("fields");
	}

}

?>