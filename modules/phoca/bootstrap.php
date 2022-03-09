<?php

use YOOtheme\Builder;
use YOOtheme\Path;

include_once __DIR__ . '/src/SourceListener.php';

return [
  'events' => [
    'source.init' => [
      SourceListener::class => 'initSource',
    ],
  ],
];
