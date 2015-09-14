<?php
get_header();
?>

<!-- main content -->

<main id="main-content">

  <!-- main posts loop -->
  <section id="posts" class="container u-align-center">

<?php

$home_posts = new WP_Query('category_name=featured&posts_per_page=-1');

if ( $home_posts->have_posts() ) {
	while ( $home_posts->have_posts() ) {
		$home_posts->the_post();
    get_template_part('partials/index-post');
	}
}
wp_reset_postdata();

$home_projects = new WP_Query('post_type=project&posts_per_page=-1');

if ( $home_projects->have_posts() ) {
	while ( $home_projects->have_posts() ) {
		$home_projects->the_post();
    get_template_part('partials/index-project');
	}
}
wp_reset_postdata();
?>
  <!-- end posts -->
  </section>

<!-- end main-content -->

</main>

<?php
get_footer();
?>