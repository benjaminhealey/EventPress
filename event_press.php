<?php 
    /*
    Plugin Name: Event Press
    Plugin URI: www.cs.redeemer.ca/~bhealey
    Description: Plugin for creating, displaying, and sharing events. 
    Author: Benjamin Healey
    Author URI: www.cs.redeemer.ca/~bhealey
    Version: 1.1
  */
require_once dirname( __FILE__ ) . '/includes/ep-main.php';
//bh_ep_main::actionHooks();

register_activation_hook (__FILE__, array ('bh_ep_main', 'bh_ep_install')); //on install, do stuff
register_deactivation_hook (__FILE__, array ('bh_ep_main', 'bh_ep_uninstall')); //uninstall action hook

add_action( 'init', 'bh_ep_event_post_type' );

//create event post type 
	function bh_ep_event_post_type(){
		//array of arguments to be passed to register
		
		$capabilities = array(
			'edit_post'          => 'edit_event', 
  			'read_post'          => 'read_event', 
  			'delete_post'        => 'delete_event', 
 			'edit_posts'         => 'edit_events', 
  			'edit_others_posts'  => 'edit_others_events', 
  			'publish_posts'      => 'publish_events',       
  			'read_private_posts' => 'read_private_events', 
  			'create_posts'       => 'edit_events',
		);
		
		$labels = array(
			'name'               => 'Events',
			'singular_name'      => 'Event',
			'menu_name'          => 'Events',
			'name_admin_bar'     => 'Event',
			'add_new'            => 'Add New Event',
			'add_new_item'       => 'Add New Event' ,
			'new_item'           => 'New Event',
			'edit_item'          => 'Edit Event',
			'view_item'          => 'View Event',
			'all_items'          => 'All Events',
			'search_items'       => 'Search Events',
			'parent_item_colon'  => 'Parent Events:',
			'not_found'          => 'No events found.',
			'not_found_in_trash' => 'No events found in Trash.' 
		);
		$support = array(
			'title',
			'editor'
		); 
		$args = array(
			'labels'             => $labels,
                	'description'        => __( 'Description.'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true, //default UI 
			'show_in_menu'       => true, //show it menu 
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'event' ),
			'capability_type'    => $capabilities, //pass array of translated capabilities 
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'	     => $support
		);
		register_post_type('bh_ep_event', $args);
	} 

?>
