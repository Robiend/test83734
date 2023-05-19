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
$multiple_html = ( isset( $multiple ) && $multiple ) ? ' multiple' : '';
?>

<select<?php _e( $multiple_html) ?>
    id="<?php _e( $id) ?>"
    name="<?php _e( $name) ?>" <?php if ( isset( $std ) ) : ?>data-std="<?php _e( $std) ?>"<?php endif ?>
    class="smms-plugin-fw-select"
    <?php _e( $custom_attributes) ?>
    <?php if ( isset( $data ) ) _e( smms_plugin_fw_html_data_to_string( $data )) ?>>
    <?php foreach ( $options as $key => $item ) : ?>
        <option value="<?php _e( $key) ?>"<?php selected( $key, $value ) ?>><?php _e( $item) ?></option>
    <?php endforeach; ?>
</select>
<input type="button" class="button-secondary <?php _e( isset( $class ) ? $class : '') ?>" value="<?php _e( $button_name) ?>"/>
<span class="spinner"></span>
