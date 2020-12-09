<?php

  

  function return_flex_layout($id) {
    $layout_modules = array();
    if ( have_rows( 'flexible_layout', $id ) ) :
      while ( have_rows( 'flexible_layout', $id ) ) : the_row();
        if(get_row_layout() == 'video'):
          $data = 'video';
        elseif(get_row_layout() == 'slideshow'):
          $data = return_slideshow();
        elseif(get_row_layout() == 'project_insert'):
          $data = 'project_insert';
        elseif(get_row_layout() == 'photo_gallery'):
          $data = 'photo_gallery';
        elseif(get_row_layout() == 'copy_block'):
          $data = 'copy_block';
        endif;
        $layout_modules[] = $data;
      endwhile;
    endif;
    return $layout_modules;
  }

  function return_single_entry($id) {
    $data = array();
    if ( have_rows( 'single_entry', $id ) ) :
      while ( have_rows( 'single_entry', $id ) ) : the_row();
        $photo_gallery_images = get_sub_field( 'photo_gallery' );
        $trt = return_null_false(get_sub_field( 'trt' ));
        $data = array(
          'media_type' => get_sub_field( 'media_type' ),
          'video_embed' => get_sub_field( 'video_embed', false ),
          'video_file' => get_sub_field( 'video_file' ),
          'trt' => time_to_seconds($trt)
        );
      endwhile;
    endif;
    return $data;
  }

  function return_project_layout($type, $id) {
    if ($type === "flex_layout") {
      return return_flex_layout($id);
    } else {
      return return_single_entry($id);
    }
  }

  function return_wm_project($id) {
    $type = get_field( 'project_type', $id );
    return array(
      'project_type' => $type,
      'display_title' => return_null_false(get_field( 'display_title', $id )),
      'additional_information' => return_null_false(get_field( 'additional_information', $id )), 
      'reel_thumbnail' => return_null_false(get_field( 'reel_thumbnail', $id )),
      'project_layout' => return_project_layout($type, $id),
    );
  }

  function return_other_project($id) {
    return array(
      'project' => 'other-project'
    );
  }

  function acf_data($type, $id) {
    if ($type === 'project') {
      return return_wm_project($id);
    } else {
      return return_other_project($id);
    }
  }

  function project_data($post, $p) {
    $type = $post->post_type;
    return array(
      'id' => $post->ID,
      'slug' => $post->post_name,
      'title' => $post->post_title,
      'post_type' => $type,
      'thumbnail' => return_thumb_url($post),
      'tags' => array(
        'director_name' => return_first_taxonomy_name($post, 'director'),
        'director_slug' => return_first_taxonomy_slug($post, 'director'),
        'type_name' => return_first_taxonomy_name($post, 'type'),
        'type_slug' => return_first_taxonomy_slug($post, 'type'),
        'client_name' => return_first_taxonomy_name($post, 'client'),
        'client_slug' => return_first_taxonomy_slug($post, 'client'),
      ),
      'data' => acf_data($type, $post->ID)
    );
  }