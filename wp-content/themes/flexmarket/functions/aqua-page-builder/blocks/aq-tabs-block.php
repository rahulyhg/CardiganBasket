<?php
/* Aqua Tabs Block */
if(!class_exists('AQ_Tabs_Block')) {
	class AQ_Tabs_Block extends AQ_Block {
	
		function __construct() {
			$block_options = array(
				'name' => __('Tabs &amp; Toggles','pro'),
				'size' => 'span6',
			);
			
			//create the widget
			parent::__construct('AQ_Tabs_Block', $block_options);
			
			//add ajax functions
			add_action('wp_ajax_aq_block_tab_add_new', array($this, 'add_tab'));
			
		}
		
		function form($instance) {
		
			$defaults = array(
				'tabs' => array(
					1 => array(
						'title' => __('My New Tab','pro'),
						'content' => __('My tab contents','pro'),
					)
				),
				'type'	=> 'tab',
				'bgcolor' => '#ffffff',
				'textcolor' => '#676767',
			);
			
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			$tab_types = array(
				'tab' => __('Tabs','pro'),
				'toggle' => __('Toggles','pro'),
				'accordion' => __('Accordion','pro')
			);

			$bgcolor = isset($bgcolor) ? esc_attr($bgcolor) : '#ffffff';
			$textcolor = isset($textcolor) ? esc_attr($textcolor) : '#676767';

			do_action( $id_base . '_before_form' , $instance );
			
			?>
			<div class="description cf">
				<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
					$count = 1;
					foreach($tabs as $tab) {	
						$this->tab($tab, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="tab" class="aq-sortable-add-new button"><?php _e('Add New','pro'); ?></a>
				<p></p>
			</div>
			<div class="description third">
				<label for="<?php echo $this->get_field_id('type') ?>">
					<?php _e('Tabs style','pro'); ?><br/>
					<?php echo aq_field_select('type', $block_id, $tab_types, $type) ?>
				</label>
			</div>
			<div class="description third">
				<label for="<?php echo $this->get_field_id('bgcolor') ?>">
					<?php _e('Pick a background color','pro'); ?><br/>
					<?php echo aq_field_color_picker('bgcolor', $block_id, $bgcolor) ?>
				</label>
			</div>
			<div class="description third last">
				<label for="<?php echo $this->get_field_id('textcolor') ?>">
					<?php _e('Pick a text color','pro'); ?><br/>
					<?php echo aq_field_color_picker('textcolor', $block_id, $textcolor) ?>
				</label>
			</div>
			<?php

			do_action( $id_base . '_after_form' , $instance );
		}
		
		function tab($tab = array(), $count = 0) {
				
			?>
			<li id="<?php echo $this->get_field_id('tabs') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

				<?php do_action( 'aq_tabs_block_before_item_form' , $tab , $count ); ?>
				
				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo $tab['title'] ?></strong>
					</div>
					<div class="sortable-handle">
						<a href="#"><?php _e('Open / Close','pro'); ?></a>
					</div>
				</div>
				
				<div class="sortable-body">
					<p class="tab-desc description">
						<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title">
							<?php _e('Tab Title','pro'); ?><br/>
							<input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][title]" value="<?php echo $tab['title'] ?>" />
						</label>
					</p>
					<p class="tab-desc description">
						<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content">
							<?php _e('Tab Content','pro'); ?><br/>
							<textarea id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $tab['content'] ?></textarea>
						</label>
					</p>
					<p class="tab-desc description"><a href="#" class="sortable-delete"><?php _e('Delete','pro'); ?></a></p>
				</div>

				<?php do_action( 'aq_tabs_block_after_item_form' , $tab , $count ); ?>
				
			</li>
			<?php
		}
		
		function block($instance) {
			extract($instance);
			
			$output = '';
			
			if($type == 'tab') {
			
				$num = rand(1, 1000);
			
				$output .= '<div class="aq_block_tabs">';
					$output .= '<ul id="aq_block_tabs_'. $num .'" class="aq-nav cf">';
					
					$i = 1;
					foreach( $tabs as $tab ){
						$tab_selected = $i == 1 ? 'active' : '';
						$output .= '<li class="'.$tab_selected.'"><a href="#aq-tab-'. sanitize_title( $tab['title'] ) . $i .'" data-toggle="tab" style="background:'.esc_attr($bgcolor).'; color: '.esc_attr($textcolor).';">' . $tab['title'] . '</a></li>';
						$i++;
					}
					
					$output .= '</ul>';
					$output .= '<div id="aq_block_tabs_'. $num .'" class="tab-content">';
					
					$i = 1;
					foreach($tabs as $tab) {
						$tabs_active = $i == 1 ? ' active' : '';
						
						$output .= '<div id="aq-tab-'. sanitize_title( $tab['title'] ) . $i .'" class="aq-tab tab-pane fade in'.$tabs_active.'" style="background:'.esc_attr($bgcolor).'; color: '.esc_attr($textcolor).';">'. wpautop(do_shortcode(mpt_content_kses(htmlspecialchars_decode($tab['content'])))) .'</div>';
						
						$i++;
					}
				
				$output .= '</div></div>';
				$output .= '<script type="text/javascript">jQuery(document).ready(function () {jQuery("#aq_block_tabs_'. $num .'").tab();});</script>';
				
			} elseif ($type == 'toggle') {
				
				$output .= '<div class="aq_block_toggles_wrapper">';
				
				foreach( $tabs as $tab ){

					$num = rand(1, 1000);

					$output  .= '<div class="aq_block_toggle">';
						$output .= '<a href="#aq_block_toggles_'.$num.'" data-toggle="collapse">';
							$output .= '<h2 class="tab-head" style="background:'.esc_attr($bgcolor).'; color: '.esc_attr($textcolor).';">'. $tab['title'] .'</h2>';
							$output .= '<div class="arrow"></div>';
						$output .= '</a>';
						$output .= '<div id="aq_block_toggles_'.$num.'" class="collapse">';
							$output .= '<div class="tab-body" style="background:'.esc_attr($bgcolor).'; color: '.esc_attr($textcolor).'">';
								$output .= wpautop(do_shortcode(mpt_content_kses(htmlspecialchars_decode($tab['content']))));
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				}
				
				$output .= '</div>';
				
			} elseif ($type == 'accordion') {
				
				$num = rand(1, 1000);
				
				$count = count($tabs);
				$i = 1;
				
				$output .= '<div id="aq_block_accordion_wrapper_'.$num.'" class="aq_block_accordion_wrapper">';
				
				foreach( $tabs as $tab ){

					$tabnum = rand(1, 1000);
					
					$open = $i == 1 ? ' in' : '';
					
					$child = '';
					if($i == 1) $child = 'first-child';
					if($i == $count) $child = 'last-child';
					$i++;
					
					$output  .= '<div class="aq_block_accordion accordion-group">';
						$output .= '<a href="#aq_block_toggles_'.$tabnum.'" data-toggle="collapse" data-parent="#aq_block_accordion_wrapper_'.$num.'">';
						$output .= '<h2 class="tab-head" style="background:'.esc_attr($bgcolor).'; color: '.esc_attr($textcolor).';">'. $tab['title'] .'</h2>';
						$output .= '<div class="arrow"></div>';
						$output .= '</a>';
						$output .= '<div id="aq_block_toggles_'.$tabnum.'" class="collapse'.$open.' cf" style="background:'.esc_attr($bgcolor).'; color: '.esc_attr($textcolor).';">';
							$output .= '<div class="tab-body">';
								$output .= wpautop(do_shortcode(mpt_content_kses(htmlspecialchars_decode($tab['content']))));
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				}
				
				$output .= '</div>';
				
			}
			
			echo apply_filters( 'aq_tabs_block_output' , $output , $instance );
			
		}
		
		/* AJAX add tab */
		function add_tab() {
			$nonce = $_POST['security'];
			if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
			
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
			
			//default key/value for the tab
			$tab = array(
				'title' => __('New Tab','pro'),
				'content' => ''
			);
			
			if($count) {
				$this->tab($tab, $count);
			} else {
				die(-1);
			}
			
			die();
		}
		
		function update($new_instance, $old_instance) {
			$new_instance = aq_recursive_sanitize($new_instance);
			return $new_instance;
		}
	}
}
