<?php
 /**
 * Template Name: signup
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
       	<!--
      <?php if($bp_existed == 'true') : ?>
	<?php do_action( 'bp_before_blog_page' ) ?>
	<?php endif; ?>
	<?php get_template_part( 'content', 'page' );?>
	<div class="clear"></div>
	<?php if($bp_existed == 'true') : ?>
	<?php do_action( 'bp_after_blog_page' ) ?>
	<?php endif; ?>
	
	-->
	
	<p>Sign up to create an account to the Teifi Basket as a Seller or as a Customer</p>
	<br>
	<a href="<?php echo site_url(); ?>/wp-signup.php"><img src="<?php bloginfo('template_directory'); ?>/images/signup-seller.png" /></a> &nbsp;
	<a href="<?php echo site_url(); ?>/register"><img src="<?php bloginfo('template_directory'); ?>/images/signup-customer.png" /></a>

        
</div>
    
<?php
	 get_sidebar();
    get_footer();
 ?>   
