<?php
require_once('../models/User.php');
session_start();

$errorMessages = array();
try {

  if (!isset($_POST['name']) || $_POST['name'] === '') {
    array_push($errorMessages, 'Name is required');
  }

  if (!isset($_POST['password']) || $_POST['password'] === '') {
    array_push($errorMessages, 'Password is required');
  }

  if ($errorMessages !== []) {
    throw new Exception('', 400);
  }

  $instance = User::instance();
  $user = $instance->addUser($_POST['name'], $_POST['password']);
  $_SESSION['user'] = $user;
  $_SESSION['show_api_key'] = true;

  header('Location: ../../../../src/splash/index.html');
} catch (Exception $e) {
  array_push($errorMessages,  $e->getMessage());
  $errorMessages = array_filter($errorMessages);
  $_SESSION['invalid_signup_details'] = $errorMessages;
  header('Location: register.php');
}
