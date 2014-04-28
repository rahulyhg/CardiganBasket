<?php
/** A simple text block **/
class AQ_Text_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => __('Text','pro'),
			'size' => 'span6',
		);
		
		//create the block
		parent::__construct('aq_text_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'text' => '',
			'heading' => 'h4',
			'id' => '',
			'class' => '',
			'style' => ''

		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$heading_style = array(
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		);

		do_action( $id_base . '_before_form' , $instance );
		
		?>
		<div class="description two-third">
			<label for="<?php echo $this->get_field_id('title') ?>">
				<?php _e('Title (optional)','pro'); ?>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>

		<div class="description third last">
			<label for="<?php echo $this->get_field_id('heading') ?>">
				<?php _e('Heading Type','pro'); ?><br/>
				<?php echo aq_field_select('heading', $block_id, $heading_style, $heading); ?>
			</label>
		</div>

		<div class="cf"></div>
		
		<div class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				<?php _e('Content','pro'); ?>
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
		</div>

		<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>

		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				<?php _e('id (optional)','pro'); ?><br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>

		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				<?php _e('class (optional)','pro'); ?><br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>

		<div class="cf"></div>

		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				<?php _e('Additional inline css styling (optional)','pro'); ?><br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>
		
		<?php

		do_action( $id_base . '_after_form' , $instance );
	}
	
	function block($instance) {
		extract($instance);

		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$class = (!empty($class) ? ' class="'.esc_attr($class).'"' : '');
		$style = (!empty($style) ? ' style="' . esc_attr($style).'"' : '');
		
		$output = '<div'.$id.$class.$style.'>';
		if($title) 
			$output .= '<'.$heading.' class="aq-block-title">'.strip_tags($title).'</'.$heading.'>';
		$output .= wpautop(do_shortcode(mpt_content_kses(htmlspecialchars_decode($text))));
		$output .= '</div>';

		echo apply_filters( 'aq_text_block_output' , $output , $instance );
	}
	
}