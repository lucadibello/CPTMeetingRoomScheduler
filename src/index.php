<?php

// Carico la classe di config
require __DIR__ . '/application/config/config.php';

// Autoload delle liberie di composer
require_once __DIR__ . '/vendor/autoload.php';

foreach($autoload_directories as $directory) {
    $files = glob($directory.'*.php');
    foreach($files as $file) {
        $path = __DIR__.'/'.$file;
        require_once $path;
    }
}

session_start();

// faccio partire il notifier
$GLOBALS["NOTIFIER"] = new Notifier();

// setup database variables
DB::$host = DATABASE_SERVER;
DB::$user = DATABASE_USERNAME;
DB::$password = DATABASE_PASSWORD;
DB::$dbName = DATABASE_NAME;

// faccio partire l'applicazione
$app = new Application();