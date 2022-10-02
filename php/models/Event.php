<?php
require_once 'Database.php';
// Lucinda Botes u19048263
class Event extends Database
{
  public function addEvent($title, $description, $date, $location, $level, $reward)
  {
    try{
      $this->insert(
        "INSERT INTO events (ename, event_description, event_date, event_location, level_requirement, reward) VALUES (?, ?, ?, ?, ?, ?)",
        ["ssssss", $title, $description, $date, $location, $level, $reward]
      );
      return array(
        'title' =>$title,
        'description' =>$description,
        'date' =>$date,
        'location' =>$location,
        'level' =>$level,
        'reward' =>$reward,
      );
    }
    catch(Exception $e){
      throw new Exception('Error adding event', 500);
    }
    
  }

  public function getEvents()
  {
    try{
      $result = $this->select("SELECT * FROM events");
      return $result;
    }
    catch(Exception $e){
      throw new Exception('Error getting events', 500);
    }
  }
}
