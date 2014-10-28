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
						
					
						<div id="top-bar">
						<nav>
							<ul>
								<li class="nav-button-home"><a href="/">Home</li></a>
								<li class="nav-button-about"><a href="#">About us</li></a>
								<li class="nav-button-how"><a href="#">How it works</li></a>
								<li class="nav-button-sellers"><a href="#">Meet the sellers</li></a>
								<li class="nav-button-news"><a href="#">News</li></a>
								<li class="nav-button-contact"><a href="#">Contact us</li></a>
								
							</ul>
						</nav>
						<div id="register-login">
							
							<!-- Check whether or not the user is signed in, if they are display sign out-->
							 <?php
								 $current_user = wp_get_current_user();
								 
								if ( is_user_logged_in() ) {
									//echo 'Welcome, registered user!';
									?>
									<!-- Check if customer/subscriber or admin/shop owner. If admin then link to dashboard/bask-end, if customer then disable the back-end and only show a simple edit account page for password change -->
									<?php if ( current_user_can('manage_options') ) { ?>
										<p><a href="<?php echo site_url(); ?>/wp-admin/"><?php echo $current_user->user_login; ?></a>  
						            <a href="<?php echo wp_logout_url(); ?>"> (Log Out)</a></p>
						            <?php } else{ ?>
						            
						            <p><a href="<?php echo site_url(); ?>/edit-account/"><?php echo $current_user->user_login; ?></a>  
						            <a href="<?php echo wp_logout_url(); ?>"> (Log Out)</a></p>
						            <?php } ?>
							<?php
								} else {
									//echo 'Welcome, visitor!';
									?>
							<p> <a href="<?php echo site_url(); ?>/signup/"> Create Account </a> / <a href="<?php echo site_url(); ?>/login">Log In</a> </p>
							<?php
								}
							?>

							
							
						</div>
						
						</div> <!-- end of div top-bar -->

						
						<div id="header">
							
							<div id="order-collect-location-info">
								<ul><!--
									<li class="icon-order">Order Deadlines: Wednesday’s 5pm </li> 
									<li class="icon-collection">Collections: Friday’s between 3pm - 8pm</li> 
									<li class="icon-location">Location: 4CG click & collect hub, Pwllhai car park</li> 
									-->
									<li><img src='/wp-content/themes/teifibasket-theme/images/tb/icon-order.png'/>Order Deadlines: Wednesday’s 5pm </li> 
									<li><img src='/wp-content/themes/teifibasket-theme/images/tb/icon-collect.png'/>Collections: Friday’s between 3pm - 8pm</li> 
									<li><img src='/wp-content/themes/teifibasket-theme/images/tb/icon-location.png'/>Location: 4CG click & collect hub, Pwllhai car park</li> 
								</ul>
								
							</div> <!-- end of order-collect-location-info div -->
							
							<!-- SITE LOGO -->
						    <a href="/"><img class ="logo" src="<?php bloginfo('template_directory'); ?>/images/tb/teifibasket-logo.png" width="218px" height="43px" /></a>
						    
						    <!-- SHOPPING BASKET -->
						    <div id="shopping-basket">
							    
								<a href="/store/shopping-cart/">
								<img src='/wp-content/themes/teifibasket-theme/images/tb/shopping-basket.png' width="25px" height="20px" /><p>Basket(<?php  echo mp_items_count_in_cart(); ?>)</p></a>
							</div>
							
							<div id="shopping-bar">
								<h3>Shop</h3>
								<h4>right now</h4>
								<ul>
									<li>By Seller</li>
									<li>By Category</li>
									<li>By Keywords</li>
									
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
							</div>
							
						</div>	<!-- end of div header -->
				  
			</div>  <!-- end of div wrapper -->
				
				
				
				
				
				
			<div id="branding-wrapper">
				<div id="branding">
					<div id="branding-inner">
					<?php
						$options = get_option('framemarket_theme_options');
						$logotype = isset($options['logoinput']) ? $options['logoinput'] : '';
						$logotext = isset($options['logotext']) ? $options['logotext'] : '';
				
					?>
					<div id="site-logo">
						<a href="<?php echo site_url(); ?>"><img src="http://cardiganbasket.co.uk/wp-admin/images/shop-icon.png" width="42px" height="42px"/><h1><?php echo bloginfo('name'); ?></h1></a>
					</div>
					
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
			
			
			<div id="site-wrapper">
				<div id="container">