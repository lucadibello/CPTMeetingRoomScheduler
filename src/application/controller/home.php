<?php
class Home
{
    public function index()
    {
        if(Auth::isAuthenticated()){
            /*
            //Show index page
            ViewLoader::load("_templates/header");
            ViewLoader::load("home/index");
            ViewLoader::load("_templates/footer");
            */

            // If the user is logged in
            ViewLoader::load_full("home/index");
        }
        else{
            // If the user is not logged in the controller redirect him to the login page.
            ViewLoader::load("login/index");
        }
    }
}
