<?php
class Home
{
    public function index()
    {

        if(Auth::isAuthenticated()){
            // If the user is logged in

            // Delete password change confirmation cookie (if there is one)
            if(isset($_COOKIE["password_changed_successfully"]) && $_COOKIE["password_changed_successfully"] == '1'){
                Application::deleteCookie("password_changed_successfully");
            }

            // Load data
            $bookings = BookingModel::getUserBookings($_SESSION["username"]);

            //Show index page
            ViewLoader::load("home/templates/header");
            ViewLoader::load("home/index", array(
                "bookings" => $bookings)
            );
            ViewLoader::load("home/templates/footer");
        }
        else{
            // If the user is not logged in the controller redirect him to the login page.

            // Redirect to login controller
            RedirectManager::redirect("login");
        }
    }
}
