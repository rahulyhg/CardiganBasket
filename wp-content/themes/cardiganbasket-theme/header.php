<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->


	<title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="stylesheet" href=<?php bloginfo('template_directory'); ?>/css/shop.css type="text/css"/>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50070426-1', 'cardiganbasket.co.uk');
  ga('send', 'pageview');

</script>



<?php wp_head(); ?>
</head>



<body <?php body_class(); ?>>
<div id="page" > <!--class="hfeed site"-->	

	<header>
		<nav>
	    <a href="http://cardiganbasket.co.uk"><img src="<?php bloginfo('template_directory'); ?>/images/logo-navbar.png" width="152px" height="32px" /></a>
		<ul>
            <li><a href="http://cardiganbasket.co.uk/">ABOUT</a></li>
            <li class="active">SHOP</li>
            <li><a href="http://cardiganbasket.co.uk/join/">JOIN</a></li>
        </ul>
        
        
        
        
        
  
		

        
        
       
        
        
    </nav>
	</header>

	<div id="main" class="site-main"> 


