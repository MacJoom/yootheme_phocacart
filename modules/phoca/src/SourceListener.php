<?php

include_once __DIR__ . '/PhocacartYTUtils.php';
include_once __DIR__ . '/PhocacartProductsQueryType.php';
include_once __DIR__ . '/PhocacartProductType.php';

class SourceListener
{
  public static function initSource($source)
  {
    $source->queryType(PhocacartProductsQueryType::config());
    $args	= ['PhocacartProduct', PhocacartProductType::config()];
    $source->objectType(...$args);
  }
}
