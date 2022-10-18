<?php
require_once 'Database.php';

class Message extends Database
{
  public function sendPersonalMessage($message, $time, $userId, $receiverID)
  {
    try{
      $this->insert(
        "INSERT INTO messages (mText, mTime) VALUES (?, ?)",
        ["si", $message, $time]
      );

      $messageID = $this->select(
        "SELECT id FROM messages WHERE mText = ? AND mTime = ?",
        ["si", $message, $time]
      );

      $this->insert(
        "INSERT INTO personal_messages (senderID, receiverID, messageID) VALUES (?, ?, ?)",
        ["iii", $userId, $receiverID, $messageID[0]['id']]
      );

      return array(
        'message' =>$message,
        'user' =>$userId,
        'receiver' =>$receiverID,
        'time' =>$time
      );
    }
    catch(Exception $e){
      throw new Exception('Error sending message', 500);
    }
  }

  public function sendGroupMessage($groupID, $message, $time, $userId){
    try{
      $this->insert(
        "INSERT INTO messages (mText, mTime) VALUES (?, ?)",
        ["si", $message, $time]
      );

      $messageID = $this->select(
        "SELECT id FROM messages WHERE mText = ? AND mTime = ?",
        ["si", $message, $time]
      );
      
      $this->insert(
        "INSERT INTO group_messages (messageID, uID, gID ) VALUES (?, ?, ?)",
        ["iii", $messageID[0]['id'], $userId, $groupID]
      );

      return array(
        'message' =>$message,
        'user' =>$userId,
        'group' =>$groupID,
        'time' =>$time
      );
    }
    catch(Exception $e){
      throw new Exception('Error sending message', 500);
    }
  }

  public function getPersonalMessages($userId, $receiverId){
    try{
      $messages = $this->select("SELECT messageID FROM personal_messages WHERE senderID = ? AND receiverID = ?", ["ii", $userId, $receiverId]);

      $messageShown = [];
      foreach($messages as $message){
        $messageShown[] = $this->select("SELECT * FROM messages WHERE id = ?", ["i", $message['messageID']]);
      }

      return $messageShown;
    }
    catch(Exception $e){
      throw new Exception('Error getting message', 500);
    }
  }
}


// SELECT user.id, groups.gName, events.eName, events.eDescription, events.eReward FROM user 
// INNER JOIN group_users ON user.id = group_users.uID
// INNER JOIN groups ON group_users.id = groups.id
// INNER JOIN user_event ON user.id = user_event.uID
// INNER JOIN events ON user_event.eID = events.id
// WHERE user.id = 5