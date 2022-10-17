<?php
// Lucinda Botes u19048263
require_once(realpath(dirname(__FILE__) . '/../models/Event.php'));
require_once(realpath(dirname(__FILE__) . '/../models/User.php'));
require_once 'Controller.php';
require_once(realpath(dirname(__FILE__) . '/../common/config.php'));
class EventController extends Controller
{
  public function getMonsters($body)
  {
    $errorMessages = array();
    if (!isset($body['userId']) || $body['userId'] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }
    $userId = $body['userId'];
    try {
      $instance = Event::instance();
      $monsters = $instance->getMonsters($userId);
      $this->sendSuccess($monsters);
    } catch (Exception $e) {
      $this->sendServerError($e->getMessage());
    }
  }

  public function addEvents($body)
  {
    $errorMessages = array();
    if (!isset($body['name']) || $body['name'] === '') {
      array_push($errorMessages, 'name is required');
    }

    if (!isset($body['description']) || $body['description'] === '') {
      array_push($errorMessages, 'Description is required');
    }

    if (!isset($body['date']) || $body['date'] === '') {
      array_push($errorMessages, 'Date is required');
    }

    if (!isset($body['time']) || $body['time'] === '') {
      array_push($errorMessages, 'Time is required');
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

    $name = $body['name'];
    $description = $body['description'];
    $date = $body['date']; // 2020-12-31
    $time = $body['time']; // 12:00
    $level = $body['level'];
    $reward = $body['reward'];
    $userId = $body['userId'];
    // $thumbnail_path = $body['thumbnail'] ? $body['thumbnail'] : "../../gallery/placeholderImage.jpg";
    $thumbnail = 2;


    try {
      $instance = Event::instance();
      $event = $instance->addEvent($name, $description, $date, $time, $level, $reward, $userId, $thumbnail);
      $this->sendCreated($event);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function getMyEvents($userId)
  {
    try {
      $instance = Event::instance();
      $events = $instance->getMyEvents($userId);
      $this->sendSuccess($events);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function getAllEvents()
  {
    try {
      $instance = Event::instance();
      $events = $instance->getAllEvents();
      $this->sendSuccess($events);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function getGroupEvents($groupId)
  {
    try {
      $instance = Event::instance();
      $events = $instance->getGroupEvents($groupId);
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
