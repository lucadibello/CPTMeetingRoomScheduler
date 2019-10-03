<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 19.09.2019
 * Time: 15:23
 */

class Login
{

    public function index()
    {
        if (Auth::isAuthenticated()) {

            if (isset($_SESSION["default_password_changed"]) && !$_SESSION["default_password_changed"]) {
                // Generate custom URL and save it to database
                $a = new PasswordChangeModel();
                $url = $a->generateUrl($_SESSION["username"]);

                // Redirect to change password controller
                //TODO: Email with url, not redirect
                Header("Location: " . $url);

            } else {
                // If the user is logged in
                //ViewLoader::load_full("home/index");
                RedirectManager::redirect("home");
            }
        } else {
            // If the user is not logged in the controller redirect him to the login page.
            ViewLoader::load("login/index");
        }
    }

    public function auth()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $this->validate_login($_POST)) {

            // Clear data
            $username = filter_input(INPUT_POST, 'username', FILTER_DEFAULT);
            $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

            // Create auth object
            $auth = new LoginModel($username, $password);

            // Try to login with Local database
            if (($status = $auth->localLogin()) && $status["status"]) {
                $_SESSION["auth"] = $status["status"];
                $_SESSION["username"] = $username;
                $_SESSION["default_password_changed"] = $status["extra_information"]["default_password_changed"];
                $_SESSION["login_type_used"] = "LOCAL";
            } // Try to login with ldap
            elseif (($_SESSION["auth"] = $auth->ldapLogin())) {
                // Save login type
                $_SESSION["login_type_used"] = "LDAP";
            } // Cannot login
            else {
                $GLOBALS["NOTIFIER"]->add("Email o password sbagliate. Controlla le credenziali.");
            }

            if (Auth::isAuthenticated()) {
                if($_SESSION["login_type_used"] == "LOCAL"){
                    $_SESSION["permissions"] = (new PermissionModel($username))->getLocalPermissions();
                }
                else{
                    $_SESSION["permissions"] = (new PermissionModel($username))->getLdapPermissions();
                }

                if (isset($_SESSION["default_password_changed"]) && !$_SESSION["default_password_changed"]) {

                    // Generate custom URL and save it to database
                    $a = new PasswordChangeModel();
                    if(($url = $a->generateUrl($_SESSION["username"])) && $url){
                        // User have to change password
                        RedirectManager::redirect($url);
                    }
                    else{
                        echo "<p>C'è stato un errore durante l'inserimento dei dati nel database. 
                        Contatta un'amministratore.</p>";
                    }
                } else {
                    // User has all right
                    RedirectManager::redirect("home");
                }
            } else {
                RedirectManager::redirect("login");
            }
        }
        else{
            RedirectManager::redirect("login");
        }
    }

    private function validate_login(array $array): bool
    {
        return isset($_POST["username"]) && isset($_POST["password"]);
    }
}