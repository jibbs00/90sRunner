<?php

/* Database Helper Class

*/

class database_core 
{      
      /* protected variables for user authenticaiton and login information */
      protected $database = '90s_runner';
      protected $table_name = 'websites';

      public static function setup_connection($username,$password)
      {
	   /* connect to database, find correct database */
	   $db_con = mysql_connect("localhost", $username, $password) 
	              or die("ERROR: Could not connect to DB media_flow");
           $db_sel = mysql_select_db("90s_runner", $db_con)
	      	      or die("ERROR: could not select DB media_flow");
	   /* return connection */
	   return $db_con;
      }

      public static function query_database($query)
      {
          return mysql_query($query);
      }

      public static function close_connection($con)
      {
          return mysql_close($con);
      }


}

?>