<?php

// Prevent direct access to the file
if (!defined('WPINC')) {
    die;
}

/**
 * Display the About menu
 */
function lite3d_about_menu()
{
?>
  <div class="wrap">
    <h1>
      <?php esc_html_e('Lite 3D Viewer - About', 'lite3d-viewer'); ?>
    </h1>

    <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">
        <div id="post-body-content">
          <div class="postbox">
            <h2 class="hndle"><?php esc_html_e('Credits and Authors', 'lite3d-viewer'); ?></h2>
            <div class="inside">
              <p><?php esc_html_e('Lite3D Viewer', 'lite3d-viewer'); ?></p>
              <table class="widefat fixed striped lite3d-about-table">
                <thead>
                  <tr>
                    <th><?php esc_html_e('Information', 'lite3d-viewer'); ?></th>
                    <th><?php esc_html_e('Details', 'lite3d-viewer'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php esc_html_e('Authors', 'lite3d-viewer'); ?></td>
                    <td>
                      <?php 
                        echo LITE3D_Utility::link(
                          __( 'https://github.com/alipultra', 'lite3d-viewer' ),
                          __( 'Alipultra', 'lite3d-viewer' ),
                          array(
                            'target' => '_blank',
                            'rel' => 'nofollow noopener',
                          )
                        );
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td><?php esc_html_e('Help and Support', 'lite3d-viewer'); ?></td>
                    <td>
                      <?php 
                        echo LITE3D_Utility::link(
                          __( 'https://github.com/alipultra/lite3d-Viewer/issues', 'lite3d-viewer' ),
                          __( 'Submit a request', 'lite3d-viewer' ),
                          array(
                            'target' => '_blank',
                            'rel' => 'nofollow noopener',
                          )
                        );
                      ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div> <!-- end postbox -->
        </div> <!-- end post-body-content -->
      </div> <!-- end post-body -->
    </div> <!-- end poststuff -->
  </div>
<?php
}
