<?php

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/login', '')->setName('auth.login');
$app->get('/registrar','')->setName('auth.register');