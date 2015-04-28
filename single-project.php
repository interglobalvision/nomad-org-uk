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
    $title = get_post_meta($post->ID, '_igv_project_title');
?>

    <article <?php post_class(); ?> id="project">
      <h1 class="u-align-center"><?php the_title(); ?></h1>

      <section id="project-visuals" class="row js-packery-container">
 <?php
  foreach ($visuals[0] as $visual) {
    if (!empty($visual['video'])) {
      var_dump($visual['video']);
    } else {
      $thumbnail = wp_get_attachment_image_src($visual['thumbnail_id'], 'project-thumb');
?>
        <div class="project-visual percent-col into-3 grid-hover js-packery-item js-load-gallery" data-gallery="<?php if (!empty($visual['gallery'])) { echo $visual['gallery'];} ?>">
          <div class="grid-hover-holder">
            <div class="u-holder">
              <div class="u-held">
                <h4><?php if (!empty($title)) {echo $title;} ?></h4>
              </div>
            </div>
          </div>
          <img src="<?php echo $thumbnail[0]; ?>" />
        </div>
<?php
    }
  }
?>
      </section>

      <ul id="project-copy-nav">
<?php
  $project_copy_index = 1;
  foreach ($copy[0] as $copy_section) {
?>
  <li class="js-project-copy-link u-dummy-link" data-target-id="project-copy-<?php echo $project_copy_index; ?>">
    <h4 class="font-uppercase"><?php echo $copy_section['title']; ?></h4>
  </li>
<?php
  $project_copy_index++;
  }
?>
      </ul>

      <section id="project-copy">
         <div class="project-copy-section" id="project-copy-main">
          <?php the_content(); ?>
        </div>
<?php
  $project_copy_index = 1;
  foreach ($copy[0] as $copy_section) {
?>
        <div class="project-copy-section" id="project-copy-<?php echo $project_copy_index; ?>">
          <h4 class="font-uppercase"><?php echo $copy_section['title']; ?></h4>
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