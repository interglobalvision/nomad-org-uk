<?php
get_header();
?>

<!-- main content -->

<main id="main-content">

  <!-- main posts loop -->
  <section id="posts" class="container u-align-center">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();

    if ( get_post_type($post->ID) == 'project') {
      get_template_part('partials/index-project');
    } else {
      get_template_part('partials/index-post');
    }

  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no posts matched your criteria :{'); ?></article>
<?php
} ?>
  <!-- end posts -->
  </section>

  <?php get_template_part('partials/pagination'); ?>

<!-- end main-content -->

</main>

<?php
get_footer();
?>