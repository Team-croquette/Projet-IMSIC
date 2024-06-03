<?php
class SecuIpModel extends ModelCore {

    public function ipUsed($ip): bool {
        $dbLink = $this->connectBd();

        //var_dump($ipRouter, $ipClient);

        $queryReponse = mysqli_prepare($dbLink, 'SELECT EXISTS(SELECT * FROM IP WHERE IP.IP=?)');
        mysqli_stmt_bind_param($queryReponse, "s", $ip);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        return $result["EXISTS(SELECT * FROM IP WHERE IP.IP=?)"];
    }

    public function nbrCoFromIp($ip) : int{
        $dbLink = $this->connectBd();

        $queryReponse = mysqli_prepare($dbLink, 'SELECT NBR_CO FROM IP WHERE IP.IP=?');
        mysqli_stmt_bind_param($queryReponse, "s", $ip);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        //var_dump($result['NBR_CO']);
        return $result['NBR_CO'];
    }

    public function addIp($ip) {
        $dbLink = $this->connectBd();

        if ($this->ipUsed($ip)){
            //si l'ip à déjà été rentré une fois on augmente son nbr de connection et on met a jour sa date
            $nbrCo = $this->nbrCoFromIp($ip) + 1;
            $now = date("Y-m-d H:i:s");
            $queryReponse = mysqli_prepare($dbLink, 'UPDATE IP SET NBR_CO=?, DATE_LAST_CO=? WHERE IP=?');
            mysqli_stmt_bind_param($queryReponse, "sss", $nbrCo, $now, $ip);
            mysqli_stmt_execute($queryReponse);
            mysqli_stmt_close($queryReponse);
        } else {
            //sinon on insert une ligne
            $nbrCo = 1;
            $queryReponse = mysqli_prepare($dbLink, 'INSERT Into IP(IP, NBR_CO) Values (?, ?);');
            mysqli_stmt_bind_param($queryReponse, "ss", $ip, $nbrCo);
            mysqli_stmt_execute($queryReponse);
            mysqli_stmt_close($queryReponse);
        }

    }

    public function addDesacIp(string $cible, array $tempoDesactivate) {
        //$tempoDesactivate sous forme [heures , minutes, secondes]

        $now = new DateTime();

        $limit = $now->add(new DateInterval('PT'.$tempoDesactivate[0].'H'.$tempoDesactivate[1].'M'.$tempoDesactivate[2].'S'));       
       
        $dbLink = $this->connectBd();

        $dateReactivate = date("Y-m-d H:i:s", $limit->getTimestamp());

        $queryReponse = mysqli_prepare($dbLink, 'INSERT Into DESAC_IP(CIBLE, DATE_REACTIVATE) Values (?, ?);');
        mysqli_stmt_bind_param($queryReponse, "ss", $cible, $dateReactivate);
        mysqli_stmt_execute($queryReponse);
        mysqli_stmt_close($queryReponse);
    }

    public function isIpDesac($ip) : bool {
        //return true si il existe une ligne dans la bdd ou la date de réactivation est supérieur à la date actuel pour l'ip ciblé ou pour "all"

        $dbLink = $this->connectBd();

        $now = date("Y-m-d H:i:s");
        $queryReponse = mysqli_prepare($dbLink, 'SELECT EXISTS( SELECT * FROM DESAC_IP WHERE (CIBLE=? AND DATE_REACTIVATE > ?) OR (CIBLE="all" AND DATE_REACTIVATE > ?)) ');
        mysqli_stmt_bind_param($queryReponse, "sss", $ip, $now, $now);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        // var_dump($result['EXISTS( SELECT * FROM DESAC_IP WHERE (CIBLE=? AND DATE_REACTIVATE > ?) OR (CIBLE="all" AND DATE_REACTIVATE > ?))']);
        // die; 
        return $result ['EXISTS( SELECT * FROM DESAC_IP WHERE (CIBLE=? AND DATE_REACTIVATE > ?) OR (CIBLE="all" AND DATE_REACTIVATE > ?))'];
    }
}