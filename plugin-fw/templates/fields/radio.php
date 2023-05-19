<?php
/**
 * This file belongs to the SMM Plugin Framework.
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @var array $field
 */

/** @since 3.0.13 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly

extract( $field );

$class = isset( $class ) ? $class : '';
$class = 'smms-plugin-fw-radio ' . $class;

?>
<div class="<?php _e( $class) ?>" id="<?php _e( $id ) ?>"
    <?php _e( $custom_attributes) ?>
    <?php if ( isset( $data ) ) _e( smms_plugin_fw_html_data_to_string( $data )) ?> value="<?php _e( $value) ?>">
    <?php foreach ( $options as $key => $label ) :
        $radio_id = sanitize_key( $id . '-' . $key );
        ?>
        <div class="smms-plugin-fw-radio__row">
            <input type="radio" id="<?php _e( $radio_id) ?>" name="<?php _e( $name) ?>" value="<?php _e( esc_attr( $key )) ?>" <?php checked( $key, $value ); ?> />
            <label for="<?php _e( $radio_id) ?>"><?php _e( $label) ?></label>
        </div>
    <?php endforeach; ?>
</div>

