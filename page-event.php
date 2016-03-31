<?php
 /**
 * Template Name: Page of Events
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>

<?php get_header(); ?>

        <div id="container">
            <div id="content">

<?php
$type = 'products';
$args=array(
  'post_type' => 'event',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
    <?php
  endwhile;
}
wp_reset_query();  // Restore global post data stomped by the_post().
?>
            </div><!-- #content -->
        </div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
