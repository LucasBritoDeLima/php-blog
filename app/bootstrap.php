<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

require __DIR__ . "/../vendor/autoload.php";

$app = new Slim\App();

$container = $app->getContainer();

$container['HomeController'] = function($container) {
  return new App\Controllers\HomeController;
};

require __DIR__ . "/routes.php";