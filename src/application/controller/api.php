<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 04.10.2019
 * Time: 15:03
 */

class Api
{
    // api/user/delete/<index>
    // api/user/add
    // api/user/update/<index>
    public function user($action, $username=null){
        if(Auth::isAuthenticated()){
            $GLOBALS["NOTIFIER"]->clear();
            if($action=="delete" && !is_null($username)){
                if(!UserModel::delete($username)){
                    $GLOBALS["NOTIFIER"]->add("Non sono riuscito ad eliminare l'utente.");
                }
            }
            elseif($action == "add" && $_SERVER["REQUEST_METHOD"] == "POST"){
                // Sanitize POST data and add record to database
                $result = UserModel::add(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
                // If it detects errors
                if(is_array($result)){
                    $GLOBALS["NOTIFIER"]->add_all($result);
                }
            }
            elseif($action == "update" && !is_null($username) && $_SERVER["REQUEST_METHOD"] == "POST"){
                // Sanitize POST data and add record to database
                $result = CategoriesModel::update(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING),
                    $username);

                // If it detects errors
                if(is_array($result)){
                    $GLOBALS["NOTIFIER"]->add_all($result);
                }
            }
            RedirectManager::redirect("admin/utenti");
        }
        else{
            RedirectManager::redirect("admin");
        }
    }
}