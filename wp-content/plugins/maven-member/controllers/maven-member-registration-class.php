<?php

class Maven_member_registration extends Maven_member_base {

    var $errors = null;
    var $fields = null;
    var $user_login = '';
    var $action_register = "register-new-user";

    public function __construct() {
        parent::__construct();

        $this->load_model("registration");

        add_action("init", array(&$this, "init"));
    }

    public function init() {
        $this->register_user();
    }

    /**
     * Load the role view
     */
    public function show_form() {
        $this->set_title(__("Registration Fields",maven_translation_key()));
        $this->add_data("fields", $this->registration_m->get_fields());

        $this->load_admin_view("fields");
    }

    public function ajax_update_fields_to_display() {
        $fields_to_display = $this->get_post_var("fields");
        $order_fields = $this->get_post_var("order_fields");
        $required_fields = $this->get_post_var("required_fields");

        $this->update_fields_to_display($fields_to_display, $required_fields);
        $this->update_fields_order($order_fields);

        $this->send_ajax_result(__("Fields updated",maven_translation_key()));
    }

    public function ajax_insert_field() {
        $name = $this->get_post_var("name");
        $display = $this->get_post_var("display");
        $required = $this->get_post_var("required");

        $result = $this->insert_field($name, $display, $required);

        $this->send_ajax_result($result);
    }

    public function insert_field($name, $display, $required) {
        return $this->registration_m->insert_field($name, $display, $required);
    }

    /**
     * Update fields to display
     */
    public function update_fields_to_display($fields_to_display, $required_fields=false) {

        // Get all fields
        $all_fields = $this->registration_m->get_fields();

        // get the fiels to display
        $fields_to_display = explode(",", $fields_to_display);

        if ($required_fields)
            $required_fields = explode(",", $required_fields);

        foreach ($all_fields as $field) {
            $field->display = false;
            $field->required = false;

            if (in_array($field->id, $fields_to_display))
                $field->display = true;


            if ($required_fields && in_array($field->id, $required_fields))
                $field->required = true;
        }

        $this->registration_m->update_fields($all_fields);
    }

    /**
     * Update fields to display
     */
    public function update_fields_order($fields) {

        // Get all fields
        $all_fields = $this->registration_m->get_fields();

        // get the fiels to display
        $fields = explode(",", $fields);

        foreach ($all_fields as $field) {
            foreach ($fields as $order_field) {
                $order = explode(";", $order_field);
                if ($order[0] == $field->id)
                    $field->order = $order[1];
            }
        }

        $this->registration_m->update_fields($all_fields);
    }

    public function get_fields_to_display() {
        $all_fields = $this->registration_m->get_fields();
        $fields = array();

        foreach ($all_fields as $field)
            if ($field->display)
                $fields[] = $field;

        return $fields;
    }

    public function get_front_form() {
        $fields = $this->fields ? $this->fields : $this->get_fields_to_display();

        $template_container = $this->get_setting_class()->get_registration_template_container();
        $template_field = $this->get_setting_class()->get_registration_template_field();
        $template_required = $this->get_setting_class()->get_registration_template_required();

        $generated_fields = "";
        foreach ($fields as $field) {
            $template_field_aux = $template_field;
            $template_field_aux = str_replace("{\$field_name}", $field->name, $template_field_aux);

            if ($field->required)
                $template_field_aux = str_replace("{\$required}", $template_required, $template_field_aux);
            $template_field_aux = str_replace("{\$required}", "", $template_field_aux);

            $control = "";
            $required = $field->required ? "class='validate[required]'" : "";

            if ($field->type == "text")
                $control = "<input type='input' $required name='{$field->id}' id='{$field->id}' value='{$field->value}' />";
            else
                $control = "<input type='password' $required name='{$field->id}' id='{$field->id}' value='{$field->value}' />";

            $template_field_aux = str_replace("{\$field_control}", $control, $template_field_aux);

            $generated_fields .= $template_field_aux;
        }

        $generated_fields = str_replace("{\$fields}", $generated_fields, $template_container);

        // Captcha
        $addon = new Maven_addons_core();
        $captcha = $addon->get_active_captcha();

	
        if ($this->get_setting_class()->is_captcha_enabled())
            $generated_fields = str_replace("{\$captcha}", $captcha->get_captcha(), $generated_fields);
        else
            $generated_fields = str_replace("{\$captcha}", "", $generated_fields);


        $this->add_data("fields", $generated_fields);
        $this->add_data("errors", $this->errors);
        $this->add_data("user_login", $this->user_login);








        return $this->get_front_view("registration");
    }

    public function ajax_remove_field() {
        $id = $this->get_post_var("field_id");
        $result = $this->remove_field($id);

        $this->send_ajax_result($result);
    }

    public function remove_field($id) {
        if ($id)
            return $this->registration_m->remove_field($id);

        return __("id is required",maven_translation_key());
    }

    public function ajax_reset_fields() {
        return $this->reset_fields();
    }

    public function reset_fields() {
        return $this->registration_m->reset_fields();
    }

    public function get_non_wp_fields() {
        return $this->registration_m->get_non_wp_fields();
    }

    private function validate_fields($fields) {
        foreach ($fields as $field)
            if ($field->required && !($this->has_value_post_var($field->id)))
                return array(__("Required fields",maven_translation_key()));

        return true;
    }

    public function register_user() {
        if ($this->is_post() && $this->exists_post_var("maven-member-registering")) {



            $fields = $this->get_fields_to_display();



            $non_wp_fields = array();

            $user_data = array();

            foreach ($fields as $field) {
                // Also fill the values, in case an error occurs
                $field->value = '';
                if ($this->exists_post_var($field->id)) {
                    $user_data[$field->id] = $this->get_post_var($field->id);
                    $field->value = $this->get_post_var($field->id);
                }

                // Save the non wp fields
                if (!$field->native)
                    $non_wp_fields[] = $field;
            }

            // Get default fields
            //$user_data["user_login"] = $this->get_post_var("user_login");
            //$user_data["user_pass"] = $this->get_post_var("user_pass");
            // Save fields in case an error occurs
            $this->fields = $fields;

            if (($result = $this->validate_fields($fields)) !== true)
                $this->errors = $result;
            else {
                // Captcha
                $addon = new Maven_addons_core();
                $captcha = $addon->get_active_captcha();

                if ($this->get_setting_class()->is_captcha_enabled() && $captcha->validate() !== true) {

                    $this->errors = array($captcha->get_error_description());
                    return;
                }

                //Insert a new user
                $user = $this->get_users_class()->register_user($user_data);

                if (!isset($user->errors)) {


                    // Save the non wp field to the user
                    $this->get_users_class()->save_registration_fields($user, $non_wp_fields);

                    // Add the default user
                    $default_role = $this->get_setting_class()->get_default_registration_role();
                    if ($default_role)
                        $this->get_users_class()->add_role_to_user($user, $default_role);

                    //TODO: send email to admin
                    wp_new_user_notification($user);

                    wp_redirect($this->get_setting_class()->get_successul_registration_url());

                    die();
                }
                else {
                    $this->errors = $user->get_error_messages();
                }
            }
        }



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
    }

    function wp_new_user_notification($user_id, $plaintext_pass = '') {
        $user = new WP_User($user_id);

        $user_login = stripslashes($user->user_login);
        $user_email = stripslashes($user->user_email);

        // The blogname option is escaped with esc_html on the way into the database in sanitize_option
        // we want to reverse this for the plain text arena of emails.
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $message = sprintf(__('New user registration on your site %s:',maven_translation_key()), $blogname) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s',maven_translation_key()), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('E-mail: %s',maven_translation_key()), $user_email) . "\r\n";

        @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration',maven_translation_key()), $blogname), $message);
    }
	
	function wp_user_activated_notification($user_id) {
        if($user_id AND $this->get_setting('send-activation-email-default'))
		{
			$user = new WP_User($user_id);

			$user_login = stripslashes($user->user_login);
			$user_email = stripslashes($user->user_email);

			// The blogname option is escaped with esc_html on the way into the database in sanitize_option
			// we want to reverse this for the plain text arena of emails.
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

			$message = $this->get_setting("email-activation-template");
			$message = str_replace(array('{user_name}','{blog_name}'), array($user_login,$blogname), $message);

			@wp_mail($user_email, sprintf(__('[%s] User Activated',maven_translation_key()), $blogname), $message);
		}
    }

}

?>