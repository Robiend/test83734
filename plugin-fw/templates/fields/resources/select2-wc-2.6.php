<?php
/**
 * This file belongs to the SMM Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @var array  $args
 * @var string $custom_attributes
 *
 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly
?>

<input
        type="hidden"
        id="<?php  _e( $args[ 'id' ]) ?>"
        class="<?php  _e( $args[ 'class' ]) ?>"
        name="<?php  _e(  $args[ 'name' ] )?>"
        data-placeholder="<?php _e(  $args[ 'data-placeholder' ]) ?>"
        data-allow_clear="<?php _e(  $args[ 'data-allow_clear' ]) ?>"
        data-selected="<?php _e(  is_array( $args[ 'data-selected' ] ) ? esc_attr( json_encode( $args[ 'data-selected' ] ) ) : esc_attr( $args[ 'data-selected' ] )) ?>"
        data-multiple="<?php _e( $args[ 'data-multiple' ] === true ? 'true' : 'false' )?>"
    <?php _e( !empty( $args[ 'data-action' ] ) ? 'data-action="' . $args[ 'data-action' ] . '"' : '' ) ?>
        value="<?php _e(  $args[ 'value' ]) ?>"
        style="<?php _e(  $args[ 'style' ]) ?>"
    <?php _e( $custom_attributes )?>
/>
