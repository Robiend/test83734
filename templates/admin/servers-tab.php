<div class="wrap">
    <h1><?php _e('AVAILABLE API SERVERS', 'smm-api') ?></h1>
<?php $this->cpt_obj_servers->SmmServerform();?>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <?php
                        $this->cpt_obj_servers->prepare_items();
                        $this->cpt_obj_servers->display(); ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>