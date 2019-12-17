<?php

class ChangePassword
{
    public function index()
    {
        if(Auth::isAuthenticated()){
            if (Auth::getAuthType() == AuthType::AUTH_LOCAL && !$_SESSION["user"]->isDefaultPasswordChanged()) {
                // Load page
                ViewLoader::load("changepassword/index");
            }
            else{
                // User already changed his password
                RedirectManager::redirect("calendario");
            }
        }
        else{
            // Redirect to login
            RedirectManager::redirect("calendario");
        }
    }

    public function verify()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $this->changePasswordRequestValidator()) {
            if ($_POST["newPassword"] == $_POST["confirmPassword"]) {
                $model = new UserModel();

                if ($model->userChangePassword($_SESSION["user"]->getUsername(), $_POST["confirmPassword"])) {
                    Auth::logout();

                    setcookie('password_changed_successfully', true,
                        time() + PASSWORD_CHANGED_MESSAGE_COOKIE_ADD_LIFETIME, '/');

                    RedirectManager::redirect("login");
                } else {
                    echo "C'è stato un problema durante il cambiamento della password. Contattare un amministratore.";
                }
            }
            else {
                $GLOBALS["NOTIFIER"]->add("Le password inserite non coincidono");
                RedirectManager::redirect("changepassword");
            }
        } else {
            // If wrong request method
            RedirectManager::redirect("login");
        }
    }

    private function changePasswordRequestValidator(): bool
    {
        // Clear data
        $_POST = filter_input_array(INPUT_POST, $_POST);

        return isset($_POST["newPassword"]) && isset($_POST["confirmPassword"]) && isset($_SESSION["user"])
            && !empty($_POST["newPassword"]) && !empty($_POST["confirmPassword"]) && !empty($_SESSION["user"]->getUsername());
    }
}
