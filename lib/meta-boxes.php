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

  $video_args = array(
    'post_type' => 'video',
    'posts_per_page' => -1
  );

	/**
	 * Metaboxes declarations here
   * Reference: https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
	 */

	  // POST

	 $post_meta = new_cmb2_box( array(
      'id'            => $prefix . 'post_metabox',
      'title'         => __( 'Post Options', 'cmb2' ),
      'object_types'  => array( 'post', ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
    ) );

  $post_meta->add_field( array(
		'name'    => __( 'Color Picker', 'cmb2' ),
		'desc'    => __( 'color for post backgound', 'cmb2' ),
		'id'      => $prefix . 'color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

  $post_meta->add_field( array(
		'name'    => __( 'Video (mp4)', 'cmb2' ),
		'desc'    => __( '(optional) video for post background (plays on hover). This file should be an optimized .mp4', 'cmb2' ),
		'id'      => $prefix . 'mp4',
		'type'    => 'file'
	) );

  $post_meta->add_field( array(
		'name'    => __( 'Video (webm)', 'cmb2' ),
		'desc'    => __( 'Same (optional) video as above but this file should be a .webm file', 'cmb2' ),
		'id'      => $prefix . 'webm',
		'type'    => 'file'
	) );

    // PROJECT

  $project_meta = new_cmb2_box( array(
      'id'            => $prefix . 'project_metabox',
      'title'         => __( 'Project Meta', 'cmb2' ),
      'object_types'  => array( 'project', ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
    ) );

  $project_meta->add_field( array(
		'name'    => __( 'Video (mp4)', 'cmb2' ),
		'desc'    => __( '(optional) video for post background (plays on hover). This file should be an optimized .mp4', 'cmb2' ),
		'id'      => $prefix . 'mp4',
		'type'    => 'file'
	) );

  $project_meta->add_field( array(
		'name'    => __( 'Video (webm)', 'cmb2' ),
		'desc'    => __( 'Same (optional) video as above but this file should be a .webm file', 'cmb2' ),
		'id'      => $prefix . 'webm',
		'type'    => 'file'
	) );

  $project_visuals_meta = new_cmb2_box( array(
      'id'            => $prefix . 'project_visuals_metabox',
      'title'         => __( 'Project Visuals', 'cmb2' ),
      'object_types'  => array( 'project', ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
    ) );

  $project_meta_visual_group = $project_visuals_meta->add_field( array(
      'id'          => $prefix . 'project_visuals',
      'type'        => 'group',
      'description' => __( 'Add as many project visuals here as you want. They are either galleries or videos.', 'cmb' ),
      'options'     => array(
        'group_title'   => __( 'Visual Element {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
        'add_button'    => __( 'Add Another Project Visual Element', 'cmb' ),
        'remove_button' => __( 'Remove Element', 'cmb' ),
        'sortable'      => true, // beta
      ),
    ) );

  $project_visuals_meta->add_group_field( $project_meta_visual_group, array(
      'name' => 'Thumbnail',
      'description' => 'This is the thumbnail for this visual item. If the visual is a video setting this will override the automatic thumbnail.',
      'id'   => 'thumbnail',
      'type' => 'file',
    ) );

  $project_visuals_meta->add_group_field( $project_meta_visual_group, array(
      'name' => 'title',
      'description' => 'This is the title for this visual item.',
      'id'   => 'title',
      'type' => 'text',
    ) );

  $project_visuals_meta->add_group_field( $project_meta_visual_group, array(
      'name' => 'Gallery',
      'description' => 'Add a wordpress gallery here',
      'id'   => 'gallery',
      'type' => 'wysiwyg',
      'options' => array( 'textarea_rows' => 4, )
    ) );

  $project_visuals_meta->add_group_field( $project_meta_visual_group, array(
      'name' => 'Video',
      'description' => 'If this visual element is a video choose it from the already added videos here. If you have not added it go to Videos>Add New',
      'id'   => 'video',
      'type'    => 'select',
      'show_option_none' => true,
      'options' => get_post_objects($video_args),
    ) );


  $project_copy_meta = new_cmb2_box( array(
      'id'            => $prefix . 'project_copy_metabox',
      'title'         => __( 'Project Copy', 'cmb2' ),
      'object_types'  => array( 'project', ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
    ) );

  $project_meta_copy_group = $project_copy_meta->add_field( array(
      'id'          => $prefix . 'project_copy',
      'type'        => 'group',
      'description' => __( 'Add as many copy sections for the project as you want', 'cmb' ),
      'options'     => array(
        'group_title'   => __( 'Copy Section {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
        'add_button'    => __( 'Add Another Copy Section', 'cmb' ),
        'remove_button' => __( 'Remove Copy Section', 'cmb' ),
        'sortable'      => true, // beta
      ),
    ) );

  $project_copy_meta->add_group_field( $project_meta_copy_group, array(
      'name' => 'Title',
      'description' => 'Title of this project section',
      'id'   => 'title',
      'type' => 'text',
    ) );

  $project_copy_meta->add_group_field( $project_meta_copy_group, array(
      'name' => 'Copy',
      'description' => 'Add the copy for the section here',
      'id'   => 'copy',
      'type' => 'wysiwyg',
      'options' => array( 'textarea_rows' => 9, )
    ) );

}

?>