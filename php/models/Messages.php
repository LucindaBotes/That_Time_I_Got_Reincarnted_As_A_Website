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
      $messageShown =$this->select("SELECT * FROM messages INNER JOIN personal_messages ON messages.id = personal_messages.messageID WHERE personal_messages.senderID = ? AND personal_messages.receiverID = ? OR personal_messages.senderID = ? AND personal_messages.receiverID = ?", ["iiii", $userId, $receiverId, $receiverId, $userId]);

      return $messageShown;
    }
    catch(Exception $e){
      throw new Exception('Error getting message', 500);
    }
  }

  public function updateMessage($messageid, $message, $time){
    try{
      $this->update("UPDATE messages SET mText = ?, mTime = ? WHERE id = ?", ["sii", $message, $time, $messageid]);
      return array(
        'message' =>$message,
        'time' =>$time
      );
    }
    catch(Exception $e){
      throw new Exception('Error updating message', 500);
    }
  }
  
  public function deleteMessage($messageid, $type){
    try{

      $this->delete("DELETE FROM messages WHERE id = ?", ["i", $messageid]);
      $this->delete("DELETE FROM " . $type . "_messages WHERE messageID = ?", ["i", $messageid]);
      return $messageid;
    }
    catch(Exception $e){
      throw new Exception('Error deleting message', 500);
    }
  }

  public function getGroupMessages($userId, $groupId){
    try{
      $messageShown =$this->select("SELECT * FROM messages INNER JOIN group_messages ON messages.id = group_messages.messageID WHERE group_messages.gID = ?", ["i", $groupId]);

      return $messageShown;
    }
    catch (Exception $e){
      throw new Exception('Error while trying to get the group messages of the user', 500);
    }
  }

}


// SELECT * FROM messages INNER JOIN personal_messages ON messages.id = personal_messages.messageID WHERE personal_messages.senderID = 1 AND personal_messages.receiverID = 2 
// INNER JOIN group_users ON user.id = group_users.uID
// INNER JOIN groups ON group_users.id = groups.id
// INNER JOIN user_event ON user.id = user_event.uID
// INNER JOIN events ON user_event.eID = events.id
// WHERE user.id = 5