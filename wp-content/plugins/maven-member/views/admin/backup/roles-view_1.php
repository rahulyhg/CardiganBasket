<div class="wrap">

    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php echo $title ?> </h2>
<br/>

<div id="maven-roles-container">
    <ul class="mvn-listing" style="float:left">
	<li >
	    <h3>Existing roles</h3>

	    <ul id="existing-roles">
		<?php foreach($roles as $role): ?>
			<li id="maven-container-<?php echo $role->internal_name; ?>" class="maven-normal maven-highlight">
		    <div class="buttons">
				<a href="#" class="maven-add-users" >
					<input type="hidden" value="<?php echo $role->internal_name; ?>" />
					<img  alt="Add users" src="<?php echo $plugin_url ?>images/users.png">
				</a>
				<a href="#" class="maven-remove-role" >
					<input type="hidden" value="<?php echo $role->internal_name; ?>" />
					<img  alt="Remove" src="<?php echo $plugin_url ?>images/delete.png">
				</a>
		    </div>
		    <div class="maven-edit-inplace" id="<?php echo $role->internal_name; ?>"><?php echo $role->name; ?></div>
		    
		</li>
	       <?php endforeach; ?>

	    </ul>
	</li>
	<li>
	    <input class="text" id="roleName" />
	    <a id="btnAddRole" class="button add-new-h2" href="#">Add New</a>
	</li>
    </ul>

	<ul id="existing-users-container" class="mvn-listing" style="display:none;float:right">
		<li >
			<h3>Existing users</h3>

			<ul id="existing-users" >

			</ul>
		</li>
		<li >
			<a id="btnUpdateUsers" class="button add-new-h2"   href="#">Save</a>
			<a id="btnCancelAddUsers" class="button add-new-h2"   href="#">Cancel</a>
		</li>
    </ul>
</div>

</div>