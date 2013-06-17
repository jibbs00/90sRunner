<?php defined('SYSPATH') OR die('No direct access allowed.');

class Contact_Controller extends Website_Controller
{

  public function index()
  {
    $this->template->title = 'Contact Us - MediaFlow';
    $this->template->content = new View('pages/contact');
    $this->template->main_heading = 'Contact Us';
    $this->template->bg = '#DDD';

  }

}