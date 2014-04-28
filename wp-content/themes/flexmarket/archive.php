<?php get_header(); ?>

	<!-- Page -->
	<div id="page-wrapper">

		<div class="header-section">
			<div class="outercontainer">
				<div class="container">

					<div class="clear padding30"></div>					
							
						<?php /* If this is a category archive */ if (is_category()) { ?>
							<h2 class="page-header"><span><?php _e( 'Archive for the ' , 'flexmarket' ); ?>&#8216;<?php single_cat_title(); ?>&#8217;<?php _e( ' Category' , 'flexmarket' ); ?></span></h2>

						<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
							<h2 class="page-header"><span><?php _e( 'Posts Tagged ' , 'flexmarket' ); ?>&#8216;<?php single_tag_title(); ?>&#8217;</span></h2>

						<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
							<h2 class="page-header"><span><?php _e( 'Archive for ' , 'flexmarket' ); ?><?php the_time('F jS, Y'); ?></span></h2>

						<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
							<h2 class="page-header"><span><?php _e( 'Archive for ' , 'flexmarket' ); ?><?php the_time('F, Y'); ?></span></h2>

						<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
							<h2 class="page-header"><span><?php _e( 'Archive for ' , 'flexmarket' ); ?><?php the_time('Y'); ?></span></h2>

						<?php /* If this is an author archive */ } elseif (is_author()) { ?>
							<h2 class="page-header"><span><?php _e( 'Author Archive' , 'flexmarket' ); ?></span></h2>

						<?php /* If this is a paged archive */ } elseif ( isset($wp_query->query_vars['paged']) && !empty($wp_query->query_vars['paged']) ) { ?>
							<h2 class="page-header"><span><?php _e( 'Blog Archives' , 'flexmarket' ); ?></span></h2>
						
						<?php } ?>
						
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
								$category = is_category() ? get_query_var('cat') : '';
								$tag = is_tag() ? get_query_var('tag') : '';
								$author = is_author() ? get_query_var('author_name') : '';
								$day = is_day() ? get_query_var('day') : '';
								$month = is_month() ? get_query_var('monthnum') : '';
								$year = is_year() ? get_query_var('year') : '';

								$args = array(
									'searchterms' => esc_attr( $searchterms ),
									'category' => esc_attr( $category ), 
									'tag' => esc_attr( $tag ),
									'author' => esc_attr( $author ),
									'day' => esc_attr( $day ),
									'month' => esc_attr( $month ),
									'year' => esc_attr( $year )
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