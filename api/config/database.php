<?php
namespace API\Config;

use PDO;
use PDOException;

class Database {
  public $connection;

  public function makeConnection(){
    $this->connection = null;

    try {
      $this->connection = new PDO("sqlite:".__DIR__.DIRECTORY_SEPARATOR.Config::PATH_DB_FILE);

      return $this->connection;
    } catch (PDOException $exception) {
      echo "Connection failure" . $exception->getMessage();
    }
  }

  public function createDatabase() {
    // check if 
  }
}


