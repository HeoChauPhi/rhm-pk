<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context["acf"] = get_field_objects($data["post"]->ID);

$post_type = get_post_type();

/*switch( $post_type ) {
  case 'news':
    $menu_obj = wp_get_nav_menu_object('News menu');
    $context['menu_select'] = new TimberMenu($menu_obj->term_id);
  break;
}*/

Timber::render( 'single.twig', $context );
