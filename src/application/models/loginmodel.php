<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 19.09.2019
 * Time: 15:10
 */

class LoginModel
{
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->user_data = array();
    }

    public function ldapLogin(): bool{
        // Check if user is a professor
        $ldap = new LdapAuth($this->username, $this->password);

        // Return result
        return $ldap->auth();
    }

    public function isUserEnabled(): bool {
        // Check if user is enabled to use this application
        $result = DB::query("SELECT * FROM utente WHERE email=%s", $this->username);

        if(count($result) > 0){
            $this->user_data = $result[0];
            return true;
        }

        return false;
    }
}