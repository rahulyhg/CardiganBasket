<?php
/*
Plugin Name: Maven Member
Plugin URI:  
Description: This plugin gives you the ability to create roles to protect pages, and posts under categories. It also let you manage user registration, in a very easy way. 
Version:     1.0.35
Author:      Emiliano Jankowski,Guillermo Tenaschuk,Juan Pablo Baena
License:     
*/

define( 'WBM_MEMBER_PLUGIN_DIR',WP_PLUGIN_DIR."/".str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) );
define( 'WBM_MEMBER_PLUGIN_URL',plugins_url()."/".str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) );
define( 'WBM_MEMBER_VERSION',"1.0.35" );
define( 'WBM_MEMBER_KEY',"wbm-maven-member" );


require_once 'helpers/maven_cache.php';
require_once 'helpers/maven_file.php'; 

require_once 'addons/core/maven-addon.php';
require_once 'addons/core/maven-addon-option.php';


require_once 'addons/core/maven-addons-core.php';
require_once 'addons/core/maven-base-captcha.php';
require_once 'addons/core/maven-dummy-captcha.php';

/*Widgets */
require_once 'addons/widgets/logout/mvn_widget_logout.php';


//TODO: Implement autoload
require_once 'models/maven-member-base-model.php';
require_once 'models/maven-member-roles-model.php';
require_once 'models/maven-member-users-model.php';
require_once 'models/maven-member-categories-model.php';
require_once 'models/maven-member-settings-model.php';
require_once 'models/maven-member-pages-model.php';
require_once 'models/maven-member-registration-model.php';
require_once 'controllers/maven-member-base-class.php';
require_once 'controllers/maven-member-registration-class.php';
require_once 'controllers/maven-member-dashboard-class.php';
require_once 'controllers/maven-member-roles-class.php';
require_once 'controllers/maven-member-users-class.php';
require_once 'controllers/maven-member-categories-class.php';
require_once 'controllers/maven-member-blocker-class.php';
require_once 'controllers/maven-member-settings-class.php';
require_once 'controllers/maven-member-import-class.php';
require_once 'controllers/maven-member-pages-class.php';
require_once 'controllers/maven-member-install-class.php';
require_once 'controllers/maven-member-auto-logout-class.php';
require_once 'controllers/maven-member-short-codes-class.php';
require_once 'controllers/maven-member-wizard-class.php';
require_once 'controllers/maven-member-manager-class.php';





global $maven_manager;

function maven_manager()
{
	global $maven_manager;
	if (!$maven_manager)
		$maven_manager= new Maven_member_manager();

	return $maven_manager;
}

function maven_check_template()
{
	$manager = maven_manager();
	$manager->get_blocker_class()->check_template();
}

function maven_global_key()
{
    return WBM_MEMBER_KEY;
}

function maven_hidden_input_key()
{
    printf('<input type="hidden" name="%s" id="%s" value="1" />', maven_global_key(), maven_global_key());
}

function maven_translation_key(){
	return 'maven-member';
}

function load_locale() {
	// Here we manually fudge the plugin locale as WP doesnt allow many options
	$locale = get_locale();
	if( empty( $locale ) )
		$locale = 'en_US';

	$moFile =  WBM_MEMBER_PLUGIN_DIR ."language/" .maven_translation_key().'-'. $locale . ".mo";
	if(@file_exists($moFile)){
		if(is_readable($moFile)){
			load_textdomain(maven_translation_key(), $moFile);
		}
	}
}

//Register activation function
register_activation_hook( __FILE__, array('Maven_member_manager', 'install'));

load_locale();



?>