<?php
/**
 * @var array  $field
 * @var string $description
 */
$default_field = array(
    'id'    => '',
    'title' => isset( $field[ 'name' ] ) ? $field[ 'name' ] : '',
    'desc'  => '',
);
$field         = wp_parse_args( $field, $default_field );

$display_row = !in_array( $field[ 'type' ], array( 'hidden', 'html', 'sep', 'simple-text', 'title', 'list-table' ) );
$display_row = isset( $field[ 'smms-display-row' ] ) ? !!$field[ 'smms-display-row' ] : $display_row;

$extra_row_classes = apply_filters( 'smms_plugin_fw_panel_wc_extra_row_classes', array(), $field );
$extra_row_classes = is_array( $extra_row_classes ) ? implode( ' ', $extra_row_classes ) : '';

?>
<tr valign="top" class="smms-plugin-fw-panel-wc-row <?php _e( $field[ 'type' ]) ?> <?php _e( $extra_row_classes )?>" <?php _e( smms_field_deps_data( $field ) )?>>
    <?php if ( $display_row ) : ?>
        <th scope="row" class="titledesc">
            <label for="<?php _e( esc_attr( $field[ 'id' ] )) ?>"><?php _e( esc_html( $field[ 'title' ] ))?></label>
        </th>
        <td class="forminp forminp-<?php _e(sanitize_title( $field[ 'type' ] )) ?>">
            <?php smms_plugin_fw_get_field( $field, true ); ?>
            <?php _e( '<span class="description">' . wp_kses_post( $field[ 'desc' ] ) . '</span>') ?>
        </td>
    <?php else: ?>
        <td colspan="2">
            <?php smms_plugin_fw_get_field( $field, true ); ?>
        </td>
    <?php endif; ?>
</tr>