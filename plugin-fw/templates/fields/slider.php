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

$min = isset( $option[ 'min' ] ) ? $option[ 'min' ] : 0;
$max = isset( $option[ 'max' ] ) ? $option[ 'max' ] : 100;
?>
<div class="smms-plugin-fw-slider-container">
    <div class="ui-slider">
        <span class="minCaption"><?php _e( $min) ?></span>
        <div id="<?php _e( $id) ?>-div" data-step="<?php _e( isset( $step ) ? $step : 1 )?>" data-min="<?php _e( $min) ?>" data-max="<?php _e( $max) ?>" data-val="<?php _e( $value) ?>" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
            <input id="<?php _e( $id) ?>" type="hidden" name="<?php _e( $name) ?>" value="<?php _e( esc_attr( $value )) ?>"/>
        </div>
        <span class="maxCaption"><?php _e( $max) ?></span>
    </div>
</div>