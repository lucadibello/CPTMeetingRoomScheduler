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
    public static function validatePastDateTime(datetime $timeStart): bool {
        /* Check if date is in the past */
        return $timeStart > new DateTime();
    }

    public static function validateInRange(datetime $time, datetime $rangeStart, datetime $rangeEnd){
        // Convert to timestamp
        $currentTimeStamp = $time->getTimestamp();
        $rangeStartTimeStamp = $rangeStart->getTimestamp();
        $rangeEndTimeStamp = $rangeEnd->getTimestamp();

        // Check that user date is between start & end
        return $currentTimeStamp >= $rangeStartTimeStamp && $currentTimeStamp <= $rangeEndTimeStamp;
    }

    public static function validateTime(datetime $timeStart, datetime $timeEnd){
        /* Check time */
        return $timeStart < $timeEnd;
    }

    public static function validateSameDay(datetime $timeStart, datetime $timeEnd){
        /* Check if same day */
        return $timeStart->format("Y-m-d") == $timeEnd->format("Y-m-d");
    }

    public static function validateOsservazioni(string $ossevazioni): bool {
        return strlen($ossevazioni) < 512;
    }

    public static function validateOverlapBooking(datetime $timeStart, datetime $timeEnd, $max_overlap_events): bool {
        $overlap_events = count(BookingModel::getEventsFromRange($timeStart, $timeEnd));
        return $overlap_events >= 0 && $overlap_events <= $max_overlap_events;
    }
}