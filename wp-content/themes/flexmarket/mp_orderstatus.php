<?php get_header(); ?>

<?php 
	$btnclass = mpt_load_mp_btn_color();
	$iconclass = mpt_load_whiteicon_in_btn();
?>

	<!-- Page -->
	<div id="page-wrapper">

		<div class="header-section">
			<div class="outercontainer">
				<div class="container">

					<div class="clear padding30"></div>
							
						<h1 class="page-header"><span><?php _e('Track Your Order', 'flexmarket'); ?></span></h1>

					<div class="clear padding15"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / header-section -->	

		<div class="content-section">
			<div class="outercontainer">
				<div class="clear padding30"></div>	
				<div class="container" style="min-height: 450px;">

					<div id="mp_cart_page">			

						<?php if ( class_exists( 'MarketPress' ) ) { ?>

							<?php mp_order_status(); ?>

						<?php } ?>

					</div>
					
					<div class="clear padding20"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / content-section -->	

	</div><!-- / page-wrapper -->

<?php get_template_part('footer', 'widget'); ?>

<?php get_footer(); ?>