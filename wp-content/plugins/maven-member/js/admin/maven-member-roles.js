
(function($) {

	mavenRole ={
		currentInlineID:0,
		init : function() {
					var qeRow = $('#inline-edit');

					// prepare the edit rows
					qeRow.keyup(function(e){
						if (e.which == 27)
							return mavenRole.cancelInLineEdit();
					});

					$('#cancel-role').click(function(){
						return mavenRole.cancelInLineEdit();
					});


					$(".maven-edit").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenRole.showInLineEdit(value);

						return false;
					})

					$("#save-role").click(function(){
						mavenRole.save();
					});

					$("#addNew").click(function(){
						mavenRole.add();
					});

					$("#btnCancelNewRole").click(function(){
						mavenRole.cancelNewRole();
					});

					$("#btnSaveNewRole").click(function(){
						mavenRole.saveNewRole();
					});

					$(".maven-remove").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenRole.remove(value);

						return false;
					});
				},

		showInLineEdit: function(id)
		{
			var t=this;
			t.cleanInLine();

			editRow = $("#inline-edit").clone(true);

			rowData = $('#inline-'+id);

			$("#role-row-"+id).hide().after(editRow);

			//Fill role name
			$("#role_name",editRow).val($(".role_name",rowData).text());

			//Fill the roles
			roles = $(".cat_existing_roles",rowData).text()
			if (roles){

				roles = roles.split(",");
				$.each(roles,function(){
					$("#in-role-"+this,editRow).attr('checked', true);
				});
			}

			$(editRow).attr('id', 'edit-'+id).addClass('inline-editor').show();

			this.currentInlineID = id;
		},

		cleanInLine: function(){
			if (this.currentInlineID)
			{
				//$("#role-row-"+value).show();
				$("#edit-"+this.currentInlineID).hide();
				$('#role-row-'+this.currentInlineID).show();
			}

		},

		cancelInLineEdit: function(id){
			var t=this;
			t.cleanInLine();
		},

		add: function(){
					$("#poststuff").show('slow');
				},

		remove: function(role){

				var txt = 'Are you sure you want to remove the role?<input type="hidden" id="role_id" name="role_id" value="'+ role +'" />';

				jQuery.prompt(txt,{
					buttons:{Delete:true, Cancel:false},
					callback: function(v,m,f){

						if(v){
							var value = f.role_id;

							mavenBase.post("roles_remove","role_name="+value,function(data){
								$("#role-row-"+value).fadeOut('slow',function(){
									$(this).remove();
								});
							});

						}
						else{}

					}
				});



				},

		saveNewRole: function(){

					var name;
					name = $("#new-role-name").val();

					mavenBase.post("roles_add","role_name="+name,function(data){

						mavenRole.cancelNewRole();

						var row;
						row = $("#roles > tr:first").clone();

						// Replace the id, with the new one.
						row.attr('id',"role-row-"+data.result.role_name);
						$(".hidden",row).attr('id',"inline-"+data.result.role_name);

						$(".maven-edit",row).attr('href',"#"+data.result.role_name);
						$(".maven-remove",row).attr('href',"#"+data.result.role_name);
                                                $role_val = "[mvn-block roles='"+data.result.role_name+"'] My protected content [/mvn-block]";
                                                    
                                                $(".row-short-role",row).html($role_val);
                                                

						$(".row-title-role",row).html(data.result.display_name);
						$(".field_name",row).html(data.result.name);

						$("#roles").append(row);

						mavenRole.refresh();
					});
				},
		refresh: function()
		{
					$('#cancel-role').click(function(){
						return mavenRole.cancelInLineEdit();
					});


					$(".maven-edit").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenRole.showInLineEdit(value);

						return false;
					})

					$("#save-role").click(function(){
						mavenRole.save();
					});

                    $(".maven-remove").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenRole.remove(value);

						return false;
					});
		},


		cancelNewRole: function(){

					$("#poststuff").hide('slow');
					$("#new-role-name").val('');
					$("[name='new-role-role[]']").each(function(){
						$(this).attr('checked',false);
					});

				},


		save: function()
		{
			var t = this,editRow,role_name;
			editRow = $("#edit-"+t.currentInlineID);

			role_name = $("#role_name",editRow).val();

			mavenBase.post("roles_update","role_id="+t.currentInlineID,function(data){
//				var row;
//
				row = $("#role-row-"+t.currentInlineID);
//
//				$(".row-title",row).html(role_name);
//
//				if (data.result && data.result.roles)
//				{
//					var existings_roles = '',existings_roles_names='';
//					$.each(data.result.roles,function(){
//						existings_roles = existings_roles==''?this.internal_name:existings_roles+","+this.internal_name;
//						existings_roles_names = existings_roles_names==''?this.name:existings_roles_names+","+this.name;
//					});

//					$(".cat_existing_roles",row).html(existings_roles);
//					$(".roles-names",row).html(existings_roles_names);

//				}
				//Save roles

				editRow.fadeOut().remove();
				$(row).fadeIn().show();
				//t.cleanInLine();

			});
		},

		getId : function(o) {
			var id = $(o).closest('tr').attr('id'),
				parts = id.split('-');
			return parts[parts.length - 1];
		}

	};


$(document).ready(function(){mavenRole.init();});
})(jQuery);