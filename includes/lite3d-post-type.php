<?php

class LITE3D_Post_Type {
  protected $post_type = 'lite3d-viewer';

  public function __construct() {
    add_action('init', [$this, 'init_post_type']);

    if ( is_admin() ) {
      add_action( 'manage_'.$this->post_type.'_posts_custom_column', [$this, 'addShortcodeColumn'], 10, 2);
      add_action( 'manage_'.$this->post_type.'_posts_columns', [$this, 'addShortcodeColumnContent'], 10, 2);
      add_action( 'admin_head-post.php', [$this, 'hide_publishing_actions'] );
      add_action( 'admin_head-post-new.php', [$this, 'hide_publishing_actions'] );
      add_filter( 'gettext', [$this, 'change_publish_button'], 10, 2 );
      add_action( 'edit_form_after_title', [$this, 'bp3d_shortcode_area'] );
      add_filter( 'post_row_actions', [$this, 'remove_row_actions'], 10, 2 );
    }
  }

  public function init_post_type() {
    $labels = array(
      'name'                  => __( 'Lite3D Viewer', 'lite3d-viewer' ),
      'menu_name'             => __( 'Lite3D Viewer', 'lite3d-viewer' ),
      'name_admin_bar'        => __( 'Lite3D Viewer', 'lite3d-viewer' ),
      'add_new'               => __( 'Add New', 'lite3d-viewer' ),
      'add_new_item'          => __( 'Add New', 'lite3d-viewer' ),
      'new_item'              => __( 'New 3D', 'lite3d-viewer' ),
      'edit_item'             => __( 'Edit 3D', 'lite3d-viewer' ),
      'view_item'             => __( 'View 3D', 'lite3d-viewer' ),
      'all_items'             => __( 'All 3D', 'lite3d-viewer' ),
      'not_found'             => __( 'No 3D found.', 'lite3d-viewer' ),
    );
  
    $args = array(
      'labels'             => $labels,
      'description'        => __( 'Lite 3D Viewer Options.', 'lite3d-viewer' ),
      'public'             => false,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'menu_icon'          => 'dashicons-editor-contract',
      'query_var'          => true,
      'rewrite'            => array( 'slug' => 'lite3d-viewer' ),
      'capability_type'    => 'post',
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_position'      => 10,
      'supports'           => array( 'title' ),
      'show_in_rest'       => true,
    );
  
    register_post_type( $this->post_type, $args );
  }

  public function addShortcodeColumnContent($defaults){
    unset($defaults['date']);
    $defaults['shortcode'] = 'ShortCode';
    $defaults['date'] = 'Date';
    return $defaults;
  }		

  public function addShortcodeColumn($column_name, $post_ID){
    global $post;
    
    $shortcode = LITE3D_Utility::shortcode_format( $post->ID );
    if ($column_name === 'shortcode' &&  isset($shortcode)) {
      echo sprintf(
        '<span class="lite3d_column shortcode wp-ui-highlight"><input %1$s /></span>',
        LITE3D_Utility::format_atts( 
          array(
            'type' => 'text',
            'id' => 'lite3d-viewer-shortcode',
            'onfocus' => 'this.select();',
            'readonly' => true,
            'class' => 'large-text code',
            'value' => $shortcode,
          ) 
        )
      );
    }
  }

  public function hide_publishing_actions() {
    global $post ;
    if ( $post->post_type == $this->post_type ) {
      echo  ' <style type="text/css">
              #misc-publishing-actions,
              #minor-publishing-actions{
                  display:none;
              } </style> ' ;
    }
  }

  public function change_publish_button( $translation, $text ) {
    if ( $this->post_type == get_post_type() ) {
      if ( $text == 'Publish' ) {
        return 'Save';
      }
    }
      
    return $translation;
  }

  public function bp3d_shortcode_area() {
    global $post;

    $shortcode = LITE3D_Utility::shortcode_format( $post->ID );
    if ( $post->post_type == 'lite3d-viewer' &&  isset($shortcode)) {
    ?>
      <div class="inside">
         <?php
         echo sprintf(
          '<p class="description"><label for="lite3d-viewer-shortcode">%1$s</label> <span class="shortcode wp-ui-highlight"><input %2$s /></span></p>',
          esc_html( __( "Copy this shortcode and paste it into your post, page, or text widget content:", 'contact-form-7' ) ),
          LITE3D_Utility::format_atts( 
            array(
              'type' => 'text',
              'id' => 'lite3d-viewer-shortcode',
              'onfocus' => 'this.select();',
              'readonly' => true,
              'class' => 'large-text code',
              'value' => $shortcode,
            ) 
          )
        );
         ?>
      </div>
    <?php 
    }
  }

  public function remove_row_actions( $idtions ) {
    global  $post;
    if ( $post->post_type == 'lite3d-viewer' ) {
      unset( $idtions['view'] );
      unset( $idtions['inline hide-if-no-js'] );
    }
    return $idtions;
  }
}


new LITE3D_Post_Type();