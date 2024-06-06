<?php

class QuestionnaireFinController extends ControllerCore
{
    protected string $name;

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        $this->renderTemplate();
        return true;
    }
}