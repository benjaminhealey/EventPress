<?php 
    /*
    Plugin Name: Event Press
    Plugin URI: www.cs.redeemer.ca/~bhealey
    Description: Plugin for creating, displaying, and sharing events. 
    Author: Benjamin Healey
    Author URI: www.cs.redeemer.ca/~bhealey
    Version: 1.1
  */
require_once dirname( __FILE__ ).'/includes/ep-main.php';

register_activation_hook (__FILE__, array ('bh_ep_main', 'bh_ep_install')); //on install, do stuff
register_deactivation_hook (__FILE__, array ('bh_ep_main', 'bh_ep_uninstall')); //uninstall action hook

add_action( 'init', 'bh_ep_event_post_type' );
add_action( 'add_meta_boxes', 'bh_ep_add_event_info_metabox' );
add_action( 'save_post', 'bh_ep_save_event_info' );
add_action('admin_menu', 'bh_ep_menu');

//create event post type 
function bh_ep_event_post_type(){
	//array of arguments to be passed to register
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
		'editor',
		'thumbnail'
	); 
	$args = array(
		'labels'             => $labels,
               	'description'        => __( 'Description.'),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true, //default UI 
		'show_in_menu'       => true, //show in menu 
		'query_var'          => true,
		'menu_icon' 	     => 'dashicons-calendar-alt',
		'rewrite'            => array( 'slug' => 'event' ),
		//'capability_type'    => $capabilities, //pass array of translated capabilities 
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'	     => $support
	);
	register_post_type('bh_ep_event', $args);
} 
function bh_ep_add_event_info_metabox() {
    add_meta_box(
        'bh-ep-event-info-metabox',
        __('Event Info'),
        'bh_ep_render_event_info_metabox',
        'bh_ep_event',
        'side',
        'core'
    );
}
function bh_ep_render_event_info_metabox( $post ) {
    // generate a nonce field
    wp_nonce_field( basename( __FILE__ ), 'bh-ep-event-info-nonce' );
 
    // get previously saved meta values (if any)
    $event_start_date = get_post_meta( $post->ID, 'event-start-date', true );
    $event_end_date = get_post_meta( $post->ID, 'event-end-date', true );
    $event_venue = get_post_meta( $post->ID, 'event-venue', true );
 
    // if there is previously saved value then retrieve it, else set it to the current time
    $event_start_date = ! empty( $event_start_date ) ? $event_start_date : time();
 
    //we assume that if the end date is not present, event ends on the same day
    $event_end_date = ! empty( $event_end_date ) ? $event_end_date : $event_start_date;
 
    ?>
<label for="bh-ep-event-start-date"><?php _e( 'Event Start Date:' ); ?></label>
        <input class="widefat bh-ep-event-date-input" id="bh-ep-event-start-date" type="text" name="bh-ep-event-start-date" placeholder="Format: February 18, 2014" value="<?php echo date( 'F d, Y', $event_start_date ); ?>" />
 
<label for="bh-ep-event-end-date"><?php _e( 'Event End Date:'); ?></label>
        <input class="widefat bh-ep-event-date-input" id="bh-ep-event-end-date" type="text" name="bh-ep-event-end-date" placeholder="Format: February 18, 2014" value="<?php echo date( 'F d, Y', $event_end_date ); ?>" />
 
<label for="bh-ep-event-venue"><?php _e( 'Event Venue:'); ?></label>
        <input class="widefat" id="bh-ep-event-venue" type="text" name="bh-ep-event-venue" placeholder="eg. Times Square" value="<?php echo $event_venue; ?>" />
<?php 
}

//save custom post type 
function bh_ep_save_event_info( $post_id ) {
    // checking if the post being saved is an 'event',
    // if not, then return
    if ( 'bh_ep_event' != $_POST['post_type'] ) {
        return;
    }
 
    // checking for the 'save' status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['bh-ep-event-info-nonce'] ) && ( wp_verify_nonce( $_POST['bh-ep-event-info-nonce'], basename( __FILE__ ) ) ) ) ? true : false;
 
    // exit depending on the save status or if the nonce is not valid
    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }
 
    // checking for the values and performing necessary actions
    if ( isset( $_POST['bh-ep-event-start-date'] ) ) {
        update_post_meta( $post_id, 'event-start-date', strtotime( $_POST['bh-ep-event-start-date'] ) );
    }
 
    if ( isset( $_POST['bh-ep-event-end-date'] ) ) {
        update_post_meta( $post_id, 'event-end-date', strtotime( $_POST['bh-ep-event-end-date'] ) );
    }
 
    if ( isset( $_POST['bh-ep-event-venue'] ) ) {
        update_post_meta( $post_id, 'event-venue', sanitize_text_field( $_POST['bh-ep-event-venue'] ) );
    }
}

function bh_ep_menu(){
	//custom menu 
	//what page is, Title, capability, slug, function(to be called), 
	add_menu_page('EventPress Page', 'EventPress', 'manage_options', __FILE__. 'bh_ep_settings', 'bh_ep_settings'); 
	//create submenu items
	add_submenu_page( __FILE__, 'Uinstall My Plugin', 'Uninstall', 'manage_options', __FILE__.'_uninstall', 'bh_ep_uninstall_page'); 
}

function bh_ep_settings(){ ?>
<form action="">
<fieldset>
<h4>Personal information:</h4>
    	Contact Email:<br>
<input type="email" name="press_email" value=""> 
<br>
    	Site name:<br>
<input type="text" name="lastname" value="">
<br><br>
</fieldset>
		
<fieldset>
<h4>Event Criteria</h4>
    	Location<br>
<input type="text" name="press_email" value=""> 
<br>
</fieldset>
<input type="submit" value="Submit">
</form>
<?php
}

?>
