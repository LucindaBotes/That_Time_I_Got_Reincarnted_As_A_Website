<?php
require_once 'Database.php';

class User extends Database
{

  public $cols = array(
    'id' => 'id',
    'name' => 'uName',
    'password' => 'uPass',
    'salt' => 'uSalt',
    'level' => 'uLevel',
    'gold' => 'uGold',
    'profile_image' => 'uProfile',
    'location' => 'uLocation',
  );

  public $types = array(
    'id' => 'i',
    'name' => 's',
    'password' => 's',
    'salt' => 's',
    'level' => 'i',
    'gold' => 'd',
    'profile_image' => 'i',
    'location' => 'i',
  );

  public function generateSalt(int $length = 6, string $keySelection = '0123456789abcdefghijklmnnopqrestuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
  {
    $salt = [];
    $max = mb_strlen($keySelection, '8bit') - 1;
    for ($i = 0; $i < $length; $i++) {
      $salt[] = $keySelection[random_int(0, $max)];
    }
    return implode('', $salt);
  }

  public function addUser($name, $password, $profile_picture, $gold, $personal_level)
  {
    $salt = $this->generateSalt();
    $saltedPassword = $password . $salt;
    $hashedPassword = hash('sha256', $saltedPassword);
    $profile_id = 1;
    try {
      if ($this->isNameInUse($name)) {
        throw new Exception('User already exists', 400);
      }
      
      $town = rand(1, 100);
      $world = rand(1, 50);
      $this->insert("INSERT INTO `location` (cID, tID) VALUES (?, ?)", ["ii", $world, $town]);
      $location_id = $this->select("SELECT id FROM `location` WHERE cID = ? AND tID = ?", ["ii", $world, $town])[0]['id'];

      $this->insert(
        "INSERT INTO user (uName, uPass, uSalt, uLevel, uGold, uProfile, uLocation) VALUES (?, ?, ?, ?, ?, ?, ?)",
        ["sssidii", $name, $hashedPassword, $salt, $personal_level, $gold, $profile_id, $location_id]
      );
      
      $user = $this->select("SELECT * FROM user WHERE uName = ?", ["s", $name])[0];

      return array(
        "id" => $user['id'],
        "name" => $user['uName'],
        "personal_level" => $user["uLevel"],
        "gold" => $user["uGold"],
        "profile_picture" => $user["uProfile"],
        "location" => $user["uLocation"]
      );
    } catch (Exception $e) {
      if ($e->getCode() == 400) {
        throw new Exception('User already exists', 400);
      } else {
        throw new Exception('Error adding user', 500);
      }
    }
  }

  public function validateLogin($name, $password)
  {

    try {
      if ($this->isNameInUse($name)) {
        $user = $this->select('SELECT * FROM user WHERE uName = ?', ["s", $name]);
        $saltedPassword = $password . $user[0]['uSalt'];
        $hashedPassword = hash('sha256', $saltedPassword);
        $retrievedPassword = $user[0]['uPass'];
        if ($hashedPassword === $retrievedPassword && !$this->isUserDeleted($user[0]['id'])) {
          
          $id = $user[0]['id'];
          $name = $user[0]['uName'];
          $level = $user[0]['uLevel'];
          $gold = $user[0]['uGold'];
          $profile_picture = $user[0]['uProfile'];
          $location = $user[0]['uLocation'];

          

          return array(
            "id" => $id,
            "name" => $name,
            "gold" => $gold,
            "level" => $level,
            "profile_picture" => $profile_picture,
            "location" => $location

          );
        } else
          throw new Exception('Incorrect password was entered', 401);
      } else {
        throw new Exception('The username entered does not exist', 404);
      }
    } catch (Exception $e) {
      if ($e->getCode() == 401) {
        throw new Exception($e->getMessage(), 401);
      } else if ($e->getCode() == 404) {
        throw new Exception($e->getMessage(), 404);
      } else {
        throw new Exception('Error validating user', 500);
      }
    }
  }

  public function isNameInUse($name)
  {
    try {
      return $this->select('SELECT * FROM user WHERE uName = ?', ["s", $name]);
    } catch (Exception $e) {
      return false;
    }
  }

  public function createGroup($groupName, $userId){
    try {
      $group = $this->select("SELECT * FROM `groups` WHERE gName = ?", ["s", $groupName]);
      if ($group) {
        throw new Exception('Group already exists', 400);
      }
      $this->insert("INSERT INTO `groups` (gName) VALUES (?)", ["s", $groupName]);
      $group = $this->select("SELECT * FROM `groups` WHERE gName = ?", ["s", $groupName])[0];
      $this->insert("INSERT INTO `group_users` (gID, uID) VALUES (?, ?)", ["ii", $group['id'], $userId]);
      return array(
        "groupId" => $group['id'],
        "groupName" => $group['gName']
      );
    }
    catch (Exception $e){
      throw new Exception('Error creating group', 500);
    }
  }

  public function joinGroup($groupId, $userId){
    try {
      $inGorup = $this->select("SELECT * FROM `group_users` WHERE gID = ? AND uID = ?", ["ii", $groupId, $userId]);
      if($inGorup){
        throw new Exception('User is already in group', 400);
      }
      $this->insert("INSERT INTO `group_users` (gID, uID) VALUES (?, ?)", ["ii", $groupId, $userId]);
      $group = $this->select("SELECT * FROM `groups` WHERE id = ?", ["i", $groupId])[0];
      return array(
        "groupId" => $group['id'],
        "groupName" => $group['gName']
      );
    }
    catch (Exception $e){
      throw new Exception('Error joining group', 500);
    }
  }

  public function getUserGroups($userId){
    try {
      $groups = $this->select("SELECT * FROM `group_users` WHERE uID = ?", ["i", $userId]);
      $groupArray = array();
      foreach($groups as $group){
        $groupArray[] = $this->select("SELECT * FROM `groups` WHERE id = ?", ["i", $group['gID']])[0];
      }
      return $groupArray;
    }
    catch (Exception $e){
      throw new Exception('Error getting user groups', 500);
    }
  }

  public function updateUser($body)
  {
    try {
      
      $userId = $body['userId'];
      unset($body['userId']);
      $query = "UPDATE user SET ";
      $types = "";
      $values = array();
      $columns = "";
      foreach($body as $key => $value){
        $columns .= "," . $this->cols[$key] . " = ?";
        array_push($values, $value);
        $types .= $this->types[$key];
      }

      $query .= substr($columns, 1) . " WHERE id = ?";
      array_push($values, $userId);
      $types .= "i";

      $this->update($query, [$types, ...$values]);
  
    } catch (Exception $e) {
      if ($e->getCode() == 401) {
        throw new Exception($e->getMessage(), 401);
      } else if ($e->getCode() == 404) {
        throw new Exception($e->getMessage(), 404);
      } else {
        throw new Exception('Error validating user', 500);
      }
    }
  }

  public function deleteUser($userId) {
    try {
      $this->update("UPDATE user SET deleted = 1 WHERE id = ?", ["i", $userId]);
    } catch (Exception $e) {
      if ($e->getCode() == 401) {
        throw new Exception($e->getMessage(), 401);
      } else if ($e->getCode() == 404) {
        throw new Exception($e->getMessage(), 404);
      } else {
        throw new Exception('Error validating user', 500);
      }
    }
  }

  public function isUserDeleted($userId) {
    try {
      $user = $this->select("SELECT deleted FROM user WHERE id = ?", ["i", $userId]);
      if($user){
        return false;
      }
      return true;
    } catch (Exception $e) {
      if ($e->getCode() == 401) {
        throw new Exception($e->getMessage(), 401);
      } else if ($e->getCode() == 404) {
        throw new Exception($e->getMessage(), 404);
      } else {
        throw new Exception('Error validating user', 500);
      }
    }
  }
  
}
