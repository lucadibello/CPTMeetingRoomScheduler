<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 15.10.2019
 * Time: 14:01
 */

class Booking implements JsonSerializable
{
    private $id;
    private $dataInizio;
    private $dataFine;
    private $creator_username;
    private $osservazioni;

    public function __construct(int $id, datetime $dataInizio, datetime $dataFine, string $creator_username,
                                string $osservazioni=null)
    {
        $this->id = $id;
        $this->dataInizio = $dataInizio;
        $this->dataFine = $dataFine;
        $this->creator_username = $creator_username;
        $this->osservazioni = $osservazioni;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return datetime
     */
    public function getDataInizio(): datetime
    {
        return $this->dataInizio;
    }

    /**
     * @return datetime
     */
    public function getDataFine(): datetime
    {
        return $this->dataFine;
    }

    /**
     * @return string
     */
    public function getCreatorUsername(): string
    {
        return $this->creator_username;
    }

    /**
     * @return string
     */
    public function getOsservazioni() {
        return $this->osservazioni;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}

/**
 * Class BookingValidator this class validates the all the booking related data. WARINING: No database checks here
 */
class BookingValidator{

    /*
     * This method checks if both datetime objects points to the same day. It checks also if the timeEnd "older" than
     * timeStart.
     */
    public static function validateDatetime(datetime $timeStart, datetime $timeEnd): bool {
        /* Check time */
        $right_time = $timeStart < $timeEnd;

        /* Check if same day */
        $right_date = $timeStart->format("Y-m-d") == $timeEnd->format("Y-m-d");

        return $right_time && $right_date;
    }

    public static function validateOsservazioni(string $ossevazioni): bool {
        return strlen($ossevazioni) < 512;
    }
}