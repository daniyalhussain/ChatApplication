<?php
namespace API\Models;

use API\Core\Model;

class ChatMessage extends Model {
  public $id;
  public $message;
  public $user;
  public $chat;
  public $created_at;

  function __construct()
  {
    $this->setTableName("chatMessages");
  }

  public function getAllWithUser($chatId) {
    $chatMessages = $this->where("chat", $chatId);

    foreach ($chatMessages as $chatMessage) {
      $chatMessage->initUser();
    }

    return $chatMessages;
  }

  public function initUser() {
    if (isset($this->user)) {
      $userClass = new User();
      $this->user = $userClass->get($this->user);
    }
  }
}