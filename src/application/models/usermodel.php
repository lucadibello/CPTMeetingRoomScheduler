<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 01.10.2019
 * Time: 15:27
 */

class UserModel
{
    private static $errors = [];

    /* WRAPPER METHOD */
    public function userChangePassword($username, $new_password)
    {
        return $this->usrCngPassword($username, $new_password);
    }

    /* WRAPPER METHOD */

    private function usrCngPassword($user, $new_psw): bool
    {
        return DB::update("utente", array(
            "password" => password_hash($new_psw, PSW_CRYPT_METHOD),
            "default_password_changed" => true
        ), "username=%s", $user);
    }

    public static function getUsers(): array
    {
        return self::getUsersData();
    }

    /* API METHODS */
    public static function delete(string $username): bool {
        return DB::delete("utente", "username=%s", $username);
    }

    public static function add(array $data){
        // Complete email
        $data["email"] = $data["email"] . "@" . EMAIL_ALLOWED_DOMAIN;
        // Validate data
        if(self::validateUserData($data)){
            $result = DB::insert("utente", array(
                "username" => $data["username"],
                "password" => User::generatePassword(),
                "nome" => $data["nome"],
                "cognome" => $data["cognome"],
                "tipo_utente" => $data["tipo_utente"],
                "default_password_changed" => false,
                "email"=> $data["email"]
            ));

            return  (!$result ? array("C'è stato un errore durante l'inserimento dei dati 
                all'interno del database. Contattare un amministratore.") : true);
        }
        else{
            $GLOBALS["NOTIFIER"]->add_all(self::$errors);
            RedirectManager::redirect("admin/utenti");
        }
    }

    public static function update(array $data, string $username){
        DB::update();
    }

    private static function getUsersData()
    {
        // Read users data from database
        $result = DB::query("SELECT * FROM utente");

        // Parse user data from database
        $users = [];
        foreach ($result as $row) {
            $users[] = self::parseUserData($row);
        }

        // Return parsed result
        return $users;
    }

    private static function parseUserData($user_data): User
    {
        return new User(
            $user_data["username"],
            $user_data["nome"],
            $user_data["cognome"],
            $user_data["tipo_utente"],
            (bool)$user_data["default_password_changed"],
            $user_data["email"]
        );
    }


    private static function validateUserData($data){
        self::$errors = [];

        if(!UserValidator::validateUsername($data["username"])){
            self::$errors[] = "Hai fornito un username non valido non valido";
        }

        if(!UserValidator::validateNome($data["nome"])){
            self::$errors[] = "Hai fornito un nome non valido";
        }

        if(!UserValidator::validateCognome($data["cognome"])){
            self::$errors[] = "Hai fornito un cognome non valido";
        }

        if(!in_array($data["tipo_utente"], PermissionModel::getUniquePermissionTypes())){
            self::$errors[] = "Hai fornito un tipo di utente non valido";
        }

        if(!UserValidator::validateEmail($data["email"])){
            self::$errors[] = "Hai fornito un indirizzo mail non valido. Controlla che l'email desiderata sia 
            formattata correttamente e che abbia il dominio '" . EMAIL_ALLOWED_DOMAIN . "'";
        }

        return count(self::$errors) == 0;
    }
}