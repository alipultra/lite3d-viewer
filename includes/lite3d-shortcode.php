<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die();
}

class LITE3D_Shortcode {
  /**
   * Initialize the class and hooks.
  */
  public function __construct() {
      // Register shortcode.
      add_shortcode('lite3d_viewer', [$this, 'render_shortcode']);
  }
  /**
   * Render the shortcode.
   *
   * @return string
   */
  public function render_shortcode($post) {
    if(!empty($post)) {
      global $wpdb;
      $html = '';
      $args = array('post_type'=>'lite3d-viewer','p'=>$post['id']);
      $wp_posts = new WP_Query($args);
      $posts = $wp_posts->posts;
      $value = get_post_meta( $posts[0]->ID, '_lite3d_viewer', true );
      
      $html.= '<div id="lite3d-viewer-'. __($posts[0]->ID).'" data-cid="'. __($posts[0]->ID).'" data-url="'. __($value['url']).'" style="width: 50vw; height: 50vw;"></div>';
      return $html;
    } else {
        // Output the form.
      return 'Please enter correct shortcode';    
    }
  }
}

new LITE3D_Shortcode();