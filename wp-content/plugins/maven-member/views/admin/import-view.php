<div class="wrap">

   <div id="poststuff" class="metabox-holder has-right-sidebar" >
		<div id="post-body">
			<div id="post-body-content">
				<div class="postbox">
							<h3 class="hndle"><span> <?php _e("Import users",maven_translation_key()); ?></span></h3>
								<div class="inside">
									<table class="form-table">
										<tbody>
											<tr>
												<th scope="row">
													<label for="new-category-name"><?php _e("File",maven_translation_key()); ?></label>
												</th>
												<td>
													<input type="text" value="" name="file-name" id="file-name">
													<button class="button" value="removeImport" name="btnUpload" id="btnUpload" type="button">
														<span><?php _e("Upload file",maven_translation_key()); ?></span>
													</button>
													<span><a href="<?php echo WBM_MEMBER_PLUGIN_URL."files/example.csv";?>" target="blank"><?php _e("Download CSV example",maven_translation_key()); ?></a></span>
												</td>
											</tr>
											<tr>
												<th scope="row">
													<label for="new-category-name"><?php _e("Default Roles",maven_translation_key()); ?></label>
												</th>
												<td>
													<ul id="default-roles">
														<?php foreach($roles as $role): ?>
														<li  id="addrole-<?php echo $role->internal_name; ?>">
															<label class="selectit"><input type="checkbox" id="in-role-<?php echo $role->internal_name; ?>" name="default-role[]" value="<?php echo $role->internal_name; ?>"><?php echo $role->name; ?></label>
														</li>
														<?php endforeach;?>
													</ul>
												</td>
											</tr>
											<tr>
												<th scope="row">
													<label for="new-category-name"><?php _e("Default Active",maven_translation_key()); ?></label>
												</th>
												<td>
													<input type="checkbox" id="default_active" name="default_active" value="1" checked='checked'>
												</td>
											</tr>
											<tr>
												<td id="importedMessage">
													
												</td>
												<td>
													<span id="importedUsersCount"></span>
												</td>
											</tr>
											<tr>
												<td id="importedErrorMessage" valign="top">
													
												</td>
												<td>
													<span id="importedErrorUsersCount"></span>
												</td>
											</tr>
										</tbody>
									</table>
									<p class="submit">
										<img id="waiting" alt="" src="<?php echo $loading_image?>" style="display: none;" class="waiting">
										<button class="button-primary" value="import" name="btnSaveNewCategory" id="btnImportUser" type="submit">
											<span><?php _e("Import users",maven_translation_key()); ?></span>
										</button>
										<button class="button" value="removeImport" name="btnRemvoeImportedUsers" id="btnRemvoeImportedUsers" type="submit">
											<span><?php _e("Remove imported users",maven_translation_key()); ?></span>
										</button>
									</p>
							</div>
					 </div>
			</div>
		</div>
	</div>
	

</div>