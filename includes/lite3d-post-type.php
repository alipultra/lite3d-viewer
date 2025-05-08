<?php

class LITE3D_Post_Type {
  protected $post_type = 'lite3d-viewer';

  public function __construct() {
    add_action('init', [$this, 'init_post_type']);

    if ( is_admin() ) {
      add_action( 'manage_'.$this->post_type.'_posts_custom_column', [$this, 'addShortcodeColumn'], 10, 2);
      add_action( 'manage_'.$this->post_type.'_posts_columns', [$this, 'addShortcodeColumnContent'],10,2);
      add_action( 'admin_head-post.php', [$this, 'hide_publishing_actions'] );
      add_action( 'admin_head-post-new.php', [$this, 'hide_publishing_actions'] );
      add_filter( 'gettext', [$this, 'change_publish_button'], 10, 2 );
      add_filter( 'post_row_actions', [$this, 'remove_row_actions'], 10, 2 );
    }
  }

  public function init_post_type() {
    $labels = array(
      'name'                  => _x( 'Lite3D Viewer', 'lite3d-viewer' ),
      'menu_name'             => _x( 'Lite3D Viewer', 'lite3d-viewer' ),
      'name_admin_bar'        => _x( 'Lite3D Viewer', 'lite3d-viewer' ),
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
      'menu_icon'          => 'dashicons-format-image',
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
    if ($column_name === 'shortcode') {
      echo "<div onclick='this.select()' class='lite3d_column_shortcode'><input value='[lite3d_viewer id=$post_ID]' ><span class='htooltip'>". esc_html__("Copy To Clipboard", "lite3d-viewer")."</span></div>";
    }
  }

  // HIDE everything in PUBLISH metabox except Move to Trash & PUBLISH button
  public function hide_publishing_actions() {
    global  $post ;
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

  // Hide & Disabled View, Quick Edit and Preview Button
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