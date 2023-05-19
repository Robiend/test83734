<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly


return array(
    'servers' => array(
        'home' => array(
            'type'   => 'custom_tab',
            'action' => 'smms_smapi_servers_tab',
            'hide_sidebar' => true
        )
    )
);