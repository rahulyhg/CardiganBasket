<?php
 /**
 * Template Name: join
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
 get_header();
 ?>   
<div id="content">
       	
      	<div id="signup">
   
        <h1>JOIN THE TEIFI BASKET</h1>
        
        <p>
        If you're a local <b>trader</b> in the Cardigan and Teifi Valley area, create your <b>free</b>
        online shop here and be part of the Teifi Basket community.
        </p>
        
        <a href= "/wp-signup.php" ><img src=<?php bloginfo('template_directory'); ?>/images/button_createshop.png width="127" height="36" /></a>
        
        <h4>
        <a href="wp-admin/CardiganBasketGuide.pdf" TARGET="_blank">(Download</a> the detailed guide that explains step-by-step how to create a user account and set up a shop.)
        </h4>
        
        </div>        
        
</div>
    
<?php
	get_sidebar();
    get_footer();
 ?>   
