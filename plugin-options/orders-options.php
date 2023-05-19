<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly


return array(
    'orders' => array(
        'home' => array(
            'type'   => 'custom_tab',
            'action' => 'smms_smapi_orders_tab',
            'hide_sidebar' => true
        )
    )
);