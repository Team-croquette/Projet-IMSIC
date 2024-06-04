<?php

class QuestionnaireController extends ControllerCore
{
    protected $info;

    public function getInfo()
    {
        return $this->info;
    }

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        $questMod = new QuestionnaireModel();
        $listIdQuest = $questMod->getAllQuestionsID();
        $idQuestion = $listIdQuest[$_SESSION['currentQuestion']];

        $question = $this->traitementQuestion($questMod->getQuestion($idQuestion));
        $reponses = $this->traitementReponses($questMod->getRepFromQuest($idQuestion));

        $this->renderTemplate($this->getTemplateVariables($question, $reponses));
        return true;
    }


    private function getTemplateVariables($question, $reponses):array
    {
        $header = SITE_PATH . '/templates/header.php';
        $footer = SITE_PATH . '/templates/footer.php';
        return [
            'header' => $header,
            'footer' => $footer,
            'resultSecuIp' => $_SESSION['VerifIp'],
            'question' => $question,
            'reponses' => $reponses,
        ];
    }

    private function traitementQuestion($retourBD){
        $htmlQuestion = "
            <div class='imgsQuestion'>
            ";

        //ajout de la première image si set
        if ($retourBD['IMG'] != null){
            //$img = $this->getImgFromBlob($retourBD['IMG'], 'imgQuest1');

            $htmlQuestion .= '
            <img id="img2Question" src= "data:image/*;base64,'.$retourBD['IMG'].'"
                alt="' . $retourBD['IMG_DESC'].'"/>';
        }

        //ajout de la deuxième image si set
        if ($retourBD['IMG_SECOND'] != null){
            //$img = $this->getImgFromBlob($retourBD['IMG_SECOND'],'imgQuest2');

            $htmlQuestion .= '
            <img id="img2Question" src= "data:image/*;base64,'.$retourBD['IMG_SECOND'].'"
                alt="' . $retourBD['IMG_SECOND_DESC'].'"/>';
        }
        $numQuestion = $_SESSION['currentQuestion']+1;
        //var_dump($numQuestion);
        $htmlQuestion .= "   
            </div>
            <div class='right-panel'>
                <div class='question'>
                    <div id='numQuestion'>
                        <p>Question {$numQuestion}</p>
                    </div>
                    <div id='questionLib'>
                        <p>{$retourBD['LIBELLE']}</p>
                    </div>
                </div>
        "; // </div> de right-panel a fermé après le traitement des reponses

        return $htmlQuestion;
    }

    private function traitementReponses($retourBD){
        $htmlReponses = '<div class="reponses">';
        switch ($retourBD['case']) {
            case 0:
                $htmlReponses .= '
                <form action="../questionnaire/" method="post">
                    <div class="slider-container">
                        <label for="slider">Sélectionnez une valeur :</label>
                        <input type="range" id="slider" name="sliderValue" min="0" max="' . $retourBD['maxSlider'] . '" value="' . round($retourBD['maxSlider']/2) . '" class="slider">
                        <span id="sliderValeur">' . round($retourBD['maxSlider']/2) . '</span>
                    </div>
                    <input type="submit" value="Valider">
                </form>

                <script>
                    // Script pour afficher la valeur actuelle du slider
                    const slider = document.getElementById("slider");
                    const sliderValeur = document.getElementById("sliderValeur");

                    slider.oninput = function() {
                        sliderValeur.innerText = this.value;
                    }
                </script>';
                break;
            case 1:
                $htmlReponses .= '
                    <form action="../questionnaire/" method="post">
                        <label for="champRep">Entrez une votre reponse :</label>
                        <input type="text" id="champRep" name="champRep" required>
                        <input type="submit" value="Valider">
                    </form>';
                break;
            case 2:
                $htmlReponses .= '
                    <form action="../questionnaire/" method="post">
                        <label> Choix possibles :</label>';

                $i = 0;
                foreach ($retourBD['contenuReps'] as $row) {
                    //var_dump($row);
                    $htmlReponses .= '
                    <div class="reponse">
                        <input type="checkbox" id="rep' . $i . '" name="selectedOptions[' . $row['ID'] . ']" value="">
                        <label for="rep' . $i . '">' . $row['CONTENU'] . '</label>
                    </div>';
                    ++$i;
                }

                $htmlReponses .= '    
                    <input type="submit" value="Valider">
                </form>';
                break;
            case 3:
                $htmlReponses .= '
                    <form action="../questionnaire/" method="post">
                        <label>Choix possibles :</label>';

                $i = 0;
                foreach ($retourBD['imgReps'] as $row) {
                    $htmlReponses .= '
                    <div class="reponse">
                        <input type="checkbox" id="rep' . $i . '" name="selectedOptions[' . $row['ID'] . ']" value="">
                        <label for="rep' . $i . '">' .
                        '<img id="img' . $i . 'Rep" src= "data:image/*;base64,'.$row['IMG'].'"
                            alt="' . $row['IMG_LABEL'].'"/>' .
                        '</label>
                    </div>';
                    ++$i;
                }

                $htmlReponses .= '    
                    <input type="submit" value="Valider">
                </form>';
                break;
        }

        $htmlReponses .= '
                </div> <!-- fermeture div reponses -->
            </div> <!-- fermeture div right-panel -->
        ';
        return $htmlReponses;
    }

    private function getImgFromBlob($imgBlob, $imgLieu){
        //methode Luke
        //$nomFichier = 'imgtmp' . $img . $_SESSION['idClient'];
        //file_put_contents();
        //Je tente ça :
        return '<img id="' . $imgLieu . '" src="data:image/jpeg;base64,'.base64_encode($imgBlob).'"/>';
    }

}