<?php

/* Get post objects for select field options */
function get_post_objects( $query_args ) {
$args = wp_parse_args( $query_args, array(
    'post_type' => 'post',
) );
$posts = get_posts( $args );
$post_options = array();
if ( $posts ) {
    foreach ( $posts as $post ) {
        $post_options [ $post->ID ] = $post->post_title;
    }
}
return $post_options;
}


/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Hook in and add metaboxes. Can only happen on the 'cmb2_init' hook.
 */
add_action( 'cmb2_init', 'igv_cmb_metaboxes' );
function igv_cmb_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_igv_';

	/**
	 * Metaboxes declarations here
   * Reference: https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
	 */

	$gallery = new_cmb2_box( array(
		'id'            => $prefix . 'gallery_metabox',
		'title'         => __( 'Gallery', 'cmb2' ),
		'object_types'  => array( 'project', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => false, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$gallery->add_field( array(
		'name'    => __( 'Gallery', 'cmb2' ),
		'desc'    => __( 'Slider gallery', 'cmb2' ),
		'id'      => $prefix . 'gallery',
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 5,
			'media_buttons' => true,
			'tinymce' => true,
      'quicktags' => false,
			),
	) );

/*
  $gallery->add_field( array(
    'name' => 'Gallery',
    'desc' => 'Upload and manage gallery',
    'button' => 'Manage gallery',
    'id'   => $prefix . 'gallery_images',
    'type' => 'pw_gallery',
    'sanitization_cb' => 'pw_gallery_field_sanitise',
  ) );
*/

}

?>