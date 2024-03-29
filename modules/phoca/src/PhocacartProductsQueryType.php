<?php

use PhocacartYTUtils as PCU;
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
define('DS', DIRECTORY_SEPARATOR);

class PhocacartProductsQueryType
{
  public static function config()
  {
    PCU::init();
    $a= PCU::getPhocacartProductCategories();
    return [
      'fields' => [
        'Phocacartproducts' => [
          'type' => [
            'listOf' => 'PhocacartProduct',
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
            'label' => 'Phocacart Products',

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
/*
              'url_filter_field' => [
                // Field label
                'label' => 'URL Filter Field',
                // Field description
                'description' => 'Select a field to filter with when supplied from URL.',
                // Default or custom field types can be used
                'type' => 'select',
                'default' => '',
                //'options' => ['- NONE -' => ''] + CiviContactType::getFieldList(),
                'options' => ['- NONE -' => ''],
              ],
*/
              '_offset' => [
                'description' => 'Set the starting point and limit the number of products.',
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
    static $entities = [];
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

      $result			= PhocacartProduct::getProducts($p['offset'], $p['limit'], $p['order'], 0, true, false, false, 0, $p['catid_multiple'], $p['featured_only'], array(0,1), '', '', true);
      //$result = civicrm_api4('Contact', 'get', $params);
      $pathitem 		= PhocacartPath::getPath('productimage');

      foreach ($result as &$product) {
        if (!empty($product->image)) {
          //$product->image_URL = "<img src='$pathitem->orig_rel_ds.{$product->image}'>";
            $product->image = DS.$pathitem['orig_rel_ds'].$product->image;
            $product->link = JRoute::_(PhocacartRoute::getItemRoute($product->id, $product->catid, $product->alias, $product->catalias));

        }
        $entities[$key][] = $product;
      }
    }
    return $entities[$key];
  }
}
