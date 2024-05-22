<?php 

foreach(glob('./classes/*.php') as $fileName){
    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}

foreach(glob('./modeles/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}

$controller = ControllerCore::getInstanceByName('index');
$controller->run();
