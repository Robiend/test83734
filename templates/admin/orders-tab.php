<div class="wrap">
   
<?php ?> 
    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <?php
                        $this->cpt_obj_orders->prepare_items();
                        $this->cpt_obj_orders->display(); ?> 
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>