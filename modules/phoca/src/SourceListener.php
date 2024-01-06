<?php

include_once __DIR__ . '/PhocacartYTUtils.php';
include_once __DIR__ . '/PhocacartProductsQueryType.php';
include_once __DIR__ . '/PhocacartProductType.php';
include_once __DIR__ . '/PhocacartCategoriesQueryType.php';
include_once __DIR__ . '/PhocacartCategoryType.php';

class SourceListener
{
  public static function initSource($source)
  {
    $source->queryType(PhocacartProductsQueryType::config());
    $args	= ['PhocacartProduct', PhocacartProductType::config()];
    $source->objectType(...$args);
    $source->queryType(PhocacartCategoriesQueryType::config());
    $args	= ['PhocacartCategory', PhocacartCategoryType::config()];
    $source->objectType(...$args);
  }
}
