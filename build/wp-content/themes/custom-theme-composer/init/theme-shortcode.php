<?php
// View List
add_shortcode( 'view_list', 'cat_view_list' );
function cat_view_list($attrs) {
  extract(shortcode_atts (array(
    'name'        => '',
    'post_type'   => '',
    'per_page'    => -1,
    'cat_id'      => '',
    'custom_fields' => '',
    'use_pagination' => '',
    'pagination_type' => '',
    'current_paged' => '',
    'filter_select' => 1,
    'show_popup_file' => '',
  ), $attrs));

  ob_start();
    global $paged;
    global $post;
    if (!isset($paged) || !$paged){
      $paged = $current_paged;
    }

    $filter_array = array();
    $meta_query = array('relation' => 'OR',);

    if($custom_fields){
      $fields = explode("+", $custom_fields);
      foreach ($fields as $item) {
        $item_exp = explode('//value//', $item);
        $item_slug_exp = explode('//slug//', $item_exp[0]);
        $item_slug = $item_slug_exp[1];
        //$item_vals = str_replace(" ", "", $item_exp[1]);
        $item_val = $item_exp[1];

        $filter_array['key'] = $item_slug;
        $filter_array['value'] = $item_exp[1];
        $filter_array['compare'] = '=';
        array_push($meta_query, $filter_array);
      }
    }

    $context = Timber::get_context();
    if($custom_fields) {
      $args = array(
        'post_type'       => $post_type,
        'posts_per_page'  => $per_page,
        'cat'             => $cat_id,
        'post_status'          => 'publish',
        'paged' => $paged,
        //'meta_key'   => 'type',
        //'orderby'    => 'meta_value_num',
        //'order'      => 'ASC',
        'meta_query' => $meta_query,
      );
    } else {
      $args = array(
        'post_type'       => $post_type,
        'posts_per_page'  => $per_page,
        'cat'             => $cat_id,
        'post_status'          => 'publish',
        'paged' => $paged,
      );
    }

    query_posts($args);
    $posts = Timber::get_posts($args);
    $context['posts'] = $posts;

    $args_pagi = array(
      'base' => get_pagenum_link(1) . '%_%',
      'format' => 'page/%#%',
    );

    switch ($name) {
      case 'media-press-releases':
        $context['filter_item'] = Timber::get_posts(array(
          'post_type'       => $post_type,
          'posts_per_page'  => -1,
          'post_status'          => 'publish',
        ));
        $context['filter_select'] = $filter_select;
        break;
    }

    $context['pager_base_url'] = get_pagenum_link(1);
    $context['pagination_type'] = $pagination_type;
    $context['use_pagination'] = $use_pagination;
    $context['show_popup_file'] = $show_popup_file;
    $context['pagination'] = Timber::get_pagination($args_pagi);

    try {
    Timber::render( array( 'view-' . $name . '.twig', 'views.twig'), $context );
    } catch (Exception $e) {
      echo 'Could not find a twig file for Shortcode Name: ' . $name;
    }

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}
