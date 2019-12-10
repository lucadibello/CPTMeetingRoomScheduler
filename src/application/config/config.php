<?php

/**
 * Configurazione di : Error reporting
 * Utile per vedere tutti i piccoli problemi in fase di sviluppo, in produzione solo quelli gravi
 */
error_reporting(E_ALL); // Gestione errori
ini_set("display_errors", 1);

/* Impostazioni generali */
define('URL', 'http://localhost:8080/'); // URL base del sito web
define('APP_NAME', "CPT Meeting Room Scheduler"); // Nome dell'applicazione
date_default_timezone_set('Europe/Zurich'); // Configura la timezone
$autoload_directories = array( // Directory dove viene eseguito un autoload (NON TOCCARE!)
    "application/libs/",
    "application/models/"
);

/* Configurazione per la connessione al database */
define('DATABASE_SERVER', 'localhost'); // Server MySQL (ip/hostname)
define('DATABASE_USERNAME', 'root'); // MySQL user
define('DATABASE_PASSWORD', ''); // MySQL user password
define('DATABASE_NAME', 'cptmrs'); // MySQL database name

/* Impostazioni applicazione*/
define('PSW_CRYPT_METHOD', PASSWORD_DEFAULT); // metodo con cui le password vengono cryptate
define('DEFAULT_USER_PERMISSION_GROUP', "user"); // permessi assegnati di default agli utenti LDAP
define('ADMIN_PANEL_USER_PERMISSION_GROUP', "admin"); // permessi necessari per accedere al pannello admin
define('ADMIN_PERMISSION_GROUP', "admin"); // permesso assegnato agli admin (usato per il controllo dell'eliminazione degli account amministratore)
define('MINIMUM_ADMINS_ALLOWED', 1); // numero minimo di admin che devono essere presenti nel sistema
define('PASSWORD_CHANGED_MESSAGE_COOKIE_ADD_LIFETIME', 60 * 60); // tempo di vita del cookie che conferma il cambio password
define('EMAIL_ALLOWED_DOMAIN', "edu.ti.ch"); // dominio delle email (usato nella validazione + scrittura utenti nel DB)
define('BOOKING_DATE_FORMAT', "Y-m-d"); // formato in cui le date delle prenotazioni vengono formattate (usato per il parsing dei dati)
define('BOOKING_TIME_FORMAT', "H:i:s"); // formato in cui gli orari delle prenotazioni vengono formattati (usato per il parsing dei dati)
define('BOOKING_HIDDEN_DAYS', array( // Giorni che vengono nascosti dal calendario
    DaysOfWeek::Sunday,
    DaysOfWeek::Saturday
));

define(
    "API_TOKEN", // Token utilizzato dai client per accedere alle API
    "058c24b04169e44528ff2be1ac83f5dd787aa2109ad64fdcf142538f4d8617b5832e532a7c4a004398c3a3b4f12d1eac47423680fd71c02105d33c77cae12d5d"
);

<<<<<<< HEAD
/*
* Impostazioni servizio di invio mail (PHPMailer)
*
*       (Di default utilizza un server SMTP)
*/
define('MAIL_SERVER_HOST', 'mail.infomaniak.com');
define('MAIL_SERVER_PORT', 587);
define('SMTP_AUTH', true);
define('SMTP_USERNAME', "luca.dibello@samtrevano.ch");
define('SMTP_PASSWORD', "Alberto58");
define('SMTP_SECURE_PROTOCOL', 'tsl');

/* Impostazioni generali Mailer */
define('CPTMRS_MAIL_ADDRESS', "noreply@cptmrs.cpt"); // indirizzo utilizzato come mittente delle email
=======
/* LDAP server and agent configuration */
define('LDAP_HOST', "10.20.4.2"); // Server AD utilizzato per le richieste con LDAP (login + fetch delle informazioni degli utenti)
define('LDAP_AGENT_USERNAME', "TODO"); // Username di servizio utilizzato per il fetch delle informazioni degli utenti
define('LDAP_AGENT_PASSWORD', "TODO"); // Password dell'utente di servizio utilizzato per il fetch delle informazioni degli utenti

/* LDAP authentication configuration */
define('LDAP_USER_DOMAIN', "@cpt.local"); // dominio di AD utilizzato nelle query tramite LDAP
//define('LDAP_USER_DN_GROUP', "OU=docenti,DC=CPT,DC=local"); // DN dove si trovano gli utenti dell'applicazioni
define('LDAP_USER_DN_GROUP', "DC=CPT,DC=local"); // DN dove si trovano gli utenti dell'applicazioni
//define('LDAP_AUTHORIZED_USER_GROUP',"docenti"); // gruppo a quale devono appartenere gli utenti ....
define('LDAP_AUTHORIZED_USER_GROUP',"allievi"); // gruppo a quale devono appartenere gli utenti ....
>>>>>>> 08f0ebd52b95f9b71c5a878069276052f2330c58

abstract class DaysOfWeek
{
    const Sunday = 0;
    const Monday = 1;
    const Tuesday = 2;
    const Wednesday = 3;
    const Thursday = 4;
    const Friday = 5;
    const Saturday = 6;
}