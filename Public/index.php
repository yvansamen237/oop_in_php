<?php

use App\Core\Main;
use App\Autoloader;

define('ROOT', dirname(__DIR__));

// on importe l'autoloader
require_once ROOT.'/Autoloader.php';
Autoloader::register(); 

// on instancie notre routeur (Main)
$app = new Main();

// on demarre le routeur
$app->start();