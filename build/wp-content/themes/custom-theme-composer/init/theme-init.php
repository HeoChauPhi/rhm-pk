<?php
$timber = new \Timber\Timber();

use Timber\Timber;
use Timber\Menu;

// load the theme's framework
require_once dirname( __FILE__ ) . '/theme-support.php';

// Get custom function template with Timber
Timber::$dirname = array('templates', 'templates/blocks', 'templates/shortcode', 'templates/pages', 'templates/layouts', 'templates/views');

// Disable Related post
function related($custom_cat, $showpost = -1) {
  global $post;
  $argss = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'ids');
  $terms = wp_get_post_terms( $post->ID, $custom_cat, $argss );
  $myposts = array(
    'showposts' => $showpost,
    'post_type' => 'any',
    'post__not_in' => array($post->ID),
    'tax_query' => array(
      array(
      'taxonomy' => $custom_cat,
      'field' => 'term_id',
      'terms' => $terms
      )
    )
  );
  $loop_custom = Timber::get_posts($myposts);
  return $loop_custom;
}

// Disable sidebar
function sidebar($name) {
  if ( is_active_sidebar( $name ) ) {
    dynamic_sidebar($name);
  }
  return;
}

// Disable shortcode
function shortcode($name) {
  echo do_shortcode($name);
  return;
}

// Disable ACF plugin function
function acfwidget($name, $widgetid) {
  if (get_field($name, 'widget_'.$widgetid)) {
    $afcfield = get_field($name, 'widget_'.$widgetid);
    //print_r($afcfield);

    if ( !empty( $afcfield ) ) {
      foreach ($afcfield as $field) {
        $layout = $field['acf_fc_layout'];

        try {
          Timber::render($layout . '.twig', $field);
        } catch (Exception $e) {
          echo 'Could not find a twig file for layout type: ' . $layout;
        }
      }
    }
  }
  return;
}

// --> Get object in ACF. Ex: label, slug...
function acfobject($name, $object) {
  $field = get_field_object($name);
  $field_object = $field[$object];
  if (is_array($field_object)) {
    return $field_object;
  } else {
    echo $field_object;
  }
  return;
}

// Disable term in custom taxonomy
function taxvalue($tax) {
  $args = array(
    'parent' => 0,
    'orderby' => 'slug',
    'hide_empty' => false
  );

  $terms = get_terms( $tax, $args);
  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    echo '<ul class="listcat listcat-'.$tax.'">';
    foreach ( $terms as $term ) {
      $subterms1 = get_terms($tax, array('parent' => $term->term_id, 'orderby' => 'slug', 'hide_empty' => false));

      if (sizeof($subterms1) > 0) {
        echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a>';

        // sub term 1
        echo '<ul class="subterm">';
          foreach ($subterms1 as $term) {
            $subterms2 = get_terms($tax, array('parent' => $term->term_id, 'orderby' => 'slug', 'hide_empty' => false));

            if (sizeof($subterms2) > 0) {
              echo '<li class="listcat-item has-subterm"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a>';

              // sub term 2
              echo '<ul class="subterm">';
              foreach ($subterms2 as $term) {
                echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a></li>';
              }
              echo '</ul></li>';
            } else {
              echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a></li>';
            }
          }
        echo '</ul></li>';
      } else {
        echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a></li>';
      }
    }
    echo '</ul>';
  }
}
// --> Disable term format function
function customtax($customtax) {
  ob_start();

  taxvalue($tax = $customtax);

  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
// --> Disable term format shortcode
add_shortcode( 'customtax', 'create_customtax' );
function create_customtax($attrs) {
  extract(shortcode_atts (array(
    'tax_name' => ''
  ), $attrs));
  ob_start();
    taxvalue($tax = $tax_name);
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

// Get term name in custom taxonomy
function get_term_name($slug, $tax){
  $term = get_term_by('slug', $slug, $tax);
  $term_name = array(
    array(
      'name' => $term->name,
      'slug' => $term->slug,
      'link' => esc_url( get_term_link( $term ) ),
    )
  );
  return $term_name;
}

// Get avatar author
function avatar_author($size = '') {
  $avatar = get_avatar( get_the_author_meta( 'ID' ), $size );
  return $avatar;
}

// Flexible content field
function flexible_content($name) {
  $fc_type = array();

  global $post;
  $fc = get_field( $name, $post->ID );
  $fc_ob = get_field_object( $name, $post->ID );

  //print_r($fc);
  //print_r($fc_ob);

  if ( !empty( $fc ) ) {
    foreach ($fc as $field) {
      $layout = $field['acf_fc_layout'];
      $fc_type[$layout] = array();

      if ( $field['acf_fc_layout'] == 'box_views_group' ) {
        $fc_sub = $field['views_shortcode_group']['view_component'];
        //print_r($fc_sub);
        foreach ($fc_sub as $field_sub) {
          $layout_sub = $field_sub['acf_fc_layout'];

          try {
            Timber::render($layout_sub . '.twig', $field_sub);
          } catch (Exception $e) {
            echo 'Could not find a twig file for layout type: ' . $layout_sub;
          }
        }
      } else {
        try {
          Timber::render($layout . '.twig', $field);
        } catch (Exception $e) {
          echo 'Could not find a twig file for layout type: ' . $layout;
        }
      }
    }
  }

  return;
}

function acfobject_field($name, $id) {
  global $post;
  $field = get_field($name, $id);
  return $field;
}

function preg_match_url($field, $extend) {
  preg_match('/src="(.+?)"/', $field, $matches);
  $full_src = $matches[1];
  $src = explode("?", $full_src);

  if($extend) {
    $src = $src[0] . $extend;
  } else {
    $src = $src[0];
  }
  return $src;
}

function get_id_embed($url) {
  $video_id = preg_match_url($url);
  $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
  $result = preg_match($pattern, $video_id, $matches);
  if ($result) {
    return $matches[1];
  }
  return false;
}

function get_id_youtube($url) {
  $video_id = $url;
  $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
  $result = preg_match($pattern, $video_id, $matches);
  if ($result) {
    return $matches[1];
  }
  return false;
}

// Add Timber value
add_filter('timber_context', 'ct_twig_data');
function ct_twig_data($data){
  // Theme setting
  $custom_logo_id = get_theme_mod( 'custom_logo' );
  $custom_logo_attachment = wp_get_attachment_image_src( $custom_logo_id , 'full' );
  $custom_logo = $custom_logo_attachment[0];

  $logo = get_template_directory_uri().'/dist/images/logo.png';
  $favicon = get_template_directory_uri().'/dist/images/favicon.ico';

  $data['site_logo'] = new TimberImage($logo);
  $data['custom_logo'] = new TimberImage($custom_logo);
  $data['site_favicon'] = new TimberImage($favicon);

  $data['flexible_content'] = TimberHelper::function_wrapper( 'flexible_content' );
  $data['preg_match_url'] = TimberHelper::function_wrapper( 'preg_match_url' );
  $data['get_id_embed'] = TimberHelper::function_wrapper( 'get_id_embed' );
  $data['get_id_youtube'] = TimberHelper::function_wrapper( 'get_id_youtube' );
  $data['related'] = TimberHelper::function_wrapper( 'related' );
  $data['sidebar'] = TimberHelper::function_wrapper( 'sidebar' );
  $data['shortcode'] = TimberHelper::function_wrapper( 'shortcode' );
  $data['acfwidget'] = TimberHelper::function_wrapper( 'acfwidget' );
  $data['acfobject_field'] = TimberHelper::function_wrapper( 'acfobject_field' );
  $data['acfobject'] = TimberHelper::function_wrapper( 'acfobject' );
  $data['customtax'] = TimberHelper::function_wrapper( 'customtax' );
  $data['get_term_name'] = TimberHelper::function_wrapper( 'get_term_name' );
  $data['avatar_author'] = TimberHelper::function_wrapper( 'avatar_author' );

  $data['menu']['main'] = new TimberMenu('main');
  $data['menu']['footer'] = new TimberMenu('footer');

  return $data;
}
