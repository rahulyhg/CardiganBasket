<?php get_header(); ?>

	<!-- Page -->
	<div id="page-wrapper">

		<div class="header-section">
			<div class="outercontainer">
				<div class="container">

					<div class="clear padding30"></div>
							
						<h1 class="page-header"><span><?php _e('Our Products', 'flexmarket'); ?></span></h1>

					<div class="clear padding15"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / header-section -->	

		<div class="content-section">
			<div class="outercontainer">
				<div class="clear padding30"></div>	
				<div class="container" style="min-height: 450px;">			

					<?php if ( class_exists( 'MarketPress' ) ) { ?>

						<?php do_action('flexmarket_product_listing_page' , 'productlistingpage' , 'list'); ?>

					<?php } ?>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / content-section -->	

	</div><!-- / page-wrapper -->

<?php get_template_part('footer', 'widget'); ?>

<?php get_footer(); ?>