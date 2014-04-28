jQuery.maven = {};
//TODO: The plugin url must be dynamic
jQuery.maven.plugin_url = "/wp-content/plugins/maven-member/";
jQuery.maven.plugin_images_url = "/wp-content/plugins/maven-member/images/";
jQuery.maven.roles = {};
jQuery.maven.users = {};


jQuery.maven.call_ajax = function (action,args,result_fnc)
{
    jQuery.ajax({
	url:"/wp-admin/admin-ajax.php",
	type:'POST',
	dataType: 'json',
	data:'action=maven_'+action+"&"+args,
	success:function(result)
	     {
			 
			 if (result_fnc)
				result_fnc(result);
	     }

     });
}


maven_cleanList = function(list)
{
	jQuery(list).children().each(function(){
			jQuery(this).css('background-color','#fff');
		})
}


maven_toggleCheckImage = function(src,obj)
{
	if (src.indexOf('unchecked', 0)>0)
		jQuery(obj).attr("src",maven_getCheckImage(true));
	else
		jQuery(obj).attr("src",maven_getCheckImage(false));
}

maven_getCheckImage = function(checked)
{
	if (checked)
		return jQuery.maven.plugin_images_url+"checked.png";
	else
		return jQuery.maven.plugin_images_url+"unchecked.png";
}
