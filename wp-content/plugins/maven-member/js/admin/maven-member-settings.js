
(function($) {

    mavenSetting ={

        init: function(){
            jQuery( "#tabs" ).tabs({
                fx: {
                    opacity: 'toggle'
                }
            });
            
            jQuery( "#registration-tabs" ).tabs();
            
		
    },

		
    resetSettings: function()
    {
        mavenBase.post("setting_reset",'',function(){
            mavenBase.show_message("Setting resetted");
        });
    },

    saveSetting:function(setting,value)
    {
        mavenBase.post("setting_save","settings="+setting+"&values="+value,function(){
            mavenBase.show_message("Setting saved");
        });
    }
		
}


$(document).ready(function(){
    mavenSetting.init();
});
})(jQuery);


	