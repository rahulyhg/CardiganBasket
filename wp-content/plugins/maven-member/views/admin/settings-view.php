<form method="post" action="<?php echo $form_action; ?>">
<?php echo $nonce_field ?>

<div class="settings">

    <div id="tabs">
	<ul>
		<li><a href="#tabs-gsettings"><?php _e("General settings",maven_translation_key()); ?></a></li>
		<li><a href="#tabs-dialogs"><?php _e("Dialogs",maven_translation_key()); ?></a></li>
		<li><a href="#tabs-autologout"><?php _e("Auto Log out",maven_translation_key()); ?></a></li>
		<li><a href="#tabs-ltemplate"><?php _e("Login Template",maven_translation_key()); ?></a></li>
		<li><a href="#tabs-registration"><?php _e("Registration",maven_translation_key()); ?></a></li>
		<li><a href="#tabs-advanced"><?php _e("Advanced",maven_translation_key()); ?></a></li>
	</ul>
	<div id="tabs-gsettings">

	    <table class="form-table">
		<tbody>
<!--						<tr valign="top">
				<th scope="row"><label for="use_smilies">Notify admin</label></th>
				<td>
								<label for="use_smilies">
						<input type="checkbox" checked="checked" value="1" id="use_smilies" name="use_smilies" />
								</label>
							</td>
						</tr>-->
						<tr valign="top">
				<th scope="row"><label for="maven-block-title"><?php _e("Block title",maven_translation_key()); ?> </label></th>
				<td>
								<label for="maven-block-title">
						<input type="checkbox"  <?php echo $block_title == '1' ? 'checked="checked"' : ''; ?> value="1" id="maven-block-title" name="block-title" />
									<?php _e("If user doesn't have rights to see the content, also block the title",maven_translation_key()); ?>
								</label>
							</td>
						</tr>

		    <tr valign="top">
				<th scope="row"><label for="maven-login-url"><?php _e("Login url",maven_translation_key()); ?></label></th>
			<td>
			    <table>
				<tr>
				    <td>
						<label for="maven-login-url"> <?php _e("Page",maven_translation_key()); ?> </label>
				    </td>
				    <td>
					<?php wp_dropdown_pages(array('show_option_none' => '&nbsp;', 'id' => 'login_maven_page_id', 'selected' => $login_page, 'name' => 'login-url')); ?>
						
				    </td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<?php _e("Use the shortcut <strong>[mvn-login]</strong> to show the form in your page.",maven_translation_key()); ?>
						<br />
						<?php _e("Can use the attribute 'redirect_to' in the shortcut to redirect after the login.",maven_translation_key()); ?>
						<br />
						<?php _e("For example <strong>[mvn-login redirect_to='http://example.com/']</strong>",maven_translation_key()); ?>
					</td>
				</tr>
			    </table>

			</td>
		    </tr>
		</tbody>
	    </table>
	    <br/>
	    <p  class="submit">
			<button type="submit" name="btnSaveGeneral" id="btnSaveGeneral" class="button button-mvn" value="save"><?php _e("Save",maven_translation_key()); ?></button>
			
	    </p>

	</div>
	<div id="tabs-dialogs">
		<h3><?php _e("Maven members dialogs and error messages",maven_translation_key()); ?></h3>

	    <table class="form-table">
		<tbody>
		    <tr valign="top">
				<th scope="row"><label for="blogname"><?php _e("Restricted post (or page)",maven_translation_key()); ?></label></th>
				<td><textarea  class="large-text code" rows="10" cols="50" id="maven-setting-dialog-restricted" name="dialog-restricted"><?php echo $restricted ?></textarea></td>
		    </tr>
		    <tr valign="top">
				<th scope="row"><label for="dialog-block-title"><?php _e("Restricted title",maven_translation_key()); ?></label></th>
			<td>
			    <input type="text" class="regular-text" value="<?php echo $dialog_block_title ?>" id="dialog-block-title" name="dialog-block-title">
			</td>
		    </tr>
		</tbody>
	    </table>
	    <br/>
	    <p  class="submit">
			<button type="submit" name="btnSaveGeneral" id="btnSaveGeneral" class="button button-mvn" value="save"><?php _e("Save",maven_translation_key()); ?></button>
	    </p>
	</div>
	<div id="tabs-autologout">
	    <table class="form-table">
		<tbody>
		    <tr valign="top">
				<th scope="row"><label for="enabled-auto-log-out"><?php _e("Enable auto-log out",maven_translation_key()); ?></label></th>
			<td>
			    <label for="enabled-auto-log-out">
					<input type="checkbox" <?php echo $auto_logout_enabled == '1' ? 'checked="checked"' : ''; ?> value="1" id="auto-logout-enabled" name="auto-logout-enabled" />
			    </label>
			</td>
		    </tr>
		    <tr valign="top">
				<th scope="row"><label for="auto-logout-idle-limit"><?php _e("Idle time limit",maven_translation_key()); ?></label></th>
			<td>
				<input type="text" class="regular-text" value="<?php echo $auto_logout_limit; ?>" id="auto-logout-idle-limit" name="auto-logout-idle-limit"><?php _e("(minutes)",maven_translation_key()); ?>
			</td>
		    </tr>
		</tbody>
	    </table>
	    <p  class="submit">
			<button type="submit" name="btnSaveGeneral" id="btnSaveGeneral" class="button button-mvn" value="save"><?php _e("Save",maven_translation_key()); ?></button>
	    </p>
	</div>
	<div id="tabs-ltemplate">
	    <table class="form-table">
		<tbody>
		    <tr valign="top">
				<th scope="row"><label for="maven-setting-login"><?php _e("Template",maven_translation_key()); ?></label></th>
			<td>
			    <?php _e("Please, remember to use <b>\"pwd\"</b> and <b>\"log\"</b> as input's names",maven_translation_key()); ?><textarea  class="large-text code" rows="15" cols="50" id="control-login" name="control-login"><?php echo $login ?></textarea>
			    <p>
					<?php _e("You can use a special variable <b>{register_page}</b>. Eg. Don't you have a user yet? &lt;a href=\"{register_page}\" &gt;Register! &lt;/a&gt;",maven_translation_key()); ?><br />
					<?php _e("Or <b>{password_reminder_page}</b>. Eg. Lost your password? &lt;a href=\"{password_reminder_page}\" &gt;Click here &lt;/a&gt;",maven_translation_key()); ?>
				</p>
			</td>
		    </tr>
<!--						<tr valign="top">
			    <th scope="row"><label for="blogname">Register html</label></th>
			    <td>Please, remember to use "pwd" and "log" as input's names<textarea  class="large-text code" rows="15" cols="50" id="maven-setting-register" name="maven-setting-register"><?php //echo $register ?></textarea></td>
						</tr>-->
		</tbody>
	    </table>
	    <p  class="submit">
			<button type="submit" name="btnSaveGeneral" id="btnSaveGeneral" class="button button-mvn" value="save"><?php _e("Save",maven_translation_key()); ?></button>
	    </p>

	</div>

	<div id="tabs-registration">
	    <div id="registration-tabs">
		<ul>
			<li><a href="#registration-1"><?php _e("Options",maven_translation_key()); ?></a></li>
			<li><a href="#registration-2"><?php _e("Templates",maven_translation_key()); ?></a></li>
			<li><a href="#registration-3"><?php _e("Captcha",maven_translation_key()); ?></a></li>
		</ul>
		<div id="registration-1">

		    <table class="form-table">
			<tbody>
			    <tr valign="top">
					<th scope="row"><label for="maven-registration-on"><?php _e("Disable registration",maven_translation_key()); ?></label></th>
				<td>
				    <label for="maven-registration-on">
					<input type="checkbox"  <?php echo $registration_on == '1' ? 'checked="checked"' : ''; ?> value="1" id="registration-on" name="registration-on" />
					<?php _e("Disable the registration process, only allows login",maven_translation_key()); ?>
				    </label>
				</td>
			    </tr>
			    <tr valign="top">
					<th scope="row"><label for="registration_page"><?php _e("Registration page",maven_translation_key()); ?></label></th>
				<td>
				    <?php wp_dropdown_pages(array('show_option_none' => '&nbsp;', 'id' => 'registration_page', 'selected' => $registration_page, 'name' => 'registration-page')); ?>
					<?php _e("Use the shortcut <b>[mvn-registration]</b> to show the form in your page",maven_translation_key()); ?>
				</td>
			    </tr>
			    <tr valign="top">
					<th scope="row"><label for="successful_registration_page"><?php _e("Successful registration page",maven_translation_key()); ?></label></th>
				<td>
				    <?php wp_dropdown_pages(array('show_option_none' => '&nbsp;', 'id' => 'successful_registration_page', 'selected' => $successful_registration_page, 'name' => 'successful-registration-page')); ?>
				</td>
			    </tr>
			    <tr valign="top">
					<th scope="row"><label for="maven-role-default"><?php _e("Default registration role",maven_translation_key()); ?></label></th>
				<td>
				    <label for="default-registration-role">
					<select id="default-registration-role" name="default-registration-role">
					    <option value=""/>
					    <?php foreach ($roles as $role): ?>
    					    <option value="<?php echo $role->internal_name ?>" <?php if ($default_registration_role == $role->internal_name): echo "selected='selected'";
					    endif; ?> title="<?php echo $role->name ?>" ><?php echo $role->name ?></option>
						    <?php endforeach; ?>
					</select>        
					<?php _e("New registration user will have this role",maven_translation_key()); ?>
				    </label>
				</td>
			    </tr>
			    <tr valign="top">
					<th scope="row"><label for="maven-activation-default"><?php _e("Activate users by default",maven_translation_key()); ?></label></th>
				<td>
				    <label for="maven-activation-default">
					<input type="checkbox"  <?php echo $activation_default == '1' ? 'checked="checked"' : ''; ?> value="1" id="activation-default" name="activation-default" />
					<?php _e("User is activated by default upon registration",maven_translation_key()); ?>
				    </label>
				</td>
				<tr valign="top">
					<th scope="row"><label for="maven-send-activation-email-default"><?php _e("Send email to a user by default",maven_translation_key()); ?></label></th>
					<td>
						<label for="maven-send-activation-email-default">
						<input type="checkbox"  <?php echo $send_activation_email_default == '1' ? 'checked="checked"' : ''; ?> value="1" id="send-activation-email-default" name="send-activation-email-default" />
						<?php _e("User will receive an email when it is activated",maven_translation_key()); ?>
						</label>
					</td>
			    </tr>
			    <tr valign="top">
					<th scope="row"><label for="maven-activation-page-id"><?php _e("Activation page",maven_translation_key()); ?></label></th>
				<td>
				    <table>
					<tr>
					    <td colspan="2">
						<?php wp_dropdown_pages(array('show_option_none' => '&nbsp;', 'id' => 'activation-url','name' => 'activation-url', 'selected' => $activation_url)); ?>
						<?php _e("User is redirected to this page, if he is not activated yet.",maven_translation_key()); ?>
					    </td>
					</tr>
					
				    </table>
				</td>
			    </tr>
			</tbody>
		    </table>

		</div>
		<div id="registration-2">

		    <table class="form-table">
			<tbody>
			    <tr valign="top">
					<th scope="row"><label for="maven-registration-template-container"><?php _e("Container template",maven_translation_key()); ?></label></th>
				<td>
				    <label for="maven-registration-template-container">
					<textarea  class="large-text code" rows="9" cols="50" id="registration-template-container" name="registration-template-container" ><?php echo $registration_template_container ?></textarea>
				    </label>
				    <p>
						<?php _e('Use <b>{$fields},{$captcha}</b> in your template to set the place where fields and reCaptcha will be set.',maven_translation_key()); ?>
				    </p>
				</td>
			    </tr>

			    <tr valign="top">
					<th scope="row"><label for="maven-registration-template-field"><?php _e("Container field template",maven_translation_key()); ?></label></th>
				<td>
				    <label for="maven-registration-template-field">
					<textarea  class="large-text code" rows="5" cols="50" id="registration-template-field" name='registration-template-field'  ><?php echo $registration_template_field ?></textarea>
				    </label>
				    <p>
						<?php _e('Use <b>{$field_name},{$required},{$field_control}</b> in your template to set the place where property fields will appear.',maven_translation_key()); ?>
				    </p>
				</td>
			    </tr>
			    <tr valign="top">
					<th scope="row"><label for="maven-registration-template-required"><?php _e("Required template",maven_translation_key()); ?></label></th>
				<td>
				    <label for="maven-registration-template-required">
					<textarea  class="large-text code" rows="2" cols="50" id="registration-template-required" name="registration-template-required"  ><?php echo $registration_template_required ?></textarea>
				    </label>
				</td>
			    </tr>
				<tr valign="top">
					<th scope="row"><label for="maven-email-activation-template"><?php _e("Template for email user activation",maven_translation_key()); ?></label></th>
					<td>
						<?php _e("The user will receive this message when the account is activated",maven_translation_key()); ?>
						<textarea  class="large-text code" rows="15" cols="50" id="email-activation-template" name="email-activation-template"><?php echo $email_activation_template ?></textarea>
						<p>
						<?php _e('Use <b>{user_name} or {blog_name}</b> in your template to set the place where user and blog name will appear.',maven_translation_key()); ?>
						</p>
					</td>
				</tr>
			</tbody>
		    </table>     

		</div>
		<div id="registration-3">
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
					<th scope="row"><label for="registration-is-captcha-enabled"><?php _e("Enable Captcha",maven_translation_key()); ?></label></th>
				<td>
				    <label for="registration-is-captcha-enabled">
					<input type="checkbox"  <?php echo $is_captcha_enabled == '1' ? 'checked="checked"' : ''; ?> value="1" id="registration-is-captcha-enabled" name="registration-is-captcha-enabled" />

				    </label>
				</td>
			    </tr>
			     <tr valign="top">
					 <th scope="row"><label for="maven-captcha"><?php _e("Choose the captcha you want to use",maven_translation_key()); ?></label></th>
				<td>
				    <label for="registration-active-captcha">
					<select id="registration-active-captcha" name="registration-active-captcha">
					    <option value=""/>
					    <?php foreach ($captchas as $captcha): ?>
    					    <option value="<?php echo $captcha->file ?>" <?php if ($selected_captcha == $captcha->file): echo "selected='selected'";
					    endif; ?> title="<?php echo $captcha->name ?>" ><?php echo $captcha->name ?></option>
						    <?php endforeach; ?>
					</select>        
				    </label>
				</td
			    </tr>
			    <tr>
				<td>
				    <?php _e("Captchas options",maven_translation_key()); ?>
				    <input id="captcha_options_ids" type="hidden" value="<?php echo $captcha_options_ids;?>" />
				</td>
				<td >
				    <?php foreach ($captchas as $captcha): ?>
				    <div class="setting-box">
					<div class="title">
					<?php echo $captcha->name; ?>
					</div>
					<div class="short_desc">
					    <?php echo $captcha->description; ?>
					</div>
					    <table>
						<tbody>
						    <?php foreach ($captcha->options as $option): ?>
						    <tr>
							<td>
							    <?php echo $option->name; ?>
							</td>
							<td>
							    <?php echo $option->get_html(); ?>
							</td>
						    </tr>
						    <?php endforeach; ?>
						</tbody>
					    </table>
				    </div>
				    <?php endforeach; ?>
				</td>
			    </tr>
			</tbody>
		    </table>
		</div>
	    </div>




	    <p  class="submit">
			<button type="submit" name="btnSaveGeneral" id="btnSaveGeneral" class="button button-mvn" value="save"><?php _e("Save",maven_translation_key()); ?></button>
	    </p>
	</div>

	<div id="tabs-advanced">

	    <div class="setting-box">
			<h3 class="hndle"><span> <?php _e("Reset",maven_translation_key()); ?> </span></h3>
		<table>
		    <tr>
			<td>
			    <img src="<?php echo $plugin_image_url . "warning.png" ?>" alt="warning"/>
			</td>
			<td>
				<?php _e("Clicking in the reset button, you will <b>lose all your configuration</b>, including",maven_translation_key()); ?>
			    <ul>
					<li>
						<?php _e("Registration fields configuration",maven_translation_key()); ?>
					</li>
					<li>
						<?php _e("Custom Registration fields",maven_translation_key()); ?>
					</li>
					<li>
						<?php _e("Reset all category roles",maven_translation_key()); ?>
					</li>
			    </ul>
			</td>
		    </tr>
		    <tr>
			<td colspan="2" style="text-align: right;">
				<p  class="submit">
					<button type="submit" name="btnSaveGeneral" id="btnSaveGeneral" class="button button-mvn" value="reset"><?php _e("Reset",maven_translation_key()); ?></button>
				</p>
			</td>
		    </tr>
		</table>

	    </div>


	</div>
    </div>

</div><!-- End demo -->
</form>