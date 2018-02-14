<?php

if (defined('WP_UNINSTALL_PLUGIN'))
{
  //multisite call
  if (function_exists('is_multisite') && is_multisite())
  {
    global $wpdb;
    $old_blog =  $wpdb->blogid;

    //Get all blog ids
    $blogids =  $wpdb->get_col('SELECT blog_id FROM ' .  $wpdb->blogs);

    foreach ($blogids as $blog_id)
    {
      switch_to_blog($blog_id);
      removePlugin();
    }

    switch_to_blog($old_blog);
  }

  //regular call
  removePlugin();
}

function removePlugin()
{
  global $wpdb;

  $opts = $wpdb->get_results('SELECT option_name FROM ' . $wpdb->prefix . 'options WHERE option_name LIKE "flickrstream_short_%"', ARRAY_A);

  foreach ($opts as $value)
    delete_option($value['option_name']);

  delete_option('flickrstream_main_opts');
  delete_option('widget_flickrstream_widget');
}
?>
