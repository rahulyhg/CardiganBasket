<?php

global $mpcr_settings;

// General Settings section
$mpcr_settings[] = array(
    'section_id' => 'general_settings',
    'section_title' => 'General Settings',
    'section_description' => 'You can change the look and feel of Checkout Recommendation here',
    'section_order' => 5,
    'fields' => array(
        array(
            'id' => 'enable_checkout_recommendation',
            'title' => 'Turn on Checkout Recommendation',
            'desc' => '',
            'type' => 'radio',
            'std' => 'no',
            'choices' => array(
                'yes' => 'Yes',
                'no' => 'No'
            )
        ),       
        array(
            'id' => 'cr_title',
            'title' => 'Title Text',
            'desc' => '',
            'type' => 'textarea',
            'std' => 'Customers Who Bought Items In Your Cart Also Bought:'
        ),
        array(
            'id' => 'cr_items_per_row',
            'title' => 'Items per Row',
            'desc' => '',
            'type' => 'select',
            'std' => 'span-4x',
            'choices' => array(
                'span-2x' => '2 items per row',
                'span-3x' => '3 items per row',
                'span-4x' => '4 items per row',
                'span-5x' => '5 items per row',
                'span-6x' => '6 items per row'
            )
        ),        
        array(
            'id' => 'cr_color_skin',
            'title' => 'Color skin',
            'desc' => '',
            'type' => 'select',
            'std' => 'grey',
            'choices' => array(
                'grey' => 'Grey',
                'blue' => 'Blue',
                'lightblue' => 'Light Blue',
                'green' => 'Green',
                'red' => 'Red',
                'yellow' => 'Yellow',
                'black' => 'Black'
            )
        )
    )
);

?>