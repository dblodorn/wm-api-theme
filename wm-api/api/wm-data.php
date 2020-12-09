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

function return_landing() {
  return array(
    'meta' => 'landing_projects()'
  );
}

function return_styling() {
  return array(
    'bg_color' => get_field( 'background_color', 'option' ),
  );
}

function return_about() {
  return 'about';
}

function return_contact() {
  return 'contact';
}

function wm_data(){
  return array(
    'styling' => return_styling(),
    'landing' => return_landing(),
    'projects' => landing_projects(),
    'about' => return_about(),
    'contact' => return_contact(),
  );
}