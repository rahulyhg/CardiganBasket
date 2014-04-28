<?php 
/*
	Metaboxes for Page
*/

	if (!function_exists('metaboxes_for_page')) {

		add_filter( 'cmb_meta_boxes', 'metaboxes_for_page' );
		
		function metaboxes_for_page( array $meta_boxes ) {

			// Start with an underscore to hide fields from custom fields list
			$prefix = '_mpt_';

			$meta_boxes[] = array(
				'id'         => 'page_metabox',
				'title'      => 'Page Options',
				'pages'      => array('page'), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields'     => array(
					array(
			            'name' => 'Header Section: Background Color',
			            'desc' => 'Pick a custom background color for header section.',
			            'id'   => $prefix . 'page_header_bg_color',
			            'type' => 'colorpicker',
						'std'  => ''
			        ),
					array(
			            'name' => 'Header Section: Text Color',
			            'desc' => 'Pick a custom text color for header section.',
			            'id'   => $prefix . 'page_header_text_color',
			            'type' => 'colorpicker',
						'std'  => ''
			        ),
					array(
			            'name' => 'Content Section: Background Color',
			            'desc' => 'Pick a custom background color for content section.',
			            'id'   => $prefix . 'page_content_bg_color',
			            'type' => 'colorpicker',
						'std'  => ''
			        ),
					array(
			            'name' => 'Content Section: Text Color',
			            'desc' => 'Pick a custom text color for content section.',
			            'id'   => $prefix . 'page_content_text_color',
			            'type' => 'colorpicker',
						'std'  => ''
			        ),		        
					array(
						'name' => 'Show Comments',
						'desc' => '',
						'id' => $prefix . 'page_show_comments',
						'type' => 'checkbox'
					),
				),
			);

			// Meta Boxes For Blog Page Template
			$meta_boxes[] = array(
				'id'         => 'blog_page_metabox',
				'title'      => 'Blog Options',
				'pages'      => array( 'page', ), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'show_on'    => array( 'key' => 'page-template', 'value' => 'page-blog.php' ), // Specific page template to display this metabox
				'fields' => array(
					array(
						'name' => 'Page Layout',
						'desc' => 'Select the layout you want to display in this blog page',
						'id' => $prefix . 'blog_page_layout',
						'type' => 'select',
						'options' => array(
							array('name' => '1 Columns (with sidebar)', 'value' => '1col'),
							array('name' => '2 Columns (without sidebar)', 'value' => '2col'),
							array('name' => '3 Columns (without sidebar)', 'value' => '3col')				
						),
						'std'  => '1col'
					),
					array(
						'name' => 'Number of entries',
						'desc' => 'Select the number of entries that should appear (per page).',
						'id' => $prefix . 'blog_page_entries',
						'type' => 'select',
						'options' => array(
							array('name' => '2', 'value' => '2'),
							array('name' => '3', 'value' => '3'),
							array('name' => '4', 'value' => '4'),		
							array('name' => '5', 'value' => '5'),
							array('name' => '6', 'value' => '6'),		
							array('name' => '7', 'value' => '7'),
							array('name' => '8', 'value' => '8'),		
							array('name' => '9', 'value' => '9'),
							array('name' => '10', 'value' => '10'),	
							array('name' => '11', 'value' => '11'),
							array('name' => '12', 'value' => '12'),	
							array('name' => '13', 'value' => '13'),
							array('name' => '14', 'value' => '14'),	
							array('name' => '15', 'value' => '15'),
							array('name' => '16', 'value' => '16'),	
							array('name' => '17', 'value' => '17'),
							array('name' => '18', 'value' => '18'),	
							array('name' => '19', 'value' => '19'),
							array('name' => '20', 'value' => '20')
						),
						'std'  => '5'
					),
				)
			);

			// Add other metaboxes as needed

			return $meta_boxes;
		}

	}

?>