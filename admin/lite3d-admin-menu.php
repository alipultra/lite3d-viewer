<?php

if (!defined('WPINC')) {
    die;
}

class LITE3D_Plugin
{
  // class instance
  static        $instance;
  protected     $post_type = 'lite3d-viewer';

  // class constructor
  public function __construct()
  {
    add_action('admin_menu', [$this, 'lite3d_add_admin_menu']);
  }

  public function lite3d_add_admin_menu()
  {
    
    add_submenu_page(
      'edit.php?post_type='.$this->post_type,
      __( 'Settings', 'lite3d-viewer' ),
      __( 'Settings', 'lite3d-viewer' ),
      LITE3D_MANAGEMENT_PERMISSION,
      'lite3d_settings',
      'lite3d_settings_menu',
    );
    add_submenu_page(
      'edit.php?post_type='.$this->post_type, 
      __('About', 'lite3d-viewer'), 
      __('About', 'lite3d-viewer'), 
      LITE3D_MANAGEMENT_PERMISSION, 
      'lite3d_about', 
      'lite3d_about_menu'
    );
  }

  /** Singleton instance */
  public static function get_instance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }

    return self::$instance;
  }
}

add_action('plugins_loaded', function () {
  LITE3D_Plugin::get_instance();
});
