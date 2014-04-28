<div class="wrap">
    
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php echo $title; ?> <?php if ($add_new_button):?><a id="addNew" class="add-new-h2" href="#"><?php _e("Add New",maven_translation_key()); ?></a> <?php endif;?></h2>
    <br/>
    
    
    <div id="messageContainer" class="updated below-h2" style="display: none;">
        <p><?php _e("Info successfully updated",maven_translation_key()); ?></p>
    </div>

    <div id="errorMessageContainer" class="error below-h2" style="display: none;">
        <p><span id="errorMessage"></span></p>
    </div>

    
	<div class="wrap-content">
    <?php echo $view ?>
	</div>

<form id="maven-donate" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypalobjects.com/en_US/ES/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>