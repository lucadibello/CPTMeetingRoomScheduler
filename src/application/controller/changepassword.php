<?php
class ChangePassword
{
    public function index()
    {
        if(Auth::isAuthenticated() && $this->check_get_id()){
            // If the user is logged in

            if(isset($_SESSION["default_password_changed"]) && !$_SESSION["default_password_changed"]){
                // User didn't changed password, redirect to changepassword page
                ViewLoader::load("changepassword/index");
            }
            else{
                // User changed password correctly, go to index
                Header("Location: home");
            }

        }
        else{
            // If the user is not logged in the controller redirect him to the login page.

            // Redirect to login controller
            Header("Location: login");
        }
    }

    private function check_get_id(){
        return isset($_GET["id"]) && !empty($_GET["id"]);
    }
}
