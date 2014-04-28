<?php get_header(); ?>

	<!-- Page -->
	<div id="page-wrapper">

		<div class="header-section">
			<div class="outercontainer">
				<div class="container">

					<div class="clear padding30"></div>		

					<?php
						global $wp_query;
						$termname = $wp_query->queried_object->name;
						$termslug = $wp_query->queried_object->slug;
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$showmpdg = get_option('mpt_mpdg_enable_dg');
						$entries = ( !empty($showmpdg) ? ( $showmpdg == 'true' ? get_option('mpt_mpdg_listing_entries') : get_option('mpt_mp_listing_entries')) : get_option('mpt_mp_listing_entries'));

						$moreargs = array(
							'showposts' => $entries,
							'orderby' => 'date',
							'order' => 'DESC',
							'paged' => $paged
						);

						$args = array_merge( $wp_query->query_vars, $moreargs );

						query_posts($args);
					?>		
							
					<?php if (have_posts()) : ?>		

					<?php $post = $posts[0]; ?>
							
						<h1 class="page-header"><span><?php _e('Items tagged with ', 'flexmarket'); ?>&#8216;<?php echo $termname; ?>&#8217;</span></h1>

					<div class="clear padding15"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / header-section -->	

		<div class="content-section">
			<div class="outercontainer">
				<div class="clear padding30"></div>	
				<div class="container" style="min-height: 450px;">			

							<?php if ( class_exists( 'MarketPress' ) ) { ?>

							<div id="mpt-product-grid">

								<?php do_action('flexmarket_tag_page' , $termslug , 'tag'); ?>

							</div>

							<?php } ?>

						<?php else : ?>

						<!-- nothing found -->

					<?php $post = $posts[0]; ?>
							
						<h1 class="page-header"><span><?php _e('Items tagged with ', 'flexmarket'); ?>&#8216;<?php echo $termname; ?>&#8217;</span></h1>

					<div class="clear padding15"></div>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / header-section -->	

		<div class="content-section">
			<div class="outercontainer">
				<div class="clear padding30"></div>	
				<div class="container" style="min-height: 450px;">

							<h2><?php _e('Nothing Found.'); ?></h2>

							<p><?php _e('Perhaps try one of the links below:'); ?></p>
							<div class="padding10"></div>
							<h4><?php _e('Most Used Categories'); ?></h4>
							<ul>
								<?php wp_list_categories( array( 'taxonomy' => 'product_category' , 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
							</ul>				
							<div class="padding20"></div>
							<p><?php _e('Or, use the search box below:'); ?></p>
							<?php get_search_form(); ?>
							<div class="padding20"></div>

						<!-- / nothing found -->

						<?php endif; ?>

				</div><!-- / container -->
			</div><!-- / outercontainer -->	
		</div><!-- / content-section -->	

	</div><!-- / page-wrapper -->

<?php get_template_part('footer', 'widget'); ?>

<?php get_footer(); ?>