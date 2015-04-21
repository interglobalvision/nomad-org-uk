<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $visuals = get_post_meta($post->ID, '_igv_project_visuals');
    $copy = get_post_meta($post->ID, '_igv_project_copy');
?>

    <article <?php post_class(); ?> id="project">
      <?php the_title(); ?>

      <section id="project-visuals">
 <?php
  foreach ($visuals[0] as $visual) {
?>
        <div class="project-visual">
<?php
    if (!empty($visual['video'])) {
      var_dump($visual['video']);
    } else {
      $thumbnail = wp_get_attachment_image_src($visual['thumbnail_id'], 'project-thumb');
      var_dump($thumbnail);
    }
?>
        </div>
<?php
  }
?>
      </section>

      <ul id="project-copy-nav">
<?php
  $project_copy_index = 1;
  foreach ($copy[0] as $copy_section) {
?>
  <li class="js-project-copy-link" data-target-id="project-copy-<?php echo $project_copy_index; ?>">
    <h3><?php echo $copy_section['title']; ?></h3>
  </li>
<?php
  $project_copy_index++;
  }
?>
      </ul>

      <section id="project-copy">
<?php
  $project_copy_index = 1;
  foreach ($copy[0] as $copy_section) {
?>
  <div class="project-copy-section" id="project-copy-<?php echo $project_copy_index; ?>">
    <h3><?php echo $copy_section['title']; ?></h3>
    <?php echo wpautop($copy_section['copy']); ?>
  </div>
<?php
  $project_copy_index++;
  }
?>
      </section>

    </article>

<?php
  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no project matched your criteria'); ?></article>
<?php
} ?>

<!-- end main-content -->

</main>

<?php
get_footer();
?>