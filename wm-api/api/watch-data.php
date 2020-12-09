<?php

function video_entry($id) {
  $data = array();
  if ( have_rows( 'single_entry', $id ) ) :
    while ( have_rows( 'single_entry', $id ) ) : the_row();
      $photo_gallery_images = get_sub_field( 'photo_gallery' );
      $trt = return_null_false(get_sub_field( 'trt' ));
      $data = array(
        'media_type' => get_sub_field( 'media_type' ),
        'url' => get_sub_field( 'video_embed', false ),
        'file' => get_sub_field( 'video_file' ),
        'trt' => time_to_seconds($trt)
      );
    endwhile;
  endif;
  return $data;
}

function block() {
  
  $schedule = array();
  $schedule_list = get_field( 'schedule_list' );
  
  if ( $schedule_list ) :
    
    $offset_counter = 0;
    
    foreach ( $schedule_list as $post ):
      $type = $post->post_type;
      
      $video_data = video_entry($post->ID);
      $trt = return_null_false($video_data['trt']);
      
      $video = $video_data['url'];
      $src = array(
        'id' => VideoUrlParser::get_url_id($video),
        'mediaType' => 'video',
        'provider' => VideoUrlParser::identify_service($video),
        'src' => VideoUrlParser::get_url_id($video)
      );

      $post_basics = array(
        'title' => $post->post_title,
        'cover' => return_thumb_url($post),
        'director' => return_first_taxonomy_name($post, 'director'),
        'src' => $src
      );

      $offset = array( 'offset' => $offset_counter );
      $offset_counter = $offset_counter + $trt;
      $schedule[] = array_merge($post_basics, $video_data, $offset);
    endforeach;
    wp_reset_postdata();
  endif;
  return $schedule;
}

function return_schedule_post($post) {
  return array(
    'post_id' => $post->ID,
    'title' => $post->post_title,
    'slug' => $post->post_name,
    'content' => block(),
  );
}

function schedule_blocks() {
  $args = array(
    'post_type' => 'watch_schedules',
    'posts_per_page' => -1
  );
  $the_query = new WP_Query( $args );
  if ( $the_query->have_posts() ) :
    $data = array();
    while ($the_query->have_posts()) : $the_query->the_post();
      $post = get_post($post_id);
      $id = $the_query->post->ID;
      $data[] = return_schedule_post($post);
    endwhile;
  endif;
  return $data;
}

/*-----------------------------------------------------------------------------------*/
/* MASTER SCHEDULE
/*-----------------------------------------------------------------------------------*/

function return_master_schedule() {
  $default_block = get_field( 'default_block', 'option' );
  return array (
    'default_block' => $default_block->ID
  );
}

/*-----------------------------------------------------------------------------------*/
/* BUMPERS
/*-----------------------------------------------------------------------------------*/

function return_bumpers() {
  $data = array();
  if ( have_rows( 'bumpers', 'option' ) ) :
    while ( have_rows( 'bumpers', 'option' ) ) : the_row();
      $data[] = get_sub_field( 'video' );
    endwhile;
  endif;
  return $data;
}

/*-----------------------------------------------------------------------------------*/
/* RETURN WATCH DATA
/*-----------------------------------------------------------------------------------*/

function watch_data(){
  return array(
    'master_schedule' => return_master_schedule(),
    'schedule_blocks' => schedule_blocks(),
    'bumpers' => return_bumpers(),
  );
}