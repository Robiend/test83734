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

$min_max_attr = $step_attr = '';

if ( isset( $min ) ) {
    $min_max_attr .= " min='{$min}'";
}

if ( isset( $max ) ) {
    $min_max_attr .= " max='{$max}'";
}

if ( isset( $step ) ) {
    $step_attr .= "step='{$step}'";
}
?>
<input type="number" id="<?php _e( $id) ?>"
    <?php _e( !empty( $class )) ? "class='$class'" : ''; ?>
       name="<?php _e( $name) ?>" <?php _e( $step_attr) ?> <?php _e( $min_max_attr) ?>
       value="<?php _e( esc_attr( $value ) )?>" <?php if ( isset( $std ) ) : ?>data-std="<?php _e( $std) ?>"<?php endif ?>
    <?php _e( $custom_attributes) ?>
    <?php if ( isset( $data ) ) _e( smms_plugin_fw_html_data_to_string( $data )) ?>/>