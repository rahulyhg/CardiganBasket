<?php
/** 
 * Builder Page
 *
 * @description Main admin UI settings page
 * @package Aqua Page Builder
 *
 */
 
// Debugging
if(isset($_POST) && $this->args['debug'] == true) {
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
}

// Permissions Check
if ( ! current_user_can('edit_theme_options') )
	wp_die( __( 'Cheatin&#8217; uh?' ) );
	
$messages = array();

// Get selected template id
$selected_template_id = isset($_REQUEST['template']) ? (int) $_REQUEST['template'] : 0;

// Actions
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'edit';
$template = isset($_REQUEST['template']) ? $_REQUEST['template'] : 0;

// DEBUG
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

// Template title & layout
$template_name = isset($_REQUEST['template-name']) && !empty($_REQUEST['template-name']) ? htmlspecialchars($_REQUEST['template-name']) : 'No Title';

// Get all templates
$templates = $this->get_templates();

// Get recently edited template
$recently_edited_template = (int) get_user_option( 'recently_edited_template' );

if( ! isset( $_REQUEST['template'] ) && $recently_edited_template && $this->is_template( $recently_edited_template )) {
	$selected_template_id = $recently_edited_template;
} elseif ( ! isset( $_REQUEST['template'] ) && $selected_template_id == 0 && !empty($templates)) {
	$selected_template_id = $templates[0]->ID;
}

//define selected template object
$selected_template_object = get_post($selected_template_id);

// saving action
switch($action) {

	case 'create' :
		
		$new_id = $this->create_template($template_name);
		
		if(!is_wp_error($new_id)) {
			$selected_template_id = $new_id;
		
			//refresh templates var
			$templates = $this->get_templates();
			$selected_template_object = get_post($selected_template_id);
			
			$messages[] = '<div id="message" class="updated"><p>' . __('The ', AQPB_TEXT_DOMAIN_SLUG ) . '<strong>' . $template_name . '</strong>' . __(' page template has been successfully created', AQPB_TEXT_DOMAIN_SLUG ) . '</p></div>';
		} else {
			$errors = '<ul>';
			foreach( $new_id->get_error_messages() as $error ) {
				$errors .= '<li><strong>'. $error . '</strong></li>';
			}
			$errors .= '</ul>';
			
			$messages[] = '<div id="message" class="error"><p>' . __('Sorry, the operation was unsuccessful for the following reason(s): ', AQPB_TEXT_DOMAIN_SLUG ) . '</p>' . $errors . '</div>';
		}
		
		break;
		
	case 'update' :
	
		$blocks = isset($_REQUEST['aq_blocks']) ? $_REQUEST['aq_blocks'] : '';
		
		$this->update_template($selected_template_id, $blocks, $template_name);
		
		//refresh templates var
		$templates = $this->get_templates();
		$selected_template_object = get_post($selected_template_id);
		
		$messages[] = '<div id="message" class="updated"><p>' . __('The ', AQPB_TEXT_DOMAIN_SLUG ) . '<strong>' . $template_name . '</strong>' . __(' page template has been updated', AQPB_TEXT_DOMAIN_SLUG ) . '</p></div>';
		break;
		
	case 'delete' :
		
		$this->delete_template($selected_template_id);
		
		//refresh templates var
		$templates = $this->get_templates();
		$selected_template_id =	!empty($templates) ? $templates[0]->ID : 0;
		$selected_template_object = get_post($selected_template_id);
		
		$messages[] = '<div id="message" class="updated"><p>' . __('The template has been successfully deleted', AQPB_TEXT_DOMAIN_SLUG ) . '</p></div>';
		break;
}

global $current_user;
update_user_option($current_user->ID, 'recently_edited_template', $selected_template_id);

//display admin notices & messages
if(!empty($messages)) foreach($messages as $message) { echo $message; }

//disable blocks archive if no template
$disabled = $selected_template_id === 0 ? 'metabox-holder-disabled' : '';

?>

<div class="wrap">
	<div id="icon-themes" class="icon32"><br/></div>
	<h2><?php echo $this->args['page_title'] ?></h2>

<!-- START custom template selector -->
	<div class="aqpb-template-selector-wrapper">
		<form action="<?php 
					echo esc_url( admin_url( 'themes.php' ) );
				?>" method="get">
		<?php
			if ( !empty( $templates ) ) {
				$new_templates = array();
				foreach ( (array) $templates as $template ) {
					$sanitizedtitle = sanitize_title($template->post_title);
					$new_templates[$sanitizedtitle] = array( 'title' => $template->post_title , 'id' => $template->ID );
				}
				echo '<input type="hidden" value="'.$this->args['page_slug'].'" name="page"></input>
						<input type="hidden" value="edit" name="action"></input>';
				echo '<label class="selected-menu" for="menu">'.__( 'Select a template to edit: ' , AQPB_TEXT_DOMAIN_SLUG  ).'</label>';
				echo '<select id="template" name="template">';
					echo '<option value="0"></option>';
				ksort( $new_templates );
				foreach ( (array) $new_templates as $new_template ) {
					echo '<option value="'.$new_template['id'] .'"'.( $selected_template_id == $new_template['id']  ? ' selected="selected"' : '' ).'>' . htmlspecialchars($new_template['title']) . '</option>';
				}
				echo '</select>';
				echo '<span class="submit-btn">';
					echo '<input class="button-secondary" type="submit" value="Select"></input>';
				echo '</span>';
			}

			echo '<span class="add-template-action">';
				echo __( ' or ' , AQPB_TEXT_DOMAIN_SLUG  );
				echo '<a href="' .
					esc_url(add_query_arg(
						array(
							'page' => $this->args['page_slug'], 
							'action' => 'edit',
							'template' => 0,
						),
						admin_url( 'themes.php' )
					)) . '">'.__( 'create a new template' , AQPB_TEXT_DOMAIN_SLUG  ).'</a>';
			echo '</span>';
		?>
		</form>
	</div>
<!-- END custom template selector -->
	
	<div id="page-builder-frame">
	
		<div id="page-builder-column" class="metabox-holder <?php echo $disabled ?>">
			<div id="page-builder-archive" class="postbox">
				<h3 class="hndle"><span><?php _e('Available Blocks', AQPB_TEXT_DOMAIN_SLUG ) ?></span><span id="removing-block"><?php _e('Deleting', AQPB_TEXT_DOMAIN_SLUG ) ?></span></h3>
				<div class="inside">
					<ul id="blocks-archive" class="cf">
						<?php $this->blocks_archive() ?>
					</ul>
					<p><?php _e('Need help? Use the Help tab in the upper right of your screen.', AQPB_TEXT_DOMAIN_SLUG ) ?></p>
				</div>
			</div>
		</div>
	
		<div id="page-builder-fixed">
			<div id="page-builder">

				<div class="aqpb-wrap aqpbdiv">
					<form id="update-page-template" action="<?php echo $this->args['page_url'] ?>" method="post" enctype="multipart/form-data">
						<div id="aqpb-header">
							
								<div id="submitpost" class="submitbox">
									<div class="major-publishing-actions cf">
									
										<label class="open-label" for="template-name">
											<span><?php _e('Template Name', AQPB_TEXT_DOMAIN_SLUG ) ?></span>
											<input name="template-name" id="template-name" type="text" class="template-name regular-text" title="Enter template name here" placeholder="Enter template name here" value="<?php echo is_object($selected_template_object) ? $selected_template_object->post_title : ''; ?>">
										</label>
										
										<div id="template-shortcode">
											<input type="text" readonly="readonly" value='[template id="<?php echo $selected_template_id ?>"]' onclick="select()"/>
										</div>
										
										<div class="publishing-action">
<!-- START Custom Stuff - preset template -->
											<div class="preset-template-select">	
												<?php 
													global $aqpb_customclass;
													if ( empty( $selected_template_id ) )
														echo $aqpb_customclass->select_preset_template_html();
												?>
											</div>
<!-- END Custom Stuff - preset template -->
											<?php submit_button( empty( $selected_template_id ) ? __( 'Create Template', AQPB_TEXT_DOMAIN_SLUG  ) : __( 'Save Template', AQPB_TEXT_DOMAIN_SLUG  ), 'button-primary ', 'save_template', false, array( 'id' => 'save_template_header' ) ); ?>
										</div><!-- END .publishing-action -->
										
										<?php if(!empty($selected_template_id)) { ?>
										<div class="delete-action">
<!-- START Custom Stuff - duplicate template -->
											<?php 
											echo '<a class="submitduplicate template-duplicate" href="' . esc_url(add_query_arg(
												array(
													'action' => 'customclass_duplicate_aqpb_template',
													'template' => $selected_template_id,
													'_wpnonce' => wp_create_nonce('duplicate-template')
												),
												admin_url( 'admin.php' )
											)) . '">'. __('Duplicate Template', AQPB_TEXT_DOMAIN_SLUG ) .'</a>';
											?>
<!-- END Custom Stuff - duplicate template -->
											<?php 
											echo '<a class="submitdelete deletion template-delete" href="' . esc_url(add_query_arg(
												array(
													'page' => $this->args['page_slug'], 
													'action' => 'delete',
													'template' => $selected_template_id,
													'_wpnonce' => wp_create_nonce('delete-template'),
												),
												admin_url( 'themes.php' )
											)) . '">'. __('Delete Template', AQPB_TEXT_DOMAIN_SLUG ) .'</a>';
											?>
										</div><!-- END .delete-action -->
										<?php } ?>
										
									</div><!-- END .major-publishing-actions -->
								</div><!-- END #submitpost .submitbox -->
								
								<?php 
								if($selected_template_id === 0) {
									wp_nonce_field( 'create-template', 'create-template-nonce' ); 
								} else {
									wp_nonce_field( 'update-template', 'update-template-nonce' );
								}
								?>	
								<input type="hidden" name="action" value="<?php echo empty( $selected_template_id ) ? 'create' : 'update' ?>"/>
								<input type="hidden" name="template" id="template" value="<?php echo $selected_template_id ?>"/>
								<input type="hidden" id="aqpb-nonce" name="aqpb-nonce" value="<?php echo wp_create_nonce('aqpb-settings-page-nonce') ?>"/>
							
						</div>
						
						<div id="aqpb-body">
							
							<ul class="blocks cf" id="blocks-to-edit">
								<?php 
								if($selected_template_id === 0) {
									echo '<p class="empty-template">';
									echo __('To create a custom page template, give it a name above and click Create Template. Then choose blocks like text, widgets or tabs &amp; toggles from the left column to add to this template.
									<br/><br/>
									You can drag and drop the blocks to put them in the order you want. Click on the small arrow at the corner of each block to reveal additional configuration options. You can also resize each block by clicking on either side of the block (Note that some blocks are not resizable)
									<br/><br/>
									When you have finished building your custom page template, make sure you click the Save Template button.', AQPB_TEXT_DOMAIN_SLUG );
									echo '</p>';
									
									
								} else {
									$this->display_blocks($selected_template_id); 
								}
								?>
							</ul>
							
						</div>
						
						<div id="aqpb-footer">
							<div class="major-publishing-actions cf">
								<div class="publishing-action">
									<?php if(!empty($selected_template_id)) {
										submit_button( __( 'Save Template' ), 'button-primary ', 'save_template', false, array( 'id' => 'save_template_footer' ) ); 
									} ?>
								</div><!-- END .publishing-action -->
							</div><!-- END .major-publishing-actions -->
						</div>
						
					</div>
				</form>
			</div>
			<p style="float:left"><small>Aqua Page Builder &copy; 2012 by <a href="http://aquagraphite.com">Syamil MJ</a></small></p>
			<p style="float:right"><small>Version <?php echo AQPB_VERSION ?></small></p>
			
		</div>
		
		
	</div>
</div>