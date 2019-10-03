<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 01.10.2019
 * Time: 15:27
 */

class UserModel
{
    /* WRAPPER METHOD */
    public function userChangePassword($username, $new_password){
        return $this->usrCngPassword($username, $new_password);
    }

    private function usrCngPassword($user, $new_psw): bool {
        return DB::update("utente", array(
            "password"=>password_hash($new_psw, PSW_CRYPT_METHOD),
            "default_password_changed"=>true
        ), "username=%s", $user);

    }
}