<?php
//use YOOtheme\Config;
//use YOOtheme\Path;

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
    $source->queryType(PhocacartCategoriesQueryType::config());

    $args	= ['PhocacartProduct', PhocacartProductType::config()];
    $source->objectType(...$args);

    $args	= ['PhocacartCategory', PhocacartCategoryType::config()];
    $source->objectType(...$args);
  }
/*
  public static function initCustomizer(Config $config, Translator $translator) {
      $translator->addResource(Path::get("{$config('theme.childDir')}/languages/{$config('locale.code')}.json"));
  } */
}
