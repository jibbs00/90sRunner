<?php

class tags_core
{

    public static function add_tag($tag)
    {
        // setup DB connection - root for testing
	$con = database::setup_connection('root','crimson');

	// query database to insert new tag into tag table
	/*** NOTE: uses backticks not single quotes in some places ***/
	$query = " INSERT INTO `90s_runner`.`tags`
	(`id`, `tag`, `tag_count`) VALUES (NULL, '$tag','1'); ";

	/*** NOTE:figure out how to calculate tag count later ***/
	
	$result = database::query_database($query);

	// close database connection
	database::close_connection($con);
    }

    public static function retrieve_tags($view)
    {
    
	// Load the document
	$doc = new DOMDocument();	
	$doc->loadHTML($view);
	$doc->formatOutput = true;

	// determine where to insert tags
	$tag_container = $doc->getElementById('tag_container');

	// setup database connection
	$con = database::setup_connection('root','crimson');

	// query database for distinct tags corresponding to 
	// designated user logged in 

	/*** NOTE: must modify to work for certain user, not all ***/

	$query = database::query_database('SELECT DISTINCT t.tag, t.tag_count FROM tags t WHERE 1');

	// process the query
	while($tag_row = mysql_fetch_assoc($query))
	{
	    // create elements for each tags 'spans'
	    $span_tag = $doc->createElement('span');
	    $span_count = $doc->createElement('span');
	    
	    // set all atrributes for spans, and create text nodes 
	    // for content from query
	    $span_tag->setAttribute('class','tag');
	    $tag_text = $doc->createTextNode($tag_row['tag']);
	    $span_count->setAttribute('class','tag_count');
	    $count_text = $doc->createTextNode('  ('.$tag_row['tag_count'].')  ');
	    
	    // append span_count as child of span_tag, 
	    // append text node childs, add to div
	    $tag_container->appendChild($span_tag);
	    $span_tag->appendChild($tag_text);
	    $span_tag->appendChild($span_count);
	    $span_count->appendChild($count_text);

	}

	// free querys results
	mysql_free_result($query);
	
	// close database connection
	database::close_connection($con);
	
	// Save the appended file
	return $doc->saveHTML();
    }



}


?>
