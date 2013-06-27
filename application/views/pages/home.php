
<div id="content_container" class="side-shade">
     <div id="center" class="column inner-shading centrecol-outter-shading">
        <div name="post_1" class="post_container">
           <h3>Post #1</h3>
           <hr/>
	   <img src="http://placehold.it/600x360" alt=""/>
	   <p>text text text text text text text text text text text text </p>
	</div>
	<div name="post_2" class="post_container">
           <h3>Post #2</h3>
           <hr/>
	   <img src="http://placehold.it/600x360" alt=""/>
	   <p>text text text text text text text text text text text text </p>
	</div>
     </div>
     <div id="left" class="column leftcol-inner-shading">
         <h3>Interests</h3>
         <form name="left-col-form">
             <div class="input-append">
                 <input name="left-input" class="input_ctm_sml" type="text" placeholder="...">
		 <!-- Input and Actions to edit Interests -->
		 <div class="btn-group">
		      <button class="btn btn-small" tabindex="-1">Action</button>
		      <button class="btn btn-small dropdown-toggle" data-toggle="dropdown" tabindex="-1">
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
		     <button name="add_button" class="btn btn-small" type="submit">Add</button>
		</div>
	  </form>
	  
	  <ul id="right_ul">
	      <!-- right column links added dynamically-->
          </ul>

    </div>
</div>
