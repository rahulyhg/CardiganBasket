<?php 
/*
Template Name: Blog Page
 */

get_header(); ?>

	<!-- Page -->
	<div id="page-wrapper">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php 
						$headerbgcolor = esc_attr(get_post_meta( $post->ID, '_mpt_page_header_bg_color', true ));
						$headertextcolor = esc_attr(get_post_meta( $post->ID, '_mpt_page_header_text_color', true ));
						$contentbgcolor = esc_attr(get_post_meta( $post->ID, '_mpt_page_content_bg_color', true ));
						$contenttextcolor = esc_attr(get_post_meta( $post->ID, '_mpt_page_content_text_color', true ));

						$col = get_post_meta( $post->ID, '_mpt_blog_page_layout', true );
						$entries = get_post_meta( $post->ID, '_mpt_blog_page_entries', true );
					?>

		<div class="header-section"<?php echo ($headerbgcolor != '#' && !empty($headerbgcolor) ? ' style="background: '.$headerbgcolor.';"' : '') ?>>
			<div class="outercontainer">
				<div class="container">

					<div class="clear padding30"></div>				
							
						<h1 class="page-header"><span<?php echo ($headertextcolor != '#' && !empty($headertextcolor) ? ' style="color: '.$headertextcolor.';"' : '') ?>><?php the_title(); ?></span></h1>

					<div class="clear padding15"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / header-section -->	


		<div class="content-section"<?php echo ($contentbgcolor != '#' && !empty($contentbgcolor) ? ' style="background: '.$contentbgcolor.';"' : '') ?>>
			<div class="outercontainer">
				<div class="clear padding30"></div>	
				<div class="container">

					<div class="row-fluid">

						<div class="span<?php echo ($col == '2col' || $col == '3col' ? '12' : '8') ?>"<?php echo ($contenttextcolor != '#' && !empty($contenttextcolor) ? ' style="color: '.$contenttextcolor.';"' : '') ?>>

							<?php the_content(); ?>					

					<?php endwhile; endif; ?>

							<?php

							  	$query_args = array(
									'echo' => true,
									'paginate' => true,
									'per_page' => $entries, 
									'order_by' => 'date', 
									'order' => 'DESC',
									'columns' => $col,
									'imagesize' => 'full',
									'btnclass' => '',
									'iconclass' => ''
								);						 

								flexmarket_display_wp_post_query( $query_args );
							?>

						</div><!-- / span -->
						
						<?php if ($col == '2col' || $col == '3col') {} else { ?>
							<div id="sidebar" class="span4">
									<?php get_sidebar(); ?>
							</div>
						<?php } ?>

					</div><!-- / row-fluid -->

					
					<div class="padding20"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / content-section -->	

	</div><!-- / page-wrapper -->

<?php get_template_part('footer', 'widget'); ?>

<?php get_footer(); ?>