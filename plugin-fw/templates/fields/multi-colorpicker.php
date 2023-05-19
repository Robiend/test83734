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

wp_enqueue_style( 'wp-color-picker' );

extract( $field );
if ( ! isset( $colorpickers ) ){
    return;
}
$class = !empty( $class ) ? $class : 'smms-plugin-fw-multi-colorpicker';
?>
<div class="<?php _e( esc_attr( $class ))?>" id="<?php _e( esc_attr( $id )) ?>">

<?php
$items_to_process = array();

for ( $i = 0; $i < count( $colorpickers ); $i++ ):
    $items = $colorpickers[ $i ];

    // make sure that we have at least one group
    if( isset( $items['id'] ) ){
	    $items_to_process[] = $items;
	    $next = isset( $colorpickers[ $i + 1 ] ) ? $colorpickers[ $i + 1 ] : false;

	    if( isset( $next['id'] ) ){
	        continue;
        }
    }
    else{
        $items_to_process = $items;
    }

    if( isset( $items_to_process['desc'] ) ){
        $group_desc = $items_to_process['desc'];
        unset( $items_to_process['desc'] );
    }
?>
    <div class="smms-colorpicker-group">
        <?php
            foreach( $items_to_process as $colorpicker ):
                if( ! is_array( $colorpicker ) ){
                    continue;
                }

                $colorpicker['type'] = 'colorpicker';
                $colorpicker['title'] = $colorpicker['name'];
                $colorpicker['name'] = $name."[{$colorpicker['id']}]";
                $colorpicker['value'] = isset( $value[$colorpicker['id']] ) ? $value[$colorpicker['id']] : $colorpicker['default'];
                $colorpicker['id']   = $name."_".$colorpicker['id'];
        ?>
        <div class="smms-single-colorpicker colorpicker">
            <label for="<?php _e( esc_attr($colorpicker['id'] ) )?>"><?php _e( esc_html($colorpicker['title'])) ?></label>
            <?php _e( smms_plugin_fw_get_field( $colorpicker, true, false )) ?>
            </div>

        <?php endforeach; ?>
        <?php if( ! empty( $group_desc ) ): ?>
            <span class="description"><?php _e( $group_desc) ?></span>
        <?php endif; ?>
    </div>
<?php $items_to_process = array() ?>
<?php endfor; ?>
</div>