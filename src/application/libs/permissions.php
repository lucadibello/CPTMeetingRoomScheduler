<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 03.10.2019
 * Time: 13:52
 */

class Permissions
{
    private $PERMISSIONS_NAME;

    // User related permissions
    private $creazione_utenti;
    private $eliminazione_utenti;
    private $promozione_utenti;
    private $modifica_utenti;

    // Booking related permissions
    private $visione_prenotazioni;
    private $inserimento_prenotazioni;
    private $cancellazione_prenotazioni;
    private $modifica_prenotazioni;

    private $cancellazione_prenotazioni_altri_utenti;
    private $inserimento_prenotazioni_altri_utenti;
    private $modifica_prenotazioni_altri_utenti;


    public function __construct(bool $creazione_utenti,
                                bool $eliminazione_utenti,
                                bool $promozione_utenti,
                                bool $visione_prenotazioni,
                                bool $inserimento_prenotazioni,
                                bool $cancellazione_prenotazioni,
                                bool $cancellazione_prenotazioni_altri_utenti,
                                bool $modifica_utenti,
                                bool $inserimento_prenotazioni_altri_utenti,
                                bool $modifica_prenotazioni,
                                bool $modifica_prenotazioni_altri_utenti,
                                string $permissions_name)
    {
        $this->creazione_utenti = $creazione_utenti;
        $this->eliminazione_utenti = $eliminazione_utenti;
        $this->promozione_utenti = $promozione_utenti;
        $this->visione_prenotazioni = $visione_prenotazioni;
        $this->inserimento_prenotazioni = $inserimento_prenotazioni;
        $this->cancellazione_prenotazioni = $cancellazione_prenotazioni;
        $this->cancellazione_prenotazioni_altri_utenti = $cancellazione_prenotazioni_altri_utenti;
        $this->modifica_utenti = $modifica_utenti;

        $this->inserimento_prenotazioni_altri_utenti = $inserimento_prenotazioni_altri_utenti;
        $this->modifica_prenotazioni = $modifica_prenotazioni;
        $this->modifica_prenotazioni_altri_utenti = $modifica_prenotazioni_altri_utenti;

        $this->PERMISSIONS_NAME = $permissions_name;
    }

    public function getPermissionName(): string
    {
        return $this->PERMISSIONS_NAME;
    }

    public function canModificareUtenti(): bool
    {
        return $this->modifica_utenti;
    }

    public function canVisionePrenotazioni(): bool
    {
        return $this->visione_prenotazioni;
    }

    public function canInserirePrenotazioniPrivate(): bool
    {
        return $this->inserimento_prenotazioni;
    }

    public function canInserirePrenotazioniGlobali(): bool
    {
        return $this->inserimento_prenotazioni_altri_utenti;
    }

    public function canCancellazionePrenotazioniPrivate()
    {
        return $this->cancellazione_prenotazioni;
    }

    public function canCancellazionePrenotazioniGlobali()
    {
        return $this->cancellazione_prenotazioni_altri_utenti;
    }

    public function canModificaPrenotazioniPrivate(){
        return $this->modifica_prenotazioni;
    }

    public function canModificaPrenotazioniGlobali(){
        return $this->modifica_prenotazioni_altri_utenti;
    }

    public function canEliminareUtenti(): bool
    {
        return $this->eliminazione_utenti;
    }

    public function canCreareUtenti(): bool
    {
        return $this->creazione_utenti;
    }

    public function canPromozioneUtenti(): bool
    {
        return $this->promozione_utenti;
    }



    /* WRAPPER FUNCTIONS */
    public function canUserAction(): bool
    {
        return $this->canCreareUtenti() || $this->canPromozioneUtenti() ||
            $this->canEliminareUtenti() || $this->canModificareUtenti();
    }

}