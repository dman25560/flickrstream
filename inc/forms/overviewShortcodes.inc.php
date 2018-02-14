<?php

require_once(dirname(__FILE__) . '/../../class/fsShortcodeListTable.class.php');

$shortcodes = new fsShortcodeListTable();
$shortcodes->prepare_items();

?>

<div class="fs-formbox">
  <p class="fs-actionbar">
    <a href="?page=flickr-stream&view=shortcodecreate" class="fs-link-submit-button"><?php _e('Create Shortcode', 'flickrstm'); ?></a>
  </p>
  <h3><?php _e('Shortcodes', 'flickrstm'); ?></h3>
  <form method="post">

    <?php $shortcodes->display(); ?>

  </form>
</div>
<div class="postbox">
  <h3 class="hndle fs-postbox"><span><?php _e("FAQ's", 'flickrstm'); ?></span></h3>
  <div class="inside">
    <div class="fs-formbox">
      <ul>
        <li>You must provide a <a href="http://www.flickr.com/services/apps/create/apply" target="_blank">valid Flickr Api key</a> in order to use this plugin.</li>
        <li>When adding an album or gallery you must give its album or gallery id for the ID field (ie 72157622248195017, in http://www.flickr.com/photos/davedunne/galleries/72157622248195017/).</li>
        <li>Un-installing the plugin will remove all data associated with it, including your api key, shortcodes and widget settings.</li>
        <li>To refresh the images of a cached widget or shortcode, simply click edit and then click on save changes.</li>
        <li>Only check the box to include Magnific Popup scripts if not using another Magnific Popup plugin.</li>
        <li>The hide captions option only affects Lightbox images, not Flickr links.</li>
        <li>Check the mobile viewer option to use Photoswipe for mobile devices</li>
      </ul>
    </div>
  </div>
</div>
