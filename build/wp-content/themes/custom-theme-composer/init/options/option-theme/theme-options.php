<?php
/*
 *
 *
 * Registor Theme option
 *
 *
 */
function theme_settings_page() { 
  $active_tab = "theme-support";
  if(isset($_GET["tab"])) {
    if($_GET["tab"] == "theme-support") {
      $active_tab = "theme-support";
    }
    else {
      $active_tab = "social-options";
    }
  }
  ?>
  <div class="wrap">
    <h1><?php echo __('Theme options') ?></h1>
  
    <div class="nav-tab-wrapper" style="border-bottom: 1px solid #ccc;">
      <a href="?page=theme-panel&tab=theme-support" class="nav-tab <?php if($active_tab == 'theme-support'){echo 'nav-tab-active';} ?> "><?php echo __('Themes Support'); ?></a>
      <a href="?page=theme-panel&tab=social-options" class="nav-tab <?php if($active_tab == 'social-options'){echo 'nav-tab-active';} ?>"><?php echo __('Social Options'); ?></a>
    </div>

    <form method="post" action="options.php">
      <?php
        settings_fields("theme-setting");
        do_settings_sections("theme-options");
        submit_button();
      ?>
    </form>
  </div>
<?php
}



/*
 *
 *
 * Registor Theme option
 *
 *
 */
function add_theme_menu_item() {
  add_submenu_page(
    "themes.php",
    "Theme Settings",
    "Theme Settings",
    "manage_options",
    "theme-panel",
    "theme_settings_page",
    null,
    99
  );
}
add_action("admin_menu", "add_theme_menu_item");



/*
 *
 *
 * Registor Fields
 *
 *
 */

// Tab Theme support
function tab_theme_support() {
  // Display Text Field
  add_settings_field(
    "text_field", 
    "Text field", 
    "display_text_element", 
    "theme-options", 
    "theme-setting"
  );
  register_setting("theme-setting", "text_field");

  // Display File Field
  add_settings_field(
    "upload_field", 
    "Upload field", 
    "display_upload_element", 
    "theme-options", 
    "theme-setting"
  );
  register_setting("theme-setting", "upload_field");
}

// Tab Social options
function tab_social_options() {
  // Display Fields
  add_settings_field(
    "ajax_field", 
    "Ajax field", 
    "display_ajax_element", 
    "theme-options", 
    "theme-setting"
  );
  register_setting("theme-setting", "ajax_field");
}



/*
 *
 *
 * Display in dasboard
 *
 *
 */
function display_theme_panel_fields() {
  // Add Section
  add_settings_section("theme-setting", "Theme Setting", null, "theme-options");

  if(isset($_GET["tab"])) {

    if($_GET["tab"] == "theme-support") {
      tab_theme_support();
    } else {
      tab_social_options();
    }
  } else {
      tab_theme_support();
  }
}
add_action("admin_init", "display_theme_panel_fields");



/*
 *
 *
 * Fields for Theme Option
 *
 *
 */

// Text Field
function display_text_element() { ?>
  <input type="text" name="text_field" value="<?php echo get_option('text_field'); ?>" />
<?php
}

// Upload Field
function display_upload_element() { 
  if(function_exists( 'wp_enqueue_media' )){
  wp_enqueue_media();
  } else {
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
  }
  ?>
  <div class="upload_demo"><img class="thumbnail_image" src="<?php echo get_option('upload_field'); ?>" width="150"/></div>
  <div class="upload_url"><input class="value_image" type="text" name="upload_field" value="<?php echo get_option('upload_field'); ?>" /></div>
  <div><a href="#" class="upload_image">Upload</a> <a href="#" class="remove_image">Remove</a></div>
<?php
  media_upload();
}

// Ajax field
function display_ajax_element() { ?>
  <div class="ajax_group">
    <div class="ajax-action" style="margin-bottom: 10px;">
      <button class="ajax-add button button-primary">Add Field</button>
      <button class="ajax-remove button button-primary" disabled="disabled">Remove Field</button>
    </div>
    <div class="ajax-list">
      <div class="ajax-item">
        <input type="text" name="ajax_field" value="<?php echo get_option('ajax_field'); ?>" />
      </div>
    </div>
  </div>
<?php
}

/*add_action( 'wp_ajax_ajaxloadfields', 'ajaxloadfields_callback' );
add_action( 'wp_ajax_nopriv_ajaxloadfields', 'ajaxloadfields_callback' );
function ajaxloadfields_callback() {
  $values = $_REQUEST;
  $content = get_option('ajax_field');
  $result = json_encode(array('markup' => $content));
  echo $result;
  wp_die();
}*/