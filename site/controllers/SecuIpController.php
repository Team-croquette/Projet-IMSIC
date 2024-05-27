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
        //TODO: Deplacer les addIp dans le questionnaireController (ou après clique du liens) quand la page sera faite
        $ip = $this->getIp();
        //var_dump($coFromIp['case']);
        $secu = new \SecuIpModel();
        if ( ! $this->ipUsed($ip)) {
            $this->info = 'Début du questionnaire';
            $secu->addIp($ip);
            return false;
        } else {
            $coFromIp = $this->toManyCoFromIp($ip);

            if ($coFromIp['case'] < 2) {
                $secu->addIp($ip);
                $this->info = $coFromIp['info'];
                return false;
            } elseif ($coFromIp['case'] == 2) {
                $this->info = $coFromIp['info'];
                return true;
            } else {
                $secu = new \SecuIpModel();
                $secu->addIp($ip);
                $this->info = $coFromIp['info'];
                return false;
            }
        }
    }

    private function ipUsed($ip): bool
    {
        $secu = new \SecuIpModel();
        return $secu->ipUsed($ip);
    }

    private function toManyCoFromIp($ip) {
        $secu = new \SecuIpModel();
        $nbrCoFromIp = $secu->nbrCoFromIp($ip);
        if ($nbrCoFromIp<4) {
            $txtInfo = $nbrCoFromIp . ' appareil(s) a(ont) déjà éssayé de se connecté depuis votre réseaux. ' . 5 - $nbrCoFromIp . 'connexions restante(s).';
            return ["case"=> 0, "info" => $txtInfo ];
        } elseif ($nbrCoFromIp == 4) {
            $txtInfo =$nbrCoFromIp . ' appareils ont déjà éssayé de se connecté depuis votre réseaux.  Ceci sera votre dernière tentative.';
            return ["case"=> 1, "info" => $txtInfo];
        } else {
            return ["case"=> 2, "info" => 'Nous avons déjà recu le nombres de tentatives maximum pour ce questionnaire depuis votre réseaux.'];
        }
    }

    public function getIp()
    {
        //recupération des ips du client
        if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) ) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        } else if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "Was not able to get client ip";
        }
        return $ip;
    }
}