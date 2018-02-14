<?php

class fsAdminAjax
{
  private $_options;

  public function __construct($options)
  {
    require_once(dirname(__FILE__) . '/../class/fsAdminGen.class.php');

    $this->_options = $options;
    fsAdminGen::initialize($this->_options);

    add_action('wp_ajax_fs_deleteshortcode', array($this, 'deleteShortcode'));
  }

  //delete a gallery script//
  public function deleteShortcode()
  {
    check_ajax_referer('fs-delete-shortcode', 'nonce');

    $keys = array(sanitize_key($_POST['key']));

    if (fsAdminGen::deleteShortcodes($keys))
      echo 1;
    else
      echo 0;

    die();
  }
}
?>
