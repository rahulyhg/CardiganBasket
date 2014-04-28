	<?php echo $nonce_field ?>
	<div id="poststuff" class="metabox-holder has-right-sidebar" style="display:none">
		<div id="post-body">
			<div id="post-body-content">
				<div class="postbox">
							<h3 class="hndle"><span><?php _e("Role details",maven_translation_key()); ?></span></h3>
								<div class="inside">
									<table class="form-table">
										<tbody>
											<tr>
												<th scope="row">
													<label for="new-role-name"><?php _e("Name",maven_translation_key()); ?></label>
												</th>
												<td>
													<input type="text" value=""  id="new-role-name">
												</td>
											</tr>
											
										</tbody>
									</table>
									<p class="submit">
										<button class="button-primary" value="save" name="btnSaveNewCategory" id="btnSaveNewRole" type="submit">
											<span><?php _e("Save",maven_translation_key()); ?></span>
										</button>
										<a class="button" id="btnCancelNewRole" href="#"><?php _e("Cancel",maven_translation_key()); ?></a>
									</p>
							</div>
					 </div>
			</div>
		</div>
	</div>
	<table cellspacing="0" class="widefat fixed">
		<thead>
			<tr>
				<th class="manage-column column-name sorted asc" scope="col">
					<a class="sorted asc" href="#"><span><?php _e("Name",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
				</th>
				<th class="manage-column column-name sorted asc" scope="col">
					<span><?php _e("Shortcode",maven_translation_key()); ?></span>
				</th>
<!--				<th class="manage-column column-key sortable asc" scope="col">
					<a class="sortable asc" href="#"><span>Users</span><span class="sorting-indicator"></span></a>
				</th>-->

			</tr>
		</thead>
		<tfoot>
			<tr>
				<th class="manage-column column-name sorted asc" scope="col">
					<a class="sorted asc" href="#"><span><?php _e("Name",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
				</th>
				<th class="manage-column column-name sorted asc" scope="col">
					<span><?php _e("Shortcode",maven_translation_key()); ?></span>
				</th>
<!--				<th class="manage-column column-key sortable asc" scope="col">
					<a class="sortable asc" href="#"><span>Users</span><span class="sorting-indicator"></span></a>
				</th>-->
			</tr>
		</tfoot>

		<tbody class="list:user user-list" id="roles">
			<?php foreach ($roles as $role): ?>
			<tr id="role-row-<?php echo  $role->internal_name; ?>">
				<td class="username column-username">
                    <span class="row-title-role"><?php echo  $role->name; ?></span><br/>
                    <div class="row-actions">
<!--                        <a class="maven-edit" href="#<?php echo  $role->internal_name; ?>">Edit|</a>-->
						<a class="maven-remove confirm" href="#<?php echo  $role->internal_name; ?>"> <?php _e("Delete",maven_translation_key()); ?></a>
                    </div>
					<div id="inline-<?php echo  $role->internal_name; ?>" class="hidden">
						<div class="role_name"><?php echo  $role->name; ?></div>
						<?php if(isset($role->roles_keys)): ?>
							<div class="cat_existing_roles"><?php echo (is_array($role->roles_keys))?implode(',', $role->roles_keys):$role->roles_keys; ?></div>
						<?php endif; ?>
					</div>
				</td>
				<td class="username column-username">
					<span class="row-short-role">[mvn-block roles="<?php echo  $role->internal_name; ?>"] <?php _e("My protected content",maven_translation_key()); ?> [/mvn-block]</span><br/>
				</td>
<!--				<td class="username column-username">
					<span class="roles-names"><?echo "0" ?></span>
				</td>-->
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
								<span class="input-text-wrap"><input type="text" value="" class="ptitle" id="role_name"></span>
							</label>
						</div>
					</fieldset>
					
					<p class="submit inline-edit-save">
						<img alt="" src="<?php echo $loading_image?>" style="display: none;" class="waiting">
						<a id="save-role" class="button-primary save " title="Update" href="#inline-edit" accesskey="s"><?php _e("Update",maven_translation_key()); ?></a>
						<a id="cancel-role" class="button-secondary cancel " title="Cancel" href="#inline-edit" accesskey="c"><?php _e("Cancel",maven_translation_key()); ?></a>

						<br class="clear">
					</p>
				</td>
			</tr>
	</table>