<?php echo $nonce_field ?>
<div id="poststuff" class="metabox-holder has-right-sidebar" style="display:none">
    <div id="post-body">
        <div id="post-body-content">
            <div class="postbox">
                <h3 class="hndle"><span><?php _e('Category details',maven_translation_key()); ?></span></h3>
                <div class="inside">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="new-category-name"><?php _e("Name",maven_translation_key()); ?></label>
                                </th>
                                <td>
                                    <input type="text" value="" name="new-category-name" id="new-category-name">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="web_site"><?php _e("Roles",maven_translation_key()); ?></label>
                                </th>
                                <td>
                                    <ul >
                                        <?php foreach ($roles as $role): ?>
                                            <li  id="addrole-<?php echo $role->internal_name; ?>">
                                                <label class="selectit"><input type="checkbox" id="in-role-<?php echo $role->internal_name; ?>" name="new-category-role[]" value="<?php echo $role->internal_name; ?>"><?php echo $role->name; ?></label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="submit">
                        <button class="button-primary" value="save" name="btnSaveNewCategory" id="btnSaveNewCategory" type="submit">
                            <span><?php _e("Save",maven_translation_key()); ?></span>
                        </button>
                        <a class="button" id="btnCancelNewCategory" href="#"><?php _e("Cancel",maven_translation_key()); ?></a>
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
            <th class="manage-column column-key sortable asc" scope="col">
                <a class="sortable asc" href="#"><span><?php _e("Roles",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>

        </tr>
    </thead>
    <tfoot>
        <tr>
            <th class="manage-column column-name sorted asc" scope="col">
                <a class="sorted asc" href="#"><span><?php _e("Name",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
            <th class="manage-column column-key sortable asc" scope="col">
                <a class="sortable asc" href="#"><span><?php _e("Roles",maven_translation_key()); ?></span><span class="sorting-indicator"></span></a>
            </th>
        </tr>
    </tfoot>

    <tbody class="list:user user-list" id="categories">
        <?php foreach ($categories as $category): ?>
            <tr id="category-row-<?php echo $category->term_id; ?>">
                <td class="username column-username">
                    <span class="row-title-category" ><?php echo $category->name; ?></span><br />
                    <div class="row-actions">
                        <a class="maven-edit" href="#<?php echo $category->term_id; ?>"><?php _e("Edit",maven_translation_key()); ?></a>
                        <?php if (!$category->is_system): ?>
			<a class="maven-remove confirm" href="#<?php echo $category->term_id; ?>">| <?php _e("Delete",maven_translation_key()); ?></a>
                        <?php endif; ?>
                    </div>
                    <div id="inline-<?php echo $category->term_id; ?>" class="hidden">
                        <div class="cat_name"><?php echo $category->name; ?></div>
                        <div class="cat_existing_roles"><?php echo implode(',', $category->roles_keys); ?></div>
                    </div>
                </td>
                <td class="username column-username">
                    <span class="roles-names"><?php echo $category->roles_names ?></span>
                </td>
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
                            <span class="input-text-wrap"><input type="text" value="" class="ptitle" id="category_name"></span>
                        </label>
                    </div>
                </fieldset>
                <fieldset class="inline-edit-col-center inline-edit-categories">
                    <div class="inline-edit-col">
                        <ul class="cat-checklist category-checklist">
                            <?php foreach ($roles as $role): ?>
                                <li  id="role-<?php echo $role->internal_name; ?>">
                                    <label class="selectit"><input type="checkbox" id="in-role-<?php echo $role->internal_name; ?>" name="category-role[]" value="<?php echo $role->internal_name; ?>"><?php echo $role->name; ?></label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </fieldset>
                <p class="submit inline-edit-save">
                    <img alt="" src="<?php echo $loading_image ?>" style="display: none;" class="waiting">
                    <a id="save-category" class="button-primary save " title="<?php _e("Update",maven_translation_key()); ?>" href="#inline-edit" accesskey="s"><?php _e("Update",maven_translation_key()); ?></a>
                    <a id="cancel-category" class="button-secondary cancel " title="<?php _e("Cancel",maven_translation_key()); ?>" href="#inline-edit" accesskey="c"><?php _e("Cancel",maven_translation_key()); ?></a>

                    <br class="clear">
                </p>
            </td>
        </tr>
</table>
