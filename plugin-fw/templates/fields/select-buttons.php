<?php
/**
 * This file belongs to the SMM Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @var array $field
 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly

wp_enqueue_script( 'wc-enhanced-select' );

$field[ 'type' ] = 'select';

if ( empty( $field[ 'class' ] ) ) unset( $field[ 'class' ] );

$add_label = isset( $field['add_all_button_label'] ) ? $field['add_all_button_label'] : __( 'Add All', 'smms-plugin-fw' );
$default_args = array(
    'multiple' => true,
    'class'    => 'wc-enhanced-select',
    'buttons'  => array(
        array(
            'name'  => $add_label,
            'class' => 'smms-plugin-fw-select-all',
            'data'  => array(
                'select-id' => $field[ 'id' ]
            ),
        ),
        array(
            'name'  => __( 'Remove All', 'smms-plugin-fw' ),
            'class' => 'smms-plugin-fw-deselect-all',
            'data'  => array(
                'select-id' => $field[ 'id' ]
            ),
        )
    )
);

$field = wp_parse_args( $field, $default_args );

smms_plugin_fw_get_field( $field, true );