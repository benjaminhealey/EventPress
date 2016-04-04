<?// Create post object
//change to ASP file with embedded PHP 
//try to receive post as object 
//if ^ doesn't work use JSON 

$my_post = array(
  'post_title'    => wp_strip_all_tags( $_POST['post_title'] ),
  'post_content'  => $_POST['post_content'],
  'post_status'   => 'publish',
  'post_author'   => 1,
  'post_category' => array( 8,39 )
);
 
// Insert the post into the database
wp_insert_post( $my_post );
?>

