<?php

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/login', 'AuthController:login')->setName('auth.login');
$app->get('/registrar','AuthController:register')->setName('auth.register');