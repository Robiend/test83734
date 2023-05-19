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

extract( $field );
$multiple      = isset( $multiple ) && $multiple;
$multiple_html = ( $multiple ) ? ' multiple' : '';
$placeholder   = isset( $placeholder ) ? ' data-placeholder = "' . $placeholder .'" ': '';
if ( $multiple && !is_array( $value ) )
    $value = array();

$class = isset( $class ) ? $class : 'smms-plugin-fw-select';
?>
    <select<?php _e( $multiple_html) ?>
            id="<?php _e( $id) ?>"
        name="<?php _e( $name) ?><?php if ( $multiple ) _e( "[]" )?>" <?php if ( isset( $std ) ) : ?>
        data-std="<?php _e( ( $multiple ) ? implode( ' ,', $std ) : $std) ?>"<?php endif ?>

        class="<?php _e( $class) ?>"
	    <?php _e( $placeholder) ?>
        <?php _e( $custom_attributes) ?>
        <?php if ( isset( $data ) ) _e( smms_plugin_fw_html_data_to_string( $data )) ?>>
        <?php foreach ( $options as $key => $item ) : ?>
            <option value="<?php _e( esc_attr( $key )) ?>" <?php if ( $multiple ): selected( true, in_array( $key, $value ) );
            else: selected( $key, $value ); endif; ?> ><?php _e( $item) ?></option>
        <?php endforeach; ?>
    </select>

<?php
/* --------- BUTTONS ----------- */
if ( isset( $buttons ) ) {
    $button_field = array(
        'type'    => 'buttons',
        'buttons' => $buttons
    );
    smms_plugin_fw_get_field( $button_field, true );
}
?>