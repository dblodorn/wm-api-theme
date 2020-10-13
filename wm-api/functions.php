<?php

define( 'W&M API THEME', 1.0 );
/*-----------------------------------------------------------------------------------*/
/* Theme Setup
/*-----------------------------------------------------------------------------------*/
function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
}

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

add_action( 'admin_menu', 'my_remove_menu_pages' );

function my_remove_menu_pages() {
  remove_menu_page('edit-comments.php');
  remove_menu_page('edit.php');
  remove_menu_page('edit.php?post_type=page');
}

function my_theme_setup() {
  require_once( 'custom-post-type.php' );
  require_once( 'api/api.php');
  add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'my_theme_setup' );

// MENUS

function register_my_menu() {
  register_nav_menu('main-menu',__( 'Main Menu' ));
}

add_action( 'init', 'register_my_menu' );

add_filter( 'template_include', 'phpless_template');

/*-----------------------------------------------------------------------------------*/
/* ACF Add Options Page
/*-----------------------------------------------------------------------------------*/

if(function_exists('acf_add_options_page')) {
  
  acf_add_options_page(array(
    'page_title' 	=> 'Site Settings',
    'menu_title' 	=> 'W&M Site',
    'menu_slug' 	=> 'site-content',
    'capability' 	=> 'edit_posts',
    'icon_url'    => 'dashicons-admin-site',
		'redirect'		=> false,
    'position'    => 10
  ));

  acf_add_options_page(array(
    'page_title' 	=> 'Contact Info',
    'menu_title' 	=> 'Contact Info',
    'menu_slug' 	=> 'contact-info',
		'parent_slug'	=> 'site-content',
  ));

  acf_add_options_page(array(
    'page_title' 	=> 'Socials',
    'menu_title' 	=> 'Socials',
    'menu_slug' 	=> 'socials',
		'parent_slug'	=> 'site-content',
  ));

  acf_add_options_page(array(
    'page_title' 	=> 'Watch Scheduling',
    'menu_title' 	=> 'Watch Scheduling',
    'menu_slug' 	=> 'watch-scheduling',
		'capability' 	=> 'edit_posts',
    'icon_url'    => 'dashicons-welcome-view-site',
		'redirect'		=> false,
    'position'    => 35
  ));
}

function get_current_template() {
  global $template;
  return basename($template, '.php');
}

function get_current_post() {
  global $post; $post_slug=$post->post_name;;
  return $post_slug;
}

/*-----------------------------------------------------------------------------------*/
/* ALLOW SVG
/*-----------------------------------------------------------------------------------*/

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/*-----------------------------------------------------------------------------------*/
/* REMOVE EMOJI SHIT
/*-----------------------------------------------------------------------------------*/ 

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/*-----------------------------------------------------------------------------------*/
/* NETLIFY PUBLISH PERMISSIONS
/*-----------------------------------------------------------------------------------*/ 

add_filter('netlify_status_capability', function() {
  return 'edit_pages';
});

add_filter('netlify_deploy_capability', function() {
  return 'edit_pages';
});

function acf_set_featured_image( $value, $post_id, $field  ){ 
  if($value != ''){
    //Add the value which is the image ID to the _thumbnail_id meta data for the current post
    add_post_meta($post_id, '_thumbnail_id', $value);
  }
  return $value;
}

// acf/update_value/name={$field_name} - filter for a specific field based on it's name
add_filter('acf/update_value/name=video_thumbs', 'acf_set_featured_image', 10, 3);
