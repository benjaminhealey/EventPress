<?php 
    /*
    Plugin Name: Event Press
    Plugin URI: www.cs.redeemer.ca/~bhealey
    Description: Plugin for creating, displaying, and sharing events. 
    Author: Benjamin Healey
    Author URI: www.cs.redeemer.ca/~bhealey
    Version: 1.0
  */

register_activation_hook (__FILE__, 'bh_ep_install'); //on install, do stuff
register_deactivation_hook (__FILE__, 'bh_ep_uninstall'); //uninstall action hook

function bh_ep_install(){
//add default load in 
	$bh_ep_options = array(); 
	If (version_compare (get_bloginfo('version'), '4.3', '<')){ //version compare
		deactivate_plugins(basename(__FILE__));//deactivate plugin
}
}

function bh_ep_uninstall(){
	//deactivate code
	deactivate_plugins(basename(__FILE__));//deactivate plugin
}


add_action('admin_menu', 'bh_ep_menu');

function bh_ep_menu(){
//custom menu 
//what page is, Title, capability, slug, function(to be called), 
add_menu_page('EventPress Page', 'EventPress', 'manage_options', __FILE__, 'bh_ep_settings_page', 'dashicons-mail');  

//create submenu items
	add_submenu_page( __FILE__, 'About EventPress', 'About', 'manage_options', __FILE__.'_about', bh_ep_about_page );
	add_submenu_page( __FILE__, 'EventPress Settings', 'Settings', 'manage_options', __FILE__.'_settings', bh_ep_help_page );
	add_submenu_page( __FILE__, 'Uinstall My Plugin', 'Uninstall', 'manage_options', __FILE__.'_uninstall', bh_ep_uninstall_page ); 
}

function bh_ep_about_page(){?> 
	<h3>About</h3> 
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In lorem tortor, commodo in purus eu, dapibus fermentum dui. Duis odio purus, dapibus vel dui in, congue imperdiet leo. Donec eleifend nibh et rhoncus facilisis. Duis luctus, turpis eu egestas elementum, urna dolor vehicula augue, quis aliquet velit metus a enim. Donec mattis ante diam, non ullamcorper nisi faucibus a. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam eu posuere sem, at ultrices tellus. Aliquam varius sodales eros, sed pharetra arcu pretium vitae. Morbi dictum rutrum accumsan.</p>
<?php
}

?>
