<?php
  global $post;
  $meta = get_post_meta($post->ID);

  $mp4 = false;
  $webm = false;
  if (!empty($meta['_igv_mp4'][0])) {
    $mp4 = $meta['_igv_mp4'][0];
  }
  if (!empty($meta['_igv_webm'][0])) {
    $webm = $meta['_igv_webm'][0];
  }
?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      <a href="<?php the_permalink() ?>">
<?php
if ($webm) {
?>
        <video class="project-video" preload="auto" loop="true" muted="true">
          <source src="<?php echo $webm; ?>" type='video/webm'/>
<?php if ($mp4) {
?>
          <source src="<?php echo $mp4; ?>" type='video/mp4'/>
<?php
}
?>
        </video>
<?php
} else {
  the_post_thumbnail();
}
?>
        <h2 class="index-project-title"><?php the_title(); ?></h2>
      </a>
    </article>