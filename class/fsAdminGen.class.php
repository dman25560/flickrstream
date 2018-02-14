<?php

class fsAdminGen
{
  private static $_options;

  public static function initialize(&$options)
  {
    self::$_options = $options;
  }

  public static function deleteShortcodes($shortcodes)
  {
    foreach($shortcodes as $id)
    {
      if (!delete_option('flickrstream_short_' . $id))
        return false;
    }

    return true;
  }
}
?>
