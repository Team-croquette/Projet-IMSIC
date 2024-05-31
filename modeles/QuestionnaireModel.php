<?php

class QuestionnaireModel extends ModelCore {

    public function getAllQuestionsID(){
        $dbLink = $this->connectBd();

        $queryReponse = mysqli_prepare($dbLink, 'SELECT ID FROM QUESTION ORDER BY ID');
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result();

        $ids = [];
        foreach ($result as $row) {
            $ids[] = $row['ID'];
        }
        mysqli_stmt_close($queryReponse);

        var_dump($ids);
        return $ids;
    }

    public function getQuestion($idQuestion){
        //retourne un dico dont chaque champ peut être null
        //['libelle' => ..., 'img' => ..., 'imgDesc' => ..., 'imgSecond' => ..., 'imgSecondDesc' => ...]
        $dbLink = $this->connectBd();

        $queryReponse = mysqli_prepare($dbLink, 'SELECT * FROM QUESTION WHERE ID=?');
        mysqli_stmt_bind_param($queryReponse, "s", $idQuestion);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        var_dump($result['*']);
        return $result['*'];
    }

    public function getRepFromQuest($idQuestion) {
        //retourne dico [ 'case' => (resultat de getRepStyle) , ... ]
        $dbLink = $this->connectBd();

        $repStyle = $this->getRepStyle($idQuestion);

        if ($repStyle == 0){
            $queryReponse = mysqli_prepare($dbLink, 'SELECT SLIDER FROM QUESTION WHERE ID = ?');
            mysqli_stmt_bind_param($queryReponse, "s", $idQuestion);
            mysqli_stmt_execute($queryReponse);
            $maxSlider = $queryReponse->get_result()->fetch_assoc();
            mysqli_stmt_close($queryReponse);

            var_dump($maxSlider);
            return [ 'case' => 0, 'maxSlider' => $maxSlider['SLIDER']];

        }
        elseif ($repStyle == 1){
            return [ 'case' => 1];

        }
        elseif ($repStyle == 2){
            $queryReponse = mysqli_prepare($dbLink, 'SELECT CONTENU FROM REPONSE WHERE ID_QUESTION = ?');
            mysqli_stmt_bind_param($queryReponse, "s", $idQuestion);
            mysqli_stmt_execute($queryReponse);
            $contenuReps = $queryReponse->get_result()->fetch_assoc();
            mysqli_stmt_close($queryReponse);

            var_dump($contenuReps);
            return [ 'case' => 2, 'contenuRep' => $contenuReps['CONTENU']];

        }
        elseif ($repStyle == 3){
            $queryReponse = mysqli_prepare($dbLink, 'SELECT IMG, IMG_LABEL FROM REPONSE WHERE ID_QUESTION = ?');
            mysqli_stmt_bind_param($queryReponse, "s", $idQuestion);
            mysqli_stmt_execute($queryReponse);
            $contenuReps = $queryReponse->get_result()->fetch_assoc();
            mysqli_stmt_close($queryReponse);

            var_dump($contenuReps);
            return [ 'case' => 3, 'img' => $contenuReps['IMG'], 'imgLabel' => $contenuReps['IMG_LABEL']];
        }

        throw new Exception("Couldn't get response in database");
    }

    private function getRepStyle($idQuestion) : int{
        // 0 : Slider  , 1 : champs libre , 2 : choix multiple text, 3 : choix multiple img
        $dbLink = $this->connectBd();

        //On test si la reponse est de type slider
        $queryReponse = mysqli_prepare($dbLink, 'SELECT CASE WHEN SLIDER IS NOT NULL THEN "True" ELSE "False" END bool_val FROM QUESTION WHERE ID = ?)');
        mysqli_stmt_bind_param($queryReponse, "s", $idQuestion);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        var_dump($result);
        if ($result) {
            return 0;
        }

        //si pas slider et pas de réponse associé = champs libre
        $queryReponse = mysqli_prepare($dbLink, 'SELECT EXISTS(SELECT * FROM REPONSE WHERE ID_QUESTION = ?)');
        mysqli_stmt_bind_param($queryReponse, "s", $idQuestion);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        if (! $result["EXISTS(SELECT * FROM REPONSE WHERE ID_QUESTION = ?)"]) {
            return 1;
        }

        //si colonne contenue d'une des réponses n'est pas null = choix multiple text
        $queryReponse = mysqli_prepare($dbLink, 'SELECT CASE WHEN CONTENU IS NOT NULL THEN "True" ELSE "False" END bool_val FROM REPONSE WHERE ID_QUESTION = ?)');
        mysqli_stmt_bind_param($queryReponse, "s", $idQuestion);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        var_dump($result);
        if ($result[0]) {
            return 2;
        }

        //sinon on verifie quand même qu'il y a une des images = choix multiple img
        $queryReponse = mysqli_prepare($dbLink, 'SELECT CASE WHEN (IMG IS NOT NULL AND IMG_LABEL IS NOT NULL) THEN "True" ELSE "False" END bool_val FROM REPONSE WHERE ID_QUESTION = ?)');
        mysqli_stmt_bind_param($queryReponse, "s", $idQuestion);
        mysqli_stmt_execute($queryReponse);
        $result = $queryReponse->get_result()->fetch_assoc();
        mysqli_stmt_close($queryReponse);

        var_dump($result);
        if ($result[0]) {
            return 3;
        }


        //sinon on as pas réussie a reconnaître le type de reponse
        throw new Exception("Unrecognized response type (slider, champs libre, choix multiple text ou image)");
    }
}