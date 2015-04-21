<?php
get_header();
?>

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $gallery = get_post_meta( $post->ID, '_igv_gallery', true );
?>

    <article <?php post_class('viewer'); ?> id="post-<?php the_ID(); ?>">

      <div id="single-slider">

        <nav id="single-close" class="single-nav">
          <a href="<?php echo home_url(); ?>">
            <?php echo url_get_contents(get_bloginfo('stylesheet_directory') . '/img/close.svg'); ?>
          </a>
        </nav>
        <nav id="single-next" class="single-nav">
<?php
  $nextPost = get_adjacent_post(null, null, false);
  if ($nextPost) {
    $nextLink = get_permalink($nextPost->ID);
  } else {
    $nextLink = home_url();
  }
?>
          <a href="<?php echo $nextLink; ?>">
            <?php echo url_get_contents(get_bloginfo('stylesheet_directory') . '/img/next.svg'); ?>
          </a>
        </nav>
        <nav id="single-prev" class="single-nav">
<?php
  $previousPost = get_adjacent_post();
  if ($previousPost) {
    $prevLink = get_permalink($previousPost->ID);
  } else {
    $prevLink = home_url();
  }
/*   var_dump($previousPost); */
?>
          <a href="<?php echo $prevLink; ?>">
            <?php echo url_get_contents(get_bloginfo('stylesheet_directory') . '/img/prev.svg'); ?>
          </a>
        </nav>

        <div class="js-slick-container u-pointer">
          <?php echo do_shortcode($gallery) ?>
        </div>

      </div>

      <div id="single-slider-text">
        <?php the_title(); ?>
         |
        <span id="slick-caption" class="font-italic"></span>
         |
        <span id="slick-current-index">1</span> of <span id="slick-length"></span>
         |
        <span id="slick-prev" class="u-pointer">Prev</span>/<span id="slick-next" class="u-pointer">Next</span>
      </div>

      <section id="single-copy" class="container">
        <div class="row">
          <div class="col col6">
	          <?php the_content(); ?>
          </div>
        </div>
      </section>

    </article>

<?php
  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no posts matched your criteria :{'); ?></article>
<?php
} ?>

<?php
get_footer();
?>