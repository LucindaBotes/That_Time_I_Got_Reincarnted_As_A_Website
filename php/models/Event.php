<?php
require_once 'Database.php';
// Lucinda Botes u19048263
class Event extends Database
{
  public $cols = array(
    "id" => "id",
    "name" => "eName",
    "description" => "eDescription",
    "date" => "eDate",
    "time" => "eTime",
    "location" => "eLocation",
    "level" => "eLevel",
    "reward" => "eReward",
    "thumbnail" => "eThumbnail",
  );

  public $types = array(
    "id" => "i",
    "name" => "s",
    "description" => "s",
    "date" => "s",
    "time" => "s",
    "location" => "i",
    "level" => "i",
    "reward" => "d",
    "thumbnail" => "i",
  );

  public function getMonsters($userId){
    try {
      $userLevel = $this->select(
        "SELECT uLevel FROM user WHERE id = ?",
        ["i", $userId]
      );

      $level = $this->select(
        "SELECT `Level` FROM `level` WHERE id = ?",
        ["i", $userLevel[0]['uLevel']]
      );
      
      $monsters = $this->select("SELECT * FROM monsters WHERE mLevel = ?", ["s", $level[0]['Level']]);
      return $monsters;

    } catch (Exception $e) {
      throw new Exception('Error getting monsters', 500);
    }
  }

  public function addEvent($title, $description, $date, $time, $monsterId, $reward, $userId, $thumbnail)
  {
    try{
      $level = $this->select(
        "SELECT uLevel FROM user WHERE id = ?",
        ["i", $userId]
      );

      var_dump($level);

      $location_id = $this->select(
        "SELECT uLocation FROM user WHERE id = ?", ["i", $userId]
      );

      $location = $location_id[0]['uLocation'];

      $this->insert(
        "INSERT INTO events (eName, eDescription, eDate, eTime, eLocation, eLevel, eReward, eThumbnail) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        ["ssssiidi", $title, $description, $date, $time, $location, $level, $reward, $thumbnail]
      );
      $eventID = $this->select(
        "SELECT id FROM events WHERE eName = ? AND eDescription = ? AND eDate = ? AND eTime = ? AND eLocation = ? AND eLevel = ? AND eReward = ? AND eThumbnail = ?",
        ["ssssiidi", $title, $description, $date, $time, $location, $level, $reward, $thumbnail]
      );
      
      $this->insert(
        "INSERT INTO user_event (uID, eID) VALUES (?, ?)",
        ["ii", $userId, $eventID[0]['id']]
      );

      $this->insert(
        "INSERT INTO gallery (imagePath) VALUES (?)",
        ["s", $thumbnail]
      );

      $thumbnailID = $this->select(
        "SELECT id FROM gallery WHERE imagePath = ?",
        ["s", $thumbnail]
      );

      $this->insert(
        "INSERT INTO thumbnail_gallery (galleryID, externID) VALUES (?, ?)",
        ["ii", $thumbnailID[0]['id'], $eventID[0]['id']]
      );

      $thumbnailGalleryID = $this->select(
        "SELECT id FROM thumbnail_gallery WHERE galleryID = ? AND externID = ?",
        ["ii", $thumbnailID[0]['id'], $eventID[0]['id']]
      );

      $this->update(
        "UPDATE events SET eThumbnail = ? WHERE id = ?",
        ["ii", $thumbnailGalleryID[0]['id'], $eventID[0]['id']]
      );

      $this->insert(
        "INSERT INTO event_monster (eID, mID) VALUES (?, ?)",
        ["ii", $eventID[0]['id'], $monsterId]
      );

      return array(
        'eventID' =>$eventID[0]['id'],
        'title' =>$title,
        'description' =>$description,
        'date' =>$date,
        'time' =>$time,
        'location' =>$location,
        'level' => $level[0]['uLevel'],
        'reward' =>$reward,
        'monsterId' =>$monsterId,
        'event_thumbnail' =>$thumbnail
      );
    }
    catch(Exception $e){
      throw new Exception('Error adding event', 500);
    }
    
  }

  public function getAllEvents()
  {
    try{
      $result = $this->select("SELECT * FROM events ORDER BY eDate ASC", []);
      
      $events = array();
      foreach($result as $event){
        $events[] = $this->getEvent($event['id']);
      }
      return $events;
      
    }
    catch(Exception $e){
      throw new Exception('Error getting events', 500);
    }
  }

  public function getEvent($id)
  {
    try{
        // get the location from events table
        $event = $this->select(
          "SELECT * FROM events WHERE id = ?",
          ["i", $id]
        );

        // get the galleryId from the thumbnail_gallery table
        $galleryId = $this->select(
          "SELECT galleryID FROM thumbnail_gallery WHERE externID = ?",
          ["i", $id]
        );
        
        // get the image path from the gallery table
        $imagePath = $this->select(
          "SELECT imagePath FROM gallery WHERE id = ?",
          ["i", $galleryId[0]['galleryID']]
        );

        // get the city and town from the location table
        $location = $this->select(
          "SELECT cID, tID FROM location WHERE id = ?",
          ["i", $event[0]['eLocation']]
        );

        // get the city name from the city table
        $city = $this->select(
          "SELECT wName FROM world WHERE id = ?",
          ["i", $location[0]['cID']]
        );

        // get the town name from the town table
        $town = $this->select(
          "SELECT tName FROM town WHERE id = ?",
          ["i", $location[0]['tID']]
        );

        // get the monster id from the event_monster table
        $monsterId = $this->select(
          "SELECT mID FROM event_monster WHERE eID = ?",
          ["i", $id]
        );

        // get the monster name from the monsters table
        $monsterName = $this->select(
          "SELECT mName FROM monsters WHERE id = ?",
          ["i", $monsterId[0]['mID']]
        );

        // get the event level from the level table
        $level = $this->select(
          "SELECT Level FROM level WHERE id = ?",
          ["i", $event[0]['eLevel']]
        );

        // fromat the data to be returned
        $event = array(
          'id' => $id,
          'title' => $event[0]['eName'],
          'description' => $event[0]['eDescription'],
          'date' => $event[0]['eDate'],
          'time' => $event[0]['eTime'],
          'location' => $city[0]['wName'] . ', ' . $town[0]['tName'],
          'level' => $level[0]['Level'],
          'reward' => $event[0]['eReward'],
          'monster' => $monsterName[0]['mName'],
          'event_thumbnail' => $imagePath[0]['imagePath']
        );

        return $event;
        
    }
    catch(Exception $e){
      throw new Exception('Error getting event', 500);
    }
  }

  public function getMyEvents($id)
  {
    try{
      $eventList = $this->select("SELECT * FROM user_event WHERE uID = ?", ["i", $id]);
      $events = [];
      foreach($eventList as $event){
          $events[] = $this->select("SELECT * FROM events WHERE id = ?", ["i", $event['eID']]);
      }
      return $events;
    }
    catch(Exception $e){
      throw new Exception('Error getting event', 500);
    }
  }

  public function getGroupEvents($id)
  {
    try{
      $groups = $this->select("SELECT gID FROM group_users WHERE uID = ?", ["i", $id]);

      $users = [];
      foreach($groups as $group){
        $users[] = $this->select("SELECT uID FROM group_users WHERE gID = ?", ["i", $group['gID']]);
      }
      
      $events = [];

      foreach($users as $user){
        $newUID = $user[0]['uID'];
        $events[] = $this->select("SELECT eID FROM user_event WHERE uID = ?", ["i", $newUID]);
      }

      $eventShown = [];
      foreach($events as $event){
        $eventShown[] = $this->select("SELECT * FROM events WHERE id = ?", ["i", $event[0]['eID']]);
      }

      return $eventShown;
    }
    catch(Exception $e){
      throw new Exception('Error getting event', 500);
    }
  }

  public function createEventList($listName, $userId){
    try {
      $this->insert(
        "INSERT INTO lists (lName) VALUES (?)",
        ["s", $listName]
      );

      $listID = $this->select(
        "SELECT id FROM lists WHERE lName = ?",
        ["s", $listName]
      );

      $this->insert(
        "INSERT INTO user_lists (uID, listID) VALUES (?, ?)",
        ["ii", $userId, $listID[0]['id']]
      );

      return array(
        'listName' =>$listName
      );
    }
    catch(Exception $e){
      throw new Exception('Error creating event list', 500);
    } catch (Exception $e) {
      throw new Exception('Error creating event list', 500);
    }
  }

  public function addReview($review, $userId, $eventId){
    try{
      $check = $this->select(
        "SELECT * FROM event_reviews WHERE uID = ? AND eID = ?",
        ["ii", $userId, $eventId]
      );
      
      if($check){
        throw new Exception('You have already reviewed this event', 500);
      }

      $this->insert(
        "INSERT INTO reviews (rText) VALUES (?)",
        ["s", $review]
      );

      //TODO: Cannot have duplicate reviews
      $reviewID = $this->select(
        "SELECT id FROM reviews WHERE rText = ?",
        ["s", $review]
      );
      
      $this->insert(
        "INSERT INTO event_reviews (reviewID, eID, uID) VALUES (?, ?, ?)",
        ["iii", $reviewID[0]['id'], $eventId, $userId]
      );
      
      return array(
        'review' =>$review
      );
    }
    catch(Exception $e){
      throw new Exception('Error adding review', 500);
    }
  }

  public function rateEvent($rating, $userId, $eventId){
    try{
      $ratingId = $this->select(
        "SELECT id FROM ratings WHERE rating = ?",
        ["d", $rating]
      );

      $this->insert(
        "INSERT INTO event_ratings (ratingID, eID, uID) VALUES (?, ?, ?)",
        ["iii", $ratingId[0]['id'], $eventId, $userId]
      );

      return array(
        'rating' =>$rating
      );
    }
    catch(Exception $e){
      throw new Exception('Error rating event', 500);
    }
  }

  public function updateReview($review, $userId, $eventId){
    try{
      $reviewID = $this->select(
        "SELECT reviewId FROM event_reviews WHERE eID = ? AND uID = ?",
        ["ii", $eventId, $userId]
      );

      $this->update(
        "UPDATE reviews SET rText = ? WHERE id = ?",
        ["si", $review, $reviewID[0]['reviewId']]
      );
    }
    catch(Exception $e){
      throw new Exception('Error updating review', 500);
    }
  }

  public function deleteEvent($eventId){
    try{
      // set deleted column in events table to 1
      $this->update(
        "UPDATE events SET deleted = 1 WHERE id = ?",
        ["i", $eventId]
      );
    }
    catch(Exception $e){
      throw new Exception('Error deleting event', 500);
    }
  }

  public function deleteReview($userId, $eventId){
    try{
      $reviewID = $this->select(
        "SELECT reviewID FROM event_reviews WHERE eID = ? AND uID = ?",
        ["ii", $eventId, $userId]
      );

      var_dump($reviewID[0]['reviewID']);
      die();
      $this->delete(
        "DELETE FROM reviews WHERE id = ?",
        ["i", $reviewID[0]['reviewID']]
      );

      $this->delete(
        "DELETE FROM event_reviews WHERE eID = ? AND uID = ?",
        ["ii", $eventId, $userId]
      );
    }
    catch(Exception $e){
      throw new Exception('Error deleting review', 500);
    }
  }

  public function deleteRating($userId, $eventId){
    try{
      $this->delete(
        "DELETE FROM event_ratings WHERE eID = ? AND uID = ?",
        ["ii", $eventId, $userId]
      );
    }
    catch(Exception $e){
      throw new Exception('Error deleting rating', 500);
    }
  }

  public function updateEvent($body) {
    // For each key in the body, find the column name and update the value
    try {
      $eventId = $body['eventId'];
      unset($body['eventId']);
      $query = "UPDATE events SET ";
      $columns = "";
      $values = array();
      $types = "";
      foreach ($body as $key => $value) {
        $columns .= "," . $this->cols[$key] . " = ? ";
        array_push($values, $value);
        $types .= $this->types[$key];
      }

      $query .= substr($columns, 1) . " WHERE id = ?";
      array_push($values, $eventId);
      $types .= "i";

      $this->update($query, array($types, ...$values));

      // Return the updated event
      return $this->getEvent($eventId);


    }
    catch (Exception $e) {
      throw new Exception('Error updating event', 500);
    }

  }

  public function uploadImage($image, $eventId){
    try{
      $this->insert(
        "INSERT INTO gallery (imagePath) VALUES (?)",
        ["s", $image]
      );

      $imageId = $this->select(
        "SELECT id FROM gallery WHERE imagePath = ?",
        ["s", $image]
      );

      $this->insert(
        "INSERT INTO event_gallery (externID, galleryID) VALUES (?, ?)",
        ["ii", $eventId, $imageId[0]['id']]
      );

      return array(
        'image' =>$image
      );

    }
    catch(Exception $e){
      throw new Exception('Error uploading image', 500);
    }
  }

  public function isEventDeleted($eventId){
    try{
      $event = $this->select(
        "SELECT deleted FROM events WHERE id = ?",
        ["i", $eventId]
      );

      if($event){
        return false;
      }
      else{
        return true;
      }
    }
    catch(Exception $e){
      throw new Exception('Error checking if event is deleted', 500);
    }
  }

  public function getEventLocation($eventId){
    try{
      $location = $this->select(
        "SELECT location FROM events WHERE id = ?",
        ["i", $eventId]
      );

      $townCountry = $this->select(
        "SELECT cID, tID FROM location WHERE id = ?",
        ["i", $location[0]['location']]
      );

      $country = $this->select(
        "SELECT wName FROM world WHERE id = ?",
        ["i", $townCountry[0]['cID']]
      );

      $town = $this->select(
        "SELECT tName FROM town WHERE id = ?",
        ["i", $townCountry[0]['tID']]
      );

      return array(
        'country' => $country[0]['wName'],
        'town' => $town[0]['tName']
      );
    }
    catch(Exception $e){
      throw new Exception('Error getting event location', 500);
    }
  }
}
