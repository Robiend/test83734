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
 *
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly

extract( $field );
?>
<input type="checkbox" id="<?php _e( $id) ?>"
       name="<?php _e( $name ) ?>" value="1"
    <?php _e( !empty( $class ) ? "class='$class'" : '') ?>
       <?php if ( isset( $std ) ) : ?>data-std="<?php _e( $std) ?>" <?php endif; ?>
    <?php checked( true, smms_plugin_fw_is_true( $value ) ) ?>
    <?php _e( $custom_attributes) ?>
    <?php if ( isset( $data ) ) _e( smms_plugin_fw_html_data_to_string( $data )) ?>/>
<?php
if ( isset( $field[ 'desc-inline' ] ) )
    _e( "<span class='description inline'>" . $field[ 'desc-inline' ] . "</span>");

?>
