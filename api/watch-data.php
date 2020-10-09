<?php
  function return_schedule() {
    return 'watch-schedule';
  }
  
  function return_projects() {
    return 'watch-projects';
  }

  function watch_data(){
    $data = array();
    $data['projects'] = return_projects();
    $data['schedule'] = return_schedule();
    return $data;
  }