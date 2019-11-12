<?php

namespace API\Helpers;

class UserHelper {

  public static function loggedIn() {
    if(!isset($_SESSION["user"])) {
      echo "You need to be logged in";
      exit();
    }
  }
}