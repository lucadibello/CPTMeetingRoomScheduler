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
     * @param $action string Desired API action. Here is the list of the available actions: delete, add, update, promote.
     * @param null $username User's username. It have to be set if using these actions: delete, update, promote.
     */
    public function user($action, $username=null){
        if(Auth::isAuthenticated()){
            $GLOBALS["NOTIFIER"]->clear();
            /*
             * Action url: api/user/delete/<username>
             * Permission needed: eliminazione_utenti
             * Extra data: none
             */
            if($action=="delete" && !is_null($username)){
                if(PermissionManager::getPermissions()->canEliminareUtenti()){
                    if(!UserModel::delete($username)){
                        $GLOBALS["NOTIFIER"]->add("Non sono riuscito ad eliminare l'utente.");
                    }
                }
                else{
                    $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per eliminare gli utenti");
                }

                RedirectManager::redirect("admin/utenti");
            }
            /*
             * Action url: api/user/add
             * Permission needed: creazione_utenti
             * Extra data: POST data
             */
            elseif($action == "add" && $_SERVER["REQUEST_METHOD"] == "POST"){
                if(PermissionManager::getPermissions()->canCreareUtenti()){
                    // Sanitize POST data and add record to database
                    $result = UserModel::add(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
                    // If it detects errors
                    if(is_array($result)){
                        $GLOBALS["NOTIFIER"]->add_all($result);
                    }
                }
                else{
                    $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per la creazione degli utenti");
                }

                RedirectManager::redirect("admin/utenti");
            }
            /*
             * Action url: api/user/update/<username>
             * Permission needed: modifica_utenti
             * Extra data: POST data
             */
            elseif($action == "update" && !is_null($username) && $_SERVER["REQUEST_METHOD"] == "POST"){
                // TODO: ADD PERMISSIONS CHECK
                // Sanitize POST data and add record to database
                if(PermissionManager::getPermissions()->canModificareUtenti()){
                    $result = UserModel::update(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING),
                        $username);

                    // If it detects errors
                    if(is_array($result)){
                        $GLOBALS["NOTIFIER"]->add_all($result);
                    }

                    RedirectManager::redirect("admin/utenti");
                }
                else{
                    $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per la modifica degli utenti");
                }

                RedirectManager::redirect("admin/utenti");
            }

            /*
             * Action url: api/user/promote/<username>
             * Permission needed: promozione_utenti
             * Extra data: POST data
             */
            elseif($action == "promote" && !is_null($username) && $_SERVER["REQUEST_METHOD"] == "POST"){
                if(PermissionManager::getPermissions()->canPromozioneUtenti()){
                    // Sanitize POST data and promote user
                    $result = UserModel::promote(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING), $username);

                    // If it detects errors
                    if(is_array($result)){
                        $GLOBALS["NOTIFIER"]->add_all($result);
                    }
                }
                else{
                    $GLOBALS["NOTIFIER"]->add("Non hai i permessi necessari per la promozione degli utenti");
                }

                RedirectManager::redirect("admin/utenti");
            }

            // Unknown API request
            RedirectManager::redirect("admin");
        }
        else{
            // Not logged: show login page
            RedirectManager::redirect("admin");
        }
    }
}