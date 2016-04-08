<?php 
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
