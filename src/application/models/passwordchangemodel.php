<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 19.09.2019
 * Time: 15:10
 */

class PasswordChangeModel
{
    /* WRAPPER METHOD */
    public function generateUrl($username){
        return $this->registerChangePasswordUrl($username);
    }

    /* WRAPPER METHOD */
    public function isIdRight($id, $username){
        return $this->idExists($id, $username);
    }

    /* WRAPPER METHOD */
    public function sendConfirmMail(){
        //TODO: FINISH SEND MAIL METHOD USING PhpMailer
        echo "Work in progress";
    }

    /* WRAPPER METHOD */
    public function changeUserDefaultPassword($username, $new_password){
        return $this->usrChangeDefPsw();
    }
    

    private function registerChangePasswordUrl($username){
        // Get current datetime
        $current_timestamp = (new DateTime())->format("Y-m-d H:i:s");

        // Calculate expiration datetime
        $expiration_timestamp = (new DateTime())->add(new DateInterval('P1D'))->format("Y-m-d H:i:s");

        // Random ID
        $randomId = $this->generateRandomId();

        // Insert data into database
        $a = DB::query("INSERT INTO email VALUES (0, %s, %s, %s, %s, NULL)",
            $randomId, $current_timestamp, $expiration_timestamp, $username);

        if($a){
            return "changepassword/id/".$randomId;
        }
        else{
            return false;
        }
    }

    private function isEmailFlood(){
        // TODO: DETECTS IF A USER IS FLOODING EMAILS (continua a richiedere mail)
        DB::query();
    }

    private function idExists($id, $username): bool {
        DB::query("SELECT * FROM email WHERE url_conferma=%s AND utente=%s", $id, $username);
        return DB::count() != 0;
    }

    private function generateRandomId(){
        return password_hash(rand(1,10), PASSWORD_DEFAULT);
    }
}