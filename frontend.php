<?php
/**
* fsFrontend - Frontend section for Flickr-Stream
*
* @package Flickr-Stream
* @author Dustin Scarberry
*
* @since 1.1.5
*/

if (!class_exists('fsFrontend'))
{
  class fsFrontend
  {
    private $_options, $_version;

    public function __construct($version)
    {
      //set version
      $this->_version = $version;
      
      //get plugin options
      $this->_options = get_option('flickrstream_main_opts');

      //add hooks
      add_shortcode('flickrstream', array($this, 'shortcode'));
      add_action('wp_enqueue_scripts', array($this, 'addScripts'));
      add_action('wp_enqueue_scripts', array($this, 'addStyles'));
    }

    public function addStyles()
    {
      //load frontend styles
      wp_enqueue_style('fs-frontend-css', plugins_url('css/frontend.min.css', __FILE__), false, $this->_version);

      if ($this->_options['highlightColor'] != '#397fdf')
      {
        $css = '.flickrstream-widgetbox a img:hover, .flickrstream-embed img:hover{background-color:' . $this->_options['highlightColor'] . '!important;}';
        wp_add_inline_style('fs-frontend-css', $css);
      }
    }

    public function addScripts()
    {
      //load jquery and lightbox js / css
      wp_enqueue_script('jquery');
      wp_enqueue_script('codeclouds-mp-js', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array('jquery'), null, true);
      wp_enqueue_style('codeclouds-mp-css', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css', false, null);

      //localize js data
      $jsdata = array(
        'useMobileView' => $this->_options['useMobileView'],
        'photoswipeCustomJSPath' => plugins_url('photoswipe/photoswipe-custom.js', __FILE__),
        'photoswipeCSSPath' => plugins_url('photoswipe/photoswipe.css', __FILE__),
        'closeButtonText' => __('Close (Esc)', 'flickrstm')
      );

      //load main frontend js
      wp_enqueue_script('fs-frontend', plugins_url('js/frontend.min.js', __FILE__), array('jquery', 'codeclouds-mp-js'), $this->_version, true);
      wp_localize_script('fs-frontend', 'fsJSData', $jsdata);
    }

    public function shortcode($atts)
    {
      $content = '';

      if (!isset($atts['id']))
        $content = '<div class="fs-errorbar">' . __('ERROR: INVALID SHORTCODE ID', 'flickrstm') . '</div>';
      else
      {
        $opts = get_option('flickrstream_short_' . $atts['id']);
        require_once 'class/fsWorkhorse.class.php';

        if (!empty($opts))
        {
          $content = '<div id="flickrstream-embed-' . $atts['id'] . '" class="flickrstream-embed fs-align-' . strtolower($opts['photoAlign']) . '">';

          $workhorse = new fsWorkhorse();
          $data = $workhorse->returnPhotos('shortcode', $opts, $atts);

          if ($data)
          {
            $content .= $data;
            $content .= '</div>';
          }
          else
            $content = '<div class="fs-errorbar">' . __('ERROR: BAD API KEY OR FLICKR API CALL', 'flickrstm') . '</div>';
        }
        else
          $content = '<div class="fs-errorbar">' . __('ERROR: INVALID SHORTCODE ID', 'flickrstm') . '</div>';
      }

      return $content;
    }
  }
}
?>
