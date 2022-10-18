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

    $message = $body['message'];
    $userId = $body['userId'];
    $receiverID = $body['receiverId'];
    $time = date("h:i:sa");

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

    $message = $body['message'];
    $userId = $body['userId'];
    $groupId = $body['groupID'];
    $time = date("h:i:sa");

    try {
      $instance = Message::instance();
      $message = $instance->sendGroupMessage($message, $time, $userId, $groupId);
      $this->sendCreated($message);
    } catch (Exception $e) {
      $this->sendServerError($e->getMessage());
    }
  }

  public function getPersonalMessages($body)
  {
    $errorMessages = array();
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
    $userId = $body['userId'];
    $receiverId = $body['receiverId'];
    try {
      $instance = Message::instance();
      $messages = $instance->getPersonalMessages($userId, $receiverId);
      $this->sendSuccess($messages);
    } catch (Exception $e) {
      $this->sendServerError($e->getMessage());
    }
  }
}

// Delete personal message
// Update personal message
// get all personal messages
// get all group messages
// Delete group message
// Update group message