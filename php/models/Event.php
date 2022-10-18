<?php
require_once 'Database.php';
// Lucinda Botes u19048263
class Event extends Database
{

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

      return array(
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
}
