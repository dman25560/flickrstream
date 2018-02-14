<?php

require_once(plugin_dir_path(__FILE__) . 'fsWPListTableBase.class.php');

class fsShortcodeListTable extends fsWPListTableBase
{
  function __construct()
  {
    global $status, $page;

    parent::__construct(array(
      'singular' => '',
      'plural' => 'fs-sortable-table',
      'ajax' => false
    ));
  }

  function get_columns()
  {
    $columns = array(
      'cb' => '<input type="checkbox"/>',
      'name' => __('Name', 'flickrstm'),
      'shortcode' => __('Shortcode', 'flickrstm'),
      'lastupdated' => __('Last Updated', 'flickrstm'),
      'type' => __('Type', 'flickrstm'),
      'cached' => __('Cached', 'flickrstm')
    );

    return $columns;
  }

  function prepare_items()
  {
    $this->process_bulk_action();

    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = array($columns, $hidden, $sortable);

    $this->items = $this->setup_items();

    if (!empty($_GET['orderby']) && !empty($_GET['order']))
      usort($this->items, array($this, 'usort_reorder'));
  }

  function column_default($item, $column_name)
  {
    switch ($column_name)
    {
      case 'name':
      case 'shortcode':
      case 'lastupdated':
      case 'type':
      case 'cached':
        return $item[ $column_name ];
      default:
        return 'An unknown error has occured';
    }
  }

  function get_sortable_columns()
  {
    $sortable_columns = array(
      'name'  => array('name', false),
      'shortcode' => array('shortcode', false),
      'lastupdated' => array('lastupdated', false),
      'type' => array('type', false),
      'cached'   => array('cached', false)
    );

    return $sortable_columns;
  }

  function usort_reorder($a, $b)
  {
    // If no sort, default to title
    $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'name';
    // If no order, default to asc
    $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
    // Determine sort order
    $result = strcmp( $a[$orderby], $b[$orderby] );
    // Send final sort direction to usort
    return ($order === 'asc') ? $result : -$result;
  }

  //add id to table rows
  function single_row( $item )
  {
    static $row_class = '';
    $row_class = ( $row_class == '' ? ' class="alternate"' : '' );

    echo '<tr id="' . $item['ID'] . '" ' . $row_class . '>';
    $this->single_row_columns( $item );
    echo '</tr>';
  }

  function get_bulk_actions()
  {
    $actions = array(
      'delete' => __('Delete', 'flickrstm')
    );

    return $actions;
  }

  function process_bulk_action()
  {
    $action = $this->current_action();

    if ($action != -1)
    {
      require_once 'fsAdminGen.class.php';

      $options = get_option('flickrstream_main_opts');

      fsAdminGen::initialize($options);

      if ($action == 'delete')
        fsAdminGen::deleteShortcodes($_POST['shortcode']);
    }
  }

  function column_cb($item)
  {
    return sprintf('<input type="checkbox" name="shortcode[]" value="%s" />', $item['ID']);
  }

  function no_items()
  {
    _e('No shortcodes found', 'flickrstm');
  }

  function setup_items()
  {
    global $wpdb;
    $cells = array();

    $data = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'options WHERE option_name LIKE "flickrstream_short_%" ORDER BY option_name', ARRAY_A);

    foreach ($data as $val)
    {
      $intdata = unserialize($val['option_value']);

      array_push($cells, array(
        'ID' => $intdata['shortid'],
        'name' => '<a class="fs-row-title" href="?page=flickr-stream&view=shortcodeedit&id=' . $intdata['shortid'] . '" title="' . __('Edit', 'flickrstm') . '">' . stripslashes($intdata['vanityname']) . '</a>
        <div class="fs-row-actions">
        <a href="?page=flickr-stream&view=shortcodeedit&id=' . $intdata['shortid'] . '" title="' . __('Edit', 'flickrstm') . '">' . __('Edit', 'flickrstm') . '</a>
        <span class="utv-row-divider">|</span>
        <a href="" class="fs-delete-shortcode" title="' . __('Delete', 'flickrstm') . '">' . __('Delete', 'flickrstm') . '</a>
        </div>',
        'shortcode' => '[flickrstream id="' . $intdata['shortid'] . '"]',
        'lastupdated' => date('Y/m/d', $intdata['updated']),
        'type' => ($intdata['type'] == 'Set' ? 'Album' : 'Gallery'),
        'cached' => ($intdata['cachedata'] == 'on' ? 'Yes' : 'No')
      ));
    }

    return $cells;
  }
}
?>
