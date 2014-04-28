
(function($) {
	
    mavenField ={
        currentInlineID:0,
        init : function() {
					
            $("#tblFields tbody").sortable().disableSelection();

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

            $("#btnUpdateFields").click(function(){
                mavenField.updateFields();
            });


            $("#addNew").click(function(){
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

                return false;
            });
            $("#btnResetFields").click(function(){
                                
                mavenField.resetFields();

                return false;
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

                return false;
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

        remove: function(id){

            var txt = 'Are you sure you want to remove the field?<input type="hidden" id="field_id" name="field_id" value="'+ id +'" />';

            jQuery.prompt(txt,{
                buttons:{
                    Delete:true, 
                    Cancel:false
                },
                callback: function(v,m,f){

                    if(v){
                        var value = f.field_id;

                        mavenBase.post("registration_remove_field","field_id="+value,function(data){
                            $("#field-row-"+value).fadeOut('slow',function(){
                                $(this).remove();
                            });
                        });

                    }
                    else{}

                }
            });
					
        },
        resetFields: function(id){

            var txt = 'Are you sure you want to reset fields?';

            jQuery.prompt(txt,{
                buttons:{
                    Delete:true, 
                    Cancel:false
                },
                callback: function(v,m,f){

                    if(v){
                        var value = f.field_id;

                        mavenBase.post("registration_reset_fields","",function(data){
                            location.reload();
                        });

                    }
                    else{}

                }
            });
					
        },

        saveNewField: function(){

            var name,display,required;
            name = $("#new-field-name").val();
            display = $("#new-display").attr('checked');
            required = $("#new-required").attr('checked');
            
					
            mavenBase.post("registration_insert_field","name="+name+"&display="+display+"&required="+required,function(data){
						
                mavenField.cancelNewField();
						
                var row;
                row = $("#fields > tr:first").clone();

                // Replace the id, with the new one.
                row.attr('id',"field-row-"+data.result.id);
                $(".hidden",row).attr('id',"inline-"+data.result.id);

                $(".maven-edit",row).attr('href',"#"+data.result.id);
                $(".maven-remove",row).attr('href',"#"+data.result.id);
                $(".list-user-enabled",row).attr('checked','');
                $(".row-field-order",row).val('99999');

                $(".row-title-field",row).html(data.result.name);
                $(".field_name",row).html(data.result.name);
						
                $("#fields").append(row);
                                                
                mavenField.refresh();
            });

					

        },

        cancelNewField: function(){
					
            $("#poststuff").hide('slow');
            $("#new-field-name").val('');
            $("#new-display").attr('checked','checked');
        },

        updateFields: function()
        {
            var i=0;
            var fields_to_display = '';
            var order_fields;
                        
            $("[name='list-field-display[]']:checked").each(function(){
                var value = jQuery(this).val();
                if(!fields_to_display)
                    fields_to_display = value;
                else
                    fields_to_display += ","+value;
            });
                        
            order_fields = '';
            $("[name='list-field-display[]']").each(function(){
                var value = jQuery(this).val();
                if(!order_fields)
                    order_fields = value+";"+i;
                else
                    order_fields += ","+value+";"+i;
                i++;
            });
            
            checked_fields = '';
            $("[name='list-field-required[]']:checked").each(function(){
                var value = jQuery(this).val();
                if(!checked_fields)
                    checked_fields = value;
                else
                    checked_fields += ","+value;
            });

                        
            mavenBase.post("registration_update_fields_to_display","fields="+fields_to_display+"&order_fields="+order_fields+"&required_fields="+checked_fields,function(data){
                mavenBase.show_message("Fields saved");
            });

        },
		
		

        getId : function(o) {
            var id = $(o).closest('tr').attr('id'),
            parts = id.split('-');
            return parts[parts.length - 1];
        }
				
    };


    $(document).ready(function(){
        mavenField.init();
    });
})(jQuery);