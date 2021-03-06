 		<?php include (get_template_directory() . '/buddypress/buddypress-globals.php'); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<?php if ( ! empty( $post->post_parent ) ) : ?>
					<?php if($bp_existed == 'true') : ?>
					<?php do_action( 'bp_before_blog_post' ) ?>
					<?php endif; ?>
					<p class="page-title"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( __( 'Return to %s', 'framemarket' ), get_the_title( $post->post_parent ) ) ); ?>" rel="gallery"><?php
						printf( __( '<span class="meta-nav">&larr;</span> %s', 'framemarket'), get_the_title( $post->post_parent ) );
					?></a></p>
				<?php endif; ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h2 class="post-title"><?php the_title(); ?></h2>
					<div class="post-meta">
						<?php
							printf( __( '<span class="%1$s">By</span> %2$s', 'framemarket' ),
								'meta-prep meta-prep-author',
								sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
									get_author_posts_url( get_the_author_meta( 'ID' ) ),
									sprintf( esc_attr__( 'View all posts by %s', 'framemarket'), get_the_author() ),
									get_the_author()
								)
							);
						?>
						<span class="meta-sep">|</span>
						<?php
							printf( __( '<span class="%1$s">Published</span> %2$s', 'framemarket'),
								'meta-prep meta-prep-entry-date',
								sprintf( '<span class="entry-date"><abbr class="published" title="%1$s">%2$s</abbr></span>',
									esc_attr( get_the_time() ),
									get_the_date()
								)
							);
							if ( wp_attachment_is_image() ) {
								echo ' <span class="meta-sep">|</span> ';
								$metadata = wp_get_attachment_metadata();
								printf( __( 'Full size is %s pixels', 'framemarket'),
									sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
										wp_get_attachment_url(),
										esc_attr( __( 'Link to full-size image', 'framemarket' ) ),
										$metadata['width'],
										$metadata['height']
									)
								);
							}
						?>
						<?php edit_post_link( __( 'Edit', 'framemarket'), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
					</div>

					<div class="post-content">
						<div class="entry-attachment">
<?php if ( wp_attachment_is_image() ) :
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		$next_attachment_url = wp_get_attachment_url();
	}
?>
						<p class="attachment"><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
							$attachment_width  = apply_filters( 'framemarket_attachment_size', 900 );
							$attachment_height = apply_filters( 'framemarket_attachment_height', 900 );
							echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) );
						?></a></p>

						<div id="navigation-bottom" class="navigation">
							<div class="nav-previous"><?php previous_image_link( false ); ?></div>
							<div class="nav-next"><?php next_image_link( false ); ?></div>
						</div>
<?php else : ?>
						<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
<?php endif; ?>
						</div>
						<div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>

<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'framemarket' ) ); ?>
<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'framemarket' ), 'after' => '</div>' ) ); ?>

					</div>

					<div class="post-info">
						<?php framemarket_postedin(); ?>
						<?php edit_post_link( __( 'Edit', 'framemarket'), ' <span class="edit-link">', '</span>' ); ?>
					</div>
					<?php if($bp_existed == 'true') : ?>
					<?php do_action( 'bp_after_blog_post' ) ?>
					<?php endif; ?>
				</div>
<?php comments_template(); ?>
<?php endwhile; ?>