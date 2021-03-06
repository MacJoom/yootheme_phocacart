<?php
use PhocacartYTUtils as PCU; //nicht PhocacartUtils!!! schon in Benutzung...

class PhocacartProductType //defines the fields to be used - see db table for all the fields
{
  public static $fieldsToKeep = [ //fields to keep from all fields
    'id',
    'title',
    'description',
    'sku',
    'price',
    'image',
  ];

  public static $fieldsToAdd = [ //calculated fields
    'link' => 'Link',
  ];

  /**
   * @return array
   */
  public static function config() //load fields for beeing displayed in yootheme
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
