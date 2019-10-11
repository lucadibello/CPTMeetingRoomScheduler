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
define('URL', 'http://localhost:8123/');
define('APP_NAME', "CPT Meeting Room Scheduler");

/* Configurazione per la connessione al database */
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', 'root');
define('DATABASE_NAME', 'cptmrs');

/* APPLICATION SETTINGS */
define('PSW_CRYPT_METHOD', PASSWORD_DEFAULT);
define('DEFAULT_USER_PERMISSION_GROUP', "user");
define('ADMIN_PANEL_USER_PERMISSION_GROUP', "admin");
define('PASSWORD_CHANGED_MESSAGE_COOKIE_ADD_LIFETIME', 60*60);
define('EMAIL_ALLOWED_DOMAIN', "edu.ti.ch");

// Setup default timezone
date_default_timezone_set('Europe/Zurich');

define('CONFIRMATION_MAIL_DELAY', 10);

$autoload_directories = array(
    "application/libs/",
    "application/models/"
);