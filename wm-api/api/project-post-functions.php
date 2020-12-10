<?php
 
  function return_flex_video() {
    return array(
      'layout' => 'video',
    );
  }
 
  function simple_slideshow_gallery($images) {
    if ($images) {
      foreach ($images as $image) {
        $imgArray[] = $image;
      }
      return $imgArray;
    } else {
      return false;
    }
  }

  function insert_project($post) {
    return array(
      'id' => $post->ID,
      'slug' => $post->post_name,
      'title' => $post->post_title,
      'post_type' => $type,
      'custom_thumbnail' => return_null_false(get_field( 'custom_thumbnail', $post->ID )),
      'thumbnail' => return_thumb_url($post),
      'data' => return_wm_project($post->ID)
    );
  }

  function insert_projects() {
    $list = get_sub_field( 'project' );
    $projects = false;
    if ( $list ):
      foreach ( $list as $post ):
        $projects[] = insert_project($post);
      endforeach;
      wp_reset_postdata();
    endif;
    return $projects;
  }

  function return_flex_copy_block() {
    return array(
      'layout' => 'copy_block',
      'copy' => get_sub_field( 'copy' ),
    );
  }

  function return_flex_block_quote() {
    return array(
      'layout' => 'block_quote',
      'copy' => get_sub_field( 'copy' ),
    );
  }

  function return_flex_photo_gallery() {
    $images = get_sub_field( 'images' );
    return array(
      'layout' => 'photo_gallery',
      'images' => simple_slideshow_gallery($images),
    );
  }

  function return_flex_project_insert() {
    return array(
      'layout' => 'project_insert',
      'projects' => insert_projects()
    );
  }

  function return_flex_layout($id) {
    $fc_layout_modules = array();
    if ( have_rows( 'flexible_layout', $id ) ) :
      while ( have_rows( 'flexible_layout', $id ) ) : the_row();
        if(get_row_layout() == 'copy_block'):
          $data = return_flex_copy_block();
        elseif(get_row_layout() == 'project_insert'):
          $data = return_flex_project_insert();
        elseif(get_row_layout() == 'photo_gallery'):
          $data = return_flex_photo_gallery();
        elseif(get_row_layout() == 'block_quote'):
          $data = return_flex_block_quote();
        elseif(get_row_layout() == 'video'):
          $data = return_flex_video();
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

  function return_single_entry($id) {
    $data = array();
    if ( have_rows( 'single_entry', $id ) ) :
      while ( have_rows( 'single_entry', $id ) ) : the_row();
        $photo_gallery_images = get_sub_field( 'photo_gallery' );
        $trt = return_null_false(get_sub_field( 'trt' ));
        $data = array(
          'additional_information' => return_null_false(get_field( 'additional_information', $id )),
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
      'custom_thumbnail' => return_null_false(get_field( 'custom_thumbnail', $post->ID )),
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