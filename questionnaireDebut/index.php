<?php

session_start();

if (isset($_SESSION["VerifCapcha"])){
    if (!$_SESSION["VerifCapcha"]){
        header("Location: ../index.php");
        die;
    }
}
else{
    header("Location: ../index.php");
    die;
}

foreach(glob('../classes/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}
foreach(glob(ADMIN_PATH.'/classes/*.php') as $fileName){

    if (!str_contains($fileName,'index.php') && !str_contains($fileName,'AdminController') && !str_contains($fileName,'ModelCore.php')) {
        require_once $fileName;
    }
}

foreach(glob(ADMIN_PATH.'/enum/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}

$controller = ControllerCore::getInstanceByName(basename(__DIR__));
$controller->run();