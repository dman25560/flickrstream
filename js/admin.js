var fsAdmin = {};

fsAdmin.initialize = function($)
{
  fsAdmin.setupEvents($);
};

fsAdmin.setupEvents = function($)
{
  $(function()
  {
    //remove success and error messages after 3 seconds
    $('div.updated, div.e-message').delay(3000).queue(function(){$(this).remove();});

    $('#resetHighlightColor').click(function()
    {
      $('#highlightColor').val('#397fdf');
      return false;
    });

    //delete shortcode ajax
    $('.fs-delete-shortcode').click(function()
    {
      if (!confirm(fsJSData.confirmDeleteText))
        return false;

      var $item = $(this).parents('tr');
      var key = $item.attr('id');

      var data =
      {
        action: 'fs_deleteshortcode',
        key: key,
        nonce: fsJSData.deleteShortcodeNonce
      };

      $.post(ajaxurl, data, function(response)
      {
        if (response)
          $item.fadeOut(400, function(){ $item.remove(); });
      });

      return false;
    });
  });
};

//initialize
(function($){fsAdmin.initialize($);})(jQuery);
