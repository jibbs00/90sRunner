<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

   <meta http-equiv="Content-Style-Type" content="text/html; charset=utf-8"/>
   <title><?php echo html::specialchars($title) ?></title>

   <!-- LINKS -->
   
   <!-- link for boostrap.less to compile less files -->
   <link rel="stylesheet/less" href="/90sRunner/media/less/bootstrap.less" />
   <!-- link for browser tab icon -->
   <link rel="shortcut icon" href="/90sRunner/media/ico/thumb1.ico" />
   
   <!-- STYLESHEETS and CSS for Bootstrap-->
   <?php echo html::stylesheet(
         array('media/css/site',),
         array('screen',)
     ); 
   ?>
   <link href="/90sRunner/media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

   <!-- JAVASCRIPTS -->

   <!-- link to include javascripts for LESS Module -->
   <script type="text/javascript" src="/90sRunner/media/js/less-1.3.3.min.js" ></script>

</head>

<body background="<?php echo $bg ?>" >
   <!-- FULL PAGE BACKGROUND -->
   <!--<img src="/mediaflow/media/img/jCDgKkOh.jpg" class="bg">-->
   
   <h1><?php echo $main_heading; ?></h1>

   <div id="header" class="inner-shading outter-shading">
   </div>
   <!-- handle form information if controller defined as homepage -->
   <?php
       if(isset($_POST['site_input'])){
	   /* insert to database */
           sites::add_url($_POST['site_input']);
           /* reset $content */
           $content = sites::retrieve_urls($content);
       }
   ?>

   <!-- MAIN PAGE CONTENT -->
   <?php echo $content; ?>

<!-- footer wrapper removed till solution to height problem found -->
<!-- <div id="footer-wrapper"> -->
     <div id="footer" class="outter-shading">
          <ul>
	      <?php foreach ($page_links as $link => $url): ?>
       	      <li><?php echo html::anchor($link, $url); ?></li>
       	      <?php endforeach ?>
	  </ul>
     </div>
<!-- </div> -->


   <p id="date"><?php  echo date(DATE_RFC822); ?></p>
   <hr/>

   <!--- JAVASCRIPTS --->
   <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
   <script src="/90sRunner/media/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
