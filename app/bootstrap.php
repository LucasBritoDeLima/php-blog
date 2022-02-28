<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

require __DIR__ . "/../vendor/autoload.php";

$app = new Slim\App([
  'settings' => [
    'displayErrorDetails' => true,
    'db' => [
      'driver' => 'mysql',
      'host' => 'localhost',
      'database' => 'mpblog',
      'username' => 'usuario',
      'password' => '123456',
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => '',
    ]
  ]
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['view'] = function ($container) {
  $view = new Slim\Views\Twig(__DIR__ . "/../resources/views", [
    'cache' => false,
  ]);

  $view->addExtension(new \Slim\Views\TwigExtension(
    $container->router,
    $container->request->getUri()
  ));

  return $view;
};

$container['hello'] = "Hello, World!";

$container['HomeController'] = function ($container) {
  return new App\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container) {
  return new App\Controllers\AuthController($container);
};


require __DIR__ . "/routes.php";
