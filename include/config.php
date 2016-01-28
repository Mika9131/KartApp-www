<?php
// Damit alle Fehler angezeigt werden
error_reporting(E_ALL);

// Zum Aufbau der Verbindung zur Datenbank
define ( 'MYSQL_HOST',      'localhost' );

// Benutzername und Passwort für DB Zugriff
define ( 'MYSQL_BENUTZER',  '' );
define ( 'MYSQL_KENNWORT',  '');

// Datenbankname
define ( 'MYSQL_DATENBANK', '' );

// Konstanten
define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);

define('BOXCOUNT', 5);
?>
