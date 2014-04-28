<?php

class Maven_addons_core
{
    var $cache_key = "!maven_addons_captcha_key";
    var $default_headers = array(
		'Name' => 'Captcha Name',
		'CaptchaURI' => 'Captcha URI',
		'Version' => 'Version',
		'Description' => 'Description',
		'Author' => 'Author'
	);
    var $captcha_options_ids = "";
    
    
    public function __construct() {
        ;
    }
    
    
    private function get_addons_path(){
        return WBM_MEMBER_PLUGIN_DIR."addons/";
    }
    
    private function get_captchas_path(){
        return WBM_MEMBER_PLUGIN_DIR."addons/captcha/";
    }
    
    public function load_addsons(){
        
	$plugin_data = get_file_data( WBM_MEMBER_PLUGIN_DIR."addons/captcha/maven-recaptcha/maven-recaptcha.php", $default_headers, 'captcha' );
        
    }
    
    public function captcha_enabled(){
        
    }
    
    public function get_captchas()
    {
        $existing_captchas = Maven_cache::get($this->cache_key);
        
        if ($existing_captchas!==false)
            return $existing_captchas;
        
        // Get existings captchas directories
        $files = Maven_file::list_files($this->get_captchas_path(),2);
        $existing_captchas = array();
        
        foreach($files as $file){
            $data = get_file_data( $file, $this->default_headers, 'captcha' );
            if ($data["Name"])
            {
                //TODO: Validate if the class exists
                $obj = $this->convert_to_object($data);
                $obj->file = basename($file);
                
                $file_name = str_replace(".php","",$obj->file);
                
                $obj->dir = $file_name."/";
                $obj->class_name = $file_name;
		
		$obj->options = $this->instantiate_captcha($obj)->get_options();
		
		foreach($obj->options as $option){
		    
		    if (!$this->captcha_options_ids)
			$this->captcha_options_ids = $option->id;
		    else
			$this->captcha_options_ids .= ",".$option->id;
		}
		
                $existing_captchas[$obj->file] = $obj;
                
            }
        }
        
        return $existing_captchas;
    }
    
    public function get_captcha_options_ids(){
	return $this->captcha_options_ids;
    }
    
    
    
    private function get_captcha($key){
        
        $existing_captchas = $this->get_captchas();
        
        if (!isset($existing_captchas[$key])) 
            return false;
         
        return $existing_captchas[$key];
    }
    
    
    private function convert_to_object($data){

        $obj = new Maven_addon();
        $obj->name = $data["Name"];
        $obj->description = $data["Description"];
        $obj->author = $data["Author"];
        
        return $obj;
    }
    
    private function instantiate_captcha($captcha){
	
	// Include captcha file 
        require_once $this->get_captchas_path().$captcha->dir.$captcha->file;
        
        $captcha = new $captcha->class_name;
        
        return $captcha;
	
    }
    
    public function get_active_captcha(){
        
	global $maven_manager;
        
        $captcha = $this->get_captcha($maven_manager->get_setting_class()->get_registration_captcha());
        
        if (!$captcha) 
            return $this->get_dummy_captcha();
        
        return $this->instantiate_captcha($captcha);
	
    }
    
    public function save_options($options)
    {
	$captchas = $this->get_captchas();
	
	//TODO: We need to return a list of errors
	$result = true;
	foreach($captchas as $captcha){
	    foreach($captcha->options as $option){
			
			if(isset($options[$option->id])){
				$option->value = $options[$option->id];
			}
	    }
	    
	    $instance = $this->instantiate_captcha($captcha);
	    
	    $result = $instance->save_options($captcha->options);
	}
	
	return $result;
	
    }

//    
//    private function get_options($key){
//        
//        global $maven_manager;
//        
//        $captcha = $this->get_captcha($key);
//        
//        if (!$captcha) 
//            return $this->get_dummy_captcha();
//            
//        
//        // Include captcha file 
//        require_once $this->get_captchas_path().$captcha->dir.$captcha->file;
//        
//        $captcha = new $captcha->class_name;
//        
//        return $captcha->get_options();
//	 
//        
//    }
    
    
    
    private function get_dummy_captcha(){
        $dummy_captcha = new Maven_dummy_captcha();
        
        
        return $dummy_captcha;
    }
    
    
    
}



?>
