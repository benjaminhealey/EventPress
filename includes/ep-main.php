<?php 
class bh_ep_main{
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			$className      = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
	}
	
	
	
	//install function 
	function bh_ep_install(){
		//add default load in 
		$bh_ep_options = array(); 
		If (version_compare (get_bloginfo('version'), '4.3', '<')){ //version compare
			deactivate_plugins(basename(__FILE__));//deactivate plugin
		}
	}
	//uninstall function 
	function bh_ep_uninstall(){
		//deactivate code
		deactivate_plugins(basename(__FILE__));//deactivate plugin
	}
	
	//Creates menus
	function bh_ep_menu(){
		//custom menu 
		//what page is, Title, capability, slug, function(to be called), 
		add_menu_page('EventPress Page', 'EventPress', 'manage_options', $title, 'bh_ep_settings_page', 'dashicons-mail');  

		//create submenu items
		add_submenu_page( __FILE__, 'About EventPress', 'About', 'manage_options', $title,'_about', bh_ep_about_page );
		add_submenu_page( __FILE__, 'EventPress Settings', 'Settings', 'manage_options', __FILE__,'_settings', bh_ep_help_page );
		add_submenu_page( __FILE__, 'Uinstall My Plugin', 'Uninstall', 'manage_options', __FILE__,'_uninstall', bh_ep_uninstall_page ); 
	}
	
	
	//action hooks 
	function actionHooks(){
		add_action('admin_menu', 'bh_ep_menu');
		
	}
}//end of main 
?>
