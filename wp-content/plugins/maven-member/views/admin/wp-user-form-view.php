<?php if ($fields): ?>
<h3><?php _e("Maven Member Fields",maven_translation_key()) ?></h3>
<table class="form-table">
	
    
	<?php foreach($fields as $field): ?>
	<tr>
		<th scope="row" valign="top">
			<label for="maven-<?php echo $field->id; ?>"><?php echo $field->name; ?></label>
		</th>
		<td>
			<input class="regular-text" type="text" id="maven-<?php echo $field->id; ?>" name="maven-<?php echo $field->id; ?>"  value="<?php echo $field->value; ?>" />
		</td>
	</tr>
	<?php endforeach;?>
	
	
</table>
<?php endif;?>