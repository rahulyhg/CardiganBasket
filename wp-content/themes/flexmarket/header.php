<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	<title><?php mpt_load_site_title(); ?></title>
	<meta name="description" content="<?php mpt_load_meta_desc(); ?>" />
	<meta name="keywords" content="<?php mpt_load_meta_keywords(); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php mpt_load_google_web_font_header(); ?>
	<?php mpt_load_google_web_font_body(); ?>
	<?php mpt_load_custom_google_font_header(); ?>
	<?php mpt_load_custom_google_font_body(); ?>	
	<link rel="shortcut icon" href="<?php mpt_load_favicon(); ?>" /> 
	<link href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" rel="stylesheet" />
	
	<?php wp_head(); ?>

	<?php mpt_load_base_style(); ?>

	<?php include(get_template_directory() . '/admin/custom-styles.php'); ?>

	<!--[if gte IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<style type="text/css">.gradient {filter: none;}</style>
	<![endif]-->

	<?php mpt_load_header_code(); ?>


</head>

<body id="body-wrapper" <?php body_class(); ?>>

	<!-- Header Section -->
	<div id="header-wrapper" class="navbar navbar-static-top">
		<div class="navbar-inner">
			<div class="outercontainer">
			<div class="container">	

			<div class="clear padding30"></div>

			<div class="row-fluid">
				
				<!-- Logo -->
				<div class="span2">
					<?php mpt_load_site_logo(); ?>
				</div>
                            
                
				<!-- Nav -->
				<div class="span10">
          
			        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			        </a>	
					
					<div class="nav-collapse">

						<?php 

							wp_nav_menu(array(
										'theme_location' => 'mainmenu',
										'depth'      => 2,
										'container'	=> false,
										'menu_class'	=> 'nav nav-pills pull-right',
										'walker' => new twitter_bootstrap_nav_walker()
										)); 
						?>
                        

					</div>

				</div>

			</div><!-- / row-fluid -->

			</div><!-- / container -->
		</div><!-- / outercontainer -->
		</div><!-- / navbar-inner -->
	</div><!-- / navbar -->
	<!-- End Header Section -->

	<div class="clear"></div>

<!-- End header -->