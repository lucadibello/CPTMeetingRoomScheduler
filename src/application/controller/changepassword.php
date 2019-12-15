<?php

class ChangePassword
{
    public function index()
    {
        // Redirect to login
        RedirectManager::redirect("login");
    }

    public function id($id)
    {
        if (Auth::isAuthenticated()) {
            // If the user is logged in

            // Check if id is saved into the database
            $change = new PasswordChangeModel();

            if ($change->isIdRight($id, $_SESSION["user"]->getUsername())) {
                // Save token for later verify
                $_SESSION["change_password_token"] = $id;
                ViewLoader::load("changepassword/index");
            } else {
                echo "Hai fornito un id non valido.";
                //RedirectManager::redirect("login");
            }
        } else {
            // If the user is not logged in the controller redirect him to the login page.
            // Redirect to login controller
            RedirectManager::redirect("login");
        }
    }

    public function verify()
    {

        $id = new PasswordChangeModel();

        if ($_SERVER["REQUEST_METHOD"] == "POST"
            && $this->changePasswordRequestValidator()
            && $id->isIdRight($_SESSION["change_password_token"], $_SESSION["user"]->getUsername())) {

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
            } else {
                $GLOBALS["NOTIFIER"]->add("Le password inserite non coincidono");
                RedirectManager::redirect("changepassword/id/" . $_SESSION["change_password_token"]);
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
            && !empty($_POST["newPassword"]) && !empty($_POST["confirmPassword"]) && !empty($_SESSION["user"]->getUsername())
            && isset($_SESSION["change_password_token"]);
    }
}
