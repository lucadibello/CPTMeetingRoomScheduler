<?php

/**
 * Configurazione
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configurazione di : Error reporting
 * Utile per vedere tutti i piccoli problemi in fase di sviluppo, in produzione solo quelli gravi
 *
 * TODO: Nascondere errori quando in produzione!
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configurazione di : URL del progetto
 */
define('URL', 'http://localhost:8080/');
define('APP_NAME', "CPT Meeting Room Scheduler");

/* Configurazione per la connessione al database */
define('DATABASE_SERVER', 'localhost');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', 'root');
define('DATABASE_NAME', 'cptmrs');

/* APPLICATION SETTINGS */
define('PSW_CRYPT_METHOD', PASSWORD_DEFAULT);
define('DEFAULT_USER_PERMISSION_GROUP', "user");
define('ADMIN_PANEL_USER_PERMISSION_GROUPS', array("admin"));
define('ADMIN_PERMISSION_GROUP', "admin");
define('MINIMUM_ADMINS_ALLOWED', 1);
define('PASSWORD_CHANGED_MESSAGE_COOKIE_ADD_LIFETIME', 60 * 60);
define('EMAIL_ALLOWED_DOMAIN', "edu.ti.ch");
define('BOOKING_DATE_FORMAT', "Y-m-d");
define('BOOKING_TIME_FORMAT', "H:i:s");

/* CALENDAR OPTIONS */
define("CALENDAR_DATETIME_FORMAT", "d-m-Y H:i");
define('CALENDAR_BUSINESS_DAYS', array(
    DaysOfWeek::Monday,
    DaysOfWeek::Tuesday,
    DaysOfWeek::Wednesday,
    DaysOfWeek::Thursday,
    DaysOfWeek::Friday
));

define('CALENDAR_BUSINESS_TIME_START', "07:00");
define('CALENDAR_BUSINESS_TIME_END', "21:00");

/* BOOKING ALLOWED DAYS */
define('BOOKING_HIDDEN_DAYS', array(
    DaysOfWeek::Sunday,
    DaysOfWeek::Saturday
));

// Setup default timezone
date_default_timezone_set('Europe/Zurich');

/* API TOKEN AUTHENTICATION */
define("API_TOKEN", "058c24b04169e44528ff2be1ac83f5dd787aa2109ad64fdcf142538f4d8617b5832e532a7c4a004398c3a3b4f12d1eac47423680fd71c02105d33c77cae12d5d");

$autoload_directories = array(
    "application/libs/",
    "application/models/"
);

/* LDAP server and agent configuration */
define('LDAP_HOST', "10.20.4.2"); // Server AD utilizzato per le richieste con LDAP (login + fetch delle informazioni degli utenti)

/* LDAP authentication configuration */
define('LDAP_USER_DOMAIN', "@cpt.local"); // dominio di AD utilizzato nelle query tramite LDAP
//define('LDAP_USER_DN_GROUP', "OU=docenti,DC=CPT,DC=local"); // DN dove si trovano gli utenti dell'applicazioni
define('LDAP_USER_DN_GROUP', "DC=CPT,DC=local"); // DN dove si trovano gli utenti dell'applicazioni
//define('LDAP_AUTHORIZED_USER_GROUP',"docenti"); // gruppo a quale devono appartenere gli utenti ....
define('LDAP_AUTHORIZED_USER_GROUP',"allievi"); // gruppo a quale devono appartenere gli utenti ....

/* Mailer settings */
define("CPTMRS_MAIL_ADDRESS", "noreply@riservazioni-cpt.ch");
define("CPTMRS_FULLNAME", "Riservazioni Saletta");

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
