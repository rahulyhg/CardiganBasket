
(function($) {
	
	mavenWizard ={
                
		currentInlineID:0,
		newRole : '',
		init : function() {
                                        mavenBase.showAutoMessage = false;

					$('#btnSaveNewRole').click(function(){
						mavenWizard.saveNewRole();
					});

					$('#btnSaveUsers').click(function(){
						mavenWizard.asignRoles();
					});

					$('#btnSaveCategories').click(function(){
						mavenWizard.asignRolesToCategories();
					});

					
				},
				
		saveNewRole: function(){

					var name;
					name = $("#new-role-name").val();

					mavenBase.post("roles_add","role_name="+name,function(data){

						mavenWizard.showNewRole(name,data.result.role_name);
					});
				},
		showNewRole : function(display_name,role_name){

			$("#role-table").hide('slow');
			$("#show-new-role-name").find('.role').text(display_name);
			$("#show-new-role-name").show('slow');

			$("#pbusers").show('slow');

			mavenWizard.newRole = role_name;
			
		},
		asignRoles: function(){

					jQuery(".list-user-enabled:checked").each(function(){
							var value = jQuery(this).val();

							mavenBase.post("users_add_role_to_user","user_id="+value+"&roles="+mavenWizard.newRole,function(data){

							});
					});

					jQuery(".list-user-enabled").each(function(){
						jQuery(this).attr('disabled', 'disabled');
					})
					
					$("#pSaveUsers").hide();
					$("#pbcategories").show('slow');
		},

		asignRolesToCategories: function(){

					jQuery(".list-category-enabled:checked").each(function(){
							var value = jQuery(this).val();

							mavenBase.post("categories_add_roles","cat_id="+value+"&roles="+mavenWizard.newRole,function(data){

							});
					});

					$("#pbcategories").hide('slow');
					$("#pbusers").hide('slow');
					$("#pbRoles").hide('slow');

					$("#pbFinish").show();

		}

				
	};


$(document).ready(function(){mavenWizard.init();});
})(jQuery);