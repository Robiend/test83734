<div class="wrap">
   
<?php $this->cpt_obj_items->smm_item_form();?> 
    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <?php
                        $this->cpt_obj_items->prepare_items();
                        $this->cpt_obj_items->display(); ?> 
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>