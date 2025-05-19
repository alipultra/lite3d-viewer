<?php
class LITE3D_Utility
{
  private static function hash( $hash, $length = 7 ) {
		return substr( $hash, 0, absint( $length ) );
	}

  public static function shortcode_format ( $post_id )
  {
    $post = get_post_meta( $post_id, '_lite3d_viewer', true );
    
    if (isset($post['hash'])) {
      return sprintf(
        '[lite3d-viewer id="%1$s"]',
        $post['hash']
      );
    }
  }

  public static function generate_hash($post_id) {
    $hash = sha1( implode( '|', array(
      get_current_user_id(),
      $post_id,
      time(),
      home_url(),
    ) ) );
    return self::hash($hash);
  }

  public static function format_atts( $atts )
  {
    $atts_filtered = array();
  
    foreach ( $atts as $name => $value ) {
      $name = strtolower( trim( $name ) );
  
      if ( ! preg_match( '/^[a-z_:][a-z_:.0-9-]*$/', $name ) ) {
        continue;
      }
  
      static $boolean_attributes = array(
        'checked',
        'disabled',
        'inert',
        'multiple',
        'readonly',
        'required',
        'selected',
      );
  
      if ( in_array( $name, $boolean_attributes, true ) and '' === $value ) {
        $value = false;
      }
  
      if ( is_numeric( $value ) ) {
        $value = (string) $value;
      }
  
      if ( null === $value or false === $value ) {
        unset( $atts_filtered[$name] );
      } elseif ( true === $value ) {
        $atts_filtered[$name] = $name; // boolean attribute
      } elseif ( is_string( $value ) ) {
        $atts_filtered[$name] = trim( $value );
      }
    }
  
    $output = '';
  
    foreach ( $atts_filtered as $name => $value ) {
      $output .= sprintf( ' %1$s="%2$s"', $name, esc_attr( $value ) );
    }
  
    return trim( $output );
  }

  /**
 * Builds an HTML anchor element.
 *
 * @param string $url Link URL.
 * @param string $anchor_text Anchor label text.
 * @param string|array $atts Optional. HTML attributes.
 * @return string Formatted anchor element.
 */
  public static function link( $url, $anchor_text, $atts = '' ) {
    $atts = wp_parse_args( $atts, array(
      'id' => null,
      'class' => null,
    ) );

    $atts = array_merge( $atts, array(
      'href' => esc_url( $url ),
    ) );

    return sprintf(
      '<a %1$s>%2$s</a>',
      self::format_atts( $atts ),
      esc_html( $anchor_text )
    );
  }

  public static function default_meta() {
    return array(
      'lite3d_width' => array('width' => 100, 'unit' => '%'),
      'lite3d_height' => array('height' => 100, 'unit' => 'px'),
      'post_id' => get_the_ID(),
      'hash' => self::generate_hash($id),
      'url' => null,
      'thumbnail' => null
    );
    
  }
}