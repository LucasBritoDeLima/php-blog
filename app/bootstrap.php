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

$container['validator'] = function($container) {
  return new App\Validation\Validator;
};

$container['flash'] = function($container) {
  return new Slim\Flash\Messages;
};

$container['mail'] = function($container) {
  return new App\Mail($container);
};

$container['auth'] = function($container) {
  return new App\Auth\Auth($container);
};

$container['upload_directory'] = __DIR__ . '/../public/uploads';

$container['view'] = function ($container) {
  $view = new Slim\Views\Twig(__DIR__ . "/../resources/views", [
    'cache' => false,
  ]);

  $view->addExtension(new \Slim\Views\TwigExtension(
    $container->router,
    $container->request->getUri()
  ));

  $view->getEnvironment()->addGlobal('flash', $container->flash);

  $view->getEnvironment()->addGlobal('auth', [
    'check' => $container->auth->check(),
    'user' => $container->auth->user(),
  ]);

  return $view;
};

/*$container['hello'] = "Hello, World!";

$container['HomeController'] = function ($container) {
  return new App\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container) {
  return new App\Controllers\AuthController($container);
};*/

require __DIR__ . '/commons.php';

getControllers($container, [
  'HomeController', 
  'AuthController', 
  'UserController',
  'PostController'
]);

$app->add(new App\Middleware\DisplayInputErrorsMiddleware($container));

require __DIR__ . "/routes.php";