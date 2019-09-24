<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 19.09.2019
 * Time: 15:10
 */

class PasswordChangeModel
{
    public function generateUrl($username){
        $this->registerChangePasswordUrl($username);
    }

    private function sendConfirmMail(){
        //TODO: FINISH SEND MAIL METHOD USING PhpMailer
        echo "Work in progress";
    }

    private function registerChangePasswordUrl($username){
        // Get current datetime
        $current_timestamp = (new DateTime())->format("Y-m-d H:i:s");

        // Calculate expiration datetime
        $expiration_timestamp = (new DateTime())->add(new DateInterval('P1D'))->format("Y-m-d H:i:s");

        // Insert data into database
        DB::query("INSERT INTO email VALUES (0, '%s', '%s', '%s', '%s')",
            $this->generateRandomUrl(), $current_timestamp, $expiration_timestamp, $username);

        return true;
    }

    private function generateRandomUrl(){
        return "changepassword?id=".password_hash(rand(1,10), PASSWORD_DEFAULT);
    }
}