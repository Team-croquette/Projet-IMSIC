<?php


require_once SITE_PATH . "modeles/SecuIpModel.php";


class SecuIpController extends ControllerCore
{
    protected string $name;

    protected $info; //état du lien vers le questionnaire (class = "disabled|enabled")


    public function getInfo()
    {
        return $this->info;
    }

    public function run() : bool
    {
        if ($this->ipUsed()) {
            $this->info = '<script type="text/javascript">window.alert("Ip déjà utilisée");</script>';
            return true;
        }
        else {
            $secu = new \SecuIpModel();
            $secu->addIp($this->getIp()[0]);
            $this->info = $secu->countIpInServ() . ' appareil(s) a(ont) déjà éssayé de se connecté depuis votre réseaux. \n' . 5-$secu->countIpInServ() . 'connexions restante(s).';
            return false;
        }
    }

    private function ipUsed(): bool
    {
        $secu = new \SecuIpModel();
        $ipRouter = $this->getIp()[1];
        $ipClient = $this->getIp()[0];
        return $secu->ipUsed($ipRouter, $ipClient);
        //var_dump("client : " . $this->getIp()[1]);
    }

    private function getIp()
    {
        $ips = [];

        //recupération des ips du client
        if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) ) {
            $ips[0] = $_SERVER['HTTP_X_REAL_IP'];
        } else if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ips[0] = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ips[0] = "Was not able to get client ip";
        }

        //récuperation des ips (potentielement du routeur ou parfois de l'hebergeur du site selon les cas)
        if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ips[1] = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            $ips[1] = $_SERVER['REMOTE_ADDR'];
        } else {
            $ips[1] = "Was not able to get router ip";
        }

        return $ips;
    }
}