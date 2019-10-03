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
    }

    public function ldapLogin(): bool{
        // Check if user is a professor
        $ldap = new LdapAuth($this->username, $this->password);
        // Return result
        return $ldap->auth();
    }

    public function localLogin(){
        // Check if user is enabled to use this application
        $result = DB::query("SELECT password, default_password_changed FROM utente WHERE username=%s", $this->username);

        if(count($result) > 0){
            $status = array("status" => false, "extra_information" => null);
            $pswChanged = (bool) $result[0]["default_password_changed"];
            if(!$pswChanged){
                $status["status"] = $this->password == $result[0]["password"];
                $status["extra_information"] = array("default_password_changed" => false);
                return $status;
            }
            else{
                // Normal password: hashed
                $status["status"] = password_verify($this->password, $result[0]["password"]);
                $status["extra_information"] = array("default_password_changed" => true);
                return $status;
            }
        }
        return false;
    }
}