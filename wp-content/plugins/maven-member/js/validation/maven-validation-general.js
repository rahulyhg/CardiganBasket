
(function($) {
	
    mavenValidation ={
        init : function() {
					
            jQuery("#maven-registration-form").validationEngine();
        }
				
    };


    $(document).ready(function(){
        mavenValidation.init();
    });
})(jQuery);