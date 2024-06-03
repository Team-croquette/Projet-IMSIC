<?php

foreach(glob('../classes/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}

foreach(glob('../modeles/*.php') as $fileName){

    if (!str_contains($fileName,'index.php')) {
        require_once $fileName;
    }
}


if(isset($_SESSION['VerifIp'])) {
    if($_SESSION['VerifIp']) {
        if (isset($_SESSION['idClient'])) {
            if (!isset($_SESSION['currentQuestion'])) {
                $_SESSION['currentQuestion'] = 0;
            }
            $controller = ControllerCore::getInstanceByName(basename(__DIR__));
            $controller->run();
        }
    }
    header('Location: ../');
}
else
{
    $secuIpCont = ControllerCore::getInstanceByName('SecuIp');
    $secuIpMod = new SecuIpModel();
    if ($secuIpMod->isIpDesac($secuIpCont->getIp())) {
        $doQuest = true;
    } else {
        $doQuest = !$secuIpCont->run(); //resultat de SecuIpController->run() est true si l'ip est deja trop utilisé
    }

    if ($doQuest) {
        session_start();
        $_SESSION['VerifIp'] = true;

        $resultMod = new ResultatModel();
        $_SESSION['idClient'] = $resultMod->AddGetClient();

        $_SESSION['currentQuestion'] = 5;

        $controller = ControllerCore::getInstanceByName(basename(__DIR__));
        $controller->run();
    } else {
        header('Location: ../');
    }
}