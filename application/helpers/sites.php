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
	$url = 'https://'.$url;
	
        // setup DB connection - root for TESTING
	$con = database::setup_connection('root','crimson');
  	
	// query database to insert new website into table 
	$query = " INSERT INTO `media_flow`.`websites` 
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
        $view = '/var/www/html/mediaflow/application/views/pages/home.php';

        // Load the document
	$doc = new DOMDocument();	
	$doc->loadHTMLFile($view);
	$doc->formatOutput = true;
	
	// determine place to insert URLS
	$ul = $doc->getElementsByTagName('ul')->item(0);
	
	// setup DB connection - root for TESTING
	$con = database::setup_connection('root','crimson');
  	
	// query database for distinct urls and their corresponding site names	
	$query = database::query_database('SELECT DISTINCT w.name, w.url FROM websites w WHERE 1');
	
	// process the query
	while($website_row = mysql_fetch_assoc($query))
	{
	    // Create the child elements for links and set attributes
	    $li = $doc->createElement('li');
	    $a = $doc->createElement('a', $website_row['name']);
	    $br = $doc->createElement('br');  // added break line
	    $a->setAttribute('href', $website_row['url']);
	    $a->setAttribute('target','_blank'); 
	    // *** _blank opens link in new tab when pressed
	    
	    // Append (insert) the child to the parent node
	    $ul->appendChild($li);
	    $ul->appendChild($br);
	    $li->appendChild($a);
	}
	$doc->saveHTML();
	sites::retrieve_img_from_url($doc,'https://www.facebook.com');
	// free query results
	mysql_free_result($query);

	// close database connection
	database::close_connection($con);

	// Save the appeneded file
	return $doc->saveHTML();
    }

    
    /*
     function parese a url string to retrieve tthe domain name

     @param $url - url string
     @return $parsed - parsed url string

    */
    public static function parse_url($url)
    {   
      $parsed = str_replace('www.','',$url);
      $parsed = str_replace('.com','',$parsed);
      return $parsed;
    }

    /* function will load an html page, parse for a certain image,
       and retrieve it for use on the home page 
    */
    public static function retrieve_img_from_url(DOMNode $domnode, $url)
    {
	/*** use PHP simple dom parser module to load html from site ***/
	//include('simple_html_dom.php');  //DIDNT WORK
	//$site = file_get_html($url);

	/* create new document, load html parsed, @ suppreses errors, 
	remove white spaces */
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