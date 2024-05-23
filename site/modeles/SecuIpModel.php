<?php
class SecuIpModel extends ModelCore {



    public function ipUsed($ipRouter, $ipClient): bool {
        $dbLink = $this->connectBd();

        $queryReponse = mysqli_prepare($dbLink, 'SELECT EXISTS(SELECT IP FROM IP WHERE IP.IP=?)');
        mysqli_stmt_bind_param($queryReponse, "s", $ipClient);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        //var_dump($result["EXISTS(SELECT IP FROM IP WHERE IP.IP=?)"]);
        return $result["EXISTS(SELECT IP FROM IP WHERE IP.IP=?)"];
    }

    public function countIpInServ(){return 1;}

    public function addIp($ip) {
        $dbLink = $this->connectBd();

        $queryReponse = mysqli_prepare($dbLink, 'INSERT Into IP(IP) Values (?);');
        mysqli_stmt_bind_param($queryReponse, "s", $ip);
        mysqli_stmt_execute($queryReponse);
        mysqli_stmt_close($queryReponse);
    }
}