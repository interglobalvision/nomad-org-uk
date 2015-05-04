<?php
  global $post;
  $meta = get_post_meta($post->ID);

  if (!empty($meta['_igv_color'][0])) {
    $color = $meta['_igv_color'][0];
  }

  if (!empty($post->post_content)) {
    $has_copy = true;
  } else {
    $has_copy = false;
  }
?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>" <?php
  if ($color) {
    echo 'style="background-color: ' . $color .'"';
  }
?>>
      <h2 class="js-post-toggle u-pointer">
        <?php the_title(); ?>
<?php
  if ($has_copy) {
?>
        <span class="post-toggle">+</span>
<?php
  }
?>
      </h2>

<?php
  if ($has_copy) {
?>
      <div class="post-copy">
        <?php the_content(); ?>
      </div>
<?php
  }
?>

    </article>