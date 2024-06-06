<?php

use classes\ModelCore;

session_start();

foreach(glob('./classes/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}
foreach(glob('./enum/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}


foreach(glob('./modeles/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}
foreach(glob('./controllers/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}

$controller = AdminControllerCore::getInstanceByName('index');
$controller->run();
