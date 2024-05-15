<?php 

class LoginAdminController extends AdminControllerCore{
    protected string $name;

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        $this->toto();
        $this->renderTemplate();
        return true;
    }

    private function toto(){
        return 'toto';
    }
}