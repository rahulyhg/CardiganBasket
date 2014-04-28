<p><?php _e("Welcome to the Maven Member Wizard! It will help you throw the process of protecting pages and posts!",maven_translation_key()); ?></p>

	<div id="poststuff" class="metabox-holder has-right-sidebar" >
		<div id="post-body">
			<div id="post-body-content" >
				<div class="postbox" style="width:60%;" id="pbRoles">
							<h3 class="hndle"><span> <?php _e("Role details",maven_translation_key()); ?></span></h3>
								<div class="inside" id="role-table">
									<table class="form-table" >
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
											<span><?php _e("Create new role and continue",maven_translation_key()); ?></span>
										</button>
									</p>
								</div>
								<div class="inside" id="show-new-role-name" style="display: none;">
									<p>
										<?php _e("Role",maven_translation_key()); ?>: <span class="role"></span>
									</p>
								</div>
					 </div>


					<div class="postbox" id="pbusers" style="width:60%;display:none;">
						<h3 class="hndle"><span> <?php _e("Users",maven_translation_key()); ?></span></h3>
						<div class="inside" >
						<p>
							<?php _e("Choose the users you want to assign a role",maven_translation_key()); ?>
						</p>
						 <table id="users_list" cellspacing="0" class="widefat fixed">
							<thead>
								<tr>
									<th class="manage-column column-key sortable asc" scope="col" style="width:10%;">
									</th>
									<th class="manage-column column-name sorted asc" scope="col">
										<a class="sorted asc" href="#"><span><?php _e("Name",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
									</th>
									<th class="manage-column column-key sortable asc" scope="col">
										<a class="sortable asc" href="#"><span><?php _e("Active",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
									</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th class="manage-column column-key sortable asc" scope="col" style="width:10%;">
									</th>
									<th class="manage-column column-name sorted asc" scope="col">
										<a class="sorted asc" href="#"><span><?php _e("Name",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
									</th>
									<th class="manage-column column-key sortable asc" scope="col">
										<a class="sortable asc" href="#"><span><?php _e("Active",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
									</th>
								</tr>
							</tfoot>

							<tbody class="list:user user-list" id="users">
								<?php foreach ($users as $user): ?>
								<tr id="user-row-<?php echo  $user->ID; ?>">
									<td class="username column-username" style="width:10%;">
										<input class="list-user-enabled" value="<?php echo  $user->ID; ?>" type="checkbox"  />
									</td>
									<td class="username column-username">
										<?php echo  $user->display_name; ?><br />

										<div id="inline-<?php echo  $user->ID; ?>" class="hidden">
											<div class="user_name"><?php echo  $user->display_name; ?></div>
											<div class="user_existing_roles"><?php echo implode(',', $user->roles_keys); ?></div>
											<div class="user_enabled"><?php echo  $user->enabled; ?></div>
										</div>
									</td>
									<td class="username column-username">
										<input  type="checkbox" <?php echo $user->enabled?'checked="checked"':''; ?> disabled="disabled" />
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<p class="submit" id="pSaveUsers">
							<button class="button-primary" value="save" name="btnSaveUsers" id="btnSaveUsers" type="submit">
								<span><?php _e("Add users to role and continue",maven_translation_key()); ?></span>
							</button>
						</p>
					</div>
				 </div>

				 <div class="postbox" id="pbcategories" style="width:60%;display: none;">
						<h3 class="hndle"><span> <?php _e("Categories",maven_translation_key()); ?></span></h3>
						
							<div class="inside">
								<p>
									<?php _e("Choose the categories you want to protect",maven_translation_key()); ?>
								</p>
								<table cellspacing="0" class="widefat fixed" >
									<thead>
										<tr>
											<th class="manage-column column-key sortable asc" scope="col" style="width:10%;">

											</th>
											<th class="manage-column column-name sorted asc" scope="col">
												<a href="#"><span><?php _e("Name",maven_translation_key()); ?></span></a>
											</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th class="manage-column column-key sortable asc" scope="col" style="width:10%;">

											</th>
											<th class="manage-column column-name sorted asc" scope="col">
												<a  href="#"><span><?php _e("Name",maven_translation_key()); ?></span></a>
											</th>
										</tr>
									</tfoot>
									<tbody class="list:user user-list" id="categories">
										<?php foreach ($categories as $category): ?>
										<tr id="category-row-<?php echo  $category->term_id; ?>">
											<td class="username column-username" style="width:10%;">
												<input class="list-category-enabled" value="<?php echo  $category->term_id; ?>" type="checkbox"  />
											</td>
											<td class="username column-username">
												<span class="row-title-category" ><?php echo  $category->name; ?></span><br />
												<div class="row-actions">

												</div>
												<div id="inline-<?php echo  $category->term_id; ?>" class="hidden">
													<div class="cat_name"><?php echo  $category->name; ?></div>
													<div class="cat_existing_roles"><?php echo implode(',', $category->roles_keys); ?></div>
												</div>
											</td>

										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
								<p class="submit">
									<button class="button-primary" value="save" name="btnSaveCategories" id="btnSaveCategories" type="submit">
										<span><?php _e("Save",maven_translation_key()); ?></span>
									</button>
								</p>
						</div>
				 </div>
				<div class="postbox" id="pbFinish" style="width:60%;display: none;">
					<h3 class="hndle"><span> <?php _e("Finish!",maven_translation_key()); ?> </span></h3>
					<div class="inside">
						<img  alt="ok" src="<?php echo $plugin_url."/images/user_ok.png" ?>" /> <span><?php _e("You have configured your WP Site!",maven_translation_key()); ?> &nbsp;&nbsp;<a href="/wp-admin/admin.php?page=maven_member-section-wizard"><?php _e("Use the wizard again!",maven_translation_key()); ?></a></span>
					</div>
				</div>

				
			</div>
		</div>
	</div>
