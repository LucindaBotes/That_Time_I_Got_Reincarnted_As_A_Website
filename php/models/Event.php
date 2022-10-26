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

  public function addEvent($title, $description, $date, $time, $level, $reward, $userId, $thumbnail)
  {
    try{
      // get the user location
      $location_id = $this->select(
        "SELECT uLocation FROM user WHERE id = ?", ["i", $userId]
      );

      $location = $location_id[0]['uLocation'];

      $this->insert(
        "INSERT INTO events (eName, eDescription, eDate, eTime, eLocation, eLevel, eReward, eThumbnail) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        ["ssssiidi", $title, $description, $date, $time, $location, $level, $reward, $thumbnail]
      );
      // get event id
      $eventID = $this->select(
        "SELECT id FROM events WHERE eName = ? AND eDescription = ? AND eDate = ? AND eTime = ? AND eLocation = ? AND eLevel = ? AND eReward = ? AND eThumbnail = ?",
        ["ssssiidi", $title, $description, $date, $time, $location, $level, $reward, $thumbnail]
      );
      
      $this->insert(
        "INSERT INTO user_event (uID, eID) VALUES (?, ?)",
        ["ii", $userId, $eventID[0]['id']]
      );

      // insert thumbnail into gallery
      $this->insert(
        "INSERT INTO gallery (imagePath) VALUES (?)",
        ["s", $thumbnail]
      );

      // get thumbnail id
      $thumbnailID = $this->select(
        "SELECT id FROM gallery WHERE imagePath = ?",
        ["s", $thumbnail]
      );

      // insert thumbnail into event_gallery
      $this->insert(
        "INSERT INTO thumbnail_gallery (galleryID, externID) VALUES (?, ?)",
        ["ii", $thumbnailID[0]['id'], $eventID[0]['id']]
      );

      var_dump($thumbnailID);

      // selectId from thumbnail_gallery
      $thumbnailGalleryID = $this->select(
        "SELECT id FROM thumbnail_gallery WHERE galleryID = ? AND externID = ?",
        ["ii", $thumbnailID[0]['id'], $eventID[0]['id']]
      );

      // update event thumbnail
      $this->update(
        "UPDATE events SET eThumbnail = ? WHERE id = ?",
        ["ii", $thumbnailGalleryID[0]['id'], $eventID[0]['id']]
      );

      return array(
        'eventID' =>$eventID[0]['id'],
        'title' =>$title,
        'description' =>$description,
        'date' =>$date,
        'time' =>$time,
        'location' =>$location,
        'level' =>$level,
        'reward' =>$reward,
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
      $result = $this->select("SELECT * FROM events", []);
      return $result;
    }
    catch(Exception $e){
      throw new Exception('Error getting events', 500);
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
      throw new Exception("Cannot Delete event", 1);
      
      // // check if event is in a list
      // $list = $this->select(
      //   "SELECT listID FROM event_lists WHERE eID = ?",
      //   ["i", $eventId]
      // );

      // // if event is in a list, delete from list
      // if($list){
      //   $this->delete(
      //     "DELETE FROM event_lists WHERE eID = ?",
      //     ["i", $eventId]
      //   );
      // }

      // // check if event has a review
      // $review = $this->select(
      //   "SELECT reviewId FROM event_reviews WHERE eID = ?",
      //   ["i", $eventId]
      // );

      // // if event has a review, delete review
      // if($review){
      //   $this->delete(
      //     "DELETE FROM reviews WHERE id = ?",
      //     ["i", $review[0]['reviewId']]
      //   );
      // }

      // // check if event has a rating
      // $rating = $this->select(
      //   "SELECT ratingID FROM event_ratings WHERE eID = ?",
      //   ["i", $eventId]
      // );

      // // if event has a rating, delete rating
      // if($rating){
      //   $this->delete(
      //     "DELETE FROM ratings WHERE id = ?",
      //     ["i", $rating[0]['ratingID']]
      //   );
      // }

      // // delete event
      // $this->delete(
      //   "DELETE FROM events WHERE id = ?",
      //   ["i", $eventId]
      // );

      // // delete event from user_event
      // $this->delete(
      //   "DELETE FROM user_event WHERE eID = ?",
      //   ["i", $eventId]
      // );

      // // attendance
      // // event_list
      // // event_reviews
      // // event_ratings
      // // event_gallery
      // // event_level
      // // event_monsters
      // // event_thumbnail
      // // event_location
      // // event
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

  public function getEvent($id) {

    try {
      $event = $this->select(
        "SELECT * FROM events WHERE id = ?",
        ["i", $id]
      );

      return $event;
    } catch (Exception $e) {
      throw new Exception('Error getting event', 500);
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
}

//! Delete event
//* Update event - Name
//* Update event - Description
//* Update event - Date
//* Update event - Time
//* Update event - Reward
//! Delete event from list
//* Delete review
//* Delete rating
// Upload image to gallery
// Delete image from gallery
