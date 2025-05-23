/**
 *
 * -----------------------------------------------------------
 *
 * Lite3D Viewer
 * A Simple and Lightweight WordPress 3D Viewer
 *
 * -----------------------------------------------------------
 *
 */
;(function( $, window, document, undefined ) {
  'use strict';
  
  $.fn.reload_media_frame = function( options ) {
    var $library; 
    var wp_media_frame;

    
      
    $('#lite3d_meta_upload_button').click(function(e) {
      e.preventDefault();
      if ( typeof window.wp === 'undefined' || ! window.wp.media || ! window.wp.media.gallery ) {
        return;
      }

      if ( wp_media_frame ) {
        wp_media_frame.open();
        return;
      }

      wp_media_frame = window.wp.media({
        library: {
          type: $library
        }
      });

      wp_media_frame.on( 'select', function() {
        var thumbnail;
        var attributes = wp_media_frame.state().get('selection').first().attributes;

        thumbnail = attributes.icon;
        $(".lite3d-preview").removeClass('hidden');
        $(".lite3d_meta_src").attr('src', thumbnail);
        $("#lite3d_meta_thumbnail").val(thumbnail);
        $("#lite3d_meta_url").val(attributes.url).trigger('change');
      });

      wp_media_frame.open();
    });
  }

  $.fn.reload_color_picker = function() {
    return this.each( function() {
      var $input        = $(this);
      var color = $input.val();


      $input.wpColorPicker();
    });
  }

  $(document).ready( function() {
    $('.lite3d-meta-form').reload_media_frame();
    $('.lite3d_meta_background').reload_color_picker();
  });
    
})( jQuery, window, document );