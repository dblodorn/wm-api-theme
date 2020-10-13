<?php

  function return_wm_project($id) {
    
    function single_entry() {
      $data = array();
      if ( have_rows( 'single_entry', $id ) ) :
        while ( have_rows( 'single_entry', $id ) ) : the_row();
          $photo_gallery_images = get_sub_field( 'photo_gallery' );  
          $data = array(
            'media_type' => get_sub_field( 'media_type' ),
            'video_embed' => get_sub_field( 'video_embed', false ),
            'video_file' => get_sub_field( 'video_file' ),
          );
        endwhile;
      endif;
      return $data;
    }
    
    
    return array(
      'project_type' => get_field( 'project_type', $id ),
      'project_layout' => single_entry()
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
      'thumbnail' => return_thumb_url($post),
      'post_type' => $type,
      'data' => acf_data($type, $post->ID)
    );
  }