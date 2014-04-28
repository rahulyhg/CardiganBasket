
(function($) {
	
	mavenField ={
		currentInlineID:0,
		init : function() {
					

					$('#cancel-field').click(function(){
						return mavenField.cancelInLineEdit();
					});


					$(".maven-edit").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenField.showInLineEdit(value);

						return false;
					})

					$("#save-field").click(function(){
						mavenField.save();
					});

					$("#addNewField").click(function(){
						mavenField.add();
					});

					$("#btnCancelNewField").click(function(){
						mavenField.cancelNewField();
					});

					$("#btnSaveNewField").click(function(){
						mavenField.saveNewField();
					});

					$(".maven-remove").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenField.remove(value);
					});
					
				},
		refresh: function()
		{
					$('#cancel-field').click(function(){
						return mavenField.cancelInLineEdit();
					});


					$(".maven-edit").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenField.showInLineEdit(value);

						return false;
					})

					$("#save-field").click(function(){
						mavenField.save();
					});
                                        
                    $(".maven-remove").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenField.remove(value);
					});
		},

		showInLineEdit: function(id)
		{
			var t=this;
			t.cleanInLine();
			
			editRow = $("#inline-edit").clone(true);
						
			rowData = $('#inline-'+id);
			
			$("#field-row-"+id).hide().after(editRow);

			//Fill field name
			$("#field_name",editRow).val($(".cat_name",rowData).text());

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
				//$("#field-row-"+value).show();
				$("#edit-"+this.currentInlineID).hide();
				$('#field-row-'+this.currentInlineID).show();
			}

		},

		cancelInLineEdit: function(id){
			var t=this;
			t.cleanInLine();
		}, 

		add: function(){
					$("#poststuff").show('slow');
				},

		remove: function(cat_id){

				var txt = 'Are you sure you want to remove the field?<input type="hidden" id="field_id" name="field_id" value="'+ cat_id +'" />';

				jQuery.prompt(txt,{
					buttons:{Delete:true, Cancel:false},
					callback: function(v,m,f){

						if(v){
							var value = f.field_id;

							mavenBase.post("categories_delete","cat_id="+value,function(data){
								$("#field-row-"+cat_id).fadeOut('slow',function(){
									$(this).remove();
								});
							});

						}
						else{}

					}
				});
					
					
					
				},

		saveNewField: function(){

					var name,role_ids;
					name = $("#new-field-name").val();

					role_ids = '';
					jQuery("[name='new-field-role[]']:checked").each(function(){
							var value = jQuery(this).val();
							if(!role_ids)
								role_ids = value;
							else
								role_ids += ","+value;
					});
					
					mavenBase.post("categories_add","cat_name="+name+"&roles="+role_ids,function(data){
						
						mavenField.cancelNewField();

						var row;
						row = $("#categories > tr:first").clone();

						// Replace the id, with the new one.
						row.attr('id',"field-row-"+data.result.id);
						$(".hidden",row).attr('id',"inline-"+data.result.id);

						$(".maven-edit",row).attr('href',"#"+data.result.id);
						$(".maven-remove",row).attr('href',"#"+data.result.id);

						$(".row-title-field",row).html(data.result.name);
						$(".cat_name",row).html(data.result.name);
						
						if (data.result && data.result.roles)
						{
							var existings_roles = '',existings_roles_names='';
							$.each(data.result.roles,function(){
								existings_roles = existings_roles==''?this.internal_name:existings_roles+","+this.internal_name;
								existings_roles_names = existings_roles_names==''?this.name:existings_roles_names+","+this.name;
							});

							$(".cat_existing_roles",row).html(existings_roles);
							$(".roles-names",row).html(existings_roles_names);

						}
						else
						{
							$(".cat_existing_roles",row).html('');
							$(".roles-names",row).html('');
						}


						$("#categories").append(row);
                                                
                                                

						mavenField.refresh();
					});

					

				},

		cancelNewField: function(){
					
					$("#poststuff").hide('slow');
					$("#new-field-name").val('');
					$("[name='new-field-role[]']").each(function(){
						$(this).attr('checked',false);
					});

				},


		save: function()
		{
			var t = this,editRow,role_ids,reset;
			editRow = $("#edit-"+t.currentInlineID);

			role_ids = null;
			jQuery("[name='field-role[]']:checked",editRow).each(function(){

					var value = jQuery(this).val();
					if(!role_ids)
						role_ids = value;
					else
						role_ids += ","+value;
			});

						
			cat_name = $("#field_name",editRow).val();

			reset = 0;
			//If there isnt' any role checked. Reset the field
			if (!role_ids)
				reset = 1;
			
			mavenBase.post("categories_update","cat_id="+t.currentInlineID+"&cat_name="+cat_name+"&roles="+role_ids+"&reset="+reset,function(data){
				var row;
				
				row = $("#field-row-"+t.currentInlineID);
				
				$(".row-title-field",row).html(cat_name);
				$(".cat_name",row).html(cat_name);

				if (data.result && data.result.roles)
				{
					var existings_roles = '',existings_roles_names='';
					$.each(data.result.roles,function(){
						existings_roles = existings_roles==''?this.internal_name:existings_roles+","+this.internal_name;
						existings_roles_names = existings_roles_names==''?this.name:existings_roles_names+","+this.name;
					});

					$(".cat_existing_roles",row).html(existings_roles);
					$(".roles-names",row).html(existings_roles_names);

				}
				else
				{
					$(".cat_existing_roles",row).html('');
					$(".roles-names",row).html('');
				}
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


$(document).ready(function(){mavenField.init();});
})(jQuery);