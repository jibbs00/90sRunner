<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

   <meta http-equiv="Content-Style-Type" content="text/html; charset=utf-8"/>
   <title><?php echo html::specialchars($title) ?></title>

   <!-- LINKS -->
   <!-- link for browser tab icon -->
   <link rel="shortcut icon" href="/90sRunner/media/ico/thumb1.ico" />

   <!-- link to GOOGGLE Webfonts Collection -->
   <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Fauna+One|Codystar|Muli|Inconsolata|Satisfy|Megrim' type='text/css'>

   <!-- link for boostrap.less to compile less files -->
   <link rel="stylesheet/less" href="/90sRunner/media/less/bootstrap.less" />
   
   <link href="/90sRunner/media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
   <!-- STYLESHEETS and CSS for Bootstrap-->
   <?php echo html::stylesheet(
	 array('media/css/site','media/css/override','media/css/animations',
	       'media/css/fonts','media/css/img'),
         array('screen','screen','screen',
	       'screen','screen')
     ); 
   ?>
   
   <!-- JAVASCRIPTS -->

   <!-- link to include javascripts for LESS Module -->
   <script type="text/javascript" src="/90sRunner/media/js/less-1.3.3.min.js"></script>

</head>

<body background="<?php echo $bg ?>">
   <!-- FULL PAGE BACKGROUND -->
   <!--<img src="/90sRunner/media/img/garage-stain-590.jpg" class="bg">-->
   
   <div id="page_wrapper">

       <!-- === MAIN PAGE === -->

       <div id="page_main">

          <!-- === HEADERS === -->
          <div id="title_bar">
          <!-- website logo with imbeded social media links -->
          </div>
          <!-- edit later to be removed if something not set -->
          <div id="login_bar"></div>

	  <!-- === content for top carousel on main page === -->
	  <?php  echo $component1; ?>

	  <div id="top_navbar" class="inner-shading outter-shading">
	     <div class="navbar navbar-inverse">
	        <div class="navbar-inner">
		   <a class="brand" href="#">90sRunner</a>
		   <!-- all navbar contents within collapse -->
		   <div class="nav-collapse collapse">
		      <ul class="nav" padding-bottom=20px>
	      	         <?php foreach ($page_links as $link => $url): ?>
	      	         <li <?php if($link=='home'){echo "class='active'";}?>>
			      <?php echo html::anchor($link, $url); ?>
			  </li>
	      	         <?php endforeach ?>
	    	      </ul>	      
		   </div>
		</div>
	     </div>
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
	  <div id="footer_navbar" class="navbar-inverse outter-shading">
	    
	  </div>
	  <!-- </div> -->

	  <!-- content for bottom carousel on main page -->
	  <?php  echo $component2; ?>


         <!-- === FOOTER === --> 
         <div id="bottom_footer_bar">
         </div>

       <!-- === page_main end === -->
       </div> 
   <!-- === page_wrapper end === -->
   </div>

   <!-- JAVA/JQUERY SCRIPTS -->
   <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
   <script src="/90sRunner/media/bootstrap/js/bootstrap.min.js"></script>
   <!-- Grab Google CDNs jQuery, with a protocol relative URL; fall back to local if necessary -->
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <script>
      window.jQuery || document.write('<script src="var/www/html/90sRunner/media/js/jquery-1.9.1.min.js"><\/script>')
   </script>
   <!-- initialize carosuel -->
   <script>
      $(document).ready(function(){
          $('.carousel').carousel({
	    interval: 200
	  });
      });
   </script>
   <!-- script for logo link class to be animated when hovered over -->
   <script>
      $('.site_logo').hover(function() {
          $(this).addClass("pulse");
      });
   </script>

</body>
</html>
