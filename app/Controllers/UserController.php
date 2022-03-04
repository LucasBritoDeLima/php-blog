<?php

namespace App\Controllers;

use Slim\Http\UploadedFile;

class UserController extends Controller {

  public function avatar($request, $response) {

    if($request->isGet())
      return $this->container->view->render($response, 'user/avatar.twig');
  }

  private function moveUploadFile($directory, UploadedFile $uploadedFile) {
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename  = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
  }
}