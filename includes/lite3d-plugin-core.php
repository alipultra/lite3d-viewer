<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die();
}

/**
 *
 * @package   LITE3D Viewer
 * @author    Alip Putra
 * @license   GPL-2.0+
 * @link      http://alipultra.com
 */

require_once(LITE3D_LIB . 'lite3d-scripts.php');
require_once(LITE3D_LIB . 'lite3d-post-type.php');
require_once(LITE3D_LIB . 'lite3d-shortcode.php');

 // Admin-only includes
if (is_admin()) {
  require_once LITE3D_ADMIN . 'lite3d-admin-init.php';
}
