<?php

if (!isset($_GET['id']))
{
  echo 'Invalid Shortcode ID';
  return;
}

$id = sanitize_key($_GET['id']);
$data = get_option('flickrstream_short_' . $id);

if (!$data)
{
  echo 'Invalid Shortcode ID';
  return;
}

?>

<div class="fs-left-column">
  <div class="fs-formbox fs-top-formbox card">
    <form method="post">
      <h3><?php _e('Edit Shortcode', 'flickrstm'); ?></h3>
      <p>
        <label><?php _e('Name: ', 'flickrstm'); ?></label>
        <input type="text" name="vanityname" value="<?php echo $data['vanityname']; ?>"/>
        <span class="fs-hint"><?php _e('ex: vanity name just for your reference', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Type: ', 'flickrstm'); ?></label>
        <select name="type">

          <?php

          $opts = array(array('text' => __('Album', 'flickrstm'), 'value' => 'Set'), array('text' => __('Gallery', 'flickrstm'), 'value' => 'Gallery'));

          foreach ($opts as $val)
          {
            if ($val['value'] == $data['type'])
              echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
            else
              echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';
          }

          ?>

        </select>
        <span class="fs-hint"><?php _e('ex: type of picture group', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('ID: ', 'flickrstm'); ?></label>
        <input type="text" name="id" value="<?php echo $data['id']; ?>"/>
        <span class="fs-hint"><?php _e(' ex: id of set or gallery', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Number Of Photos: ', 'flickrstm'); ?></label>
        <select name="photocnt">

          <?php

          for ($i = 1; $i < 101; $i++)
          {
            if ($i == $data['photocnt'])
              echo '<option selected>' . $i . '</option>';
            else
              echo '<option>' . $i . '</option>';
          }

          ?>

        </select>
        <span class="fs-hint"><?php _e('ex: number of photos to display', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Photo Selection: ', 'flickrstm'); ?></label>
        <select name="photoselect">

          <?php

          $opts = array(array('text' => __('Beginning', 'flickrstm'), 'value' => 'Beginning'), array('text' => __('Random', 'flickrstm'), 'value' => 'Random'));

          foreach ($opts as $val)
          {
            if ($val['value'] == $data['photoselect'])
              echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
            else
              echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';
          }

          ?>

        </select>
        <span class="fs-hint"><?php _e('ex: how to select photos from Flickr', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Link Type: ', 'flickrstm'); ?></label>
        <select name="linktype">

          <?php

          $opts = array(array('text' => __('Lightbox', 'flickrstm'), 'value' => 'Image/Fancybox'), array('text' => __('Flickr', 'flickrstm'), 'value' => 'Flickr'));
          foreach ($opts as $val)
          {
            if ($val['value'] == $data['linktype'])
              echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
            else
              echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';
          }

          ?>

        </select>
        <span class="fs-hint"><?php _e('ex: how to open photo links', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Thumbnail Size: ', 'flickrstm'); ?></label>
        <select name="thumbsize">

          <?php

          $opts = array(array('text' => __('Small', 'flickrstm'), 'value' => 'Small'), array('text' => __('Medium', 'flickrstm'), 'value' => 'Medium'));

          foreach ($opts as $val)
          {
            if ($val['value'] == $data['thumbsize'])
              echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
            else
              echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';
          }

          ?>

        </select>
        <span class="fs-hint"><?php _e('ex: thumbnail size to use', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Photo Alignment: ', 'flickrstm'); ?></label>
        <select name="photoAlign">

          <?php

          $opts = array(array('text' => __('Left', 'flickrstm'), 'value' => 'Left'), array('text' => __('Center', 'flickrstm'), 'value' => 'Center'), array('text' => __('Right', 'flickrstm'), 'value' => 'Right'));

          foreach ($opts as $val)
          {
            if ($val['value'] == $data['photoAlign'])
              echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
            else
              echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';
          }

          ?>

        </select>
        <span class="fs-hint"><?php _e('ex: alignment of photos in gallery/set', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Cache Data: ', 'flickrstm'); ?></label>

        <?php

        if ($data['cachedata'] == 'on')
          echo '<input type="checkbox" name="cachedata" checked/>';
        else
          echo '<input type="checkbox" name="cachedata"/>';

        ?>

      </p>
      <p>
        <label><?php _e('Hide Set/Gallery Title: ', 'flickrstm'); ?></label>

        <?php

        if ($data['hidetitle'] == 'on')
          echo '<input type="checkbox" name="hidetitle" checked/>';
        else
          echo '<input type="checkbox" name="hidetitle"/>';

        ?>

      </p>
      <p>
        <label><?php _e('Hide Captions: ', 'flickrstm'); ?></label>

        <?php

        if ($data['hidecaption'] == 'on')
          echo '<input type="checkbox" name="hidecaption" checked/>';
        else
          echo '<input type="checkbox" name="hidecaption"/>';
        ?>

      </p>
      <p class="submit">
        <input type="submit" name="updateShortcode" value="<?php _e('Save Changes', 'flickrstm') ?>" class="button-primary"/>
        <input type="hidden" name="shortid" value="<?php echo $data['shortid']; ?>"/>
        <?php wp_nonce_field('flickrstream_update_shortcode'); ?>
        <a href="?page=flickr-stream" class="fs-cancel"><?php _e('Go Back', 'flickrstm'); ?></a>
      </p>
    </form>
  </div>
</div>
<div class="fs-right-column">
  <div class="fs-formbox fs-top-formbox card">

    <h3><?php _e('Preview: ', 'flickrstm'); ?></h3>

    <?php

    require_once(dirname(__FILE__) . '/../../class/fsWorkhorse.class.php');

    if (!empty($data))
    {
      $content = '<div class="flickrstream-embed">';

      $workhorse = new fsWorkhorse();
      $data = $workhorse->returnPhotos('shortcode', $data, null);

      if ($data)
      {
        $content .= $data;
        $content .= '</div>';
      }
      else
        $content = '<div class="fs-errorbar">' . __('ERROR: BAD API KEY OR FLICKR API CALL', 'flickrstm') . '</div>';

      echo $content;
    }

    ?>

  </div>
</div>
