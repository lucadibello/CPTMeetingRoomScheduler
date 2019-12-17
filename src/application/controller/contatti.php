<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 07.12.2019
 * Time: 11:10
 */

class Contatti
{
    public function index()
    {
        if(Auth::isAuthenticated()){
            if (Auth::getAuthType() == AuthType::AUTH_LOCAL && !$_SESSION["user"]->isDefaultPasswordChanged()) {
                // Change password model
                RedirectManager::redirect("changepassword");
            }
            else{
                ViewLoader::load("contatti/templates/header");
                ViewLoader::load("contatti/index");
                ViewLoader::load("contatti/templates/footer");
            }

        }
        else{
            RedirectManager::redirect("/login");
        }
    }
}