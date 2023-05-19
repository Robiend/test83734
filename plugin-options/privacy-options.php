<?php

$settings = array(

    'privacy' => array(

            'privacy_settings'     => array(
                'name' => __( 'Privacy settings', 'smm-api' ),
                'type' => 'title',
                'id'   => 'smapi_privacy_settings'
            ),

            'erasure_request'   => array(
	            'name'      => __('Account erasure requests','smm-api'),
	            'desc-inline'      => __( 'Remove personal data from subscriptions', 'smms-woocommerce-request-a-quote' ),
	            'desc'      => sprintf( __( 'When handling an <a href="%s">account erasure request</a>, should personal data within subscriptions be retained or removed?.
<br>Note: All the subscriptions will change the status to cancelled if the personal data will be removed.', 'smms-woocommerce-request-a-quote' ), esc_url( admin_url( 'tools.php?page=remove_personal_data' ) ) ),
	            'id'        => 'smapi_erasure_request',
	            'type'      => 'smms-field',
	            'smms-type' => 'onoff',
	            'default'   => 'no'
            ),

            'section_end_privacy_settings'=> array(
	            'type'              => 'sectionend',
	            'id'                => 'smapi_section_end_privacy_settings'
            ),

            array(
	            'title' => __( 'Personal data retention', 'smm-api' ),
	            'desc'  => __( 'Choose how long to retain personal data when it\'s no longer needed for processing. Leave the following options blank to retain this data indefinitely.', 'smm-api' ),
	            'type'  => 'title',
	            'id'    => 'smapi_personal_data_retention',
            ),
            array(
	            'title'       => __( 'Retain pending subscriptions', 'smm-api' ),
	            'desc_tip'    => __( 'Pending subscriptions are unpaid and may have been abandoned by the customer. They will be trashed after the specified duration.', 'smm-api' ),
	            'id'          => 'smapi_trash_pending_subscriptions',
	            'type'        => 'relative_date_selector',
	            'placeholder' => __( 'N/A', 'smm-api' ),
	            'default'     => '',
            ),
            array(
	            'title'       => __( 'Retain cancelled subscriptions', 'smm-api' ),
	            'desc_tip'    => __( 'Cancelled subscriptions are disable subscriptions that can\'t be reactivated by the customer. They will be trashed after the specified duration.', 'smm-api' ),
	            'id'          => 'smapi_trash_cancelled_subscriptions',
	            'type'        => 'relative_date_selector',
	            'placeholder' => __( 'N/A', 'smm-api' ),
	            'default'     => '',
            ),

            'section_end_privacy_retention_settings'=> array(
	            'type'              => 'sectionend',
	            'id'                => 'smapi_section_end_privacy_retention_settings'
            ),


    )

);

return apply_filters( 'smms_smapi_panel_privacy_settings_options', $settings );