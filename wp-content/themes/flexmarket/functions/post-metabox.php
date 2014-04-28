<?php 
/*
	Metaboxes for Post
*/

	if (!function_exists('metaboxes_for_post')) {

		add_filter( 'cmb_meta_boxes', 'metaboxes_for_post' );
		
		function metaboxes_for_post( array $meta_boxes ) {

			// Start with an underscore to hide fields from custom fields list
			$prefix = '_mpt_';

			$meta_boxes[] = array(
				'id'         => 'post_metabox',
				'title'      => 'Post Options',
				'pages'      => array('post'), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields'     => array(
					array(
						'name' => 'Select Post Template',
						'desc' => 'Select the post template you want to display for this post.',
						'id' => $prefix . 'post_select_temp',
						'type' => 'select',
						'options' => array(
							array('name' => 'None', 'value' => 'none'),
							array('name' => 'Image Slider', 'value' => 'image-carousel'),
							array('name' => 'Video Post', 'value' => 'video')				
						)
					),
					array(
						'name' => 'Second Image For Silder',
						'desc' => 'Upload a second image or enter an URL here. <em>Image format: JPEG, PNG, or GIF only</em>',
						'id' => $prefix . 'video_featured_image_2',
						'type' => 'file',
						'save_id' => true, // save ID using true
						'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
					),
					array(
						'name' => 'Third Image For Slider',
						'desc' => 'Upload a third image or enter an URL here. <em>Image format: JPEG, PNG, or GIF only</em>',
						'id' => $prefix . 'video_featured_image_3',
						'type' => 'file',
						'save_id' => true, // save ID using true
						'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
					),
					array(
						'name' => 'Video URL',
						'desc' => 'Enter the video url here. <em>(example: http://vimeo.com/51333291 or http://youtu.be/iOiE6XMy0y8)</em>',
						'id' => $prefix . 'post_video_url',
						'type' => 'text'
					),
					array(
						'name' => 'Select Video Type',
						'desc' => '',
						'id' => $prefix . 'post_video_type',
						'type' => 'select',
						'options' => array(
							array('name' => 'Youtube', 'value' => 'youtube'),
							array('name' => 'Vimeo', 'value' => 'vimeo')				
						)
					),
				),
			);

			$meta_boxes[] = array(
				'id'         => 'post_custom_color_metabox',
				'title'      => 'Custom Color Options',
				'pages'      => array('post','portfolio'), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
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
			        )
				),
			);

			// Add other metaboxes as needed

			return $meta_boxes;
		}

	}

?>