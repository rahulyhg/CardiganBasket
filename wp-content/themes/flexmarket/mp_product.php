<?php get_header(); ?>

<?php
	$btnclass = mpt_load_mp_btn_color();
	$iconclass = mpt_load_whiteicon_in_btn();
	$tagcolor = mpt_load_icontag_color();
?>

	<!-- Post -->
	<div id="product-single-wrapper">

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

					<div class="clear padding30"></div>
							
						<h1 class="page-header"><span<?php echo ($headertextcolor != '#' && !empty($headertextcolor) ? ' style="color: '.$headertextcolor.';"' : '') ?>><?php the_title(); ?></span></h1>	

						<div class="post-meta">
							<p><?php _e( 'Categorized in ', 'flexmarket' ); ?><?php the_terms( $post->ID, 'product_category' , '<span class="label label-tag">' , '</span> <span class="label label-tag">' , '</span>' ); ?> <?php the_terms( $post->ID, 'product_tag' , '<span class="label label-tag">' , '</span> <span class="label label-tag">' , '</span>' ); ?> </p>
						</div>

						<div class="clear padding15"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / header-section -->	



		<div class="content-section"<?php echo ($contentbgcolor != '#' && !empty($contentbgcolor) ? ' style="background: '.$contentbgcolor.';"' : '') ?>>
			<div class="outercontainer">
				<div class="clear padding30"></div>	
				<div class="container">

					<div class="row-fluid">
						<div class="span8">

							<div id="post-<?php the_ID(); ?>"<?php echo ($contenttextcolor != '#' && !empty($contenttextcolor) ? ' style="color: '.$contenttextcolor.';"' : '') ?>>

								<?php mpt_load_top_code(); ?>	

									<?php if (has_post_thumbnail( $post->ID )) : ?>

											<?php
												$image1 = get_post_meta( $post->ID, '_mpt_video_featured_image_2', true );
												$image2 = get_post_meta( $post->ID, '_mpt_video_featured_image_3', true );

												$featured_args = array(
													'echo' => true,
													'post_id' => $post->ID,
													'prettyphoto' => true,
													'imagesize' => 'tb-360',
													'videoheight' => 195,
													'btnclass' => '',
													'iconclass' => '',
												);

												if (!empty($image1) || !empty($image2)) {
													mpt_load_image_carousel( $featured_args );
												} else {
													mpt_load_featured_image( $featured_args );
												}
													 
											?>

									<?php endif; ?>	

								<div class="clear padding25"></div>

								  	<div class="row-fluid">

								  		<div class="span3">
								  			<?php flexmarket_product_price(true , NULL , true , $tagcolor); ?>
								  		</div>

								  		<div class="span9 align-right">
								  			<?php flexmarket_buy_button(true, 'single' , NULL , $btnclass); ?>
								  			<?php echo ( function_exists('mp_pinit_button') ? '<div class="single-page-pinit-btn">' . mp_pinit_button( $post->ID ) . '</div>' : '' ); ?>
								  		</div>

								  	</div>

								<div class="clear"></div>

								<?php the_content(); ?>
								
								<?php edit_post_link( __('Edit this entry.' , 'flexmarket' ) , '<div class="clear padding20"></div><p>', '</p><div class="clear padding30"></div>'); ?>
								
								<?php echo ( function_exists('mp_related_products') ? '<div class="single-page-related-products">' . mp_related_products( $post->ID ) . '</div>' : '' ); ?>

								<?php 

									$showcomments = get_post_meta( $post->ID , '_mpt_post_show_comments', true );

									if ( $showcomments == 'on') {
										comments_template();
									} 
								?>

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