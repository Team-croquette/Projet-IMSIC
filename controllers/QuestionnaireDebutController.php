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

        $formBuilder->setAction('../questionnaire/index.php');

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
            if (!(isset($_POST['login']) && isset($_POST['password']) && $this->accountExist($_POST['login'],$_POST['password']))) {
                throw new Exception("L'identifiant ou le mot de passe est incorrect. Veuillez réessayer.", 1);
            }

            $_SESSION['token'] = $this->getToken($_POST['login']);
            $_SESSION['login'] = $_POST['login'];

            header('Location: ../index.php');
            die;
        } catch (\Throwable $th) {
            $this->errors[] = $th->getMessage();
        }
    }
}