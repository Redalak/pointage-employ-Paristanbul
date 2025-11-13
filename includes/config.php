<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Paris');

define('DB_HOST', 'localhost');
define('DB_NAME', 'logistique_agenda');
define('DB_USER', 'root');
// MAMP default is 'root', WAMP often empty. Adjust per machine.
define('DB_PASS', 'root');

define('APP_BASE_URL', '/pointage employée paristanbul/public');

define('ADMIN_PASSWORD', 'admin123');
