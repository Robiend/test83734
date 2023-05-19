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

extract( $field );

$layout        = !isset( $value[ 'layout' ] ) ? 'sidebar-no' : $value[ 'layout' ];
$sidebar_left  = !isset( $value[ 'sidebar-left' ] ) ? '-1' : $value[ 'sidebar-left' ];
$sidebar_right = !isset( $value[ 'sidebar-right' ] ) ? '-1' : $value[ 'sidebar-right' ];
?>
<div class="smms-plugin-fw-sidebar-layout">
    <div class="option">
        <input type="radio" name="<?php esc_html_e( $name) ?>[layout]" id="<?php _e( $id) . '-left' ?>" value="sidebar-left" <?php checked( $layout, 'sidebar-left' ) ?> />
        <img src="<?php _e( SMM_CORE_PLUGIN_URL) ?>/assets/images/sidebar-left.png" title="<?php _e( 'Left sidebar', 'smms-plugin-fw' ) ?>" alt="<?php _e( 'Left sidebar', 'smms-plugin-fw' ) ?>" class="<?php _e( $id) . '-left' ?>" data-type="left"/>

        <input type="radio" name="<?php esc_html_e($name) ?>[layout]" id="<?php _e( $id) . '-right' ?>" value="sidebar-right" <?php checked( $layout, 'sidebar-right' ) ?> />
        <img src="<?php _e( SMM_CORE_PLUGIN_URL) ?>/assets/images/sidebar-right.png" title="<?php _e( 'Right sidebar', 'smms-plugin-fw' ) ?>" alt="<?php _e( 'Right sidebar', 'smms-plugin-fw' ) ?>" class="<?php _e( $id) . '-right' ?>" data-type="right"/>

        <input type="radio" name="<?php esc_html_e( $name) ?>[layout]" id="<?php _e( $id) . '-double' ?>" value="sidebar-double" <?php checked( $layout, 'sidebar-double' ) ?> />
        <img src="<?php _e( SMM_CORE_PLUGIN_URL) ?>/assets/images/double-sidebar.png" title="<?php _e( 'No sidebar', 'smms-plugin-fw' ) ?>" alt="<?php _e( 'No sidebar', 'smms-plugin-fw' ) ?>" class="<?php _e( $id) . '-double' ?>" data-type="double"/>

        <input type="radio" name="<?php esc_html_e( $name) ?>[layout]" id="<?php _e( $id) . '-no' ?>" value="sidebar-no" <?php checked( $layout, 'sidebar-no' ) ?> />
        <img src="<?php _e( SMM_CORE_PLUGIN_URL) ?>/assets/images/no-sidebar.png" title="<?php _e( 'No sidebar', 'smms-plugin-fw' ) ?>" alt="<?php _e( 'No sidebar', 'smms-plugin-fw' ) ?>" class="<?php _e( $id) . '-no' ?>" data-type="none"/>
    </div>
    <div class="clearfix"></div>
    <div class="option" id="choose-sidebars">
        <div class="side">
            <div <?php if ( $layout != 'sidebar-double' && $layout != 'sidebar-left' ) {
                _e( 'style="display:none"');
            } ?> class="smms-plugin-fw-sidebar-layout-sidebar-left-container select-mask">
                <label for="<?php _e( $id) ?>-sidebar-left"><?php _e( 'Left Sidebar', 'smms-plugin-fw' ) ?></label>
                <select class="smms-plugin-fw-select" name="<?php _e( $name) ?>[sidebar-left]" id="<?php _e( $id) ?>-sidebar-left">
                    <option value="-1"><?php _e( 'Choose a sidebar', 'smms-plugin-fw' ) ?></option>
                    <?php foreach ( smm_registered_sidebars() as $val => $option ) { ?>
                        <option value="<?php _e( esc_attr( $val )) ?>" <?php selected( $sidebar_left, $val ) ?>><?php _e( $option) ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="side" style="clear: both">
            <div <?php if ( $layout != 'sidebar-double' && $layout != 'sidebar-right' ) {
                _e( 'style="display:none"');
            } ?> class="smms-plugin-fw-sidebar-layout-sidebar-right-container select-mask">
                <label for="<?php _e( $id) ?>-sidebar-right"><?php _e( 'Right Sidebar', 'smms-plugin-fw' ) ?></label>
                <select class="smms-plugin-fw-select" name="<?php _e( $name) ?>[sidebar-right]" id="<?php _e( $id) ?>-sidebar-right">
                    <option value="-1"><?php _e( 'Choose a sidebar', 'smms-plugin-fw' ) ?></option>
                    <?php foreach ( smm_registered_sidebars() as $val => $option ) { ?>
                        <option value="<?php _e( esc_attr( $val )) ?>" <?php selected( $sidebar_right, $val ) ?>><?php _e( $option) ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
