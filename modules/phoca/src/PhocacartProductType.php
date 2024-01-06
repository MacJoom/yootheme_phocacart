<?php
use PhocacartYTUtils as PCU;

class PhocacartProductType
{
  public static $fieldsToKeep = [
    'id',
    'title',
    'description',
    'sku',
    'price',
    'image',
  ];

  public static $fieldsToAdd = [
    'link' => 'Link',
  ];

  /**
   * @return array
   */
  public static function config()
  {
    static $entityFields = [];
    if (empty($entityFields)) {
      PCU::init();

      $result = PCU::getPhocacartProductFields();
      $entityFields = PCU::getEntityFields($result, self::$fieldsToKeep, self::$fieldsToAdd);
      if (!empty($entityFields)) {
        $entityFields['metadata'] = [
          // Label used in the customizer
          'label' => 'PhocacartProduct',

          // Denotes that this is an object type and makes the type usable as dynamic content source
          'type' => true,
        ];
      }
    }
    return $entityFields;
  } 

}
