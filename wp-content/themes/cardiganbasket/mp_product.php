<?php // custom template for product single view
get_header();
?>
	<div id="content">
					<h1 class="post-title"><?php the_title(); ?></h1>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				
				<div class="product-photo">
				<?php $your_custom_field = get_post_meta( get_the_ID(), 'ct_Locally_Ma_checkbox_5706', true);
									if ( $your_custom_field == 'Yes' ) {
									echo '<img src=/wp-content/themes/framemarket/images/locally_made_icon.png width=172px; height=172px; style="position: absolute; z-index:5000" />';
									} 
								?>
				<?php mp_product_image(true, 'single', null); ?>
				
				</div>
				
					<div class="product-details">
				<div class="content-box">
					<?php the_content(); ?>
				</div>
				<?php echo framemarket_product_meta(); ?>
				<?php
				    $options = get_option('framemarket_theme_options');
				    if($options['show_related_product'] == 'yes') echo mp_related_products();
				?>
			</div>
				<?php endwhile; else: ?>
					<p><?php _e( 'Sorry, no posts matched your criteria.', 'framemarket' ) ?></p>
				<?php endif; ?>
		<?php comments_template( '', true ); ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer() ?>