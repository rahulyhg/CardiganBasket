
(function($) {
	
	mavenCategory ={
		currentInlineID:0,
		init : function() {
					var qeRow = $('#inline-edit');
					
					// prepare the edit rows
					qeRow.keyup(function(e){
						if (e.which == 27)
							return mavenCategory.cancelInLineEdit();
					});

					$('#cancel-category').click(function(){
						return mavenCategory.cancelInLineEdit();
					});


					$(".maven-edit").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenCategory.showInLineEdit(value);

						return false;
					})

					$("#save-category").click(function(){
						mavenCategory.save();
					});

					$("#addNew").click(function(){
						mavenCategory.add();
					});

					$("#btnCancelNewCategory").click(function(){
						mavenCategory.cancelNewCategory();
					});

					$("#btnSaveNewCategory").click(function(){
						mavenCategory.saveNewCategory();
					});

					$(".maven-remove").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenCategory.remove(value);
					});
					
				},
		refresh: function()
		{
					$('#cancel-category').click(function(){
						return mavenCategory.cancelInLineEdit();
					});


					$(".maven-edit").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenCategory.showInLineEdit(value);

						return false;
					})

					$("#save-category").click(function(){
						mavenCategory.save();
					});
                                        
                                        $(".maven-remove").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenCategory.remove(value);
					});
		},

		showInLineEdit: function(id)
		{
			var t=this;
			t.cleanInLine();
			
			editRow = $("#inline-edit").clone(true);
						
			rowData = $('#inline-'+id);
			
			$("#category-row-"+id).hide().after(editRow);

			//Fill category name
			$("#category_name",editRow).val($(".cat_name",rowData).text());

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
				//$("#category-row-"+value).show();
				$("#edit-"+this.currentInlineID).hide();
				$('#category-row-'+this.currentInlineID).show();
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

				var txt = 'Are you sure you want to remove the category?<input type="hidden" id="category_id" name="category_id" value="'+ cat_id +'" />';

				jQuery.prompt(txt,{
					buttons:{Delete:true, Cancel:false},
					callback: function(v,m,f){

						if(v){
							var value = f.category_id;

							mavenBase.post("categories_delete","cat_id="+value,function(data){
								$("#category-row-"+cat_id).fadeOut('slow',function(){
									$(this).remove();
								});
							});

						}
						else{}

					}
				});
					
					
					
				},

		saveNewCategory: function(){

					var name,role_ids;
					name = $("#new-category-name").val();

					role_ids = '';
					jQuery("[name='new-category-role[]']:checked").each(function(){
							var value = jQuery(this).val();
							if(!role_ids)
								role_ids = value;
							else
								role_ids += ","+value;
					});
					
					mavenBase.post("categories_add","cat_name="+name+"&roles="+role_ids,function(data){
						
						mavenCategory.cancelNewCategory();

						var row;
						row = $("#categories > tr:first").clone();

						// Replace the id, with the new one.
						row.attr('id',"category-row-"+data.result.id);
						$(".hidden",row).attr('id',"inline-"+data.result.id);

						$(".maven-edit",row).attr('href',"#"+data.result.id);
						$(".maven-remove",row).attr('href',"#"+data.result.id);

						$(".row-title-category",row).html(data.result.name);
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
                                                
                                                

						mavenCategory.refresh();
					});

					

				},

		cancelNewCategory: function(){
					
					$("#poststuff").hide('slow');
					$("#new-category-name").val('');
					$("[name='new-category-role[]']").each(function(){
						$(this).attr('checked',false);
					});

				},


		save: function()
		{
			var t = this,editRow,role_ids,reset;
			editRow = $("#edit-"+t.currentInlineID);

			role_ids = null;
			jQuery("[name='category-role[]']:checked",editRow).each(function(){

					var value = jQuery(this).val();
					if(!role_ids)
						role_ids = value;
					else
						role_ids += ","+value;
			});

						
			cat_name = $("#category_name",editRow).val();

			reset = 0;
			//If there isnt' any role checked. Reset the category
			if (!role_ids)
				reset = 1;
			
			mavenBase.post("categories_update","cat_id="+t.currentInlineID+"&cat_name="+cat_name+"&roles="+role_ids+"&reset="+reset,function(data){
				var row;
				
				row = $("#category-row-"+t.currentInlineID);
				
				$(".row-title-category",row).html(cat_name);
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


$(document).ready(function(){mavenCategory.init();});
})(jQuery);