<?php
	$showfooterwidget = get_option('mpt_enable_footer_widget');
?>


<?php if ($showfooterwidget == 'true') { ?>

	<!-- Footer Widget -->
	<div id="footer-widget">
		<div class="footer-widget-top"></div>
		<div class="outercontainer">
			<div class="container">
				
				<div class="clear padding30"></div>		

				<div class="row-fluid">

					<!-- start 1st footer widget -->
					<div class="span<?php mpt_footer_widget_setting_1(); ?>">
						<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
								<?php dynamic_sidebar( 'footer-one' ); ?>
						<?php endif; ?>
					</div>
					<!-- end 1st footer widget -->

					<!-- start 2nd footer widget -->
					<div class="span<?php mpt_footer_widget_setting_2(); ?>">
						<?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
								<?php dynamic_sidebar( 'footer-two' ); ?>
						<?php endif; ?>
					</div>
					<!-- end 2nd footer widget -->	

					<!-- start 3rd footer widget -->
					<div class="span<?php mpt_footer_widget_setting_3(); ?>">
						<?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
								<?php dynamic_sidebar( 'footer-three' ); ?>
						<?php endif; ?>
					</div>
					<!-- end 3rd footer widget -->

				</div>

				<div class="clear padding30"></div>	

			</div><!-- / container -->
		</div><!-- / outercontainer -->	
	</div><!-- / content-section -->	

<?php } ?>