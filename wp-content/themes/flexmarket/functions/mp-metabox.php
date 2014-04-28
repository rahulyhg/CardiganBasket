<?php
/*
	Metaboxes for Market Press Single Item
*/

	if (!function_exists('mpt_metaboxes_for_multiple_product_image')) {

		add_filter( 'cmb_meta_boxes', 'mpt_metaboxes_for_multiple_product_image' );
		
		function mpt_metaboxes_for_multiple_product_image( array $meta_boxes ) {

			// Start with an underscore to hide fields from custom fields list
			$prefix = '_mpt_';

			$meta_boxes[] = array(
				'id'         => 'page_metabox',
				'title'      => 'Additional Product Images',
				'pages'      => array('product'), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields'     => array(
					array(
						'name' => 'Second Product Image',
						'desc' => 'Upload an image or enter an URL here.',
						'id' => $prefix . 'video_featured_image_2',
						'type' => 'file',
						'save_id' => true, // save ID using true
						'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
					),
					array(
						'name' => 'Third Product Image',
						'desc' => 'Upload an image or enter an URL here.',
						'id' => $prefix . 'video_featured_image_3',
						'type' => 'file',
						'save_id' => true, // save ID using true
						'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
					),
				),
			);

			return $meta_boxes;
		}

	}

	if (!function_exists('metaboxes_for_mp_single')) {

		add_filter( 'cmb_meta_boxes', 'metaboxes_for_mp_single' );
		
		function metaboxes_for_mp_single( array $meta_boxes ) {

			// Start with an underscore to hide fields from custom fields list
			$prefix = '_mpt_';

			$meta_boxes[] = array(
				'id'         => 'post_custom_color_metabox',
				'title'      => 'Custom Styling Options',
				'pages'      => array('post','product'), // Post type
				'context'    => 'normal',
				'priority'   => 'core',
				'show_names' => true, // Show field names on the left
				'fields'     => array(
					array(
			            'name' => 'Header Section: Background Color',
			            'desc' => 'Pick a custom background color for header section.',
			            'id'   => $prefix . 'post_header_bg_color',
			            'type' => 'colorpicker',
						'std'  => ''
			        ),
					array(
			            'name' => 'Header Section: Text Color',
			            'desc' => 'Pick a custom text color for header section.',
			            'id'   => $prefix . 'post_header_text_color',
			            'type' => 'colorpicker',
						'std'  => ''
			        ),
					array(
			            'name' => 'Content Section: Background Color',
			            'desc' => 'Pick a custom background color for content section.',
			            'id'   => $prefix . 'post_content_bg_color',
			            'type' => 'colorpicker',
						'std'  => ''
			        ),
					array(
			            'name' => 'Content Section: Text Color',
			            'desc' => 'Pick a custom text color for content section.',
			            'id'   => $prefix . 'post_content_text_color',
			            'type' => 'colorpicker',
						'std'  => ''
			        ),
					array(
						'name' => 'Show Comments',
						'desc' => '',
						'id' => $prefix . 'post_show_comments',
						'type' => 'checkbox'
					),
				),
			);

			// Add other metaboxes as needed

			return $meta_boxes;
		}

	}


?>