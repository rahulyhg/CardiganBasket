<?php get_header(); ?>

	<!-- Page -->
	<div id="page-wrapper">

		<div class="header-section">
			<div class="outercontainer">
				<div class="container">

					<div class="clear padding30"></div>	

							<h2 class="page-header"><span><?php _e('Search Results' , 'flexmarket'); ?></span></h2>

						<div class="clear padding15"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / header-section -->	


		<div class="content-section">
			<div class="outercontainer">
				<div class="clear padding30"></div>	
				<div class="container">

					<div class="row-fluid">
						<div class="span8">

							<?php 

								$searchterms = isset($wp_query->query_vars['s']) ? get_query_var('s') : '';

								$args = array(
									'searchterms' => esc_attr( $searchterms )
								);

							?>

							<?php flexmarket_display_wp_post_query( $args ); ?>

						</div><!-- / span8 -->
						
						<div id="sidebar" class="span4">
								<?php get_sidebar(); ?>
						</div>

					</div><!-- / row-fluid -->

					
					<div class="padding20"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / content-section -->	

	</div><!-- / page-wrapper -->

<?php get_template_part('footer', 'widget'); ?>

<?php get_footer(); ?>