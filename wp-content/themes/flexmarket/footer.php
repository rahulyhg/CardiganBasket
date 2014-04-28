	<!-- Footer section-->
	<div class="footer-wrapper">
		<div class="outercontainer">
		<div class="clear padding10"></div>
			<div class="container">

				<div class="row-fluid">

					<div class="span4 pull-left">
						<ul class="social-links">
							<?php mpt_social_icon_section(); ?>
						</ul>
					</div>

					<div class="span8">
						<div class="pull-right">
							<?php mpt_load_footer_text(); ?>
						</div>
					</div>

				</div>

			</div>
		</div>
		<div class="clear"></div>
	</div>
	<!-- End Footer section -->

	<?php get_template_part('js') ?>

	<?php mpt_load_body_code(); ?>

	<?php wp_footer();?>
	
</body>
</html>