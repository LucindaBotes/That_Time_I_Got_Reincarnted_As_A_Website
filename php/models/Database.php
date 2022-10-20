<?php
require_once '../common/config.php';

class Database
{
  protected $connection;

  public static function instance()
  {
    static $instance = null;
    if (!$instance) $instance = new static();
    return $instance;
  }

  private function __construct()
  {
    try {
      $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

      if (mysqli_connect_errno()) {
        throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
      }
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function __destruct()
  {
    $this->connection->close();
  }
  
  public function select($query = "", $params = [])
  {
    try {
      $stmt = $this->executeStatement($query, $params);
      $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      $stmt->close();

      return $result;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    return false;
  }

  public function insert($query = "", $params = [])
  {
    try {
      $stmt = $this->executeStatement($query, $params);
      $stmt->close();
      return true;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    return false;
  }

  public function update($query = "", $params = [])
  {
    try {
      $stmt = $this->executeStatement($query, $params);
      $stmt->close();
      return true;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    return false;
  }

  public function delete($query = "", $params = [])
  {
    try {
      $stmt = $this->executeStatement($query, $params);
      $stmt->close();
      return true;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    return false;
  }

  private function executeStatement($query = "", $params = [])
  {
    try {
      $stmt = $this->connection->prepare($query);
      if ($stmt === false) {
        throw new Exception("Unable to do prepared statement: " . $query);
      }
      
      if ($params) {
        $stmt->bind_param(...$params);
      }
      
      if (!$stmt->execute()) {
        throw new Exception("Unable to do prepared statement: " . $query);
      }
      
      return $stmt;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}
