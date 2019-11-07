<?php


/**
 * Class CalendarModel This class is used to parse the booking data in a way that FullCalendar.js understands.
 */
class CalendarModel
{
    /**
     * @param Booking $booking Booking object
     * @return false|string Returns a json string if the parsing process went well, otherwise false.
     */
    public static function toJson(Booking $booking)
    {
        return json_encode(self::_format_array($booking));
    }

    private static function _format_array(Booking $booking): array {
        $creator = UserModel::getUser($booking->getCreatorUsername());

        $data = [
            "id" => $booking->getId(),
            "title" => $creator->getNome() . " " . $creator->getCognome(),
            "start" => $booking->getDataInizio()->format(CALENDAR_DATETIME_FORMAT),
            "end" => $booking->getDataFine()->format(CALENDAR_DATETIME_FORMAT),
            "note" => $booking->getOsservazioni()
        ];

        return $data;
    }

    public static function fromBookingsToJson(array $array){
        $data = [];
        foreach ($array as $booking){
            $data[] = self::_format_array($booking);
        }
        return json_encode($data);
    }
}