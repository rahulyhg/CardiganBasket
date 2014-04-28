<?php


	class Maven_member_blocker extends Maven_member_base {
		public $login_already_showed = false;
		public $login_already_showed_excerpt = false;
		
		public function __construct() {
			parent::__construct();

			add_action("init", array(&$this, "init"));
			
		}

		public function init() {
			add_shortcode('mvn-block', array(&$this,'my_shortcode_handler'));
			
			//add_action('wp_login_failed',array(&$this, "login_user_failed"));
			
			//add_action("login_form",array(&$this, "is_active_user"));
			
			if (!is_super_admin() || !current_user_can('manage_options')){
			    add_filter('login_redirect', array(&$this, "is_active_user"), 10, 3);
				add_filter('authenticate',array(&$this, "is_authentic_user"), 20, 3);
				add_action('dbx_post_advanced', array(&$this, "validate_edit_page") );

			    if (!is_admin ())
			    {
				    add_filter("the_content", array(&$this, "validate_content"));
				    add_filter("the_post", array(&$this, "validate_title"));
					add_filter("the_excerpt", array(&$this, "validate_excerpt"));
					
				    //$this->is_active_user();login_redirect
			    }
			}
			
			//TODO: Invest the best way to check the user permission
			//$this->add_filter ('user_has_cap', 'check_capabilities');

			
			
		}

		function my_shortcode_handler($atts, $content=null, $code="") {

                        $restrict = false;
                        
			if ($atts)
				extract($atts);

			// $atts    ::= array of attributes
			// $content ::= text within enclosing form of shortcode element
			// $code    ::= the shortcode found, when == callback name
			// examples: [my-shortcode]
			//           [my-shortcode/]
			//           [my-shortcode foo='bar']
			//           [my-shortcode foo='bar'/]
			//           [my-shortcode]content[/my-shortcode]
			//           [my-shortcode foo='bar']content[/my-shortcode]
                        
			if (isset($roles) ) {
				// Get a coma separated role
				$roles = explode(",", $roles);
//				$user = wp_get_current_user();
//				var_dump($user);
				foreach($roles as $role)
				{
					if (!is_super_admin() || !current_user_can('manage_options')){
						if (current_user_can($role))
							return do_shortcode ($content);
					}else{
						return do_shortcode ($content);
					}
				}
				
				$restrict = true;
			}
                        
                        if (isset($users) ) {
				// Get a coma separated user
				$users_id = explode(",", $users);
				$current_user = wp_get_current_user();
                                
				foreach($users_id as $user_id)
				{
					if (!is_super_admin() || !current_user_can('manage_options')){
						if ($user_id == $current_user->ID)
							return do_shortcode ($content);
					}else{
						return do_shortcode ($content);
					}
				}
				
				$restrict = true;
			}
                        
                        if($restrict)
                            return $this->get_setting("dialog-restricted");

			return do_shortcode ($content);
		}
 

		function is_active_user ($redirect_to, $url_redirect_to = '', $user = null)
		{

			// Check if the user is not loged in
			if ($user && isset($user->id))
			{

				if ($this->get_users_class()->is_user_enabled($user) )
				{

					$result->can_read = true;
					$result->redirect = 'continue';
					//add_filter( 'show_admin_bar', '__return_false' );
					if ( in_array( 'administrator', $user->roles ) )
					    return home_url( '/wp-admin/' );
					elseif(!empty ($redirect_to))
						return $redirect_to;
					else
					    return home_url();
				}
				else
				{
					$result->can_read = false;
					$result->redirect = 'activation';

					wp_logout();
					return $this->get_setting_class()->get_activation_url();
					 
				}
			}
 
		}
		
		function is_authentic_user($user, $username, $password)
		{
			if($_POST AND isset($_POST['mvn_login']) AND is_wp_error($user))
			{
				if(isset($_REQUEST['redirect_to']) AND ! empty($_REQUEST['redirect_to']))
					$redirect_to = $_REQUEST['redirect_to'];
				elseif(wp_get_referer())
					$redirect_to = wp_get_referer();
				else
					$redirect_to = home_url ();
				//set_transient('mvn_login_error', $user->get_error_message(), 5);
				set_transient('mvn_login_error', '<strong>ERROR:</strong> Invalid username or incorrect password.', 5);
				wp_safe_redirect($redirect_to);
			}
			return $user;
		}

		function check_user(){
			$result= new stdClass();
			$result->can_read = false;
			$result->redirect='';
			
			$category_maven_roles = array();

			if (!is_page ())
			{
				// Get all the categories the post has
				$categories =$this->get_categories_class()->get_post_categories();

				foreach($categories as $category)
				{
					//return $result;
					// Get the category meta, to see if there is a Maven role
					$maven_roles = $this->get_categories_class()->get_category_roles($category->term_id);

					if ($maven_roles && count($maven_roles)>0)
						$category_maven_roles = array_merge($category_maven_roles,$maven_roles);
				}
//				var_dump($category_maven_roles);
			}
			else
			{
				//TODO: Move it, to the page class
				$category_maven_roles = get_post_meta(get_the_ID(), $this->get_pages_class()->get_role_key(),true);
			}

			
			// Has maven roles?
			if ($category_maven_roles && count($category_maven_roles)>0)
			{
				// Check if the user is not loged in
				if ($this->get_users_class()->is_user_logged_in())
				{
					// Check if the user is active
					if ($this->get_users_class()->is_current_user_enabled())
					{

						$user_can = $this->get_users_class()->current_user_can($category_maven_roles);

						$result->can_read = $user_can;
						$result->redirect = 'login';

					}
					else
					{
						$result->can_read = false;
						$result->redirect = 'activation';

						if ($this->get_setting_class()->get_activation_type()=="message")
							$result->redirect = 'message';
					}

					return $result;
				}
				else
				{
					$result->can_read = false;
					$result->redirect = 'login';
					return $result;
				}
			}
			else
			{
				$result->can_read = true;
				return $result;
			}
			
		}

		function hide_comments( $file )
		{
		     //if ( is_page() {
			 $file = dirname( __FILE__ ) . '/empty-comments.php';
		     //}
		    return $file;
		}
		
		function validate_content($content) {
			return $this->control_validate($content, 'content');
		}
		
		function validate_excerpt($content)
		{
			return $this->control_validate($content, 'excerpt');
		}
		
		function validate_edit_page(){
			$post_id = get_the_ID();
			if(isset($post_id)){
				$category_maven_roles = array();
				
				$categories =$this->get_categories_class()->get_post_categories();
				
				if(isset($categories) && count($categories)>0){
					foreach($categories as $category)
					{
						
						// Get the category meta, to see if there is a Maven role
						$maven_roles = $this->get_categories_class()->get_category_roles($category->term_id);

						if ($maven_roles && count($maven_roles)>0)
							$category_maven_roles = array_merge($category_maven_roles,$maven_roles);
					}
				}else{
					$category_maven_roles = get_post_meta($post_id, $this->get_pages_class()->get_role_key(),true);
				}
				
				if ($category_maven_roles && count($category_maven_roles)>0)
				{
					// Check if the user is not loged in
					$user_can = $this->get_users_class()->current_user_can($category_maven_roles);
					if(!$user_can){
						wp_die( __('You are not allowed to edit this item.') );
					}
				}				
			}
		}
		
		function control_validate($content, $type = 'content')
		{
			$result = $this->check_user();
 
			
			if (!$result->can_read)
			{
				// If user can't read the content, so can't see comments either.
				add_filter('comments_template', array(&$this,'hide_comments'));
				
				switch($result->redirect)
				{
					case "login":
						//$new_content = '';//$this->get_setting("dialog-restricted");

						$new_content = $this->get_login_control($type);

						return $new_content;
						
//					case "activation":
//						$url = $this->get_setting_class()->get_activation_url();
//
//						//var_dump($url);
//						//wp_redirect($url);
//						break;
					case "message":
						
						$message = $this->get_setting_class()->get_activation_url();
						return $message;
						//var_dump($url);
						//wp_redirect($url);
						break;
					default:
						return $content;
				}
				
			}

			return $content;
		}


		function login_user_redirect() {

			wp_logout();
			wp_redirect($this->get_setting_class()->get_login_url(), 301);
		}
		
		function inactive_user_redirect() {
			
			wp_logout();
			wp_redirect($this->get_setting_class()->get_activation_url(), 301);
		}

		private function get_login_control($type = 'content')
		{
			$show_message = true;
			if($type == 'excerpt')
			{
				// if the login was showed in the same page, just show the restricted message
				if( ! $this->login_already_showed_excerpt)
				{
					$show_message = false;
					$this->login_already_showed_excerpt = true;
				}
			}else
			{
				if( ! $this->login_already_showed)
				{
					$show_message = false;
					$this->login_already_showed = true;
				}			
			}
			
			if($show_message)
				// if the login was showed in the same page, just show the restricted message
				return $this->get_setting_class()->get_restricted_message();
			else
				return $this->get_setting_class()->get_full_login_control();
		}
		

		function validate_title($post) {
			$result = $this->check_user();
 
			
			if (!$result->can_read && $this->get_setting("block-title")=="1")
			{
			//if (!$this->can_read_content() && $this->get_setting("block-title")=="1")
				$post->post_title = $this->get_setting("dialog-block-title");
			}
			return $post;
		}

		function check_template()
		{
			$roles = $this->get_pages_class()->get_current_template_roles();
			
			// Has maven roles?
			if ($roles && count($roles)>0)
			{
				// Check if the user is not loged in
				if ($this->get_users_class()->is_user_logged_in())
				{
					// Check if the user is active
					if ($this->get_users_class()->is_current_user_enabled())
					{
						$user_can = $this->get_users_class()->current_user_can($roles);

						if (!$user_can)
							$this->login_user_redirect();
					}
					else
						$this->inactive_user_redirect();
				}
				else
					$this->login_user_redirect();
			}
			 
		}

	}


	
	
?>