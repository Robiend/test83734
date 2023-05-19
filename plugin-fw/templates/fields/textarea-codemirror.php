<?php
/**
 * This file belongs to the SMM Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */


!defined( 'ABSPATH' ) && exit; // Exit if accessed directly

wp_enqueue_script( 'wp-codemirror' );
wp_enqueue_script( 'codemirror-javascript' );
wp_enqueue_style( 'codemirror' );

extract( $field );

$class = isset( $class ) ? $class : 'codemirror';
?>
<textarea id="<?php _e( $id) ?>"
          name="<?php _e( $name) ?>"
          class="<?php _e( $class) ?>"
          rows="8" cols="50" <?php _e( $custom_attributes) ?>
    <?php if ( isset( $data ) ) _e( smms_plugin_fw_html_data_to_string( $data )) ?>><?php _e( $value) ?></textarea>