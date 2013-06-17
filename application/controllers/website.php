<?php defined ('SYSPATH') or die('No direct script access.');

class Website_Controller extends Template_Controller {

  /* template controller contains global variables accessed by multiple controllers */

  public $page_links = array
      	 	       (
      		       'home' => 'home',
      		       'about' => 'about',
      		       'contact' => 'contact',
       		       );

  public function __construct()
  {
    parent::__construct();
    
    //add relevent link array in Website_Controller
    View::set_global('page_links', $this->page_links);
       
  }

}