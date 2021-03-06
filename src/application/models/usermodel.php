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

    public static function userExists($username): bool
    {
        // Check if the user is saved into the database
        $data = DB::query("SELECT * FROM utente WHERE username=%s", $username);
        return count($data) != 0;
    }

    public static function getUsers(): array
    {
        return self::getUsersData();
    }

    public static function getLocalUsers(): array
    {
        // Return only local users
        return self::getLocalUsersData();
    }

    public static function getLdapUsers() : array
    {
        // Return only ldap users
        return self::getLdapUsersData();
    }

    /* API METHODS */
    public static function delete(string $username) {

        // Internal function
        function delete_user($username){
            $result = DB::delete("utente", "username=%s", $username);
            return  (!$result ? array("C'è stato un errore durante l'eliminazione dell'utente. 
                Contattare un amministratore.") : true);
        }

        // Read user permission group
        $perm_name = PermissionModel::getUserPermissionGroup($username);

        // Check if user is admin
        if($perm_name == ADMIN_PERMISSION_GROUP){
            if($username != $_SESSION["user"]->getUsername()) {
                if(self::countAdmins() > MINIMUM_ADMINS_ALLOWED){
                    // Calls delete internal function
                    return delete_user($username);
                }
                else{
                    return array("Ci devono essere almeno " . MINIMUM_ADMINS_ALLOWED . " admin(s) nel sistema. Impossibile
                    eliminare l'account");
                }
            }
            else{
                // The user is trying to delete himself
                return array("Non puoi eliminare l'account con cui sei loggato. Esegui il login con altro 
                account autorizzato e riprova");
            }
        }
        else{
            // Calls delete internal function
            return delete_user($username);
        }
    }

    public static function countAdmins(): int{
        DB::query("SELECT * FROM utente WHERE tipo_utente=%s", ADMIN_PERMISSION_GROUP);
        return DB::count();
    }

    public static function getUser($username){
        $result = DB::query("SELECT * FROM utente WHERE username=%s", $username);
        if(count($result) > 0){
            return self::parseUserData($result[0]);
        }
        else{
            return false;
        }
    }

    public static function add(array $data){
        // Complete email
        $partial_mail = $data["email"];
        $data["email"] = $data["email"] . "@" . EMAIL_ALLOWED_DOMAIN;
        // Validate data
        if(self::validateAllUserData($data)){
            // Generate password
            $password = User::generatePassword();
            // add data to database
            $result = DB::insert("utente", array(
                "username" => $data["username"],
                "password" => $password,
                "nome" => $data["nome"],
                "cognome" => $data["cognome"],
                "tipo_utente" => $data["tipo_utente"],
                "default_password_changed" => false,
                "email"=> $partial_mail
            ));

            // Return error or the generated password
            return  (!$result ? array("C'è stato un errore durante l'inserimento dei dati 
                all'interno del database. Contattare un amministratore.") : $password);
        }
        else{
            $GLOBALS["NOTIFIER"]->add_all(self::$errors);
            RedirectManager::redirect("admin/utenti");
        }
    }

    public static function add_ldap_user(LdapUser $ldap, $password){
        // add data to database
        $result = DB::insert("utente", array(
            "username" => $ldap->getUsername(),
            "password" => password_hash($password, PSW_CRYPT_METHOD),
            "nome" => $ldap->getNome(),
            "cognome" => $ldap->getCognome(),
            "tipo_utente" => DEFAULT_USER_PERMISSION_GROUP,
            "default_password_changed" => true,
            "email"=> $ldap->getUsername(),
            "is_ldap" => 1
        ));

        // Return error or the generated password
        return  (!$result ? array("C'è stato un errore durante l'inserimento dei dati 
                all'interno del database. Contattare un amministratore.") : true);
    }

    public static function update(array $data, string $username){
        // Complete email
        $partial_mail = $data["email"];
        $data["email"] = $data["email"] . "@" . EMAIL_ALLOWED_DOMAIN;
        // Validate data
        if(self::validateUpdateUserData($data)){
            $result = DB::update("utente", array(
                "username" => $data["username"],
                "nome" => $data["nome"],
                "cognome" => $data["cognome"],
                "email"=> $partial_mail
            ), "username=%s", $username);

            return  (!$result ? array("C'è stato un errore durante l'inserimento dei dati 
                all'interno del database. Contattare un amministratore.") : true);
        }
        else{
            $GLOBALS["NOTIFIER"]->add_all(self::$errors);
            RedirectManager::redirect("admin/utenti");
        }
    }

    public static function promote(array $data, string $username){
        if(UserValidator::validateUsername($data["tipo_utente"])){
            $result = DB::update("utente", array(
                "tipo_utente" => $data["tipo_utente"],
            ),"username=%s", $username);

            return  (!$result ? array("C'è stato un errore durante l'inserimento dei dati 
                all'interno del database. Contattare un amministratore.") : true);
        }
        else{
            $GLOBALS["NOTIFIER"]->add_all(self::$errors);
            RedirectManager::redirect("admin/utenti");
        }
    }

    private static function getUsersData()
    {
        // Read users data from database
        $result = DB::query("SELECT * FROM utente");
        return self::parseUsersData($result);
    }

    private static function getLocalUsersData(){
        // Read users data from database
        $result = DB::query("SELECT * FROM utente WHERE is_ldap = 0");
        return self::parseUsersData($result);
    }

    public static function getLdapUsersData(){
        // Read users data from database
        $result = DB::query("SELECT * FROM utente WHERE is_ldap = 1");
        return self::parseUsersData($result);
    }

    private static function parseUsersData($users_data){
        // Parse user data from database
        $users = [];
        foreach ($users_data as $row) {
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


    private static function validateAllUserData($data){
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

        if(!UserValidator::validateUserPermissionName($data["tipo_utente"])){
            self::$errors[] = "Hai fornito un tipo di utente non valido";
        }

        if(!UserValidator::validateEmail($data["email"])){
            self::$errors[] = "Hai fornito un indirizzo mail non valido. Controlla che l'email desiderata sia 
            formattata correttamente e che abbia il dominio '" . EMAIL_ALLOWED_DOMAIN . "'";
        }

        return count(self::$errors) == 0;
    }

    private static function validateUpdateUserData($data){
        self::$errors = [];

        if(!UserValidator::validateUsername($data["username"])){
            self::$errors[] = "Hai fornito un username non valido";
        }

        if(!UserValidator::validateNome($data["nome"])){
            self::$errors[] = "Hai fornito un nome non valido";
        }

        if(!UserValidator::validateCognome($data["cognome"])){
            self::$errors[] = "Hai fornito un cognome non valido";
        }

        if(!UserValidator::validateEmail($data["email"])){
            self::$errors[] = "Hai fornito un indirizzo mail non valido. Controlla che l'email desiderata sia 
            formattata correttamente e che abbia il dominio '" . EMAIL_ALLOWED_DOMAIN . "'";
        }

        return count(self::$errors) == 0;
    }
}