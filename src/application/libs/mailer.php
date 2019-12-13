<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 07.12.2019
 * Time: 17:14
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mailer;

    // TODO: CONTINUE MAILER

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // Setup mail server settings
        $this->mailer->SMTPDebug  = 2;                      // Enable verbose debug output
        $this->mailer->isSMTP();                            // Set mailer to use SMTP
        $this->mailer->Host = MAIL_SERVER_HOST;             // Specify main and backup SMTP servers

        if(SMTP_AUTH){
            // If the SMTP auth is enabled, setup user and password
            $this->mailer->SMTPAuth   = true;               // Enable SMTP authentication
            $this->mailer->Username   = SMTP_USERNAME;      // SMTP username
            $this->mailer->Password   = SMTP_PASSWORD;      // SMTP password
        }

        $this->mailer->SMTPSecure = SMTP_SECURE_PROTOCOL;   // Enable TLS encryption, `ssl` also accepted
        $this->mailer->Port       = MAIL_SERVER_PORT;       // TCP port to connect to
    }

    public function sendMail($to, $to_fullname, $subject, $body, $from=CPTMRS_MAIL_ADDRESS, $from_fullaname='') {
        // !! Any exception handler !!
        $this->mailer->setFrom($from, $from_fullaname); // Setup who's the sender of the mail
        $this->mailer->addAddress($to, $to_fullname); // Setup mail reciever
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $body;
        $this->mailer->send();
    }
}