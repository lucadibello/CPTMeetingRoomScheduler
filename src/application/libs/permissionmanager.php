<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 20.09.2019
 * Time: 14:28
 */

class PermissionManager
{
    public function __construct(string $perm_key)
    {
        $this->PERM_KEY = $perm_key;
    }

    public function getPermissions(): Permissions{
        $data = $this->read_from_database();
        return $this->parse_data($data);
    }

    private function read_from_database(){
        return DB::query("SELECT * FROM tipo_utente WHERE nome=%s", $this->PERM_KEY)[0];
    }

    private function parse_data(array $data): Permissions{
        return new Permissions(
            $data["creazione_utenti"], $data["eliminazione_utenti"],
            $data["promozione_utenti"], $data["visione_prenotazioni"],
            $data["inserimento_prenotazioni"], $data["cancellazione_prenotazioni_personali"],
            $data["cancellazione_prenotazioni_altri_utenti"], $this->PERM_KEY
        );
    }
}

class Permissions
{
    private $PERMISSIONS_NAME;
    private $creazione_utenti;
    private $eliminazione_utenti;
    private $promozione_utenti;
    private $visione_prenotazioni;
    private $inserimento_prenotazioni;
    private $cancellazione_prenotazioni_personali;
    private $cancellazione_prenotazioni_altri_utenti;

    public function __construct(bool $creazione_utenti, bool $eliminazione_utenti, bool $promozione_utenti,
                                bool $visione_prenotazioni, bool $inserimento_prenotazioni,
                                bool $cancellazione_prenotazioni_personali,
                                bool $cancellazione_prenotazioni_altri_utenti, string $permissions_name)
    {
        $this->creazione_utenti = $creazione_utenti;
        $this->eliminazione_utenti = $eliminazione_utenti;
        $this->promozione_utenti = $promozione_utenti;
        $this->visione_prenotazioni = $visione_prenotazioni;
        $this->inserimento_prenotazioni = $inserimento_prenotazioni;
        $this->cancellazione_prenotazioni_personali = $cancellazione_prenotazioni_personali;
        $this->cancellazione_prenotazioni_altri_utenti = $cancellazione_prenotazioni_altri_utenti;
        $this->PERMISSIONS_NAME = $permissions_name;
    }

    public function getPermissionName(){
        return $this->PERMISSIONS_NAME;
    }

    public function canCreareUtenti(){
        return $this->creazione_utenti;
    }

    public function canEliminareUtenti(){
        return $this->eliminazione_utenti;
    }

    public function canPromozioneUtenti(){
        return $this->promozione_utenti;
    }

    public function canVisionePrenotazioni()
    {
        return $this->visione_prenotazioni;
    }

    public function canInserirePrenotazioni(){
        return $this->inserimento_prenotazioni;
    }

    public function canCancellazionePrenotazioniPrivate(){
        return $this->cancellazione_prenotazioni_personali;
    }

    public function canCancellazionePrenotazioniGlobali(){
        return $this->cancellazione_prenotazioni_altri_utenti;
    }
}