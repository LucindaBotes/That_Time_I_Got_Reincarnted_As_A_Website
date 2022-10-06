<?php
// Lucinda Botes u19048263
require_once(realpath(dirname(__FILE__) . '/../models/Event.php'));
require_once(realpath(dirname(__FILE__) . '/../models/User.php'));
require_once 'Controller.php';
require_once(realpath(dirname(__FILE__) . '/../common/config.php'));
class EventController extends Controller
{
  public function addEvents($body)
  {
    $errorMessages = array();
    if (!isset($body['title']) || $body['title'] === '') {
      array_push($errorMessages, 'Title is required');
    }

    if (!isset($body['description']) || $body['description'] === '') {
      array_push($errorMessages, 'Description is required');
    }

    if (!isset($body['date']) || $body['date'] === '') {
      array_push($errorMessages, 'Date is required');
    }

    if (!isset($body['location']) || $body['location'] === '') {
      array_push($errorMessages, 'Location is required');
    }

    if (!isset($body['level']) || $body['level'] === '') {
      array_push($errorMessages, 'Level is required');
    }

    if (!isset($body['reward']) || $body['reward'] === '') {
      array_push($errorMessages, 'Reward is required');
    }

    if (!isset($body['userId']) || $body['userId'] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $title = $body['title'];
    $description = $body['description'];
    $date = $body['date'];
    $location = $body['location'];
    $level = $body['level'];
    $reward = $body['reward'];
    $userId = $body['userId'];
    $thumbnail = $body['event_image'];

    try {
      $instance = Event::instance();
      $event = $instance->addEvent($title, $description, $date, $location, $level, $reward, $userId, $thumbnail);
      $this->sendCreated($event);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function getEvents($userId)
  {
    try {
      $instance = Event::instance();
      $events = $instance->getEvents($userId);
      $this->sendSuccess($events);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }
}
