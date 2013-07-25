<?php

  /**
    class defines how content of designated websites is parsed and
    added to the home page for authorized users 
  **/

class content_core
{
	/* post url (set with each post retrieved) */
	/*protected $post_url = '';*/


	public function __construct(){
	    /*** load class from other file to recursively iterate DOM tree ***/
      	    require_once('RecursiveDOMIterator.php');
	}

	public static function retrieve_content($url)
	{
		/*** call construct  load class to recursively iterate DOM tree ***/
		$construct = new content();
		$construct->__construct();
     
		// Load the homepage document
		$home = new DOMDocument();	
		$home->loadHTMLFile('/var/www/html/90sRunner/application/views/pages/home.php');
		$home->formatOutput = true;
	
		/*** load the html of the given webpage using DOMDocument module, 
		     @ suppresses errors, remove whitespaces ***/
		$doc = new DOMDocument();
		@$doc->loadHTML(file_get_contents($url));
		$doc->preserveWhiteSpace = false;
		
		/*** Use recursiveDOMiterator class to recurse all the elements in the html ***/
     		$body_itr = new RecursiveIteratorIterator(new RecursiveDOMIterator($doc)
	   	, RecursiveIteratorIterator::SELF_FIRST);
   		
		foreach($body_itr as $node)
		{
		    /* look for div tags with post or item classes */
		    if($node->nodeName == 'div'
		       && (strpos($node->getAttribute('class'),'post') !== false 
		       || strpos($node->getAttribute('id'),'post') !== false))
		    {
		        /*** find url pretaining to post by checking if each
			     child element has an 'href' attribute ***/
		        foreach($node->childNodes as $child)
			{
			    /* if node has a href attribute, contains a link to post page */
			    
			    /*** NOTE: assumes link goes to post page (as most sites have 
			    such a link early in the html) ***/
			    
			    if($child->nodeType === XML_ELEMENT_NODE
			       && $child->getAttribute('href') !== false)
			    {
				/* call function to parse post page */
				$post_url = $child->getAttribute('href');
			        $post_node = content::parse_post($post_url);
			        if($post_node !== false)
				{
				  /*** if node returned (not false), create post
				       based on that post node ***/
				  //sites::print_DOM_Nodes($post_node);
				  content::create_post($home,$post_node,$post_url);
				}
			    }


			}

		    }

	        }
		

		/*** returned a saved, and completed webpage with content from desired site ***/
		return $home->saveHTML();
	}


	
	/**
	   function parses a particular DOMNode object for keywords
	   pretaining to the array of user tags, returns true if a match and false otherwise 
	**/
	public static function parse_post($post_url)
	{   	    
	    // setup database connection, query database to retrieve user tags
	    $con = database::setup_connection('root','crimson');

	    /*** NOTE: need to fix for specific user, just pulls all tags for now ***/

	    $tag_query = database::query_database('SELECT DISTINCT t.tag FROM tags t WHERE 1');

	    /*** load the html of the given webpage using DOMDocument module, 
		     @ suppresses errors, remove whitespaces ***/
 	    $doc = new DOMDocument();
	    @$doc->loadHTML(file_get_contents($post_url));
	    $doc->preserveWhiteSpace = false;

	    /*** Use recursiveDOMiterator class to recurse all the elements in the post html***/
     	    $post_itr = new RecursiveIteratorIterator(new RecursiveDOMIterator($doc)
	    , RecursiveIteratorIterator::SELF_FIRST);
	    
	    /*** foreach of the elements within the post body, search for any tag word ***/
	    foreach($post_itr as $node)
	    {
	        /* look for div tags with post or item classes */
		if($node->nodeName == 'div'
		   && ($node->getAttribute('class') == 'post' 
		   || strpos($node->getAttribute('id'),'post') !== false))
		{
		    /*** loop through each child node within the post div (not recursive)***/
		    foreach($node->childNodes as $child)
		    {
		        /* if the node is an emptytextnode, remove it*/
			if($child->nodeType === XML_TEXT_NODE)
			{ //NOT WORKING
			  //$child->parentNode->removeChild($child);
			}
			/* else if, search through text values in node trying to match tags */
			elseif($child->nodeType === XML_ELEMENT_NODE)
			{
			    /* loop through user tags, comparing tags to the text content of the node */
			    while($tag = mysql_fetch_assoc($tag_query))
			    {
			        /* if tag matches, clean up query and return the post node */
			        if(strpos(strtolower($child->nodeValue)
				    ,strtolower($tag['tag'])) !== false)
				{

				    //print $child->nodeName.' : '.$child->nodeType.' : '.$child->nodeValue.'<br>';
				    			    				    
				    // free querys results
				    mysql_free_result($tag_query);
				    // close database connection
				    database::close_connection($con);
		
				    /*** return the post node ***/
				    return $node;
				}
			    
			    }
			    
			}
		    
		    }

		}

	    }

	    /*** else, if no matches recieved, 
	    clean up query and return false ***/
	    mysql_free_result($tag_query);
	    database::close_connection($con);

	    return false;
	}


	/**
	  function creates content on webpage when tag matches 
	**/
	public static function create_post(DOMDocument $doc, DOMNode $post, $post_url)
	{	    
	    /*** Use recursiveDOMiterator class to recurse all the elements in the post html***/
     	    $post_itr = new RecursiveIteratorIterator(new RecursiveDOMIterator($post)
	    , RecursiveIteratorIterator::SELF_FIRST);
	    
	    // determine place to insert POST content
	    $center = $doc->getElementById('center');

	    // create main post div and set attributes
	    $post_div = $doc->createElement('div');
	    $post_div->setAttribute('class','post_container');
	    
	    /*** create post header by calling function ***/
	    content::post_title($doc,$post_div,$post_itr);

	    // create and append horizontal line
	    $hr = $doc->createElement('hr');
	    $post_div->appendChild($hr);

	    /*** create image container for post ***/
	    content::post_imgs($doc,$post,$post_div,$post_itr);
	    /*** create abstract container containing icon for post ***/
	    content::post_abstract($doc,$post_div,$post_itr,$post_url);

	    /*** append all elements to center column ***/
	    $center->appendChild($post_div);

	    /*** returned the completed, and saved document ***/
	    return $doc->saveHTML();
	}


	public function post_title(DOMDocument $doc,DOMNode &$post_div,RecursiveIteratorIterator $post_itr)
	{
	    /* traverse post nodes looking for header title */
	    foreach($post_itr as $node)
	    {
		//print $node->nodeName.' : '.$node->nodeType.' : '.$node->nodeValue.'<br/>';
	      	
	        if($node->nodeName == 'h1')
		{
		  /*** NOTE: assumes title is text_node within 'a' element
		   within the header element*/
		  $title = $node->childNodes->item(0)->childNodes->item(0);
		  
		  /* create elements, set atrributes, and append to document */
		  $title_h2 = $doc->createElement('h2');
		  $title_a = $doc->createElement('a');
		  $text_value = $doc->createTextNode($title->nodeValue);

		  $title_h2->setAttribute('title',$title->nodeValue);
		  $title_a->setAttribute('href',$node->childNodes->item(0)->getAttribute('href'));
		  $title_a->setAttribute('target','_blank');

		  $title_a->appendChild($text_value);
		  $title_h2->appendChild($title_a);
		  $post_div->appendChild($title_h2);
		  
		  /* save modified document */
		  return $doc->saveHTML();
		}

	    }

	}


	/***NOTE: hate 4 parameters, find way to change later ***/
	public function post_imgs(DOMDocument $doc,DOMNode $post,DOMNode &$post_div
				  ,RecursiveIteratorIterator $post_itr)
	{
	   /*** NOTE: count is a bit high, but works for now, fix later ***/

	   /* count # of 'img' elements in DOMTree */
	   $count_imgs = content::countElementsbyTagName($post,'img');
	 
	   if($count_imgs >= 4)  /*** ideal img post ***/
	   {
	      /*** create post_img and post_thumb containers and set attributes ***/
	      $post_imgs = $doc->createElement('div');
	      $post_thumbs = $doc->createElement('div');
	      $post_imgs->setAttribute('class','post_imgs');
	      $post_thumbs->setAttribute('class','post_thumbs');

	      /*** create main_img element and set attributes (except src and class) ***/
	      $main_img = $doc->createElement('img');
	      $main_img->setAttribute('alt','');

	      /* at random (or in sequence), reference 4 (one main img) 
	      provided in the content post on own webpage */

	      $count = 0;
	      foreach($post_itr as $img_node)
	      {
	         /* img element detected, evaluate */
	         if($img_node->nodeName == 'img')
		 {   
		     /* if the count is 0, means use first img as $main_img */
		     if($count == 0)
		     {
		         $main_img->setAttribute('class','post_main_img_2');
		         $main_img->setAttribute('src',$img_node->getAttribute('src'));
		     }
		     /* else, until count == 4, create elements for gallery
		     imgs and set their attributes, then append to $post_thumbs */
		     elseif($count >= 1 && $count <= 3)
		     {
		         $gal_img = $doc->createElement('img');
			 $gal_img->setAttribute('class','post_thumb_img');
			 $gal_img->setAttribute('src',$img_node->getAttribute('src'));
			 $gal_img->setAttribute('atr','');
			 
			 $post_thumbs->appendChild($gal_img);
		     }
		     /* else, break out of loop (count > 4) */
		     else
		     {
		         break;
		     }

		     /* increment count */
		     $count++;
		 }

	      }

	      /*** append all children to relevent elements 
	      and save the html document and return ***/
	      $post_imgs->appendChild($main_img);
	      $post_imgs->appendChild($post_thumbs);

	      $post_div->appendChild($post_imgs);

	      return $doc->saveHTML();

	   }
	   elseif($count_imgs == 1)
	   {


	   }  
	   /* else, error or something */
	   


	}


	public function post_abstract(DOMDocument $doc,DOMNode &$post_div
	       			,RecursiveIteratorIterator $post_itr, $post_url)
	{
	    /* first retrieve website browser icon to use as icon in post_abstract from website */
	    $tab = 'http://placehold.it/80x80';

	    /* loop through post until first 'p' element with pure TEXT_NODES as children */
	    foreach($post_itr as $p_node)
	    {
	        if(($p_node->nodeName == 'p')
		   && ($p_node->hasChildNodes())
		   && ($p_node->childNodes->item(0)->nodeType === XML_TEXT_NODE))
		{
		    /*** create abstract_container and set attribute ***/
		    $post_abstract = $doc->createElement('div');
		    $post_abstract->setAttribute('class','abstract_container');
		    
		    /*** create abstract element and set atrributes ***/
		    $post_paragraph = $doc->createElement('p');
		    $post_paragraph->setAttribute('class','abstract');

		    /*create img for post_tab and set attributes*/
		    $post_tab = $doc->createElement('img');
		    $post_tab->setAttribute('class','post_tab');
		    $post_tab->setAttribute('src',$tab);
		    $post_tab->setAttribute('alt','');

		    /*** create TEXT_NODE for 'p' contents ***/

		    /*** NOTE: need to fix to encompass all nodes in parent, as some have
		    links that screw up the paragraph ***/
		    
		    $text = $doc->createTextNode($p_node->childNodes->item(0)->nodeValue);


		    /*** create post_link element and set attributes ***/
		    $post_link = $doc->createElement('a');		   
		    $post_link->setAttribute('class','post_link');
		    $post_link->setAttribute('href',$post_url);  /*** NOTE: make $post_link global eventually ***/
		    $post_link->setAttribute('target','_blank');
		    /* create TEXT_NODE for text of link */
		    $link_text = $doc->createTextNode('Link to the Post [...]');
		    
		    /*** append elements to abstract_container, abstract, and post_div ***/
		    $post_link->appendChild($link_text);
		    $post_paragraph->appendChild($post_tab);
		    $post_paragraph->appendChild($text);
		    $post_paragraph->appendChild($post_link);
		    $post_abstract->appendChild($post_paragraph);		    

		    $post_div->appendChild($post_abstract);
		    
		    /* save html document */
		    return $doc->saveHTML();
		}

	    }

	}

	
	public function post_icon(DOMNode $post,DOMDocument $doc)
	{


	}


	/**
	   utility function used to count how many elements there are with
	   a specific tag name
	 **/
	 public function countElementsByTagName(DOMNode $node,$tag_name)
	 {
	     /* create new domdocument from DOMNode */
	     $doc = new DomDocument();
	     $doc->appendChild($doc->importnode($node, true));

	     /* get element based on tag_name */
	     $elements = $doc->getElementsbyTagName($tag_name);
	     
	     /* return count (length) */
	     return $elements->length;
	 }
	 

}


?>
