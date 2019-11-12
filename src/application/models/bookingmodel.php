<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 15.10.2019
 * Time: 14:07
 */

class BookingModel
{
    private static $errors = [];


    public static function getBookings(): array
    {
        $result = DB::query("SELECT * FROM riservazione");
        return self::parseBookingArrayData($result);
    }

    public static function getBooking(int $id){
        $result = DB::query("SELECT * FROM riservazione WHERE id=%d", $id);
        if(count($result) > 0){
            return self::parseBookingData($result[0]);
        }
        else{
            return false;
        }
    }

    public static function getUserBookings(string $username): array
    {
        $result = DB::query("SELECT * FROM riservazione where utente=%s", $username);
        return self::parseBookingArrayData($result);
    }

    /**
     * This method is used to add a new booking to the database.
     *
     * @param $data array Booking data array
     * @return array|bool Return array if the booking was added to the database, otherwise it returns an error as an
     * array
     */
    public static function add(array $data){
        // Check booking data
        if(self::validateBookingData($data)){
            // Insert data into database
            $result = DB::insert('riservazione', array(
                'data' => $data["dataInizio"]->format(BOOKING_DATE_FORMAT),
                'ora_inizio' => $data["dataInizio"]->format(BOOKING_TIME_FORMAT),
                'ora_fine' => $data["dataFine"]->format(BOOKING_TIME_FORMAT),
                'osservazioni' => (empty($data["osservazioni"]) ? null : $data["osservazioni"]),
                'utente' => $_SESSION["username"]
            ));

            // Return true (if the insert query was successful) otherwise it returns an error as array
            return  (!$result ? array("C'è stato un errore durante l'inserimento dei dati 
                all'interno del database. Contattare un amministratore.") : true);
        }
        // Booking data not valid
        else{
            $GLOBALS["NOTIFIER"]->add_all(self::$errors);
            RedirectManager::redirect("admin/utenti");
        }
    }

    public static function delete($booking_id)
    {
        $result = DB::delete("riservazione", "id=%d", $booking_id);
        return  (!$result ? array("C'è stato un errore durante l'eliminazione della prenotazione. 
            Contattare un amministratore") : true);
    }

    private static function parseBookingData($booking_data): Booking
    {
        $_format = BOOKING_DATE_FORMAT . " " . BOOKING_TIME_FORMAT;
        $date = $booking_data["data"];

        return new Booking(
            $booking_data["id"],
            DateTime::createFromFormat($_format, $date . " " . $booking_data["ora_inizio"]),
            DateTime::createFromFormat($_format, $date . " " . $booking_data["ora_fine"]),
            $booking_data["utente"],
            $booking_data["osservazioni"]
        );
    }

    /* WRAPPER METHOD */
    private static function parseBookingArrayData($data): array {
        $bookings = [];

        foreach ($data as $row) {
            $bookings[] = self::parseBookingData($row);
        }

        return $bookings;
    }

    private static function validateBookingData($data): bool{
        self::$errors = [];

        if(!BookingValidator::validateDatetime($data["dataInizio"],$data["dataFine"])){
            self::$errors[] = "Le date inserite non sono valide";
        }

        if(isset($data["osservazioni"]) && !BookingValidator::validateOsservazioni($data["osservazioni"])){
            self::$errors[] = "La descrizione è troppo lunga";
        }

        return count(self::$errors) == 0;
    }
}