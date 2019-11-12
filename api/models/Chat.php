<?php
namespace API\Models;

use API\Config\Database;
use API\Core\Model;
use PDO;

class Chat extends Model {
    public $id;
    public $chatMessages;
    public $creator;
    public $participant;
    public $created_at;

    function __construct()
    {
      $this->setTableName("chats");
    }

    public function getUserChats($id) {
      $database = new Database();

      $stmt = $database->makeConnection()->prepare('Select * from chats where participant = :id or creator = :id');
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);

      $chats = $this->query($stmt);

      foreach ($chats as $chat) {
        $chat->initUser();
      }

      return $chats;
    }

    public function initUser() {
      if (isset($this->participant) && isset($this->creator)) {
        $userClass = new User();
        $this->participant = $userClass->get($this->participant);
        $this->creator = $userClass->get($this->creator);
      }
    }

}
