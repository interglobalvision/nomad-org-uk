<?php
  global $post;
  $meta = get_post_meta($post->ID);

  if (!empty($meta['_igv_mp4'][0])) {
    $mp4 = $meta['_igv_mp4'][0];
  }
  if (!empty($meta['_igv_webm'][0])) {
    $webm = $meta['_igv_webm'][0];
  }

?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      <a href="<?php the_permalink() ?>">
        <?php the_post_thumbnail(); ?>
        <h2><?php the_title(); ?></h2>
      </a>
    </article>