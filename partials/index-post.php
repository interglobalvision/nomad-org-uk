<?php
  global $post;
  $meta = get_post_meta($post->ID);

  $img = false;
  if ($thumb_id = get_post_thumbnail_id($post->ID)) {
    $img = wp_get_attachment_image_src($thumb_id, 'size');
  }

  if (!empty($meta['_igv_color'][0])) {
    $color = $meta['_igv_color'][0];
  }

  $link = false;
  if (!empty($meta['_igv_project_link'][0])) {
    $link = get_permalink($meta['_igv_project_link'][0]);
  } else if (!empty($meta['_igv_external_link'][0])) {
    $link = $meta['_igv_external_link'][0];
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

<?php
  if ($has_copy) {
?>
      <h2 class="post-title js-post-toggle u-pointer"<?php
        if ($img) {
          echo 'style="background-image: url(' . $img[0] .')"';
        }
      ?>>
        <?php the_title(); ?>
        <span class="post-toggle">+</span>
      </h2>

      <div class="post-copy">
        <?php the_content(); ?>
      </div>
<?php
  } else if ($link) {
?>
      <a href="<?php echo $link; ?>">
        <h2 class="post-title"<?php
          if ($img) {
            echo 'style="background-image: url(' . $img[0] .')"';
          }
        ?>>
          <?php the_title(); ?>
        </h2>
      </a>
<?php
  } else {
?>
      <h2 class="post-title"<?php
        if ($img) {
          echo 'style="background-image: url(' . $img[0] .')"';
        }
      ?>>
        <?php the_title(); ?>
      </h2>
<?php
  }
?>

    </article>