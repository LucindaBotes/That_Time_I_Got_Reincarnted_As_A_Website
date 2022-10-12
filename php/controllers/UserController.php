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
    $personal_level = "F";
    $gold = 0;
    $profile_picture = null;

    try {
      $instance = User::instance();
      $user = $instance->addUser($name, $password, $profile_picture, $gold, $personal_level);
      var_dump($user);
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

  public function update($body)
  {
    $errorMessages = array();

    if (!isset($body["theme"]) || $body["theme"] === '') {
      array_push($errorMessages, 'Theme is not set');
    }

    if (!isset($body["categories"]) || $body["categories"] === '') {
      array_push($errorMessages, 'Preference in filter is not set');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $api_key = $body['api_key'];
    $theme = $body['theme'];
    $filter = $body['categories'];
    $body['user']['filter'] = $filter;
    $body['user']['theme'] = $theme;

    try {
      $instance = User::instance();
      $instance->updateUser($theme, $filter, $api_key);
      if (in_array('*', $body['return'])) {
        $this->sendSuccess($body['user']);
        die();
      }

      $returnValues = array('api_key', 'name', 'surname', 'email', 'theme', 'filter', 'id');
      $return = array();
      foreach ($body['return'] as $value) {
        if (in_array($value, $returnValues)) {
          $return[$value] = $body['user'][$value];
        }
      }

      $this->sendSuccess($return);
    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function rateArticle($body)
  {
    $errorMessages = array();

    if (!isset($body["rating"]) || $body["rating"] === '') {
      array_push($errorMessages, 'No rating was provided');
    }

    if (!isset($body["article"]) || $body["article"] === '') {
      array_push($errorMessages, 'No article was provided');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $rating = $body['rating'];
    $article = $body['article'];
    $user_id = $body['user']['id'];

    try {
      
      $instance = User::instance();
      $instance->rate($user_id, $article, $rating);      
      $this->sendSuccess(null);

    } catch (Exception $e) {
      if ($e->getCode() === 400) {
        $this->sendBadRequest($e->getMessage());
      } else {
        $this->sendInternalServerError($e->getMessage());
      }
    }
  }

  public function chat($body)
  {
    throw new Exception('Chat is not implemented yet', 501);
  }
}

