<?php

class QuestionModel extends ModelCore{

    const QUESTION_FIELDS = ['libelle', 'image', 'imageDescription', 'slider'];

    public function getAllQuestion():array
    {
        $questions = [];
        $dbLink = $this->connectBd();
        $query = $dbLink->prepare('SELECT `id`, `libelle` FROM QUESTION');
        if(!$query->execute()){
            $query->close();
            throw $query->error;
        }

        $result = $query->get_result();

        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }

        return $questions;
    }

    public function removeQuestion(int $id):bool
    {

        $dbLink = $this->connectBd();
        $query = $dbLink->prepare('SELECT * FROM REPONSE WHERE `id_question`=?');
        $query->bind_param('i',$id);

        if(!$query->execute()){
            $query->close();
            throw $query->error;
        }

        $result = $query->get_result();
        if($result->num_rows == 0){
            $query->close();
            
            $query = $dbLink->prepare('DELETE FROM QUESTION WHERE `id`=?');
            $query->bind_param('i',$id);

            if(!$query->execute()){
                $query->close();
                throw $query->error;
            }
            return true;
        }

        $query->close();
        $query = $dbLink->prepare('DELETE r, res, q FROM REPONSE r LEFT JOIN QUESTION q ON r.`id_question`=q.`id` LEFT JOIN RESULTAT res ON r.`id_question`=res.`id_question` WHERE r.`id_question`=?;');
       
        $query->bind_param('i',$id);

        if(!$query->execute()){
            $query->close();
            throw $query->error;
        }

        return true;
    }

    public function addFreeTextQuestion($params):bool
    {        
        $request = 'INSERT INTO QUESTION (`libelle`';
        $bind = 's';
        $values = '?';
        $sqlParams = [$params['libelle']];

        $questionColumn = array_intersect(self::QUESTION_FIELDS, QuestionTypeEnum::FREE_TEXT->getVarForInsert());

        foreach ($questionColumn as $keyAsked) {
            if ($keyAsked === 'libelle') {
                continue;
            }

            list($column, $nextBind, $newValues, $newSqlParams) = $this->processColumn($keyAsked, $params);

            if ($column) {
                $request .= ',`' . $column . '`';
                $bind .= $nextBind;
                $values .= $newValues;
                $sqlParams = array_merge($sqlParams, $newSqlParams);
            }
        }

        $request .= ') VALUES (' . $values . ')';
        return $this->executeInsertQuery($request, $bind, $sqlParams);
    }

    public function addSliderQuestion(array $params):bool
    {  
        $request = 'INSERT INTO QUESTION (`libelle`';
        $bind = 's';
        $values = '?';
        $sqlParams = [$params['libelle']];

        if (!isset($params['slider'])) {
            throw new Exception('Il faut un nombre maximum pour le slider.');
        }

        $questionColumn = array_intersect(self::QUESTION_FIELDS, QuestionTypeEnum::SLIDER->getVarForInsert());

        foreach ($questionColumn as $keyAsked) {
            if ($keyAsked === 'libelle') {
                continue;
            }

            list($column, $nextBind, $newValues, $newSqlParams) = $this->processColumn($keyAsked, $params);

            if ($column) {
                $request .= ',`' . $column . '`';
                $bind .= $nextBind;
                $values .= $newValues;
                $sqlParams = array_merge($sqlParams, $newSqlParams);
            }
        }

        $request .= ') VALUES (' . $values . ')';
        return $this->executeInsertQuery($request, $bind, $sqlParams);
    }

    public function addMultiImageQuestion(array $params):bool
    {   
        $request = 'INSERT INTO QUESTION (`libelle`';
        $bind = 's';
        $values = '?';
        $sqlParams = [$params['libelle']];

        if (!isset($_FILES['imageResp']) || !is_array($_FILES['imageResp']) || count($_FILES['imageResp']) < 1) {
            throw new Exception('Il faut au moins une image pour ce type de question.');
        }

        if (!isset($params['imageRespDesc']) || !is_array($params['imageRespDesc']) || count($params['imageRespDesc']) < 1) {
            throw new Exception('Il faut une description pour chaque image.');
        }

        $questionColumn = array_intersect(self::QUESTION_FIELDS,QuestionTypeEnum::MULTI_IMAGE->getVarForInsert());

        foreach ($questionColumn as $keyAsked) {
            if ($keyAsked === 'libelle') {
                continue;
            }

            list($column, $nextBind, $newValues, $newSqlParams) = $this->processColumn($keyAsked, $params);

            if ($column) {
                $request .= ',`' . $column . '`';
                $bind .= $nextBind;
                $values .= $newValues;
                $sqlParams = array_merge($sqlParams, $newSqlParams);
            }
        }

        $request .= ') VALUES (' . $values . ')';
        $idQuestion = intval($this->executeInsertQuery($request, $bind, $sqlParams));

        foreach ($_FILES['imageResp']['name'] as $key => $image) {
            if (empty($image)) {
                continue;
            }
            $requestResp = 'INSERT INTO REPONSE (`id_question`,`img`,`img_label`) VALUES (?,?,?)';
            $bindResp = 'iss';
            $sqlParamsResp = [$idQuestion, base64_encode(file_get_contents($_FILES['imageResp']['tmp_name'][$key])), $params['imageRespDesc'][$key]];

            $this->executeInsertQuery($requestResp, $bindResp, $sqlParamsResp);
        }

        return true;
    }

    public function addTextChoiceQuestion(array $params):bool
    {   
        if (!isset($params['choiseText']) || !is_array($params['choiseText']) || count($params['choiseText']) < 2){
            throw new Exception('Il faut plusieurs choix pour ce type de question.');
        }
        $request = 'INSERT INTO QUESTION (`libelle`';
        $bind = 's';
        $values = '?';
        $sqlParams = [$params['libelle']];

        $questionColumn = array_intersect(self::QUESTION_FIELDS,QuestionTypeEnum::TEXT_CHOICE->getVarForInsert());

        foreach ($questionColumn as $keyAsked) {
            if ($keyAsked === 'libelle') {
                continue;
            }

            list($column, $nextBind, $newValues, $newSqlParams) = $this->processColumn($keyAsked, $params);

            if ($column) {
                $request .= ',`' . $column . '`';
                $bind .= $nextBind;
                $values .= $newValues;
                $sqlParams = array_merge($sqlParams, $newSqlParams);
            }
        }

        $request .= ') VALUES (' . $values . ')';
        $idQuestion = intval($this->executeInsertQuery($request, $bind, $sqlParams));

        foreach ($params['choiseText'] as $key => $content) {
            if ($content == '') {
                continue;
            }
            $requestResp = 'INSERT INTO REPONSE (`id_question`,`contenu`) VALUES (?,?)';
            $bindResp = 'is';
            $sqlParamsResp = [$idQuestion, $content];

            $this->executeInsertQuery($requestResp, $bindResp, $sqlParamsResp);
        }

        return true;
    }

}