<div id="content_container" class="outter-shading">
     <div id="center" class="column inner-shading centrecol-outter-shading">
     	  
     </div>
     <div id="left" class="column leftcol-inner-shading">
         <h3>Interets</h3>
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
	  
	  <ul>
	      <!-- right column links -->
          </ul>

	  <p> The genius and trick to this method is in using inline-block elements and then using word-spacing to counterbalance using a negative right margin. A negative right margin on it's own will pull elements together, allowing you to have 100% width set and still fit things in between, but leave the elements overlapping. Setting negative margin on the parent just undoes the child margin in regards to the effect on interacting with total width (the magic "100% width" mark we're trying to hit"). Padding only serves to increase the size of th, any gutter size, any predefined amount of columns in width, handles arbitrary amounts of rows with auto-wrapping, and uses inline-block elements so therefore provides the vertical-alignment options that come with inline-block, AND it doesn't require any extra markup and only requires a single class declaration on the container (not counting defining column widths). I think the code speaks for itself. Here's the code implementation for 2-6 columns using 10px gutters and bonus helper classes for percentages.

EDIT: interesting conundrum. I've managed to get two slightly different versions; one for mozilla and ie8+, the other for webkit. It seems the word-spacing trick doesn't work in webkit, and I don't know why the other version works in webkit but not ie8+/mozilla. Combining both gets you coverage over everything and I'm willing to bet there's a way to unify this tactic or something very similar to work around the issue. </p>
    </div>
</div>
