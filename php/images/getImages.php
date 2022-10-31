<?php 
require_once('../controllers/ImageController.php');

$imageController = new ImageController();

$body = json_decode(file_get_contents('php://input'), true);

try {
  $imageController->getImages($body);
} catch (Exception $e) {
  switch ($e->getCode()) {
    case 400:
      $imageController->sendBadRequest($e->getMessage());
      break;

    case 401:
      $imageController->sendUnauthorized($e->getMessage());
      break;

    case 403:
      $imageController->sendForbidden($e->getMessage());
      break;

    case 404:
      $imageController->sendNotFound($e->getMessage());
      break;

    case 405:
      $imageController->sendMethodNotAllowed($e->getMessage());
      break;

    case 501:
      $imageController->sendNotImplemented($e->getMessage());
      break;

    default:
      $imageController->sendInternalServerError($e->getMessage());
      break;
  }
}
