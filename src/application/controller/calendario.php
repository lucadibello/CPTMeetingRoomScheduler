<?php


class Calendario
{
    public function index(){
        if(Auth::isAuthenticated()){
            if (Auth::getAuthType() == AuthType::AUTH_LOCAL && !$_SESSION["user"]->isDefaultPasswordChanged()) {
                // Change password model
                RedirectManager::redirect("changepassword");
            }
            else{
                // Load page
                ViewLoader::load("calendario/templates/header");
                ViewLoader::load("calendario/index");
                ViewLoader::load("calendario/templates/footer");
            }
        }
        else{
            // Redirect to login page
            RedirectManager::redirect("login");
        }
    }
}