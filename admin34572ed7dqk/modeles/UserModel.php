<?php

class UserModel extends ModelCore{

    public function userExist(string $login, string $inputPassword):bool
    {
        $dbLink = $this->connectBd();
        $query = $dbLink->prepare('SELECT count(*) FROM COMPTES WHERE `identifiant`= ?');
        $query->execute([$login]);
        $query->bind_param('s',$login);
        $query->execute();
        $query->bind_result($compte);
        $query->fetch();
        if ( $compte >= 1 ) {
            $dbLink->close();
            $dbLink= $this->connectBd();
            $password = $dbLink->prepare('SELECT mdp FROM COMPTES WHERE `identifiant`= ?');
            $password->bind_param('s',$login);
            $password->execute();
            $password->bind_result($passwordHash);
            $password->fetch();
            if (password_verify($inputPassword, $passwordHash)) {
                return true;
            }
        }
        return false;
    }
}