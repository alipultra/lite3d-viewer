<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die();
}

// Enqueue admin styles and scripts
function lite3d_admin_assets() {
    wp_enqueue_media();
    wp_enqueue_style('lite3d-admin-style', LITE3D_ASSETS_URL . 'css/lite3d-main.scss', array(), time(), 'all');
    wp_enqueue_script('lite3d-admin-js', LITE3D_ASSETS_URL . 'js/lite3d-main.js', array('jquery'), time(), true);
}
add_action('admin_enqueue_scripts', 'lite3d_admin_assets');

// Enqueue styles and scripts
function lite3d_assets() {
    wp_enqueue_style( 'lite3d-style', LITE3D_URL . "/dist/assets/index.css", array(), time(), 'all');
    wp_enqueue_script('lite3d-js', LITE3D_URL ."/dist/assets/index.js", array(), time(), true);
}

add_action('wp_enqueue_scripts' , 'lite3d_assets'); 