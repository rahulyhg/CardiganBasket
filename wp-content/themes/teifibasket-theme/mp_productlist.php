<?php // custom template for product list
get_header();
?>
<div id="content">
	<?php if ( class_exists( 'MarketPress' ) ) {
		?>
			<h1 class="post-title"><?php _e( 'Our products', 'framemarket' ) ?></h1>
		<!--	<?php echo mp_products_filter(); ?> -->
		<!-- MARK DAVIES - I've taken the product category filter out of single store pages for the time being. We are now using a network wide category hierachy where the admin creates/sets the categories. This affects the store category filter and would now show the network wide categories within each store..instead of showing only the categories that the store stocks..-->
			<div id="mp-product-grid">
				<?php framemarket_grid_mp_list_products();?>
				<div class="clear"></div>
			</div>
		<?php
	}
	?>
</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>