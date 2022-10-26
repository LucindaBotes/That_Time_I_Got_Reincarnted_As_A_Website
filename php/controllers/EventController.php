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
    if (!isset($_POST['title']) || $_POST['title'] === '') {
      array_push($errorMessages, 'Title is required');
    }

    if (!isset($_POST['description']) || $_POST['description'] === '') {
      array_push($errorMessages, 'Description is required');
    }

    if (!isset($_POST['date']) || $_POST['date'] === '') {
      array_push($errorMessages, 'Date is required');
    }

    if (!isset($_POST['time']) || $_POST['time'] === '') {
      array_push($errorMessages, 'Time is required');
    }

    if (!isset($_POST['reward']) || $_POST['reward'] === '') {
      array_push($errorMessages, 'Reward is required');
    }

    if (!isset($_POST['userId']) || $_POST['userId'] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if (!isset($_POST['monster']) || $_POST['monster'] === '') {
      array_push($errorMessages, 'Monster is required');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $extension = pathinfo($_FILES['eventImage']['name'], PATHINFO_EXTENSION);
    $new_name = time() . '.' . $extension;
    move_uploaded_file($_FILES['eventImage']['tmp_name'], '../../gallery/' . $new_name);
    $thumbnail = array(
      'image_source'		=>	'../../gallery/' . $new_name
    );
    
    $name = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date']; // 2020-12-31
    $time = $_POST['time']; // 12:00
    $monsterId = $_POST['monster'];
    $reward = $_POST['reward'];
    $userId = $_POST['userId'];
    
    try {
      $instance = Event::instance();
      $event = $instance->addEvent($name, $description, $date, $time, $monsterId, $reward, $userId, $thumbnail);
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

  public function uploadImage($body){
    try{
      $errorMessages = array();
      if (!isset($_POST['eventId']) || $_POST['eventId'] === '') {
        array_push($errorMessages, 'Event is required');
      }

      if(!isset($_FILES['image']))
      {
        array_push($errorMessages, 'Image is required');
      }

      if ($errorMessages !== []) {
        $this->sendBadRequest($errorMessages);
        die();
      }

      $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      $new_name = time() . '.' . $extension;
      move_uploaded_file($_FILES['image']['tmp_name'], '../../gallery/' . $new_name);
      $data = array(
        'image_source'		=>	'../../gallery/' . $new_name
        //"../../../gallery/"
      );

      $eventId = $_POST['eventId'];

      $instance = Event::instance();
      $event = $instance->uploadImage($data, $eventId);
      $this->sendSuccess($event);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function deleteEvent($body) {
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
      $event = $instance->deleteEvent($body);
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
