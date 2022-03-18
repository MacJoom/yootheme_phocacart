<?php
use PhocacartYTUtils as PCU; //nicht PhocacartUtils!!! schon in Benutzung...

class PhocacartCategoryType //defines the fields to be used - see db table for all the fields
{
  public static $fieldsToKeep = [ //fields to keep from all fields
    'id',
    'title',
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

      $result = PCU::getPhocacartCategoryFields();
      $entityFields = PCU::getEntityFields($result, self::$fieldsToKeep, self::$fieldsToAdd);
      if (!empty($entityFields)) {
        $entityFields['metadata'] = [
          // Label used in the customizer
          'label' => 'PhocacartCategory',

          // Denotes that this is an object type and makes the type usable as dynamic content source
          'type' => true,
        ];
      }
    }
    return $entityFields;
  } 

}
