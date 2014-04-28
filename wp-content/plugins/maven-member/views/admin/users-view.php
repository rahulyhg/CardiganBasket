<div id="poststuff" class="metabox-holder has-right-sidebar" style="display:none">
    <div id="post-body">
        <div id="post-body-content">
            <div class="postbox">
                <h3 class="hndle"><span> <?php _e("User details",maven_translation_key()); ?></span></h3>
                <div class="inside">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="new-user-name"><?php _e("Name",maven_translation_key()); ?></label>
                                </th>
                                <td>
                                    <input type="text" value="" name="new-user-name" id="new-user-name">
                                </td>
                                <td>
                                    <label for="new-password-name"><?php _e("Password",maven_translation_key()); ?></label>
                                </td>
                                <td>
                                    <input type="password" value="" name="new-password-name" id="new-password-name">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="new-email-name"><?php _e("Email",maven_translation_key()); ?></label>
                                </th>
                                <td>
                                    <input type="text" value="" name="new-email-name" id="new-email-name">
                                </td>
                                <th scope="row">
                                    <label for="new-enabled"><?php _e("Enabled",maven_translation_key()); ?></label>
                                </th>
                                <td>
                                    <input type="checkbox" name="new-enabled" id="new-enabled">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="web_site"><?php _e("Roles",maven_translation_key()); ?></label>
                                </th>
                                <td colspan="3">
                                    <ul id="edit-roles" >
                                        <?php foreach ($roles as $role): ?>
                                            <li  id="addrole-<?php echo $role->internal_name; ?>">
                                                <label class="selectit"><input type="checkbox" id="in-role-<?php echo $role->internal_name; ?>" name="new-user-role[]" value="<?php echo $role->internal_name; ?>"><?php echo $role->name; ?></label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
					<span id="error-message"></span>
                    <p class="submit">
                        <button class="button-primary" value="save" name="btnSaveNewUser" id="btnSaveNewUser" type="submit">
                            <span><?php _e("Save",maven_translation_key()); ?></span>
                        </button>
                        <a class="button" id="btnCancelNewUser" href="#"><?php _e("Cancel",maven_translation_key()); ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<table id="users_list" cellspacing="0" class="widefat fixed">
    <thead>
        <tr>
            <th class="manage-column column-name sorted asc" scope="col">
                <a class="sorted asc" href="#"><span><?php _e("User",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
            <th class="manage-column column-name sortable asc" scope="col">
                <a class="sortable asc" href="#"><span><?php _e("Name",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
            <th class="manage-column column-name sortable asc" scope="col">
                <a class="sortable asc" href="#"><span><?php _e("Email",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
            <th class="manage-column column-key sortable asc" scope="col">
                <a class="sortable asc" href="#"><span><?php _e("Roles",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
            <th class="manage-column column-key sortable asc" scope="col">
                <a class="sortable asc" href="#"><span><?php _e("Active",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
        </tr>
    </thead>
    <tfoot>
        <tr>
			<th class="manage-column column-name sorted asc" scope="col">
                <a class="sorted asc" href="#"><span><?php _e("User",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
            <th class="manage-column column-name sorted asc" scope="col">
                <a class="sorted asc" href="#"><span><?php _e("Name",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
            <th class="manage-column column-name sorted asc" scope="col">
                <a class="sorted asc" href="#"><span><?php _e("Email",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
            <th class="manage-column column-key sortable asc" scope="col">
                <a class="sortable asc" href="#"><span><?php _e("Roles",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
            <th class="manage-column column-key sortable asc" scope="col">
                <a class="sortable asc" href="#"><span><?php _e("Active",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
        </tr>
    </tfoot>

    <tbody class="list:user user-list" id="users">
        <?php foreach ($users as $user): ?>
            <tr id="user-row-<?php echo $user->ID; ?>">
                <td class="username column-username">
                    <?php echo $user->display_name; ?><br />
                    <div class="row-actions">
							<a class="maven-edit" href="#<?php echo $user->ID; ?>"><?php _e("Edit",maven_translation_key()); ?></a>
                        <?php if (!$user->enabled): ?>
							<a class="maven-enable on" href="#<?php echo $user->ID; ?>">| <?php _e("Enable",maven_translation_key()); ?></a>
                        <?php else: ?>
                            <a class="maven-enable off" href="#<?php echo $user->ID; ?>">| <?php _e("Disable",maven_translation_key()); ?></a>
                        <?php endif; ?>
							<a class="maven-remove confirm" href="#<?php echo $user->ID; ?>">| <?php _e("Delete",maven_translation_key()); ?></a>
                    </div>
                    <div id="inline-<?php echo $user->ID; ?>" class="hidden">
                        <div class="user_name"><?php echo $user->display_name; ?></div>
                        <div class="user_email"><?php echo $user->user_email; ?></div>
                        <div class="user_existing_roles"><?php echo implode(',', $user->roles_keys); ?></div>
                        <div class="user_enabled"><?php echo $user->enabled; ?></div>
						<span class="maven-member-fields">
						<?php
						if(is_array($fields_value[$user->ID])){
							foreach($fields_value[$user->ID] as $field_value){?>
								<input type="hidden" class="maven-member-<?php echo $field_value->id;?>" value="<?php echo $field_value->value;?>" />
							<?php
							}
						}
						?>
						</span>
                    </div>
                </td>
		<td class="username column-username">
                    <span class="user-names"><?php echo $user->first_name.' '.$user->last_name; ?></span>
                </td>
                <td class="username column-username">
                    <span class="user-email"><?php echo $user->user_email; ?></span>
                </td>
                <td class="username column-username">
                    <span class="roles-names"><?php echo $user->roles_names ?></span>
                </td>
                <td class="username column-username">
                    <input class="list-user-enabled" type="checkbox" <?php echo $user->enabled ? 'checked="checked"' : ''; ?> disabled="disabled" />
					
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<table id="tblForm" style="display: none;">
    <tbody id="inlineedit">

        <tr style="display: none;" class="inline-edit-row inline-edit-row-post inline-edit-post quick-edit-row quick-edit-row-post inline-edit-post" id="inline-edit">
            <td class="colspanchange" colspan="5">

                <fieldset class="inline-edit-col-left">
                    <div class="inline-edit-col">
                        <label>
                            <span class="title"><?php _e("Name",maven_translation_key()); ?></span>
                            <span class="input-text-wrap"><input type="text" value="" class="ptitle" id="user_name" readonly="readonly"></span>
                        </label>
                        <label>
                            <span class="title"><?php _e("Email",maven_translation_key()); ?></span>
                            <span class="input-text-wrap"><input type="text" value="" class="ptitle" id="user_email" readonly="readonly"></span>
                        </label>
						<?php foreach($fields as $field): ?>

						<?php	$title_label=preg_replace('/\s+?(\S+)?$/', '', substr($field->name, 0, 7)); ?>
                                                <label>
							<span class="title"><?php _e($title_label,maven_translation_key()); ?></span>
							<span class="input-text-wrap"><input type="text" value="" class="ptitle" id="maven-member-<?php echo $field->id; ?>" readonly="readonly"></span>
						</label>
						<?php endforeach;?>
                        <label>
                            <span class="title"><?php _e("Enable",maven_translation_key()); ?></span>
                            <span class="input-text-wrap"><input type="checkbox" id="user_enabled" /></span>
                        </label>

        
                    </div>
                </fieldset>
                <fieldset class="inline-edit-col-center inline-edit-categories">
                    <div class="inline-edit-col">
                        <ul class="cat-checklist category-checklist">
                            <?php foreach ($roles as $role): ?>
                                <li  id="role-<?php echo $role->internal_name; ?>">
                                    <label class="selectit"><input type="checkbox" id="in-role-<?php echo $role->internal_name; ?>" name="user-role[]" value="<?php echo $role->internal_name; ?>"><?php echo $role->name; ?></label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </fieldset>
                <p class="submit inline-edit-save">
                    <img alt="" src="<?php echo $loading_image; ?>" style="display: none;" class="waiting">
                    <a id="save-user" class="button-primary save " title="<?php _e("Update",maven_translation_key()); ?>" href="#inline-edit" accesskey="s"><?php _e("Update",maven_translation_key()); ?></a>
                    <a id="cancel-user" class="button-secondary cancel " title="<?php _e("Cancel",maven_translation_key()); ?>" href="#inline-edit" accesskey="c"><?php _e("Cancel",maven_translation_key()); ?></a>

                    <br class="clear">
                </p>
            </td>
        </tr>
</table>