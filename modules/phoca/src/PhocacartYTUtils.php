<?php
use Joomla\CMS\Factory;

class PhocacartYTUtils {

  public static function init() {
    if (!defined('PHOCACART_DSN')) {
        JLoader::registerPrefix('Phocacart', JPATH_ADMINISTRATOR . '/components/com_phocacart/libraries/phocacart');
        require JPATH_ADMINISTRATOR . '/components/com_phocacart/libraries/autoloadPhoca.php';
        //require_once JPATH_BASE.'/components/com_phocacart/controllers/phocacartcommons.php';
        jimport('joomla.application.component.controller');
        //JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_phocacart/tables');
   }
    return defined('PHOCACART_DSN');
  }

  public static function getPhocacartProductFields() {
      $language = Factory::getApplication()->getLanguage();
      $language ->load('com_phocacart',JPATH_SITE);

      $db = Factory::getContainer()->get('DatabaseDriver');
      $q = "SHOW COLUMNS FROM #__phocacart_products";
      $db->setQuery($q);
      $fields = $db->loadAssocList();
      foreach ($fields as $idx => &$field)  {
          $n = 'COM_PHOCACART_FIELD_'.strtoupper($field['Field']).'_LABEL';
          $field['title']=JText::_($n);
      }
      return $fields;
  }
    public static function getPhocacartCategoryFields() {
        //$language = Factory::getLanguage();
        $language = Factory::getApplication()->getLanguage();
        $language ->load('com_phocacart',JPATH_SITE);

        $db = Factory::getContainer()->get('DatabaseDriver');
        $q = "SHOW COLUMNS FROM #__phocacart_categories";
        $db->setQuery($q);
        $fields = $db->loadAssocList();
        foreach ($fields as $idx => &$field)  {
            $n = 'COM_PHOCACART_FIELD_'.strtoupper($field['Field']).'_LABEL';
            $field['title']=JText::_($n);
        }
        return $fields;
    }
    public static function getPhocacartProductCategories() {
        $db = Factory::getContainer()->get('DatabaseDriver');
        $q = "SELECT id,title  FROM #__phocacart_categories";
        $db->setQuery($q);
        $fields = $db->loadAssocList('title','id');
        return $fields;
    }

    public static function getCategoryByParentId($pid,$sid) {
        $db = Factory::getContainer()->get('DatabaseDriver');
        if ($pid = -2) { //all categories
            $query = 'SELECT a.title, a.alias, a.id, a.parent_id, a. image'
                . ' FROM #__phocacart_categories AS a'
                . ' ORDER BY a.ordering';
            $db->setQuery( $query );
            $categories = $db->loadObjectList();

        }
        if ($pid >-1) {
            $query = 'SELECT a.title, a.alias, a.id, a.parent_id, a. image'
                . ' FROM #__phocacart_categories AS a'
                . ' WHERE a.parent_id = ' . $pid
                . ' ORDER BY a.ordering';
            //. ' LIMIT 1'; We need all subcategories
            $db->setQuery( $query );
            $categories = $db->loadObjectList();
        }
        if ($sid >-1) { //override parent select
            $query = 'SELECT a.title, a.alias, a.id, a.parent_id, a. image'
                . ' FROM #__phocacart_categories AS a'
                . ' WHERE a.id = ' . $sid
                . ' ORDER BY a.ordering';
            //. ' LIMIT 1'; We need all subcategories
            $db->setQuery( $query );
            $categories = $db->loadObjectList();
        }

        return $categories;
    }

    public static function getEntityFields($apiResult, $fieldsToKeep = [], $fieldsToAdd = []) {
    $entityFields = [];
    if (!empty($apiResult)) {
      foreach ($apiResult as $idx => $field) {
        $key = $field['Field'];
        if (empty($fieldsToKeep) ||
          (!empty($fieldsToKeep) && in_array($key, $fieldsToKeep))
        ) {
          $entityFields['fields'][$key] = [
            'name' => $key,
            'type' => 'String',
            'metadata' => [
              'label' => $field['title'],
              'group' => 'Phocacart'
            ],
          ];
          if (stripos($key, '_date')) {
            $entityFields['fields'][$key]['metadata']['filters'] = ['date'];
          }
        }
      }
    }
    if (!empty($fieldsToAdd)) {
      foreach ($fieldsToAdd as $key => $title) {
        $entityFields['fields'][$key] = [
          'name' => $key,
          'type' => 'String',
          'metadata' => [
            'label' => $title,
            'group' => 'Phocacart'
          ],
        ];
      }
    }
    return $entityFields;
  }

  public static function getOptions(array $args) {
    $options = [
      'limit' => 10
    ];
    if (!empty($args['limit'])) {
      $options['limit'] = $args['limit'];
    }
    if (isset($args['offset'])) {
      $options['offset'] = $args['offset'];
    }
    if (!empty($args['order'])) {
      $options['orderBy'] = [$args['order'] => $args['order_direction']];
    }
    $options['checkPermissions'] = FALSE;
    return $options;
  }

  public static function applyUrlFilter(array $args, &$params, $prefix = 'phocacartproduct_') {
    if (!empty($args['url_filter_field'])) {
      $urlQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
      parse_str($urlQuery, $query);
      $uff = str_replace($prefix, '', $args['url_filter_field']);
      $val = (!empty($query[$args['url_filter_field']])) ? $query[$args['url_filter_field']] : '-111111';
      $params['where'][] = [$uff, '=', $val];
    }
  }
}
