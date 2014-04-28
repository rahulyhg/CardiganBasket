<?php

class Maven_member_fields extends Maven_member_base {

    public function __construct() {
        parent::__construct();

		$this->load_model("fields");
		
        add_action("init", array(&$this, "init"));
    }

    public function init() {
        
    }
    
    /**
     * Load the role view
     */
    public function show_form() {
            $this->set_title("Fields");
			$fields = $this->fields_m->get_fields();
			$this->add_data("fields", $fields);

            $this->load_admin_view("fields");
    }
}
?>
