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
								      <li><a href="http://<?php echo $domain_name; ?>/#featured-products">Featured Products</a></li>
								      <li><a href="http://<?php echo $domain_name; ?>/news">News</a></li>
   								      <li><a href="http://<?php echo $domain_name; ?>/#how-it-works">How it Works</a></li>
								      <li><a href="http://<?php echo $domain_name; ?>/#find-us">Find Us</a></li>
								      <li><a href="http://<?php echo $domain_name; ?>/#footer-about-us">About Us</a></li>
								      <li><a href="http://<?php echo $domain_name; ?>/#footer-contactus">Contact Us</a></li>
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
										<li> <a href="http://<?php echo $domain_name; ?>/signup/"> Signup </a> </li>
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
								<h3>Start</h3>
								<h4>shopping</h4>
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
   										        	
   										        <optgroup value="/marketplace/categories/bakery/" label="Bakery" >
													<option value="/marketplace/categories/biscuits/">Biscuits</option>
											        <option value="/marketplace/categories/bread/">Bread</option>
	   										        <option value="/marketplace/categories/cakes/">Cakes</option>
	   										        <option value="/marketplace/categories/flour/">Flour</option>	   										        
	   										        <option value="/marketplace/categories/pastry/">Pastry</option>
	   											</optgroup>					
	   											
	   											<optgroup value="/marketplace/categories/beers-and-wines/" label="Beers/Wines" >		
										           	<option value="/marketplace/categories/beers/">Beers</option>
										           	<option value="/marketplace/categories/wines/">Wines</option>
										        </optgroup>
	   											
	   											<optgroup value="/marketplace/categories/chemist/" label="Chemist" >
													<option value="/marketplace/categories/cleaning/">Cleaning</option>
											        <option value="/marketplace/categories/eco-products/">Eco products</option>
	   										        <option value="/marketplace/categories/medicines/">Over the counter medicines</option>
	   										        <option value="/marketplace/categories/toiletries/">Toiletries</option>
	   											</optgroup>		

	   											 <optgroup value="/marketplace/categories/chocolate-and-confectionery/" label="Chocolate/Confectionery" >		
										           	<option value="/marketplace/categories/chocolate-and-confectionery/">See all chocolate and confectionery</option>
										        </optgroup>				        
										        
										        <optgroup value="/marketplace/categories/dairy/" label="Dairy" >		
										           	<option value="/marketplace/categories/butter/">Butter</option>
													<option value="/marketplace/categories/cheese/">Cheese</option>
													<option value="/marketplace/categories/cream/">Cream</option>
													<option value="/marketplace/categories/ice-cream/">Ice cream</option>
													<option value="/marketplace/categories/milk/">Milk</option>
										        </optgroup>
										        
										        <optgroup value="/marketplace/categories/delicatessen/" label="Delicatessen" >		
										           	<option value="/marketplace/categories/delicatessen/">See all delicatessen</option>
										        </optgroup>
										        
										        <optgroup value="/marketplace/categories/fish-and-shellfish/" label="Fish/Shell fish" >		
										           	<option value="/marketplace/categories/fish/">Fish</option>
										           	<option value="/marketplace/categories/shellfish/">Shell fish</option>
										        </optgroup>
										        
										        <optgroup value="/marketplace/categories/fruit/" label="Fruit" >
										        	<option value="/marketplace/categories/apples/">Apples</option>
										        	<option value="/marketplace/categories/apricots/">Apricots</option>										        	
										        	<option value="/marketplace/categories/bananas/">Bananas</option>
										        	<option value="/marketplace/categories/blueberries/">Blueberries</option>								
										        	<option value="/marketplace/categories/grapes/">Grapes</option>
										        	<option value="/marketplace/categories/lemons/">Lemons</option>
										        	<option value="/marketplace/categories/limes/">Limes</option>
										        	<option value="/marketplace/categories/mango/">Mango</option>
										        	<option value="/marketplace/categories/melons/">Melons</option>
										        	<option value="/marketplace/categories/nectarines/">Nectarines</option>
										        	<option value="/marketplace/categories/oranges/">Oranges</option>
										        	<option value="/marketplace/categories/pears/">Pears</option>
										        	<option value="/marketplace/categories/pineapple/">Pineapple</option>										        	
										        	<option value="/marketplace/categories/raspberries/">Raspberries</option>
										        	<option value="/marketplace/categories/rhubarb/">Rhubarb</option>
										        	<option value="/marketplace/categories/strawberries/">Strawberries</option>
										        </optgroup>
										        
										        <optgroup value="/marketplace/categories/meat/" label="Meat" >
												    <option value="/marketplace/categories/bacon">Bacon</option>
												    <option value="/marketplace/categories/beef">Beef</option>
   												    <option value="/marketplace/categories/chicken">Chicken</option>
   												    <option value="/marketplace/categories/pork">Pork</option>
   												    <option value="/marketplace/categories/sausages">Sausages</option>
												</optgroup>	
														
														
												<optgroup value="/marketplace/categories/pet-food/" label="Pet food" >
												    <option value="/marketplace/categories/pet-food">See all pet food</option>
   												 </optgroup>
   												 						        
												<optgroup value="/marketplace/categories/meat/" label="Salad" >
												    <option value="/marketplace/categories/avocado">Avocado</option>
												    <option value="/marketplace/categories/beetroot">Beetroot</option>
   												    <option value="/marketplace/categories/cress">Cress</option>
   												    <option value="/marketplace/categories/cucumber">Cucumber</option>
   												    <option value="/marketplace/categories/lettuce">Lettuce</option>
   													<option value="/marketplace/categories/peppers">Peppers</option>
   												    <option value="/marketplace/categories/radish">Radish</option>
   												    <option value="/marketplace/categories/spring-onions">Spring onions</option>
   												    <option value="/marketplace/categories/tomatoes">Tomatoes</option>  
   												    <option value="/marketplace/categories/watercress">Watercress</option>
   												 </optgroup>	
   												 	
										        <optgroup value="/marketplace/categories/vegetables/" label="Vegetables">
										        	<option value="/marketplace/categories/asparagus/">Asparagus</option>
										        	<option value="/marketplace/categories/aubergine/">Aubergine</option>
										        	<option value="/marketplace/categories/beans/">Beans</option>
										        	<option value="/marketplace/categories/broccoli/">Broccoli</option>
												    <option value="/marketplace/categories/brussels-sprouts/">Brussels sprouts</option>
													<option value="/marketplace/categories/carrots/">Carrots</option>
													<option value="/marketplace/categories/cauliflower/">Cauliflower</option>													
													<option value="/marketplace/categories/celeriac/">Celeriac</option>													
													<option value="/marketplace/categories/celery/">Celery</option>													
													<option value="/marketplace/categories/courgette/">Courgette</option>													
													<option value="/marketplace/categories/garlic/">Garlic</option>													
													<option value="/marketplace/categories/kale/">Kale</option>
													<option value="/marketplace/categories/leeks/">Leeks</option>
													<option value="/marketplace/categories/mushrooms/">Mushrooms</option>
													<option value="/marketplace/categories/onions/">Onions</option>
													<option value="/marketplace/categories/peas/">Peas</option>
													<option value="/marketplace/categories/potatoes/">Potatoes</option>
													<option value="/marketplace/categories/spinach/">Spinach</option>
													<option value="/marketplace/categories/squash/">Squash</option>
													<option value="/marketplace/categories/swede/">Swede</option>
													<option value="/marketplace/categories/turnips/">Turnips</option>
												</optgroup>		
												
												<optgroup value="/marketplace/categories/wholefoods/" label="Wholefoods">
										        	<option value="/marketplace/categories/baking-ingredients/">Baking ingredients</option>
													<option value="/marketplace/categories/cereals/">Cereals</option>
													<option value="/marketplace/categories/drinks/">Drinks</option>
													<option value="/marketplace/categories/food-supplements/">Food supplements</option>
													<option value="/marketplace/categories/gluten-free/">Gluten free</option>
													<option value="/marketplace/categories/grains/">Grains</option>
													<option value="/marketplace/categories/herbs/">Herbs</option>
													<option value="/marketplace/categories/jams-and-spreads/">Jams/Spreads</option>
													<option value="/marketplace/categories/nuts/">Nuts</option>
													<option value="/marketplace/categories/pasta/">Pasta</option>
													<option value="/marketplace/categories/pulses/">Pulses</option>
													<option value="/marketplace/categories/spices/">Spices</option>
													<option value="/marketplace/categories/vitamins/">Vitamins</option>

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
					<?php if (get_bloginfo('name') <> 'Teifi Basket' || '') { ?>
					<div id="site-logo">
						<img src="http://cardiganbasket.co.uk/wp-admin/images/shop-icon.png" width="24px" height="24px"/><h1> <?php echo bloginfo('name'); ?> Store</h1>
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