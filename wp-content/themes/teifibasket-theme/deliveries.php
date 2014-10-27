<?php
 /**
 * Template Name: deliveries
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


    
    <div id="what">
          
    	<div id="what-content">
        <h1> We deliver to SA43 </h1>
        
        <p>
         Deliveries are only available for our customers living in the SA43 area of Cardigan. Deliveries are every Friday between 3pm - 8pm.
         The deadline for a Friday delivery is two days before, on Wednesday's at 3pm. Any orders placed after 3pm on a Wednesday will be delivered on the Friday of the next week.
        </p>
        
        <div id= "map">
        <img src="<?php bloginfo('template_directory'); ?>/images/sa43-map.png" alt="cardigan sa43 area"/>
        </div>
        
    	</div>
    </div>
    
         

</div>

<?php
	get_sidebar();
    get_footer();
 ?>   





