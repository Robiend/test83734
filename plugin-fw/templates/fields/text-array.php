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

$size = isset( $size ) ? " style=\"width:{$size}px;\"" : '';
?>
<table class="smms-plugin-fw-text-array-table">
    <?php foreach ( $fields as $field_name => $field_label ) : ?>
        <tr>
            <td><?php _e( $field_label) ?></td>
            <td>
                <input type="text" name="<?php _e( $name) ?>[<?php _e( $field_name) ?>]" id="<?php _e( $id) ?>_<?php _e( $field_name) ?>" value="<?php _e( isset( $value[ $field_name ] ) ? esc_attr( $value[ $field_name ] ) : '') ?>"<?php _e( $size) ?> />
            </td>
        </tr>
    <?php endforeach ?>
</table>
