<?php 
// Set the arguments for the query
$args = array( 
  'numberposts'		=> -1, // -1 is for all
  'post_type'		=> 'event', // or 'post', 'page'
  'orderby' 		=> 'date', // or 'date', 'rand'
  'order' 		=> 'ASC', // or 'DESC'
);

// Get the posts
$myposts = get_posts($args);

// If there are posts
if($myposts):
  // Loop the posts
  foreach ($myposts as $mypost):
?>
  <div class="row">
    <!-- Image -->
    <div class="col-xs-3"> 
      <?php getFirstImg($mypost->ID); // Implement this how you want ?>
    </div> 	
    
    <!-- Content -->
    <div class="col-xs-9">
      <h1><a href="<?php echo get_permalink($mypost->event-start-date); ?>"><?php echo get_the_title($mypost->ID); ?></a></h1>
      <?php echo $trimmed = wp_trim_words(get_the_content($mypost->ID), 15, '...'); ?>
    </div>
  </div>

  <?php endforeach; wp_reset_postdata(); ?>
<?php endif; ?>
