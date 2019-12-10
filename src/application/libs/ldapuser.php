<?php


class LdapUser
{
    public function __construct(string $username, string $nome, string $cognome, string $email)
    {
        $this->username = $username;
        $this->nome = $nome;
        $this->cognome = $cognome;
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
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmailAddress(){
        return $this->email;
    }
}