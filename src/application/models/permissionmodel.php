<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 03.10.2019
 * Time: 13:51
 */

class PermissionModel
{
    public function __construct(String $username)
    {
        $this->PERM_KEY = $this->getUserPermissionGroup($username);
    }

    // Permissions for local users
    public function getLocalPermissions(): Permissions{
        $data = $this->read_from_database($this->PERM_KEY);
        return $this->parse_data($data, $this->PERM_KEY);
    }

    // Permissions for LDAP users
    public function getLdapPermissions(): Permissions{
        $data = $this->read_from_database(DEFAULT_USER_PERMISSION_GROUP);
        return $this->parse_data($data, DEFAULT_USER_PERMISSION_GROUP);
    }

    // Get all user types
    public static function getUniquePermissionTypes(){
        // Read data from DB
        $result = DB::query("SELECT nome FROM tipo_utente");

        // Parse data
        $types = [];
        foreach ($result as $row){
            $types[] = $row["nome"];
        }

        return $types;
    }

    private function getUserPermissionGroup($username){
        $result = DB::query("SELECT tipo_utente FROM utente WHERE username=%s",$username);

        if(count($result)>0){
            return $result[0]["tipo_utente"];
        }
        else{
            return DEFAULT_USER_PERMISSION_GROUP;
        }
    }

    private function read_from_database($perm_key){
        return DB::query("SELECT * FROM tipo_utente WHERE nome=%s", $perm_key)[0];
    }

    private function parse_data(array $data, $perm_key): Permissions{
        return new Permissions(
            $data["creazione_utenti"], $data["eliminazione_utenti"],
            $data["promozione_utenti"], $data["visione_prenotazioni"],
            $data["inserimento_prenotazioni"], $data["cancellazione_prenotazioni_personali"],
            $data["cancellazione_prenotazioni_altri_utenti"], $data["modifica_utenti"],
            $perm_key
        );
    }
}