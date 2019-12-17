<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 19.09.2019
 * Time: 15:10
 */

class PasswordChangeModel
{
    public static function sendConfirmationMail($username, $password)
    {
        // Search user infos in the database
        $user = UserModel::getUser($username);

        // Check if user infos have been found
        if ($user != false) {
            // Email content
            $body = "<!doctype html>
                <html lang='en'>
                <head>
                    <style>
                        body{
                            font-family: arial, sans-serif;
                        }
                
                        table {
                            border-collapse: collapse;
                            width: 100%;
                        }
                
                        .header{
                            background-color: #dddddd;
                        }
                
                        td, th {
                            border: 1px solid #dddddd;
                            text-align: left;
                            padding: 8px;
                        }
                    </style>
                </head>
                <body>
                    <h1>CPT Meeting Room Scheduler - Creazione account</h1>
                    <p>Il tuo account è stato creato correttamente all'interno del sistema. Queste sono le credenziali di accesso per il tuo account:</p>
                
                    <table>
                        <tr>
                            <td class='header'>Nome utente</td>
                            <td>$username</td>
                        </tr>
                        <tr>
                            <td class='header'>Password</td>
                            <td>$password</td>
                        </tr>
                    </table>
                    <br>
                 
                    <p>Clicca <a href='".URL."login'>qui</a> per accedere alla pagina di login. Al primo accesso l'utente verrà obbligato a cambiare la password di accesso per motivi di sicurezza.</p>
                    <br>
                    <p style='color:red;font-weight: bold'>Questa email è stata inviata automaticamente dal sistema.</p>
                
                    <img src='".URL."assets/img/cpt_logo.jpg' alt='CPT Trevano Logo'>
                </body>
                </html>";

            // TODO: Uncomment this sendMail statement
            /*
            $result = Mailer::sendMail(
                $user->getEmailAddress(),
                $user->getNome() . " " . $user->getCognome(),
                "Credenziali CPT MRS",
                $body
            );
            */
            $result = Mailer::sendMail(
                "luca6469@gmail.com",
                $user->getNome() . " " . $user->getCognome(),
                "Credenziali CPT MRS",
                $body
            );

            // Return true if the email was send correctly, otherwise false
            return $result;
        } else {
            // Can't find user infos in the database
            $GLOBALS["NOTIFIER"]->add("Errore durante la lettura delle informazioni dell'utente. Invio mail non riuscito.");
        }
    }
}