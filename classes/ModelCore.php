<?php

class ModelCore
{

    public function connectBd()
    {
        $dbLink = mysqli_connect($_ENV["HOSTNAME"], $_ENV["USERNAME"], $_ENV["MDP"]) or die('Erreur de connexion au serveur : ' . mysqli_connect_error());
        mysqli_select_db($dbLink, $_ENV["DATABASE"]) or die('Erreur dans la sélection de la base : ' . mysqli_error($dbLink));
        return $dbLink;
    }
}