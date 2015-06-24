<?php
get_header();
?>

<!-- main content -->

<main id="main-content">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

    <article <?php post_class(); ?> id="project">
      <header class="inner-container">
        <h1 class="u-align-center"><?php the_title(); ?></h1>
      </header>

      <section id="page-copy" class="text-container">
         <div class="project-copy-section" id="project-copy-main">
          <?php the_content(); ?>
        </div>
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