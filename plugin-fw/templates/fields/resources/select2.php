<?php
/**
 * This file belongs to the SMM Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @var array $args
 * @var string $custom_attributes
 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly
?>

<select
        id="<?php _e( $args[ 'id' ]) ?>"
        class="<?php _e( $args[ 'class' ]) ?>"
        name="<?php _e( $args[ 'name' ]) ?>"
        data-placeholder="<?php _e( $args[ 'data-placeholder' ] )?>"
        data-allow_clear="<?php _e( $args[ 'data-allow_clear' ]) ?>"
    <?php _e( !empty( $args[ 'data-action' ] ) ? 'data-action="' . $args[ 'data-action' ] . '"' : ''); ?>
    <?php _e( !empty( $args[ 'data-multiple' ] ) ? 'multiple="multiple"' : ''); ?>
        style="<?php _e( $args[ 'style' ]) ?>"
    <?php _e( $custom_attributes) ?>
>

    <?php if ( !empty( $args[ 'value' ] ) ) {
        $values = $args[ 'value' ];

        if ( !is_array( $values ) ) {
            $values = explode( ',', $values );
        }

        foreach ( $values as $value ): ?>
            <option value="<?php _e( $value); ?>" <?php selected( true, true, true ) ?> >
                <?php _e( $args[ 'data-selected' ][ $value ]); ?>
            </option>
        <?php endforeach;
    }
    ?>
</select>
