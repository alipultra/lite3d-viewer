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
    echo 'Here goes the metabox content…';
  }
}

new LITE3D_Product_Meta_Box();