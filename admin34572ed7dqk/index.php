<?php 

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

require_once './modeles/ModelCore.php';
foreach(glob('./modeles/*.php') as $fileName){

    if (!str_contains($fileName,'index.php') && !str_contains($fileName,'ModelCore.php')) {
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
