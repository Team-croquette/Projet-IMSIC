<?php

class QuestionModel extends ModelCore{

    public function getAllQuestion():array
    {
        $users = [];
        $dbLink = $this->connectBd();
        $query = $dbLink->prepare('SELECT `date`, `identifiant` FROM COMPTES');
        $query->execute();
        $result = $query->get_result();

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    public function removeQuestion(int $id):bool
    {
        $dbLink = $this->connectBd();
        $query = $dbLink->prepare('DELETE FROM COMPTES WHERE `id`=?');
        $query->bind_param('i',$id);
        $query->execute();

        return true;
    }

    public function addQuestion(QuestionTypeEnum $type, string $libelle, string $img, int $slider, array $reponses):bool
    {      
        $dbLink = $this->connectBd();
        $query = $dbLink->prepare('INSERT INTO QUESTION (`libelle`,`img`,`slider`) VALUES (?,?, ?)');
        $query->bind_param('sbi',$libelle,$null,$slider);
        $query->send_long_data(1, $img);

        return $query->execute();
    }

}