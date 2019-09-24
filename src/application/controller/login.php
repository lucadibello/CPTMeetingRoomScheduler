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

            if(isset($_SESSION["default_password_changed"]) && !$_SESSION["default_password_changed"]) {
                $this->changePassword();
                exit();
            }
            else{
                // If the user is logged in
                //ViewLoader::load_full("home/index");
                Header("Location: home");
            }


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

            // Clear data
            $username = filter_input(INPUT_POST, 'username', FILTER_DEFAULT);
            $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

            // Create auth object
            $auth = new LoginModel($username, $password);

            var_dump($auth->localLogin());
            var_dump($auth->ldapLogin());

            // Try to login with Local database
            if(($status = $auth->localLogin()) && $status["status"]){
                $_SESSION["auth"] = $status["status"];
                $_SESSION["username"] = $username;
                $_SESSION["default_password_changed"] = $status["extra_information"]["default_password_changed"];
                $_SESSION["login_type_used"] = "LOCAL";
            }
            // Try to login with ldap
            elseif(($_SESSION["auth"] = $auth->ldapLogin())){
                // Save login type
                $_SESSION["login_type_used"] = "LDAP";
            }
            // Cannot login
            else{
                $GLOBALS["NOTIFIER"]->add("Email o password sbagliate. Controlla le credenziali.");
            }

            if(Auth::isAuthenticated()){
                $_SESSION["permissions"] = (new PermissionManager($username))->getPermissions();

                if(isset($_SESSION["default_password_changed"]) && !$_SESSION["default_password_changed"]){
                    // Send email with confirmation id
                    $this->changePassword();


                    // User have to change password
                    Header("Location: ../changepassword");
                }
                else{
                    // User has all right
                    Header("Location: ../home");
                }
            }
            else{
                Header("Location: ../login");
            }
        }
    }

    private function changePassword(){
        require_once("./application/models/passwordchangemodel.php");
        $a = new PasswordChangeModel();

        // Generate custom URL and save it to database
        $a->generateUrl($_SESSION["username"]);
    }

    private function validate_login(array $array): bool
    {
        return isset($_POST["username"]) && isset($_POST["password"]);
    }
}