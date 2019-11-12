<?php

use API\Helpers\UserHelper;
use API\Models\Chat;
use API\Models\ChatMessage;

require_once __DIR__."/../vendor/autoload.php";

session_start();

$post = json_decode(file_get_contents('php://input'), true);

if (isset($post["chat"])) {
  UserHelper::loggedIn();

  $chatId = $post["chat"];

  $chatClass = new Chat();
  $chat = $chatClass->get($chatId);

  // prevent other users to see other chats
  if ($chat->participant != $_SESSION["user"] && $chat->creator != $_SESSION["user"]) {
    echo "Can't view this chat";
    exit;
  }

  $chatMessagesClass = new ChatMessage();
  $chatMessages = $chatMessagesClass->getAllWithUser($chatId);

  $response = json_encode($chatMessages);

  header('Content-type: application/json');
  echo $response;

}
