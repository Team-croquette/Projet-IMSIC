<?php

class SecuIpModel extends ModelCore {

    public function ipUsed($ip): bool {
        $dbLink = $this->connectBd();

        $queryReponse = mysqli_prepare($dbLink, 'SELECT IP FROM IP WHERE IP.IP == (?);');
        mysqli_stmt_bind_param($queryReponse, "s", $ip);
        $result = mysqli_stmt_execute($queryReponse);
        mysqli_stmt_close($queryReponse);

        echo ($result);
        return $result;
    }

}