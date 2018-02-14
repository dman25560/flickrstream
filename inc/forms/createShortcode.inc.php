<div class="fs-left-column">
  <div class="fs-formbox fs-top-formbox card">
    <form method="post">
      <h3><?php _e('Create Shortcode', 'flickrstm'); ?></h3>
      <p>
        <label><?php _e('Name: ', 'flickrstm'); ?></label>
        <input type="text" name="vanityname"/>
        <span class="fs-hint"><?php _e('ex: vanity name just for your reference', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Type: ', 'flickrstm'); ?></label>
        <select name="type">
          <option></option>
          <option value="Set"><?php _e('Album', 'flickrstm'); ?></option>
          <option value="Gallery"><?php _e('Gallery', 'flickrstm'); ?></option>
        </select>
        <span class="fs-hint"><?php _e('ex: type of picture group', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('ID: ', 'flickrstm'); ?></label>
        <input type="text" name="id"/>
        <span class="fs-hint"><?php _e('ex: id of album or gallery', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Number Of Photos: ', 'flickrstm'); ?></label>
        <select name="photocnt">
          <option></option>

          <?php
          for ($i = 1; $i < 101; $i++)
            echo '<option>' . $i . '</option>';
          ?>

        </select>
        <span class="fs-hint"><?php _e('ex: number of photos to display', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Photo Selection: ', 'flickrstm'); ?></label>
        <select name="photoselect">
          <option></option>
          <option value="Beginning"><?php _e('Beginning', 'flickrstm'); ?></option>
          <option value="Random"><?php _e('Random', 'flickrstm'); ?></option>
        </select>
        <span class="fs-hint"><?php _e('ex: how to select photos', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Link Type: ', 'flickrstm'); ?></label>
        <select name="linktype">
          <option></option>
          <option value="Image/Fancybox"><?php _e('Lightbox', 'flickrstm'); ?></option>
          <option value="Flickr"><?php _e('Flickr', 'flickrstm'); ?></option>
        </select>
        <span class="fs-hint"><?php _e('ex: how to open photo links', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Thumbnail Size: ', 'flickrstm'); ?></label>
        <select name="thumbsize">
          <option></option>
          <option value="Small"><?php _e('Small', 'flickrstm'); ?></option>
          <option value="Medium"><?php _e('Medium', 'flickrstm'); ?></option>
        </select>
        <span class="fs-hint"><?php _e('ex: thumbnail size to use', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Photo Alignment: ', 'flickrstm'); ?></label>
        <select name="photoAlign">
          <option></option>
          <option value="Left"><?php _e('Left', 'flickrstm'); ?></option>
          <option value="Center"><?php _e('Center', 'flickrstm'); ?></option>
          <option value="Right"><?php _e('Right', 'flickrstm'); ?></option>
        </select>
        <span class="fs-hint"><?php _e('ex: alignment of photos in gallery/set', 'flickrstm'); ?></span>
      </p>
      <p>
        <label><?php _e('Cache Data: ', 'flickrstm'); ?></label>
        <input type="checkbox" name="cachedata"/>
      </p>
      <p>
        <label><?php _e('Hide Set/Gallery Title: ', 'flickrstm'); ?></label>
        <input type="checkbox" name="hidetitle"/>
      </p>
      <p>
        <label><?php _e('Hide Captions: ', 'flickrstm'); ?></label>
        <input type="checkbox" name="hidecaption"/>
      </p>
      <p class="submit">
        <input type="submit" name="saveShortcode" value="<?php _e('Save New Shortcode', 'flickrstm') ?>" class="button-primary"/>
        <?php wp_nonce_field('flickrstream_save_shortcode'); ?>
        <a href="?page=flickr-stream" class="fs-cancel"><?php _e('Go Back', 'flickrstm'); ?></a>
      </p>
    </form>
  </div>
</div>
