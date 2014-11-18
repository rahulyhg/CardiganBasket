<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	

<meta charset="<?php bloginfo( 'charset' ); ?>" />
 		<?php include (get_template_directory() . '/buddypress/buddypress-globals.php'); ?>
	<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
	<?php if($bp_existed == 'true') : ?>
	<?php do_action( 'bp_head' ) ?>
	<?php endif; ?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php wp_head(); ?>
		<?php include(get_stylesheet_directory() . '/custom-styles.php'); ?>


		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-50070426-1', 'cardiganbasket.co.uk');
		  ga('send', 'pageview');

		</script>
		
		<script type="text/javascript">
		function handleSelect(elm)
		{
		window.location = elm.value;
		}
		</script>
		
		
		
		
		
		
		
		
<!--Connect to the google maps api using your api key-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSa4sPxyqZcHOTyAshg3iwF10-Bcfhf3Q&sensor=true"></script>

<script src="/wp-content/themes/teifibasket-theme/infobox/infobox.js" type="text/javascript"></script>


<!--Main chunk of javascript that creates and controls the map.-->
<script type="text/javascript">

//Create the variables that will be used within the map configuration options.
//The latitude and longitude of the center of the map.
var cardiganMapCenter = new google.maps.LatLng(52.082816, -4.66125);
//The degree to which the map is zoomed in. This can range from 0 (least zoomed) to 21 and above (most zoomed).
var cardiganMapZoom = 16;
//The max and min zoom levels that are allowed.
var cardiganMapZoomMax = 20;
var cardiganMapZoomMin = 14;


//These options configure the setup of the map. 
var cardiganMapOptions = { 
		  center: cardiganMapCenter, 
          zoom: cardiganMapZoom,
		  //The type of map. In addition to ROADMAP, the other 'premade' map styles are SATELLITE, TERRAIN and HYBRID. 
          mapTypeId: google.maps.MapTypeId.ROADMAP,
		  maxZoom:cardiganMapZoomMax,
		  minZoom:cardiganMapZoomMin,
		  //Turn off the map controls as we will be adding our own later.
		  panControl: false,
		  mapTypeControl: false,
		  
		//turn off the mouse scroll for zoom in/out when a user scrolls up and down the web page 
		scrollwheel: false,
		navigationControl: true,
		mapTypeControl: false,
		scaleControl: false,
		draggable: true,



    styles: [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]


		    
			
		  
};

//Create the variable for the main map itself.
var cardiganMap;

//When the page loads, the line below calls the function below called 'loadCardiganMap' to load up the map.
google.maps.event.addDomListener(window, 'load', loadCardiganMap);


 //Variable containing the style for the pop-up infobox.
var pop_up_info = "border: 0px solid black; background-color: #ffffff; padding:15px; margin-top: 8px; border-radius:10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; box-shadow: 1px 1px #888;";




//THE MAIN FUNCTION THAT IS CALLED WHEN THE WEB PAGE LOADS --------------------------------------------------------------------------------
function loadCardiganMap() {
	
//The empty map variable ('cariganMap') was created above. The line below creates the map, assigning it to this variable. The line below also loads the map into the div with the id 'cardigan-map' (see code within the 'body' tags below), and applies the 'cardiganMapOptions' (above) to configure this map. 
cardiganMap = new google.maps.Map(document.getElementById("cardigan-map"), cardiganMapOptions);	


//Calls the function below to load up all the map markers.
loadMapMarkers();



}



//Function that loads the map markers.
function loadMapMarkers (){

	//Shop -----------------
	
	//Setting the position of the Shop map marker.
	var markerPositionHQ = new google.maps.LatLng(52.082847, -4.660087);
	
	//Creating the shop marker.
	markerHQ = new google.maps.Marker({
	//uses the position set above.
	position: markerPositionHQ,
	//adds the marker to the map.
	map: cardiganMap,
	title: 'Collection Point',
	//sets the z-index of the map marker.
	zIndex:107 });
	
	
	
	//HQ
	//Creates the information to go in the pop-up info box.
	var boxTextHQ = document.createElement("div");
	boxTextHQ.style.cssText = pop_up_info;
	boxTextHQ.innerHTML = '<span class="pop_up_box_text">4CG Click & Collect Hub</span>';
	 
	//Sets up the configuration options of the pop-up info box.
	var infoboxOptionsHQ = {
	 content: boxTextHQ
	 ,disableAutoPan: false
	 ,maxWidth: 0
	 ,pixelOffset: new google.maps.Size(10, -100)
	 ,zIndex: null
	 ,boxStyle: {
	 background: "url('/wp-content/themes/teifibasket-theme/infobox/pop_up_box_top_arrow.png') no-repeat"
	 ,opacity: 1
	 ,width: "190px"
	 }
	 ,closeBoxMargin: "10px 2px 2px 2px"
	 ,closeBoxURL: "/wp-content/themes/teifibasket-theme/icons/button_close.png"
	 ,infoBoxClearance: new google.maps.Size(1, 1)
	 ,isHidden: false
	 ,pane: "floatPane"
	 ,enableEventPropagation: false
	};
	 
	
	//Creates the pop-up infobox for Cardigan, adding the configuration options set above.
	infoboxHQ = new InfoBox(infoboxOptionsHQ);
	 
	//Add an 'event listener' to the Shop map marker to listen out for when it is clicked.
	google.maps.event.addListener(markerHQ, "click", function (e) {
	 //Open the Cardigan info box.
	 infoboxHQ.open(cardiganMap, this);
	 //Changes the z-index property of the marker to make the marker appear on top of other markers.
	 this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
	 //Zooms the map.
	 setZoomWhenMarkerClicked();
	 //Sets the Shop marker to be the center of the map.
	 cardiganMap.setCenter(markerHQ.getPosition());
	 
	 
	
	});



}



</script>
	
		
		

	</head>
	<body <?php body_class() ?>>
			<?php if($bp_existed == 'true') : ?>
				<?php do_action( 'bp_before_header' ) ?>
			<?php endif; ?>
			<div id="wrapper">
						
					<?php
						 $current_user1 = wp_get_current_user();
						 $curr_user = $current_user1->user_login;
						 //$username = strtoupper ($curr_user);
						 $username = $curr_user;
						 /*$domain_name = $_SERVER['SERVER_NAME'];*/
						 $domain_name =  preg_replace('/^www\./','',$_SERVER['SERVER_NAME']);
					?>

											

						
					<div id="cover-photo">
															
					</div>	<!-- end of div cover-photo -->
						
					<div id="header-bottom">
								
					
					
					</div> <!-- end of div header-bottom -->
					
					<div id="top-bar">
						
						<!-- SITE LOGO -->
						    <a href="/"><img class ="logo" src="/wp-content/themes/teifibasket-theme/images/tb/logo.png" width="150px" height="33px" /></a>
						
						<div id="top-bar-links">
							<p><a href="/store/shopping-cart/"><img src='/wp-content/themes/teifibasket-theme/images/tb/shopping-basket.png' width="21px" height="16px"/> Basket (<?php  echo mp_items_count_in_cart(); ?>)</a></p>

							<ul>
								
								<li>Menu
									<ul>
								      <li><a href="/">Home</a></li>
								      <li><a href="#featured-products">Featured Products</a></li>
								      <li><a href="http://<?php echo $domain_name; ?>/news">News</a></li>
   								      <li><a href="#how-it-works">How it Works</a></li>
								      <li><a href="#find-us">Find Us</a></li>
								      <li><a href="#footer-about-us">About Us</a></li>
								      <li><a href="#footer-contactus">Contact Us</a></li>
								    </ul>
								 <img src='/wp-content/themes/teifibasket-theme/images/tb/arrow-down.png' />
								 </li>   
								
								
								<!-- Check whether or not the user is signed in, if they are display sign out-->							
								<?php										
								if ( is_user_logged_in() ) {
										//echo 'Welcome, registered user!';
										?>
										<!-- Check if customer/subscriber or admin/shop owner. If admin then link to dashboard/bask-end, if customer then disable the back-end and only show a simple edit account page for password change -->
										<!-- if its the super admin -->
								
										<?php 
											
											$user_ID = get_current_user_id();
											if($user_ID && is_super_admin( $user_ID )) {
											//if ( current_user_can('manage_options') ) { 
											?>
										
											<li><a href="http://<?php echo $domain_name; ?>/wp-admin/"><?php echo /*"Logged in as '".$username."'"*/'My Account ('.$username.')'; ?></a></li>
											<li><a href="<?php echo wp_logout_url(); ?>"> Log Out</a></li>
							            <?php } 
								            
								            //if its a customer (subscriber)
								            elseif (user_can( $current_user1, "subscriber" )) {
									    	?>
									    	        
									        <li><a href="http://<?php echo $domain_name; ?>/edit-account/"><?php echo /*"Logged in as '".$username."'"*/'My Account ('.$username.')'; ?></a></li> 
											<li><a href="<?php echo wp_logout_url(); ?>"> Log Out</a></li>
							                  
									        <?php    
								            }
								            //if its the other shops/sellers
								            else{ ?>
								            <?php
									            
									            //if you are a seller you will have a site
									        global $usrblogname; 
								            $blogs = get_blogs_of_user( $current_user1->id );
												if($blogs) {
													foreach ( $blogs as $blog ) {
														if($blog->userblog_id != 1) { 
														$usrblogname = $blog->domain.$blog->path;
														}
													}
													
													//customers
													if(empty($usrblogname)){ ?>
														<li><a href="http://<?php echo $domain_name; ?>/edit-account/"><?php echo /*"Logged in as '".$username."'"*/'My Account ('.$username.')'; ?></a></li> 
														<li><a href="<?php echo wp_logout_url(); ?>"> Log Out</a></li>
													<?php
													}
													//sellers
													else{ 
													?>
														<li><a href="http://<?php echo $usrblogname; ?>wp-admin/"><?php echo /*"Logged in as '".$username."'"*/'My Account ('.$username.')'; ?></a></li> 
														<li><a href="<?php echo wp_logout_url(); ?>"> Log Out</a></li>	
													<?php
													}
													
											
												
												}
												?>												
													 
							            
							
							            
							            <?php } ?>
								<?php
									} else {
										//echo 'Welcome, visitor!';
										?>
										<li> <a href="http://<?php echo $domain_name; ?>/signup/"> Create Account </a> </li>
									<li> <a href="http://<?php echo $domain_name; ?>/login">Log In</a> </li>
								<?php
									}
								?>	
								
								
							</ul>

							
						</div>			
									
					</div>		
						
					<div id="shopping-area">
						
						
						<h2>‘Click & Collect’ shopping service helping local people buy local products</h2>
						
						
							<div id="order-collect-location-info">
								<ul><!--
									<li class="icon-order">Order Deadlines: Wednesdays 5pm </li> 
									<li class="icon-collection">Collections: Fridays between 3pm - 8pm</li> 
									<li class="icon-location">Location: 4CG click & collect hub, Pwllhai car park</li> 
									-->
									<li><img src='/wp-content/themes/teifibasket-theme/images/tb/icon-order.png'/>Order Deadlines: Wednesdays 5pm </li> 
									<li><img src='/wp-content/themes/teifibasket-theme/images/tb/icon-collect.png'/>Collections: Fridays between 3pm - 8pm</li> 
									<li><img src='/wp-content/themes/teifibasket-theme/images/tb/icon-location.png'/>Location: 4CG click & collect hub, Pwllhai car park</li> 
								</ul>
								
							</div> <!-- end of order-collect-location-info div -->
							
							
							
							
					
								<div id="shopping-bar">
								<h3>Shop</h3>
								<h4>right now</h4>
								<ul>
									<li>By Seller</li>
									<li>By Category</li>
									<li class="sleft">By Keywords</li>
									
									<div id="sellers">
										<div id="mp-storepicker"><?php framemarket_listall_shops(); ?></div>
									</div>
									
									<div id="categories">
										    <select class="dropdown-menu" onchange="javascript:handleSelect(this)">
   										        <option>Select a category...</option>	
   										        	
   										        <optgroup value="/marketplace/categories/bakery/" label="Bakery" >					    																	<option value="/marketplace/categories/biscuits/">Biscuits</option>
											        <option value="/marketplace/categories/bread/">Bread</option>
	   										        <option value="/marketplace/categories/cakes/">Cakes</option>							        										        		<option value="/marketplace/categories/pastry/">Pastry</option></a>
	   											</optgroup>									        
										        
										        <optgroup value="/marketplace/categories/dairy/" label="Dairy" >										        										        	<option value="/marketplace/categories/butter/">Butter</option>
													<option value="/marketplace/categories/cheese/">Cheese</option>
													<option value="/marketplace/categories/milk/">Milk</option>
										        </optgroup>
										        <optgroup value="/marketplace/categories/fruit/" label="Fruit" >
										        	<option value="/marketplace/categories/apples/">Apples</option>
										        	<option value="/marketplace/categories/bananas/">Bananas</option>
										        	<option value="/marketplace/categories/bananas/">Blueberries</option>								
										        	<option value="/marketplace/categories/grapes/">Grapes</option>
										        	<option value="/marketplace/categories/lemons/">Lemons</option>
										        	<option value="/marketplace/categories/melons/">Melons</option>
										        	<option value="/marketplace/categories/oranges/">Oranges</option>
										        	<option value="/marketplace/categories/raspberries/">Raspberries</option>
										        	<option value="/marketplace/categories/strawberries/">Strawberries</option>
										        </optgroup>
										        
										        <optgroup value="/marketplace/categories/meat/" label="Meat" >
												    <option value="/marketplace/categories/bacon">Bacon</option>
												    <option value="/marketplace/categories/beef">Beef</option>
   												    <option value="/marketplace/categories/chicken">Chicken</option>
   												    <option value="/marketplace/categories/pork">Pork</option>
   												    <option value="/marketplace/categories/sausages">Sausages</option>
												</optgroup>									        
										        <optgroup value="/marketplace/categories/vegetables/" label="Vegetables">
										        	<option value="/marketplace/categories/broccoli/">Broccoli</option>
													<option value="/marketplace/categories/carrots/">Carrots</option>
													<option value="/marketplace/categories/leeks/">Leeks</option>
													<option value="/marketplace/categories/onions/">Onion</option>
													<option value="/marketplace/categories/potatoes/">Potatoes</option>
													<option value="/marketplace/categories/spinach/">Spinach</option>
												</optgroup>									        

										    </select>
									</div>
									
									
									<div id="search">
										<!--<form>
											<input class="search" type="text" placeholder="Search..." required>
											<input class="button" type="button" value="Search">
										</form>
										-->
										
										<?php
											$options = get_option('framemarket_theme_options');
											$searchbar = isset($options['searchinput']) ? $options['searchinput'] : '';
										?>
										<?php if(($searchbar == '' || $searchbar == 'BuddyPress') && $bp_existed == 'true') : ?>
											<?php if ( apply_filters( 'bp_search_form_enabled', true ) ): $bp_search_form = true; ?>
												<div id="buddypress-searchbar"> -->
													<form action="<?php echo bp_search_form_action() ?>" method="post" id="search-form">
														<input class="search" type="search-keywords" placeholder="Search..." required />
														<?php echo bp_search_form_type_select() ?>
					
														<input class="button" type="search-button" value="Search" />
														<?php wp_nonce_field( 'bp_search_form' ) ?>
													</form><!-- #search-form -->
													<?php do_action( 'bp_search_login_bar' ) ?>
												</div> 
											<?php endif; ?>
										<?php endif; ?>
										<?php if ( ! isset($bp_search_form) || !$bp_search_form ): ?>
											<div id="search-bar">
												<?php get_search_form(); ?>
											</div>
										<?php endif ?>
										
									</div> <!-- End of id="Search" -->

								</ul>
							</div> <!-- End of shopping bar-->
							
							
							
							
							

						
						
					</div> <!-- end of div shopping area -->
						
				  
				
				
				
				
				
				
			<div id="branding-wrapper">
				<div id="branding">
					<div id="branding-inner">
					<?php
						$options = get_option('framemarket_theme_options');
						$logotype = isset($options['logoinput']) ? $options['logoinput'] : '';
						$logotext = isset($options['logotext']) ? $options['logotext'] : '';
				
					?>
					<?php if (get_bloginfo('name') <> '') { ?>
					<div id="site-logo">
						<img src="http://cardiganbasket.co.uk/wp-admin/images/shop-icon.png" width="24px" height="24px"/><h2>>></h2><h1> <?php echo bloginfo('name'); ?> Store</h1>
					</div>
					<?php } ?>
					
					<div id="site-advert">
						<?php
						$options = get_option('framemarket_theme_options');
						$advert = isset($options['adverttextarea']) ? $options['adverttextarea'] : '';
						if ($advert != ""){
							echo stripslashes($advert);
						}
						?>
					</div>
					</div>
				</div>
			</div>
			
			
			<div id="navigation-wrapper">
				<div id="navigation">
					<?php wp_nav_menu( array('theme_location' => 'main_menu', 'menu_class' => 'nav', 'container' => '', )); ?>
						<?php if($bp_existed == 'true') : ?>
							<ul class="nav">
								<li><a href="">Community</a>
								<ul class="submenu">
								<?php if ( 'activity' != bp_dtheme_page_on_front() && bp_is_active( 'activity' ) ) : ?>
									<li<?php if ( bp_is_page( BP_ACTIVITY_SLUG ) ) : ?> class="selected"<?php endif; ?>>
										<a href="<?php echo site_url() ?>/<?php echo BP_ACTIVITY_SLUG ?>/" title="<?php _e( 'Activity', 'framemarket' ) ?>"><?php _e( 'Activity', 'framemarket' ) ?></a>
									</li>
								<?php endif; ?>

								<li<?php if ( bp_is_page( BP_MEMBERS_SLUG ) || bp_is_user() ) : ?> class="selected"<?php endif; ?>>
									<a href="<?php echo site_url() ?>/<?php echo BP_MEMBERS_SLUG ?>/" title="<?php _e( 'Members', 'framemarket' ) ?>"><?php _e( 'Members', 'framemarket' ) ?></a>
								</li>

								<?php if ( bp_is_active( 'groups' ) ) : ?>
									<li<?php if ( bp_is_page( BP_GROUPS_SLUG ) || bp_is_group() ) : ?> class="selected"<?php endif; ?>>
										<a href="<?php echo site_url() ?>/<?php echo BP_GROUPS_SLUG ?>/" title="<?php _e( 'Groups', 'framemarket' ) ?>"><?php _e( 'Groups', 'framemarket' ) ?></a>
									</li>
								<?php endif; ?>

								<?php if ( bp_is_active( 'forums' ) && bp_is_active( 'groups' ) && ( function_exists( 'bp_forums_is_installed_correctly' ) && !(int) bp_get_option( 'bp-disable-forum-directory' ) ) && bp_forums_is_installed_correctly() ) : ?>
									<li<?php if ( bp_is_forums_component() && !bp_is_user_forums() ) : ?> class="selected"<?php endif; ?>>
										<a href="<?php echo site_url() ?>/<?php echo bp_forums_root_slug() ?>/" title="<?php _e( 'Forums', 'framemarket' ) ?>"><?php _e( 'Forums', 'framemarket' ) ?></a>
									</li>
								<?php elseif ( function_exists('bbpress') ): ?>
									<li<?php if ( bbp_is_forum($post->ID) || bbp_is_topic($post->ID) ) : ?> class="selected"<?php endif; ?>>
										<a href="<?php bbp_forums_url(); ?>"><?php _e( 'Forums', 'framemarket' ) ?></a>
									</li>
								<?php endif; ?>

								<?php if ( bp_is_active( 'blogs' ) && is_multisite() ) : ?>
									<li<?php if ( bp_is_page( BP_BLOGS_SLUG ) ) : ?> class="selected"<?php endif; ?>>
										<a href="<?php echo site_url() ?>/<?php echo BP_BLOGS_SLUG ?>/" title="<?php _e( 'Blogs', 'framemarket' ) ?>"><?php _e( 'Blogs', 'framemarket' ) ?></a>
									</li>
								<?php endif; ?>
								<?php do_action( 'bp_nav_items' ); ?>
								</ul>
								</li>
							</ul>
						<?php endif; ?>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<?php if($bp_existed == 'true') : ?>
					<?php do_action( 'bp_after_header' ) ?>
					<?php do_action( 'bp_before_container' ) ?>
			<?php endif; ?>
			
		
	</div>  <!-- end of div wrapper -->

			
			<div id="site-wrapper">
				<div id="container">