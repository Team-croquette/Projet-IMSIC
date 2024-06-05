<?php

session_start();

foreach(glob('../classes/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}

$controller = ControllerCore::getInstanceByName(basename(__DIR__));
$controller->run();