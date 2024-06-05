<?php
session_start();
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

$resultMod = new ResultatModel();
$questMod = new QuestionnaireModel();
//dump($_SESSION);
//var_dump($_POST);
if (isset($_SESSION["conditions-generales"]) AND isset($_SESSION["VerifCapcha"])){
    if ($_SESSION["conditions-generales"] AND $_SESSION["VerifCapcha"]){
        if(isset($_SESSION['VerifIp'])) {
            if($_SESSION['VerifIp']) {
                if (isset($_SESSION['idClient'])) {
                    if (!isset($_SESSION['currentQuestion'])) {
                        $_SESSION['currentQuestion'] = 0;
                    }

                    $listIdQuest = $questMod->getAllQuestionsID();
                    $idQuest = $listIdQuest[$_SESSION['currentQuestion']];
                    if (isset($_POST['sliderValue']))
                    {
                        $resultMod->AddReponse($idQuest, $_SESSION['idClient'], Null, $_POST['sliderValue']);
                        $_SESSION['currentQuestion']++;

                    }
                    elseif (isset($_POST['champRep']))
                    {
                        $resultMod->AddReponse($idQuest, $_SESSION['idClient'], Null, $_POST['champRep']);
                        $_SESSION['currentQuestion']++;
                        //var_dump($_SESSION);
                    }
                    elseif (isset($_POST['selectedOptions']))
                    {
                        $repsID = '';
                        foreach ($_POST['selectedOptions'] as $key => $value){
                            $repsID .= $key . ',';
                        }
                        $resultMod->AddReponse($idQuest, $_SESSION['idClient'], Null, $repsID);
                        $_SESSION['currentQuestion']++;
                    }

                    if ($_SESSION['currentQuestion'] >= sizeof($listIdQuest)){
                        session_destroy();
                        header('Location: ../questionnaireFin/index.php');
                    }

                    $controller = ControllerCore::getInstanceByName(basename(__DIR__));
                    $controller->run();
                }
            }
            else {
                header('Location: ../');
            }
        }
        else
        {
            //var_dump('init');
            $secuIpCont = ControllerCore::getInstanceByName('SecuIp');
            $secuIpMod = new SecuIpModel();
            if ($secuIpMod->isIpDesac($secuIpCont->getIp())) {
                $doQuest = true;
            } else {
                $doQuest = !$secuIpCont->run(); //resultat de SecuIpController->run() est true si l'ip est deja trop utilisé
            }

            if ($doQuest) {
                $_SESSION['VerifIp'] = true;

                $resultMod = new ResultatModel();
                $_SESSION['idClient'] = $resultMod->AddGetClient();

                $_SESSION['currentQuestion'] = 0;
                //var_dump($_SESSION);
                $controller = ControllerCore::getInstanceByName(basename(__DIR__));
                $controller->run();
            } else {
                header('Location: ../');
            }
        }
    }
    else{
        header("Location: ../index.php");
    }
}
else{
    header("Location: ../index.php");
}

