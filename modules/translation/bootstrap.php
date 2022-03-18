<?php

namespace YOOtheme;

return [
    'services' => [
        Translator::class => function (Config $config) {
            $translator = new Translation\Translator();
            $translator->setLocale($config('locale.code'));
            $translator->addResource(Path::get("{$config('theme.childDir')}/languages/{$config('locale.code')}.json"));
            return $translator;
        },
    ],
];
?>