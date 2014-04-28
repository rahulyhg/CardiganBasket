<?php
class Maven_member_auto_logout extends Maven_member_base {

        //TODO: Use Setting class to manage the options
        public function __construct() {
                parent::__construct();

                add_action("init", array(&$this, "init"));
        }

        public function init() {

            add_action('wp_login',array(&$this, "update_login_time"),1 );
            add_action('get_header', array(&$this, "on_page_load"), 1 );
            add_action('admin_init', array(&$this, "on_page_load"), 1 );
        }


        function update_login_time( $username = '' ) {
           //var_dump(get_current_user_id());
                $user_id = get_current_user_id();
                if ($user_id==0)
                    $user_id = get_userdatabylogin( $username )->ID;
                
                if ($user_id != null && $user_id > 0) {
                        update_user_meta( $user_id, 'maven-setting-last-active-time', time() );
                }
        }

        function on_page_load() {
                if( is_user_logged_in() ) {
                    $opt =get_option( 'maven-setting-auto-logout-enabled',0);
                    if (get_option( 'maven-setting-auto-logout-enabled',0)=='1'){
                        
                        $lastActivityTime = $this->get_last_active_time();
                        $idleTimeDuration = get_option( 'maven-setting-auto-logout-idle-limit')*60;
                        $time = time();
                        if( ($lastActivityTime + $idleTimeDuration) < $time ) {
                                wp_logout();
                                wp_redirect( wp_login_url() );
                        } else {
                                $this->update_login_time();
                        }
                        
                    }
                }
        }

        function get_last_active_time() {
                if (is_user_logged_in()) {
                        $value =  get_user_meta( get_current_user_id(), 'maven-setting-last-active-time',true );
                        return (int)$value;
                } else {
                        return 0;
                }
        }

}


	
	
?>