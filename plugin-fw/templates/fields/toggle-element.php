<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//delete_option('ywraq_toggle_element');
$defaults = array(
	'id'                => '',
	'add_button'        => '',
	'name'              => '',
	'class'             => '',
	'custom_attributes' => '',
	'elements'          => array(),
	'title'             => '',
	'subtitle'          => '',
	'onoff_field'       => array(),
	//is an array to print a onoff field, if need to call an ajax action, add  'ajax_action' => 'myaction' in the array args,
	'sortable'         => false,
	'save_button'       => array(),
	'delete_button'     => array()

);
$field = wp_parse_args( $field, $defaults );

extract( $field );

$show_add_button = isset( $add_button ) && $add_button;
$add_button_closed = isset( $add_button_closed ) ? $add_button_closed : '';
$values          = isset( $value ) ? $value : get_option( $name, array() );
$values          = maybe_unserialize( $values );
$sortable        = isset( $sortable ) ? $sortable : false;
$class_wrapper   = $sortable ? 'ui-sortable' : '';
$onoff_id        = isset( $onoff_field['id'] ) ? $onoff_field['id'] : '';

if ( empty( $values ) && ! $show_add_button && $elements ) {
    $values = array();
	//populate a toggle element with the default
	foreach ( $elements as $element ) {
		$values[0][ $element['id'] ] = $element['default'];
	}
}

?>
<div class="smms-toggle_wrapper <?php _e( $class_wrapper) ?>" id="<?php _e( $id) ?>">
	<?php

	if ( $show_add_button ):

		?>
        <button class="smms-add-button smms-add-box-button"
                data-box_id="<?php _e( $id) ?>_add_box"
                data-closed_label="<?php _e( esc_attr( $add_button_closed )) ?>"
                data-opened_label="<?php _e( esc_attr( $add_button )) ?>"><?php _e( $add_button) ?></button>
        <div id="<?php _e( $id) ?>_add_box" class="smms-add-box">
        </div>
        <script type="text/template" id="tmpl-smms-toggle-element-add-box-content-<?php _e( $id) ?>">
			<?php foreach ( $elements as $element ):
				$element['title'] = $element['name'];

				$element['type'] = isset( $element['smms-type'] ) ? $element['smms-type'] : $element['type'];
				unset( $element['smms-type'] );
				$element['value'] =  isset($element['default']) ? $element['default'] : '';
				$element['id'] = 'new_'.$element['id'];
				$element['name'] = $name. "[{{{data.index}}}][" . $element['id'] . "]";
				$class_element = isset(  $element['class'] ) ? $element['class'] : '';
				?>
                <div class="smms-add-box-row <?php _e( $class_element) ?> <?php _e( '{{{data.index}}}')?>">

                    <label for="<?php  _e( $element['id']) ?>"><?php _e ( $element['title'] ) ?></label>
                    <div class="smms-plugin-fw-option-with-description">
					<?php
					_e( smms_plugin_fw_get_field( $element, true )) ?>
                    <span class="description"><?php _e( ! empty( $element['desc'] ) ? $element['desc'] : '') ?></span>
                    </div>
                </div>
			<?php endforeach; ?>

            <div class="smms-add-box-buttons">
                <button class="button-primary smms-save-button">
					<?php _e( $save_button['name'] )?>
                </button>
            </div>
        </script>
	<?php endif; ?>

    <div class="smms-toggle-elements">
		<?php
        if ($values ):
		//print toggle elements
		foreach ( $values as $i => $value ):
			$title_element = smms_format_toggle_title( $title, $value );
			$title_element = apply_filters( 'smms_plugin_fw_toggle_element_title_' . $id, $title_element, $elements, $value );
			$subtitle_element = smms_format_toggle_title( $subtitle, $value );
			$subtitle_element = apply_filters( 'smms_plugin_fw_toggle_element_subtitle_' . $id, $subtitle_element, $elements, $value );
			?>

            <div id="<?php _e( $id) ?>_<?php _e( $i) ?>"
                 class="smms-toggle-row <?php _e( ! empty( $subtitle ) ? 'with-subtitle' : '') ?> <?php _e($class) ?>" <?php _e( $custom_attributes) ?>
                 data-item_key="<?php _e( esc_attr( $i )) ?>">
                <div class="smms-toggle-title">
                    <h3>
                    <span class="title"
                          data-title_format="<?php _e(esc_attr( $title ) )?>"><?php _e( $title_element) ?></span>
						<?php if ( ! empty( $subtitle_element ) ): ?>
                            <div class="subtitle"
                                 data-subtitle_format="<?php _e(esc_attr( $subtitle )) ?>"><?php _e( $subtitle_element) ?></div>
						<?php endif; ?>
                    </h3>
                    <span class="smms-toggle">
            <span class="smms-icon smms-icon-arrow_right ui-sortable-handle"></span>
        </span>
					<?php
					if ( ! empty( $onoff_field ) && is_array( $onoff_field ) ):
						$action = ! empty( $onoff_field['ajax_action'] ) ? 'data-ajax_action="' . $onoff_field['ajax_action'] . '"' : '';
						$onoff_field['value'] = isset( $value[ $onoff_id  ] ) ? $value[ $onoff_id  ] : $onoff_field['default'];
						$onoff_field['type'] = 'onoff';
						$onoff_field['name'] = $name. "[$i][" . $onoff_id . "]";
						$onoff_field['id'] = $onoff_id.'_'.$i;
						unset( $onoff_field['smms-type'] );
						?>
                        <span class="smms-toggle-onoff" <?php _e($action)?> >
                    <?php
                    _e( smms_plugin_fw_get_field( $onoff_field, true ));
                    ?>
                </span>

						<?php if ( $sortable ): ?>
                        <span class="smms-icon smms-icon-drag"></span>
					<?php endif ?>

					<?php endif; ?>
                </div>
                <div class="smms-toggle-content">
					<?php
					if ( $elements && count( $elements ) > 0 ) {
						foreach ( $elements as $element ):
							$element['type'] = isset( $element['smms-type'] ) ? $element['smms-type'] : $element['type'];
							unset( $element['smms-type'] );
							$element['title'] = $element['name'];
							$element['name']  = $name . "[$i][" . $element['id'] . "]";
							$element['value'] = isset( $value[ $element['id'] ] ) ? $value[ $element['id'] ] : $element['default'];
							$element['id'] = $element['id'].'_'.$i;
							$element['class'] = isset(  $element['class'] ) ? $element['class'] : '';
							?>
                            <div class="smms-toggle-content-row <?php _e( $element['class'].' '.$element['type']) ?>">
                                <label for="<?php _e( $element['id']) ?>"><?php _e( $element['title']) ?></label>
                                <div class="smms-plugin-fw-option-with-description">
								<?php _e( smms_plugin_fw_get_field( $element, true )) ?>
                                <span class="description"><?php _e( ! empty( $element['desc'] ) ? $element['desc'] : '') ?></span>
                                </div>
                            </div>
						<?php endforeach;
					}
					?>
                    <div class="smms-toggle-content-buttons">
                        <div class="spinner"></div>
		                <?php
		                if ( $save_button && ! empty( $save_button['id'] ) ):
			                $save_button_class = isset( $save_button['class'] ) ? $save_button['class'] : '';
			                $save_button_name = isset( $save_button['name'] ) ? $save_button['name'] : '';
			                ?>
                            <button id="<?php _e( $save_button['id']) ?>"
                                    class="smms-save-button <?php _e( $save_button_class)?>">
				                <?php _e( $save_button_name) ?>
                            </button>
		                <?php endif; ?>
		                <?php
		                if ( $delete_button && ! empty( $delete_button['id'] ) ):
			                $delete_button_class = isset( $delete_button['class'] ) ? $delete_button['class'] : '';
			                $delete_button_name = isset( $delete_button['name'] ) ? $delete_button['name'] : '';
			                ?>
                            <button id="<?php _e( $delete_button['id']) ?>"
                                    class="button-secondary smms-delete-button <?php _e($delete_button_class) ?>">
				                <?php _e( $delete_button_name) ?>
                            </button>
		                <?php endif; ?>
                    </div>
                </div>

            </div>
		<?php endforeach;
		endif;
		?>


    </div>
    <!-- Schedule Item template -->
    <script type="text/template" id="tmpl-smms-toggle-element-item-<?php _e( $id )?>">
        <div id="<?php _e( $id) ?>_{{{data.index}}}"
             class="smms-toggle-row  highlight <?php _e( ! empty( $subtitle ) ? 'with-subtitle' : '') ?> <?php _e( $class) ?>"
             data-item_key="{{{data.index}}}" <?php _e( $custom_attributes)?>
             data-item_key="{{{data.index}}}">
            <div class="smms-toggle-title">
                <h3>
                    <span class="title" data-title_format="<?php _e( esc_attr( $title ) )?>"><?php _e( $title) ?></span>

                        <div class="subtitle"
                             data-subtitle_format="<?php _e( esc_attr( $subtitle )) ?>"><?php _e( $subtitle) ?></div>

                </h3>
                <span class="smms-toggle">
            <span class="smms-icon smms-icon-arrow_right"></span>
        </span>
				<?php
				if ( ! empty( $onoff_field ) && is_array( $onoff_field ) ):
					$action = ! empty( $onoff_field['ajax_action'] ) ? 'data-ajax_action="' . $onoff_field['ajax_action'] . '"' : '';
					$onoff_field['value'] = $onoff_field['default'];
					$onoff_field['type'] = 'onoff';
					$onoff_field['name'] = $name . "[{{{data.index}}}][" . $onoff_id . "]";
					$onoff_field['id'] = $onoff_id;
					unset( $onoff_field['smms-type'] );
					?>
                    <span class="smms-toggle-onoff" <?php _e( $action) ?> >
                    <?php
                    _e( smms_plugin_fw_get_field( $onoff_field, true ));
                    ?>
                </span>

				<?php endif; ?>
				<?php if ( $sortable ): ?>
                    <span class="smms-icon smms-icon-drag ui-sortable-handle"></span>
				<?php endif ?>
            </div>
            <div class="smms-toggle-content">
				<?php
				if ( $elements && count( $elements ) > 0 ) {
					foreach ( $elements as $element ):
						$element['type'] = isset( $element['smms-type'] ) ? $element['smms-type'] : $element['type'];
						unset( $element['smms-type'] );
						$element['title'] = $element['name'];
						$element['name']  = $name . "[{{{data.index}}}][" . $element['id'] . "]";
						$element['id']    = $element['id'] . '_{{{data.index}}}';
						$class_element = isset( $element['class'] ) ? $element['class'] : '';
						?>
                        <div class="smms-toggle-content-row <?php _e( $class_element.' '.$element['type']) ?>">
                            <label for="<?php _e( $element['id'])?>"><?php _e( $element['title']) ?></label>
                            <div class="smms-plugin-fw-option-with-description">
                            <?php _e( smms_plugin_fw_get_field( $element, true )) ?>
                            <span class="description"><?php _e( ! empty( $element['desc'] ) ? $element['desc'] : '') ?></span>
                            </div>
                        </div>
					<?php endforeach;
				}
				?>
                <div class="smms-toggle-content-buttons">
                    <div class="spinner"></div>
	                <?php
	                if ( $save_button && ! empty( $save_button['id'] ) ):
		                $save_button_class = isset( $save_button['class'] ) ? $save_button['class'] : '';
		                $save_button_name = isset( $save_button['name'] ) ? $save_button['name'] : '';
		                ?>
                        <button id="<?php _e( $save_button['id']) ?>"
                                class="smms-save-button <?php _e( $save_button_class) ?>">
			                <?php _e( $save_button_name) ?>
                        </button>
	                <?php endif; ?>
					<?php
					if ( $delete_button && ! empty( $delete_button['id'] ) ):
						$delete_button_class = isset( $delete_button['class'] ) ? $delete_button['class'] : '';
						$delete_button_name = isset( $delete_button['name'] ) ? $delete_button['name'] : '';
                        ?>
                        <button id="<?php _e( $delete_button['id']) ?>"
                                class="button-secondary smms-delete-button <?php _e( $delete_button_class) ?>">
							<?php _e( $delete_button_name) ?>
                        </button>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </script>

</div>