<?php

class Maven_cache{
    
    public static function add($key,$data){
        wp_cache_add($key, $data);
    }
    
    public static function remove ($key){
        wp_cache_delete($key);
    }
    
    public static function get($key){
        return wp_cache_get($key);
    }
    
}


?>
