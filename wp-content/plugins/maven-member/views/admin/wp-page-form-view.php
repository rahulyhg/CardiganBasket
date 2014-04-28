<?php foreach($roles as $role): ?>
	<input type="checkbox" name="maven-page-role[]" <?php echo $role->selected?"checked='checked'":""; ?> value="<?php echo $role->internal_name ?>" />
	<span><?php echo $role->name ?></span>
<?php endforeach; ?>
  