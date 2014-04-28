<?php

class Maven_member_dashboard extends Maven_member_base {

	public function __construct() {
		parent::__construct();
	}


	public function show_form() {

		//TODO: Validate it, if it is enough
		$this->user_can();

		$this->set_title(__("Maven Member Dashboard",maven_translation_key()));
		$this->add_new_button(false);

		$registration = $this->get_setting_class()->get_successul_registration_url();
		$registration = $registration?$registration :false;
		$this->add_data("registration",$registration);
                
                $registration_enabled = $this->get_setting_class()->is_registration_enabled();
                $this->add_data("registration_enabled",$registration_enabled);

		$auto_logout_enabled = $this->get_setting_class()->is_auto_logout_enabled();
		$auto_logout_enabled = $auto_logout_enabled?$auto_logout_enabled :false;
		$this->add_data("auto_logout_enabled",$auto_logout_enabled);

		$auto_logout_limit = $this->get_setting_class()->get_auto_logout_limit();
		$auto_logout_limit = $auto_logout_limit?$auto_logout_limit :__("Not setted",maven_translation_key());
		$this->add_data("auto_logout_limit",$auto_logout_limit);
                $this->add_data("thanks_message","display: none;");

                if ($this->get_post_var("maven-message"))
                {
                    $message = $this->get_post_var("maven-message");
                    $message.= "<br/>".$this->get_post_var("maven-email");
                    
                    @wp_mail('mavenmember@gmail.com', __('Maven Member Feedback',maven_translation_key()), $message);
                    $this->add_data("thanks_message","");
                }
                
                
		$this->load_admin_view("dashboard");

		
	}

        
        
	public function show_help() {

		$this->set_title(__("Maven Member FAQs",maven_translation_key()));
		$this->add_new_button(false);
		$this->load_admin_view("help");
	}



//		// Write our custom html
//		echo '<div class="icon32 icon32-posts-post" id="icon-edit"><br></div>';
//		echo '<h2> Maven Member</h2>';
//		echo '<div class="wrap">';
//		echo '<div class="postbox-container">';
//		echo '<div class="metabox-holder">';
//		//echo  bloginfo('rss2_url');
//		include_once(ABSPATH . WPINC . '/feed.php');
//
//		$xml = fetch_feed('http://wordpress.org/news/feed');
//		$content = '';
//		$rss_items = null;
//
//		if (!is_wp_error( $xml ) ) // Checks that the object is created correctly
//		{
//			// Figure out how many total items there are, but limit it to 5.
//			$maxitems = $xml->get_item_quantity(5);
//
//			// Build an array of all the items, starting with element 0 (first element).
//			$rss_items = $xml->get_items(0, $maxitems);
//		}
//
//		if ($rss_items){
//			foreach ( $rss_items as $item )
//				$content.="<li>{$item->get_title()}</li>";
//		}
//		else
//			$content = "No news items, feed might be broken...";
//
//		$this->box("welcome","Welcome",'<p>Welcome to Maven Members, a plugin that allows flexible control over protected areas of your website.<br/> Setup users and protected areas, customize messaging, and more. Be sure to check out the tutorial and support forums (coming soon!)</p>');
//
//		$this->box("news","News","<p><ul>$content</ul></p>");
//		echo '</div>';
//		echo '</div>';
//		echo '</div>';

	


		

}

?>