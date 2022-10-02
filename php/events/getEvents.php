<?php
require_once('../controllers/EventController.php');

$eventController = new EventController();

try {
  $eventController->getEvents();
} catch (Exception $e) {
  switch ($e->getCode()) {
    case 400:
      $eventController->sendBadRequest($e->getMessage());
      break;

    case 401:
      $eventController->sendUnauthorized($e->getMessage());
      break;

    case 403:
      $eventController->sendForbidden($e->getMessage());
      break;

    case 404:
      $eventController->sendNotFound($e->getMessage());
      break;

    case 405:
      $eventController->sendMethodNotAllowed($e->getMessage());
      break;

    case 501:
      $eventController->sendNotImplemented($e->getMessage());
      break;

    default:
      $eventController->sendInternalServerError($e->getMessage());
      break;
  }
}
