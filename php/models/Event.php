<?php
require_once 'Database.php';
// Lucinda Botes u19048263
class Event extends Database
{
  public function addEvent($title, $description, $date, $location, $level, $reward, $userId,$thumbnail)
  {
    try{
      $this->insert(
        "INSERT INTO events (ename, event_description, event_date, event_location, level_requirement, reward, userId, event_thumbnail) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        ["ssssssss", $title, $description, $date, $location, $level, $reward, $userId, $thumbnail]
      );
      return array(
        'title' =>$title,
        'description' =>$description,
        'date' =>$date,
        'location' =>$location,
        'level' =>$level,
        'reward' =>$reward,
        'userId' =>$userId,
        'event_thumbnail' =>$thumbnail
      );
    }
    catch(Exception $e){
      throw new Exception('Error adding event', 500);
    }
    
  }

  public function getEvents($userId)
  {
    try{
      $result = $this->select("SELECT * FROM events where userId = ?", ["i", $userId]);
      return $result;
    }
    catch(Exception $e){
      throw new Exception('Error getting events', 500);
    }
  }
}
