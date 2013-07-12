<?php

/*
    Site Helper Class

*/

class sites_core
{

    /*
    function takes in $_POST data from an html form, and inputs it
    as a website entry into the 'websites' table in the database

    @param $url - string based url entered by user
    @return boolean

    */
    public static function add_url($url)
    {       	
    	/* get website/company/application name from url,
    	   attached protocol to start of url,
	   default other categories */
	$name = sites::parse_url($url);
	$url = 'http://'.$url;
	
        // setup DB connection - root for TESTING
	$con = database::setup_connection('root','crimson');
  	
	// query database to insert new website into table 
	$query = " INSERT INTO `90s_runner`.`websites` 
	(`id`, `name`, `url`, `description`, `priority`) 
	VALUES (NULL, '$name', '$url', '', '1'); ";

	$result = database::query_database($query);

	// close database connection
	database::close_connection($con);
    }


    /*
     function using PHP module DomDocument to reqrite the HTML of a
     designated webpage, adding URL links by either from the database
     or inputted by the user

     @param $content - 'View' object for page
     @param $view - View being dynamically re-written or modified
     @param $element - HTML element being added or modified
     @return $content

    */
    public static function retrieve_urls($user)
    {
        // Variable for main view filename
        $view = '/var/www/html/90sRunner/application/views/pages/home.php';

        // Load the document
	$doc = new DOMDocument();	
	$doc->loadHTMLFile($view);
	$doc->formatOutput = true;
	
	// determine place to insert URLS
	$ul = $doc->getElementById('right_ul');
	
	// setup DB connection - root for TESTING
	$con = database::setup_connection('root','crimson');
  	
	// query database for distinct urls and their corresponding site names	
	$query = database::query_database('SELECT DISTINCT w.name, w.url FROM websites w WHERE 1');
	
	// process the query
	while($website_row = mysql_fetch_assoc($query))
	{
	    // Create the child elements for links and set attributes
	    /*** call function to reference site logo */
	    $logo = sites::retrieve_site_logo($website_row['url']);

	    $li = $doc->createElement('li');

	    $link_a = $doc->createElement('a');
	    $logo_img = $doc->createElement('img');
	    //added breakline
	    $br = $doc->createElement('br');

	    /*** set all atrributes for elements ***/
	    $link_a->setAttribute('href', $website_row['url']);
	    $link_a->setAttribute('target','_blank');
	    // custom logo class for img, custom animation class to pulse when hovered over
	    $logo_img->setAttribute('class','site_logo pulse');
	    $logo_img->setAttribute('src',$logo); /*** add logo string to src ***/
	    $logo_img->setAttribute('alt',$website_row['name']);
	    // *** _blank opens link in new tab when pressed
	    
	    /*** Append all (insert) the child to proper parent node ***/
	    $ul->appendChild($li);
	    $ul->appendChild($br);
	    $li->appendChild($link_a);
	    $link_a->appendChild($logo_img);

	}
	//$doc->saveHTML();
	//sites::retrieve_icon_from_url($doc,'https://www.facebook.com');
	// free query results
	mysql_free_result($query);

	// close database connection
	database::close_connection($con);

	// Save the appeneded file
	return $doc->saveHTML();
    }

    
    /*
     function parse's a url string to retrieve the domain name without protocol or extensions

     @param $url - url string
     @return $parsed - parsed url string

    */
    public static function parse_url($url)
    {   
      $parsed = str_replace('http://','',$url);
      $parsed = str_replace('https://','',$parsed);
      $parsed = str_replace('www.','',$parsed);
      $parsed = str_replace('.com','',$parsed);
      return $parsed;
    }
    
   /*
     function returns a string containging the src of a websites logo

     @param $url - string containing full url of desired website
     @return $logo_str - string containing full path to reference website logo

    */
    public static function retrieve_site_logo($url)
    {
      /*** load class from other file to recursively iterate DOM tree ***/
      require_once('RecursiveDOMIterator.php');

      /* create new document, load html parsed, @ suppreses errors, remove white spaces */
      $doc = new DOMDocument();	
      @$doc->loadHTML(file_get_contents($url));
      $doc->preserveWhiteSpace = false;

      /*** Use recursiveDOMiterator class to recurse all the elements in the body of the html ***/
      $dit = new RecursiveIteratorIterator(
	   new RecursiveDOMIterator($doc)
	   , RecursiveIteratorIterator::SELF_FIRST);
      
      /*** recurse through html document, finding img tags with src content pretaining to the
	   website logo ***/
      foreach($dit as $node)
      {
	if(($node->nodeType === XML_ELEMENT_NODE)
	   && $node->nodeName == 'img')
	{
	  /* if src atrribute contains a url with logo, parse it and return */

/*** NOTE: need to find a better way to do this as more keywords include banner and header
	       as well as the images maybe loaded from the css not html ***/

	  $logo_str = $node->getAttribute('src');
	  if(( strpos($logo_str,'logo') !== false
	       || strpos($logo_str,'banner') !== false 
	       || strpos($logo_str,'header') !== false)
	     && (strpos($logo_str,sites::parse_url($url))) !== false)
	  {
	     /* add the site url to the start of the str if not already there
		(so can reference img src correctly (test for protocol to see) */
	    if((strpos($logo_str,'http') !== false) 
	       || (strpos($logo_str,'https') !== false)){
	      return $logo_str; }
	    else{
	      return $url.$logo_str; }
	  }
	}
      }

      /* else return*/
      return;
    }

    /* function will load an html page, parse for the browser icon,
       and retrieve it for use on the home page 
    */
    public static function retrieve_icon_from_url(DOMNode $domnode, $url)
    {
	/*** use PHP simple dom parser module to load html from site ***/
	//include('simple_html_dom.php');  //DIDNT WORK
	//$site = file_get_html($url);

	/* create new document, load html parsed, @ suppreses errors, remove white spaces */
	$doc = new DOMDocument();	
	@$doc->loadHTML(file_get_contents($url));
	$doc->preserveWhiteSpace = false;
	
	// *** get icon from parsed page to be added to own page
	foreach($doc->getElementsByTagName('head')->item(0)->childNodes as $node)
	{
	   if($node->nodeName == 'link')
	   {
	       $href = $node->getAttribute('href');
	       if(strpos($href,'icon') || strpos($href,'.ico'))
	       {
	           
	       }
	   }
	}	


	// determine if links inright column from own page have images already,
	// if not add them from page parsed
	/*foreach($domnode->getElementsByTagName('ul')->item(0)->childNodes as $lnode)
	{
	    if($lnode->nodeName == 'li')
	    {
		foreach($lnode->childNodes as $cnode)
		{
		    if($cnode->nodeName == 'a' && $cnode->nodeValue == 'Facebook')
		    {
	                //print $cnode->nodeName.' : '.$cnode->nodeValue.'<br>';
		    }
		}
	    }
	}*/

    }

    /* function to print DOM Nodes */
    public static function print_DOM_Nodes(DOMNode $domnode)
    {
      foreach($domnode->childNodes as $node)
      {
	print $node->nodeName.' : '.$node->nodeType.'<br>';
	if($node->hasChildNodes()){
	  sites::print_DOM_Nodes($node);
	}
      }
    }
    

}

?>