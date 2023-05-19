<?php
/**
 * This file belongs to the SMM Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Upload Plugin Admin View
 *
 * @package    SMMS
 * @author     sam softnwords
 * @since      1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
$hidden_val = get_option($id . "-smms-attachment-id", 0);

?>

<tr valign="top">
    <th scope="row" class="image_upload">
        <label for="<?php _e( $id )?>"><?php _e( $name )?></label>
    </th>
    <td class="forminp forminp-color plugin-option">

        <div id="<?php _e( $id )?>-container" class="smm_options rm_option rm_input rm_text rm_upload"
             <?php if (isset($option['deps'])): ?>data-field="<?php _e( $id) ?>"
             data-dep="<?php _e( $this->get_id_field($option['deps']['ids'])) ?>"
             data-value="<?php _e( $option['deps']['values']) ?>" <?php endif ?>>
            <div class="option">
                <input type="text" name="<?php _e( $id )?>" id="<?php _e( $id) ?>"
                       value="<?php _e( $value == '1' ? '' : esc_attr($value)) ?>" class="smms-plugin-fw-upload-img-url"/>
                <input type="hidden" name="<?php _e( $id )?>-smms-attachment-id" id="<?php _e( $id) ?>-smms-attachment-id" value="<?php _e( $hidden_val) ?>" />
                <input type="button" value="<?php _e('Upload', 'smms-plugin-fw') ?>" id="<?php _e( $id )?>-button"
                       class="smms-plugin-fw-upload-button button"/>
            </div>
            <div class="clear"></div>
            <span class="description"><?php _e( $desc) ?></span>

            <div class="smms-plugin-fw-upload-img-preview" style="margin-top:10px;">
                <?php
                $file = $value;
                if (preg_match('/(jpg|jpeg|png|gif|ico)$/', $file)) {
                    _e( "<img src=\"" . SMM_CORE_PLUGIN_URL) . "/assets/images/sleep.png\" data-src=\"$file\" />";
                }
                ?>
            </div>
        </div>


    </td>
</tr>

