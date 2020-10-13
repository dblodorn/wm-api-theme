<?php

function block() {
  $schedule = array();
  $schedule_list = get_field( 'schedule_list' );
  if ( $schedule_list ) :
    foreach ( $schedule_list as $post ):
      $schedule[] = array(
        'id' => $post->ID,
        'post_type' => $post->post_type,
      );
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
    'projects' => block(),
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
/* RETURN WATCH DATA
/*-----------------------------------------------------------------------------------*/

function watch_data(){
  return array(
    'master_schedule' => return_master_schedule(),
    'schedule_blocks' => schedule_blocks()
  );
}