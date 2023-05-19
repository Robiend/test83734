<?php
/**
 * This file belongs to the SMM Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @var $field
 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly

extract( $field );

$class   = isset( $class ) ? $class : 'smms-plugin-fw-select';
$options = smm_registered_sidebars();
?>
<select id="<?php _e( $id) ?>"
        name="<?php _e( $name) ?>"
        class="<?php _e( $class) ?>"
    <?php _e( $custom_attributes) ?>
    <?php if ( isset( $data ) ) _e( smms_plugin_fw_html_data_to_string( $data )) ?>>
    <?php foreach ( $options as $key => $item ) : ?>
        <option value="<?php _e( esc_attr( $key )) ?>"<?php selected( $key, $value ) ?>><?php _e( $item) ?></option>
    <?php endforeach; ?>
</select>
