<?php

class Auth
{

    public static function isAuthenticated()
    {
        if (isset($_SESSION["auth"]) && $_SESSION["auth"]) {
            return true;
        }
        return false;
    }

    public function __construct()
    {
        $_SESSION["auth"] = true;
    }

    public static function getAuthType()
    {
        if (self::isAuthenticated()) {
            if ($_SESSION["user"] instanceof User) {
                return AuthType::AUTH_LOCAL;
            }
            elseif ($_SESSION["user"] instanceof LdapUser) {
                return AuthType::AUTH_LDAP;
            }
            return false;
        }
        else{
            return false;
        }
    }

    public static function logout()
    {
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        session_destroy();
    }
}

class AuthType
{
    const AUTH_LOCAL = "LOCAL";
    const AUTH_LDAP = "LDAP";
}
