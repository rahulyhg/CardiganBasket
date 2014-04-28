<?php

$root = realpath($_SERVER['DOCUMENT_ROOT']);
if (!$root) $root = realpath(substr(	// Attempt to trace document root by script pathing
				$_SERVER['SCRIPT_FILENAME'],0,
				strpos($_SERVER['SCRIPT_FILENAME'],$_SERVER['SCRIPT_NAME'])
			));
require_once($root."/wp-load.php");
require_once(ABSPATH.'/wp-admin/admin.php');

$roles = maven_manager()->get_roles_class()->get_roles();
//http://tinymce.moxiecode.com/forum/viewtopic.php?id=24383
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<style type="text/css">
		#existing-roles{
			list-style-type: none;
		}
	</style>
	<script language="javascript" type="text/javascript" src="<?php echo maven_manager()->get_site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo maven_manager()->get_site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo maven_manager()->get_site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo maven_manager()->get_site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo maven_manager()->get_site_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo maven_manager()->get_plugin_url(); ?>/js/maven-member-admin.js"></script>

	<script type="text/javascript">

		function show(){
			//alert(tinyMCEPopup.getWindowArg("some_custom_arg"));

			
			//alert(window.tinyMCE.selection.getContent({format : 'text'}));
		}

		(jQuery(function(){
			
			jQuery(".maven-check-image").click(function(){

							src = jQuery(this).attr("src");
							maven_toggleCheckImage(src,this);
					});


			jQuery("#btnPopUpAddRole").click(function(){

					ids = null;

					jQuery("#existing-roles").children().each(function(){
						img = jQuery(this).find('img').attr('src');

						if (maven_getCheckImage(true)==img)
						{
							if(!ids)
								ids = this.id;
							else
								ids += ","+this.id;
						}
					});


					tag = '[mvn roles="'+ids+'"]';
					end_tag = '[/mvn]';
					content = tag+window.tinyMCE.selectedInstance.selection.getContent()+end_tag;

					if(window.tinyMCE) {
						window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, content);
						tinyMCEPopup.editor.execCommand('mceRepaint');
						tinyMCEPopup.close();
					}
			});

		}));

		

	</script>
  </head>
  <body>
	  <h3>Roles</h3>
	   <ul id="existing-roles">
			<?php foreach($roles as $role): ?>
			<li id="<?php echo $role->internal_name; ?>" class="maven-normal maven-highlight">
		    <img class="maven-check-image" alt="Users" src="<?php echo maven_manager()->get_plugin_url(); ?>/images/unchecked.png"><span ><?php echo $role->name; ?></span>

			</li>
	       <?php endforeach; ?>

	    </ul>

	    <a id="btnPopUpAddRole" class="button add-new-h2" href="#">Add tag</a>
  </body>
</html>
