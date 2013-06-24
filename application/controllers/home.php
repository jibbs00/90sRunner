<?php defined('SYSPATH') OR die('No direct access allowed.');

class Home_Controller extends Website_Controller
{
	
  public function index()
  {
    $this->template->title = '90\'s Runner | Worldwide Car Culture Collective';
    /*$this->template->content = View::factory('pages/home')
    			     ->set('links', array(
      			     		    'home' => 'home',
      					    'about' => 'about',
      					    'contact' => 'contact',
       					    ));
					    */
    $this->template->content = new View('pages/home');
    $this->template->bg = "";

    /*** rewrites the content of the page upon initial loading ***/
    $this->template->content = sites::retrieve_urls($this->template->content);
    
  }

}