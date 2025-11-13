<?php
// Bootstrap central pour charger la config, DB et fonctions
define('SRC_ROOT', __DIR__);
require_once SRC_ROOT . '/bdd/config.php';
require_once SRC_ROOT . '/bdd/db.php';
// Les fichiers de traitement seront inclus page par page selon le besoin
