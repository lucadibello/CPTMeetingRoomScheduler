<?php


class Calendario
{
    public function index(){
        if(Auth::isAuthenticated()){
            // Load page
            ViewLoader::load("calendario/templates/header");
            ViewLoader::load("calendario/index");
            ViewLoader::load("calendario/templates/footer");
        }
        else{
            // Redirect to login page
            RedirectManager::redirect("login");
        }
    }
}