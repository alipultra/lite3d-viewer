<?php

if (!defined('WPINC')) {
    die;
}

class LITE3D_Meta_Box
{
  static        $instance;
  protected     $post_type = 'lite3d-viewer';

  function __construct()
  {
    add_action( 'add_meta_boxes', array($this, 'lite3d_register_meta_boxes') );
    add_action( 'save_post', array($this, 'save_lite3d_meta_box_data' ) );
  }

  public function lite3d_register_meta_boxes() {
    
    add_meta_box( 'lite3d_viewer', __( '3D Settings', 'lite3d-viewer' ), array($this, 'add_meta_box_content'), 'lite3d-viewer' );
  }

  public function add_meta_box_content( $post ) {
    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'lite3d_viewer_nonce', 'lite3d_viewer_nonce' );
    $preview_size = 'thumbnail';
    $units = array( 'px', '%', 'em' );
    $switch =  array( 
      1 => 'Yes',
      0 => 'No' 
    );

    // Generate meta value
    $meta = $this->generate_meta_value();

    $preview_src = ( $preview_size !== 'thumbnail' ) ? $meta['url'] : $meta['thumbnail'];
    $hidden_auto = (empty( $meta['url'] )) ? ' hidden' : '';
    ?>
    <div class="lite3d-meta-form">
      <div class="row">
        <div class="col-25">
          <h4 for="lite3d_meta_width">
            <?php esc_html_e('Width', 'lite3d-viewer'); ?>
          </h4>
          <div class="subtitle-text">
            <?php esc_html_e('3D Viewer Width', 'lite3d-viewer'); ?>
          </div>
        </div>
        <div class="col-75 col-flex">
          <?php
            echo sprintf(
              '<input %1$s />',
              LITE3D_Utility::format_atts( 
                array(
                  'type' => 'number',
                  'id' => 'lite3d_meta_width',
                  'name' => 'lite3d_meta_width',
                  'value' => $meta['lite3d_width']['width'],
                ) 
              )
            );
            $option = '';
            foreach ( $units as $unit ) {
              $selected = ( $meta['lite3d_width']['unit'] === $unit ) ? ' selected' : '';
              $option_atts = array(
                'value' => $unit,
                'selected' => $selected,
              );

              $option .= sprintf(
                '<option %1$s>%2$s</option>',
                LITE3D_Utility::format_atts( $option_atts ),
                esc_html( $unit )
              );
            }

            echo sprintf(
              '<select %1$s>%2$s</select>',
              LITE3D_Utility::format_atts( 
                array(
                  'id' => 'lite3d_meta_width_unit',
                  'name' => 'lite3d_meta_width_unit',
                ) 
              ),
              $option
            );
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <h4 for="lite3d_meta_height">
            <?php esc_html_e('Height', 'lite3d-viewer'); ?>
          </h4>
          <div class="subtitle-text">
            <?php esc_html_e('3D Viewer Height', 'lite3d-viewer'); ?>
          </div>
        </div>
        <div class="col-75 col-flex">
          <?php
            echo sprintf(
              '<input %1$s />',
              LITE3D_Utility::format_atts( 
                array(
                  'type' => 'number',
                  'id' => 'lite3d_meta_height',
                  'name' => 'lite3d_meta_height',
                  'value' => $meta['lite3d_height']['height'],
                ) 
              )
            );
            $option = '';
            foreach ( $units as $unit ) {
              $selected = ( $meta['lite3d_height']['unit'] === $unit ) ? ' selected' : '';
              $option_atts = array(
                'value' => $unit,
                'selected' => $selected,
              );

              $option .= sprintf(
                '<option %1$s>%2$s</option>',
                LITE3D_Utility::format_atts( $option_atts ),
                esc_html( $unit )
              );
            }

            echo sprintf(
              '<select %1$s>%2$s</select>',
              LITE3D_Utility::format_atts( 
                array(
                  'id' => 'lite3d_meta_height_unit',
                  'name' => 'lite3d_meta_height_unit',
                ) 
              ),
              $option
            );
          ?>
        </div>
      </div>
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
      <div class="row">
        <div class="col-25">
          <h4 for="lite3d_meta_height">
            <?php esc_html_e('Moving Controls', 'lite3d-viewer'); ?>
          </h4>
          <div class="subtitle-text">
            <?php esc_html_e('Use The Moving controls to enable user interaction', 'lite3d-viewer'); ?>
          </div>
        </div>
        <div class="col-75 col-flex">
          <?php
            $option = '';
            foreach ( $switch as $key => $value ) {
              $selected = ( (int) $meta['controls'] === $key ) ? ' selected' : '';
              $option_atts = array(
                'value' => $key,
                'selected' => $selected,
              );

              $option .= sprintf(
                '<option %1$s>%2$s</option>',
                LITE3D_Utility::format_atts( $option_atts ),
                esc_html( $value )
              );
            }

            echo sprintf(
              '<select %1$s>%2$s</select>',
              LITE3D_Utility::format_atts( 
                array(
                  'id' => 'lite3d_meta_controls',
                  'name' => 'lite3d_meta_controls',
                ) 
              ),
              $option
            );
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <h4 for="lite3d_meta_height">
            <?php esc_html_e('Enable Zoom', 'lite3d-viewer'); ?>
          </h4>
          <div class="subtitle-text">
            <?php esc_html_e('Enable or Disable Zooming Behaviour', 'lite3d-viewer'); ?>
          </div>
        </div>
        <div class="col-75 col-flex">
          <?php
            $option = '';
            foreach ( $switch as $key => $value ) {
              $selected = ( (int) $meta['zoom'] === $key ) ? ' selected' : '';
              $option_atts = array(
                'value' => $key,
                'selected' => $selected,
              );

              $option .= sprintf(
                '<option %1$s>%2$s</option>',
                LITE3D_Utility::format_atts( $option_atts ),
                esc_html( $value )
              );
            }

            echo sprintf(
              '<select %1$s>%2$s</select>',
              LITE3D_Utility::format_atts( 
                array(
                  'id' => 'lite3d_meta_zoom',
                  'name' => 'lite3d_meta_zoom',
                ) 
              ),
              $option
            );
          ?>
        </div>
      </div>
    </div>
    <?php
  }

  function save_lite3d_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['lite3d_viewer_nonce'] ) ) {
      return;
    }

    if ( ! wp_verify_nonce( $_POST['lite3d_viewer_nonce'], 'lite3d_viewer_nonce' ) ) {
      return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }

    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
      }
    }
    else {
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
      }
    }

    // Sanitize user input.
    $width          = $_POST['lite3d_meta_width'];
    $unit_width     = $_POST['lite3d_meta_width_unit'];
    $height         = $_POST['lite3d_meta_height'];
    $unit_height    = $_POST['lite3d_meta_height_unit'];
    $controls       = $_POST['lite3d_meta_controls'];
    $zoom           = $_POST['lite3d_meta_zoom'];
    $url            = $_POST['lite3d_meta_url'];
    $thumbnail      = sanitize_text_field( $_POST['lite3d_meta_thumbnail'] );
    $id             = sanitize_text_field( $_POST['lite3d_meta_id'] );
    $hash           = sanitize_text_field( $_POST['lite3d_meta_hash'] );

    // Set Meta value
    $lite3d_meta_data = $this->set_meta_value($width, $unit_width, $height,$unit_height, $zoom, $controls, $id, $hash, $url, $thumbnail);

    // Update the meta field in the database.
    update_post_meta( $post_id, '_lite3d_viewer', $lite3d_meta_data );
  }

  /** Set Meta value function */
  private function set_meta_value( $width = 100, $unit_width = '%', 
    $height = 100, $unit_height = 'px', $zoom = 1, $controls = 1, $id = null, $hash = null, $url = null, $thumbnail = null) {
    return array(
      'lite3d_width' => array(
        'width'     => $width,
        'unit'      => $unit_width,
      ),
      'lite3d_height' => array(
        'height' => $height,
        'unit' => $unit_height,
      ),
      'controls' => $controls,
      'zoom' => $zoom,
      'thumbnail' => $thumbnail,
      'url' => $url,
      'post_id' => (isset($id)) ? $id : get_the_ID(),
      'hash' => (isset($hash)) ? $hash : LITE3D_Utility::generate_hash(get_the_ID())
    ); 
  }

  /** Generate meta value function */
  private function generate_meta_value ( ) {
    $metas = get_post_meta( get_the_ID(), '_lite3d_viewer', true );

    if (empty($metas)) {
      return $this->set_meta_value();
    }
    return $metas;
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

LITE3D_Meta_Box::get_instance();