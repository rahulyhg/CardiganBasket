<?php
/*
Plugin Name: Mail From 
Plugin URI: http://code.andrewhamilton.net/wordpress/plugins/mail-from/
Description: Change the default address that WordPress sends it's email from.
Author: Andrew Hamilton
Version: 1.0.1
Author URI: http://andrewhamilton.net/
Licensed under the The GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
*/

//----------------------------------------------------------------------------
//		SETUP FUNCTIONS
//----------------------------------------------------------------------------

$mail_from_opt = get_option('mail_from_options');

register_activation_hook(__FILE__,'mail_from_setup_options');

//----------------------------------------------------------------------------
//	Setup Default Settings
//----------------------------------------------------------------------------

function mail_from_setup_options()
{
	global $mail_from_opt;
	
	$mail_from_version = get_option('mail_from_version'); //Mail From Version Number
	$mail_from_this_version = '1.0.1';
	
	$domain = preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
	$sitename = get_bloginfo('name');
	
	// Check the version of Members Only
	if (empty($mail_from_version))
	{
		add_option('mail_from_version', $mail_from_this_version);
	} 
	elseif ($mail_from_version != $mail_from_this_version)
	{
		update_option('mail_from_version', $mail_from_this_version);
	}
	
	// Setup Default Options Array
	$optionarray_def = array(
		'username' => 'noreply',
		'domainname' => $domain,
		'sendername' => $sitename
		);
		
		
	if (empty($mail_from_opt)){ //If there aren't already options for Mail From
		add_option('mail_from_options', $optionarray_def, 'Mail From Wordpress Plugin Options');
	}	
}

//Detect WordPress version to add compatibility with 2.3 or higher
$wpversion_full = get_bloginfo('version');
$wpversion = preg_replace('/([0-9].[0-9])(.*)/', '$1', $wpversion_full); //Boil down version number to X.X

//--------------------------------------------------------------------------
//	Add Admin Page
//--------------------------------------------------------------------------

function mail_from_add_options_page() 
{
    if (function_exists('add_options_page')) 
    {
		add_options_page('Mail From', 'Mail From', 8, basename(__FILE__), 'mail_from_options_page');
    }
}

//----------------------------------------------------------------------------
//		MAIN FUNCTIONS
//----------------------------------------------------------------------------

function mail_from() 
{

global $mail_from_opt;

	if (empty($mail_from_opt['username'])) : $username = "wordpress"; else : $username = $mail_from_opt['username']; endif;
	if (empty($mail_from_opt['domainname'])) : $domainname = strtolower($_SERVER['SERVER_NAME']); else : $domainname = $mail_from_opt['domainname']; endif;
	
	$emailaddress = $username.'@'.$domainname;
	
	return $emailaddress;
}

function mail_from_name() 
{

global $mail_from_opt;

	if (empty($mail_from_opt['sendername'])) : $sendername = "WordPress"; else : $sendername = stripslashes($mail_from_opt['sendername']); endif;
	
	return $sendername;
}

//----------------------------------------------------------------------------
//		ADMIN OPTION PAGE FUNCTIONS
//----------------------------------------------------------------------------

function mail_from_options_page()
{

global $wpdb, $wpversion;

	$domain = preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));

	if (isset($_POST['submit']) ) 
	{	
		// Remove any illegal characters and convert to lowercase both the user name and domain name
		$domain_input_errors = array('http://', 'https://', 'ftp://', 'www.');
		$illegal_chars_username = array('(', ')', '<', '>', ',', ';', ':', '\\', '"', '[', ']', '@', "'", ' ');
		
		$sendername = $_POST['sendername'];
		//$sendername = str_replace ($illegal_chars_username, "", $sendername);
		
		$username = strtolower($_POST['username']);
		$username = str_replace ($illegal_chars_username, "", $username);
		
		$domainname = strtolower($_POST['domainname']);
		$domainname = str_replace ($domain_input_errors, "", $domainname);
		$domainname = preg_replace('/[^0-9a-z\-\.]/i','',$domainname);
		
		// Options Array Update
		$optionarray_update = array (
			'username' => $username,
			'domainname' => $domainname,
			'sendername' => $sendername
		);
		
		update_option('mail_from_options', $optionarray_update);
	}
	
	// Get Options
	$optionarray_def = get_option('mail_from_options');

?>
	<div class="wrap">
	<h2>Mail From Options</h2>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?page=' . basename(__FILE__); ?>&updated=true">
	<fieldset class="options" style="border: none">
	<p>
	<b>Mail From</b> allows you to change the default email address <em>(wordpress@<?php echo $domain;?>)</em> that WordPress sends it's mail from, and
	the name of the sender that the email is from <em>(which is normally WordPress)</em>.</p>
	<table width="100%" <?php $wpversion >= 2.5 ? _e('class="form-table"') : _e('cellspacing="2" cellpadding="5" class="editform"'); ?> >
		<tr valign="center"> 
			<th width="150px" scope="row">Sender Name </th> 
			<td width="45px"><input type="text" id="sendername_inp" name="sendername" value="<?php echo stripslashes($optionarray_def['sendername']); ?>" size="25" /></td>
			<td><span style="color: #555; font-size: .85em;">The sender name that the email is from</span></td> 
		</tr>
		<tr valign="center"> 
			<th width="150px" scope="row">User Name </th> 
			<td width="45px"><input type="text" id="username_inp" name="username" value="<?php echo $optionarray_def['username']; ?>" size="25" /></td>
			<td><span style="color: #555; font-size: .85em;">Username part of the email address e.g. <b>username</b>@example.com</span></td> 
		</tr>
		<tr valign="center"> 
			<th width="150px" scope="row">Domain Name </th> 
			<td width="45px"><input type="text" id="domainname_inp" name="domainname" value="<?php echo $optionarray_def['domainname']; ?>" size="25" /></td>
			<td><span style="color: #555; font-size: .85em;">Domain name part of the email address e.g. username@<b>example.com</b></span></td> 
		</tr>
		<tr valign="center"> 
			<th width="150px" scope="row">eMail Address </th> 
			<td width="45px"><b><?php echo $optionarray_def['username']; ?>@<?php echo $optionarray_def['domainname']; ?></b></td>
			<td><span style="color: #555; font-size: .85em;">Current address WordPress is sending mail from</span></td> 
		</tr>
	</table>
	<p style="color: #555; font-size: .85em;">
	<em><strong>Note:</strong> If you input any characters that can't be used in an email address, either in the user name or domain name they will be automatically removed. Leaving any fields blank will result in the WordPress defaults being used.</em>
	</p>
	<p />
	</fieldset>
	<div class="submit">
		<input type="hidden" name="_submit_check" value="1"/>
		<input type="submit" name="submit" value="<?php _e('Update Options') ?> &raquo;" />
	</div>
	</form>
	<p>	
<?php
}

//----------------------------------------------------------------------------
//		WORDPRESS FILTERS AND ACTIONS
//----------------------------------------------------------------------------

add_filter('wp_mail_from','mail_from');
add_filter('wp_mail_from_name','mail_from_name');
add_action('admin_menu', 'mail_from_add_options_page');

?>