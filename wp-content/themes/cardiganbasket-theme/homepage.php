<?php
 /**
 * Template Name: homepage-traders
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
<html>
<head>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="stylesheet" href=<?php bloginfo('template_directory'); ?>/css/homepage.css type="text/css"/>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50070426-1', 'cardiganbasket.co.uk');
  ga('send', 'pageview');

</script>

</head>

<body>
	
    <nav>
    	
    	<div id="nav-center">
            <a href="http://www.cardiganbasket.co.uk"><img src=<?php bloginfo('template_directory'); ?>/images/logo-navbar.png width="152" height="32" /></a>
            <a href="wp-login.php"><p>SIGN IN </p></a>
            <a href="signup.php"><p>REGISTER </p></a>  
        </div>
    </nav>

    <div id="container">
    
	<div id="content">
	    <div id="logo">
    	</div>
    	
      	<div id="signup">
   
        <h1>SIGN UP AND CREATE A SHOP</h1>
        
        <p>
        If you're a local <b>trader</b> in Cardigan, create your <b>free</b>
        online shop here and be part of the Cardigan Basket
        community.
        </p>
        
        <a href="signup.php"><img src=<?php bloginfo('template_directory'); ?>/images/button_createshop.png width="136" height="49" /></a>
        
        <h4>
        <a href="CardiganBasketGuide.pdf" TARGET="_blank">(Download</a> the detailed guide that explains step-by-step how to create a user account and set up a shop.)
        </h4>
        
        </div>
        
        
    </div>
    
    </div>
</body>

</html>