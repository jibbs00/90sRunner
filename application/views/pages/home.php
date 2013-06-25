<!--  Carousel - consult the Twitter Bootstrap docs at
      http://twitter.github.com/bootstrap/javascript.html#carousel -->
<div id="this-carousel-id" class="carousel slide carousel_atr"><!-- class of slide for animation -->
  <div class="carousel-inner">
    <div class="item active"><!-- class of active since its the first item -->
      <img src="http://placehold.it/1200x360" alt="" />
      <div class="carousel-caption">
        <p>Caption text here</p>
      </div>
    </div>
    <div class="item">
      <img src="http://placehold.it/1280x480" alt="" />
      <div class="carousel-caption">
        <p>Caption text here</p>
      </div>
    </div>
    <div class="item">
      <img src="http://placehold.it/1280x480" alt="" />
      <div class="carousel-caption">
        <p>Caption text here</p>
      </div>
    </div>
    <div class="item">
      <img src="http://placehold.it/1280x480" alt="" />
      <div class="carousel-caption">
        <p>Caption text here</p>
      </div>
    </div>
  </div><!-- /.carousel-inner -->
  <!--  Next and Previous controls below; href values must reference the id for this carousel -->
    <a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
</div><!-- /.carousel -->

<div id="header" class="inner-shading outter-shading"></div>

<div id="content_container" class="side-shade">
     <div id="center" class="column inner-shading centrecol-outter-shading">
     	  
     </div>
     <div id="left" class="column leftcol-inner-shading">
         <h3>Interests</h3>
         <form name="left-col-form">
             <div class="input-append">
                 <input name="left-input" class="input_ctm_sml" type="text" placeholder="...">
		 <!-- Input and Actions to edit Interests -->
		 <div class="btn-group">
		      <button class="btn" tabindex="-1">Action</button>
		      <button class="btn dropdown-toggle" data-toggle="dropdown" tabindex="-1">
		          <span class="caret"></span>
		      </button>
  		      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
		      	  <li><a tabindex="-1" href="#">Action</a></li>
    		      	  <li><a tabindex="-1" href="#">Another action</a></li>
   		      	  <li><a tabindex="-1" href="#">Something else here</a></li>
    		      	  <li class="divider"></li>
    		      	  <li><a tabindex="-1" href="#">Separated link</a></li>
  		      </ul>
		 </div>
             </div>
          </form>
     </div>
     <div id="right" class="column rightcol-inner-shading">

     	  <h3>Add Content!</h3>
	  <!-- action loads defined controller -->
	  <form name="right-col-form" class="form-inline" method="post" action="">
	  	<div class="input-append">
		     <input name="site_input" class="input_ctm_sml" type="text" placeholder="add URL">
		     <button name="add_button" class="btn" type="submit">Add</button>
		</div>
	  </form>
	  
	  <ul id="right_ul">
	      <!-- right column links -->
          </ul>

    </div>
</div>
