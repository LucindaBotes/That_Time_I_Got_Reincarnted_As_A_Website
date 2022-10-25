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
    if (!isset($body['title']) || $body['title'] === '') {
      array_push($errorMessages, 'title is required');
    }

    if (!isset($body['description']) || $body['description'] === '') {
      array_push($errorMessages, 'Description is required');
    }

    if (!isset($body['date']) || $body['date'] === '') {
      array_push($errorMessages, 'Date is required');
    }

    // if (!isset($body['time']) || $body['time'] === '') {
    //   array_push($errorMessages, 'Time is required');
    // }

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

    
    $name = $body['title'];
    $description = $body['description'];
    $date = $body['date']; // 2020-12-31
    // $time = $body['time']; // 12:00
    $time = "00:12:00";
    $level = $body['level'];
    $reward = $body['reward'];
    $userId = $body['userId'];
    $thumbnail = $body['thumbnail'] ? $body['thumbnail'] : "../../gallery/placeholderImage.jpg";
    
    
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

  public function createEventList($body)
  {
    try {
      $errorMessages = array();
      if (!isset($body['listName']) || $body['listName'] === '') {
        array_push($errorMessages, 'List name is required');
      }

      if (!isset($body['userId']) || $body['userId'] === '') {
        array_push($errorMessages, 'You are not logged in');
      }

      if ($errorMessages !== []) {
        $this->sendBadRequest($errorMessages);
        die();
      }

      $listName = $body['listName'];
      $userId = $body['userId'];

      $instance = Event::instance();
      $eventList = $instance->createEventList($listName, $userId);
      $this->sendSuccess($eventList);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }

  }

  public function addReview($body){
    try{
      $errorMessages = array();
      if (!isset($body['review']) || $body['review'] === '') {
        array_push($errorMessages, 'Review is required');
      }

      if (!isset($body['userId']) || $body['userId'] === '') {
        array_push($errorMessages, 'You are not logged in');
      }

      if (!isset($body['eventId']) || $body['eventId'] === '') {
        array_push($errorMessages, 'Event is required');
      }

      if ($errorMessages !== []) {
        $this->sendBadRequest($errorMessages);
        die();
      }

      $review = $body['review'];
      $userId = $body['userId'];
      $eventId = $body['eventId'];

      $instance = Event::instance();
      $event = $instance->addReview($review, $userId, $eventId);
      $this->sendSuccess($event);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }

  }

  public function rateEvent($body){
    try{
      $errorMessages = array();
      if (!isset($body['rating']) || $body['rating'] === '') {
        array_push($errorMessages, 'Rating is required');
      }

      if (!isset($body['userId']) || $body['userId'] === '') {
        array_push($errorMessages, 'You are not logged in');
      }

      if (!isset($body['eventId']) || $body['eventId'] === '') {
        array_push($errorMessages, 'Event is required');
      }

      if ($errorMessages !== []) {
        $this->sendBadRequest($errorMessages);
        die();
      }

      $rating = $body['rating'];
      $userId = $body['userId'];
      $eventId = $body['eventId'];

      $instance = Event::instance();
      $event = $instance->rateEvent($rating, $userId, $eventId);
      $this->sendSuccess($event);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }

  }

  public function updateReview($body){
    try{
      $errorMessages = array();
      if (!isset($body['review']) || $body['review'] === '') {
        array_push($errorMessages, 'Review is required');
      }

      if (!isset($body['userId']) || $body['userId'] === '') {
        array_push($errorMessages, 'You are not logged in');
      }

      if (!isset($body['eventId']) || $body['eventId'] === '') {
        array_push($errorMessages, 'Event is required');
      }

      if ($errorMessages !== []) {
        $this->sendBadRequest($errorMessages);
        die();
      }

      $review = $body['review'];
      $userId = $body['userId'];
      $eventId = $body['eventId'];

      $instance = Event::instance();
      $event = $instance->updateReview($review, $userId, $eventId);
      $this->sendSuccess($event);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function deleteReview($body){
    try{
      $errorMessages = array();
      if (!isset($body['userId']) || $body['userId'] === '') {
        array_push($errorMessages, 'You are not logged in');
      }

      if (!isset($body['eventId']) || $body['eventId'] === '') {
        array_push($errorMessages, 'Event is required');
      }

      if ($errorMessages !== []) {
        $this->sendBadRequest($errorMessages);
        die();
      }

      $userId = $body['userId'];
      $eventId = $body['eventId'];

      $instance = Event::instance();
      $event = $instance->deleteReview($userId, $eventId);
      $this->sendSuccess($event);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function deleteRating($body){
    try{
      $errorMessages = array();
      if (!isset($body['userId']) || $body['userId'] === '') {
        array_push($errorMessages, 'You are not logged in');
      }

      if (!isset($body['eventId']) || $body['eventId'] === '') {
        array_push($errorMessages, 'Event is required');
      }

      if ($errorMessages !== []) {
        $this->sendBadRequest($errorMessages);
        die();
      }

      $userId = $body['userId'];
      $eventId = $body['eventId'];

      $instance = Event::instance();
      $event = $instance->deleteRating($userId, $eventId);
      $this->sendSuccess($event);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }catch (Exception $e){
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  // public function updateEvent($body){
  //   try{
  //     $errorMessages = array();
  //     if (!isset($body['update']) || $body['update'] === '') {
  //       array_push($errorMessages, 'Update is required');
  //     }

  //     if (!isset($body['value']) || $body['value'] === '') {
  //       array_push($errorMessages, 'value is required');
  //     }

  //     if (!isset($body['eventId']) || $body['eventId'] === '') {
  //       array_push($errorMessages, 'Event is required');
  //     }

  //     if ($errorMessages !== []) {
  //       $this->sendBadRequest($errorMessages);
  //       die();
  //     }

  //     $update = $body['update'];
  //     $value = $body['value'];
  //     $eventId = $body['eventId'];

  //     $instance = Event::instance();
  //     $event = $instance->updateEvent($eventId, $update, $value);
  //     $this->sendSuccess($event);
  //   } catch (Exception $e) {
  //     if ($e->getCode() === 400) {
  //       $this->sendBadRequest($e->getMessage());
  //     } else {
  //       $this->sendInternalServerError($e->getMessage());
  //     }
  //   }
  // }

  public function updateEvent($body) {
    try {
      $errorMessages = array();
      if (!isset($body['eventId']) || $body['eventId'] === '') {
        array_push($errorMessages, 'Event is required');
      }

      if ($errorMessages !== []) {
        $this->sendBadRequest($errorMessages);
        die();
      }

      $instance = Event::instance();
      $event = $instance->updateEvent($body);
      $this->sendSuccess($event);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }
}

// Delete event
// Update event - Name
// Update event - Description
// Update event - Date
// Update event - Time
// Update event - Reward
// Delete event from list
// Delete Event from list
// Delete review
// Delete rating
// Upload image to gallery
// Delete image from gallery
