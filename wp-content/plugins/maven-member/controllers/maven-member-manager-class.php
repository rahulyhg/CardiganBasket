<?php

if (!class_exists('Maven_member_manager')) {

	class Maven_member_manager extends Maven_member_base {

		var $fields_class;
		var $roles_class;
		var $users_class;
		var $blocker_class;
		var $categories_class;
		var $settings_class;
		var $pages_class;
		var $auto_logout_class;
		var $short_codes_class;
		var $wizard_class;
                var $addons_class;
		var $plugin_url = "";
                
	
		public function __construct() {

			parent::__construct();

			$this->registration_class = new Maven_member_registration();
			$this->roles_class = new Maven_member_roles();
			$this->users_class = new Maven_member_users();
			$this->blocker_class = new Maven_member_blocker();
			$this->categories_class = new Maven_member_categories();
			$this->settings_class = new Maven_member_settings();
			$this->import_class = new Maven_member_import();
			$this->pages_class = new Maven_member_pages();
			$this->auto_logout_class = new Maven_member_auto_logout();
			$this->short_codes_class = new Maven_member_short_codes();
			$this->wizard_class = new Maven_member_wizard();
			$this->dashbaord_class = new Maven_member_dashboard();
                        $this->addons_class = new Maven_addons_core();


			add_action('init', array(&$this, 'init'));
		}


		/**
		 * Add the javascript file to our wordpress page
		 */
		function add_scripts() {
			
			if (is_admin() && $this->is_my_plugin()) {

				$ver = WBM_MEMBER_VERSION;

				wp_enqueue_script('maven_admin', $this->get_js_url('maven-member-admin'), array('jquery'),$ver);

				wp_localize_script('maven_admin', 'mavenConfig', array( 'siteurl' => $this->get_site_url(),"host"=>$this->get_host(),"root"=>$this->get_root_path()),$ver);
	
				//wp_enqueue_script('maven_jeditable', $this->get_js_url('jquery.jeditable.mini'), array('jquery'));
				wp_enqueue_script('maven_admin_impromptu', $this->get_js_url('jquery-impromptu.3.1.min'), array('maven_admin'),$ver);
//				wp_enqueue_script('maven_admin_effects.core', $this->get_js_url('jquery.effects.core.min'), array('maven_admin_impromptu'));
//				wp_enqueue_script('maven_admin_effects.highlight', $this->get_js_url('jquery.effects.highlight.min'), array('maven_admin_effects.core'));

				if ($this->is_page("roles"))
					wp_enqueue_script('maven_admin_roles', $this->get_js_url('admin/maven-member-roles'), array('maven_admin_impromptu'),$ver);

				if ($this->is_page("users"))
					wp_enqueue_script('maven_admin_users', $this->get_js_url('admin/maven-member-users'), array('maven_admin_impromptu'),$ver);

				if ($this->is_page("categories"))
					wp_enqueue_script('maven_admin_categories', $this->get_js_url('admin/maven-member-categories'), array('maven_admin_impromptu'),$ver);

				if ($this->is_page("registration"))
					wp_enqueue_script('maven_admin_registration', $this->get_js_url('admin/maven-member-registration'), array('maven_admin_impromptu',"jquery-ui-sortable"),$ver);

				if ($this->is_page("templates"))
					wp_enqueue_script('maven_admin_templates', $this->get_js_url('admin/maven-member-templates'), array('maven_admin_impromptu'),$ver);

				if ($this->is_page("import"))
				{
					wp_enqueue_script('media-upload');
					wp_enqueue_script('thickbox');
					wp_enqueue_script('maven_admin_import', $this->get_js_url('admin/maven-member-import'), array('jquery','maven_admin_impromptu','media-upload','thickbox'),$ver);
				}

				if ($this->is_page("wizard"))
					wp_enqueue_script('maven_admin_wizard', $this->get_js_url('admin/maven-member-wizard'), array('maven_admin_impromptu'),$ver);

				
				if ($this->is_page("settings"))
				{
					wp_enqueue_script( 'jquery-ui-core' );
					wp_enqueue_script( 'jquery-ui-tabs' );
					wp_enqueue_script('maven_admin_settings', $this->get_js_url('admin/maven-member-settings'), array('jquery-ui-tabs'),$ver);
				}

			}
                        
                        
		}

		/**
		 * Add the styles file to our wordpress page
		 */
		function add_styles() {
			if (is_admin() && $this->is_my_plugin()) {
				wp_enqueue_style('maven_admin-css', $this->get_css_url('admin'));
				wp_enqueue_style('maven_admin-impromptu', $this->get_css_url('impromptu'));
				wp_enqueue_style('tabs', $this->get_css_url('tabs'));
				wp_enqueue_style('thickbox');
			}
			else if (is_admin())
			{
				wp_enqueue_style('maven_wp_admin-css', $this->get_css_url('wp-maven'));
			}
                       
		}

		function init() {
			
			// Add admin menu
			add_action('admin_menu', array(&$this, 'admin_menu'));
			
			if (is_super_admin() || current_user_can('manage_options'))
			    add_action('admin_bar_menu', array(&$this, 'admin_bar_menu'));

			add_action('admin_print_styles', array(&$this, 'add_styles'));
			add_action('admin_enqueue_scripts', array(&$this, 'add_scripts'));

			wp_enqueue_style('maven_validation-css', $this->get_css_url('validation/css/validationEngine.jquery'),array(),WBM_MEMBER_VERSION);
			wp_enqueue_style('maven_validation-template-css', $this->get_css_url('validation/css/template'),array("maven_validation-css"),WBM_MEMBER_VERSION);

			wp_enqueue_script('maven_validation_engine_lang', $this->get_js_url('validation/languages/jquery.validationEngine-en'), array('jquery'),WBM_MEMBER_VERSION);
			wp_enqueue_script('maven_validation_engine', $this->get_js_url('validation/jquery.validationEngine'), array('maven_validation_engine_lang'),WBM_MEMBER_VERSION);
			wp_enqueue_script('maven_validation', $this->get_js_url('validation/maven-validation-general'), array('maven_validation_engine'),WBM_MEMBER_VERSION);
                        
                        
			if (is_admin() ) {
				add_action('wp_ajax_maven_roles_add', array($this->roles_class, 'ajax_add_role'));
				add_action('wp_ajax_maven_roles_update', array($this->roles_class, 'ajax_update_role'));
				add_action('wp_ajax_maven_roles_remove', array($this->roles_class, 'ajax_remove_role'));
				add_action('wp_ajax_maven_roles_get_users_by_role', array($this->roles_class, 'ajax_get_users_by_role'));
				add_action('wp_ajax_maven_roles_get_all', array($this->roles_class, 'ajax_get_roles'));
				add_action('wp_ajax_maven_roles_get_roles_by_user', array($this->roles_class, 'ajax_get_roles_by_user'));
																							  
				add_action('wp_ajax_maven_users_add_role_to_user', array($this->users_class, 'ajax_add_roles_to_user'));
//				add_action('wp_ajax_maven_users_get_roles', array($this->users_class, 'ajax_get_roles'));
				add_action('wp_ajax_maven_users_get_all', array($this->users_class, 'ajax_get_users'));
				add_action('wp_ajax_maven_users_reset_roles', array($this->users_class, 'ajax_reset_roles'));
				add_action('wp_ajax_maven_users_enable_user', array($this->users_class, 'ajax_enable_user'));
				add_action('wp_ajax_maven_users_save_user', array($this->users_class, 'ajax_save_user'));
				add_action('wp_ajax_maven_users_delete_user', array($this->users_class, 'ajax_delete_user'));
				add_action('wp_ajax_maven_users_add', array($this->users_class, 'ajax_add_user'));

				add_action('wp_ajax_maven_pages_save_template_roles', array($this->pages_class, 'ajax_save_page_template_roles'));

				add_action('wp_ajax_maven_setting_save', array($this->settings_class, 'ajax_save_setting'));
				add_action('wp_ajax_maven_setting_save_captchas', array($this->settings_class, 'save_captchas'));
				add_action('wp_ajax_maven_setting_reset', array($this->settings_class, 'ajax_reset_settings'));
				
				add_action('wp_ajax_maven_category_get_roles', array($this->categories_class, 'ajax_get_category_roles'));
				add_action('wp_ajax_maven_categories_add_roles', array($this->categories_class, 'ajax_add_roles'));
				add_action('wp_ajax_maven_categories_add', array($this->categories_class, 'ajax_add_category'));
				add_action('wp_ajax_maven_categories_delete', array($this->categories_class, 'ajax_delete_category'));
				add_action('wp_ajax_maven_categories_reset_roles', array($this->categories_class, 'ajax_reset_roles'));
				add_action('wp_ajax_maven_categories_update', array($this->categories_class, 'ajax_update_category'));
				
				add_action('wp_ajax_maven_import_import_users', array($this->import_class, 'import_users'));
				add_action('wp_ajax_maven_import_remove_users', array($this->import_class, 'remove_users'));

				add_action('wp_ajax_maven_registration_update_fields_to_display', array($this->registration_class, 'ajax_update_fields_to_display'));
				add_action('wp_ajax_maven_registration_insert_field', array($this->registration_class, 'ajax_insert_field'));
				add_action('wp_ajax_maven_registration_remove_field', array($this->registration_class, 'ajax_remove_field'));
                                add_action('wp_ajax_maven_registration_reset_fields', array($this->registration_class, 'ajax_reset_fields'));
                                
			}
		}

		/**
		 * Register the plugin options
		 */
		public static function install() {

			
			$mi = new Maven_Install();
			$mi->activate();
		}

		function admin_menu() {

			add_menu_page('Maven Member', 'Maven Member', 'manage_options', parent::PLUGIN_KEY . '-section', array(&$this->dashbaord_class, 'show_form'), $this->get_plugin_url() . "images/logo.png");
			add_submenu_page(parent::PLUGIN_KEY . '-section', __('Wizard',maven_translation_key()), __('Wizard',maven_translation_key()), 'manage_options', parent::PLUGIN_KEY . '-section-wizard', array(&$this->wizard_class, 'show_form'));
			add_submenu_page(parent::PLUGIN_KEY . '-section', __('Roles',maven_translation_key()), __('Roles',maven_translation_key()), 'manage_options', parent::PLUGIN_KEY . '-section-groups', array(&$this->roles_class, 'show_form'));
			add_submenu_page(parent::PLUGIN_KEY . '-section', __('Users',maven_translation_key()), __('Users',maven_translation_key()), 'manage_options', parent::PLUGIN_KEY . '-section-users', array(&$this->users_class, 'show_form'));
			add_submenu_page(parent::PLUGIN_KEY . '-section', __('Categories',maven_translation_key()), __('Categories',maven_translation_key()), 'manage_options', parent::PLUGIN_KEY . '-section-categories', array(&$this->categories_class, 'show_form'));
			//add_submenu_page(parent::PLUGIN_KEY . '-section', 'Templates', 'Templates', 'manage_options', parent::PLUGIN_KEY . '-section-templates', array(&$this->pages_class, 'show_templates'));
			add_submenu_page(parent::PLUGIN_KEY . '-section', __('Import',maven_translation_key()), __('Import',maven_translation_key()), 'manage_options', parent::PLUGIN_KEY . '-section-import', array(&$this->import_class, 'show_form'));
			add_submenu_page(parent::PLUGIN_KEY . '-section', __('Registration Fields',maven_translation_key()), __('Registration Fields',maven_translation_key()), 'manage_options', parent::PLUGIN_KEY . '-section-registration', array(&$this->registration_class, 'show_form'));
			add_submenu_page(parent::PLUGIN_KEY . '-section', __('Settings',maven_translation_key()), __('Settings',maven_translation_key()), 'manage_options', parent::PLUGIN_KEY . '-section-settings', array(&$this->settings_class, 'show_form'));
			add_submenu_page(parent::PLUGIN_KEY . '-section', __('Help',maven_translation_key()), __('Help',maven_translation_key()), 'manage_options', parent::PLUGIN_KEY . '-section-help', array(&$this->dashbaord_class, 'show_help'));
                        
                        //add_submenu_page(parent::PLUGIN_KEY . '-section', 'Test', 'Test', 'manage_options', parent::PLUGIN_KEY . '-section-test', array(&$this, 'show_test'));
 

			global $submenu;
			if ( isset($submenu[parent::PLUGIN_KEY . '-section']) )
				$submenu[parent::PLUGIN_KEY . '-section'][0][0] = __('Dashboard');
			
			
			
		}
		
		function admin_bar_menu() {

			global $wp_admin_bar;
			$wp_admin_bar->add_menu(
				array(	'id' => 'maven-member-menu',
						'title' => __( 'Maven Member' ),
						'href' => get_admin_url(null, 'admin.php?page=maven_member-section')
				)
			);
			
			$wp_admin_bar->add_menu(
				array(	'parent' =>'maven-member-menu',
						'id' => 'maven-member-users',
						'title' => __( 'Users' ),
						'href' => get_admin_url(null, 'admin.php?page=maven_member-section-users')
				)
			);

			$wp_admin_bar->add_menu(
				array(	'parent' =>'maven-member-menu',
						'id' => 'maven-member-categories',
						'title' => __( 'Categories' ),
						'href' => get_admin_url(null, 'admin.php?page=maven_member-section-categories')
				)
			);
			
			$wp_admin_bar->add_menu(
				array(	'parent' =>'maven-member-menu',
						'id' => 'maven-member-registration-fields',
						'title' => __( 'Registration Fields' ),
						'href' => get_admin_url(null, 'admin.php?page=maven_member-section-registration')
				)
			);
			
			$wp_admin_bar->add_menu(
				array(	'parent' =>'maven-member-menu',
						'id' => 'maven-member-settings',
						'title' => __( 'Settings' ),
						'href' => get_admin_url(null, 'admin.php?page=maven_member-section-settings')
				)
			);
			
			$wp_admin_bar->add_menu(
				array(	'parent' =>'maven-member-menu',
						'id' => 'maven-member-import',
						'title' => __( 'Import' ),
						'href' => get_admin_url(null, 'admin.php?page=maven_member-section-import')
				)
			);
		}
                
                function show_test()
                {
                    $addon = new Maven_addons_core();
                    $captcha = $addon->get_active_captcha();
                    $this->add_data("captcha_error","");
                           
                    if ($this->is_post())
                    {
                        if ($captcha->validate() !==true){
                            
                            $this->add_data("captcha_error",$captcha->get_error_description());
                            $this->add_data("captcha",$captcha->get_captcha() );
                        }
                        else {
                            $this->add_data("captcha","Ok!!! ");
                        }
                    }
                    else
                        $this->add_data("captcha",$captcha->get_captcha());
                    
                    
                    $this->set_title(__("Maven Member test"));
                    $this->add_new_button(false);
                     
                    $this->load_admin_view("test");
                }

		
	}

	global $maven_manager;
	$maven_manager = new Maven_member_manager();
	
}
?>