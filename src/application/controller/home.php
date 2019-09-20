<?php
class Home
{
    public function index()
    {

        if(Auth::isAuthenticated()){
            // If the user is logged in

            //Show index page
            ViewLoader::load("home/index");
        }
        else{
            // If the user is not logged in the controller redirect him to the login page.

            // Redirect to login controller
            Header("Location: login");
        }
    }


}
