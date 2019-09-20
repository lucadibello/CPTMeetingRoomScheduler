<?php

// carico il file di configurazione
require 'application/config/config.php';

// carico le classi dell'applicazione
require 'application/libs/application.php';

// carico la classe che permette di caricare le view
require 'application/libs/viewloader.php';

// carico la classe che permette di mostrare le notifiche a schermo
require 'application/libs/notifier.php';

// carico le liberie di composer
require 'vendor/autoload.php';

// carico la classe che permette l'autenticazione semplificata di un utente
require 'application/libs/auth.php';

// carico la classe che permette il login tramite l'active directory di scuola
require 'application/libs/ldapauth.php';

// carico la classe che permette la gestione dei permessi all'interno dell'applicazione
require 'application/libs/permissionmanager.php';

// faccio partire il notifier
$GLOBALS["NOTIFIER"] = new Notifier();

// setup database variables
DB::$user = DATABASE_USERNAME;
DB::$password = DATABASE_PASSWORD;
DB::$dbName = DATABASE_NAME;

// faccio partire l'applicazione
$app = new Application();