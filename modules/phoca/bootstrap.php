<?php

include_once __DIR__ . '/src/SourceListener.php';

return [
  'events' => [
      /* 'customizer.init' => [
          SourceListener::class=> ['initCustomizer', -10],

      ],
      */
    'source.init' => [
      SourceListener::class => 'initSource',
    ],
  ],
];
