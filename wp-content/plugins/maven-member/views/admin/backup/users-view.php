<div class="wrap">

    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php echo $title ?> </h2>
<br/>

<div id="maven-roles-container">
    <ul class="mvn-listing" style="float:left">
		<li >
			<h3>Existing users</h3>

			<ul id="existing-users">
			<?php foreach($users as $user): ?>
				<li id="maven-container-<?php echo $user->ID; ?>" class="maven-normal maven-highlight">
				<div class="buttons">
					<a href="#" class="maven-reset-roles" >
						<input type="hidden" value="<?php echo $user->ID; ?>" />
						<img  alt="Reset" src="<?php echo $plugin_url ?>images/reset.png">
					</a>
					<a href="#" class="maven-show-roles" >
						<input type="hidden" value="<?php echo $user->ID; ?>" />
						<img  alt="Add users" src="<?php echo $plugin_url ?>images/users.png">
					</a>
					<a href="#" class="maven-enabled-user" >
						<input type="hidden" value="<?php echo $user->ID; ?>" />
						<?php if($user->enabled): ?>
						<img  alt="Enable user" src="<?php echo $plugin_url ?>images/user_ok.png">
						<?php else: ?>
						<img  alt="Enable user" src="<?php echo $plugin_url ?>images/user_disabled.png">
						<?php endif; ?>
					</a>
				</div>
				<div class="maven-edit-inplace" id="<?php echo $user->ID; ?>"><?php echo $user->display_name; ?></div>

				</li>
			   <?php endforeach; ?>

			</ul>
		</li>
    </ul>

	<ul id="existing-roles-container" class="mvn-listing" style="display:none;float:right">
		<li >
			<h3>Existing roles</h3>

			<ul id="existing-roles" >

			</ul>
		</li>
		<li >
			<a id="btnUpdateUsers" class="button add-new-h2"   href="#">Save</a>
			<a id="btnCancelAddRoles" class="button add-new-h2"   href="#">Cancel</a>
		</li>
    </ul>
</div>

</div>