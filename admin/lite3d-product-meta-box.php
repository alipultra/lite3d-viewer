<?php

if (!defined('WPINC')) {
    die;
}

class LITE3D_Product_Meta_Box
{
  static        $instance;
  protected     $post_type = 'lite3d-viewer';

  function __construct()
  {
    add_action( 'add_meta_boxes', array($this, 'admin_product_lite3d_metabox') );
  }

  public function admin_product_lite3d_metabox() {
    
    add_meta_box( 
      'lite3d_product_meta', 
      __( '3D Settings', 'lite3d-viewer' ), 
      array($this, 'add_product_meta_box_content'), 
      'product',
      'normal',
      'high'
    );
  }

  public function add_product_meta_box_content() {
    wp_nonce_field( 'lite3d_product_nonce', 'lite3d_product_nonce' );
    ?>
    <div class="lite3d-meta-form">
    <div class="row">
        <div class="col-25">
          <h4 for="lite3d_meta_source">
            <?php esc_html_e('Source', 'lite3d-viewer'); ?>
          </h4>
          <div class="subtitle-text">
            <?php esc_html_e('Choose 3D Model', 'lite3d-viewer'); ?>
          </div>
        </div>
        <div class="col-75">
          <div class="lite3d-preview<?php echo esc_attr( $hidden_auto )?>">
            <div class="image-preview">
              <i class="lite3d-image-remove fas fa-times">x</i>
              <span>
                <img src="<?php echo esc_attr( $preview_src )?>" class="lite3d_meta_src" />
              </span>
            </div>
          </div>
          <div class="col-flex">
            <?php 
              echo sprintf(
                '<input %1$s />',
                LITE3D_Utility::format_atts( 
                  array(
                    'type' => 'hidden',
                    'id' => 'lite3d_meta_id',
                    'name' => 'lite3d_meta_id',
                    'value' => $meta['post_id'],
                  ) 
                )
              );
              echo sprintf(
                '<input %1$s />',
                LITE3D_Utility::format_atts( 
                  array(
                    'type' => 'hidden',
                    'id' => 'lite3d_meta_hash',
                    'name' => 'lite3d_meta_hash',
                    'value' => $meta['hash'],
                  ) 
                )
              );
              echo sprintf(
                '<input %1$s />',
                LITE3D_Utility::format_atts( 
                  array(
                    'type' => 'hidden',
                    'id' => 'lite3d_meta_thumbnail',
                    'name' => 'lite3d_meta_thumbnail',
                    'value' => $meta['thumbnail'],
                  ) 
                )
              );
              echo sprintf(
                '<input %1$s />',
                LITE3D_Utility::format_atts( 
                  array(
                    'type' => 'text',
                    'id' => 'lite3d_meta_url',
                    'name' => 'lite3d_meta_url',
                    'value' => $meta['url'],
                  ) 
                )
              );
              echo sprintf(
                '<input %1$s />',
                LITE3D_Utility::format_atts( 
                  array(
                    'type' => 'button',
                    'id' => 'lite3d_meta_upload_button',
                    'value' => 'Upload Source',
                  ) 
                )
              );
            ?>
          </div>  
          <div class="desc-text"><?php esc_html_e('Upload or Select 3d object files. Supported file type: glb, glTF', 'lite3d-viewer')?></div>
        </div>
      </div>
    </div>
    <?php
  }
}

new LITE3D_Product_Meta_Box();