<?php
/** Notifications block **/

if(!class_exists('AQ_Alert_Block')) {
	class AQ_Alert_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => __('Alerts','pro'),
				'size' => 'span6',
			);
			
			//create the block
			parent::__construct('aq_alert_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'title' => '',
				'content' => '',
				'type' => 'note',
				'style' => ''
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			$type_options = array(
				'default' => __('Standard','pro'),
				'info' => __('Info','pro'),
				'note' => __('Notification','pro'),
				'warn' => __('Warning','pro'),
				'tips' => __('Tips','pro')
			);

			do_action( $id_base . '_before_form' , $instance );
			
			?>
			
			<div class="description">
				<label for="<?php echo $this->get_field_id('title') ?>">
					<?php _e('Title (optional)','pro'); ?><br/>
					<?php echo aq_field_input('title', $block_id, $title) ?>
				</label>
			</div>
			<div class="description">
				<label for="<?php echo $this->get_field_id('content') ?>">
					<?php _e('Alert Text (required)','pro'); ?><br/>
					<?php echo aq_field_textarea('content', $block_id, $content) ?>
				</label>
			</div>
			<div class="description half">
				<label for="<?php echo $this->get_field_id('type') ?>">
					<?php _e('Alert Type','pro'); ?><br/>
					<?php echo aq_field_select('type', $block_id, $type_options, $type) ?>
				</label>
			</div>

			<?php do_action( $id_base . '_before_advance_settings' , $instance ); ?>
			
			<div class="description half last">
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

			$style = (!empty($style) ? ' style="' . esc_attr($style).'"' : '');

			$output = '<div class="aq_alert '.$type.' cf"'. $style .'>';
				if($title) 
					$output .= '<p class="aq-alert-title">'.strip_tags($title).'</p>';
				$output .= do_shortcode(mpt_content_kses(htmlspecialchars_decode($content)));
			$output .= '</div>';

			echo apply_filters( 'aq_alert_block_output' , $output , $instance );			
		}
		
	}
}