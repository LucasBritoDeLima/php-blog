<?php

namespace App\Controllers;

class HomeController {
  public function index($request, $response) {
    return $response->write(
      'What is your name? My name is: ' . $request->getParam('name')
    );
  }
}