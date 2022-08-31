<?php
require_once('../controllers/UserController.php');

$userController = new UserController();

$body = json_decode(file_get_contents('php://input'), true);
// $userController->sendSuccess(json_encode($body));
try {
  $userController->login($body);

} catch (Exception $e) {
  switch ($e->getCode()) {
    case 400:
      $userController->sendBadRequest($e->getMessage());
      break;

    case 401:
      $userController->sendUnauthorized($e->getMessage());
      break;

    case 403:
      $userController->sendForbidden($e->getMessage());
      break;

    case 404:
      $userController->sendNotFound($e->getMessage());
      break;

    case 405:
      $userController->sendMethodNotAllowed($e->getMessage());
      break;

    case 501:
      $userController->sendNotImplemented($e->getMessage());
      break;

    default:
      $userController->sendInternalServerError($e->getMessage());
      break;
  }
}

// $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

// $name = isset($_POST["name"]) ? $_POST["name"] : null;
// $pass = isset($_POST["pass"]) ? $_POST["pass"] : null;

// $query = "SELECT * FROM users WHERE name = '$name' AND password = '$pass'";
// if ($row = mysqli_fetch_array($res)) {
//   echo "Hey there";
//   header('Location: ../../src/profile/');
// }
// else {
//   header('Location: ../../../../src/error/401.php');
// }
