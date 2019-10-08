<?php
class Home
{
    public function index()
    {

        if(Auth::isAuthenticated()){
            // If the user is logged in

            if(isset($_COOKIE["password_changed_successfully"]) && $_COOKIE["password_changed_successfully"] == '1'){
                Application::deleteCookie("password_changed_successfully");
            }

            //Show index page
            ViewLoader::load("home/index");
        }
        else{
            // If the user is not logged in the controller redirect him to the login page.

            // Redirect to login controller
            RedirectManager::redirect("login");
        }
    }
}
