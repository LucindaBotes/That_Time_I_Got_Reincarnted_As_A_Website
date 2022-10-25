<?php
// Lucinda Botes u19048263
require_once(realpath(dirname(__FILE__) . '/../models/Images.php'));
require_once(realpath(dirname(__FILE__) . '/../models/User.php'));
require_once 'Controller.php';
require_once(realpath(dirname(__FILE__) . '/../common/config.php'));
class ImageController extends Controller
{
  public function uploadProfileImage($body){
    $errorMessages = array();
    if(!isset($_FILES['sample_image']))
    {
      array_push($errorMessages, 'Image is required');
    }

    if (!isset($_POST['userId']) || $_POST['userId'] === '') {
      array_push($errorMessages, 'You are not logged in');
    }

    if ($errorMessages !== []) {
      $this->sendBadRequest($errorMessages);
      die();
    }

    $extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);
    $new_name = time() . '.' . $extension;
    move_uploaded_file($_FILES['sample_image']['tmp_name'], '../../gallery/' . $new_name);
    $data = array(
      'image_source'		=>	'../../gallery/' . $new_name
      //"../../../gallery/"
    );

    $userId = $_POST['userId'];
    $type = 'profile';
    try {
      $instance = Images::instance();
      $image = $instance->uploadImage($data, $userId, $type);
      $this->sendCreated($image);
    } catch (Exception $e) {
      $this->sendServerError($e->getMessage());
    }
  }
  // uploadProfileImage
  // getProfileImage
  // updateProfileImage
  // deleteProfileImage
  // uploadEventThumbnail
  // getEventThumbnail
  // updateEventThumbnail
  // deleteEventThumbnail
  // uploadEventImage
  // getEventImage
  // updateEventImage
  // deleteEventImage

}