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
        $ipRouter = $this->getIp()[1];
        $ipClient = $this->getIp()[0];
        $resultIpFromRouter = $this->toManyIpFromRouter($ipRouter);
        var_dump($resultIpFromRouter['case']);
        if ($this->ipUsed($ipRouter, $ipClient)) {
            $this->info = 'Ip déjà utilisée';
            return true;
        } elseif ($resultIpFromRouter['case'] < 2) {
            $secu = new \SecuIpModel();
            $secu->addIp($ipRouter, $ipClient);
            $this->info = $resultIpFromRouter['info'];
            return false;
        } elseif ($resultIpFromRouter['case']==2) {
            $this->info = $resultIpFromRouter['info'];
            return true;
        } else {
            $secu = new \SecuIpModel();
            $secu->addIp($ipRouter, $ipClient);
            $this->info = $resultIpFromRouter['info'];
            return false;
        }
        die;
    }

    private function ipUsed($ipRouter, $ipClient): bool
    {
        $secu = new \SecuIpModel();
        return $secu->ipUsed($ipRouter, $ipClient);
    }

    private function toManyIpFromRouter($ipRouter) {
        $secu = new \SecuIpModel();
        $ipInRouter = $secu->countIpInServ($ipRouter);
        if ($ipInRouter<5) {
            return ["case"=> 0, "info" => $ipInRouter . " appareil(s) a(ont) déjà éssayé de se connecté depuis votre réseaux. \n" . 5 - $ipInRouter . 'connexions restante(s).'];
        } elseif ($ipInRouter == 5) {
            return ["case"=> 1, "info" => $ipInRouter . " appareils ont déjà éssayé de se connecté depuis votre réseaux. \n Ceci sera votre dernière tentative."];
        } else {
            return ["case"=> 2, "info" => 'Nous avons déjà recu le nombres de tentatives maximum pour ce questionnaire depuis votre réseaux.'];
        }
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