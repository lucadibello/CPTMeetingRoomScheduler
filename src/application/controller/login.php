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
            // Check only for local user
            if (Auth::getAuthType() == AuthType::AUTH_LOCAL && !$_SESSION["user"]->isDefaultPasswordChanged()) {
                // Change password model
                RedirectManager::redirect("changepassword");
            } else {
                // If the user is logged in
                RedirectManager::redirect("calendario");
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
                $_SESSION["auth"] = true;
                $_SESSION["user"] = UserModel::getUser($username);
            } // Try to login with ldap
            elseif (($status = $auth->ldapLogin()) && $status instanceof LdapUser) {
                // Check if user exists in database (extra check)
                if(!UserModel::userExists($status->getUsername())){
                    // Add new ldap user to local db
                    $result = UserModel::add_ldap_user($status, $password);

                    if(is_array($result)){
                        // Found errors
                        $GLOBALS["NOTIFIER"]->add("L'accesso non è possibile in quanto c'è stato un problema
                            durante il salvataggio dei dati nel database.");

                        return false;
                    }
                }

                // Save login type
                $_SESSION["auth"] = true;
                $_SESSION["user"] = $status;

            } // Cannot login
            else {
                $GLOBALS["NOTIFIER"]->add("Email o password sbagliate. Controlla le credenziali.");
            }

            if (Auth::isAuthenticated()) {
                if (Auth::getAuthType() == AuthType::AUTH_LOCAL) {
                    // Load permissions
                    $_SESSION["permissions"] = (new PermissionModel($username))->getLocalPermissions();

                    // Check for password change
                    if (!$_SESSION["user"]->isDefaultPasswordChanged()) {
                        // User have to change his password
                        RedirectManager::redirect("changepassword");
                    }
                }
                else {
                    $_SESSION["permissions"] = (new PermissionModel($username))->getLdapPermissions();
                }
                // User has all rights: redirect to calendar page
                RedirectManager::redirect("");
            }
            else {
                // User not logged in: redirect to login page
                RedirectManager::redirect("login");
            }
        } else {
            // Wrong method or data sent
            RedirectManager::redirect("login");
        }
    }

    private function validate_login(array $array): bool
    {
        return isset($_POST["username"]) && isset($_POST["password"]);
    }
}