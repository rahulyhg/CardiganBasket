
	
	<table cellspacing="0" class="widefat fixed">
		<thead>
			<tr>
				<th class="manage-column column-name sorted asc" scope="col">
					<a class="sorted asc" href="#"><span><?php _e("Name",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
				</th>
				<th class="manage-column column-key sortable asc" scope="col">
					<a class="sortable asc" href="#"><span><?php _e("Roles",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
				</th>
				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th class="manage-column column-name sorted asc" scope="col">
					<a class="sorted asc" href="#"><span><?php _e("Name",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
				</th>
				<th class="manage-column column-key sortable asc" scope="col">
					<a class="sortable asc" href="#"><span><?php _e("Roles",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
				</th>
			</tr>
		</tfoot>

		<tbody class="list:user user-list" id="templates">
			<?php foreach ($templates as $template):   ?>
			<tr id="template-row-<?php echo  $template->id; ?>">
				<td class="username column-username">
                    <span class="row-title-template" ><?php echo  $template->name; ?></span><br />
                    <div class="row-actions">
                        <a class="maven-edit" href="#<?php echo  $template->id; ?>"><?php _e("Edit",maven_translation_key()); ?></a>
                    </div>
					<div id="inline-<?php echo  $template->id; ?>" class="hidden">
						<div class="temp_name"><?php echo  $template->name; ?></div>
						<div class="temp_existing_roles"><?php echo $template->roles_keys; ?></div>
					</div>
				</td>
				<td class="username column-username">
					<span class="roles-names"><?echo $template->roles_names ?></span>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	
				
	<table id="tblForm" style="display: none;">
		<tbody id="inlineedit">

			<tr style="display: none;" class="inline-edit-row inline-edit-row-post inline-edit-post quick-edit-row quick-edit-row-post inline-edit-post" id="inline-edit">
				<td class="colspanchange" colspan="2">

					<fieldset class="inline-edit-col-left">
						<div class="inline-edit-col">
							<label>
								<span class="title"><?php _e("Name",maven_translation_key()); ?></span>
								<span class="input-text-wrap"><span id="template_name"></span></span>
							</label>
						</div>
					</fieldset>
					<fieldset class="inline-edit-col-center inline-edit-templates">
						<div class="inline-edit-col">
							<ul class="cat-checklist template-checklist">
								<?php foreach($roles as $role): ?>
								<li  id="role-<?php echo $role->internal_name; ?>">
									<label class="selectit"><input type="checkbox" id="in-role-<?php echo $role->internal_name; ?>" name="template-role[]" value="<?php echo $role->internal_name; ?>"><?php echo $role->name; ?></label>
								</li>
								<?php endforeach;?>
							</ul>
						</div>
					</fieldset>
					<p class="submit inline-edit-save">
						<img alt="" src="<?php echo $loading_image?>" style="display: none;" class="waiting">
						<a id="save-template" class="button-primary save " title="<?php _e("Update",maven_translation_key()); ?>" href="#inline-edit" accesskey="s"><?php _e("Update",maven_translation_key()); ?></a>
						<a id="cancel-template" class="button-secondary cancel " title="<?php _e("Cancel",maven_translation_key()); ?>" href="#inline-edit" accesskey="c"><?php _e("Cancel",maven_translation_key()); ?></a>
						
						<br class="clear">
					</p>
				</td>
			</tr>
	</table>