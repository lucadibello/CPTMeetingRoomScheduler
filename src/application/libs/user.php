<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 04.10.2019
 * Time: 13:24
 */

class User
{
    public function __construct(string $username, string $nome, string $cognome, string $tipo_utente, bool $default_password_changed, string $email)
    {
        $this->username = $username;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->tipo_utente = $tipo_utente;
        $this->default_password_changed = $default_password_changed;
        $this->tipo_utente = $tipo_utente;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @return bool
     */
    public function isDefaultPasswordChanged(): bool
    {
        return $this->default_password_changed;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getTipoUtente()
    {
        return $this->tipo_utente;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getPartialEmailAddress(){
        return $this->email;
    }

    public function getFullEmailAddress(){
        return $this->email . "@" . EMAIL_ALLOWED_DOMAIN;
    }

    public static function generatePassword(){
        return password_hash(time(), PSW_CRYPT_METHOD);
    }
}

class UserValidator{
    public static function validateUsername(string $username){
        return preg_match("/^[a-zA-Z0-9.]{1,255}$/", $username);
    }

    public static function validateNome(string $nome){
        setlocale(LC_ALL, 'it_CH.utf8');
        return ctype_alpha($nome);
    }

    public static function validateCognome(string $cognome){
        setlocale(LC_ALL, 'it_CH.utf8');
        return ctype_alpha(str_replace(" " ,"", $cognome));
    }

    public static function validateEmail(string $email){
        $valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $valid_domain_check = explode('@', $email)[1] == EMAIL_ALLOWED_DOMAIN;

        return $valid_email != false && $valid_domain_check;
    }

    public static function validateUserPermissionName($perm){
        return in_array($perm, PermissionModel::getUniquePermissionTypes());
    }
}