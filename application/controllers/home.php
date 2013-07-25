<?php defined('SYSPATH') OR die('No direct access allowed.');

class Home_Controller extends Website_Controller
{
  public function __construct()
  {
    /***NOTE: allows you to specify different templates for
	different controllers ***/
    $this->template = 'home_template';
    parent::__construct();
  }

  public function index()
  {
    $this->template->title = '90\'s Runner // Worldwide Car Culture Collective';
    /*$this->template->content = View::factory('pages/home')
    			     ->set('links', array(
      			     		    'home' => 'home',
      					    'about' => 'about',
      					    'contact' => 'contact',
       					    ));
					    */
    $this->template->content = new View('pages/home');
    $this->template->component1 = new View('components/top_carousel');
    $this->template->component2 = new View('components/bottom_carousel');
    $this->template->bg = "";

    /*** rewrites the content of the page upon initial loading to gather info
     about user from database, and capture relevent content from all urls pretaining ***/
    $this->template->content = content::retrieve_content("http://www.speedhunters.com");
    $this->template->content = sites::retrieve_urls($this->template->content);
    $this->template->content = tags::retrieve_tags($this->template->content);
  }

}