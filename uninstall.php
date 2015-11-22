<?php 
    /*
    Plugin Name: Event Press
    Plugin URI: www.cs.redeemer.ca/~bhealey
    Description: Plugin for creating, displaying, and sharing events. 
    Author: Benjamin Healey
    Author URI: www.cs.redeemer.ca/~bhealey
    Version: 1.0
  */

register_activation_hook (_FILE_, 'bh_ep_activate'); //on install, activate uninstall option

function bh_ep_activate(){
//register uninstall function
	register_uninstall_hook(_FILE_, 'bh_ep_uninstaller');

}

function bh_ep_uninstaller(){
	//delete anything that looks good
	delete_option('bh_ep_options');//deactivate plugin
}
  
?>
