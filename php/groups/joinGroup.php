<?php
require_once('../controllers/UserController.php');

$userController = new UserController();

$body = json_decode(file_get_contents('php://input'), true);

try {
  $userController->joinGroup($body);

} catch (Exception $e) {
  switch ($e->getCode()) {
    case 400:
      $userController->sendBadRequest($e->getMessage());
      break;

    case 401:
      $userController->sendUnauthorized($e->getMessage());
      break;

    case 403:
      $userController->sendForbidden($e->getMessage());
      break;

    case 404:
      $userController->sendNotFound($e->getMessage());
      break;

    case 405:
      $userController->sendMethodNotAllowed($e->getMessage());
      break;

    case 501:
      $userController->sendNotImplemented($e->getMessage());
      break;

    default:
      $userController->sendInternalServerError($e->getMessage());
      break;
  }
}
