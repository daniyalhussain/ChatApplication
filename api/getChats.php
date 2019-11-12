<?php

use API\Helpers\UserHelper;
use API\Models\Chat;

require_once __DIR__."/../vendor/autoload.php";

session_start();

UserHelper::loggedIn();

$chatClass = new Chat();
$chats = $chatClass->getUserChats($_SESSION["user"]);

$response = json_encode($chats);

header('Content-type: application/json');
echo $response;
