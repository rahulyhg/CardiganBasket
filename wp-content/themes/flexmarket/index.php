<?php get_header(); ?>

	<!-- Homepage Content -->

	<div id="homepage-content-wrapper">
		<div class="outercontainer">
			<div class="clear padding15"></div>	
			<div class="container">

				<?php 

					$homepagetemplateid = esc_attr(get_option('mpt_homepage_layout_code'));

					if (!empty($homepagetemplateid) && is_numeric($homepagetemplateid)) { 

						echo do_shortcode('[template id="'.$homepagetemplateid.'"]'); 

					}  else {
						if ( class_exists( 'MarketPress' ) ) {
							do_action('flexmarket_product_listing_page' , 'productlistingpage' , 'list');
						}
					} 

				?>

			</div><!-- / container -->
		</div><!-- / outercontainer -->	
	</div><!-- / homepage-content-wrapper -->

	<!-- End Homapage Content -->

	<!-- Footer Widget -->

	<?php 
		$selected = get_option('mpt_enable_homepage_footer_widget');

		if ($selected) {
			get_template_part('footer', 'widget'); 
		}
		
	?>

	<!-- End Footer Widget -->

<?php get_footer(); ?>