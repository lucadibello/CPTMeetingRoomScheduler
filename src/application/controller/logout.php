<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 19.09.2019
 * Time: 16:10
 */

class Logout
{
    public function index(){
        session_unset();
        unset($_SESSION["auth"]);
        session_destroy();

        RedirectManager::redirect("login");
    }
}