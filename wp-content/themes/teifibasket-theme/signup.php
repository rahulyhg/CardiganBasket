<?php
 /**
 * Template Name: signup (create account)
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
	<?php $domain_name =  preg_replace('/^www\./','',$_SERVER['SERVER_NAME']); ?>
	<div id="signup">
		<h1>Create Account</h1>
		<p>Thank you for visiting the Teifi Basket. If you have not already done so, please read <a href="http://<?php echo $domain_name; ?>/#how-it-works">‘How it works’</a> and <a href="http://<?php echo $domain_name; ?>/#footer-about-us">‘About us’</a>. </p>
		<p>Click on one of the buttons below to set up your account as either a Seller or a Customer.</p>
		
		<div id="seller">
			<img src="/wp-content/themes/teifibasket-theme/images/tb/seller-banner.png" /> 
			<h1>Sign up as a seller</h1>
			<ul>
				<li>Create your own shop on the Teifi Basket website – we will provide support & training</li>
				<li>For independent producers and retailers – not for large multiples</li>
				<li>‘Click & Collect’ service to help you gain additional customers</li>
				<li>You DO NOT need to have a physical shop  – you may operate your business from your  home or farm</li>
				<li>You will need to be able to deliver customer orders to the ‘Click & Collect’ hub in Pwllhai, Cardigan each Friday by noon</li>
				<li>You will need to have a PayPal account set up to ensure you receive payment promptly</li>
				<li>We ask that your selling prices are no higher than you would normally charge customers</li>
				<li> In order to cover the Teifi Basket costs, we (4CG) will require 15% of the customer spend with you</li>
			</ul>
			
			<a href="<?php echo site_url(); ?>/wp-signup.php"><img class="seller-button" src="/wp-content/themes/teifibasket-theme/images/tb/seller-button.png" /></a>
			
			
		</div>
		<div id="customer">
			<img src="/wp-content/themes/teifibasket-theme/images/tb/customer-banner.png" />
			<h1>Sign up as a customer</h1>
			
			<ul>
				<li>You’ll be supporting local shops and producers</li>
				<li>You can live (and shop from) anywhere but you will need to collect your order from the ‘Click & Collect’ hub in Cardigan on Fridays between 3:00 and 8:00 p.m.</li>
				<li>You DO need to create an account before you shop – there is no joining fee</li>
				<li>You will need to pay using PayPal (debit and credit card payments accepted)</li>
				<li>If you need help please contact us via email or telephone</li>
				<li>We look forward to your orders!</li>
			</ul>
			
			<a href="<?php echo site_url(); ?>/register"><img class="customer-button" src="/wp-content/themes/teifibasket-theme/images/tb/customer-button.png" /></a>

		</div>

	</div>

	
</div>
    
<?php
	 get_sidebar();
    get_footer();
 ?>   
