	<p><?php _e("Determine which fields will display. This includes all fields, both native WP fields and Maven Members custom fields.",maven_translation_key()); ?><br/>
		<b><?php _e("(Note: Email, login and password are always mandatory. and cannot be changed.)",maven_translation_key()); ?></b></p>
	<div id="poststuff" class="metabox-holder has-right-sidebar" style="display:none;width:40%;">
		 
			<div id="post-body-content">
				<div class="postbox">
							<h3 class="hndle"><span> <?php _e("Field details",maven_translation_key()); ?></span></h3>
								<div class="inside">
									<table class="form-table">
										<tbody>
											<tr>
												<th scope="row">
													<label for="new-field-name"><?php _e("Name",maven_translation_key()); ?></label>
												</th>
												<td>
													<input type="text" value="" name="new-field-name" id="new-field-name">
												</td>
											</tr>
											<tr>
												<th scope="row">
													<label for="new-field-display"><?php _e("Display",maven_translation_key()); ?></label>
												</th>
												<td>
													<input type="checkbox" name="new-display" checked="checked" id="new-display">
												</td>
											</tr>
											<tr>
												<th scope="row">
													<label for="new-field-required"><?php _e("Required",maven_translation_key()); ?></label>
												</th>
												<td>
													<input type="checkbox" name="new-required" checked="checked" id="new-required">
												</td>
											</tr>
										</tbody>
									</table>
									<p class="submit">
										<button class="button-primary" value="save" name="btnSaveNewField" id="btnSaveNewField" type="submit">
											<span><?php _e("Save",maven_translation_key()); ?></span>
										</button>
										<a class="button" id="btnCancelNewField" href="#"><?php _e("Cancel",maven_translation_key()); ?></a>
									</p>
							</div>
					 </div>
			</div>
		 
	</div>
	
	
		<table cellspacing="0" id="tblFields" class="widefat fixed" >
			<thead>
				<tr>
					<th class="manage-column column-name sorted asc" scope="col">
						<a href="#"><span><?php _e("Name",maven_translation_key()); ?></span></span></a>
					</th>
					<th class="manage-column column-name sorted asc" scope="col">
						<a class="sorted asc" href="#"><span><?php _e("WP Field",maven_translation_key()); ?></span></a>
					</th>
					<th class="manage-column column-name sorted asc" scope="col">
						<a class="sorted asc" href="#"><span><?php _e("Display",maven_translation_key()); ?></span></a>
					</th>
					<th class="manage-column column-name sorted asc" scope="col">
						<a class="sorted asc" href="#"><span><?php _e("Required",maven_translation_key()); ?></span></a>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="manage-column column-name sorted asc" scope="col">
						<a href="#"><span><?php _e("Name",maven_translation_key()); ?></span></span></a>
					</th>
					<th class="manage-column column-name sorted asc" scope="col">
						<a class="sorted asc" href="#"><span><?php _e("WP Field",maven_translation_key()); ?></span></a>
					</th>
					<th class="manage-column column-name sorted asc" scope="col">
						<a class="sorted asc" href="#"><span><?php _e("Display",maven_translation_key()); ?></span></a>
					</th>
					<th class="manage-column column-name sorted asc" scope="col">
						<a class="sorted asc" href="#"><span><?php _e("Required",maven_translation_key()); ?></span></a>
					</th>
				</tr>
			</tfoot>

			<tbody class="list:user user-list" id="fields">
				<?php foreach ($fields as $field): ?>
				<tr id="field-row-<?php echo  $field->id; ?>">
					<td class="username column-username">
						<input class="row-field-order" type="hidden" value="<?php echo  $field->order; ?>" />
						<span class="row-title-field" ><?php echo  $field->name; ?></span><br />
						<div class="row-actions">
							<?php if (!$field->native): ?>
							<a class="maven-remove confirm" href="#<?php echo  $field->id; ?>"><?php _e("Delete",maven_translation_key()); ?></a>
							<?php endif;?>
						</div>
						<div id="inline-<?php echo  $field->id; ?>" class="hidden">
							<div class="field_name"><?php echo  $field->name; ?></div>
						</div>
					</td>
					<td class="username column-username">
						<input class="list-user-enabled" type="checkbox" <?php echo $field->native?'checked="checked"':''; ?> disabled="disabled" />
					</td>
					<td class="username column-username">
						<input name="list-field-display[]" type="checkbox" value="<?php echo  $field->id; ?>" <?php echo $field->display?'checked="checked"':''; ?> <?php echo !$field->can_be_modify?'disabled="disabled"':''; ?>  />
					</td>
					<td class="username column-username">
						<input name="list-field-required[]" type="checkbox" value="<?php echo  $field->id; ?>" <?php echo $field->required?'checked="checked"':''; ?> <?php echo !$field->can_be_modify?'disabled="disabled"':''; ?>  />
					</td>                    
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
        
        
		<p class="submit">
			<a id="btnUpdateFields" class="button-primary" href="#"><?php _e("Save",maven_translation_key()); ?></a>
            <a id="btnResetFields" class="button" href="#"><?php _e("Reset to defaults",maven_translation_key()); ?></a>
        </p>
        <p>
            <?php _e("You can drag and drop your fields to set the order",maven_translation_key()); ?>
        </p>
	
	<table id="tblForm" style="display: none;">
		<tbody id="inlineedit">

			<tr style="display: none;" class="inline-edit-row inline-edit-row-post inline-edit-post quick-edit-row quick-edit-row-post inline-edit-post" id="inline-edit">
				<td class="colspanchange" colspan="2">

					<fieldset class="inline-edit-col-left">
						<div class="inline-edit-col">
							<label>
								<span class="title"><?php _e("Name",maven_translation_key()); ?></span>
								<span class="input-text-wrap"><input type="text" value="" class="ptitle" id="category_name"></span>
							</label>
						</div>
					</fieldset>
					
					<p class="submit">
						<img alt="" src="<?php echo $loading_image?>" style="display: none;" class="waiting">
						<a id="save-field" class="button-primary save" title="<?php _e("Update",maven_translation_key()); ?>" href="#inline-edit" accesskey="s"><?php _e("Update",maven_translation_key()); ?></a>
                                                
                                                
						<a id="cancel-field" class="button-secondary cancel " title="<?php _e("Cancel",maven_translation_key()); ?>" href="#inline-edit" accesskey="c"><?php _e("Cancel",maven_translation_key()); ?></a>

						<br class="clear">
					</p>
				</td>
			</tr>
	</table>