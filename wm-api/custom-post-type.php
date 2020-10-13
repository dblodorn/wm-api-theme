<?php

add_action( 'after_switch_theme', 'fs_flush_rewrite_rules' );

function fs_flush_rewrite_rules() {
	flush_rewrite_rules();
}

//-------------------------------------------------------------------
// CUSTOM POST TYPE: Projects
//-------------------------------------------------------------------

add_action( 'init', 'project_cpt' );

function project_cpt() {
  $labels = array(
    'name'               => _x( 'W&M Projects', 'post type general name', 'your-plugin-textdomain' ),
    'singular_name'      => _x( 'W&M Projects', 'post type singular name', 'your-plugin-textdomain' ),
    'menu_name'          => _x( 'W&M Projects', 'admin menu', 'your-plugin-textdomain' ),
    'name_admin_bar'     => _x( 'W&M Projects', 'add new on admin bar', 'your-plugin-textdomain' ),
    'add_new'            => _x( 'Add New', 'Project', 'your-plugin-textdomain' ),
    'add_new_item'       => __( 'Add New Project', 'your-plugin-textdomain' ),
    'new_item'           => __( 'New Project', 'your-plugin-textdomain' ),
    'edit_item'          => __( 'Edit Project', 'your-plugin-textdomain' ),
    'view_item'          => __( 'View Project', 'your-plugin-textdomain' ),
    'all_items'          => __( 'All Projects', 'your-plugin-textdomain' ),
    'search_items'       => __( 'Search Projects', 'your-plugin-textdomain' ),
    'parent_item_colon'  => __( 'Parent Project:', 'your-plugin-textdomain' ),
    'not_found'          => __( 'No Project found.', 'your-plugin-textdomain' ),
    'not_found_in_trash' => __( 'No Project found in Trash.', 'your-plugin-textdomain' )
  );
  $args = array(
    'labels'             => $labels,
    'description'        => __( 'Description.', 'your-plugin-textdomain' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'project' ),
    'capability_type'    => 'post',
    'taxonomies'         => array('type', 'director', 'client', 'agency'),
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-admin-site',
    'show_in_rest'       => true,
    'rest_base'          => 'project-api',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    'supports'           => array( 'title', 'editor', 'author', 'page-attributes', 'thumbnail' )
  );
  register_post_type( 'project', $args );
}

//-------------------------------------------------------------------
// CUSTOM TAXONOMIES: Projects
//-------------------------------------------------------------------

// Product Category Taxonomy
add_action( 'init', 'director_taxonomy', 30 ); 
  function director_taxonomy() {
  $labels = array(
    'name'                  => _x( 'Directors', 'taxonomy general name' ),
    'singular_name'         => _x( 'Director', 'taxonomy singular name' ),
    'search_items'          => __( 'Search Directors' ),
    'all_items'             => __( 'All Directors' ),
    'parent_item'           => __( 'Parent Directors' ),
    'parent_item_colon'     => __( 'Parent Director:' ),
    'edit_item'             => __( 'Edit Director' ),
    'update_item'           => __( 'Update Director' ),
    'add_new_item'          => __( 'Add New Director' ),
    'new_item_name'         => __( 'New Director Name' ),
    'menu_name'             => __( 'Director' ),
  );
  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'director' ),
    'show_in_rest'          => true,
    'rest_base'             => 'director-api',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );
  register_taxonomy('director', array( 'project', 'not-our-work' ), $args);
}

add_action( 'init', 'type_taxonomy', 30 ); 
  function type_taxonomy() {
  $labels = array(
    'name'                  => _x( 'Project types', 'taxonomy general name' ),
    'singular_name'         => _x( 'Project type', 'taxonomy singular name' ),
    'search_items'          => __( 'Search Project types' ),
    'all_items'             => __( 'All Project types' ),
    'parent_item'           => __( 'Parent Project types' ),
    'parent_item_colon'     => __( 'Parent Project type:' ),
    'edit_item'             => __( 'Edit Project type' ),
    'update_item'           => __( 'Update Project type' ),
    'add_new_item'          => __( 'Add New Project type' ),
    'new_item_name'         => __( 'New Project type Name' ),
    'menu_name'             => __( 'Project type' ),
  );
  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'type' ),
    'show_in_rest'          => true,
    'rest_base'             => 'type-api',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );
  register_taxonomy('type', array( 'project', 'not-our-work' ), $args);
}

// Product Category Taxonomy
add_action( 'init', 'agency_taxonomy', 30 ); 
  function agency_taxonomy() {
  $labels = array(
    'name'                  => _x( 'Agencies', 'taxonomy general name' ),
    'singular_name'         => _x( 'Agency', 'taxonomy singular name' ),
    'search_items'          => __( 'Search Agencies' ),
    'all_items'             => __( 'All Agencies' ),
    'parent_item'           => __( 'Parent Agencies' ),
    'parent_item_colon'     => __( 'Parent Agency:' ),
    'edit_item'             => __( 'Edit Agency' ),
    'update_item'           => __( 'Update Agency' ),
    'add_new_item'          => __( 'Add New Agency' ),
    'new_item_name'         => __( 'New Agency Name' ),
    'menu_name'             => __( 'Agency' ),
  );
  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'agency' ),
    'show_in_rest'          => true,
    'rest_base'             => 'agency-api',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );
  register_taxonomy('agency', array( 'project' ), $args);
}

add_action( 'init', 'client_taxonomy', 30 ); 
  function client_taxonomy() {
  $labels = array(
    'name'                  => _x( 'Clients', 'taxonomy general name' ),
    'singular_name'         => _x( 'Client', 'taxonomy singular name' ),
    'search_items'          => __( 'Search Clients' ),
    'all_items'             => __( 'All Clients' ),
    'parent_item'           => __( 'Parent Clients' ),
    'parent_item_colon'     => __( 'Parent Client:' ),
    'edit_item'             => __( 'Edit Client' ),
    'update_item'           => __( 'Update Client' ),
    'add_new_item'          => __( 'Add New Client' ),
    'new_item_name'         => __( 'New Client Name' ),
    'menu_name'             => __( 'Client' ),
  );
  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'client' ),
    'show_in_rest'          => true,
    'rest_base'             => 'client-api',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );
  register_taxonomy('client', array( 'project' ), $args);
}

//-------------------------------------------------------------------
// CUSTOM TAXONOMY FILTER DROPDOWNS IN ADMIN
//-------------------------------------------------------------------

function tsm_filter_post_type_by_taxonomy($post_type, $taxonomy) {
	global $typenow;
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __("All {$info_taxonomy->label}"),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}

function filter_director() {
  tsm_filter_post_type_by_taxonomy('project', 'director');
}

function filter_type() {
  tsm_filter_post_type_by_taxonomy('project', 'type');
}

function filter_client() {
  tsm_filter_post_type_by_taxonomy('project', 'client');
}

function filter_agency() {
  tsm_filter_post_type_by_taxonomy('project', 'agency');
}

add_action('restrict_manage_posts', 'filter_director');
add_action('restrict_manage_posts', 'filter_type');
add_action('restrict_manage_posts', 'filter_client');
add_action('restrict_manage_posts', 'filter_agency');

// NEXT
function tsm_convert_id_to_term_in_query_director($query) {
	global $pagenow;
	$post_type = 'project';
	$taxonomy  = 'director';
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

function tsm_convert_id_to_term_in_query_type($query) {
	global $pagenow;
	$post_type = 'project';
	$taxonomy  = 'type';
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

function tsm_convert_id_to_term_in_query_client($query) {
	global $pagenow;
	$post_type = 'project';
	$taxonomy  = 'client';
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

function tsm_convert_id_to_term_in_query_agency($query) {
	global $pagenow;
	$post_type = 'project';
	$taxonomy  = 'agency';
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

add_filter('parse_query', 'tsm_convert_id_to_term_in_query_director');
add_filter('parse_query', 'tsm_convert_id_to_term_in_query_type');
add_filter('parse_query', 'tsm_convert_id_to_term_in_query_client');
add_filter('parse_query', 'tsm_convert_id_to_term_in_query_agency');

//-------------------------------------------------------------------
// CUSTOM POST TYPE: NOT OUR WORK
//-------------------------------------------------------------------

add_action( 'init', 'not_our_work_cpt' );

function not_our_work_cpt() {
  $labels = array(
    'name'               => _x( 'Not Our Work', 'post type general name', 'your-plugin-textdomain' ),
    'singular_name'      => _x( 'Not Our Work', 'post type singular name', 'your-plugin-textdomain' ),
    'menu_name'          => _x( 'Not Our Work', 'admin menu', 'your-plugin-textdomain' ),
    'name_admin_bar'     => _x( 'Not Our Work', 'add new on admin bar', 'your-plugin-textdomain' ),
    'add_new'            => _x( 'Add New', 'Not Our Work', 'your-plugin-textdomain' ),
    'add_new_item'       => __( 'Add New Not Our Work', 'your-plugin-textdomain' ),
    'new_item'           => __( 'New Not Our Work', 'your-plugin-textdomain' ),
    'edit_item'          => __( 'Edit Not Our Work', 'your-plugin-textdomain' ),
    'view_item'          => __( 'View Not Our Work', 'your-plugin-textdomain' ),
    'all_items'          => __( 'All Not Our Work', 'your-plugin-textdomain' ),
    'search_items'       => __( 'Search Not Our Work', 'your-plugin-textdomain' ),
    'parent_item_colon'  => __( 'Parent Not Our Work:', 'your-plugin-textdomain' ),
    'not_found'          => __( 'No Not Our Work found.', 'your-plugin-textdomain' ),
    'not_found_in_trash' => __( 'No Not Our Work found in Trash.', 'your-plugin-textdomain' )
  );
  $args = array(
    'labels'             => $labels,
    'description'        => __( 'Description.', 'your-plugin-textdomain' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'not-our-work' ),
    'capability_type'    => 'post',
    'taxonomies'         => array('director', 'type'),
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 50,
    'menu_icon'          => 'dashicons-format-video',
    'show_in_rest'       => true,
    'rest_base'          => 'not-our-work-api',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    'supports'           => array( 'title', 'editor', 'author', 'page-attributes', 'thumbnail' )
  );
  register_post_type( 'not-our-work', $args );
}

function filter_director_now() {
  tsm_filter_post_type_by_taxonomy('not-our-work', 'director');
}

function filter_type_now() {
  tsm_filter_post_type_by_taxonomy('not-our-work', 'type');
}

add_action('restrict_manage_posts', 'filter_director_now');
add_action('restrict_manage_posts', 'filter_type_now');

function tsm_convert_id_to_term_in_query_director_now($query) {
	global $pagenow;
	$post_type = 'not-our-work';
	$taxonomy  = 'director';
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

function tsm_convert_id_to_term_in_query_type_now($query) {
	global $pagenow;
	$post_type = 'not-our-work';
	$taxonomy  = 'type';
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

add_filter('parse_query', 'tsm_convert_id_to_term_in_query_director_now');
add_filter('parse_query', 'tsm_convert_id_to_term_in_query_type_now');


//-------------------------------------------------------------------
// WATCH MENU
//-------------------------------------------------------------------

add_action("admin_menu", "add_menu_item_custom_posts");

function add_menu_item_custom_posts() {
  add_menu_page('Watch', 'Watch', 'edit_posts', 'watch_menu', 'display_custom_posts_page', 'dashicons-playlist-video', 30);
}

//-------------------------------------------------------------------
// CUSTOM POST TYPE: WATCH Scedule
//-------------------------------------------------------------------

add_action( 'init', 'watch_schedules_cpt' );

function watch_schedules_cpt() {
  $labels = array(
    'name'               => _x( 'Watch Schedules', 'post type general name', 'your-plugin-textdomain' ),
    'singular_name'      => _x( 'Watch Schedule', 'post type singular name', 'your-plugin-textdomain' ),
    'menu_name'          => _x( 'Watch Schedules', 'admin menu', 'your-plugin-textdomain' ),
    'name_admin_bar'     => _x( 'Watch Schedules', 'add new on admin bar', 'your-plugin-textdomain' ),
    'add_new'            => _x( 'Add New', 'Schedule', 'your-plugin-textdomain' ),
    'add_new_item'       => __( 'Add New Watch Schedule', 'your-plugin-textdomain' ),
    'new_item'           => __( 'New Schedule', 'your-plugin-textdomain' ),
    'edit_item'          => __( 'Edit Schedule', 'your-plugin-textdomain' ),
    'view_item'          => __( 'View Schedule', 'your-plugin-textdomain' ),
    'all_items'          => __( 'All Schedules', 'your-plugin-textdomain' ),
    'search_items'       => __( 'Search Schedules', 'your-plugin-textdomain' ),
    'parent_item_colon'  => __( 'Parent Schedule:', 'your-plugin-textdomain' ),
    'not_found'          => __( 'No Schedule found.', 'your-plugin-textdomain' ),
    'not_found_in_trash' => __( 'No Schedule found in Trash.', 'your-plugin-textdomain' )
  );
  $args = array(
    'labels'             => $labels,
    'description'        => __( 'Description.', 'your-plugin-textdomain' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => 'watch_menu',
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'watch_schedules' ),
    'capability_type'    => 'post',
    'taxonomies'         => array('category'),
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-smiley',
    'show_in_rest'       => true,
    'rest_base'          => 'watch-schedules-api',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    'supports'           => array( 'title', 'editor', 'author', 'page-attributes', 'thumbnail' )
  );
  register_post_type( 'watch_schedules', $args );
}

//-------------------------------------------------------------------
// CUSTOM POST TYPE: WATCH Scedule
//-------------------------------------------------------------------

add_action( 'init', 'watch_curations_cpt' );

function watch_curations_cpt() {
  $labels = array(
    'name'               => _x( 'Watch Curations', 'post type general name', 'your-plugin-textdomain' ),
    'singular_name'      => _x( 'Watch Curations', 'post type singular name', 'your-plugin-textdomain' ),
    'menu_name'          => _x( 'Watch Curations', 'admin menu', 'your-plugin-textdomain' ),
    'name_admin_bar'     => _x( 'Watch Curations', 'add new on admin bar', 'your-plugin-textdomain' ),
    'add_new'            => _x( 'Add New', 'Watch Curations', 'your-plugin-textdomain' ),
    'add_new_item'       => __( 'Add New Watch Curations', 'your-plugin-textdomain' ),
    'new_item'           => __( 'New Watch Curations', 'your-plugin-textdomain' ),
    'edit_item'          => __( 'Edit Watch Curations', 'your-plugin-textdomain' ),
    'view_item'          => __( 'View Watch Curations', 'your-plugin-textdomain' ),
    'all_items'          => __( 'All Watch Curations', 'your-plugin-textdomain' ),
    'search_items'       => __( 'Search Watch Curations', 'your-plugin-textdomain' ),
    'parent_item_colon'  => __( 'Parent Watch Curations:', 'your-plugin-textdomain' ),
    'not_found'          => __( 'No Watch Curations found.', 'your-plugin-textdomain' ),
    'not_found_in_trash' => __( 'No Watch Curations found in Trash.', 'your-plugin-textdomain' )
  );
  $args = array(
    'labels'             => $labels,
    'description'        => __( 'Description.', 'your-plugin-textdomain' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => 'watch_menu',
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'watch-curations' ),
    'capability_type'    => 'post',
    'taxonomies'         => array('category', 'curator'),
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-format-video',
    'show_in_rest'       => true,
    'rest_base'          => 'watch-curations-api',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    'supports'           => array( 'title', 'editor', 'author', 'page-attributes', 'thumbnail' )
  );
  register_post_type( 'watch-curations', $args );
}

add_action( 'init', 'curator_taxonomy', 30 ); 
  function curator_taxonomy() {
  $labels = array(
    'name'                  => _x( 'Curator', 'taxonomy general name' ),
    'singular_name'         => _x( 'Curator', 'taxonomy singular name' ),
    'search_items'          => __( 'Search Curators' ),
    'all_items'             => __( 'All Curators' ),
    'parent_item'           => __( 'Parent Curators' ),
    'parent_item_colon'     => __( 'Parent Curator:' ),
    'edit_item'             => __( 'Edit Curator' ),
    'update_item'           => __( 'Update Curator' ),
    'add_new_item'          => __( 'Add New Curator' ),
    'new_item_name'         => __( 'New Curator Name' ),
    'menu_name'             => __( 'Curator' ),
  );
  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'curator' ),
    'show_in_rest'          => true,
    'rest_base'             => 'curator-api',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );
  register_taxonomy('curator', array( 'watch-curations' ), $args);
}

function filter_curator() {
  tsm_filter_post_type_by_taxonomy('watch-curations', 'curator');
}

add_action('restrict_manage_posts', 'filter_curator');

function tsm_convert_id_to_term_in_query_curator($query) {
	global $pagenow;
	$post_type = 'watch-curations';
	$taxonomy  = 'curator';
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}
add_filter('parse_query', 'tsm_convert_id_to_term_in_query_curator');

?>
