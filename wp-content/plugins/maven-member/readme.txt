=== Maven Member ===
Contributors: Emiliano Jankowski, Guillermo Tenaschuk, Juan Pablo Baena
Tags: authentication, roles, block, community, content, login, password, member,register, registration, restriction, security, user, users, membership, access, permissions, members
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: trunk

Maven Member&trade; lets you protect pages, posts and categories using flexible roles that you can define. 

== Description ==

Maven Member&trade; is less about membership and more about restricting access to certain areas of your site.  While we are planning on payment integration options, the main problem this plugin solves is: do you have sensitive content but don't need a plugin that takes over your site or requires hours of setup? Bingo!

Documentation is in process and feedback is welcome.  You can use the forum or please ask submit any questions or suggestion to mavenmember@gmail.com! Thanks!

= Features: =

* Restrict access to posts, pages, and categories
* Login inline with content rather than using the WP login page
* Create your own custom registration form
* Hold new registrations for admin moderation/approval
* Customizable templates for login and registration
* Captcha in the registration form

== Installation ==

Maven Members&trade; is designed to run "out-of-the-box" with no modifications to your WP installation necessary.

= Basic Install: =

1. Upload the `/maven-members/` directory and its contents to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress&reg;
3. Use the wizard to create a new role

&nbsp;&nbsp; a. Asign the role to existing users.
&nbsp;&nbsp; b. Protect some categories. Any post under those categories, will need a login (you can customize it in Settings / Advance)

Also, you can protect some pieces of a post using the folowing shortcode

[mvn-block roles="my-role"] this is my text  [/mvn-block]

To show the registration form use

[mvn-registration]

== Screenshots ==
1. reCaptcha configuration
2. Categories
3. Registration custom fields
4. Logout widget

== Changelog ==

= 1.0.35 =

* Fixed some issues when add a new user from the backend.
* The Maven Member default role is assigned to the users created from backend.
* Fixed the fields not showing on Maven Members User form in Wordpress 3.5

= 1.0.34 =

* Added user email to the Maven Members User list/form.
* Added individual user access from [mvn-block] shortcode. I.E:
       [mvn-block users="< user ID separated comma >"][/mvn-block]
       [mvn-block roles="maven-default-role" users="23,43"] My protected content [/mvn-block]

= 1.0.33 =

* Fixed the AJAX calls when using a port on the URL

= 1.0.32 =

* Block edit form to restricted content to users EDITORS without Maven Members roles.
* Fix translation of the registration fields.


= 1.0.31 =

* Added Redirect after login option to widget login form.
* Fixed file upload popup on Maven Member import section.s

= 1.0.30 =

* Added User first name and last name in Maven Member user list.
* Maven Member plugin has now multi-language support.
* Added spanish language.

= 1.0.29 =

* Added Block Title feature. (check the Maven Members settings)
* Fixed Content blocked by shortcode when is logged as Admin

= 1.0.28 =

* Added redirect after login feature. Use the "redirect_to" attribute in the [mvn-login] shortcode

= 1.0.27 =

* Fixed issues when add new users
* Added field validation on new user form.

= 1.0.26 =

* Import users:
	-Now is possible add username and password in the CSV user file. (check the example file)
	-Added "Default Active" to set the default status of the users imported.
* Fixed some minor issues

= 1.0.25 =

* Fix for settings admin page

= 1.0.24 =

* Fixed wrong header on import page
* Added messages when there are some problem on import process

= 1.0.23 =

* Captcha Key validation for reCaptcha


= 1.0.22 =

* Fixed Maven roles reset when user haven't maven roles 


= 1.0.21 =
 
* Added donate link.
* Fixed "You don't have permissions to access this page" error when users try to edit their own profile.
* Fixed Maven roles reset when adminstrators try to edit their own profile.


= 1.0.20 =

* Added special variable {password_reminder_page} on "Settings->Login template". 
* Now administrator can see the content protected with [mvn-block] sortcode, even without roles assigned.


= 1.0.19 =

* Fix Default role not saved on settings page



= 1.0.18 =

* Changed the save method of the settings from ajax to POST request
* Fix Maven roles reset when use WP Edit user form.


= 1.0.17 =

* Redirect to the home page after logout from the widget logout link.
* Redirect to the current page if the user login fail when you try to login from the widget login form or from the content restricted login form.
* Added Import Feature


= 1.0.16 =

* Show login form when you use the_excerpt() method.


= 1.0.15 =

* Login widget
* Just one protected message for a category listing
* A few issues were fixed


= 1.0.14 =

* Mail to user when it is activated
* Template activation mail
* "Object of class stdClass could not be converted to string" issue was fixed. 
* login redirect issue was fixed. 

= 1.0.13.4 =

* Recursive shortcode
* Login redirect issue

= 1.0.13.2 =


* Logout widget
* Maven roles are not longer showed in the WP Edit user form


= 1.0.13 =


* Captcha is not enabled by default
* Adding new category using WP had an issue. 
* Admin can now see all protected content
* New options in Admin Bar



= 1.0.12 =

Please, uninstall it and install it again :)
* More than 20 issues were fixed.
* New captcha feature



= 1.0.11 =

* Adding new category using WP core, was removing the roles. 
* Wizard was not working
* Fixed js issues

= 1.0.10 =

* Adding a new category was not assigning the roles.
* Fixed Css issues
* Fixed js issues

= 1.0.9 =

* Registration enabled status in dashboard
* Required fields in registration
* Fixed a lot of bugs


= 1.0.8 =

* After adding a new role, it was showing the wrong shortcode
* Page roles weren't working. 
* New help was added



= 1.0.7 =

* Remove role was deleting all the roles from others caregories. Fixed


= 1.0.6 =

NOTE: IF YOU ALREADY HAVE THE PLUGIN INSTALLED, PLEASE ACTIVATE AND DEACTIVATE IT

* Added FAQs page
* Registration template
* Registration field orders (drag and drop)


= 1.0.5 =

* Added FAQs page
* Change the way the views are managed. 
* Change the way the update/error messages in js are managed
* Turn on/off registration
* Activate user by default and assign a role by default.

= 1.0.4 =

* Added feedback form in the dashboard page

= 1.0.3 =

New Features

* Default activation for new user registration


Bug Fixes

* Editing categories was losing roles

= 1.0.2 =

New Features

* Ability to create new fields to store user info. Now it just let you choose the WP fields.
* When roles are removed, ensure that users have the default wp role setted.
* Sanitize role names.
* Create default maven role in plugin activation
* Test with WP 3.2

Bug Fixes

* new role js




= 1.0.1 =

New Features

* added Fields page to control the registration fields
* added Dashboard with general information
* added shorcode to show the registration form [mvn-registration]

Bug Fixes

* corrected a bug that caused out error when activation
* removed not used settings

