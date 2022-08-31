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

  public function addUser($name, $password)
  { /* Add to the database
    increment id, add name, add surname, check if email exists, add email, hash and salt password, add password, create api key, add api key
    */
    $api_key_input = $name;
    $api_key = hash('sha256', $api_key_input);

    $salt = $this->generateSalt();
    $saltedPassword = $password . $salt;
    $hashedPassword = hash('sha256', $saltedPassword);

    try {
      if ($this->isNameInUse($name)) {
        throw new Exception('User already exists', 400);
      }

      $this->insert(
        "INSERT INTO users (fname, pass, api_key) VALUES (?, ?, ?)",
        ["ssssss", $name, $hashedPassword, $api_key]
      );

      return array(
        "name" => $name,
        "api_key" => $api_key
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
        // email exists
        //match with password
        $user = $this->select('SELECT * FROM users WHERE name = ?', ["s", $name]);
        $saltedPassword = $password . $user[0]['salt'];
        $hashedPassword = hash('sha256', $saltedPassword);
        $retrievedPassword = $user[0]['pass'];

        if ($hashedPassword === $retrievedPassword) {
          
          $api_key = $user[0]['api_key'];
          $name = $user[0]['name'];
          $id = $user[0]['id'];

          return array(
            "name" => $name,
            "api_key" => $api_key,
            "id" => $id,
          );
        } else
          throw new Exception('Incorrect password was entered', 401);
      } else {
        throw new Exception('The email address entered does not exist', 404);
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
      return $this->select('SELECT * FROM users WHERE name = ?', ["s", $name]);
    } catch (Exception $e) {
      return false;
    }
  }

  public function doesApiKeyExist($api_key)
  {
    try {
      $this->select('SELECT * FROM users WHERE api_key = ?', ["s", $api_key]);
    } catch (Exception $e) {
      throw new Exception('Your authorization failed, please use a valid API key', 401);
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

