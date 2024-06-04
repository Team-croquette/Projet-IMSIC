<?php

class ResultatModel extends ModelCore {

    public function AddGetClient() {
            $dbLink = $this->connectBd();

            $queryReponse = mysqli_prepare($dbLink, 'INSERT INTO CLIENT VALUES ();');
            mysqli_stmt_execute($queryReponse);
            mysqli_stmt_close($queryReponse);

            //var_dump($dbLink->insert_id);
            return $dbLink->insert_id;
    }

    public function AddReponse($idQuest, $idClient, $idRep = Null, $Rep = Null) {
        $dbLink = $this->connectBd();

        if ($idRep != Null and $Rep != Null) {
            throw new \http\Exception\InvalidArgumentException("Mettre un seul argument (idRep ou Rep)");
        } elseif ($idRep != Null) {
            $queryReponse = mysqli_prepare($dbLink, 'INSERT Into RESULTAT(ID_QUESTION, ID_CLIENT, ID_REPONSE) Values (?, ?, ?);');
            mysqli_stmt_bind_param($queryReponse, "sss", $idQuest, $idClient, $idRep);
        } elseif ($Rep != Null) {
            $queryReponse = mysqli_prepare($dbLink, 'INSERT Into RESULTAT(ID_QUESTION, ID_CLIENT, REPONSE) Values (?, ?, ?);');
            mysqli_stmt_bind_param($queryReponse, "sss", $idQuest, $idClient, $Rep);
        } else {
            throw new \http\Exception\InvalidArgumentException("Argument idRep ou Rep manquant");
        }

        mysqli_stmt_execute($queryReponse);
        mysqli_stmt_close($queryReponse);
    }

}