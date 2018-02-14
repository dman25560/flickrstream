<?php

//reload options to be sure correct options are displayed
$this->_options = get_option('flickrstream_main_opts');

?>

<div class="wrap" id="fs-settings-panel">
  <h2 id="fsMastHead">Flickr-Stream Settings</h2>
  <div class="fs-left-column fs-options-column">
    <div class="fs-formbox fs-top-formbox card">
      <form method="post">
        <h3><?php _e('General Settings', 'flickrstm'); ?></h3>
        <p>
          <label><?php _e('Flickr Api Key: ', 'flickrstm'); ?></label>
          <input type="text" name="apikey" value="<?php echo $this->_options['apikey']; ?>"/>
          <span class="fs-hint"><?php _e('ex: your api key from Flickr', 'flickrstm'); ?></span>
        </p>
        <p>
          <label><?php _e('Photo Highlight Color: ', 'flickrstm'); ?></label>
          <input type="color" name="highlightColor" id="highlightColor" value="<?php echo $this->_options['highlightColor']; ?>"/>
          <button id="resetHighlightColor" class="button-secondary">Reset</button>
          <span class="fs-hint"><?php _e('ex: color value in hex format (#fff) to use for photo highlights', 'flickrstm'); ?></span>
        </p>
        <p>
          <label><?php _e('Use Mobile Photo Viewer: ', 'flickrstm'); ?></label>
          <input type="checkbox" name="useMobileView" <?php echo ($this->_options['useMobileView'] == 'yes' ? 'checked' : ''); ?>/>
          <span class="fs-hint"><?php _e('ex: check to use mobile photo viewer for mobile devices', 'flickrstm'); ?></span>
        </p>
        <p class="submit">
          <input type="submit" name="saveopts" value="<?php _e('Save Changes', 'flickrstm') ?>" class="button-primary"/>
          <?php wp_nonce_field('flickrstream_update_options'); ?>
        </p>
      </form>
    </div>
  </div>
</div>
