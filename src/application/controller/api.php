<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 04.10.2019
 * Time: 15:03
 */

class Api
{
    /**
     * HTTP Api for User Management
     *
     * @param $action string Desired API action. Here is the list of the available actions: delete, add, update, promote.
     * @param null $username User's username. It have to be set if using these actions: delete, update, promote.
     */
    public function user($action = "", $username = null)
    {
        if (Auth::isAuthenticated()) {
            $GLOBALS["NOTIFIER"]->clear();

            /*
             * TODO: Check
             * Action url: api/user/
             * Permission needed: modifica_utenti
             */
            if (empty($action) && !is_null($username)) {
                if (PermissionManager::getPermissions()->canModificareUtenti()) {
                    // Sanitize POST data and promote user
                    $result = UserModel::getUsers();

                    echo json_encode($result);
                    exit();
                } else {
                    $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per la promozione degli utenti");
                }

                RedirectManager::redirect("admin/utenti");
            } /*
             * Action url: api/user/delete/<username>
             * Permission needed: eliminazione_utenti
             * Extra data: none
             */
            elseif ($action == "delete" && !is_null($username)) {
                if (PermissionManager::getPermissions()->canEliminareUtenti()) {
                    $result = UserModel::delete($username);

                    if (is_array($result)) {
                        $GLOBALS["NOTIFIER"]->add_all($result);
                    }
                } else {
                    $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per eliminare gli utenti");
                }

                RedirectManager::redirect("admin/utenti");
            } /*
             * Action url: api/user/add
             * Permission needed: creazione_utenti
             * Extra data: POST data
             */
            elseif ($action == "add" && $_SERVER["REQUEST_METHOD"] == "POST") {
                if (PermissionManager::getPermissions()->canCreareUtenti()) {
                    // Sanitize POST data and add record to database
                    $result = UserModel::add(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
                    // If it detects errors
                    if (is_array($result)) {
                        $GLOBALS["NOTIFIER"]->add_all($result);
                    }
                } else {
                    $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per la creazione degli utenti");
                }

                RedirectManager::redirect("admin/utenti");
            } /*
             * Action url: api/user/update/<username>
             * Permission needed: modifica_utenti
             * Extra data: POST data
             */
            elseif ($action == "update" && !is_null($username) && $_SERVER["REQUEST_METHOD"] == "POST") {
                // Sanitize POST data and add record to database
                if (PermissionManager::getPermissions()->canModificareUtenti()) {
                    $result = UserModel::update(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING),
                        $username);

                    // If it detects errors
                    if (is_array($result)) {
                        $GLOBALS["NOTIFIER"]->add_all($result);
                    }

                    RedirectManager::redirect("admin/utenti");
                } else {
                    $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per la modifica degli utenti");
                }

                RedirectManager::redirect("admin/utenti");
            } /*
             * Action url: api/user/promote/<username>
             * Permission needed: promozione_utenti
             * Extra data: POST data
             */
            elseif ($action == "promote" && !is_null($username) && $_SERVER["REQUEST_METHOD"] == "POST") {
                if (PermissionManager::getPermissions()->canPromozioneUtenti()) {
                    // Sanitize POST data and promote user
                    $result = UserModel::promote(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING), $username);

                    // If it detects errors
                    if (is_array($result)) {
                        $GLOBALS["NOTIFIER"]->add_all($result);
                    }
                } else {
                    $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per la promozione degli utenti");
                }

                RedirectManager::redirect("admin/utenti");
            }


            // Unknown API request
            RedirectManager::redirect("admin");
        } else {
            // Not logged: show login page
            RedirectManager::redirect("/");
        }
    }

    /**
     * HTTP Api for Booking management
     *
     * @param $action string Desired API action. Here is the list of the available actions: delete, add, update, promote.
     * @param null $booking_id Booking identifier. It have to be set if using these actions: delete, update, promote.
     */
    public function booking($action = null, $booking_id = null)
    {
        header('Content-Type: application/json');
        $GLOBALS["NOTIFIER"]->clear();

        /*
         * Action url: api/booking/add
         * Permission needed: visione_prenotazioni
         * Extra data: POST
         */
        if ($action == "add" && $_SERVER["REQUEST_METHOD"] == "POST") {

            if (PermissionManager::getPermissions()->canInserirePrenotazioniPrivate()) {
                // Sanitize POST data and promote user
                $result = BookingModel::add(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));

                // If it detects errors
                if (is_array($result)) {
                    $GLOBALS["NOTIFIER"]->add_all($result);
                }
            } else {
                $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per inserire le prenotazioni");
            }

            // Check errors
            if (count($GLOBALS["NOTIFIER"]->getNotifications()) == 0) {
                // success
                echo json_encode(array("success" => true));
            } else {
                // errors detected
                echo json_encode(array("success" => false, "errors" => $GLOBALS["NOTIFIER"]->getNotifications()));
            }

            exit();
        } /*
             * Action url: api/booking/delete/<booking_id>
             * Permission needed: eliminazione_utenti
             * Extra data: none
             */
        elseif ($action == "delete" && !is_null($booking_id)) {
            $booking = BookingModel::getBooking($booking_id);
            if ($booking != false) {
                // Check if the user who want to delete the booking is the same of the related booking
                if ($booking->getCreatorUsername() == $_SESSION["user"]->getUsername()) {

                    // If same user
                    if (PermissionManager::getPermissions()->canCancellazionePrenotazioniPrivate()) {
                        $result = BookingModel::delete($booking_id);

                        if (is_array($result)) {
                            $GLOBALS["NOTIFIER"]->add_all($result);
                        }

                    } else {
                        $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per eliminare le tue prenotazioni");
                    }
                } else {
                    // If other user
                    if (PermissionManager::getPermissions()->canCancellazionePrenotazioniGlobali()) {
                        $result = BookingModel::delete($booking_id);

                        if (is_array($result)) {
                            $GLOBALS["NOTIFIER"]->add_all($result);
                        }
                    } else {
                        $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per eliminare le tue prenotazioni degli altri utenti");
                    }
                }
            } else {
                $GLOBALS["NOTIFIER"]->add("L'evento fornito risulta non esistente");
            }

            // Check errors
            if (count($GLOBALS["NOTIFIER"]->getNotifications()) == 0) {
                // success
                echo json_encode(array("success" => true));
            } else {
                // errors detected
                echo json_encode(array("success" => false, "errors" => $GLOBALS["NOTIFIER"]->getNotifications()));
            }
            exit();
        } /*
             * Action url: api/booking/update/<booking_id>
             * Permission needed: modifica_prenotazione_personali | modifica_prenotazione_altri_utenti
             * Extra data: POST
             */
        elseif ($action == "update" && !is_null($booking_id) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $booking = BookingModel::getBooking($booking_id);

            if ($booking != false) {
                if ($booking->getCreatorUsername() == $_SESSION["user"]->getUsername()) {
                    // Private booking
                    if (PermissionManager::getPermissions()->canModificaPrenotazioniPrivate()) {
                        // Sanitize POST data and promote user
                        $result = BookingModel::update(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING), $booking_id);

                        // If it detects errors
                        if (is_array($result)) {
                            $GLOBALS["NOTIFIER"]->add_all($result);
                        }
                    } else {
                        $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per modificare le tue prenotazioni");
                    }
                } else {
                    // Global booking
                    if (PermissionManager::getPermissions()->canModificaPrenotazioniGlobali()) {
                        // Sanitize POST data and promote user
                        $result = BookingModel::update(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING), $booking_id);

                        // If it detects errors
                        if (is_array($result)) {
                            $GLOBALS["NOTIFIER"]->add_all($result);
                        }
                    } else {
                        $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per modificare le prenotazioni di altri utenti");
                    }
                }
            } else {
                $GLOBALS["NOTIFIER"]->add("L'evento fornito risulta non esistente");
            }


            // Check errors
            if (count($GLOBALS["NOTIFIER"]->getNotifications()) == 0) {
                // success
                echo json_encode(array("success" => true));
            } else {
                // errors detected
                echo json_encode(array("success" => false, "errors" => $GLOBALS["NOTIFIER"]->getNotifications()));
            }
            exit();
        }

        // Unknown API request
        RedirectManager::redirect("calendario");
    }

    /**
     * HTTP API used by the Raspberry Pi to read all the booking related data stored in the database.
     */
    public function calendar($type=null)
    {
        // Allow CORS
        header("Access-Control-Allow-Origin: *");

        // Set json content
        header('Content-Type: application/json');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["token"])) {
                if ($_POST["token"] == API_TOKEN) {
                    if(is_null($type)){
                        echo CalendarModel::fromBookingsToJson(BookingModel::getBookingsAfterDateTime(new DateTime()));
                    }
                    else{
                        echo CalendarModel::fromBookingsToJson(BookingModel::getBookingsAfterDateTimeDay(new DateTime()));
                    }
                } else {
                    echo CalendarModel::generateJsonError("Wrong API token", HttpCode::UNAUTHORIZED);
                }
            } else {
                echo CalendarModel::generateJsonError("Missing API token", HttpCode::BAD_REQUEST);
            }
        } else {
            echo CalendarModel::generateJsonError("Wrong request", HttpCode::BAD_REQUEST);
        }
    }
}