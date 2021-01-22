<?php

function landing_projects() {
  $homepage = get_field( 'homepage', 'option' );
  $projects = false;
  if ( $homepage ):
    foreach ( $homepage as $post ):
      $projects[] = project_data($post, $p);
    endforeach;
    wp_reset_postdata();
  endif;
  return $projects;
}

function return_meta($group) {
  $data = array();
  if ( have_rows( $group, 'option' ) ) :
    while ( have_rows( $group, 'option' ) ) : the_row();
    $data = array(
      'title' => return_null_false(get_sub_field( 'title')),
      'meta_description' => return_null_false(get_sub_field( 'meta_description')),
      'social_card' => return_null_false(get_sub_field( 'social_card')),
      'social_video' => return_null_false(get_sub_field( 'social_video')),
    );
    endwhile;
    return $data;
  else:
    return false;
  endif;
}

function return_styling() {
  return array(
    'bg_color' => get_field( 'background_color', 'option' ),
    'logo_color' => get_field( 'logo_color', 'option' ),
    'button_hover_color' => get_field( 'button_hover_color', 'option' ),
    'loading_indicator_color' => get_field( 'loading_indicator_color', 'option' ),
    'about_button_hover_color' => get_field( 'about_button_hover_color', 'option' ),
    'text_hover_color' => get_field( 'text_hover_color', 'option' ),
    'thumb_text_color' => get_field( 'thumb_text_color', 'option' ),
    'blockquote_text_color' => get_field( 'blockquote_text_color', 'option' ),
    'blockquote_quote_color' => get_field( 'blockquote_quote_color', 'option' ),
    'text_mode_hover_a' => get_field( 'text_mode_hover_a', 'option' ),
    'text_mode_hover_b' => get_field( 'text_mode_hover_b', 'option' ),
    'text_mode_hover_c' => get_field( 'text_mode_hover_c', 'option' ),
    'text_mode_hover_d' => get_field( 'text_mode_hover_d', 'option' ),
  );
}

function return_tags($field) {
  $data = array();
  $tags_terms = get_sub_field( $field );
  if ( $tags_terms ):
    foreach ( $tags_terms as $tags_term ):
      $data[] = array(
        'id' => $tags_term->term_id,
        'slug' => $tags_term->slug,
        'name' => $tags_term->name,
      );
    endforeach;
    return $data;
  else:
    return false;
  endif;
}

function return_tag_block($group) {
  $data = array();
  if ( have_rows( $group, 'option' ) ) :
    while ( have_rows( $group, 'option' ) ) : the_row();
    $data = array(
      'headline' => return_null_false(get_sub_field( 'headline')),
      'tags' => return_tags('tags'),
    );
    endwhile;
    return $data;
  else:
    return false;
  endif;
}

function return_clients() {
  $data = array();
  if ( have_rows( 'client_section', 'option' ) ) :
    while ( have_rows( 'client_section', 'option' ) ) : the_row();
    $images = get_sub_field( 'logos' );
    $data = array(
      'headline' => return_null_false(get_sub_field( 'headline')),
      'logos' => simple_slideshow_gallery($images),
    );
    endwhile;
    return $data;
  else:
    return false;
  endif;
}

function return_intro_layout() {
  $fc_layout_modules = array();
  if ( have_rows( 'about_intro', 'option' ) ) :
    while ( have_rows( 'about_intro', 'option' ) ) : the_row();
      if(get_row_layout() == 'copy'):
        $data = array(
          'layout' => 'copy',
          'copy' => get_sub_field( 'copy' ),
        );
      elseif(get_row_layout() == 'category_link'):
        $tag = get_sub_field( 'category' );
        $data = array(
          'layout' => 'category_link',
          'tag_slug' => $tag->slug,
          'tag_name' => $tag->name,
        );
      else:
        $data = array(
          'layout' => 'blank'
        );
      endif;
      $fc_layout_modules[] = $data;
    endwhile;
  endif;
  return $fc_layout_modules;
}

function return_about() {
  return array(
    'meta' => return_meta('about_meta'),
    'about_copy' => get_field( 'about_copy', 'option' ),
    'clients' => return_clients(),
    'services' => return_tag_block('services_section'),
    'genres' => return_tag_block('genre_section'),
    'intro' => return_intro_layout()
  );
}

function return_emails() {
  $data = array();
  if ( have_rows( 'contact_emails', 'option' ) ) :
    while ( have_rows( 'contact_emails', 'option' ) ) : the_row();
    $data[] = array(
      'cta' => return_null_false(get_sub_field( 'cta')),
      'address' => return_null_false(get_sub_field( 'address')),
    );
    endwhile;
    return $data;
  else:
    return false;
  endif;
}

function return_socials() {
  $data = array();
  if ( have_rows( 'social_channels', 'option' ) ) :
    while ( have_rows( 'social_channels', 'option' ) ) : the_row();
    $icon = get_sub_field( 'icon' );
    $data[] = array(
      'name' => return_null_false(get_sub_field( 'name')),
      'link' => return_null_false(get_sub_field( 'link')),
      'icon' => return_null_false($icon),
    );
    endwhile;
    return $data;
  else:
    return false;
  endif;
}

function return_masthead() {
  $data = array();
  if ( have_rows( 'masthead', 'option' ) ) :
    while ( have_rows( 'masthead', 'option' ) ) : the_row();
    $data[] = array(
      'name' => return_null_false(get_sub_field( 'name')),
      'title' => return_null_false(get_sub_field( 'title')),
      'email_address' => return_null_false(get_sub_field( 'email_address')),
    );
    endwhile;
    return $data;
  else:
    return false;
  endif;
}

function return_contact() {
  return array(
    'meta' => return_meta('contact_meta'),
    'masthead' => return_masthead(),
    'address' => get_field( 'address', 'option' ),
    'phone_number' => get_field( 'phone_number', 'option' ),
    'map_link' => get_field( 'map_link', 'option' ),
    'contact_emails' => return_emails(),
    'socials' => return_socials(),
  );
}

function wm_data(){
  return array(
    'styling' => return_styling(),
    'landing' => return_meta('home_meta'),
    'about' => return_about(),
    'contact' => return_contact(),
    'projects' => landing_projects(),
  );
}