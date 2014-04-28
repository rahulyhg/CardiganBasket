<?php 

	if ( !class_exists( 'AQ_Page_Builder_CustomClass' ) ) {

		class AQ_Page_Builder_CustomClass {

		    private $theme_path;
		    private $theme_url;
		    private $theme_slug;
		    private $filter_hook_prefix;

		    function __construct() 
		    {
		        $this->theme_path = get_template_directory();
		        $this->theme_url = get_template_directory_uri();
		        $this->theme_slug = 'flexmarket';
		        $this->filter_hook_prefix = 'flexmarket_pb_custom_func_';
		        $this->preset_templates = apply_filters( 'aqpb_preset_templates_file_location' , $this->theme_path. '/functions/page-builder-preset-templates.php' );

		    	// register CSS & JS
		    	add_action('aq-page-builder-admin-enqueue', array(&$this, 'register_admin_css_style') , 999 );
		    	add_action('wp_enqueue_scripts', array(&$this, 'register_js') , 999 );

				// Duplicate function
		    	add_action( 'admin_action_customclass_duplicate_aqpb_template', array(&$this, 'duplicate_template' ) , 15 );

				// preset template functions
		    	add_action( 'aqpb_create_template_hook', array(&$this, 'create_preset_template' ) , 15 );
		    	
		    	
		    	$this->init();
		    }

			/* Custom CSS & JS
			------------------------------------------------------------------------------------------------------------------- */

		    function register_admin_css_style() {
				wp_enqueue_style('aqpb-custom-admin-css', get_template_directory_uri() . '/css/page-builder-admin.css', null, null);
		    }

		    function register_js() {
		    	wp_dequeue_script('aqpb-view-js');
		    }

			/* Init functions
			------------------------------------------------------------------------------------------------------------------- */

			function init() {

				/* Unregister default blocks
				------------------------------------------------------------------------------------------------------------------- */
				aq_unregister_block('AQ_Text_Block');
				aq_unregister_block('AQ_Column_Block');
				aq_unregister_block('AQ_Clear_Block');
				aq_unregister_block('AQ_Widgets_Block');
				aq_unregister_block('AQ_Alert_Block');
				aq_unregister_block('AQ_Tabs_Block');

				/* Register Blocks
				------------------------------------------------------------------------------------------------------------------- */
				aq_register_block('AQ_Text_Block');
				aq_register_block('AQ_Heading_Block');
				aq_register_block('AQ_Separator_Block');
				aq_register_block('AQ_Button_Block');
				aq_register_block('AQ_Image_Block');
				aq_register_block('AQ_Video_Block');
				aq_register_block('AQ_Column_Block');
				aq_register_block('AQ_Well_Block');
				aq_register_block('AQ_List_Block');
				aq_register_block('AQ_Table_Block');
				aq_register_block('AQ_CTA_Block');
				aq_register_block('AQ_Alert_Block');
				aq_register_block('AQ_Tabs_Block');
				aq_register_block('AQ_Progress_Block');
				aq_register_block('AQ_Features_Block');
				aq_register_block('AQ_Staff_Block');
				aq_register_block('AQ_Pricing_Block');
				aq_register_block('AQ_Blog_Updates_Block');
				aq_register_block('AQ_Map_Block');
				aq_register_block('AQ_Contact_Block');
				aq_register_block('AQ_Testimonials_Block');
				aq_register_block('AQ_Slider_Block');
				aq_register_block('AQ_Widgets_Block');	
				aq_register_block('AQ_Shortcode_Block');
				if ( class_exists('MarketPress') ) {
					aq_register_block('AQ_MP_Product_Grid_Block');
					aq_register_block('AQ_MP_Product_Carousel_Block');
					aq_register_block('AQ_MPcart_Block');
				}

			}

			/* Duplicate template function
			 * reference: http://rudrastyh.com/wordpress/duplicate-post.html
			------------------------------------------------------------------------------------------------------------------- */

			function duplicate_template() {

				global $wpdb;

				if (! ( isset( $_GET['template']) || isset( $_POST['template'])  || ( isset($_REQUEST['action']) && 'customclass_duplicate_aqpb_template' == $_REQUEST['action'] && check_admin_referer( 'duplicate-template', '_wpnonce' ) ) ) ) {
					wp_die( __( 'No template to duplicate has been supplied!' , $this->theme_slug ) );
				}

				$template_id = ( isset($_GET['template']) ? intval($_GET['template']) : intval($_POST['template']) );
				$template = get_post( $template_id );

				$current_user = wp_get_current_user();
				$new_template_author = $current_user->ID;

				if ( isset( $template ) && $template != null ) {

					$new_template_args = array(
						'comment_status' => $template->comment_status,
						'ping_status'    => $template->ping_status,
						'post_author'    => $new_template_author,
						'post_parent'    => $template->post_parent,
						'post_status'    => 'publish',
						'post_title'     => $template->post_title . ' (copy)',
						'post_type'      => $template->post_type,
						'menu_order'     => $template->menu_order
					);

					$new_template_id = wp_insert_post( $new_template_args );

					$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$template_id");
					if ( count($post_meta_infos)!=0 ) {
						$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
						foreach ($post_meta_infos as $meta_info) {
							$meta_key = $meta_info->meta_key;
							$meta_value = addslashes($meta_info->meta_value);
							$sql_query_sel[]= "SELECT $new_template_id, '$meta_key', '$meta_value'";
						}
						$sql_query.= implode(" UNION ALL ", $sql_query_sel);
						$wpdb->query($sql_query);
					}

					wp_redirect( admin_url( 'themes.php?page=aq-page-builder&action=edit&template=' . $new_template_id ) );
					exit;

				} else {
					wp_die( __( 'Template creation failed, could not find original post: ' . $template_id , $this->theme_slug ) );
				}

			}

			/* Retrieve meta info from template
			------------------------------------------------------------------------------------------------------------------- */

			function retrieve_meta_info( $template_id = NULL , $unserialize = false ) {

				global $id;
				$template_id = ( NULL === $template_id ) ? $id : $template_id;

				$meta_value = get_post_meta( $template_id );

				$output = '';

				if ( !empty($meta_value) ) {
					foreach ($meta_value as $key => $value) {
						if ( $unserialize ) {
							$output .= $key . ' = ' . print_r( $value , true ) . '<br /><br />';
						} else {
							$meta = get_post_meta( $template_id , $key , true );
							$output .= $key . ' = ' . print_r( $meta , true ) . '<br />';
						}
					}
				}

				return $output;

			}

			/* Preset Template
			------------------------------------------------------------------------------------------------------------------- */

			function select_preset_template_html() {

				require_once( $this->preset_templates );

				$output = '';

				if ( !empty($preset_templates) ) {
					$output .= '<label for="preset_template">'.__( 'Preset Template:', $this->theme_slug ).'</label>';
					$output .= '<select id="preset_template" name="preset_template">';
						$output .= '<option value="">' . __( 'None' , $this->theme_slug ) . '</option>';
						foreach ($preset_templates as $template_slug => $template_data ) {
							$output .= '<option value="'.$template_slug.'">' . $template_data['name'] . '</option>';
						}
						
					$output .= '</select>';
				}

				return apply_filters( $this->filter_hook_prefix . 'select_preset_template_html' , $output );
			}

			function create_preset_template( $args = array() ) {

				$defaults = array(
					'template_id' => NULL,
					'selected_template' =>  NULL,
				);

				$instance = wp_parse_args( $args, $defaults );
				extract( $instance );

				require_once( $this->preset_templates );
				
				if ( !empty($template_id) && !empty($selected_template) && !empty($preset_templates) ) {

					foreach ($preset_templates as $template_slug => $template_data ) {

						if ( $selected_template == $template_slug && !empty($template_data['contents']) ) {

							foreach ($template_data['contents'] as $meta_key => $meta_value) {
								add_post_meta( $template_id, $meta_key, $meta_value );
							} // end foreach

						} // end ifelse

					} // end - foreach

				} // end ifelse
				
			}

			/* Icon list
			------------------------------------------------------------------------------------------------------------------- */

			function load_awesome_icon_list() {

		    	$awesome_fonts = array(
					'none' => 'none',
					'icon-adjust' => 'icon-adjust',
					'icon-adn' => 'icon-adn',
					'icon-align-center' => 'icon-align-center',
					'icon-align-justify' => 'icon-align-justify',
					'icon-align-left' => 'icon-align-left',
					'icon-align-right' => 'icon-align-right',
					'icon-ambulance' => 'icon-ambulance',
					'icon-anchor' => 'icon-anchor',
					'icon-android' => 'icon-android',
					'icon-angle-down' => 'icon-angle-down',
					'icon-angle-left' => 'icon-angle-left',
					'icon-angle-right' => 'icon-angle-right',
					'icon-angle-up' => 'icon-angle-up',
					'icon-apple' => 'icon-apple',
					'icon-archive' => 'icon-archive',
					'icon-arrow-down' => 'icon-arrow-down',
					'icon-arrow-left' => 'icon-arrow-left',
					'icon-arrow-right' => 'icon-arrow-right',
					'icon-arrow-up' => 'icon-arrow-up',
					'icon-asterisk' => 'icon-asterisk',
					'icon-backward' => 'icon-backward',
					'icon-ban-circle' => 'icon-ban-circle',
					'icon-bar-chart' => 'icon-bar-chart',
					'icon-barcode' => 'icon-barcode',
					'icon-beaker' => 'icon-beaker',
					'icon-beer' => 'icon-beer',
					'icon-bell' => 'icon-bell',
					'icon-bell-alt' => 'icon-bell-alt',
					'icon-bitbucket' => 'icon-bitbucket',
					'icon-bitbucket-sign' => 'icon-bitbucket-sign',
					'icon-bold' => 'icon-bold',
					'icon-bolt' => 'icon-bolt',
					'icon-book' => 'icon-book',
					'icon-bookmark' => 'icon-bookmark',
					'icon-bookmark-empty' => 'icon-bookmark-empty',
					'icon-briefcase' => 'icon-briefcase',
					'icon-btc' => 'icon-btc',
					'icon-bug' => 'icon-bug',
					'icon-building' => 'icon-building',
					'icon-bullhorn' => 'icon-bullhorn',
					'icon-bullseye' => 'icon-bullseye',
					'icon-calendar' => 'icon-calendar',
					'icon-calendar-empty' => 'icon-calendar-empty',
					'icon-camera' => 'icon-camera',
					'icon-camera-retro' => 'icon-camera-retro',
					'icon-caret-down' => 'icon-caret-down',
					'icon-caret-left' => 'icon-caret-left',
					'icon-caret-right' => 'icon-caret-right',
					'icon-caret-up' => 'icon-caret-up',
					'icon-certificate' => 'icon-certificate',
					'icon-check' => 'icon-check',
					'icon-check-empty' => 'icon-check-empty',
					'icon-check-minus' => 'icon-check-minus',
					'icon-check-sign' => 'icon-check-sign',
					'icon-chevron-down' => 'icon-chevron-down',
					'icon-chevron-left' => 'icon-chevron-left',
					'icon-chevron-right' => 'icon-chevron-right',
					'icon-chevron-sign-down' => 'icon-chevron-sign-down',
					'icon-chevron-sign-left' => 'icon-chevron-sign-left',
					'icon-chevron-sign-right' => 'icon-chevron-sign-right',
					'icon-chevron-sign-up' => 'icon-chevron-sign-up',
					'icon-chevron-up' => 'icon-chevron-up',
					'icon-circle' => 'icon-circle',
					'icon-circle-arrow-down' => 'icon-circle-arrow-down',
					'icon-circle-arrow-left' => 'icon-circle-arrow-left',
					'icon-circle-arrow-right' => 'icon-circle-arrow-right',
					'icon-circle-arrow-up' => 'icon-circle-arrow-up',
					'icon-circle-blank' => 'icon-circle-blank',
					'icon-cloud' => 'icon-cloud',
					'icon-cloud-download' => 'icon-cloud-download',
					'icon-cloud-upload' => 'icon-cloud-upload',
					'icon-cny' => 'icon-cny',
					'icon-code' => 'icon-code',
					'icon-code-fork' => 'icon-code-fork',
					'icon-coffee' => 'icon-coffee',
					'icon-cog' => 'icon-cog',
					'icon-cogs' => 'icon-cogs',
					'icon-collapse' => 'icon-collapse',
					'icon-collapse-alt' => 'icon-collapse-alt',
					'icon-collapse-top' => 'icon-collapse-top',
					'icon-columns' => 'icon-columns',
					'icon-comment' => 'icon-comment',
					'icon-comment-alt' => 'icon-comment-alt',
					'icon-comments' => 'icon-comments',
					'icon-comments-alt' => 'icon-comments-alt',
					'icon-compass' => 'icon-compass',
					'icon-copy' => 'icon-copy',
					'icon-credit-card' => 'icon-credit-card',
					'icon-crop' => 'icon-crop',
					'icon-css3' => 'icon-css3',
					'icon-cut' => 'icon-cut',
					'icon-dashboard' => 'icon-dashboard',
					'icon-desktop' => 'icon-desktop',
					'icon-double-angle-down' => 'icon-double-angle-down',
					'icon-double-angle-left' => 'icon-double-angle-left',
					'icon-double-angle-right' => 'icon-double-angle-right',
					'icon-double-angle-up' => 'icon-double-angle-up',
					'icon-download' => 'icon-download',
					'icon-download-alt' => 'icon-download-alt',
					'icon-dribbble' => 'icon-dribbble',
					'icon-dropbox' => 'icon-dropbox',
					'icon-edit' => 'icon-edit',
					'icon-edit-sign' => 'icon-edit-sign',
					'icon-eject' => 'icon-eject',
					'icon-ellipsis-horizontal' => 'icon-ellipsis-horizontal',
					'icon-ellipsis-vertical' => 'icon-ellipsis-vertical',
					'icon-envelope' => 'icon-envelope',
					'icon-envelope-alt' => 'icon-envelope-alt',
					'icon-eraser' => 'icon-eraser',
					'icon-eur' => 'icon-eur',
					'icon-exchange' => 'icon-exchange',
					'icon-exclamation' => 'icon-exclamation',
					'icon-exclamation-sign' => 'icon-exclamation-sign',
					'icon-expand' => 'icon-expand',
					'icon-expand-alt' => 'icon-expand-alt',
					'icon-external-link' => 'icon-external-link',
					'icon-external-link-sign' => 'icon-external-link-sign',
					'icon-eye-close' => 'icon-eye-close',
					'icon-eye-open' => 'icon-eye-open',
					'icon-facebook' => 'icon-facebook',
					'icon-facebook-sign' => 'icon-facebook-sign',
					'icon-facetime-video' => 'icon-facetime-video',
					'icon-fast-backward' => 'icon-fast-backward',
					'icon-fast-forward' => 'icon-fast-forward',
					'icon-female' => 'icon-female',
					'icon-fighter-jet' => 'icon-fighter-jet',
					'icon-file' => 'icon-file',
					'icon-file-alt' => 'icon-file-alt',
					'icon-file-text' => 'icon-file-text',
					'icon-file-text-alt' => 'icon-file-text-alt',
					'icon-film' => 'icon-film',
					'icon-filter' => 'icon-filter',
					'icon-fire' => 'icon-fire',
					'icon-fire-extinguisher' => 'icon-fire-extinguisher',
					'icon-flag' => 'icon-flag',
					'icon-flag-alt' => 'icon-flag-alt',
					'icon-flag-checkered' => 'icon-flag-checkered',
					'icon-flickr' => 'icon-flickr',
					'icon-folder-close' => 'icon-folder-close',
					'icon-folder-close-alt' => 'icon-folder-close-alt',
					'icon-folder-open' => 'icon-folder-open',
					'icon-folder-open-alt' => 'icon-folder-open-alt',
					'icon-font' => 'icon-font',
					'icon-food' => 'icon-food',
					'icon-forward' => 'icon-forward',
					'icon-foursquare' => 'icon-foursquare',
					'icon-frown' => 'icon-frown',
					'icon-fullscreen' => 'icon-fullscreen',
					'icon-gamepad' => 'icon-gamepad',
					'icon-gbp' => 'icon-gbp',
					'icon-gift' => 'icon-gift',
					'icon-github' => 'icon-github',
					'icon-github-alt' => 'icon-github-alt',
					'icon-github-sign' => 'icon-github-sign',
					'icon-gittip' => 'icon-gittip',
					'icon-glass' => 'icon-glass',
					'icon-globe' => 'icon-globe',
					'icon-google-plus' => 'icon-google-plus',
					'icon-google-plus-sign' => 'icon-google-plus-sign',
					'icon-group' => 'icon-group',
					'icon-hand-down' => 'icon-hand-down',
					'icon-hand-left' => 'icon-hand-left',
					'icon-hand-right' => 'icon-hand-right',
					'icon-hand-up' => 'icon-hand-up',
					'icon-hdd' => 'icon-hdd',
					'icon-headphones' => 'icon-headphones',
					'icon-heart' => 'icon-heart',
					'icon-heart-empty' => 'icon-heart-empty',
					'icon-home' => 'icon-home',
					'icon-hospital' => 'icon-hospital',
					'icon-h-sign' => 'icon-h-sign',
					'icon-html5' => 'icon-html5',
					'icon-inbox' => 'icon-inbox',
					'icon-indent-left' => 'icon-indent-left',
					'icon-indent-right' => 'icon-indent-right',
					'icon-info' => 'icon-info',
					'icon-info-sign' => 'icon-info-sign',
					'icon-inr' => 'icon-inr',
					'icon-instagram' => 'icon-instagram',
					'icon-italic' => 'icon-italic',
					'icon-jpy' => 'icon-jpy',
					'icon-key' => 'icon-key',
					'icon-keyboard' => 'icon-keyboard',
					'icon-krw' => 'icon-krw',
					'icon-laptop' => 'icon-laptop',
					'icon-leaf' => 'icon-leaf',
					'icon-legal' => 'icon-legal',
					'icon-lemon' => 'icon-lemon',
					'icon-level-down' => 'icon-level-down',
					'icon-level-up' => 'icon-level-up',
					'icon-lightbulb' => 'icon-lightbulb',
					'icon-link' => 'icon-link',
					'icon-linkedin' => 'icon-linkedin',
					'icon-linkedin-sign' => 'icon-linkedin-sign',
					'icon-linux' => 'icon-linux',
					'icon-list' => 'icon-list',
					'icon-list-alt' => 'icon-list-alt',
					'icon-list-ol' => 'icon-list-ol',
					'icon-list-ul' => 'icon-list-ul',
					'icon-location-arrow' => 'icon-location-arrow',
					'icon-lock' => 'icon-lock',
					'icon-long-arrow-down' => 'icon-long-arrow-down',
					'icon-long-arrow-left' => 'icon-long-arrow-left',
					'icon-long-arrow-right' => 'icon-long-arrow-right',
					'icon-long-arrow-up' => 'icon-long-arrow-up',
					'icon-magic' => 'icon-magic',
					'icon-magnet' => 'icon-magnet',
					'icon-mail-reply-all' => 'icon-mail-reply-all',
					'icon-male' => 'icon-male',
					'icon-map-marker' => 'icon-map-marker',
					'icon-maxcdn' => 'icon-maxcdn',
					'icon-medkit' => 'icon-medkit',
					'icon-meh' => 'icon-meh',
					'icon-microphone' => 'icon-microphone',
					'icon-microphone-off' => 'icon-microphone-off',
					'icon-minus' => 'icon-minus',
					'icon-minus-sign' => 'icon-minus-sign',
					'icon-minus-sign-alt' => 'icon-minus-sign-alt',
					'icon-mobile-phone' => 'icon-mobile-phone',
					'icon-money' => 'icon-money',
					'icon-moon' => 'icon-moon',
					'icon-move' => 'icon-move',
					'icon-music' => 'icon-music',
					'icon-off' => 'icon-off',
					'icon-ok' => 'icon-ok',
					'icon-ok-circle' => 'icon-ok-circle',
					'icon-ok-sign' => 'icon-ok-sign',
					'icon-paper-clip' => 'icon-paper-clip',
					'icon-paste' => 'icon-paste',
					'icon-pause' => 'icon-pause',
					'icon-pencil' => 'icon-pencil',
					'icon-phone' => 'icon-phone',
					'icon-phone-sign' => 'icon-phone-sign',
					'icon-picture' => 'icon-picture',
					'icon-pinterest' => 'icon-pinterest',
					'icon-pinterest-sign' => 'icon-pinterest-sign',
					'icon-plane' => 'icon-plane',
					'icon-play' => 'icon-play',
					'icon-play-circle' => 'icon-play-circle',
					'icon-play-sign' => 'icon-play-sign',
					'icon-plus' => 'icon-plus',
					'icon-plus-sign' => 'icon-plus-sign',
					'icon-plus-sign-alt' => 'icon-plus-sign-alt',
					'icon-print' => 'icon-print',
					'icon-pushpin' => 'icon-pushpin',
					'icon-puzzle-piece' => 'icon-puzzle-piece',
					'icon-qrcode' => 'icon-qrcode',
					'icon-question' => 'icon-question',
					'icon-question-sign' => 'icon-question-sign',
					'icon-quote-left' => 'icon-quote-left',
					'icon-quote-right' => 'icon-quote-right',
					'icon-random' => 'icon-random',
					'icon-refresh' => 'icon-refresh',
					'icon-remove' => 'icon-remove',
					'icon-remove-circle' => 'icon-remove-circle',
					'icon-remove-sign' => 'icon-remove-sign',
					'icon-renren' => 'icon-renren',
					'icon-reorder' => 'icon-reorder',
					'icon-repeat' => 'icon-repeat',
					'icon-reply' => 'icon-reply',
					'icon-reply-all' => 'icon-reply-all',
					'icon-resize-full' => 'icon-resize-full',
					'icon-resize-horizontal' => 'icon-resize-horizontal',
					'icon-resize-small' => 'icon-resize-small',
					'icon-resize-vertical' => 'icon-resize-vertical',
					'icon-retweet' => 'icon-retweet',
					'icon-road' => 'icon-road',
					'icon-rocket' => 'icon-rocket',
					'icon-rss' => 'icon-rss',
					'icon-rss-sign' => 'icon-rss-sign',
					'icon-save' => 'icon-save',
					'icon-screenshot' => 'icon-screenshot',
					'icon-search' => 'icon-search',
					'icon-share' => 'icon-share',
					'icon-share-alt' => 'icon-share-alt',
					'icon-share-sign' => 'icon-share-sign',
					'icon-shield' => 'icon-shield',
					'icon-shopping-cart' => 'icon-shopping-cart',
					'icon-signal' => 'icon-signal',
					'icon-sign-blank' => 'icon-sign-blank',
					'icon-signin' => 'icon-signin',
					'icon-signout' => 'icon-signout',
					'icon-sitemap' => 'icon-sitemap',
					'icon-skype' => 'icon-skype',
					'icon-smile' => 'icon-smile',
					'icon-sort' => 'icon-sort',
					'icon-sort-by-alphabet' => 'icon-sort-by-alphabet',
					'icon-sort-by-alphabet-alt' => 'icon-sort-by-alphabet-alt',
					'icon-sort-by-attributes' => 'icon-sort-by-attributes',
					'icon-sort-by-attributes-alt' => 'icon-sort-by-attributes-alt',
					'icon-sort-by-order' => 'icon-sort-by-order',
					'icon-sort-by-order-alt' => 'icon-sort-by-order-alt',
					'icon-sort-down' => 'icon-sort-down',
					'icon-sort-up' => 'icon-sort-up',
					'icon-spinner' => 'icon-spinner',
					'icon-stackexchange' => 'icon-stackexchange',
					'icon-star' => 'icon-star',
					'icon-star-empty' => 'icon-star-empty',
					'icon-star-half' => 'icon-star-half',
					'icon-star-half-empty' => 'icon-star-half-empty',
					'icon-step-backward' => 'icon-step-backward',
					'icon-step-forward' => 'icon-step-forward',
					'icon-stethoscope' => 'icon-stethoscope',
					'icon-stop' => 'icon-stop',
					'icon-strikethrough' => 'icon-strikethrough',
					'icon-subscript' => 'icon-subscript',
					'icon-suitcase' => 'icon-suitcase',
					'icon-sun' => 'icon-sun',
					'icon-superscript' => 'icon-superscript',
					'icon-table' => 'icon-table',
					'icon-tablet' => 'icon-tablet',
					'icon-tag' => 'icon-tag',
					'icon-tags' => 'icon-tags',
					'icon-tasks' => 'icon-tasks',
					'icon-terminal' => 'icon-terminal',
					'icon-text-height' => 'icon-text-height',
					'icon-text-width' => 'icon-text-width',
					'icon-th' => 'icon-th',
					'icon-th-large' => 'icon-th-large',
					'icon-th-list' => 'icon-th-list',
					'icon-thumbs-down' => 'icon-thumbs-down',
					'icon-thumbs-down-alt' => 'icon-thumbs-down-alt',
					'icon-thumbs-up' => 'icon-thumbs-up',
					'icon-thumbs-up-alt' => 'icon-thumbs-up-alt',
					'icon-ticket' => 'icon-ticket',
					'icon-time' => 'icon-time',
					'icon-tint' => 'icon-tint',
					'icon-trash' => 'icon-trash',
					'icon-trello' => 'icon-trello',
					'icon-trophy' => 'icon-trophy',
					'icon-truck' => 'icon-truck',
					'icon-tumblr' => 'icon-tumblr',
					'icon-tumblr-sign' => 'icon-tumblr-sign',
					'icon-twitter' => 'icon-twitter',
					'icon-twitter-sign' => 'icon-twitter-sign',
					'icon-umbrella' => 'icon-umbrella',
					'icon-underline' => 'icon-underline',
					'icon-undo' => 'icon-undo',
					'icon-unlink' => 'icon-unlink',
					'icon-unlock' => 'icon-unlock',
					'icon-unlock-alt' => 'icon-unlock-alt',
					'icon-upload' => 'icon-upload',
					'icon-upload-alt' => 'icon-upload-alt',
					'icon-usd' => 'icon-usd',
					'icon-user' => 'icon-user',
					'icon-user-md' => 'icon-user-md',
					'icon-vk' => 'icon-vk',
					'icon-volume-down' => 'icon-volume-down',
					'icon-volume-off' => 'icon-volume-off',
					'icon-volume-up' => 'icon-volume-up',
					'icon-warning-sign' => 'icon-warning-sign',
					'icon-weibo' => 'icon-weibo',
					'icon-windows' => 'icon-windows',
					'icon-wrench' => 'icon-wrench',
					'icon-xing' => 'icon-xing',
					'icon-xing-sign' => 'icon-xing-sign',
					'icon-youtube' => 'icon-youtube',
					'icon-youtube-play' => 'icon-youtube-play',
					'icon-youtube-sign' => 'icon-youtube-sign',
					'icon-zoom-in' => 'icon-zoom-in',
					'icon-zoom-out' => 'icon-zoom-out',
					'icon-zoom-out' => 'icon-zoom-out',
		    	);

				return apply_filters( $this->filter_hook_prefix . 'load_awesome_icon_list' , $awesome_fonts );
			}


		} // end - class AQ_Page_Builder_CustomClass

		global $aqpb_customclass;
		$aqpb_customclass = new AQ_Page_Builder_CustomClass();

	} // end - if ( !class_exists( 'AQ_Page_Builder_CustomClass' ) )