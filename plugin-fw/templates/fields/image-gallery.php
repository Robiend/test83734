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

extract( $field );
$array_id = array();
if ( !empty( $value ) ) {
    $array_id = array_filter( explode( ',', $value ) );
}
?>
<ul id="<?php _e( $id) ?>-extra-images" class="slides-wrapper extra-images ui-sortable clearfix">
    <?php if ( !empty( $array_id ) ) : ?>
        <?php foreach ( $array_id as $image_id ) : ?>
            <li class="image" data-attachment_id= <?php _e( esc_attr( $image_id )) ?>>
                <a href="#">
                    <?php
                    if ( function_exists( 'smm_image' ) ) :
                        smm_image( "id=$image_id&size=admin-post-type-thumbnails" );
                    else:
                        _e( wp_get_attachment_image( $image_id, array( 80, 80 ) ));
                    endif; ?>
                </a>
                <ul class="actions">
                    <li><a href="#" class="delete" title="<?php _e( 'Delete image', 'smms-plugin-fw' ); ?>">x</a></li>
                </ul>
            </li>
        <?php endforeach; endif; ?>
</ul>
<input type="button" data-choose="<?php _e( 'Add Images to Gallery', 'smms-plugin-fw' ); ?>" data-update="<?php _e( 'Add to gallery', 'smms-plugin-fw' ); ?>" value="<?php _e( 'Add images', 'smms-plugin-fw' ) ?>" data-delete="<?php _e( 'Delete image', 'smms-plugin-fw' ); ?>" data-text="<?php _e( 'Delete', 'smms-plugin-fw' ) ?>" id="<?php _e( $id) ?>-button" class="image-gallery-button button"/>
<input type="hidden" class="image_gallery_ids" id="image_gallery_ids" name="<?php _e( $name) ?>" value="<?php _e( esc_attr( $value )) ?>"/>
