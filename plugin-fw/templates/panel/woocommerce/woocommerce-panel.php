<?php add_thickbox();?>
<div class="wrap <?php _e( $wrap_class)?>">
    <div id="icon-users" class="icon32"><br/></div>
	<?php do_action('smms_plugin_fw_before_woocommerce_panel', $page )?>
    <?php if( ! empty( $available_tabs ) ): ?>
        <h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
            <?php foreach( $available_tabs as $id => $label ):
	            $active_class = ( $current_tab == $id ) ? ' nav-tab-active' : '';
	            $active_class .= 'premium' == $id ? ' smms-premium ': '';
                ?>
                <a href="?page=<?php _e( $page) ?>&tab=<?php _e( $id) ?>" class="nav-tab <?php _e( $active_class )?>"><?php _e( $label) ?></a>
            <?php endforeach; ?>
        </h2>
        <?php $this->print_panel_content() ?>
    <?php endif; ?>
</div>