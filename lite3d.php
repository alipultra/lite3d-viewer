<?php
/**
 * Plugin Name: Lite3d Viewer
 * Plugin URI: https://github.com/alipultra/lite3d-viewer
 * Description: Lite3d Viewer
 * Version: 0.1
 * Text Domain: lite3d-viewer
 * Author: Alip Putra
 * Author URI: https://alipultra.com
 */

if (!defined('ABSPATH')) {
  exit; // Secure the plugin by blocking direct access
}

// Load plugin textdomain for multilingual support
function lite3d_viewer_load_textdomain() {
  load_plugin_textdomain('lite3d-viewer', false, dirname(plugin_basename(__FILE__)) . '/i18n/languages');
}
add_action('plugins_loaded', 'lite3d_viewer_load_textdomain');

define('LITE3D_PATH', plugin_dir_path(__FILE__));
define('LITE3D_URL', plugins_url('', __FILE__));
define('LITE3D_ASSETS_URL', LITE3D_URL . '/public/assets/');
define('LITE3D_LIB', LITE3D_PATH . 'includes/');
define('LITE3D_ADMIN', LITE3D_PATH . 'admin/');

define('LITE3D_TEXT_DOMAIN', 'lite3d-viewer');
define('LITE3D_MANAGEMENT_PERMISSION', 'manage_options');
define('LITE3D_MAIN_MENU_SLUG', 'lite3d_overview');
define('LITE3D_MENU_ICON', 'dashicons-lock');

// Load core plugin functionalities
if (file_exists(LITE3D_LIB . 'lite3d-plugin-core.php')) {
  require_once LITE3D_LIB . 'lite3d-plugin-core.php';
}
