<?php
/**
* fsAdmin - Admin section for Flickr-stream
*
* @package Flickr-stream
* @author Dustin Scarberry
*
* @since 1.1.5
*/

if (!class_exists('fsAdmin'))
{
  class fsAdmin
  {
    private $_options, $_version, $_dirpath;

    public function __construct($version)
    {
      //set version
      $this->_version = $version;

      //set dirpath
      $this->_dirpath = dirname(__FILE__);

      //get plugin options
      $this->_options = get_option('flickrstream_main_opts');

      //add hooks
      add_action('admin_init', array($this, 'processor'));
      add_action('admin_enqueue_scripts', array($this, 'addScripts'));
      add_action('admin_enqueue_scripts', array($this, 'addStyles'));
      add_action('admin_menu', array($this, 'addMenus'));

      //ajax hooks
      require($this->_dirpath . '/inc/ajax.inc.php');
      $fsAdminAjax = new fsAdminAjax($this->_options);
    }

    public function addMenus()
    {
      add_menu_page('Flickr-stream', 'Flickr-Stream', 'manage_options', 'flickr-stream', array($this, 'shortcode_panel'), plugins_url('flickr-stream/i/flickrstream_icon_16x16.png'));
      add_submenu_page('flickr-stream', 'Flickr-stream Settings', __('Setttings', 'flickrstm'), 'manage_options', 'flickr-stream_settings', array($this, 'option_panel'));
    }

    public function addScripts()
    {
      wp_enqueue_script('jquery');

      //localize js data
      $jsdata = array(
        'confirmDeleteText' => __('Are you sure you want to delete this item?', 'flickrstm'),
        'deleteShortcodeNonce' => wp_create_nonce('fs-delete-shortcode')
      );

      //load main frontend js
      wp_enqueue_script('fs-admin-js', plugins_url('js/admin.min.js', __FILE__), array('jquery'), $this->_version, true);
      wp_localize_script('fs-admin-js', 'fsJSData', $jsdata);
    }

    public function addStyles()
    {
      wp_enqueue_style('fs-admin-css', plugins_url('css/admin.css', __FILE__), false, $this->_version);
    }

    public function option_panel()
    {
      require($this->_dirpath . '/inc/forms/generalOptions.inc.php');
    }

    public function shortcode_panel()
    {
      //declare globals
      global $wpdb;

      ?>

      <div class="wrap" id="fs-shortcode-panel">
        <h2 id="fs-masthead">Flickr-Stream Shortcodes</h2>

        <?php
        //if view parameter is set//
        if (isset($_GET['view']))
        {

          if ($_GET['view'] == 'shortcodecreate')
            require($this->_dirpath . '/inc/forms/createShortcode.inc.php');
          elseif ($_GET['view'] == 'shortcodeedit')
            require($this->_dirpath . '/inc/forms/editShortcode.inc.php');

        }
        //display shortcodes
        else
          require($this->_dirpath . '/inc/forms/overviewShortcodes.inc.php');
        ?>

      </div>

      <?php

    }

    public function processor()
    {
      require($this->_dirpath . '/inc/processor.inc.php');
    }

  }

}
?>
