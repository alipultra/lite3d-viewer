<?php
class LITE3D_Utility
{
  public static function count_assets($status)
  {
    global $wpdb;
    $lite3d_table = LITE3D_TBL_ASSETS;

    // Sanitize input
    $status = sanitize_text_field($status);

    // Prepare the SQL statement
    $query = $wpdb->prepare("SELECT COUNT(*) FROM $lite3d_table WHERE status = %s", $status);
    $get_assets_status = $wpdb->get_var($query);

    return $get_assets_status;
  }

  public static function get_total_assets()
  {
      global $wpdb;
      $lite3d_table = LITE3D_TBL_ASSETS;

      $lite3d_count = $wpdb->get_var("SELECT COUNT(*) FROM $lite3d_table");
      return $lite3d_count;
  }
}