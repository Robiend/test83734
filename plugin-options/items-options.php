<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly


return array(
    'items' => array(
        'home' => array(
            'type'   => 'custom_tab',
            'action' => 'smms_smapi_items_tab',
            'hide_sidebar' => true
        )
    )
);