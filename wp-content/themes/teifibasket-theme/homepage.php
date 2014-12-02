<?php
 /**
 * Template Name: tb-homepage
 *
 * @package WordPress
 */
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
 ?>
 <?php
 get_header('homepage');
 
 ?> 
 
	  
<div id="content">
	
<!--	
<section id="alert">
	<h1>Demo Website!</h1>
	<p>This website is a demo website for research purposes. All content (e.g. stores and products) is made up. This site used PayPal Sandbox and no money is taken on checkout.</p>
	<p>Created by<a href="http://www.markisonline.co.uk"> Mark Davies</a>.</p>
	<a href="#0" class="alert-close">Got it</a>
</section>   	    		    	
 -->
 
    	    		
   <div id="featured-products">
	   <h1> Featured Products</h1>
	   
	              
	              
	              <div id="mp_global_products_nav_links"><
	              
	              </div>
	           
	           
					<?php 
						/*
						 $args = array(
						    'echo' => true,
						    'paginate' => false,
						    'per_page' => 3,
						    'orderby' => 'rand',
						    'tag' => '',
								'show_thumbnail' => true,
								'thumbnail_size' => 100,
								'context' => 'list',
								'show_price' => true,
								'text' => 'none',
								'as_list' => true );
						
						
						mp_list_global_products( $args );
						*/
						
						
						mp_list_global_products( array('per_page' => 5,'order_by' => 'rand', 'text' => 'none') );
						
						    
					?> 
        <!--<p> <a href="">See more products</a></p>     -->               
                            
   </div> <!-- end of featured products--> 	    		
    	    
   <div id="how-it-works">
	   <h1> How it Works</h1>
	   <h2>The Teifi Basket makes it as easy to shop locally as it is to visit an out-of-town supermarket with the added bonus of
knowing where your products come from.</h2>

	<div id="steps">
		<div id="step">
			<img src='/wp-content/themes/teifibasket-theme/images/tb/step1-register.png'/>
			<h3>1. Register</h3>
			<p>Create your account by registering your e-mail address and setting yourself a password.</p>
		</div>
		<div id="step">
			<img src='/wp-content/themes/teifibasket-theme/images/tb/step2-shop.png'/>
			<h3>2. Shop</h3>
			<p>Shop between several local independent retailers and producers. Add the products you want to your basket.</p>			
		</div>
		<div id="step">
			<img src='/wp-content/themes/teifibasket-theme/images/tb/step3-pay.png'/>
			<h3>3. Pay</h3>	
			<p>Pay securely in a single transaction. You can order any day but the cut-off for Friday collections is 5:00 p.m. on Wednesdays. Orders placed after that time will be available for
collection the following Friday.</p>					
		</div>
		<div id="step">
			<img src='/wp-content/themes/teifibasket-theme/images/tb/step4-pickup.png'/>
			<h3>4. Pick up shopping</h3>		
			<p>Collect your shopping from the Pwllhai drive-through hub on a Friday between 3:00 p.m. and 8:00 p.m. There will be NO parking charge, and we’ll even put your shopping in your car for you!</p>				
		</div>

	</div> <!-- end of steps div id -->
	

   </div> <!-- end of how it works--> 		
    	    		
   <div id="find-us">
   	   <h1> Find Us </h1>
   	   <h2> Drive through and collect your shopping basket from the Teifi Basket Click & Collect Hub in Pwllhai 4CG car park, Cardigan, SA43 1DB. </h2>
   	   
   	   <div id="map-area">
	   	   <!--Div to hold the map.-->
	   	   <div id="cardigan-map">
		   </div> 
   	   </div>
    		
    		
   </div> <!-- end of find us--> 
       

</div>    
<?php
	/*get_sidebar();*/
    get_footer();
 ?>   



