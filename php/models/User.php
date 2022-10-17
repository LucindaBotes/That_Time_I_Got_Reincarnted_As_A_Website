<?php
require_once 'Database.php';

class User extends Database
{
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

      
      // get the id of the user that was just added
      $user = $this->select("SELECT * FROM user WHERE uName = ?", ["s", $name])[0];

      return array(
        "userId" => $user['id'],
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
        if ($hashedPassword === $retrievedPassword) {
          
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

  

  public function updateUser($theme, $filter, $api_key)
  {
    try {
      
      $this->insert('UPDATE users SET theme = ? , filter = ? WHERE api_key = ?', ["sss", $theme, $filter, $api_key]);
  
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
  
  public function getRatings($id)
  {
    try {
      return $this->select(
        'SELECT * FROM UserArticleRating INNER JOIN users ON users.id = UserArticleRating.user_id INNER JOIN ratings ON ratings.id = UserArticleRating.rating_id INNER JOIN articles ON articles.id = UserArticleRating.article_id WHERE users.id = ?',
        ["i", $id]
      );
    } catch (Exception $e) {
      throw $e;
    }
  }
  
  public function rate($user_id, $article_title, $rating)
  {
    try {
  
      $article_title_hash = hash('sha256', $article_title);
  
      $article_id = $this->select('SELECT id FROM articles WHERE article_hash = ?', ["s", $article_title_hash]);
  
      if (empty($article_id)) {
        $this->insert('INSERT INTO articles (article_hash) VALUES (?)', ["s", $article_title_hash]);
        $article_id = $this->select('SELECT id FROM articles WHERE article_hash = ?', ["s", $article_title_hash]);
      }
  
      $article_id = $article_id[0]['id'];
  
      $rating_id = $this->select('SELECT id FROM ratings WHERE rating = ?', ["i", $rating]);
      $rating_id = $rating_id[0]['id'];
  
  
      $this->insert(
        "INSERT INTO UserArticleRating (user_id, article_id, rating_id) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE rating_id = VALUES (rating_id)",
        ["iii", $user_id, $article_id, $rating_id]
      );
    } catch (Exception $e) {
      throw $e;
    }
  }
}

