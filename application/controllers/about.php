<?php defined('SYSPATH') OR die('No direct access allowed.');

class About_Controller extends Website_Controller
{

  public function index()
  {
    $this->template->title = 'About Us - MediaFlow';
    $this->template->content = new View('pages/about');
    $this->template->main_heading = 'About Us';
    $this->template->bg = '#DDD';
   
  }

}