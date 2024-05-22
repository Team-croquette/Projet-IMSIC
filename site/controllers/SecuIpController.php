<?php


require_once SITE_PATH . "modeles/SecuIpModel.php";
$secu = new \SecuIpModel();

class SecuIpController extends ControllerCore
{
    protected string $name;

    public function run() : bool
    {
        if ($this->ipUsed()) {
            echo '<script type="text/javascript">window.alert("Ip déjà utilisée");</script>';

            return true;
            //header('Location: ' . SITE_PATH . 'index.php'); //renvoie vers l'acceuil
        }
        else {
            $secu = new \SecuIpModel();
            $secu->addIp($_SERVER['REMOTE_ADDR']);

            //header('Location: ../'); // renvoie vers le questionnaire
            return false;
        }
    }

    private function ipUsed(): bool
    {
        $secu = new \SecuIpModel();
        return $secu->ipUsed($_SERVER['REMOTE_ADDR']);
        var_dump("client : " . $_SERVER['REMOTE_ADDR']);
    }
}