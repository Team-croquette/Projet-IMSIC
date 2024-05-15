<?php

namespace controllers;
use AdminControllerCore;
require_once "../modeles/SecuIpModel.php";

class SecuIpController extends AdminControllerCore
{
    protected string $name;

    public function run(): bool
    {
        if ($this->ipUsed()) {
            //pop up en mode questionnaire deja fait
            header('Location: ../../index.php'); //renvoie vers l'acceuil
        }
        else {
            // enregistre l'ip dans la bdd
            header('Location: ../'); // renvoie vers le questionnaire
        }
        die;
        return true;
    }

    private function ipUsed(): bool
    {
        $secu = new \SecuIpModel();
        return $secu->ipUsed($_SERVER['REMOTE_ADDR']);
    }
}