
(function($) {
	
    mavenUser ={
        currentInlineID:0,
        init : function() {
            var qeRow = $('#inline-edit');
					
            // prepare the edit rows
            qeRow.keyup(function(e){
                if (e.which == 27)
                    return mavenUser.cancelInLineEdit();
            });

            $('#cancel-user').click(function(){
                return mavenUser.cancelInLineEdit();
            });


            $(".maven-edit").click(function(){
                value = jQuery(this).attr('href');
                value = value.replace("#","");
                mavenUser.showInLineEdit(value);

                return false;
            })

            $("#save-user").click(function(){
                mavenUser.save();
            });

            $("#addNew").click(function(){
                mavenUser.add();
            });

            $("#btnCancelNewUser").click(function(){
                mavenUser.cancelNewUser();
            });

            $("#btnSaveNewUser").click(function(){
                mavenUser.saveNewUser();
            });

            $(".maven-remove").click(function(){
                value = jQuery(this).attr('href');
                value = value.replace("#","");
                mavenUser.remove(value);
            });

            $(".maven-enable").click(function(){
                mavenUser.enable(this);
            });

					
					
        },
				
        showInLineEdit: function(id)
        {
            var t=this;
            var user_enabled;
            t.cleanInLine();
			
            editRow = $("#inline-edit").clone(true);
						
            rowData = $('#inline-'+id);
			
            $("#user-row-"+id).hide().after(editRow);

            //Fill user name
            $("#user_name",editRow).val($(".user_name",rowData).text());
            $("#user_email",editRow).val($(".user_email",rowData).text());
			
            $(".maven-member-fields input",rowData).each(function(){
				
				$("#"+$(this).attr('class'),editRow).val($(this).val());
			});
            user_enabled = $(".user_enabled",rowData).text();
            if (user_enabled)
                $("#user_enabled",editRow).attr('checked',user_enabled);
           

            //Fill the roles
            roles = $(".user_existing_roles",rowData).text()
			
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
                //$("#user-row-"+value).show();
                $("#edit-"+this.currentInlineID).hide();
                $('#user-row-'+this.currentInlineID).show();
                
            }

        },

        cancelInLineEdit: function(){
            var t=this;
            t.cleanInLine();
        }, 

        add: function(){
            $("#poststuff").show('slow');
        },

        enable: function(obj){
                    
            var value = "";
            value = $(obj).attr('href');
            value = value.replace("#","");
                                        
            if ($(obj).hasClass('on')){
                $(obj).removeClass('on');
                $(obj).addClass('off');

                //$(obj).attr('class','maven-disable');
                $(obj).text('| Disable');
                enable = 1;
            }
            else{
                $(obj).removeClass('off');
                $(obj).addClass('on');

                //$(obj).attr('class','maven-enable');
                $(obj).text('| Enable');
                enable = 0;
            }
                                            
                                        
            //mavenUser.disable(value);
                                        
            mavenBase.post("users_enable_user","value="+enable+"&user_id="+value,function(data){
                var row;
                row= $("#user-row-"+value);
                                         
                if (enable)                         
                    $(".list-user-enabled",row).attr('checked',true);
                else
                     $(".list-user-enabled",row).attr('checked',false);
                
                                                                
            });
        },

        disable: function(value){
            mavenBase.post("users_enable_user","value=0&user_id="+value,function(data){
                //var row;
                row= $("#user-row-"+value);
                                                                
                $(".list-user-enabled",row).attr('checked', false);
            });
        },

        remove: function(user_id){

            var txt = 'Are you sure you want to remove the user?<input type="hidden" id="user_id" name="user_id" value="'+ user_id +'" />';
            jQuery.prompt(txt,{
                buttons:{
                    Delete:true, 
                    Cancel:false
                },
                callback: function(v,m,f){
                                                
                    if(v){
                        var value = f.user_id;

                        mavenBase.post("users_delete_user","user_id="+value,function(data){
                                                            
                            $("#user-row-"+value).fadeOut('slow',function(){
                                $(this).remove();
                            });
                        });

                    }
                    else{}

                }
            });
					
					
					
        },

        saveNewUser: function(){

            var name,role_ids,enabled,password;
			$("#error-message").html('');
			$("#new-user-name").css('border-color','#DFDFDF');
            $("#new-password-name").css('border-color','#DFDFDF');
            $("#new-email-name").css('border-color','#DFDFDF');
			
            name = $("#new-user-name").val();
            password = $("#new-password-name").val();
            email = $("#new-email-name").val();
            enabled = $("#new-enabled").attr('checked');
			
			if(name==''){
				$("#new-user-name").css('border-color','#FF0000');
			}
			if(password ==''){
				$("#new-password-name").css('border-color','#FF0000');
			}
			if(email==''){
				$("#new-email-name").css('border-color','#FF0000');
			}
			if(name==''||password==''||email==''){
				return false;
			}
            if (enabled)
                enabled = 1;
            else
                enabled = 0;
            
            role_ids = null;
            jQuery("[name='new-user-role[]']:checked").each(function(){
                var value = jQuery(this).val();
                if(!role_ids)
                    role_ids = value;
                else
                    role_ids += ","+value;
            });

            mavenBase.post("users_add","enabled="+enabled+"&"+"user_name="+name+"&roles="+role_ids+"&password="+password+"&user_email="+email,function(data){
				if(!data.is_error){
                $("#users").append(data.result.new_row);
                                                        
                $(".maven-edit").live('click',function(){
                    mavenUser.showInLineEdit(data.result.user.ID);
                    return false;
                });
                                                        
                $(".maven-remove").live('click',function(){
                    mavenUser.remove(data.result.user.ID);
                });
                                                        
                $(".maven-enable").live('click',function(){
                    mavenUser.enable(this);
                });

                mavenUser.cancelNewUser();
				}else{
					$("#error-message").html(data.message);
				}                     
            });
        },
		
        cancelNewUser: function(){
			$("#error-message").html('');
			$("#new-user-name").css('border-color','#DFDFDF');
            $("#new-password-name").css('border-color','#DFDFDF');
            $("#new-email-name").css('border-color','#DFDFDF');
            $("#poststuff").hide('slow');
            $("#new-user-name").val('');
            $("[name='new-user-role[]']").each(function(){
                $(this).attr('checked',false);
            });
        
         
            $("#new-password-name").val('');
            $("#new-email-name").val('');
            $("#new-enabled").attr('checked',false);

        },


        save: function()
        {
            var t = this,editRow,role_ids;
            editRow = $("#edit-"+t.currentInlineID);

            role_ids = '';
            role_names = null;
            jQuery("[name='user-role[]']:checked",editRow).each(function(){

                var value = $(this).val();
                if(!role_ids)
                {
                    role_ids = value;
                    role_names = $(this).parent().text();
                }
                else
                {
                    role_ids += ","+value;
                    role_names += ","+ $(this).parent().text();
                }
            });

						
            user_name = $("#user_name",editRow).val();
            user_enabled = $("#user_enabled",editRow).is(':checked') ?1:0;
			
            mavenBase.post("users_save_user","value="+user_enabled+"&user_id="+t.currentInlineID+"&roles="+role_ids,function(data){
                var row;
				
                row = $("#user-row-"+t.currentInlineID);
				
                $(".row-title",row).html(user_name);
                if (user_enabled==1)
                    $(".list-user-enabled",row).attr('checked','checked');
                else
                    $(".list-user-enabled",row).removeAttr('checked');
                
                
                //$(".user_enabled",row).html(user_enabled);
                $(".user_existing_roles",row).html(role_ids);
                $(".roles-names",row).html(role_names);


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


    $(document).ready(function(){
        mavenUser.init();
    });
})(jQuery);