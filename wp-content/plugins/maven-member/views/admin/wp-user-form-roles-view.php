<?php if ($mvn_member_roles): ?>
<h3><?php _e("Maven Member Roles", 'maven-member',maven_translation_key()) ?></h3>
	<?php if($is_admin): ?>
	<p><?php _e('<strong>Note:</strong> Administrators has always access to all posts and pages.',maven_translation_key()); ?></p>
	<?php else: ?>
	<table class="form-table">
		<?php foreach($mvn_member_roles as $mvn_member_role): ?>
		<tr>
			<th scope="row" valign="top">
				<label for="mvn_member_roles"><?php echo $mvn_member_role->name; ?></label>
			</th>
			<td>
				<input class="regular-text" type="checkbox" name="mvn_member_roles[]" <?php echo $mvn_member_role->selected ? 'checked="checked"' : '';?> value="<?php echo $mvn_member_role->internal_name; ?>" />
			</td>
		</tr>
		<?php endforeach;?>

	</table>
	<?php endif; ?>
<?php endif;?>