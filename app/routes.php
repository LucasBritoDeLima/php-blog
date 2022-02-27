<?php

$app->get('/', function($request, $response){
  return $response->write(
    "What is your name? My name is: {$request->getParam('name')}"
  );
});