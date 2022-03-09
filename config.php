<?php

use YOOtheme\Application;
$app = Application::getInstance();

$app->load(__DIR__ . '/modules/*/bootstrap.php');

return [];
