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

    public static function sendMail($to, $to_fullname, $subject, $body, $is_html_body = true, $from = CPTMRS_MAIL_ADDRESS, $from_fullaname = CPTMRS_FULLNAME)
    {
        if ($is_html_body) {
            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        }

        // Additional headers
        $headers[] = "To: $to_fullname <$to>";
        $headers[] = "From: $from_fullaname <$from>";
        $headers[] = "X-Mailer: PHP/" . phpversion();

        return mail($to, $subject, $body, implode("\r\n", $headers));
    }
}