<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new \Silex\Application();

$app['debug'] = true;

require __DIR__.'/config/registerService.php';
require __DIR__.'/config/routes.php';

return $app;



