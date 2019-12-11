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
            ViewLoader::load("contatti/templates/header");
            ViewLoader::load("contatti/index");
            ViewLoader::load("contatti/templates/footer");
        }
        else{
            RedirectManager::redirect("/login");
        }
    }
}