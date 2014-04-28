<?php

/**
 * 
 */
class Maven_addon_option{
    var $name;
    var $description;
    var $value;
    var $id;
    
    /**
     * Choose the html type
     * @var type: input,textarea,checkbox
     */
    var $type;
 
    
    public function get_html()
    {
	switch($this->type){
	    case "input": 
		return "<input id='{$this->id}' class='regular-text' name='{$this->id}' value='{$this->value}' />";
	}
	
	return "<strong>".__('Invalid html. Check your option type',maven_translation_key())."</strong>";
    }
}
?>
