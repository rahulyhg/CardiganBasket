<tr class="form-field">
    <th scope="row" valign="top">
        <label for="cat_Image_url"><?php _e('Maven roles',maven_translation_key());?></label>
		<?php maven_hidden_input_key(); ?>
    </th>
    <td>
        <ul>
        <?php foreach ($roles as $role): ?>
            <li><span><input type="checkbox" name="maven-role[]" style="width:20px;" class="maven-check" <?php echo $role->selected ? "checked='checked'" : ""; ?> value="<?php echo $role->internal_name ?>" />
                <?php echo $role->name ?></span>
                </li>
        <?php endforeach; ?>
        </ul>
    </td>
</tr>
