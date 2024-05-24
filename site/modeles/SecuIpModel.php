<?php
class SecuIpModel extends ModelCore {

    public function ipUsed($ipRouter, $ipClient): bool {
        $dbLink = $this->connectBd();

        //var_dump($ipRouter, $ipClient);

        $queryReponse = mysqli_prepare($dbLink, 'SELECT EXISTS(SELECT * FROM IP WHERE IP.IP=? AND IP.IP_CLIENT=?)');
        mysqli_stmt_bind_param($queryReponse, "ss", $ipRouter, $ipClient);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        return $result["EXISTS(SELECT * FROM IP WHERE IP.IP=? AND IP.IP_CLIENT=?)"];
    }

    public function countIpInServ($ipRouter) : int{
        $dbLink = $this->connectBd();
        //var_dump( $ipRouter);

        $queryReponse = mysqli_prepare($dbLink, 'SELECT COUNT(IP.IP_CLIENT) FROM IP WHERE IP.IP=?');
        mysqli_stmt_bind_param($queryReponse, "s", $ipRouter);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        //var_dump($result ['COUNT(IP.IP_CLIENT)']);
        return $result ['COUNT(IP.IP_CLIENT)'];
    }

    public function addIp($ipRouter, $ipClient) {
        $dbLink = $this->connectBd();

        $queryReponse = mysqli_prepare($dbLink, 'INSERT Into IP(IP, IP_CLIENT) Values (?, ?);');
        mysqli_stmt_bind_param($queryReponse, "ss", $ipRouter, $ipClient);
        mysqli_stmt_execute($queryReponse);
        mysqli_stmt_close($queryReponse);
    }
}