<?php
namespace API;

use API\Helpers\UserHelper;
use API\Models\ChatMessage;

require_once __DIR__."/../vendor/autoload.php";

session_start();

$post = json_decode(file_get_contents('php://input'), true);

if (isset($post["chat"])) {
  UserHelper::loggedIn();

  var_dump($post["chat"]);

  $chatMessage = new ChatMessage();
  $chatMessage->user = $_SESSION["user"];
  $chatMessage->message = $post["chat"]["message"];
  $chatMessage->chat = $post["chat"]["chat"];

  $chatMessage->save();

  header('Content-type: application/json');

  $success =
    true;
  echo json_encode($success);
}
