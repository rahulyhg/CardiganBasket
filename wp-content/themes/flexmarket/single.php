<?php get_header(); ?>

<?php 
	$btnclass = mpt_load_mp_btn_color();
	$iconclass = mpt_load_whiteicon_in_btn();
?>

	<!-- Post -->
	<div id="post-wrapper">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php 
						$headerbgcolor = esc_attr(get_post_meta( $post->ID, '_mpt_post_header_bg_color', true ));
						$headertextcolor = esc_attr(get_post_meta( $post->ID, '_mpt_post_header_text_color', true ));
						$contentbgcolor = esc_attr(get_post_meta( $post->ID, '_mpt_post_content_bg_color', true ));
						$contenttextcolor = esc_attr(get_post_meta( $post->ID, '_mpt_post_content_text_color', true ));
					?>

		<div class="header-section"<?php echo ($headerbgcolor != '#' && !empty($headerbgcolor) ? ' style="background: '.$headerbgcolor.';"' : '') ?>>
			<div class="outercontainer">
				<div class="container">

					<div class="clear padding20"></div>		

					<div class="row-fluid">

						<div class="span2">

							<div class="date-comment-box">

								<?php 
									$year  = get_the_time('Y'); 
									$month = get_the_time('M'); 
									$day   = get_the_time('j'); 
								?>

								<div class="date">

									<span class="month"><?php echo $month; ?></span>

									<div class="clear"></div>

									<span class="day"><?php echo $day; ?></span>

									<div class="clear"></div>

									<span class="year"><?php echo $year; ?></span>

								</div>

								<div class="comments"><a href="<?php comments_link(); ?>"><?php comments_number( 'No Comments' , '1 Comment' , '% Comments' ); ?></a></div>

							</div>

						</div>

						<div class="span10">
							
							<h1 class="page-header"><span<?php echo ($headertextcolor != '#' && !empty($headertextcolor) ? ' style="color: '.$headertextcolor.'; border-bottom-color: '.$headertextcolor.'; border-top-color: '.$headertextcolor.';"' : '') ?>><?php the_title(); ?></span></h1>	

							<div class="post-meta">
								<p><?php _e( 'Posted By ', 'flexmarket' ); ?><?php the_author(); ?> <?php _e( 'In', 'flexmarket' ); ?> <span class="label label-tag"><?php the_category('</span> <span class="label label-tag">'); ?></span> <?php the_tags( __( 'Tagged with ', 'flexmarket' ).'<span class="label label-tag">' , '</span> <span class="label label-tag">' , '</span>'); ?> </p>
							</div>

						</div>

						<div class="clear padding20"></div>

					</div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / header-section -->	



		<div class="content-section"<?php echo ($contentbgcolor != '#' && !empty($contentbgcolor) ? ' style="background: '.$contentbgcolor.';"' : '') ?>>
			<div class="outercontainer">
				<div class="clear padding30"></div>	
				<div class="container">

					<div class="row-fluid">
						<div class="span8">

							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php echo ($contenttextcolor != '#' && !empty($contenttextcolor) ? ' style="color: '.$contenttextcolor.';"' : '') ?>>

								<?php mpt_load_top_code(); ?>	

								<?php $temp = get_post_meta( $post->ID, '_mpt_post_select_temp', true ); ?>
								<?php if (has_post_thumbnail( $post->ID ) || $temp == 'video' ) : ?>


								<?php
									$id = get_the_ID();
									$featured_args = array(
										'echo' => true,
										'post_id' => $id,
										'content_type' => 'single',
										'prettyphoto' => true,
										'imagesize' => 'tb-860',
										'videoheight' => 300,
										'btnclass' => '',
										'iconclass' => '',
									);

									if ($temp == 'image-carousel') {
										mpt_load_image_carousel( $featured_args );
									} else if ($temp == 'video') {
										mpt_load_video_post( $featured_args );
									} else {
										mpt_load_featured_image( $featured_args );
									}							
								?>

								<?php endif; ?>	

								<div class="clear padding20"></div>

								<?php the_content(); ?>
								<div class="clear padding20"></div>
								<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
								<div class="clear padding30"></div>

								<?php comments_template(); ?>

							</div>

					<?php endwhile; endif; ?>

						<?php mpt_load_bottom_code(); ?>
						
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