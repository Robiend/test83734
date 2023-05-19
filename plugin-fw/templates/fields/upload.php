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
?>
<div class="smms-plugin-fw-upload-img-preview" style="margin-top:10px;">
	<?php
	$file = $value;
	if ( preg_match( '/(jpg|jpeg|png|gif|ico)$/', $file ) ) {
		_e( "<img src='$file' style='max-width:600px; max-height:300px;' />");
	}
	?>
</div>
<input type="text" id="<?php _e( $id) ?>" name="<?php _e( $name) ?>" value="<?php _e( esc_attr( $value )) ?>" <?php if ( isset( $default ) ) : ?>data-std="<?php _e( $default) ?>"<?php endif ?> class="smms-plugin-fw-upload-img-url"/>
<button class="button-secondary smms-plugin-fw-upload-button" id="<?php _e( $id) ?>-button"><?php _e( 'Upload', 'smms-plugin-fw' ) ?></button>
<button type="button"  id="<?php _e( $id) ?>-button-reset" class="smms-plugin-fw-upload-button-reset button"
        data-default="<?php _e( isset( $default ) ? $default : '' )?>"><?php _e( 'Reset', 'smms-plugin-fw' ) ?></button>
