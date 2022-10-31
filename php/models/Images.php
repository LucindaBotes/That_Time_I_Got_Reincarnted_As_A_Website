<?php
require_once 'Database.php';

class Images extends Database
{

  public function uploadProfileImage($data, $Id, $type)
  {
    try{
      $table = $type . "_gallery";
      $image = $this->select(
        "SELECT * FROM $table WHERE externID = ?",
        ["i", $Id]
      );

      if(!$image){
        $this->insert(
          "INSERT INTO gallery (imagePath) VALUES (?)",
          ["s", $data['image_source']]
        );
        $imageID = $this->select(
          "SELECT id FROM gallery WHERE imagePath = ?",
          ["s", $data['image_source']]
        );
        $this->insert(
          "INSERT INTO $table (galleryID, externID) VALUES (?, ?)",
          ["ii", $imageID[0]['id'], $Id]
        );

        var_dump($imageID);

        return array(
          'imagePath' =>$data['image_source'],
          'externId' =>$Id,
          'imageID' =>$imageID[0]['id']
        );
      }
      else{
        throw new Exception('Image already exists', 500);
      }
    }
    catch(Exception $e){
      throw new Exception('Error uploading image', 500);
    }
  }

  public function uploadImage($data, $Id, $type)
  {
    try{
      $table = $type . "_gallery";

      $this->insert(
        "INSERT INTO gallery (imagePath) VALUES (?)",
        ["s", $data['image_source']]
      );
      $imageID = $this->select(
        "SELECT id FROM gallery WHERE imagePath = ?",
        ["s", $data['image_source']]
      );
      $this->insert(
        "INSERT INTO $table (galleryID, externID) VALUES (?, ?)",
        ["ii", $imageID[0]['id'], $Id]
      );

      var_dump($imageID);

      return array(
        'imagePath' =>$data['image_source'],
        'externId' =>$Id,
        'imageID' =>$imageID[0]['id']
      );
    }
    catch(Exception $e){
      throw new Exception('Error uploading image', 500);
    }
  }
  
  public function getProfileImage($Id)
  {
    try{
      $image = $this->select(
        "SELECT * FROM profile_gallery WHERE externID = ?",
        ["i", $Id]
      );

      if($image){
        $imagePath = $this->select(
          "SELECT imagePath FROM gallery WHERE id = ?",
          ["i", $image[0]['galleryID']]
        );
        return array(
          'imagePath' =>$imagePath[0]['imagePath'],
          'externId' =>$Id,
          'imageID' =>$image[0]['galleryID']
        );
      }
      else{
        throw new Exception('Image does not exist', 500);
      }
    }
    catch(Exception $e){
      throw new Exception('Error getting image', 500);
    }
  }
  
  public function getEventImages($Id)
  {
    try{
      $images = $this->select(
        "SELECT galleryID FROM event_gallery WHERE externID = ?",
        ["i", $Id]
      );
      
      $imagePaths = array();
      foreach($images as $image){
        $imagePath = $this->select(
          "SELECT imagePath FROM gallery WHERE id = ?",
          ["i", $image['galleryID']]
        );
        array_push($imagePaths, $imagePath[0]['imagePath']);
      }

      return array(
        'imagePaths' =>$imagePaths,
      );
    }
    catch(Exception $e){
      throw new Exception('Error getting image', 500);
    }
  }

  //upload
  // get
  // update
  // delete
}