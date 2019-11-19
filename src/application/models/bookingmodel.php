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

            $date = DateTime::createFromFormat("d/m/Y", $data["data"]);

            $result = DB::insert('riservazione', array(
                'data' => $date->format("Y/m/d"),
                'ora_inizio' => $data["ora_inizio"],
                'ora_fine' => $data["ora_fine"],
                'osservazioni' => (empty($data["osservazioni"]) ? null : $data["osservazioni"]),
                'utente' => $_SESSION["username"]
            ));

            // Return true (if the insert query was successful) otherwise it returns an error as array
            return  (!$result ? array("C'è stato un errore durante l'inserimento dei dati 
                all'interno del database. Contattare un amministratore.") : true);

        }
        // Booking data not valid
        else{
            return self::$errors;
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

        $data_inizio = DateTime::createFromFormat("d/m/Y H:i", $data["data"] . " " . $data["ora_inizio"]);
        $data_fine = DateTime::createFromFormat("d/m/Y H:i", $data["data"] . " " . $data["ora_fine"]);

        if(!BookingValidator::validateDatetime($data_inizio,$data_fine)){
            self::$errors[] = "Le date inserite non sono valide";
        }

        if(isset($data["osservazioni"]) && !BookingValidator::validateOsservazioni($data["osservazioni"])){
            self::$errors[] = "La descrizione è troppo lunga";
        }

        return count(self::$errors) == 0;
    }
}