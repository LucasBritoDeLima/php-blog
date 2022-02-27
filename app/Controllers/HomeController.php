<?php

namespace App\Controllers;

class HomeController {

  private $container;

  public function __construct($container){
    $this->container = $container;
  }

  public function index($request, $response) {
    return $response->write($this->container->hello);
  }
}