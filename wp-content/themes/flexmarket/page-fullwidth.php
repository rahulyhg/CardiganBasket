<?php 
/*
Template Name: Page (full width)
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

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php echo ($contenttextcolor != '#' && !empty($contenttextcolor) ? ' style="color: '.$contenttextcolor.';"' : '') ?>>
							<?php the_content(); ?>
							<div class="clear padding20"></div>
							<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
							<div class="clear padding20"></div>
							<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
							<div class="clear padding30"></div>

							<?php 

								$showcomments = get_post_meta( $post->ID, '_mpt_page_show_comments', true );

								if ( $showcomments == 'on') {
									comments_template();
								} 
							?>

					</div>

					<?php endwhile; endif; ?>
											
					<div class="padding20"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / content-section -->	

	</div><!-- / page-wrapper -->

<?php get_template_part('footer', 'widget'); ?>

<?php get_footer(); ?>