<?php

if (!empty($_POST))
{
  //SAVE MAIN OPTIONS//
  if (isset($_POST['saveopts']))
  {
    if (check_admin_referer('flickrstream_update_options'))
    {
      $opts['apikey'] = sanitize_text_field($_POST['apikey']);
      $opts['marker'] = $this->_options['marker'];
      $opts['useMobileView'] = (isset($_POST['useMobileView']) ? 'yes' : 'no');
      $opts['highlightColor'] = $_POST['highlightColor'];

      if (update_option('flickrstream_main_opts', $opts))
        echo '<div class="updated"><p>' . __('Settings saved', 'flickrstm') . '</p></div>';
      else
        echo '<div class="error"><p>' . __('Oops... something went wrong or there were no changes needed', 'flickrstm') . '</p></div>';
    }
  }
  //SAVE NEW SHORTCODE//
  elseif (isset($_POST['saveShortcode']))
  {
    if (check_admin_referer('flickrstream_save_shortcode'))
    {
      $optname = 'flickrstream_short_' . $this->_options['marker'];

      $ins['vanityname'] = sanitize_text_field($_POST['vanityname']);
      $ins['type'] = sanitize_text_field($_POST['type']);
      $ins['id'] = sanitize_text_field($_POST['id']);
      $ins['photocnt'] = sanitize_text_field($_POST['photocnt']);
      $ins['photoselect'] = sanitize_text_field($_POST['photoselect']);
      $ins['linktype'] = sanitize_text_field($_POST['linktype']);
      $ins['thumbsize'] = sanitize_text_field($_POST['thumbsize']);
      $ins['photoAlign'] = sanitize_text_field($_POST['photoAlign']);
      $ins['cachedata'] = (isset($_POST['cachedata']) ? 'on' : 'off');
      $ins['hidetitle'] = (isset($_POST['hidetitle']) ? 'on' : 'off');
      $ins['hidecaption'] = (isset($_POST['hidecaption']) ? 'on' : 'off');
      $ins['shortid'] = $this->_options['marker'];
      $ins['updated'] = current_time('timestamp');

      if (empty($ins['vanityname']) || empty($ins['type']) || empty($ins['id']) || empty($ins['photocnt']) || empty($ins['photoselect']) || empty($ins['linktype']) || empty($ins['thumbsize']) || empty($ins['photoAlign']))
      {
        echo '<div class="error e-message"><p>' . __('Oops... all form fields must have a value', 'flickrstm') . '</p></div>';
        return;
      }

      if (empty($ins['shortid']))
      {
        echo '<div class="error e-message"><p>' . __('Oops... Some unknown error has occurred. If this persists, please contact the developer', 'flickrstm') . '</p></div>';
        return;
      }

      if (empty($this->_options['apikey']))
      {
        echo '<div class="error"><p>' . __('Oops... You have not provided a valid API Key in the settings menu.', 'flickrstm') . '<a href="?page=flickr-stream_settings">' . __('Enter your key', 'flickrstm') . '</a></p></div>';
        return;
      }

      if ($ins['cachedata'] == 'on')
      {
        require_once(dirname(__FILE__) . '/../class/fsWorkhorse.class.php');
        $fs = new fsWorkhorse();
        $ins['cache'] = $fs->returnCache($ins);

        if (!$ins['cache'])
        {
          echo '<div class="error"><p>' . __('Oops... Either your API key is invalid or there has been an issue contacting the Flickr Api.', 'flickrstm') . '</p></div>';
          return;
        }
      }

      $this->_options['marker']++;
      update_option('flickrstream_main_opts', $this->_options);

      if (update_option($optname, $ins))
        echo '<div class="updated"><p>' . __('Shortcode created', 'flickrstm') . '</p></div>';
      else
        echo '<div class="error e-message"><p>' . __('Oops... something went wrong', 'flickrstm') . '</p></div>';
    }
  }
  //UPDATE A SHORTCODE//
  elseif (isset($_POST['updateShortcode']))
  {
    if (check_admin_referer('flickrstream_update_shortcode'))
    {
      $ins['vanityname'] = sanitize_text_field($_POST['vanityname']);
      $ins['type'] = sanitize_text_field($_POST['type']);
      $ins['id'] = sanitize_text_field($_POST['id']);
      $ins['photocnt'] = sanitize_text_field($_POST['photocnt']);
      $ins['photoselect'] = sanitize_text_field($_POST['photoselect']);
      $ins['linktype'] = sanitize_text_field($_POST['linktype']);
      $ins['thumbsize'] = sanitize_text_field($_POST['thumbsize']);
      $ins['photoAlign'] = sanitize_text_field($_POST['photoAlign']);
      $ins['cachedata'] = (isset($_POST['cachedata']) ? 'on' : 'off');
      $ins['hidetitle'] = (isset($_POST['hidetitle']) ? 'on' : 'off');
      $ins['hidecaption'] = (isset($_POST['hidecaption']) ? 'on' : 'off');
      $ins['shortid'] = sanitize_text_field($_POST['shortid']);
      $ins['updated'] = current_time('timestamp');
      $optname = 'flickrstream_short_' . $ins['shortid'];

      if (empty($ins['vanityname']) || empty($ins['type']) || empty($ins['id']) || empty($ins['photocnt']) || empty($ins['photoselect']) || empty($ins['linktype']) || empty($ins['thumbsize']) || empty($ins['photoAlign']))
      {
        echo '<div class="error e-message"><p>' . __('Oops... all form fields must have a value', 'flickrstm') . '</p></div>';
        return;
      }

      if (empty($ins['shortid']))
      {
        echo '<div class="error e-message"><p>' . __('Oops... Some unknown error has occurred. If this persists, please contact the developer', 'flickrstm') . '</p></div>';
        return;
      }

      if (empty($this->_options['apikey']))
      {
        echo '<div class="error"><p>' . __('Oops... You have not provided a valid API Key in the settings menu.', 'flickrstm') . '<a href="?page=flickr-stream_settings">' . __('Enter your key', 'flickrstm') . '</a></p></div>';
        return;
      }

      if ($ins['cachedata'] == 'on')
      {
        require_once(dirname(__FILE__) . '/../class/fsWorkhorse.class.php');
        $fs = new fsWorkhorse();
        $ins['cache'] = $fs->returnCache($ins);

        if (!$ins['cache'])
        {
          echo '<div class="error"><p>' . __('Oops... Either your API key is invalid or there has been an issue contacting the Flickr Api.', 'flickrstm') . '</p></div>';
          return;
        }
      }

      if (update_option($optname, $ins))
        echo '<div class="updated"><p>' . __('Shortcode updated', 'flickrstm') . '</p></div>';
      else
        echo '<div class="error e-message"><p>' . __('Oops... something went wrong', 'flickrstm') . '</p></div>';
    }
  }
  //DELETE A SHORTCODE//
  elseif (isset($_POST['delShortcode']))
  {
    if (check_admin_referer('flickrstream_actions'))
    {
      if (delete_option('flickrstream_short_' . $_POST['key']))
        echo '<div class="updated"><p>' . __('Shortcode deleted', 'flickrstm') . '</p></div>';
    }
  }
}
?>
