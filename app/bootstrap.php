<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

require __DIR__ . "/../vendor/autoload.php";

$app = new Slim\App();

require __DIR__ . "/routes.php";