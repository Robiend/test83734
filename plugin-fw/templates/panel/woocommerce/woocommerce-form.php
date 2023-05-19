<?php
$panel_content_class = apply_filters( 'smm_admin_panel_content_class', 'smm-admin-panel-content-wrap' );
?>

<div id="<?php _e( $this->settings[ 'page' ]) ?>_<?php _e( $this->get_current_tab()) ?>" class="smms-plugin-fw  smm-admin-panel-container">
    <?php do_action( 'smm_framework_before_print_wc_panel_content', $current_tab ); ?>
    <div class="<?php _e( $panel_content_class)?>">
        <form id="plugin-fw-wc" method="post">
            <?php $this->add_fields() ?>
            <?php wp_nonce_field( 'smm_panel_wc_options_' . $this->settings[ 'page' ], 'smm_panel_wc_options_nonce' ); ?>
            <input style="float: left; margin-right: 10px;" class="button-primary" type="submit" value="<?php _e( 'Save Changes', 'smms-plugin-fw' ) ?>"/>
        </form>
        <form id="plugin-fw-wc-reset" method="post">
            <?php $warning = __( 'If you continue with this action, you will reset all options in this page.', 'smms-plugin-fw' ) ?>
            <input type="hidden" name="smm-action" value="wc-options-reset"/>
            <?php wp_nonce_field( 'smms_wc_reset_options_' . $this->settings[ 'page' ], 'smms_wc_reset_options_nonce' ); ?>
            <input type="submit" name="smm-reset" class="button-secondary" value="<?php _e( 'Reset Defaults', 'smms-plugin-fw' ) ?>"
                   onclick="return confirm('<?php _e( $warning ). '\n' . __( 'Are you sure?', 'smms-plugin-fw' ) ?>');"/>
        </form>
    </div>
    <?php do_action( 'smm_framework_after_print_wc_panel_content', $current_tab ); ?>
</div>