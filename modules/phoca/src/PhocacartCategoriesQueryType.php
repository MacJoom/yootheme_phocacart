<?php
use Joomla\CMS\Factory;
use PhocacartYTUtils as PCU;

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class PhocacartCategoriesQueryType
{
  public static function config()
  {
    PCU::init();
    $a= PCU::getPhocacartProductCategories();
    return [
      'fields' => [
        'Phocacartcategories' => [
          'type' => [
            'listOf' => 'PhocacartCategory',
          ],

          // Arguments passed to the resolver function
          'args' => [
            'offset' => [
              'type' => 'Int',
            ],
            'limit' => [
              'type' => 'Int',
            ],
            'category' => [
              'type' => 'Int'
            ],
            'url_filter_field' => [
              'type' => 'String'
            ],
            'order' => [
              'type' => 'String',
            ],
            'order_direction' => [
              'type' => 'String',
            ],
          ],

          'metadata' => [
            // Label in dynamic content select box
            'label' => 'Phocacart Categories',

            // Option group in dynamic content select box
            'group' => 'Phocacart',

            // Fields to input arguments in the customizer
            'fields' => [
              // The array key corresponds to a key in the 'args' array above
              'category' => [
                // Field label
                'label' => 'Product Category',
                // Field description
                'description' => 'Select a category.',
                // Default or custom field types can be used
                'type' => 'select',
                'default' => 0,
                //'options' => ['- ANY -' => 0, 'Gruppe 1'=>1, 'Gruppe 2' => 2],
                 'options' => ['- ANY -' => 0] + $a,
              ],
              '_offset' => [
                'description' => 'Set the starting point and limit the number of categories.',
                'type' => 'grid',
                'width' => '1-2',

                'fields' => [
                  'offset' => [
                    'label' => 'Start',
                    'type' => 'number',
                    'default' => 0,
                    'modifier' => 1,
                    'attrs' => [
                      'min' => 1,
                      'required' => true,
                    ],
                  ],
                  'limit' => [
                    'label' => 'Quantity',
                    'type' => 'limit',
                    'default' => 10,
                    'attrs' => [
                      'min' => 1,
                    ],
                  ],
                ],
              ],
              '_order' => [
                'type' => 'grid',
                'width' => '1-2',
                'fields' => [
                  'order' => [
                    'label' => 'Order',
                    'type' => 'select',
                    'default' => 'sort_name',
                    'options' => [
                      'Title' => 'title',
                      'ID'  => 'id',
                    ],
                  ],
                  'order_direction' => [
                    'label' => 'Direction',
                    'type' => 'select',
                    'default' => 'ASC',
                    'options' => [
                      'Ascending' => 'ASC',
                      'Descending' => 'DESC',
                    ],
                  ],
                ],
              ],
            ],
          ],

          'extensions' => [
            'call' => __CLASS__ . '::resolve',
          ],
        ],
      ],
    ];
  }

  public static function resolve($root, array $args)
  {
    $language = Factory::getApplication()->getLanguage();
    $language ->load('com_phocacart',JPATH_SITE);    static $entities = [];
    $key = implode('_', $args);
    if (empty($entities[$key])) {
      PCU::init();
      $entities[$key] = [];

      $p = PCU::getOptions($args);
      // apply other YTP UI filters
/*      foreach (['contact_type'] as $para) {
        if (!empty($args[$para])) {
          $params['where'][] = [$para, '=', $args[$para]];
        }
      }*/
      // filter with joins
      if (!empty($args['category'])) {
        $p['catid_multiple']= array($args['category']);
      }
      /*
      $params['chain'] = [
        'address_0' => ['Address', 'get', ['where' => [['contact_id', '=', '$id'], ['is_primary', '=', 1]]]],
      ];
      */
      PCU::applyUrlFilter($args, $p);

      $result           = PhocacartCategory::getCategories();
      $pathitem 		= PhocacartPath::getPath('categoryimage');

      foreach ($result as &$category) {
        if (!empty($category->image)) {
            $category->image = DS.$pathitem['orig_rel_ds'].$category->image;
            $category->link = JRoute::_(PhocacartRoute::getCategoryRoute($category->id, '', $language));
        }
        $entities[$key][] = $category;
      }
    }
    return $entities[$key];
  }
}
