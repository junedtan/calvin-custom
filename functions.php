<?php
if ( !defined('CSS_JS_VERSION') ) define( 'CSS_JS_VERSION', '1.00');
if ( !defined('TEMPLATE_PATH') ) define( 'TEMPLATE_PATH', get_bloginfo('stylesheet_directory'));
if ( !defined('TEMPLATE_IMAGE_PATH') ) define( 'TEMPLATE_IMAGE_PATH', get_bloginfo('stylesheet_directory') . '/assets/img');

function pr($r) {
  echo '<pre>';
  print_r($r);
  echo '</pre>';
}

function pd($r) {
  echo '<pre>';
  print_r($r);
  echo '</pre>';
  die();
}

/**
 * Custom body classes.
 */
function ccm_body_class($classes) {
  global $post;
  // homepage or not
  if (is_front_page() == FALSE) {
    $classes[] = 'not-home';
  }
  // post type
  $classes[] = sprintf('post-type-%s', $post->post_type);
  // page slug
  $post_slug = $post->post_name;
  $classes[] = sprintf('page-%s', $post_slug);
  // permalink classes
  $permalink = str_replace(home_url(), '', get_permalink());
  $permalink_parts = explode('/', $permalink);
  foreach($permalink_parts as $part) {
    if (!empty($part)) {
      $classes[] = sprintf('page-%s', $part);
    }
  }
  // user logged in status
  if (is_user_logged_in()) {
    $classes[] = 'logged-in';
  }
  // user role
  $current_user = wp_get_current_user();
  if ($current_user && in_array('administrator', $current_user->roles)) {
    $classes[] = 'is-admin';
  }
  return $classes;
}
add_filter('body_class', 'ccm_body_class');

// add css and javascript
function ccm_css_js() {
  wp_enqueue_script("jquery-ol", "https://code.jquery.com/jquery-3.7.1.min.js");
  wp_enqueue_script( 'flickity-js', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js', array(), '', true );
  wp_enqueue_script( 'flickity-js-fade', 'https://cdn.jsdelivr.net/npm/flickity-fade@1/flickity-fade.js', array('flickity-js'), '', true);
  wp_enqueue_script( 'parallax-js', get_template_directory_uri() . '/assets/js/parallax.js', array("jquery-ol"), '1.0.0', true );
  wp_enqueue_script( 'headroom-js', 'https://cdn.jsdelivr.net/npm/headroom.js@0.12.0/dist/headroom.min.js', array(), '', true );
  wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/assets/js/global.min.js', array("jquery-ol"), CSS_JS_VERSION, true );
  // wp_enqueue_script( 'pages', get_template_directory_uri() . '/assets/js/pages.min.js', array("jquery-core-js"), CSS_JS_VERSION, true );
  // css
  wp_enqueue_style( 'flickity-css', 'https://unpkg.com/flickity@2/dist/flickity.min.css', array(), '', 'all' );
  wp_enqueue_style( 'flickity-css-fade', 'https://cdn.jsdelivr.net/npm/flickity-fade@1/flickity-fade.css', array(), '', 'all' );
  wp_enqueue_style( 'app', get_stylesheet_directory_uri() . '/assets/css/app.css', array(), CSS_JS_VERSION, 'all' );
}
add_action('wp_enqueue_scripts', 'ccm_css_js');

// disable emojis
function ccm_disable_wp_emoji() {
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'ccm_disable_emoji_tinymce' );
}

function ccm_disable_emoji_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}
add_action( 'init', 'ccm_disable_wp_emoji' );

add_filter( 'emoji_svg_url', '__return_false' );

// add title tag
function ccm_theme_support() {
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'ccm_theme_support' );

add_theme_support('post-thumbnails');
// add_image_size( 'press_image', 610, 740, TRUE);
// add_image_size( 'person_image', 610, 480, TRUE);

add_theme_support( 'menus' );

// add acf global content page
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Global Content',
    'menu_title'  => 'Global Content',
  ));
  // acf_add_options_page(array(
  //   'page_title'  => 'Theme Settings',
  //   'menu_title'  => 'Theme Settings',
  // ));
}

// editor css for blocks preview styling
add_editor_style( 'assets/css/editor.css' );
add_theme_support( 'editor-styles' );

// blocks
add_action('acf/init', 'ccm_acf_init_block_types');
function ccm_acf_init_block_types() {
  if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(
      array(
        'name'              => 'text',
        'title'             => __('Text'),
        'render_template'   => 'blocks/text.php',
        'category'          => 'calvin-custom-theme',
        'icon'              => 'buddicons-buddypress-logo',
        'keywords'          => array( 'text' ),
        'mode'              => 'edit',
        'supports'          => array('mode' => TRUE, 'anchor' => TRUE),
      )
    );
    acf_register_block_type(
      array(
        'name'              => 'media',
        'title'             => __('Media'),
        'render_template'   => 'blocks/media.php',
        'category'          => 'calvin-custom-theme',
        'icon'              => 'buddicons-buddypress-logo',
        'keywords'          => array( 'media' ),
        'mode'              => 'edit',
        'supports'          => array('mode' => TRUE, 'anchor' => TRUE),
      )
    );
    acf_register_block_type(
      array(
        'name'              => 'text-columns',
        'title'             => __('Text Columns'),
        'render_template'   => 'blocks/text-columns.php',
        'category'          => 'calvin-custom-theme',
        'icon'              => 'buddicons-buddypress-logo',
        'keywords'          => array( 'text-columns' ),
        'mode'              => 'edit',
        'supports'          => array('mode' => TRUE, 'anchor' => TRUE),
      )
    );
    acf_register_block_type(
      array(
        'name'              => 'image-carousel',
        'title'             => __('Image Carousel'),
        'render_template'   => 'blocks/image-carousel.php',
        'category'          => 'calvin-custom-theme',
        'icon'              => 'buddicons-buddypress-logo',
        'keywords'          => array( 'image carousel' ),
        'mode'              => 'edit',
        'supports'          => array('mode' => TRUE, 'anchor' => TRUE),
      )
    );
    acf_register_block_type(
      array(
        'name'              => 'image-grid',
        'title'             => __('Image Grid'),
        'render_template'   => 'blocks/image-grid.php',
        'category'          => 'calvin-custom-theme',
        'icon'              => 'buddicons-buddypress-logo',
        'keywords'          => array( 'image grid' ),
        'mode'              => 'edit',
        'supports'          => array('mode' => TRUE, 'anchor' => TRUE),
      )
    );
    acf_register_block_type(
      array(
        'name'              => 'content-index',
        'title'             => __('Content Index'),
        'render_template'   => 'blocks/content-index.php',
        'category'          => 'calvin-custom-theme',
        'icon'              => 'buddicons-buddypress-logo',
        'keywords'          => array( 'content index' ),
        'mode'              => 'edit',
        'supports'          => array('mode' => TRUE, 'anchor' => TRUE),
      )
    );
    acf_register_block_type(
      array(
        'name'              => 'content-accordion',
        'title'             => __('Content Accordion'),
        'render_template'   => 'blocks/content-accordion.php',
        'category'          => 'calvin-custom-theme',
        'icon'              => 'buddicons-buddypress-logo',
        'keywords'          => array( 'content accordion' ),
        'mode'              => 'edit',
        'supports'          => array('mode' => TRUE, 'anchor' => TRUE),
      )
    );
  }
}

// hide core blocks from editor
function ccm_allowed_block_types( $allowed_blocks, $editor_context ) {
  return array(
    'acf/text',
    'acf/media',
    'acf/text-columns',
    'acf/image-carousel',
    'acf/image-grid',
    'acf/content-index',
    'acf/content-accordion',
  );
}
add_filter( 'allowed_block_types_all', 'ccm_allowed_block_types', 10, 2);

add_filter( 'gform_disable_form_theme_css', '__return_true' );

function ccm_custom_new_menu() {
  register_nav_menus(
    array(
      'main-navigation' => __( 'Main Navigation' ),
    )
  );
}
add_action( 'init', 'ccm_custom_new_menu' );

function ccm_redirect_to_first_child() {
  global $post;
  $pagekids = get_pages("child_of=".$post->ID."&sort_column=menu_order");
  $firstchild = is_array($pagekids) && count($pagekids) > 0 ? $pagekids[0] : null;
  if ($firstchild) {
    wp_redirect(get_permalink($firstchild->ID));
    exit;
  }
}

require_once(__DIR__.'/functions-theme.php');
require_once(__DIR__.'/shortcodes.php');
