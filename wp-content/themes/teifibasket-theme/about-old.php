<?php
 /**
 * Template Name: about
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
        <h1> What is Basged Teifi/Teifi Basket? </h1>
        
        <p>
         Basged Teifi/Teifi Basket is a research prototype, allowing local Traders in Cardigan to build their stores online. Items being sold in these virtual stores will be displayed in one global store, here (Teifi Basket), and allow customers to shop across the multiple stores of Cardigan and the Teifi Valley, online using a single shopping basket.
         
        </p>
        
        <img src="<?php bloginfo('template_directory'); ?>/images/cardigan-basket-overview.png" alt="cardigan basket overview"/>
    	</div>
    </div>
    
    <?php if($bp_existed == 'true') : ?>
	<?php do_action( 'bp_before_blog_page' ) ?>
	<?php endif; ?>
	<?php get_template_part( 'content', 'page' );?>
	<div class="clear"></div>
	<?php if($bp_existed == 'true') : ?>
	<?php do_action( 'bp_after_blog_page' ) ?>
	<?php endif; ?>
    

</div>

<?php
	get_sidebar();
    get_footer();
 ?>   





