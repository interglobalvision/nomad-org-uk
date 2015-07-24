  <footer id="footer" class="container font-caption u-align-center">
     &copy; <?php echo date('Y');?>, NOMAD web & identity design by <a href="http://modernactivity.com/" target="_blank">Modern Activity</a>, build by <a href="http://interglobal.vision/" target="_blank">Interglobal Vision</a>
  </footer>
  <?php get_template_part('partials/scripts'); ?>

  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "url": "<?php echo home_url(); ?>",
      "logo": "<?php echo get_bloginfo( 'template_directory' ); ?>/img/login-logo.png",
      "sameAs" : [
        "https://www.facebook.com/pages/Nomad/26516639196",
        "https://twitter.com/NOMAD_Ltd",
        "https://vimeo.com/nomadtelevision",
        "https://instagram.com/nomadorguk/"
        ]
    }
  </script>

  </body>
</html>