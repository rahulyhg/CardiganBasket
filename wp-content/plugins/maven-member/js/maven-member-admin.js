//
//params = {
//			action: 'inline-save',
//			post_type: typenow,
//			post_ID: id,
//			edit_date: 'true',
//			post_status: page
//		};
//
//		fields = $('#edit-'+id+' :input').serialize();
//		params = fields + '&' + $.param(params);
//
//		// make ajax request
//		$.post('admin-ajax.php', params,
//			function(r) {

(function($){
	
	mavenBase = {
		site_url:'',
		init : function(){
			
				},
		post : function(action,args,result_fnc)
		{
                        var nonce;
                        nonce = $("#_wpnonce").val();
                        
                        if (nonce)
                            nonce = "&_ajax_nonce="+nonce;
                        else 
                            nonce = '';
						
			$.ajax({
				url:mavenConfig.siteurl+"/wp-admin/admin-ajax.php",
				type:'POST',
				dataType: 'json',
				data:'action=maven_'+action+"&"+args+nonce,
				success:function(result){
                                                    
						 if (result_fnc)
							result_fnc(result);
					 }

			 });
		 },
                 show_message : function(message){
                     
                        $("#messageContainer").show();
                 },
                 
                 show_error : function(message){
                     
                         $("#errorMessage").text(message);
                         $("#errorMessageContainer").show();
                     
                 }
                 
	}

	$(document).ready(function(){
				
		mavenBase.init();
	});
})(jQuery);

