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


        $this->renderTemplate($this->getTemplateVariables());
        return true;
    }


    private function getTemplateVariables():array
    {
        $header = SITE_PATH . '/templates/header.php';
        $footer = SITE_PATH . '/templates/footer.php';
        return [
            'header' => $header,
            'footer' => $footer,
            'resultSecuIp' => $_SESSION['VerifIp'],
        ];
    }
}