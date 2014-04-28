
(function($) {
	
	mavenTemplates ={
		currentInlineID:0,
		init : function() {
					var qeRow = $('#inline-edit');
					
					// prepare the edit rows
					qeRow.keyup(function(e){
						if (e.which == 27)
							return mavenTemplates.cancelInLineEdit();
					});

					$('#cancel-template').click(function(){
						return mavenTemplates.cancelInLineEdit();
					});


					$(".maven-edit").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenTemplates.showInLineEdit(value);

						return false;
					})

					$("#save-template").click(function(){
						mavenTemplates.save();
					});

					
				},
		refresh: function()
		{
					$('#cancel-template').click(function(){
						return mavenTemplates.cancelInLineEdit();
					});


					$(".maven-edit").click(function(){
						value = jQuery(this).attr('href');
						value = value.replace("#","");
						mavenTemplates.showInLineEdit(value);

						return false;
					})

					$("#save-template").click(function(){
						mavenTemplates.save();
					});
		},

		showInLineEdit: function(id)
		{
			var t=this;
			t.cleanInLine();
			
			editRow = $("#inline-edit").clone(true);
						
			rowData = $('#inline-'+id);
			
			$("#template-row-"+id).hide().after(editRow);

			//Fill template name
			$("#template_name",editRow).html($(".temp_name",rowData).text());

			//Fill the roles
			roles = $(".temp_existing_roles",rowData).text()
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
				//$("#template-row-"+value).show();
				$("#edit-"+this.currentInlineID).hide();
				$('#template-row-'+this.currentInlineID).show();
			}

		},

		cancelInLineEdit: function(id){
			var t=this;
			t.cleanInLine();
		}, 

		add: function(){
					$("#poststuff").show('slow');
				},

	
		save: function()
		{
			var t = this,editRow,role_ids,reset;
			editRow = $("#edit-"+t.currentInlineID);

			role_ids = null;
			jQuery("[name='template-role[]']:checked",editRow).each(function(){

					var value = jQuery(this).val();
					if(!role_ids)
						role_ids = value;
					else
						role_ids += ","+value;
			});

						
			template = $("#template_name",editRow).text();

			reset = 0;
			//If there isnt' any role checked. Reset the template
			if (!role_ids)
				reset = 1;
			
			mavenBase.post("pages_save_template_roles","template="+t.currentInlineID+"&roles="+role_ids+"&reset="+reset,function(data){
				var row;
				
				row = $("#template-row-"+t.currentInlineID);
				
				$(".row-title-template",row).html(template);
				$(".temp_name",row).html(template);

				if (data.result && data.result.roles)
				{
					var existings_roles = '',existings_roles_names='';
					$.each(data.result.roles,function(){
						existings_roles = existings_roles==''?this.internal_name:existings_roles+","+this.internal_name;
						existings_roles_names = existings_roles_names==''?this.name:existings_roles_names+","+this.name;
					});

					$(".temp_existing_roles",row).html(existings_roles);
					$(".roles-names",row).html(existings_roles_names);

				}
				else
				{
					$(".temp_existing_roles",row).html('');
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


$(document).ready(function(){mavenTemplates.init();});
})(jQuery);