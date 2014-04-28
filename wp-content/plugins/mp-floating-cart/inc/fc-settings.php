<?php

global $floatcart_settings;

// General Settings section
$floatcart_settings[] = array(
        'section_id' => 'general',
        'section_title' => __('Settings','floating-cart'),
        'section_description' => __('You can change the look and feel of Floating Cart here','floating-cart'),
        'section_order' => 5,
        'fields' => array(
            array(
                'id' => 'enable_floating_cart',
                'title' => __('Turn on Floating Cart','floating-cart'),
                'desc' => '',
                'type' => 'radio',
                'std' => 'no',
                'choices' => array(
                    'yes' => __('Yes','floating-cart'),
                    'no' => __('No','floating-cart')
                )
            ),
            array(
                'id' => 'show_button_text',
                'title' => __('Show Button Text','floating-cart'),
                'desc' => '',
                'type' => 'radio',
                'std' => 'yes',
                'choices' => array(
                    'yes' => __('Yes','floating-cart'),
                    'no' => __('No','floating-cart')
                )
            ),        
            array(
                'id' => 'button_text',
                'title' => __('Button Text','floating-cart'),
                'desc' => '',
                'type' => 'text',
                'std' => __('View Cart','floating-cart')
            ),
            array(
                'id' => 'show_cart_total_item',
                'title' => __('Show Cart Total Item','floating-cart'),
                'desc' => '',
                'type' => 'radio',
                'std' => 'yes',
                'choices' => array(
                    'yes' => __('Yes','floating-cart'),
                    'no' => __('No','floating-cart')
                )
            ),
            array(
                'id' => 'show_cart_total_amount',
                'title' => __('Show Cart Total Amount','floating-cart'),
                'desc' => '',
                'type' => 'radio',
                'std' => 'yes',
                'choices' => array(
                    'yes' => __('Yes','floating-cart'),
                    'no' => __('No','floating-cart')
                )
            ),
            array(
                'id' => 'button_color_predefined',
                'title' => __('Select the Button Color','floating-cart'),
                'desc' => '',
                'type' => 'select',
                'std' => 'grey',
                'choices' => array(
                    'grey' => __('Grey','floating-cart'),
                    'blue' => __('Blue','floating-cart'),
                    'lightblue' => __('Light Blue','floating-cart'),
                    'green' => __('Green','floating-cart'),
                    'red' => __('Red','floating-cart'),
                    'yellow' => __('Yellow','floating-cart'),
                    'black' => __('Black','floating-cart')
                )
            ),
            array(
                'id' => 'button_position',
                'title' => __('Button Position','floating-cart'),
                'desc' => '',
                'type' => 'radio',
                'std' => 'top-right',
                'choices' => array(
                    'top-left' => __('Top Left','floating-cart'),
                    'top-right' => __('Top Right','floating-cart'),
                    'middle-left' => __('Middle Left','floating-cart'),
                    'middle-right' => __('Middle Right','floating-cart'),
                    'bottom-left' => __('Bottom Left','floating-cart'),
                    'bottom-right' => __('Bottom Right','floating-cart')
                )
            ),
            array(
                'id' => 'fc_only_in_store',
                'title' => __('Only show on store pages','floating-cart'),
                'desc' => '',
                'type' => 'radio',
                'std' => 'no',
                'choices' => array(
                    'yes' => __('Yes','floating-cart'),
                    'no' => __('No','floating-cart')
                )
            ),
            array(
                'id' => 'fc_mobile_view',
                'title' => __('Hide Floating Cart in Mobile Mode','floating-cart'),
                'desc' => '',
                'type' => 'radio',
                'std' => 'yes',
                'choices' => array(
                    'yes' => __('Yes','floating-cart'),
                    'no' => __('No','floating-cart')
                )
            )
        )
);