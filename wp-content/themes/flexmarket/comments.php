<?php

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		This post is password protected. Enter the password to view comments.
	<?php
		return;
	}
?>

<?php if ( have_comments() ) : ?>
	
	<h4 class="page-header" id="comments"><?php comments_number('No Responses', 'One Response', '% Responses' );?></h4>

	<ul class="commentbox">
		<?php wp_list_comments(array(
			'style' => 'div',
			'avatar_size' => 64,
			)); ?>
	</ul>

	<div class="navigation">
		<div class="pull-left"><?php previous_comments_link() ?></div>
		<div class="pull-right"><?php next_comments_link() ?></div>
	</div>
	
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<p>Comments are closed.</p>

	<?php endif; ?>
	
<?php endif; ?>

<?php if ( comments_open() ) : ?>
<div class="clear padding20"></div>
<div id="respond">

	<h4 class="page-header"><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h4>

	<div class="pull-right">
		<?php cancel_comment_reply_link(); ?>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

		<?php if ( is_user_logged_in() ) : ?>

			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>

		<?php else : ?>

			<div>
				<label for="author">Name <?php if ($req) echo "(required)"; ?></label>
				<input class="span4" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
			</div>
			<div class="clear"></div>
			<div>
				<label for="email">Email Address(will not be published) <?php if ($req) echo "(required)"; ?></label>
				<input class="span4" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
			</div>
			<div class="clear"></div>
			<div>
				<label for="url">Website</label>
				<input class="span4" type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
			</div>

		<?php endif; ?>

		<div class="clear"></div>
		<div>
			<textarea class="span8" name="comment" id="comment" rows="10" tabindex="4" placeholder="Leave your comment here..." ></textarea>
		</div>

		<div>
			<input class="btn" name="submit" type="submit" id="submit" tabindex="5" value="Post Comment" />
			<?php comment_id_fields(); ?>
		</div>
		
		<?php do_action('comment_form', $post->ID); ?>

	</form>

	<?php endif; // If registration required and not logged in ?>
	
</div>

<?php endif; ?>