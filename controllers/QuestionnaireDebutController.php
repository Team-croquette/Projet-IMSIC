<?php

class QuestionnaireDebutController extends ControllerCore
{
    protected string $name;
    private array $errors = [];

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        if(key_exists('submit', $_POST)){
            $this->proccessForm();
        }
        $this->renderTemplate($this->getTemplateVariables());
        return true;
    }

    private function getForm():string
    {
        $formBuilder = new FormBuilder();
        $formBuilder
            ->add('checkbox','En cliquant ici, j\'accepte les conditions générales d\'utilisation : ', InputTypeEnum::CHECKBOX,true)
            ->add('submit','', InputTypeEnum::SUBMIT,true,'Valider');

        $formBuilder->setAction('../questionnaireDebut/index.php');

        return $formBuilder->renderForm();
    }

    private function getTemplateVariables():array
    {
        $form = $this->getForm();
        return [
            'form' => $form,
            'errors' => $this->errors,
        ];
    }

    private function proccessForm(){

        try {
            if (!(isset($_POST['checkbox']) && $_POST['checkbox'] == 'on')) {
                var_dump($_POST['checkbox']);
                header('Location: ../questionnaireDebut/index.php');
            }

            $_SESSION['conditions-generales'] = true;
            header('Location: ../questionnaire/index.php');
        } catch (\Throwable $th) {
            $this->errors[] = $th->getMessage();
        }
    }
}