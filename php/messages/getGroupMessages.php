<?php
require_once('../controllers/MessageController.php');

$messageController = new MessageController();

$body = json_decode(file_get_contents('php://input'), true);

try {
  $messageController->getGroupMessages($body);
} catch (Exception $e) {
  switch ($e->getCode()) {
    case 400:
      $messageController->sendBadRequest($e->getMessage());
      break;

    case 401:
      $messageController->sendUnauthorized($e->getMessage());
      break;

    case 403:
      $messageController->sendForbidden($e->getMessage());
      break;

    case 404:
      $messageController->sendNotFound($e->getMessage());
      break;

    case 405:
      $messageController->sendMethodNotAllowed($e->getMessage());
      break;

    case 501:
      $messageController->sendNotImplemented($e->getMessage());
      break;

    default:
      $messageController->sendInternalServerError($e->getMessage());
      break;
  }
}
