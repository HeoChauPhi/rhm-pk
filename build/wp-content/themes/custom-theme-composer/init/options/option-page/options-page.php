<?php
add_action( 'cmb2_admin_init', 'ct_sidebar_option_metaboxes' );
function ct_sidebar_option_metaboxes() {

  $prefix = '_cmb2_';

  $cmb = new_cmb2_box( array(
    'id'            => 'sidebar_options',
    'title'         => __( 'Sidebar Options', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type or any post type use: ct_list_posttype()
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
  ) );

  // Sidebar Left
  $cmb->add_field( array(
    'name'             => __( 'Select Sidebar Left', 'cmb2' ),
    'desc'             => __( 'Choose Sidebar Left for this page', 'cmb2' ),
    'id'               => $prefix . 'sidebar_left',
    'type'             => 'select',
    'show_option_none' => false,
    'options'          => list_registered_sidebars(),
    'default'          => 'none',
  ) );

  $cmb->add_field( array(
    'name'             => __( 'Left Sidebar Menus', 'cmb2' ),
    'desc'             => __( 'Choose Menus for Left Sidebar on this page', 'cmb2' ),
    'id'               => $prefix . 'sidebar_menu',
    'type'             => 'select',
    'show_option_none' => true,
    'options'          => ct_list_nav_menus(),
  ) );

  // Sidebar Right
  /*$cmb->add_field( array(
    'name'             => __( 'Select Sidebar Right', 'cmb2' ),
    'desc'             => __( 'Choose Sidebar Right for this page', 'cmb2' ),
    'id'               => $prefix . 'sidebar_right',
    'type'             => 'select',
    'show_option_none' => false,
    'options'          => list_registered_sidebars(),
    'default'          => 'none',
  ) );*/
}

add_action( 'cmb2_admin_init', 'ct_page_option_metaboxes' );
function ct_page_option_metaboxes() {

  $prefix = '_cmb2_';

  $cmb = new_cmb2_box( array(
    'id'            => 'page_option',
    'title'         => __( 'Page Options', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
  ) );

  // Disable title
  $cmb->add_field( array(
    'name'       => __( 'Disable title', 'cmb2' ),
    'desc'       => __( 'Check it if you want disable this page title', 'cmb2' ),
    'id'         => $prefix . 'title',
    'type'       => 'checkbox'
  ) );

  // Disable title
  $cmb->add_field( array(
    'name'       => __( 'Main Content no Padding', 'cmb2' ),
    'desc'       => __( 'Check it if you want remove padding of main-content on this page', 'cmb2' ),
    'id'         => $prefix . 'no_padding',
    'type'       => 'checkbox'
  ) );

  // Layout Option
  $cmb->add_field( array(
    'name'              => __('Layout page option', 'cmb2'),
    'desc'              => __('Check to setting this page layout', 'cmb2'),
    'id'                => $prefix . 'layout_page',
    'type'              => 'radio',
    'show_option_none'  => false,
    'options'           => array(
      'full'            => __( 'Page full layout', 'cmb2' ),
      'container-wide'       => __( 'Page container layout', 'cmb2' ),
    ),
    'default'           => 'container-wide'
  ) );
}

function framework_page($name = '') {
  global $post;
  $value = get_post_meta( $post->ID, '_cmb2_' . $name, true );
  return $value;
}
