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

    // PROJECT

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
        'group_title'   => __( 'Entry {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
        'add_button'    => __( 'Add Another Entry', 'cmb' ),
        'remove_button' => __( 'Remove Entry', 'cmb' ),
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
        'group_title'   => __( 'Entry {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
        'add_button'    => __( 'Add Another Entry', 'cmb' ),
        'remove_button' => __( 'Remove Entry', 'cmb' ),
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