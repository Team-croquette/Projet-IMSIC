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

if (!isset($_SESSION['token']) && $_SESSION['token'] == (new LoginAdminController())->getToken($_SESSION['login'])) {
    header('Location: ./login/index.php');
    die;
}

$controller = AdminControllerCore::getInstanceByName('index');
$controller->run();
