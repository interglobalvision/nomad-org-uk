<?php
get_header();
?>

<!-- main content -->

<main id="main-content">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $visuals = get_post_meta($post->ID, '_igv_project_visuals');
    $copy = get_post_meta($post->ID, '_igv_project_copy');
?>

    <article <?php post_class(); ?> id="project">
      <header id="project-header">
        <h1 class="u-align-center"><?php the_title(); ?></h1>
      </header>

      <section id="project-visuals" class="inner-container row js-packery-container">
 <?php
  $visuals_index = 0;
  if ($visuals) {
  foreach ($visuals[0] as $visual) {
    if (!empty($visual['video'])) {
      $video = get_post($visual['video']);
      $video_meta = get_post_meta($visual['video']);
      $img_id = get_post_thumbnail_id($visual['video']);

      $img = wp_get_attachment_image_src($img_id, 'grid-basic');
      $img_large = wp_get_attachment_image_src($img_id, 'grid-large');
      $img_larger = wp_get_attachment_image_src($img_id, 'grid-larger');
      $img_largest = wp_get_attachment_image_src($img_id, 'grid-largest');
?>
        <div class="project-visual percent-col into-3 grid-hover u-pointer js-packery-item js-load-vimeo"
          data-vimeo="<?php echo $video_meta['_vimeo_id_value'][0]; ?>"
          data-vimeo-ratio="<?php echo $video_meta['_vimeo_ratio_value'][0]; ?>"
          data-title="<?php echo $video->post_title; ?>"
          >
<?php
        if (!empty($video->post_title)) {
?>
          <div class="grid-hover-holder">
            <div class="u-holder">
              <div class="u-held u-pad-small">
                <h4><?php echo $video->post_title; ?></h4>
              </div>
            </div>
          </div>
 <?php
        }
?>
          <img class="js-grid-img"
            data-basic="<?php echo $img[0]; ?>"
            data-large="<?php echo $img_large[0]; ?>"
            data-larger="<?php echo $img_larger[0]; ?>"
            data-largest="<?php echo $img_largest[0]; ?>" />
        </div>
<?php
    } else {
      $img_id = $visual['thumbnail_id'];

      $img = wp_get_attachment_image_src($img_id, 'grid-basic');
      $img_large = wp_get_attachment_image_src($img_id, 'grid-large');
      $img_larger = wp_get_attachment_image_src($img_id, 'grid-larger');
      $img_largest = wp_get_attachment_image_src($img_id, 'grid-largest');
?>
        <div class="project-visual percent-col into-3 grid-hover u-pointer js-packery-item js-load-gallery" data-gallery="<?php echo $visuals_index; ?>">
          <div class="grid-hover-holder">
            <div class="u-holder">
              <div class="u-held u-pad-small">
                <h4><?php if (!empty($visual['title'])) {echo $visual['title'];} ?></h4>
              </div>
            </div>
          </div>
          <img class="js-grid-img"
            data-basic="<?php echo $img[0]; ?>"
            data-large="<?php echo $img_large[0]; ?>"
            data-larger="<?php echo $img_larger[0]; ?>"
            data-largest="<?php echo $img_largest[0]; ?>" />
        </div>
<?php
    }
    $visuals_index++;
  }
  }
?>
      </section>

      <section id="project-visuals-overlay">
  <?php
  $visuals_index = 0;
  if ($visuals) {
  foreach ($visuals[0] as $visual) {
    if (!empty($visual['video'])) {
      var_dump($visual['video']);
    } else if (!empty($visual['gallery'])) {
?>
        <div class="project-visuals-overlay" id="overlay-gallery-<?php echo $visuals_index; ?>">
          <?php echo do_shortcode($visual['gallery']); ?>
        </div>
<?php
    }
    $visuals_index++;
  }
  }
?>
      </section>

      <ul id="project-copy-nav" class="text-container">
<?php
  if ($copy) {
  $project_copy_index = 1;
  foreach ($copy[0] as $copy_section) {
?>
  <li class="js-project-copy-link u-dummy-link" data-target-id="project-copy-<?php echo $project_copy_index; ?>">
    <h4 class="font-bold"><?php echo $copy_section['title']; ?></h4>
  </li>
<?php
  $project_copy_index++;
  }
?>
      </ul>

      <section id="project-copy" class="text-container">
         <div class="project-copy-section" id="project-copy-main">
          <?php the_content(); ?>
        </div>
<?php
  $project_copy_index = 1;
  foreach ($copy[0] as $copy_section) {
?>
        <div class="project-copy-section u-cf" id="project-copy-<?php echo $project_copy_index; ?>">
          <h4 class="project-copy-section-title"><?php echo $copy_section['title']; ?></h4>
          <?php echo wpautop($copy_section['copy']); ?>
        </div>
<?php
  $project_copy_index++;
  }
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

<section id="gallery-overlay" class="overlay">
  <nav id="gallery-overlay-close" class="overlay-nav overlay-close u-pointer">
    <span class="overlay-close-character">&times;</span>
  </nav>
  <div class="overlay-caption-holder row font-caption">
    <div class="percent-col into-2">
      <?php the_title(); ?>
    </div>
    <div class="percent-col into-2 u-align-right">
      <span id="gallery-overlay-title" class="font-italic"></span><span id="gallery-overlay-caption"></span>
    </div>
  </div>
  <div id="gallery-overlay-insert" class="js-slick-container"></div>
</section>

<section id="video-overlay" class="overlay">
  <nav id="video-overlay-close" class="overlay-nav overlay-close u-pointer">
    <span class="overlay-close-character">&times;</span>
  </nav>
  <div class="overlay-caption-holder row font-caption">
    <div class="percent-col into-2">
      <?php the_title(); ?>
    </div>
    <div class="percent-col into-2 u-align-right">
      <span id="video-overlay-title" class="font-italic"></span>
    </div>
  </div>
  <div class="u-holder js-video-holder">
    <div class="u-held" id="video-overlay-insert">

    </div>
  </div>
</section>

<?php
get_footer();
?>