<?php

class Auth {

  public static function isAuthenticated() {
    if(isset($_SESSION["auth"]) && $_SESSION["auth"])
    {
      return true;
    }
    return false;
  }

  public function __construct()
  {
      $_SESSION["auth"] = true;
  }

  /*
  public static function auth() {
        $_SESSION["auth"] = true;
  }
  */

  public static function logout() {
    foreach ($_SESSION as $key => $value) {
      unset($_SESSION[$key]);
    }
    session_destroy();
  }


}
