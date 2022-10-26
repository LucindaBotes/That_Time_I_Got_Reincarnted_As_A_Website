<?php
// Lucinda Botes u19048263
require_once 'Controller.php';
require_once(realpath(dirname(__FILE__) . '/../models/User.php'));

class UserController extends Controller
{
  public function signup($body)
  {
    $errorMessages = array();
    if (!isset($body['name']) || $body['name'] === '') {
      array_push($errorMessages, 'Name is required');
    }

    if (!isset($body['password']) || $body['password'] === '') {
      array_push($errorMessages, 'Password is required');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $name = $body['name'];
    $password = $body['password'];
    $personal_level = 8;
    $gold = 0;
    $profile_picture = "../../../gallery/profile.jpg";

    try {
      $instance = User::instance();
      $user = $instance->addUser($name, $password, $profile_picture, $gold, $personal_level);
      $this->sendCreated($user);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function login($body)
  {
    $errorMessages = array();
    if (!isset($body["name"]) || $body["name"] === '') {
      array_push($errorMessages, 'Username is required');
    }

    if (!isset($body["password"]) || $body["password"] === '') {
      array_push($errorMessages, 'Password is required');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
    }

    $name = $body['name'];
    $password = $body['password'];

    try {
      $instance = User::instance();
      $user = $instance->validateLogin($name, $password);
      $this->sendSuccess($user);

    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function validateApiKey($body)
  {
    try {
      if (!isset($body['api_key']) || $body['api_key'] === '') {
        throw new Exception('Invalid API key provided', 401);
      }
      $instance = User::instance();
      return $instance->doesApiKeyExist($body['api_key']);
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), $e->getCode());
    }
  }

  public function createGroup($body){
    $errorMessages = array();
    if (!isset($body["groupName"]) || $body["groupName"] === '') {
      array_push($errorMessages, 'Group needs a name');
    }

    if (!isset($body["userId"]) || $body["userID"] === '') {
      array_push($errorMessages, 'You are not logged in');
    }


    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $groupName = $body['groupName'];
    $userId = $body['userId'];

    try {
      $instance = User::instance();
      $user = $instance->createGroup($groupName, $userId);
      $this->sendCreated($user);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function joinGroup($body){
    $errorMessages = array();
    if (!isset($body["groupId"]) || $body["groupId"] === '') {
      array_push($errorMessages, 'Group needs a name');
    }

    if (!isset($body["userId"]) || $body["userID"] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $groupId = $body['groupId'];
    $userId = $body['userId'];

    try {
      $instance = User::instance();
      $user = $instance->joinGroup($groupId, $userId);
      $this->sendCreated($user);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function getUserGroups($body){
    $errorMessages = array();
    if (!isset($body['userId']) || $body['userId'] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $user_id = $body['userId']; 

    try {
      $instance = User::instance();
      $user = $instance->getUserGroups($user_id);
      $this->sendSuccess($user);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function updateUser($body)
  {
    $errorMessages = array();

    if (!isset($body["userId"]) || $body["userId"] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    try {
      $instance = User::instance();
      $user = $instance->updateUser($body);
      $this->sendSuccess($user);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function deleteUser($body){
    try {
      if(!isset($body['userId']) || $body['userId'] === ''){
        throw new Exception('You are not logged in', 400);
      }
      $instance = User::instance();
      $instance->deleteUser($body['userId']);
      $this->sendSuccess('User deleted');
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }
}

