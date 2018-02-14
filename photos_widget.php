<?php
/**
* Flickrstream_Widget - Photo widget for Flickr-stream
*
* @package Flickr-stream
* @author Dustin Scarberry
*
* @since 1.1.5
*/
class Flickrstream_Widget extends WP_Widget
{
  private $_options;

  //constructor
  public function __construct()
  {
    parent::__construct(
      'flickrstream_widget', // Base ID
      'Flickrstream', // Name
      array('description' => __('Display a Flickr album or gallery', 'flickrstm')) // Args
    );

    //get plugin options
    $this->_options = get_option('flickrstream_main_opts');
  }

  //display widget frontend
  public function widget($args, $ins)
  {
    extract($args);
    require_once 'class/fsWorkhorse.class.php';

    echo $before_widget . '<div class="flickrstream-widgetbox">';

    $workhorse = new fsWorkhorse();
    $data = $workhorse->returnPhotos('widget', $ins, $args);

    if ($data)
      echo $data;
    else
      echo '<div class="fs-errorbar">' . __('ERROR: BAD API KEY OR FLICKR API CALL', 'flickrstm') . '</div>';

    echo '</div>' . $after_widget;
  }

  //process widget updates
  public function update($new, $old)
  {
    $ins['id'] = sanitize_text_field($new['id']);
    $ins['type'] = sanitize_text_field($new['type']);
    $ins['photocnt'] = sanitize_text_field($new['photocnt']);
    $ins['photoselect'] = sanitize_text_field($new['photoselect']);
    $ins['linktype'] = sanitize_text_field($new['linktype']);
    $ins['hidetitle'] = (isset($new['hidetitle']) ? 'on' : 'off');
    $ins['hidecaption'] = (isset($new['hidecaption']) ? 'on' : 'off');
    $ins['cachedata'] = (isset($new['cachedata']) ? 'on' : 'off');

    if (empty($ins['id']) || empty($ins['type']) || empty($ins['photocnt']) || empty($ins['photoselect']) || empty($ins['linktype']) || empty($this->_options['apikey']))
      return $old;

    if ($ins['cachedata'] == 'on')
    {
      require 'class/fsWorkhorse.class.php';
      $fs = new fsWorkhorse();
      $ins['cache'] = $fs->returnCache($ins);

      if (!$ins['cache'])
        return $old;
    }

    return $ins;
  }

  //display widget control form
  public function form($ins)
  {
    $dft['id'] = '';
    $dft['type'] = '';
    $dft['photocnt'] = '';
    $dft['photoselect'] = '';
    $dft['linktype'] = '';
    $dft['hidetitle'] = '';
    $dft['hidecaption'] = '';
    $dft['cachedata'] = '';

    $ins = $ins + $dft;

    ?>

    <div id="flickrstream_widget_controls">
      <p>
        <label><?php _e('Type:', 'flickrstm'); ?></label>
        <select name="<?php echo $this->get_field_name('type'); ?>" class="widefat">
          <option></option>

          <?php

          $opts = array(array('text' => __('Album', 'flickrstm'), 'value' => 'Set'), array('text' => __('Gallery', 'flickrstm'), 'value' => 'Gallery'));

          foreach ($opts as $val)
          {
            if ($val['value'] == $ins['type'])
              echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
            else
              echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';
          }

          ?>

        </select>
      </p>
      <p>
        <label><?php _e('ID:', 'flickrstm'); ?></label>
        <input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo esc_attr($ins['id']); ?>" class="widefat"/>
      </p>
      <p>
        <label><?php _e('# Of Photos', 'flickrstm'); ?>:</label>
        <select name="<?php echo $this->get_field_name('photocnt'); ?>" class="widefat">
          <option></option>

          <?php

          for ($i = 1; $i < 101; $i++)
          {
            if ($i == $ins['photocnt'])
              echo '<option selected>' . $i . '</option>';
            else
              echo '<option>' . $i . '</option>';
          }

          ?>

        </select>
      </p>
      <p>
        <label><?php _e('Photo Selection:', 'flickrstm'); ?></label>
        <select name="<?php echo $this->get_field_name('photoselect'); ?>" class="widefat">
          <option></option>

          <?php

          $opts = array(array('text' => __('Beginning', 'flickrstm'), 'value' => 'Beginning'), array('text' => __('Random', 'flickrstm'), 'value' => 'Random'));

          foreach ($opts as $val)
          {
            if ($val['value'] == $ins['photoselect'])
              echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
            else
              echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';
          }

          ?>

        </select>
      </p>
      <p>
        <label><?php _e('Link Type:', 'flickrstm'); ?></label>
        <select name="<?php echo $this->get_field_name('linktype'); ?>" class="widefat">
          <option></option>

          <?php

          $opts = array(array('text' => __('Lightbox', 'flickrstm'), 'value' => 'Image/Fancybox'), array('text' => __('Flickr', 'flickrstm'), 'value' => 'Flickr'));

          foreach ($opts as $val)
          {
            if ($val['value'] == $ins['linktype'])
              echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
            else
              echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';
          }

          ?>

        </select>
      </p>
      <div class="toggleOptions">

        <?php

        if ($ins['hidetitle'] == 'on')
          echo '<input type="checkbox" name="' . $this->get_field_name('hidetitle') . '" checked/>';
        else
          echo '<input type="checkbox" name="' . $this->get_field_name('hidetitle') . '"/>';

        ?>

        <label class="inline"><?php _e('Hide Gallery/Set Title', 'flickrstm'); ?></label><br/>

        <?php

        if ($ins['cachedata'] == 'on')
          echo '<input type="checkbox" name="' . $this->get_field_name('cachedata') . '" checked/>';
        else
          echo '<input type="checkbox" name="' . $this->get_field_name('cachedata') . '"/>';

        ?>

        <label class="inline"><?php _e('Cache Data', 'flickrstm'); ?></label><br/>

        <?php

        if ($ins['hidecaption'] == 'on')
          echo '<input type="checkbox" name="' . $this->get_field_name('hidecaption') . '" checked/>';
        else
          echo '<input type="checkbox" name="' . $this->get_field_name('hidecaption') . '"/>';

        ?>

        <label class="inline"><?php _e('Hide Captions', 'flickrstm'); ?></label>
      </div>
    </div>

    <?php
  }
}
?>
