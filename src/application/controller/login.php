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
            // If the user is logged in
            //ViewLoader::load_full("home/index");
            Header("Location: home");
        } else {
            // If the user is not logged in the controller redirect him to the login page.
            ViewLoader::load("login/index");
        }
    }

    public function auth()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $this->validate_login($_POST)) {
            //Require login model
            require_once("application/models/loginmodel.php");
            $auth = new LoginModel($_POST["username"], $_POST["password"]);

            // if it detects a professor
            if ($auth->ldapLogin()) {
                // Check if user is enabled
                $_SESSION["auth"] = $auth->isUserEnabled();

                if (Auth::isAuthenticated()) {
                    // Get user permissions
                    $_SESSION["permissions"] = (new PermissionManager($auth->user_data["tipo_utente"]))->getPermissions();

                    //Redirect al controller home
                    Header("Location: ../home");
                } else {
                    $GLOBALS["NOTIFIER"]->add("Sembra che il tuo account non sia abilitato per 
                    accedere a questo servizio, contatta l'amministratore");

                    //Redirect al controller login
                    Header("Location: ../login");
                }
            } else {
                $GLOBALS["NOTIFIER"]->add("Email o password sbagliate. Controlla le credenziali.");
                Header("Location: ../login");
            }
        }
    }

    private function validate_login(array $array): bool
    {
        return isset($_POST["username"]) && isset($_POST["password"]);
    }
}