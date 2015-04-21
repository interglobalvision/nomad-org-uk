<?php
/*
Template Name: List archive
*/
get_header();
$args = array(
  'posts_per_page' => -1,
  'post_type' => 'project'
);
?>

<!-- main content -->

<main id="main-content" class="container">

  <!-- main posts loop -->
  <section id="posts" class="row">

<?php
$posts = get_posts($args);
if ($posts) {
  foreach ($posts as $post) {
    $meta = get_post_meta($post->ID);
?>

    <article <?php post_class('col col6'); ?> id="post-<?php the_ID(); ?>">

      <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>

    </article>

<?php
  }
}
?>

  <!-- end posts -->
  </section>

<!-- end main-content -->

</main>

<?php
get_footer();
?>