<?php

$settings = array(

    'general' => array(

            'section_general_settings'     => array(
                'name' => __( 'General settings', 'smm-api' ),
                'type' => 'title',
                'id'   => 'smapi_section_general'
            ),

            'enabled' => array(
                'name'    =>  __( 'Enable Subscription', 'smm-api' ),
                'desc'    => '',
                'id'      => 'smapi_enabled',
                'type'      => 'smms-field',
                'smms-type' => 'onoff',
                'default' => 'yes'
            ),


            'section_end_form'=> array(
                'type'              => 'sectionend',
                'id'                => 'smapi_section_general_end_form'
            ),
        )

);

return apply_filters( 'smms_smapi_panel_settings_options', $settings );