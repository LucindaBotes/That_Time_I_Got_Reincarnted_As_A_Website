<?php
// Lucinda Botes u19048263
require_once(realpath(dirname(__FILE__) . '/../models/Messages.php'));
require_once(realpath(dirname(__FILE__) . '/../models/User.php'));
require_once 'Controller.php';
require_once(realpath(dirname(__FILE__) . '/../common/config.php'));
class MessageController extends Controller
{
  public function sendPersonalMessage($body)
  {
    $errorMessages = array();
    if (!isset($body['message']) || $body['message'] === '') {
      array_push($errorMessages, 'Message is required');
    }

    if (!isset($body['userId']) || $body['userId'] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if (!isset($body['receiverId']) || $body['receiverId'] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $time = date("h:i:sa");
    $message = $body['message'];
    $userId = $body['userId'];
    $receiverID = $body['receiverId'];

    try {
      $instance = Message::instance();
      $message = $instance->sendPersonalMessage($message, $time, $userId, $receiverID);
      $this->sendCreated($message);
    } catch (Exception $e) {
      $this->sendServerError($e->getMessage());
    }
  }

  public function sendGroupMessage($body)
  {
    $errorMessages = array();
    if (!isset($body['message']) || $body['message'] === '') {
      array_push($errorMessages, 'Message is required');
    }

    if (!isset($body['userId']) || $body['userId'] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if (!isset($body['groupID']) || $body['groupID'] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $time = date("h:i:sa");
    $message = $body['message'];
    $userId = $body['userId'];
    $groupId = $body['groupID'];

    try {
      $instance = Message::instance();
      $message = $instance->sendGroupMessage($message, $time, $userId, $groupId);
      $this->sendCreated($message);
    } catch (Exception $e) {
      $this->sendServerError($e->getMessage());
    }
  }
}