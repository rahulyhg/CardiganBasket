
(function($) {
	
	mavenImport ={
		init : function() {
					

					$('#btnImportUser').click(function(){
						mavenImport.importUsers();

						return false;
					});

					$('#btnRemvoeImportedUsers').click(function(){
						mavenImport.removeUsers();

						return false;
					});

					$('#btnUpload').click(function(){
						mavenImport.showUpload();

						return false;
					});
				},
				
		importUsers: function(){

			$("#waiting").show();
			var path;
			path = $("#file-name").val();

			role_ids = null;
			
			var active = jQuery("[name='default_active']:checked").val();
			
			jQuery("[name='default-role[]']:checked").each(function(){

					var value = jQuery(this).val();
					if(!role_ids)
						role_ids = value;
					else
						role_ids += ","+value;
			});

			mavenBase.post("import_import_users","default_active="+active+"&roles="+role_ids+"&file="+path ,function(data){
				
				$("#waiting").hide();
				if(data.result.error==''){
					$("#importedMessage").html("Imported users:");
					$("#importedUsersCount").html(data.result.count);
					if(data.result.notAdded){
						$("#importedErrorMessage").html("Rows have not been added:");
						var userNotAdded='';
						$.each(data.result.notAdded, function(index, value){
							userNotAdded+=""+value+", ";
						})
						$("#importedErrorUsersCount").html(userNotAdded);
					}
				}else{
					$("#importedErrorMessage").html("Error:");
					$("#importedErrorUsersCount").html(data.result.error);
				}
			});
		},

		removeUsers: function(){

			$("#waiting").show();

			mavenBase.post("import_remove_users","",function(data){

				$("#waiting").hide();
				$("#importedMessage").html("Removed users:");
				$("#importedUsersCount").html(data.result.count);
			});
		},

		showUpload: function() {

				window.send_to_editor = function(html) {
					
						 imgurl = $(html).attr('href');
						 
						 $('#file-name').val(imgurl);
						 tb_remove();
				};

				tb_show('Import file',"media-upload.php?post_id=0&type=file&TB_iframe=1");
				
			}
	};


$(document).ready(function(){
	mavenImport.init();
});
})(jQuery);

